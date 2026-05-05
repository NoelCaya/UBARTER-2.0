@extends('layouts.master')

@section('title', 'Messages - UBarter 2.0')

@section('content')
<style>
    :root {
        --ub-maroon: #7b0f10;
        --ub-gold: #f5c518;
    }
</style>

<div class="flex h-screen bg-gray-50 pt-16">
    <!-- Chat Sidebar -->
    <div class="w-80 bg-white border-r border-gray-200 flex flex-col">
        <!-- Search -->
        <div class="p-4 border-b border-gray-200">
            <input type="text" placeholder="Search conversations..."
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10] text-sm">
        </div>

        <!-- Conversations List -->
        <div class="flex-1 overflow-y-auto">
            <!-- Mark all as read -->
            <div class="px-4 py-2 flex justify-between items-center border-b border-gray-100">
                <p class="text-xs font-semibold text-[#7b0f10]">CONVERSATIONS</p>
                <button class="text-xs text-[#7b0f10] hover:text-[#5a0a0b] font-medium">Mark all read</button>
            </div>

            <!-- Conversation Items -->
            @foreach($conversations as $conversation)
                <a href="{{ route('chat.show', $conversation['user_id']) }}" 
                   class="block px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition {{ $activeConversation && $activeConversation['id'] == $conversation['id'] ? 'bg-[#7b0f10]/5 border-l-4 border-[#7b0f10]' : '' }}">
                    <div class="flex items-center space-x-3">
                        <div class="relative flex-shrink-0">
                            <img src="https://ui-avatars.com/api/?name={{ $conversation['avatar'] }}&background=7b0f10&color=fff" 
                                 alt="{{ $conversation['name'] }}" class="w-12 h-12 rounded-full">
                            @if($conversation['online'])
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                            @else
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-gray-400 rounded-full border-2 border-white"></span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <p class="font-semibold text-gray-900 text-sm">{{ $conversation['name'] }}</p>
                                <span class="text-xs text-gray-600">{{ $conversation['last_message_time'] }}</span>
                            </div>
                            <p class="text-sm text-gray-600 truncate">{{ $conversation['last_message'] }}</p>
                        </div>
                        @if($conversation['unread'] > 0)
                            <div class="w-2.5 h-2.5 bg-[#7b0f10] rounded-full flex-shrink-0"></div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Chat Area -->
    <div class="flex-1 flex flex-col">
        @if($activeConversation)
            <!-- Chat Header -->
            <div class="bg-white border-b border-gray-200 p-4 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <img src="https://ui-avatars.com/api/?name={{ $activeConversation['avatar'] }}&background=7b0f10&color=fff" 
                         alt="{{ $activeConversation['name'] }}" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $activeConversation['name'] }}</p>
                        <p class="text-xs text-gray-600">
                            @if($activeConversation['online'])
                                <span class="text-green-600">• Active now</span>
                            @else
                                <span class="text-gray-600">Offline</span>
                            @endif
                            • {{ $activeConversation['department'] }} Dept
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-600 hover:text-[#7b0f10] text-lg transition">
                        <i class="fas fa-phone"></i>
                    </button>
                    <button class="text-gray-600 hover:text-[#7b0f10] text-lg transition">
                        <i class="fas fa-video"></i>
                    </button>
                    <button class="text-gray-600 hover:text-[#7b0f10] text-lg transition">
                        <i class="fas fa-info-circle"></i>
                    </button>
                </div>
            </div>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50" id="messagesContainer">
                @foreach($messages as $message)
                    @if($message['sender_id'] == $currentUser->id)
                        <!-- Sender Message -->
                        <div class="flex justify-end">
                            <div class="max-w-xs">
                                <div class="bg-[#7b0f10] text-white rounded-3xl rounded-tr-none px-4 py-3">
                                    <p class="text-sm">{{ $message['content'] }}</p>
                                </div>
                                <p class="text-xs text-gray-600 mt-1 text-right">{{ $message['timestamp'] }}</p>
                            </div>
                        </div>
                    @else
                        <!-- Receiver Message -->
                        <div class="flex justify-start">
                            <div class="max-w-xs">
                                <div class="bg-white border border-gray-300 rounded-3xl rounded-tl-none px-4 py-3">
                                    <p class="text-sm text-gray-900">{{ $message['content'] }}</p>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">{{ $message['timestamp'] }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Message Input -->
            <div class="bg-white border-t border-gray-200 p-4">
                <form id="messageForm" class="space-y-3">
                    @csrf
                    <div class="flex items-center space-x-4">
                        <button type="button" class="text-gray-600 hover:text-[#7b0f10] text-lg transition">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <input type="text" id="messageInput" placeholder="Type your message..."
                               class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]">
                        <button type="submit" class="bg-[#7b0f10] hover:bg-[#5a0a0b] text-white px-4 py-3 rounded-lg transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-600">
                        💡 <strong>Tip:</strong> Agree on trade terms before meeting. Always be respectful and honest about item condition.
                    </p>
                </form>
            </div>
        @else
            <!-- No Conversation Selected -->
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-comments text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg">Select a conversation to start chatting</p>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    // Handle message sending
    document.getElementById('messageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const messageInput = document.getElementById('messageInput');
        const message = messageInput.value.trim();
        
        if (!message) return;
        
        // Add message to chat immediately (optimistic update)
        const messagesContainer = document.getElementById('messagesContainer');
        const messageHTML = `
            <div class="flex justify-end">
                <div class="max-w-xs">
                    <div class="bg-[#7b0f10] text-white rounded-3xl rounded-tr-none px-4 py-3">
                        <p class="text-sm">${message}</p>
                    </div>
                    <p class="text-xs text-gray-600 mt-1 text-right">now</p>
                </div>
            </div>
        `;
        
        messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        messageInput.value = '';
        
        // Send to server
        fetch('{{ route("chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                message: message,
                conversation_id: {{ $activeConversation['id'] ?? 'null' }}
            })
        }).then(response => response.json())
          .then(data => {
              console.log('Message sent:', data);
          })
          .catch(error => console.error('Error:', error));
    });
</script>
@endsection
