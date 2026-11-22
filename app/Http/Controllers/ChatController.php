<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display chat interface with all conversations for the current user
     */
    public function index()
    {
        $currentUser = Auth::user();

        $conversations = Conversation::with(['userOne', 'userTwo', 'lastMessage'])
            ->where('user_one_id', $currentUser->id)
            ->orWhere('user_two_id', $currentUser->id)
            ->orderByDesc('last_message_at')
            ->get();

        return view('chat.index', [
            'conversations'     => $conversations,
            'activeConversation' => null,
            'messages'          => [],
            'currentUser'       => $currentUser,
        ]);
    }

    /**
     * Show or start a conversation with a specific user
     */
    public function show(Request $request, int $userId)
    {
        $currentUser = Auth::user();

        // Prevent chatting with yourself
        if ($userId === $currentUser->id) {
            return redirect()->route('chat.index');
        }

        $otherUser = User::findOrFail($userId);

        // Find or create the conversation
        $activeConversation = Conversation::findOrCreateBetween($currentUser->id, $userId);
        $activeConversation->load(['userOne', 'userTwo']);

        // Mark messages from the other user as read
        $activeConversation->messages()
            ->where('sender_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Load messages
        $messages = $activeConversation->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get()
            ->each(fn($m) => $m->timestamp_pst = $m->created_at->timezone('Asia/Manila')->format('g:i A'));

        // All conversations for sidebar
        $conversations = Conversation::with(['userOne', 'userTwo', 'lastMessage'])
            ->where('user_one_id', $currentUser->id)
            ->orWhere('user_two_id', $currentUser->id)
            ->orderByDesc('last_message_at')
            ->get();

        return view('chat.index', [
            'conversations'      => $conversations,
            'activeConversation' => $activeConversation,
            'otherUser'          => $otherUser,
            'messages'           => $messages,
            'currentUser'        => $currentUser,
        ]);
    }

    /**
     * Send a message
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'body'            => 'required|string|max:2000',
            'conversation_id' => 'required|integer|exists:conversations,id',
        ]);

        $currentUser = Auth::user();

        // Suspended users cannot message
        if ($currentUser->isSuspended()) {
            return response()->json(['error' => 'Your account is suspended. You cannot send messages.'], 403);
        }

        $conversation = Conversation::findOrFail($validated['conversation_id']);

        if ($conversation->user_one_id !== $currentUser->id &&
            $conversation->user_two_id !== $currentUser->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $currentUser->id,
            'body'            => $validated['body'],
        ]);

        $conversation->update(['last_message_at' => now()]);

        // Notify the other participant
        $otherId = $conversation->user_one_id === $currentUser->id
            ? $conversation->user_two_id
            : $conversation->user_one_id;

        \App\Models\Notification::notify(
            $otherId,
            'message',
            'New message from ' . $currentUser->name,
            \Str::limit($validated['body'], 60),
            route('chat.show', $currentUser->id),
            $currentUser->id
        );

        return response()->json([
            'success'   => true,
            'message'   => [
                'id'         => $message->id,
                'body'       => $message->body,
                'sender_id'  => $message->sender_id,
                'timestamp'  => $message->created_at->timezone('Asia/Manila')->format('g:i A'),
                'created_at' => $message->created_at->toISOString(),
            ],
        ]);
    }

    /**
     * Poll for new messages (called by frontend every few seconds)
     */
    public function poll(Request $request)
    {
        $validated = $request->validate([
            'conversation_id' => 'required|integer|exists:conversations,id',
            'last_message_id' => 'required|integer',
        ]);

        $currentUser = Auth::user();
        $conversation = Conversation::findOrFail($validated['conversation_id']);

        if ($conversation->user_one_id !== $currentUser->id &&
            $conversation->user_two_id !== $currentUser->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $newMessages = $conversation->messages()
            ->with('sender')
            ->where('id', '>', $validated['last_message_id'])
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'id'        => $m->id,
                'body'      => $m->body,
                'sender_id' => $m->sender_id,
                'timestamp' => $m->created_at->timezone('Asia/Manila')->format('g:i A'),
                'created_at'=> $m->created_at->toISOString(),
            ]);

        // Mark new messages from the other user as read
        $conversation->messages()
            ->where('id', '>', $validated['last_message_id'])
            ->where('sender_id', '!=', $currentUser->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['messages' => $newMessages]);
    }
}
