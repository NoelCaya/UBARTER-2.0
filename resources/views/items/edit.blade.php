@extends('layouts.master')

@section('title', 'Edit Item')

@section('content')
<div class="px-4 md:px-6 py-6 max-w-3xl mx-auto">

    <div class="mb-5">
        <a href="{{ route('items.my-items') }}" style="color:#7b0f10;font-size:0.82rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px;margin-bottom:10px;">
            <i class="fas fa-arrow-left" style="font-size:0.7rem;"></i> Back to My Items
        </a>
        <h1 style="font-size:1.4rem;font-weight:800;color:#1a1209;margin:0;">Edit Item</h1>
        <p style="font-size:0.78rem;color:#9ca3af;margin:3px 0 0;">Changes will be re-submitted for admin review.</p>
    </div>

    @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:10px 16px;border-radius:10px;font-size:0.82rem;margin-bottom:16px;">
            <p style="font-weight:700;margin:0 0 4px;"><i class="fas fa-exclamation-circle mr-1"></i> Please fix the following:</p>
            <ul style="list-style:disc;padding-left:18px;margin:0;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PATCH')

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-5">

            <!-- Current image preview -->
            <div>
                <p style="font-size:0.75rem;font-weight:700;color:#374151;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Current Photo</p>
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                     style="width:100px;height:100px;border-radius:10px;object-fit:cover;border:1px solid #e5e7eb;">
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1.5">Item Title <span style="color:#ef4444;">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $item->title) }}"
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm" required>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">Description <span style="color:#ef4444;">*</span></label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm resize-none" required>{{ old('description', $item->description) }}</textarea>
            </div>

            <!-- Category & Condition -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-1.5">Category <span style="color:#ef4444;">*</span></label>
                    <select id="category" name="category"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $item->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="condition" class="block text-sm font-semibold text-gray-700 mb-1.5">Condition <span style="color:#ef4444;">*</span></label>
                    <select id="condition" name="condition"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm" required>
                        @foreach($conditions as $cond)
                            <option value="{{ $cond }}" {{ old('condition', $item->condition) == $cond ? 'selected' : '' }}>{{ $cond }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Looking For (Barter only) -->
            @if($item->item_type === 'Barter')
            <div>
                <label for="looking_for" class="block text-sm font-semibold text-gray-700 mb-1.5">What are you looking for in exchange?</label>
                <textarea id="looking_for" name="looking_for" rows="2"
                          placeholder="e.g., Programming books, Lab equipment..."
                          class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm resize-none">{{ old('looking_for', $item->looking_for ?? '') }}</textarea>
            </div>
            @endif

            <!-- Replace Photo -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Replace Photo (optional)</label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-5 text-center hover:border-[#7b0f10] transition cursor-pointer bg-gray-50"
                     onclick="document.getElementById('image').click()">
                    <i class="fas fa-cloud-upload-alt text-2xl text-gray-300 mb-1 block"></i>
                    <p class="text-gray-500 text-sm">Click to upload a new photo</p>
                    <p class="text-xs text-gray-400 mt-0.5">PNG, JPG up to 5MB · Leave empty to keep current photo</p>
                    <input type="file" id="image" name="image" accept="image/*" class="hidden"
                           onchange="document.getElementById('newPhotoName').textContent = this.files[0]?.name || ''">
                </div>
                <p id="newPhotoName" style="font-size:0.72rem;color:#7b0f10;margin-top:4px;"></p>
            </div>

            <!-- Item type (read-only display) -->
            <div style="background:#f9fafb;border-radius:10px;padding:12px 14px;display:flex;align-items:center;gap:8px;">
                <i class="{{ $item->item_type === 'Barter' ? 'fas fa-exchange-alt' : 'fas fa-gift' }}"
                   style="color:{{ $item->item_type === 'Barter' ? '#7b0f10' : '#16a34a' }};font-size:0.85rem;"></i>
                <div>
                    <p style="font-size:0.78rem;font-weight:700;color:#374151;margin:0;">Item Type: {{ $item->item_type }}</p>
                    <p style="font-size:0.68rem;color:#9ca3af;margin:0;">Item type cannot be changed after posting.</p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <a href="{{ route('items.my-items') }}"
                   class="px-5 py-2.5 border border-gray-300 text-gray-600 font-semibold rounded-lg hover:bg-gray-50 transition text-sm">
                    Cancel
                </a>
                <button type="submit"
                        class="flex-1 py-2.5 text-white font-bold rounded-lg transition text-sm flex items-center justify-center gap-2"
                        style="background-color:#7b0f10;"
                        onmouseover="this.style.backgroundColor='#5a0a0b'"
                        onmouseout="this.style.backgroundColor='#7b0f10'">
                    <i class="fas fa-save text-xs"></i> Save Changes
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
