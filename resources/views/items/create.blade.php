@extends('layouts.master')

@section('title', 'Post a New Item')

@section('content')
<div class="px-4 md:px-6 py-6 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Post a New Item</h1>
        <p class="text-gray-500 mt-1 text-sm">Share an item with the UB community.</p>
    </div>

    <form class="space-y-5">
        <!-- Progress Bar -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="flex items-center mb-3">
                <div class="flex items-center justify-center w-9 h-9 bg-[#7b0f10] text-white rounded-full font-bold text-sm flex-shrink-0">1</div>
                <div class="h-1 bg-[#7b0f10] flex-grow mx-3"></div>
                <div class="flex items-center justify-center w-9 h-9 bg-[#7b0f10]/20 text-[#7b0f10] rounded-full font-bold text-sm flex-shrink-0">2</div>
                <div class="h-1 bg-gray-200 flex-grow mx-3"></div>
                <div class="flex items-center justify-center w-9 h-9 bg-gray-200 text-gray-500 rounded-full font-bold text-sm flex-shrink-0">3</div>
            </div>
            <div class="flex justify-between text-xs font-semibold">
                <span class="text-[#7b0f10]">Basic Info</span>
                <span class="text-[#7b0f10]/60">Details</span>
                <span class="text-gray-400">Preview & Publish</span>
            </div>
        </div>

        <!-- Step 1: Basic Information -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-5">Item Information</h2>

            <!-- Item Title -->
            <div class="mb-5">
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1.5">Item Title *</label>
                <input type="text" id="title" name="title" placeholder="e.g., Advanced Calculus Textbook - 3rd Edition"
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm" required>
                <p class="text-xs text-gray-400 mt-1">Be specific and clear about what you're posting</p>
            </div>

            <!-- Description -->
            <div class="mb-5">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">Description *</label>
                <textarea id="description" name="description" rows="5" placeholder="Describe the item in detail. Include condition, any damages, usage history, etc."
                          class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm resize-none"
                          required></textarea>
            </div>

            <!-- Category Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-1.5">Category *</label>
                    <select id="category" name="category" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm" required>
                        <option value="">Select a category</option>
                        <option value="books">Books & Textbooks</option>
                        <option value="uniforms">Uniforms & Apparel</option>
                        <option value="lab">Lab Supplies & Equipment</option>
                        <option value="electronics">Electronics & Gadgets</option>
                        <option value="furniture">Furniture</option>
                        <option value="art">Art & Craft Supplies</option>
                        <option value="sports">Sports Equipment</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="subcategory" class="block text-sm font-semibold text-gray-700 mb-1.5">Subcategory</label>
                    <select id="subcategory" name="subcategory" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm">
                        <option value="">Select a subcategory</option>
                        <option value="textbooks">Textbooks</option>
                        <option value="fiction">Fiction & Literature</option>
                        <option value="reference">Reference Books</option>
                    </select>
                </div>
            </div>

            <!-- Condition -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Item Condition *</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="border-2 border-gray-200 rounded-lg p-3.5 cursor-pointer hover:border-[#7b0f10] transition has-[:checked]:border-[#7b0f10] has-[:checked]:bg-[#7b0f10]/5">
                        <input type="radio" name="condition" value="new" class="w-4 h-4 accent-[#7b0f10]" required>
                        <span class="block font-semibold text-gray-900 mt-1.5 text-sm">Brand New</span>
                        <span class="text-xs text-gray-500">Never used, original packaging</span>
                    </label>
                    <label class="border-2 border-gray-200 rounded-lg p-3.5 cursor-pointer hover:border-[#7b0f10] transition has-[:checked]:border-[#7b0f10] has-[:checked]:bg-[#7b0f10]/5">
                        <input type="radio" name="condition" value="slightly-used" class="w-4 h-4 accent-[#7b0f10]">
                        <span class="block font-semibold text-gray-900 mt-1.5 text-sm">Slightly Used</span>
                        <span class="text-xs text-gray-500">Used a few times, excellent condition</span>
                    </label>
                    <label class="border-2 border-gray-200 rounded-lg p-3.5 cursor-pointer hover:border-[#7b0f10] transition has-[:checked]:border-[#7b0f10] has-[:checked]:bg-[#7b0f10]/5">
                        <input type="radio" name="condition" value="used" class="w-4 h-4 accent-[#7b0f10]">
                        <span class="block font-semibold text-gray-900 mt-1.5 text-sm">Used</span>
                        <span class="text-xs text-gray-500">Regular wear, fully functional</span>
                    </label>
                </div>
            </div>

            <!-- Item Type -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Item Type *</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="border-2 border-[#7b0f10] bg-[#7b0f10]/5 rounded-lg p-3.5 cursor-pointer transition">
                        <input type="radio" name="type" value="barter" class="w-4 h-4 accent-[#7b0f10]" checked required>
                        <span class="block font-semibold text-gray-900 mt-1.5 text-sm">
                            <i class="fas fa-exchange-alt mr-1.5 text-[#7b0f10]"></i>Barter
                        </span>
                        <span class="text-xs text-gray-500">I want to trade for other items</span>
                    </label>
                    <label class="border-2 border-gray-200 rounded-lg p-3.5 cursor-pointer hover:border-green-500 transition has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                        <input type="radio" name="type" value="donation" class="w-4 h-4 accent-green-600">
                        <span class="block font-semibold text-gray-900 mt-1.5 text-sm">
                            <i class="fas fa-gift mr-1.5 text-green-600"></i>Donation
                        </span>
                        <span class="text-xs text-gray-500">I want to give this item away</span>
                    </label>
                </div>
            </div>

            <!-- What I'm Looking For (Barter Only) -->
            <div id="barter-section" class="mb-5 pb-5 border-b border-gray-100">
                <label for="looking-for" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    What are you looking for in exchange? *
                </label>
                <textarea id="looking-for" name="looking_for" rows="3" placeholder="e.g., Programming books, Lab equipment, Electronics, etc."
                          class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm resize-none"></textarea>
            </div>

            <!-- Image Upload -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Item Photos *</label>
                <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center hover:border-[#7b0f10] transition cursor-pointer bg-gray-50 hover:bg-[#7b0f10]/5" onclick="document.getElementById('images').click()">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2 block"></i>
                    <p class="text-gray-700 font-semibold text-sm mb-0.5">Drag and drop your images here</p>
                    <p class="text-xs text-gray-400">or click to browse · PNG, JPG up to 10MB</p>
                    <input type="file" id="images" name="images" multiple accept="image/*" class="hidden">
                </div>
                <p class="text-xs text-gray-400 mt-1.5">Add at least 1 photo. The first photo will be the main image.</p>
            </div>

            <!-- Location & Delivery -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="location" class="block text-sm font-semibold text-gray-700 mb-1.5">Item Location *</label>
                    <input type="text" id="location" name="location" placeholder="e.g., College of Engineering Building"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm" required>
                </div>
                <div>
                    <label for="delivery" class="block text-sm font-semibold text-gray-700 mb-1.5">Delivery Option *</label>
                    <select id="delivery" name="delivery" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm" required>
                        <option value="">Select option</option>
                        <option value="pickup">Pickup Only</option>
                        <option value="delivery">Delivery Only</option>
                        <option value="both">Either (Pickup or Delivery)</option>
                    </select>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between pt-5 border-t border-gray-100">
                <button type="button" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition text-sm">
                    Save as Draft
                </button>
                <button type="button" class="px-5 py-2.5 text-white font-semibold rounded-lg transition text-sm flex items-center gap-2" style="background-color: #7b0f10;" onmouseover="this.style.backgroundColor='#5a0a0b'" onmouseout="this.style.backgroundColor='#7b0f10'">
                    Continue to Next Step <i class="fas fa-arrow-right text-xs"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const barterSection = document.getElementById('barter-section');
            const lookingFor = document.getElementById('looking-for');
            if (this.value === 'barter') {
                barterSection.style.display = 'block';
                lookingFor.required = true;
            } else {
                barterSection.style.display = 'none';
                lookingFor.required = false;
            }
        });
    });
</script>
@endsection
