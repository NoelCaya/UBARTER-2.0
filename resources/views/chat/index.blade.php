@extends('layouts.master')

@section('title', 'Messages - UBarter 2.0')

@section('content')
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
  .chat-header h1 { font-size:1.3rem; font-weight:800; color:#1a1209; margin:0 0 4px; }
  .chat-header p  { font-size:0.8rem; color:#9ca3af; margin:0; }
  .search-box {
    padding:16px 20px; border-bottom:1px solid #f3f4f6;
    background:#fff; position:relative;
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
  .conv-avatar img { width:44px; height:44px; border-radius:50%; border:2px solid #fff; }
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
    display:flex; flex-direction:column; align-items:flex-end; gap:4px; flex-shrink:0;
  }
  .conv-time { font-size:0.7rem; color:#9ca3af; }
  .unread-badge {
    background:#ef4444; color:#fff;
    font-size:0.65rem; font-weight:800;
    padding:2px 6px; border-radius:999px; line-height:1.2;
  }

  /* ═══ MAIN CHAT AREA ═══ */
  .chat-main {
    flex:1; display:flex; flex-direction:column; min-width:0;
  }
  .chat-top-bar {
    padding:16px 20px; background:#fff;
    border-bottom:1px solid #f3f4f6;
    display:flex; align-items:center; justify-content:space-between;
  }
  .chat-user-info { display:flex; align-items:center; gap:12px; }
  .chat-user-avatar { width:42px; height:42px; border-radius:50%; border:2px solid #f5c518; flex-shrink:0; }
  .chat-user-name  { font-size:1rem; font-weight:700; color:#1a1209; margin:0 0 2px; }
  .chat-user-status { font-size:0.75rem; color:#6b7280; margin:0; }
  .chat-actions { display:flex; align-items:center; gap:12px; }
  .chat-action-btn {
    width:36px; height:36px; border-radius:50%;
    background:#f8f9fa; border:none; color:#6b7280;
    cursor:pointer; display:flex; align-items:center; justify-content:center;
    transition:all 0.15s; font-size:0.9rem;
  }
  .chat-action-btn:hover { background:#7b0f10; color:#fff; transform:scale(1.05); }

  /* Messages */
  .messages-area {
    flex:1; overflow-y:auto; padding:20px; background:#f8f9fa;
    background-image:radial-gradient(circle at 20% 50%, rgba(123,15,16,0.02) 0%, transparent 50%),
                     radial-gradient(circle at 80% 20%, rgba(245,197,24,0.03) 0%, transparent 50%);
  }
  .message-group { display:flex; margin-bottom:16px; align-items:flex-end; }
  .message-group.sent { justify-content:flex-end; }
  .message-bubble {
    max-width:70%; padding:10px 14px; border-radius:18px;
    font-size:0.85rem; line-height:1.5; position:relative;
    word-break:break-word; display:inline-block;
  }
  .message-group.received .message-bubble {
    background:#fff; color:#1a1209; border-bottom-left-radius:6px;
    box-shadow:0 1px 2px rgba(0,0,0,0.1);
  }
  .message-group.sent .message-bubble {
    background:#7b0f10; color:#fff; border-bottom-right-radius:6px;
  }
  .message-time { font-size:0.68rem; opacity:0.6; margin-top:3px; text-align:center; }
  .message-group.sent .message-time { text-align:right; }

  /* Input area */
  .message-input-area {
    padding:16px 20px; background:#fff; border-top:1px solid #f3f4f6;
  }
  .input-wrapper { display:flex; align-items:center; gap:12px; }
  .input-controls { display:flex; align-items:center; gap:8px; }
  .input-control-btn {
    width:36px; height:36px; border-radius:50%;
    background:#f8f9fa; border:none; color:#6b7280;
    cursor:pointer; display:flex; align-items:center; justify-content:center;
    transition:all 0.15s; font-size:0.85rem;
  }
  .input-control-btn:hover { background:#7b0f10; color:#fff; }
  .message-input {
    flex:1; padding:12px 16px; background:#f8f9fa;
    border:1px solid #e9ecef; border-radius:20px;
    font-size:0.85rem; outline:none; transition:all 0.15s;
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
  .send-btn:hover { background:#5a0a0b; transform:scale(1.05); }
  .input-tip {
    padding:8px 0; font-size:0.7rem; color:#9ca3af;
    display:flex; align-items:center; gap:6px;
  }

  /* No conversation */
  .no-chat-selected {
    flex:1; display:flex; align-items:center; justify-content:center; background:#f8f9fa;
  }
  .no-chat-content { text-align:center; max-width:320px; }
  .no-chat-icon { font-size:4rem; color:#e5e7eb; margin-bottom:16px; }
  .no-chat-title { font-size:1.2rem; font-weight:700; color:#6b7280; margin:0 0 8px; }
  .no-chat-desc { font-size:0.9rem; color:#9ca3af; margin:0; line-height:1.5; }

  /* ═══ RESPONSIVE ═══ */
  @media (max-width:768px) {
    .chat-container {
      position: relative;
      height: calc(100vh - 4rem);
    }
    /* On mobile: sidebar takes full width, main is hidden by default */
    .chat-sidebar {
      width: 100%;
      position: absolute;
      inset: 0;
      z-index: 10;
      background: #fff;
      transition: transform 0.25s ease;
      transform: translateX(0);
    }
    .chat-main {
      display: flex;
      position: absolute;
      inset: 0;
      z-index: 20;
      transition: transform 0.25s ease;
      transform: translateX(100%); /* hidden off-screen to the right */
    }
    /* When a conversation is active on mobile, slide main in */
    .chat-main.mobile-active {
      transform: translateX(0);
    }
    /* When chat is open, slide sidebar out */
    .chat-sidebar.mobile-hidden {
      transform: translateX(-100%);
    }
  }
</style>

<div class="chat-container">

  {{-- ═══ LEFT: CONVERSATIONS SIDEBAR ═══ --}}
  <div class="chat-sidebar" id="chatSidebar">
    <div class="chat-header">
      <h1>Messages</h1>
      <p>{{ $conversations->count() }} conversation{{ $conversations->count() !== 1 ? 's' : '' }}</p>
    </div>

    <div class="search-box">
      <i class="fas fa-search search-icon"></i>
      <input type="text" placeholder="Search conversations..." class="search-input"
             oninput="filterConversations(this.value)">
    </div>

    <div class="conv-list">
      <div class="conv-header">
        <span>Conversations</span>
      </div>

      @forelse($conversations as $conv)
        @php
          $other    = $conv->otherUser(auth()->id());
          $lastMsg  = $conv->lastMessage;
          $unread   = $conv->unreadCountFor(auth()->id());
          $isActive = isset($activeConversation) && $activeConversation?->id === $conv->id;
        @endphp
        <a href="{{ route('chat.show', $other->id) }}"
           class="conv-item {{ $isActive ? 'active' : '' }}"
           data-name="{{ strtolower($other->name) }}"
           onclick="if(window.innerWidth<=768){ showChatPanel(); }">
          <div class="conv-avatar">
            <img src="{{ $other->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($other->name).'&background=7b0f10&color=fff&bold=true' }}"
                 alt="{{ $other->name }}">
          </div>
          <div class="conv-info">
            <p class="conv-name">{{ $other->name }}</p>
            <p class="conv-preview">
              {{ $lastMsg ? Str::limit($lastMsg->body, 40) : 'No messages yet' }}
            </p>
          </div>
          <div class="conv-meta">
            <span class="conv-time">
              {{ $lastMsg ? $lastMsg->created_at->diffForHumans(null, true) : '' }}
            </span>
            @if($unread > 0)
              <span class="unread-badge">{{ $unread }}</span>
            @endif
          </div>
        </a>
      @empty
        <div class="p-8 text-center text-gray-400">
          <i class="fas fa-comment-slash text-2xl mb-2 block"></i>
          <p class="text-sm">No conversations yet</p>
          <p class="text-xs mt-1">Visit an item listing and message the owner to start chatting.</p>
        </div>
      @endforelse
    </div>
  </div>

  {{-- ═══ RIGHT: CHAT MAIN AREA ═══ --}}
  <div class="chat-main" id="chatMain">
    @if($activeConversation && isset($otherUser))

      <div class="chat-top-bar">
        <div class="chat-user-info">
          <button class="md:hidden chat-action-btn mr-2" onclick="showSidebar()">
            <i class="fas fa-arrow-left"></i>
          </button>
          <img src="{{ $otherUser->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($otherUser->name).'&background=7b0f10&color=fff&bold=true&size=48' }}"
               alt="{{ $otherUser->name }}" class="chat-user-avatar">
          <div>
            <p class="chat-user-name">{{ $otherUser->name }}</p>
            <p class="chat-user-status">{{ $otherUser->email }}</p>
          </div>
        </div>
        {{-- Report button (#21) --}}
        <button onclick="document.getElementById('reportModal').style.display='flex'"
                style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;border-radius:8px;padding:6px 12px;font-size:0.72rem;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:5px;"
                title="Report this user">
          <i class="fas fa-flag"></i> Report
        </button>
      </div>

      {{-- Messages --}}
      <div class="messages-area" id="messagesArea">
        @foreach($messages as $message)
          <div class="message-group {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}"
               data-message-id="{{ $message->id }}">
            <div>
              <div class="message-bubble">{{ $message->body }}</div>
              <p class="message-time">{{ $message->timestamp_pst ?? $message->created_at->timezone('Asia/Manila')->format('g:i A') }}</p>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Input --}}
      <div class="message-input-area">
        <form id="messageForm" class="space-y-2">
          @csrf
          <input type="hidden" id="conversationId" value="{{ $activeConversation->id }}">
          <div class="input-wrapper">
            <div class="input-controls">
              <button type="button" class="input-control-btn" title="Emoji">
                <i class="far fa-smile"></i>
              </button>
            </div>
            <textarea id="messageInput" placeholder="Type your message..."
                      class="message-input" rows="1"
                      onkeydown="handleEnterKey(event)"></textarea>
            <button type="submit" class="send-btn" title="Send">
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
      <div class="no-chat-selected">
        <div class="no-chat-content">
          <i class="fas fa-comments no-chat-icon"></i>
          <p class="no-chat-title">Select a conversation</p>
          <p class="no-chat-desc">Choose a conversation from the sidebar, or visit an item listing and click "Message" to start chatting.</p>
        </div>
      </div>
    @endif
  </div>

</div>

<script>
const CURRENT_USER_ID  = {{ auth()->id() }};
const CONVERSATION_ID  = {{ $activeConversation?->id ?? 'null' }};
const CSRF_TOKEN       = document.querySelector('meta[name="csrf-token"]')?.content
                      ?? '{{ csrf_token() }}';

// ─── Send message ───────────────────────────────────────────────────────────
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
  const input   = document.getElementById('messageInput');
  const body    = input.value.trim();
  if (!body || !CONVERSATION_ID) return;

  // Optimistic render
  appendMessage({ body, sender_id: CURRENT_USER_ID, timestamp: 'now', id: Date.now() });
  input.value = '';
  input.style.height = 'auto';

  fetch('{{ route("chat.send") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': CSRF_TOKEN,
    },
    body: JSON.stringify({ body, conversation_id: CONVERSATION_ID }),
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      // Update the last temporary message ID with the real one
      lastMessageId = data.message.id;
    }
  })
  .catch(err => console.error('Send error:', err));
}

function appendMessage(msg) {
  const area  = document.getElementById('messagesArea');
  if (!area) return;
  const isSent = msg.sender_id === CURRENT_USER_ID;
  const div = document.createElement('div');
  div.className = `message-group ${isSent ? 'sent' : 'received'}`;
  div.dataset.messageId = msg.id;
  div.innerHTML = `
    <div>
      <div class="message-bubble">${escapeHtml(msg.body)}</div>
      <p class="message-time">${msg.timestamp}</p>
    </div>`;
  area.appendChild(div);
  area.scrollTop = area.scrollHeight;
}

function escapeHtml(text) {
  return text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
             .replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}

// ─── Polling for new messages ────────────────────────────────────────────────
let lastMessageId = (function() {
  const msgs = document.querySelectorAll('.message-group[data-message-id]');
  if (!msgs.length) return 0;
  return parseInt(msgs[msgs.length - 1].dataset.messageId) || 0;
})();

function pollMessages() {
  if (!CONVERSATION_ID) return;

  fetch(`{{ route("chat.poll") }}?conversation_id=${CONVERSATION_ID}&last_message_id=${lastMessageId}`, {
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
  })
  .then(r => r.json())
  .then(data => {
    if (data.messages && data.messages.length) {
      data.messages.forEach(msg => {
        // Skip if it's already shown (optimistic update)
        if (document.querySelector(`[data-message-id="${msg.id}"]`)) return;
        appendMessage({ ...msg, timestamp: msg.timestamp });
        lastMessageId = Math.max(lastMessageId, msg.id);
      });
    }
  })
  .catch(() => {}); // Silently fail on poll errors
}

// Poll every 3 seconds when a conversation is open
if (CONVERSATION_ID) {
  setInterval(pollMessages, 3000);
}

// ─── Search ──────────────────────────────────────────────────────────────────
function filterConversations(query) {
  document.querySelectorAll('.conv-item').forEach(el => {
    el.style.display = el.dataset.name?.includes(query.toLowerCase()) ? 'flex' : 'none';
  });
}

// ─── Mobile ──────────────────────────────────────────────────────────────────
function showSidebar() {
  if (window.innerWidth <= 768) {
    document.getElementById('chatSidebar').classList.remove('mobile-hidden');
    document.getElementById('chatMain').classList.remove('mobile-active');
  }
}

function showChatPanel() {
  if (window.innerWidth <= 768) {
    document.getElementById('chatSidebar').classList.add('mobile-hidden');
    document.getElementById('chatMain').classList.add('mobile-active');
  }
}

// On mobile, if a conversation is active, show chat panel immediately
document.addEventListener('DOMContentLoaded', function() {
  if (CONVERSATION_ID && window.innerWidth <= 768) {
    showChatPanel();
  }
});

// ─── Auto scroll & textarea resize ───────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
  const area = document.getElementById('messagesArea');
  if (area) area.scrollTop = area.scrollHeight;

  // On mobile with active conversation, show chat panel
  if (CONVERSATION_ID && window.innerWidth <= 768) {
    showChatPanel();
  }

  const textarea = document.getElementById('messageInput');
  if (textarea) {
    textarea.addEventListener('input', function() {
      this.style.height = 'auto';
      this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });
  }
});
</script>
{{-- ── Report User Modal (#21) ── --}}
@if(isset($activeConversation) && isset($otherUser))
<div id="reportModal"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:9999;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:18px;padding:28px;max-width:420px;width:90%;box-shadow:0 8px 32px rgba(0,0,0,0.2);">
    <h3 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0 0 4px;">Report User</h3>
    <p style="font-size:0.78rem;color:#9ca3af;margin:0 0 18px;">Report <strong>{{ $otherUser->name }}</strong> to CES Admin. Only submit genuine reports.</p>
    <form action="{{ route('reports.store') }}" method="POST">
      @csrf
      <input type="hidden" name="reported_user_id" value="{{ $otherUser->id }}">
      <input type="hidden" name="conversation_id"  value="{{ $activeConversation->id }}">

      <div style="margin-bottom:14px;">
        <label style="display:block;font-size:0.72rem;font-weight:700;color:#374151;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Reason <span style="color:#ef4444;">*</span></label>
        <select name="reason" required
                style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.85rem;outline:none;background:#fff;"
                onfocus="this.style.borderColor='#7b0f10'" onblur="this.style.borderColor='#e5e7eb'">
          <option value="">— Select a reason —</option>
          @foreach(['Fraudulous Behavior','Inappropriate Behavior','Verbal Abuse','Spam','Fake Item Listing','Scam Attempt','Other'] as $reason)
            <option value="{{ $reason }}">{{ $reason }}</option>
          @endforeach
        </select>
      </div>

      <div style="margin-bottom:20px;">
        <label style="display:block;font-size:0.72rem;font-weight:700;color:#374151;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Additional Details <span style="font-weight:400;color:#9ca3af;">(optional)</span></label>
        <textarea name="details" rows="3" maxlength="1000"
                  placeholder="Describe what happened…"
                  style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.85rem;outline:none;resize:none;"
                  onfocus="this.style.borderColor='#7b0f10'" onblur="this.style.borderColor='#e5e7eb'"></textarea>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;">
        <button type="button" onclick="document.getElementById('reportModal').style.display='none'"
                style="background:#f3f4f6;color:#374151;font-size:0.82rem;font-weight:700;padding:9px 18px;border-radius:8px;border:none;cursor:pointer;">
          Cancel
        </button>
        <button type="submit"
                style="background:#dc2626;color:#fff;font-size:0.82rem;font-weight:700;padding:9px 18px;border-radius:8px;border:none;cursor:pointer;">
          <i class="fas fa-flag" style="margin-right:4px;"></i> Submit Report
        </button>
      </div>
    </form>
  </div>
</div>
@endif

@endsection
