<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display chat interface with all conversations
     */
    public function index()
    {
        $currentUser = auth()->user();
        
        // Sample conversations - In a real app, this would be from database
        $conversations = [
            [
                'id' => 1,
                'user_id' => 2,
                'name' => 'Sarah Lee',
                'department' => 'ECE',
                'avatar' => 'Sarah+Lee',
                'last_message' => 'Sounds good! When can we meet?',
                'last_message_time' => '2m',
                'unread' => 1,
                'online' => true
            ],
            [
                'id' => 2,
                'user_id' => 3,
                'name' => 'Michael Brown',
                'department' => 'ME',
                'avatar' => 'Michael+Brown',
                'last_message' => 'Is this book still available?',
                'last_message_time' => '1h',
                'unread' => 0,
                'online' => false
            ],
            [
                'id' => 3,
                'user_id' => 4,
                'name' => 'Emily Johnson',
                'department' => 'CAS',
                'avatar' => 'Emily+Johnson',
                'last_message' => 'Thanks for the uniform set!',
                'last_message_time' => 'Yesterday',
                'unread' => 0,
                'online' => false
            ],
            [
                'id' => 4,
                'user_id' => 5,
                'name' => 'David Park',
                'department' => 'ICT',
                'avatar' => 'David+Park',
                'last_message' => 'What items are you looking for?',
                'last_message_time' => '2 days ago',
                'unread' => 0,
                'online' => false
            ],
            [
                'id' => 5,
                'user_id' => 6,
                'name' => 'Maria Santos',
                'department' => 'BSN',
                'avatar' => 'Maria+Santos',
                'last_message' => 'Let\'s finalize the trade details',
                'last_message_time' => '3 days ago',
                'unread' => 0,
                'online' => true
            ],
        ];

        // Get active conversation (default to first one)
        $activeConversation = $conversations[0] ?? null;
        $messages = $this->getConversationMessages($activeConversation);

        return view('chat.index', [
            'conversations' => $conversations,
            'activeConversation' => $activeConversation,
            'messages' => $messages,
            'currentUser' => $currentUser
        ]);
    }

    /**
     * Show specific conversation with a user
     */
    public function show(Request $request, $userId)
    {
        $currentUser = auth()->user();
        
        // Get all conversations
        $conversations = $this->getConversations();
        
        // Find the specific conversation
        $activeConversation = collect($conversations)
            ->firstWhere('user_id', $userId);
        
        if (!$activeConversation) {
            abort(404, 'Conversation not found');
        }

        $messages = $this->getConversationMessages($activeConversation);

        return view('chat.index', [
            'conversations' => $conversations,
            'activeConversation' => $activeConversation,
            'messages' => $messages,
            'currentUser' => $currentUser
        ]);
    }

    /**
     * Send a message in the chat
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'conversation_id' => 'required|integer'
        ]);

        $currentUser = auth()->user();

        // In a real app, save message to database
        // Message::create([
        //     'conversation_id' => $validated['conversation_id'],
        //     'user_id' => $currentUser->id,
        //     'content' => $validated['message'],
        //     'sent_at' => now()
        // ]);

        // For now, return success response
        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => [
                'sender_id' => $currentUser->id,
                'content' => $validated['message'],
                'timestamp' => now()->format('g:i A')
            ]
        ]);
    }

    /**
     * Get list of conversations
     */
    private function getConversations()
    {
        return [
            [
                'id' => 1,
                'user_id' => 2,
                'name' => 'Sarah Lee',
                'department' => 'ECE',
                'avatar' => 'Sarah+Lee',
                'last_message' => 'Sounds good! When can we meet?',
                'last_message_time' => '2m',
                'unread' => 1,
                'online' => true
            ],
            [
                'id' => 2,
                'user_id' => 3,
                'name' => 'Michael Brown',
                'department' => 'ME',
                'avatar' => 'Michael+Brown',
                'last_message' => 'Is this book still available?',
                'last_message_time' => '1h',
                'unread' => 0,
                'online' => false
            ],
            [
                'id' => 3,
                'user_id' => 4,
                'name' => 'Emily Johnson',
                'department' => 'CAS',
                'avatar' => 'Emily+Johnson',
                'last_message' => 'Thanks for the uniform set!',
                'last_message_time' => 'Yesterday',
                'unread' => 0,
                'online' => false
            ],
            [
                'id' => 4,
                'user_id' => 5,
                'name' => 'David Park',
                'department' => 'ICT',
                'avatar' => 'David+Park',
                'last_message' => 'What items are you looking for?',
                'last_message_time' => '2 days ago',
                'unread' => 0,
                'online' => false
            ],
            [
                'id' => 5,
                'user_id' => 6,
                'name' => 'Maria Santos',
                'department' => 'BSN',
                'avatar' => 'Maria+Santos',
                'last_message' => 'Let\'s finalize the trade details',
                'last_message_time' => '3 days ago',
                'unread' => 0,
                'online' => true
            ],
        ];
    }

    /**
     * Get messages for a specific conversation
     */
    private function getConversationMessages($conversation)
    {
        if (!$conversation) {
            return [];
        }

        // Sample messages - In a real app, fetch from database
        $sampleMessages = [
            [
                'id' => 1,
                'sender_id' => 2,
                'sender_name' => 'Sarah Lee',
                'content' => 'Hi! I saw you posted an Arduino Kit. Are you interested in trading?',
                'timestamp' => '10:30 AM',
                'avatar' => 'Sarah+Lee'
            ],
            [
                'id' => 2,
                'sender_id' => auth()->id(),
                'sender_name' => auth()->user()->name,
                'content' => 'Yes! I\'m looking for a Biology textbook. Do you have one?',
                'timestamp' => '10:35 AM',
                'avatar' => auth()->user()->name
            ],
            [
                'id' => 3,
                'sender_id' => 2,
                'sender_name' => 'Sarah Lee',
                'content' => 'Perfect! I have an almost new Biology book for 3rd year. Can we trade?',
                'timestamp' => '10:38 AM',
                'avatar' => 'Sarah+Lee'
            ],
            [
                'id' => 4,
                'sender_id' => auth()->id(),
                'sender_name' => auth()->user()->name,
                'content' => 'That sounds great! When can we meet to finalize the trade?',
                'timestamp' => '10:45 AM',
                'avatar' => auth()->user()->name
            ],
            [
                'id' => 5,
                'sender_id' => 2,
                'sender_name' => 'Sarah Lee',
                'content' => 'Sounds good! When can we meet?',
                'timestamp' => '10:50 AM',
                'avatar' => 'Sarah+Lee'
            ]
        ];

        return $sampleMessages;
    }
}

