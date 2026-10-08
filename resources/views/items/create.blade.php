@extends('layouts.master')

@section('title', 'Post a New Item')

@section('content')
<style>
*{box-sizing:border-box;}

/* ─── PAGE WRAP ─── */
.create-wrap { max-width:960px; margin:0 auto; padding:20px 16px 40px; }

/* ─── STEP INDICATOR ─── */
.step-bar { display:flex; align-items:center; gap:0; margin-bottom:28px; }
.step { display:flex; align-items:center; gap:8px; flex:1; }
.step-circle {
  width:32px; height:32px; border-radius:50%;
  display:flex; align-items:center; justify-content:center;
  font-size:0.75rem; font-weight:800; flex-shrink:0;
  border:2px solid #e5e7eb; background:#fff; color:#9ca3af;
  transition:all 0.2s;
}
.step.done .step-circle  { background:#7b0f10; border-color:#7b0f10; color:#fff; }
.step.active .step-circle{ background:#7b0f10; border-color:#7b0f10; color:#fff; box-shadow:0 0 0 4px rgba(123,15,16,0.15); }
.step-label { font-size:0.72rem; font-weight:700; color:#9ca3af; }
.step.active .step-label { color:#7b0f10; }
.step.done .step-label   { color:#374151; }
.step-line { flex:1; height:2px; background:#e5e7eb; margin:0 8px; }
.step-line.done { background:#7b0f10; }

/* ─── TYPE SELECTOR CARDS ─── */
.type-card {
  position: relative; padding: 20px; border: 2.5px solid #e5e7eb; border-radius: 16px;
  background: #fff; cursor: pointer; transition: all 0.2s;
}
.type-card:hover { border-color: #d1d5db; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
.type-card.selected-barter { border-color:#7b0f10; background:#fff8f8; box-shadow:0 0 0 4px rgba(123,15,16,0.08); }
.type-card.selected-donate { border-color:#16a34a; background:#f0fdf4; box-shadow:0 0 0 4px rgba(22,163,74,0.08); }
.type-icon {
  width:52px; height:52px; border-radius:14px;
  display:flex; align-items:center; justify-content:center;
  font-size:1.3rem; margin-bottom:12px;
  transition:transform 0.2s;
}
.type-card:hover .type-icon { transform:scale(1.08); }
.type-check {
  position:absolute; top:12px; right:12px;
  width:22px; height:22px; border-radius:50%;
  border:2px solid #e5e7eb; display:flex; align-items:center;
  justify-content:center; font-size:0.65rem; background:#fff;
  transition:all 0.2s;
}
.type-card.selected-barter .type-check { background:#7b0f10; border-color:#7b0f10; color:#fff; }
.type-card.selected-donate .type-check { background:#16a34a; border-color:#16a34a; color:#fff; }

/* ─── FORM INPUTS ─── */
.form-label { display:block; font-size:0.78rem; font-weight:700; color:#374151; margin-bottom:7px; }
.form-req { color:#ef4444; }
.form-input {
  width:100%; padding:11px 14px; border:2px solid #e5e7eb;
  border-radius:12px; font-size:0.875rem; outline:none;
  transition:all 0.15s; background:#fafafa; color:#1a1209;
}
.form-input:focus { border-color:#7b0f10; background:#fff; box-shadow:0 0 0 4px rgba(123,15,16,0.08); }
.form-input.error { border-color:#ef4444; }
.form-textarea { resize:none; }
.form-select {
  appearance:none;
  background-image:url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
  background-repeat:no-repeat; background-position:right 12px center; background-size:15px;
  padding-right:36px;
}
.form-select:focus {
  background-image:url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%237b0f10' stroke-width='2'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
}

/* ─── DROPZONE ─── */
.dropzone {
  border:2.5px dashed #d1d5db; border-radius:14px; padding:36px 20px;
  text-align:center; background:#fafafa; cursor:pointer;
  transition:all 0.2s; position:relative;
}
.dropzone:hover, .dropzone.drag-over {
  border-color:#f59e0b; background:#fffbeb;
}
.dropzone-icon { font-size:2.5rem; color:#d1d5db; margin-bottom:10px; display:block; transition:color 0.2s; }
.dropzone:hover .dropzone-icon, .dropzone.drag-over .dropzone-icon { color:#f59e0b; }

/* ─── PREVIEW ─── */
.img-preview-box {
  position:relative; width:100%; padding-bottom:56.25%; /* 16:9 */
  border-radius:12px; overflow:hidden; background:#f5f5f5;
}
.img-preview-box img {
  position:absolute; inset:0; width:100%; height:100%;
  object-fit:cover;
}
.img-remove-btn {
  position:absolute; top:-8px; right:-8px;
  width:28px; height:28px; background:#ef4444; color:#fff;
  border:none; border-radius:50%; cursor:pointer;
  display:flex; align-items:center; justify-content:center;
  font-size:0.75rem; transition:background 0.15s;
}
.img-remove-btn:hover { background:#dc2626; }

/* ─── GUIDELINE CARD ─── */
.guide-card {
  background:linear-gradient(135deg,#eff6ff,#eef2ff);
  border:1px solid #bfdbfe; border-radius:14px; padding:18px;
}
.guide-item { display:flex; align-items:flex-start; gap:8px; margin-bottom:8px; }
.guide-item:last-child { margin-bottom:0; }
.guide-check { width:18px; height:18px; background:#3b82f6; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }

/* ─── SUBMIT BUTTONS ─── */
.btn-submit {
  display:flex; align-items:center; justify-content:center; gap:8px;
  padding:13px 28px; background:#7b0f10; color:#fff;
  border:none; border-radius:13px; font-size:0.9rem; font-weight:800;
  cursor:pointer; transition:all 0.15s; flex:1;
}
.btn-submit:hover { background:#5a0a0b; transform:translateY(-1px); box-shadow:0 6px 16px rgba(123,15,16,0.25); }
.btn-cancel {
  display:flex; align-items:center; justify-content:center; gap:7px;
  padding:13px 22px; background:#fff; color:#6b7280;
  border:2px solid #e5e7eb; border-radius:13px;
  font-size:0.88rem; font-weight:700; text-decoration:none;
  transition:all 0.15s;
}
.btn-cancel:hover { border-color:#d1d5db; color:#374151; background:#f9fafb; text-decoration:none; }
</style>

<div class="create-wrap">

  {{-- HEADER --}}
  <div style="margin-bottom:24px;">
    <h1 style="font-size:1.5rem;font-weight:900;color:#1a1209;margin:0 0 4px;">Post a New Item</h1>
    <p style="font-size:0.82rem;color:#9ca3af;margin:0;">Share with the UB community and start bartering!</p>
  </div>

  {{-- FLASH MESSAGES --}}
  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:11px 16px;border-radius:12px;font-size:0.82rem;font-weight:600;margin-bottom:18px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif
  @if($errors->any())
    <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:11px 16px;border-radius:12px;font-size:0.82rem;margin-bottom:18px;">
      <p style="font-weight:700;margin:0 0 6px;display:flex;align-items:center;gap:6px;">
        <i class="fas fa-exclamation-circle"></i> Please fix the following:
      </p>
      <ul style="list-style:disc;padding-left:18px;margin:0;line-height:1.8;">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" id="postForm">
    @csrf

    {{-- ══════════════════════════════════════════════════ --}}
    {{-- STEP 1 — ITEM TYPE                                 --}}
    {{-- ══════════════════════════════════════════════════ --}}
    <div style="background:#fff;border-radius:18px;padding:24px;border:1px solid #f0f0f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);margin-bottom:16px;">
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px;">
        <span style="width:28px;height:28px;background:#7b0f10;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <span style="color:#fff;font-size:0.72rem;font-weight:800;">1</span>
        </span>
        <h2 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0;">What type of item are you posting?</h2>
        <span style="color:#ef4444;font-size:0.85rem;">*</span>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        {{-- Barter --}}
        <label class="type-card {{ old('item_type','Barter')==='Barter' ? 'selected-barter' : '' }}" id="card-barter" onclick="selectType('Barter')">
          <input type="radio" name="item_type" value="Barter" id="type-barter" class="sr-only" style="position:absolute;opacity:0;" {{ old('item_type','Barter')==='Barter'?'checked':'' }} required>
          <div class="type-check" id="check-barter">
            @if(old('item_type','Barter')==='Barter') <i class="fas fa-check"></i> @endif
          </div>
          <div class="type-icon" style="background:linear-gradient(135deg,#7b0f10,#5a0a0b);">
            <i class="fas fa-exchange-alt" style="color:#fff;"></i>
          </div>
          <h3 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0 0 6px;">Barter Trade</h3>
          <p style="font-size:0.78rem;color:#6b7280;margin:0 0 12px;line-height:1.5;">Trade your item in exchange for something else you need from fellow UB students.</p>
          <div style="display:flex;align-items:center;gap:6px;">
            <span style="font-size:0.65rem;font-weight:700;background:#fee2e2;color:#991b1b;padding:3px 8px;border-radius:999px;">Most Popular</span>
            <span style="font-size:0.65rem;color:#9ca3af;">• Exchange-based</span>
          </div>
        </label>

        {{-- Donation --}}
        <label class="type-card {{ old('item_type')==='Donation' ? 'selected-donate' : '' }}" id="card-donate" onclick="selectType('Donation')">
          <input type="radio" name="item_type" value="Donation" id="type-donate" class="sr-only" style="position:absolute;opacity:0;" {{ old('item_type')==='Donation'?'checked':'' }}>
          <div class="type-check" id="check-donate">
            @if(old('item_type')==='Donation') <i class="fas fa-check"></i> @endif
          </div>
          <div class="type-icon" style="background:linear-gradient(135deg,#16a34a,#15803d);">
            <i class="fas fa-hand-holding-heart" style="color:#fff;"></i>
          </div>
          <h3 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0 0 6px;">Free Donation</h3>
          <p style="font-size:0.78rem;color:#6b7280;margin:0 0 12px;line-height:1.5;">Give away items you no longer need to help UB students reduce waste and build community.</p>
          <div style="display:flex;align-items:center;gap:6px;">
            <span style="font-size:0.65rem;font-weight:700;background:#dcfce7;color:#166534;padding:3px 8px;border-radius:999px;">Eco-Friendly</span>
            <span style="font-size:0.65rem;color:#9ca3af;">• Free to claim</span>
          </div>
        </label>
      </div>
    </div>

    {{-- ══════════════════════════════════════════════════ --}}
    {{-- STEP 2 — ITEM DETAILS (2-column)                   --}}
    {{-- ══════════════════════════════════════════════════ --}}
    <div style="background:#fff;border-radius:18px;padding:24px;border:1px solid #f0f0f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);margin-bottom:16px;">
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
        <span style="width:28px;height:28px;background:#7b0f10;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <span style="color:#fff;font-size:0.72rem;font-weight:800;">2</span>
        </span>
        <h2 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0;">Item Details</h2>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

        {{-- LEFT COLUMN --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

          {{-- Title --}}
          <div>
            <label class="form-label" for="title">Item Title <span class="form-req">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title') }}"
                   placeholder="e.g., Advanced Calculus Textbook – 3rd Ed."
                   class="form-input {{ $errors->has('title')?'error':'' }}" required>
          </div>

          {{-- Description --}}
          <div>
            <label class="form-label" for="description">Description <span class="form-req">*</span></label>
            <textarea id="description" name="description" rows="4"
                      placeholder="Describe condition, usage history, any flaws…"
                      class="form-input form-textarea {{ $errors->has('description')?'error':'' }}" required>{{ old('description') }}</textarea>
          </div>

          {{-- Category & Condition --}}
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
              <label class="form-label" for="category">Category <span class="form-req">*</span></label>
              <select id="category" name="category" class="form-input form-select {{ $errors->has('category')?'error':'' }}" required>
                <option value="">Pick one</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat }}" {{ old('category')===$cat?'selected':'' }}>{{ $cat }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="form-label" for="condition">Condition <span class="form-req">*</span></label>
              <select id="condition" name="condition" class="form-input form-select {{ $errors->has('condition')?'error':'' }}" required>
                <option value="">Pick one</option>
                @foreach($conditions as $cond)
                  <option value="{{ $cond }}" {{ old('condition')===$cond?'selected':'' }}>{{ $cond }}</option>
                @endforeach
              </select>
            </div>
          </div>

          {{-- Looking For (barter only) --}}
          <div id="barter-section" style="{{ old('item_type','Barter')==='Donation' ? 'display:none;' : '' }}">
            <label class="form-label" for="looking_for">
              What are you looking for in exchange?
              <span style="font-size:0.68rem;color:#9ca3af;font-weight:500;">(optional)</span>
            </label>
            <textarea id="looking_for" name="looking_for" rows="2"
                      placeholder="e.g., Programming books, Lab equipment…"
                      class="form-input form-textarea">{{ old('looking_for') }}</textarea>
          </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

          {{-- Photo Upload --}}
          <div>
            <label class="form-label">Item Photo
              <span style="font-size:0.68rem;color:#9ca3af;font-weight:500;">(optional)</span>
            </label>

            <div class="dropzone" onclick="document.getElementById('image').click()" id="upload-zone">
              <i class="fas fa-cloud-upload-alt dropzone-icon"></i>
              <p style="font-size:0.85rem;font-weight:700;color:#4b5563;margin:0 0 4px;">Click or drag &amp; drop</p>
              <p style="font-size:0.72rem;color:#9ca3af;margin:0;">PNG or JPG, up to 5 MB</p>
              <input type="file" id="image" name="image" accept="image/*" class="hidden" style="display:none;" onchange="previewImage(this)">
            </div>

            {{-- Preview --}}
            <div id="image-preview" style="display:none;margin-top:12px;position:relative;">
              <div class="img-preview-box">
                <img id="preview-img" src="" alt="Preview">
              </div>
              <button type="button" class="img-remove-btn" onclick="removeImage()">
                <i class="fas fa-times"></i>
              </button>
              <p id="preview-name" style="font-size:0.68rem;color:#9ca3af;margin:6px 0 0;"></p>
            </div>
            <p style="font-size:0.7rem;color:#9ca3af;margin:6px 0 0;">
              <i class="fas fa-info-circle" style="margin-right:3px;"></i>
              A placeholder image will be used if none is uploaded.
            </p>
          </div>

          {{-- Guidelines --}}
          <div class="guide-card">
            <h4 style="font-size:0.82rem;font-weight:700;color:#1e3a8a;margin:0 0 12px;display:flex;align-items:center;gap:7px;">
              <i class="fas fa-lightbulb" style="color:#3b82f6;"></i> Posting Guidelines
            </h4>
            @foreach(['Use clear, honest descriptions','Mention any damages or wear','Take well-lit, sharp photos','Only post items you personally own'] as $tip)
              <div class="guide-item">
                <div class="guide-check"><i class="fas fa-check" style="color:#fff;font-size:0.58rem;"></i></div>
                <span style="font-size:0.75rem;color:#1e40af;">{{ $tip }}</span>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    {{-- ══════════════════════════════════════════════════ --}}
    {{-- SUBMIT BAR                                         --}}
    {{-- ══════════════════════════════════════════════════ --}}
    <div style="display:flex;gap:12px;align-items:center;background:#fff;border-radius:18px;padding:20px;border:1px solid #f0f0f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
      <a href="{{ route('items.browse') }}" class="btn-cancel">
        <i class="fas fa-arrow-left"></i> Cancel
      </a>
      <button type="submit" class="btn-submit">
        <i class="fas fa-paper-plane"></i> Post Item to Campus
      </button>
    </div>
  </form>
</div>

<script>
function selectType(type) {
  // update radio inputs
  document.getElementById('type-barter').checked = (type === 'Barter');
  document.getElementById('type-donate').checked = (type === 'Donation');

  // toggle card styles
  const cardBarter = document.getElementById('card-barter');
  const cardDonate = document.getElementById('card-donate');
  cardBarter.className = 'type-card' + (type === 'Barter' ? ' selected-barter' : '');
  cardDonate.className = 'type-card' + (type === 'Donation' ? ' selected-donate' : '');

  // toggle checkmarks
  document.getElementById('check-barter').innerHTML = type === 'Barter' ? '<i class="fas fa-check"></i>' : '';
  document.getElementById('check-donate').innerHTML = type === 'Donation' ? '<i class="fas fa-check"></i>' : '';

  // toggle barter-only section
  document.getElementById('barter-section').style.display = type === 'Barter' ? '' : 'none';
}

function previewImage(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      document.getElementById('preview-img').src = e.target.result;
      document.getElementById('preview-name').textContent = input.files[0].name;
      document.getElementById('image-preview').style.display = 'block';
      document.getElementById('upload-zone').style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function removeImage() {
  document.getElementById('image').value = '';
  document.getElementById('image-preview').style.display = 'none';
  document.getElementById('upload-zone').style.display = 'block';
}

// Drag-and-drop
const dz = document.getElementById('upload-zone');
['dragenter','dragover'].forEach(e => dz.addEventListener(e, ev => { ev.preventDefault(); dz.classList.add('drag-over'); }));
['dragleave','drop'].forEach(e => dz.addEventListener(e, ev => { ev.preventDefault(); dz.classList.remove('drag-over'); }));
dz.addEventListener('drop', ev => {
  const files = ev.dataTransfer.files;
  if (files.length) { document.getElementById('image').files = files; previewImage(document.getElementById('image')); }
});

// Responsive grid fix — pure JS, no Blade directives inside script blocks
document.addEventListener('DOMContentLoaded', () => {
  const cols = document.querySelectorAll('[style*="grid-template-columns:1fr 1fr"]');
  if (window.innerWidth < 640) cols.forEach(c => c.style.gridTemplateColumns = '1fr');
});
</script>
@endsection
