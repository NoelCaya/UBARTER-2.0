@extends('layouts.master')

@section('title', 'Post a New Item')

@section('content')
<div class="p-6 md:p-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Post a New Item</h1>
        <p class="text-gray-600 mt-2">Share an item with the UB community.</p>
    </div>

    <div class="max-w-4xl">
        <form class="space-y-8">
            <!-- Progress Bar -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full font-bold">1</div>
                        <div class="h-1 bg-blue-600 flex-grow mx-4 w-24"></div>
                        <div class="flex items-center justify-center w-10 h-10 bg-blue-200 text-blue-600 rounded-full font-bold">2</div>
                        <div class="h-1 bg-gray-300 flex-grow mx-4 w-24"></div>
                        <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-bold">3</div>
                    </div>
                </div>
                <div class="flex justify-between text-xs font-medium text-gray-600">
                    <span class="text-blue-600">Basic Info</span>
                    <span class="text-blue-600">Details</span>
                    <span>Preview & Publish</span>
                </div>
            </div>

            <!-- Step 1: Basic Information -->
            <div class="bg-white rounded-xl shadow-sm p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Item Information</h2>

                <!-- Item Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">
                        Item Title *
                    </label>
                    <input type="text" id="title" name="title" placeholder="e.g., Advanced Calculus Textbook - 3rd Edition"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <p class="text-xs text-gray-600 mt-1">Be specific and clear about what you're posting</p>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                        Description *
                    </label>
                    <textarea id="description" name="description" rows="6" placeholder="Describe the item in detail. Include condition, any damages, usage history, etc."
                              class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              required></textarea>
                </div>

                <!-- Category Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-900 mb-2">
                            Category *
                        </label>
                        <select id="category" name="category" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
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
                        <label for="subcategory" class="block text-sm font-semibold text-gray-900 mb-2">
                            Subcategory
                        </label>
                        <select id="subcategory" name="subcategory" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select a subcategory</option>
                            <option value="textbooks">Textbooks</option>
                            <option value="fiction">Fiction & Literature</option>
                            <option value="reference">Reference Books</option>
                        </select>
                    </div>
                </div>

                <!-- Condition -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-3">
                        Item Condition *
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer hover:border-blue-600 transition">
                            <input type="radio" name="condition" value="new" class="w-4 h-4 text-blue-600" required>
                            <span class="block font-semibold text-gray-900 mt-2">Brand New</span>
                            <span class="text-xs text-gray-600">Never used, original packaging</span>
                        </label>
                        <label class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer hover:border-blue-600 transition">
                            <input type="radio" name="condition" value="slightly-used" class="w-4 h-4 text-blue-600" required>
                            <span class="block font-semibold text-gray-900 mt-2">Slightly Used</span>
                            <span class="text-xs text-gray-600">Used a few times, excellent condition</span>
                        </label>
                        <label class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer hover:border-blue-600 transition">
                            <input type="radio" name="condition" value="used" class="w-4 h-4 text-blue-600" required>
                            <span class="block font-semibold text-gray-900 mt-2">Used</span>
                            <span class="text-xs text-gray-600">Regular wear, fully functional</span>
                        </label>
                    </div>
                </div>

                <!-- Item Type -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-3">
                        Item Type *
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="border-2 border-blue-600 bg-blue-50 rounded-lg p-4 cursor-pointer transition">
                            <input type="radio" name="type" value="barter" class="w-4 h-4 text-blue-600" checked required>
                            <span class="block font-semibold text-gray-900 mt-2">
                                <i class="fas fa-exchange-alt mr-2 text-blue-600"></i>Barter
                            </span>
                            <span class="text-xs text-gray-600">I want to trade for other items</span>
                        </label>
                        <label class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer hover:border-blue-600 transition">
                            <input type="radio" name="type" value="donation" class="w-4 h-4 text-blue-600" required>
                            <span class="block font-semibold text-gray-900 mt-2">
                                <i class="fas fa-gift mr-2 text-green-600"></i>Donation
                            </span>
                            <span class="text-xs text-gray-600">I want to give this item away</span>
                        </label>
                    </div>
                </div>

                <!-- What I'm Looking For (Barter Only) -->
                <div id="barter-section" class="mb-6 pb-6 border-b border-gray-200">
                    <label for="looking-for" class="block text-sm font-semibold text-gray-900 mb-2">
                        What are you looking for in exchange? *
                    </label>
                    <textarea id="looking-for" name="looking_for" rows="4" placeholder="e.g., Programming books, Lab equipment, Electronics, etc."
                              class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <!-- Image Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-3">
                        Item Photos *
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-600 transition cursor-pointer" onclick="document.getElementById('images').click()">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3 block"></i>
                        <p class="text-gray-900 font-semibold mb-1">Drag and drop your images here</p>
                        <p class="text-sm text-gray-600">or click to browse</p>
                        <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF up to 10MB</p>
                        <input type="file" id="images" name="images" multiple accept="image/*" class="hidden">
                    </div>
                    <p class="text-xs text-gray-600 mt-2">Add at least 1 photo. The first photo will be the main image.</p>
                </div>

                <!-- Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="location" class="block text-sm font-semibold text-gray-900 mb-2">
                            Item Location *
                        </label>
                        <input type="text" id="location" name="location" placeholder="e.g., College of Engineering Building"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label for="delivery" class="block text-sm font-semibold text-gray-900 mb-2">
                            Delivery Option *
                        </label>
                        <select id="delivery" name="delivery" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Select option</option>
                            <option value="pickup">Pickup Only</option>
                            <option value="delivery">Delivery Only</option>
                            <option value="both">Either (Pickup or Delivery)</option>
                        </select>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <button type="button" class="px-6 py-3 border border-gray-300 text-gray-900 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Save as Draft
                    </button>
                    <button type="button" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                        <span>Continue to Next Step</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle barter section based on item type
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
