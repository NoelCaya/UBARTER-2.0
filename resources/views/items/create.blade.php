@extends('layouts.master')

@section('title', 'Post a New Item')

@section('content')
<div class="px-4 md:px-6 py-6 max-w-3xl mx-auto">

    <div class="mb-5">
        <h1 class="text-2xl font-bold text-gray-900">Post a New Item</h1>
        <p class="text-gray-500 mt-1 text-sm">Share an item with the UB community.</p>
    </div>

    {{-- Success / Error messages --}}
    @if(session('success'))
        <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:10px 16px;border-radius:10px;font-size:0.82rem;margin-bottom:16px;">
            <p class="font-bold mb-1"><i class="fas fa-exclamation-circle mr-1"></i> Please fix the following errors:</p>
            <ul style="list-style:disc;padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-5">

            <!-- Item Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1.5">Item Title <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}"
                       placeholder="e.g., Advanced Calculus Textbook - 3rd Edition"
                       class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('title') ? 'border-red-400' : 'border-gray-300' }} focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm" required>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">Description <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" rows="4"
                          placeholder="Describe the item — condition, usage history, any damages, etc."
                          class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('description') ? 'border-red-400' : 'border-gray-300' }} focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm resize-none" required>{{ old('description') }}</textarea>
            </div>

            <!-- Category & Condition -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                    <select id="category" name="category"
                            class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('category') ? 'border-red-400' : 'border-gray-300' }} focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="condition" class="block text-sm font-semibold text-gray-700 mb-1.5">Condition <span class="text-red-500">*</span></label>
                    <select id="condition" name="condition"
                            class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('condition') ? 'border-red-400' : 'border-gray-300' }} focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm" required>
                        <option value="">Select condition</option>
                        @foreach($conditions as $cond)
                            <option value="{{ $cond }}" {{ old('condition') == $cond ? 'selected' : '' }}>{{ $cond }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Item Type -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Item Type <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-start gap-3 border-2 rounded-xl p-4 cursor-pointer transition"
                           id="label-barter"
                           style="border-color:#7b0f10; background:rgba(123,15,16,0.04);">
                        <input type="radio" name="item_type" value="Barter" class="mt-0.5 accent-[#7b0f10]"
                               {{ old('item_type', 'Barter') == 'Barter' ? 'checked' : '' }} required>
                        <div>
                            <p class="font-bold text-sm text-gray-900"><i class="fas fa-exchange-alt mr-1 text-[#7b0f10]"></i> Barter</p>
                            <p class="text-xs text-gray-500 mt-0.5">Trade for another item</p>
                        </div>
                    </label>
                    <label class="flex items-start gap-3 border-2 border-gray-200 rounded-xl p-4 cursor-pointer transition"
                           id="label-donation">
                        <input type="radio" name="item_type" value="Donation" class="mt-0.5 accent-green-600"
                               {{ old('item_type') == 'Donation' ? 'checked' : '' }}>
                        <div>
                            <p class="font-bold text-sm text-gray-900"><i class="fas fa-gift mr-1 text-green-600"></i> Donation</p>
                            <p class="text-xs text-gray-500 mt-0.5">Give this item away for free</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Looking For (Barter only) -->
            <div id="barter-section">
                <label for="looking_for" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    What are you looking for in exchange?
                </label>
                <textarea id="looking_for" name="looking_for" rows="2"
                          placeholder="e.g., Programming books, Lab equipment, Electronics..."
                          class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm resize-none">{{ old('looking_for') }}</textarea>
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Item Photo</label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-[#7b0f10] transition cursor-pointer bg-gray-50"
                     onclick="document.getElementById('image').click()">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2 block"></i>
                    <p class="text-gray-600 font-semibold text-sm">Click to upload a photo</p>
                    <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 5MB</p>
                    <input type="file" id="image" name="image" accept="image/*" class="hidden"
                           onchange="previewImage(this)">
                </div>
                <!-- Preview -->
                <div id="image-preview" class="hidden mt-3">
                    <img id="preview-img" src="" alt="Preview" class="h-40 rounded-lg object-cover border border-gray-200">
                    <p class="text-xs text-gray-500 mt-1" id="preview-name"></p>
                </div>
                <p class="text-xs text-gray-400 mt-1.5">Optional — if no photo is uploaded, a placeholder will be used.</p>
            </div>

            <!-- Submit -->
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <a href="{{ route('items.browse') }}"
                   class="px-5 py-2.5 border border-gray-300 text-gray-600 font-semibold rounded-lg hover:bg-gray-50 transition text-sm">
                    Cancel
                </a>
                <button type="submit"
                        class="flex-1 py-2.5 text-white font-bold rounded-lg transition text-sm flex items-center justify-center gap-2"
                        style="background-color:#7b0f10;"
                        onmouseover="this.style.backgroundColor='#5a0a0b'"
                        onmouseout="this.style.backgroundColor='#7b0f10'">
                    <i class="fas fa-paper-plane text-xs"></i> Post Item
                </button>
            </div>

        </div>
    </form>
</div>

<script>
    // Toggle barter section
    document.querySelectorAll('input[name="item_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const barterSection = document.getElementById('barter-section');
            const labelBarter = document.getElementById('label-barter');
            const labelDonation = document.getElementById('label-donation');
            if (this.value === 'Barter') {
                barterSection.style.display = 'block';
                labelBarter.style.borderColor = '#7b0f10';
                labelBarter.style.background = 'rgba(123,15,16,0.04)';
                labelDonation.style.borderColor = '#e5e7eb';
                labelDonation.style.background = '';
            } else {
                barterSection.style.display = 'none';
                labelDonation.style.borderColor = '#16a34a';
                labelDonation.style.background = 'rgba(22,163,74,0.04)';
                labelBarter.style.borderColor = '#e5e7eb';
                labelBarter.style.background = '';
            }
        });
    });

    // Image preview
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('preview-name').textContent = input.files[0].name;
                document.getElementById('image-preview').classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
