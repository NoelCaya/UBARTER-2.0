@extends('layouts.master')

@section('title', 'Write a Review')

@section('content')
<div style="max-width:680px;margin:0 auto;padding:24px 16px;">

  {{-- Header --}}
  <div style="background:linear-gradient(135deg,#7b0f10,#5a0a0b);border-radius:16px;padding:24px 28px;color:#fff;margin-bottom:20px;">
    <h1 style="font-size:1.4rem;font-weight:900;margin:0 0 4px;">Write a Review</h1>
    <p style="font-size:0.82rem;opacity:0.8;margin:0;">Share your experience from this trade</p>
  </div>

  @if(session('error'))
    <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;">
      <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
  @endif

  {{-- Item & Trade Info --}}
  <div style="background:#fff;border-radius:14px;padding:18px 20px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border:1px solid #f3f4f6;margin-bottom:16px;">
    <p style="font-size:0.6rem;font-weight:800;text-transform:uppercase;letter-spacing:0.1em;color:#9ca3af;margin:0 0 10px;">Trade Details</p>
    <div style="display:flex;align-items:center;gap:14px;">
      <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
           style="width:60px;height:60px;border-radius:10px;object-fit:cover;flex-shrink:0;background:#f5f5f5;">
      <div>
        <p style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0 0 3px;">{{ $item->title }}</p>
        <p style="font-size:0.78rem;color:#6b7280;margin:0;">
          Seller: <strong>{{ $item->user->name }}</strong> &nbsp;·&nbsp; {{ $item->category }}
        </p>
        <p style="font-size:0.68rem;color:#9ca3af;margin:3px 0 0;">
          Trade completed {{ $trade->updated_at->diffForHumans() }}
        </p>
      </div>
    </div>
  </div>

  {{-- Review Form --}}
  <div style="background:#fff;border-radius:14px;padding:24px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border:1px solid #f3f4f6;">
    <form action="{{ route('reviews.store', $item) }}" method="POST">
      @csrf
      <input type="hidden" name="trade_id" value="{{ $trade->id }}">

      {{-- Star Rating --}}
      <div style="margin-bottom:20px;">
        <label style="display:block;font-size:0.72rem;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:#374151;margin-bottom:12px;">
          Your Rating <span style="color:#ef4444;">*</span>
        </label>
        <div style="display:flex;gap:8px;align-items:center;" id="ratingStars">
          @for($i = 1; $i <= 5; $i++)
            <label style="cursor:pointer;line-height:1;">
              <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" {{ $i == 5 ? 'checked' : '' }}>
              <span style="font-size:2.5rem;transition:all 0.15s;" data-value="{{ $i }}"
                    class="{{ $i == 5 ? 'text-[#f5c518]' : 'text-gray-300' }}">★</span>
            </label>
          @endfor
          <span id="ratingLabel" style="font-size:0.82rem;font-weight:700;color:#374151;margin-left:8px;">Excellent</span>
        </div>
        @error('rating')
          <p style="color:#ef4444;font-size:0.75rem;margin-top:6px;">{{ $message }}</p>
        @enderror
      </div>

      {{-- Comment --}}
      <div style="margin-bottom:24px;">
        <label for="comment" style="display:block;font-size:0.72rem;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:#374151;margin-bottom:8px;">
          Your Comment <span style="font-size:0.65rem;font-weight:500;color:#9ca3af;">(optional)</span>
        </label>
        <textarea name="comment" id="comment" rows="4"
                  placeholder="Describe your experience — was the item as described? Was the seller responsive and fair?"
                  style="width:100%;padding:12px 14px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:0.85rem;outline:none;resize:vertical;transition:border-color 0.15s;"
                  onfocus="this.style.borderColor='#7b0f10'" onblur="this.style.borderColor='#e5e7eb'"
                  maxlength="500">{{ old('comment') }}</textarea>
        <p style="font-size:0.68rem;color:#9ca3af;margin:4px 0 0;text-align:right;">
          <span id="charCount">0</span>/500 characters
        </p>
        @error('comment')
          <p style="color:#ef4444;font-size:0.75rem;margin-top:4px;">{{ $message }}</p>
        @enderror
      </div>

      {{-- Buttons --}}
      <div style="display:flex;gap:10px;">
        <button type="submit"
                style="flex:2;background:#7b0f10;color:#fff;font-weight:700;font-size:0.88rem;padding:11px;border-radius:10px;border:none;cursor:pointer;transition:background 0.15s;"
                onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
          <i class="fas fa-paper-plane" style="margin-right:5px;"></i> Submit Review
        </button>
        <a href="{{ route('trade-history') }}"
           style="flex:1;background:#f3f4f6;color:#374151;font-weight:700;font-size:0.88rem;padding:11px;border-radius:10px;text-decoration:none;text-align:center;transition:background 0.15s;"
           onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
          Cancel
        </a>
      </div>
    </form>
  </div>

  {{-- Guidelines --}}
  <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:16px 20px;margin-top:16px;">
    <h3 style="font-size:0.82rem;font-weight:800;color:#166534;margin:0 0 10px;display:flex;align-items:center;gap:6px;">
      <i class="fas fa-shield-alt"></i> Review Guidelines
    </h3>
    <ul style="margin:0;padding:0 0 0 16px;font-size:0.78rem;color:#166534;line-height:1.8;">
      <li>Be honest and fair in your assessment</li>
      <li>Focus on item condition and seller communication</li>
      <li>Avoid personal attacks or irrelevant comments</li>
      <li>Your review helps maintain community trust</li>
    </ul>
  </div>

</div>

<script>
const ratingLabels = { 1:'Poor', 2:'Fair', 3:'Good', 4:'Very Good', 5:'Excellent' };

document.querySelectorAll('#ratingStars input').forEach(radio => {
  radio.addEventListener('change', function() {
    const val = parseInt(this.value);
    document.querySelectorAll('#ratingStars span[data-value]').forEach((star, i) => {
      star.style.color = (i + 1) <= val ? '#f5c518' : '#d1d5db';
    });
    document.getElementById('ratingLabel').textContent = ratingLabels[val] || '';
  });
});

// Init stars on load
const checked = document.querySelector('#ratingStars input:checked');
if (checked) {
  const val = parseInt(checked.value);
  document.querySelectorAll('#ratingStars span[data-value]').forEach((star, i) => {
    star.style.color = (i + 1) <= val ? '#f5c518' : '#d1d5db';
  });
  document.getElementById('ratingLabel').textContent = ratingLabels[val] || '';
}

// Char counter
const comment = document.getElementById('comment');
const counter = document.getElementById('charCount');
comment.addEventListener('input', () => { counter.textContent = comment.value.length; });
</script>
@endsection
