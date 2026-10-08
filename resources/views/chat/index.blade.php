@extends('layouts.master')

@section('title', 'Messages - UBarter 2.0')

@section('content')
{{-- ╔══════════════════════════════════════════════════════════╗
     ║  CHAT INTERFACE — Full-height split layout              ║
     ╚══════════════════════════════════════════════════════════╝ --}}
<style>
  .chat-container { 
    display:flex; 
    height:calc(100vh - 4rem); 
    background:#fff; 
    border-radius:0 0 16px 16px; 
    overflow:hidden; 
    box-shadow:0 2px 12px rgba(0,0,0,0.08); 
  }
  
  /* ═══ LEFT SIDEBAR ═══ */
  .chat-sidebar { 
    width:340px; flex-shrink:0; 
    border-right:1px solid #f3f4f6; 
    display:flex; flex-direction:column; 
    background:#fafbfc; 
  }
  .chat-header { 
    padding:20px; border-bottom:1px solid #f3f4f6; 
    background:#fff; 
  }
  .chat-header h1 { 
    font-size:1.3rem; font-weight:800; color:#1a1209; 
    margin:0 0 4px; 
  }
  .chat-header p { 
    font-size:0.8rem; color:#9ca3af; margin:0; 
  }
  .search-box { 
    padding:16px 20px; border-bottom:1px solid #f3f4f6; 
    background:#fff; 
  }
  .search-input { 
    width:100%; padding:10px 14px 10px 38px; 
    background:#f8f9fa; border:1px solid #e9ecef; 
    border-radius:12px; font-size:0.85rem; 
    outline:none; transition:all 0.15s; 
  }
  .search-input:focus { 
    background:#fff; border-color:#7b0f10; 
    box-shadow:0 0 0 3px rgba(123,15,16,0.08); 
  }
  .search-icon { 
    position:absolute; left:34px; top:50%; 
    transform:translateY(-50%); color:#9ca3af; 
    font-size:0.8rem; pointer-events:none; 
  }
  .conv-list { flex:1; overflow-y:auto; }
  .conv-header { 
    padding:12px 20px; font-size:0.65rem; 
    font-weight:800; color:#7b0f10; 
    text-transform:uppercase; letter-spacing:0.1em; 
    background:#fff; border-bottom:1px solid #f3f4f6; 
    display:flex; justify-content:space-between; 
  }
  .conv-item { 
    display:flex; align-items:center; gap:12px; 
    padding:14px 20px; border-bottom:1px solid #f9fafb; 
    cursor:pointer; transition:background 0.15s; 
    text-decoration:none; color:inherit; 
  }
  .conv-item:hover { background:#f8f9fa; text-decoration:none; color:inherit; }
  .conv-item.active { 
    background:#fff8f8; border-right:3px solid #7b0f10; 
    border-bottom-color:#f3f4f6; 
  }
  .conv-avatar { position:relative; flex-shrink:0; }
  .conv-avatar img { 
    width:44px; height:44px; border-radius:50%; 
    border:2px solid #fff; 
  }
  .status-dot { 
    position:absolute; bottom:2px; right:2px; 
    width:12px; height:12px; border-radius:50%; 
    border:2px solid #fff; 
  }
  .status-online { background:#10b981; }
  .status-offline { background:#9ca3af; }
  .conv-info { flex:1; min-width:0; }
  .conv-name { 
    font-size:0.9rem; font-weight:700; color:#1a1209; 
    margin:0 0 2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; 
  }
  .conv-preview { 
    font-size:0.8rem; color:#6b7280; 
    margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; 
  }
  .conv-meta { 
    display:flex; flex-direction:column; align-items:flex-end; 
    gap:4px; flex-shrink:0; 
  }
  .conv-time { font-size:0.7rem; color:#9ca3af; }
  .unread-badge { 
    background:#ef4444; color:#fff; 
    font-size:0.65rem; font-weight:800; 
    padding:2px 6px; border-radius:999px; 
    line-height:1.2; 
  }
  
  /* ═══ MAIN CHAT AREA ═══ */
  .chat-main { 
    flex:1; display:flex; flex-direction:column; 
    min-width:0; 
  }
  .chat-top-bar { 
    padding:16px 20px; background:#fff; 
    border-bottom:1px solid #f3f4f6; 
    display:flex; align-items:center; justify-content:space-between; 
  }
  .chat-user-info { display:flex; align-items:center; gap:12px; }
  .chat-user-avatar { 
    width:42px; height:42px; border-radius:50%; 
    border:2px solid #f5c518; flex-shrink:0; 
  }
  .chat-user-name { 
    font-size:1rem; font-weight:700; color:#1a1209; 
    margin:0 0 2px; 
  }
  .chat-user-status { 
    font-size:0.75rem; color:#6b7280; margin:0; 
  }
  .status-online-text { color:#10b981; }
  .chat-actions { display:flex; align-items:center; gap:12px; }
  .chat-action-btn { 
    width:36px; height:36px; border-radius:50%; 
    background:#f8f9fa; border:none; 
    color:#6b7280; cursor:pointer; 
    display:flex; align-items:center; justify-content:center; 
    transition:all 0.15s; font-size:0.9rem; 
  }
  .chat-action-btn:hover { 
    background:#7b0f10; color:#fff; 
    transform:scale(1.05); 
  }
  
  /* Messages area */
  .messages-area { 
    flex:1; overflow-y:auto; padding:20px; 
    background:#f8f9fa; 
    background-image:radial-gradient(circle at 20% 50%, rgba(123,15,16,0.02) 0%, transparent 50%), 
                     radial-gradient(circle at 80% 20%, rgba(245,197,24,0.03) 0%, transparent 50%); 
  }
  .message-group { 
    display:flex; margin-bottom:16px; 
    align-items:flex-end; 
  }
  .message-group.sent { justify-content:flex-end; }
  .message-bubble { 
    max-width:75%; padding:12px 16px; 
    border-radius:18px; font-size:0.85rem; 
    line-height:1.4; position:relative; 
  }
  .message-group.received .message-bubble { 
    background:#fff; color:#1a1209; 
    border-bottom-left-radius:6px; 
    box-shadow:0 1px 2px rgba(0,0,0,0.1); 
  }
  .message-group.sent .message-bubble { 
    background:#7b0f10; color:#fff; 
    border-bottom-right-radius:6px; 
  }
  .message-time { 
    font-size:0.7rem; opacity:0.7; 
    margin-top:4px; text-align:center; 
  }
  .message-group.sent .message-time { text-align:right; }
  
  /* Input area */
  .message-input-area { 
    padding:16px 20px; background:#fff; 
    border-top:1px solid #f3f4f6; 
  }
  .input-wrapper { 
    display:flex; align-items:center; gap:12px; 
  }
  .input-controls { 
    display:flex; align-items:center; gap:8px; 
  }
  .input-control-btn { 
    width:36px; height:36px; border-radius:50%; 
    background:#f8f9fa; border:none; 
    color:#6b7280; cursor:pointer; 
    display:flex; align-items:center; justify-content:center; 
    transition:all 0.15s; font-size:0.85rem; 
  }
  .input-control-btn:hover { 
    background:#7b0f10; color:#fff; 
  }
  .message-input { 
    flex:1; padding:12px 16px; 
    background:#f8f9fa; border:1px solid #e9ecef; 
    border-radius:20px; font-size:0.85rem; 
    outline:none; transition:all 0.15s; 
    resize:none; min-height:44px; max-height:120px; 
  }
  .message-input:focus { 
    background:#fff; border-color:#7b0f10; 
    box-shadow:0 0 0 3px rgba(123,15,16,0.08); 
  }
  .send-btn { 
    width:44px; height:44px; border-radius:50%; 
    background:#7b0f10; color:#fff; border:none; 
    cursor:pointer; display:flex; align-items:center; justify-content:center; 
    transition:all 0.15s; font-size:0.9rem; 
  }
  .send-btn:hover { 
    background:#5a0a0b; transform:scale(1.05); 
  }
  .input-tip { 
    padding:8px 0; font-size:0.7rem; color:#9ca3af; 
    display:flex; align-items:center; gap:6px; 
  }
  
  /* ═══ NO CONVERSATION SELECTED ═══ */
  .no-chat-selected { 
    flex:1; display:flex; align-items:center; justify-content:center; 
    background:#f8f9fa; 
  }
  .no-chat-content { text-align:center; max-width:320px; }
  .no-chat-icon { 
    font-size:4rem; color:#e5e7eb; margin-bottom:16px; 
  }
  .no-chat-title { 
    font-size:1.2rem; font-weight:700; color:#6b7280; 
    margin:0 0 8px; 
  }
  .no-chat-desc { 
    font-size:0.9rem; color:#9ca3af; margin:0; 
    line-height:1.5; 
  }
  
  /* ═══ RESPONSIVE ═══ */
  @media (max-width:768px) {
    .chat-sidebar { width:100%; position:absolute; z-index:10; background:#fff; }
    .chat-main { display:none; }
    .chat-sidebar.mobile-hidden { display:none; }
    .chat-main.mobile-show { display:flex; }
  }
</style>

<div class="chat-container">

  {{-- ═══ LEFT: CONVERSATIONS SIDEBAR ═══ --}}
  <div class="chat-sidebar" id="chatSidebar">
    {{-- Header --}}
    <div class="chat-header">
      <h1>Messages</h1>
      <p>{{ is_array($conversations) ? count($conversations) : $conversations->count() }} conversations</p>
    </div>

    {{-- Search --}}
    <div class="search-box" style="position:relative;">
      <i class="fas fa-search search-icon"></i>
      <input type="text" placeholder="Search conversations..." class="search-input" 
             oninput="filterConversations(this.value)">
    </div>

    {{-- Conversations list --}}
    <div class="conv-list">
      <div class="conv-header">
        <span>Conversations</span>
        <button class="text-xs text-[#7b0f10] hover:text-[#5a0a0b] font-semibold cursor-pointer bg-none border-none">Mark all read</button>
      </div>

      @forelse($conversations as $conversation)
        <a href="{{ route('chat.show', $conversation['user_id']) }}" 
           class="conv-item {{ $activeConversation && $activeConversation['id'] == $conversation['id'] ? 'active' : '' }}"
           data-name="{{ strtolower($conversation['name']) }}">
          <div class="conv-avatar">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($conversation['avatar']) }}&background=7b0f10&color=fff&bold=true" 
                 alt="{{ $conversation['name'] }}">
            <span class="status-dot {{ $conversation['online'] ? 'status-online' : 'status-offline' }}"></span>
          </div>
          <div class="conv-info">
            <p class="conv-name">{{ $conversation['name'] }}</p>
            <p class="conv-preview">{{ $conversation['last_message'] }}</p>
          </div>
          <div class="conv-meta">
            <span class="conv-time">{{ $conversation['last_message_time'] }}</span>
            @if($conversation['unread'] > 0)
              <span class="unread-badge">{{ $conversation['unread'] }}</span>
            @endif
          </div>
        </a>
      @empty
        <div class="p-8 text-center text-gray-400">
          <i class="fas fa-comment-slash text-2xl mb-2 block"></i>
          <p class="text-sm">No conversations yet</p>
        </div>
      @endforelse
    </div>
  </div>

  {{-- ═══ RIGHT: CHAT MAIN AREA ═══ --}}
  <div class="chat-main" id="chatMain">
    @if($activeConversation)
      {{-- Chat header --}}
      <div class="chat-top-bar">
        <div class="chat-user-info">
          <button class="md:hidden chat-action-btn mr-2" onclick="showSidebar()"
                  style="background:#f3f4f6;">
            <i class="fas fa-arrow-left"></i>
          </button>
          <img src="https://ui-avatars.com/api/?name={{ urlencode($activeConversation['avatar']) }}&background=7b0f10&color=fff&bold=true&size=48" 
               alt="{{ $activeConversation['name'] }}" class="chat-user-avatar">
          <div>
            <p class="chat-user-name">{{ $activeConversation['name'] }}</p>
            <p class="chat-user-status">
              @if($activeConversation['online'])
                <span class="status-online-text">● Active now</span>
              @else
                <span>Offline</span>
              @endif
              · {{ $activeConversation['department'] ?? 'UB Student' }}
            </p>
          </div>
        </div>
        <div class="chat-actions">
          <button class="chat-action-btn" title="Voice call">
            <i class="fas fa-phone"></i>
          </button>
          <button class="chat-action-btn" title="Video call">
            <i class="fas fa-video"></i>
          </button>
          <button class="chat-action-btn" title="Conversation info">
            <i class="fas fa-info-circle"></i>
          </button>
        </div>
      </div>

      {{-- Messages --}}
      <div class="messages-area" id="messagesArea">
        @foreach($messages as $message)
          <div class="message-group {{ $message['sender_id'] == $currentUser->id ? 'sent' : 'received' }}">
            <div>
              <div class="message-bubble">{{ $message['content'] }}</div>
              <p class="message-time">{{ $message['timestamp'] }}</p>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Input area --}}
      <div class="message-input-area">
        <form id="messageForm" class="space-y-2">
          @csrf
          <div class="input-wrapper">
            <div class="input-controls">
              <button type="button" class="input-control-btn" title="Attach file">
                <i class="fas fa-paperclip"></i>
              </button>
              <button type="button" class="input-control-btn" title="Add emoji">
                <i class="far fa-smile"></i>
              </button>
            </div>
            <textarea id="messageInput" placeholder="Type your message..." 
                      class="message-input" rows="1"
                      onkeydown="handleEnterKey(event)"></textarea>
            <button type="submit" class="send-btn" title="Send message">
              <i class="fas fa-paper-plane"></i>
            </button>
          </div>
          <div class="input-tip">
            <i class="fas fa-shield-alt text-[#7b0f10]"></i>
            <span><strong>Safety tip:</strong> Agree on trade terms before meeting. Always be respectful and honest about item condition.</span>
          </div>
        </form>
      </div>

    @else
      {{-- No conversation selected --}}
      <div class="no-chat-selected">
        <div class="no-chat-content">
          <i class="fas fa-comments no-chat-icon"></i>
          <p class="no-chat-title">Select a conversation</p>
          <p class="no-chat-desc">Choose a conversation from the sidebar to start chatting with your fellow UB students.</p>
        </div>
      </div>
    @endif
  </div>

</div>

<script>
// ═══ MESSAGE HANDLING ═══
document.getElementById('messageForm')?.addEventListener('submit', function(e) {
  e.preventDefault();
  sendMessage();
});

function handleEnterKey(event) {
  if (event.key === 'Enter' && !event.shiftKey) {
    event.preventDefault();
    sendMessage();
  }
}

function sendMessage() {
  const messageInput = document.getElementById('messageInput');
  const message = messageInput.value.trim();
  
  if (!message) return;
  
  // Add message to chat immediately (optimistic update)
  addMessageToChat(message, true);
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
    .then(data => console.log('Message sent:', data))
    .catch(error => console.error('Error:', error));
}

function addMessageToChat(message, isSent = true) {
  const messagesArea = document.getElementById('messagesArea');
  if (!messagesArea) return;
  
  const messageHTML = `
    <div class="message-group ${isSent ? 'sent' : 'received'}">
      <div>
        <div class="message-bubble">${message}</div>
        <p class="message-time">now</p>
      </div>
    </div>
  `;
  
  messagesArea.insertAdjacentHTML('beforeend', messageHTML);
  messagesArea.scrollTop = messagesArea.scrollHeight;
}

// ═══ SEARCH FUNCTIONALITY ═══
function filterConversations(query) {
  const conversations = document.querySelectorAll('.conv-item');
  query = query.toLowerCase();
  
  conversations.forEach(conv => {
    const name = conv.dataset.name || '';
    if (name.includes(query)) {
      conv.style.display = 'flex';
    } else {
      conv.style.display = 'none';
    }
  });
}

// ═══ MOBILE RESPONSIVE ═══
function showSidebar() {
  document.getElementById('chatSidebar').classList.remove('mobile-hidden');
  document.getElementById('chatMain').classList.remove('mobile-show');
}

function showChat() {
  document.getElementById('chatSidebar').classList.add('mobile-hidden');
  document.getElementById('chatMain').classList.add('mobile-show');
}

// Auto-scroll messages to bottom on page load
document.addEventListener('DOMContentLoaded', function() {
  const messagesArea = document.getElementById('messagesArea');
  if (messagesArea) {
    messagesArea.scrollTop = messagesArea.scrollHeight;
  }
});

// Auto-resize textarea
const textarea = document.getElementById('messageInput');
if (textarea) {
  textarea.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
  });
}
</script>
@endsection