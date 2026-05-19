# UBarter Filters & API Implementation

## Overview

This document explains the implementation of browse filters and the complete API structure for the UBarter application.

---

## Browse Filters Implementation

### Location
- **View**: `resources/views/items/browse.blade.php`
- **Controller**: `app/Http/Controllers/ItemController.php`
- **Model**: `app/Models/Item.php`

### How Filters Work

#### 1. **Filter Form**
The browse page includes a filter sidebar with the following options:

```html
<!-- Search -->
<input type="text" name="search" placeholder="Search items...">

<!-- Item Type -->
<input type="radio" name="type" value="all"> All Items
<input type="radio" name="type" value="Barter"> Barter
<input type="radio" name="type" value="Donation"> Donation

<!-- Category -->
<input type="radio" name="category" value="all"> All
<input type="radio" name="category" value="Electronics"> Electronics
<!-- ... more categories ... -->

<!-- Condition -->
<input type="radio" name="condition" value="all"> All
<input type="radio" name="condition" value="New"> New
<input type="radio" name="condition" value="Slightly Used"> Slightly Used
<input type="radio" name="condition" value="Used"> Used

<!-- Sort -->
<select name="sort">
  <option value="newest">Newest</option>
  <option value="most_viewed">Most Popular</option>
  <option value="highest_rated">Highest Rated</option>
  <option value="most_wishlisted">Most Wishlisted</option>
</select>
```

#### 2. **Backend Processing**
When filters are applied, the form submits to `/items/browse` with query parameters:

```
GET /items/browse?search=laptop&category=Electronics&type=Barter&condition=New&sort=newest
```

#### 3. **Controller Logic**
The `ItemController::browse()` method processes the filters:

```php
public function browse(Request $request)
{
    $query = Item::active();

    // Apply search filter
    if ($request->search) {
        $query->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
    }

    // Apply category filter
    if ($request->category && $request->category != 'all') {
        $query->where('category', $request->category);
    }

    // Apply type filter
    if ($request->type && $request->type != 'all') {
        $query->where('item_type', $request->type);
    }

    // Apply condition filter
    if ($request->condition && $request->condition != 'all') {
        $query->where('condition', $request->condition);
    }

    // Apply sorting
    $sort = $request->sort ?? 'newest';
    switch ($sort) {
        case 'newest':
            $query->newest();
            break;
        case 'most_viewed':
            $query->mostViewed();
            break;
        case 'highest_rated':
            $query->highestRated();
            break;
        case 'most_wishlisted':
            $query->orderBy('wishlist_count', 'desc');
            break;
    }

    // Paginate results
    $items = $query->with('user')->paginate(20);

    return view('items.browse', [
        'items' => $items,
        'currentFilters' => [
            'search' => $request->search ?? '',
            'type' => $request->type ?? 'all',
            'category' => $request->category ?? 'all',
            'condition' => $request->condition ?? 'all',
            'sort' => $sort,
        ]
    ]);
}
```

#### 4. **Model Scopes**
The Item model includes query scopes for filtering:

```php
// Get active items only
public function scopeActive($query)
{
    return $query->where('status', 'Active');
}

// Sort by newest
public function scopeNewest($query)
{
    return $query->orderBy('posted_at', 'desc');
}

// Sort by most viewed
public function scopeMostViewed($query)
{
    return $query->orderBy('views', 'desc');
}

// Sort by highest rated
public function scopeHighestRated($query)
{
    return $query->orderBy('seller_rating', 'desc');
}
```

### Filter Categories

The available categories are dynamically fetched from the database:

```php
$categories = Item::distinct()->pluck('category')->sort();
```

Current categories include:
- Books & Textbooks
- Uniforms & Apparel
- Lab Supplies
- Electronics
- Furniture
- Art & Craft Supplies
- Office Supplies
- Sports Equipment
- General

---

## API Implementation

### API Base URL
```
http://localhost:8000/api
```

### Authentication
The API uses Laravel Sanctum for token-based authentication:

```
Authorization: Bearer {token}
```

### Response Format
All API responses follow a consistent JSON format:

```json
{
  "success": true,
  "message": "Optional message",
  "data": {},
  "pagination": {
    "total": 100,
    "per_page": 20,
    "current_page": 1,
    "last_page": 5
  }
}
```

---

## API Endpoints

### Items API

#### Get All Items
```
GET /api/items
```

**Query Parameters**:
- `search` (string) - Search by title or description
- `category` (string) - Filter by category
- `type` (string) - Filter by type (Barter/Donation)
- `condition` (string) - Filter by condition
- `sort` (string) - Sort by (newest/most_viewed/highest_rated/most_wishlisted)
- `per_page` (integer) - Items per page (default: 20)
- `page` (integer) - Page number

**Example**:
```
GET /api/items?category=Electronics&sort=newest&per_page=10
```

**Response**:
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Laptop",
      "description": "...",
      "category": "Electronics",
      "condition": "New",
      "item_type": "Barter",
      "image_url": "...",
      "views": 150,
      "wishlist_count": 5,
      "seller_rating": 4.5,
      "user": { ... }
    }
  ],
  "pagination": { ... }
}
```

#### Get Item Details
```
GET /api/items/{id}
```

**Response**:
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Laptop",
    "description": "...",
    "category": "Electronics",
    "condition": "New",
    "item_type": "Barter",
    "image_url": "...",
    "views": 151,
    "wishlist_count": 5,
    "seller_rating": 4.5,
    "user": { ... }
  },
  "related_items": [ ... ]
}
```

#### Create Item
```
POST /api/items
```

**Authentication**: Required

**Request Body**:
```json
{
  "title": "Laptop",
  "description": "High-performance laptop",
  "category": "Electronics",
  "condition": "New",
  "item_type": "Barter",
  "image_url": "https://example.com/image.jpg"
}
```

**Response**:
```json
{
  "success": true,
  "message": "Item created successfully",
  "data": { ... }
}
```

#### Update Item
```
PATCH /api/items/{id}
```

**Authentication**: Required (must be item owner)

**Request Body**: Same as create (all fields optional)

#### Delete Item
```
DELETE /api/items/{id}
```

**Authentication**: Required (must be item owner)

#### Search Items
```
GET /api/items/search
```

**Query Parameters**:
- `q` (string) - Search query
- `category` (string) - Filter by category
- `type` (string) - Filter by type
- `condition` (string) - Filter by condition
- `per_page` (integer) - Items per page
- `page` (integer) - Page number

#### Get Filter Options
```
GET /api/items/filters
```

**Response**:
```json
{
  "success": true,
  "data": {
    "categories": ["Electronics", "Books", ...],
    "conditions": ["New", "Slightly Used", "Used"],
    "types": ["Barter", "Donation"]
  }
}
```

---

### Users API

#### Get Current User
```
GET /api/user
```

**Authentication**: Required

#### Update User Profile
```
PATCH /api/user
```

**Authentication**: Required

**Request Body**:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "bio": "Student at UB",
  "avatar_url": "https://example.com/avatar.jpg",
  "phone": "+1234567890"
}
```

#### Get User Profile
```
GET /api/users/{id}
```

#### Get User's Items
```
GET /api/users/{id}/items
```

#### Get User's Rating
```
GET /api/users/{id}/rating
```

**Response**:
```json
{
  "success": true,
  "data": {
    "average_rating": 4.5,
    "total_reviews": 10,
    "reviews": [ ... ]
  }
}
```

---

### Wishlist API

#### Get Wishlist
```
GET /api/wishlist
```

**Authentication**: Required

#### Add to Wishlist
```
POST /api/wishlist/{item_id}
```

**Authentication**: Required

#### Remove from Wishlist
```
DELETE /api/wishlist/{item_id}
```

**Authentication**: Required

#### Check if in Wishlist
```
GET /api/wishlist/check/{item_id}
```

**Authentication**: Required

**Response**:
```json
{
  "success": true,
  "in_wishlist": true
}
```

---

### Reviews API

#### Get Item Reviews
```
GET /api/items/{item_id}/reviews
```

#### Create Review
```
POST /api/items/{item_id}/reviews
```

**Authentication**: Required

**Request Body**:
```json
{
  "rating": 5,
  "comment": "Great item!"
}
```

#### Update Review
```
PATCH /api/reviews/{review_id}
```

**Authentication**: Required (must be review author)

#### Delete Review
```
DELETE /api/reviews/{review_id}
```

**Authentication**: Required (must be review author)

#### Get My Reviews
```
GET /api/reviews/my
```

**Authentication**: Required

---

### Trades API

#### Get My Trades
```
GET /api/trades
```

**Authentication**: Required

#### Create Trade Request
```
POST /api/trades
```

**Authentication**: Required

**Request Body**:
```json
{
  "initiator_item_id": 1,
  "receiver_item_id": 2,
  "receiver_id": 3,
  "message": "I'd like to trade with you!"
}
```

#### Get Trade Details
```
GET /api/trades/{trade_id}
```

**Authentication**: Required

#### Update Trade Status
```
PATCH /api/trades/{trade_id}
```

**Authentication**: Required (must be receiver)

**Request Body**:
```json
{
  "status": "Accepted"
}
```

Valid statuses: `Accepted`, `Rejected`, `Completed`, `Cancelled`

#### Cancel Trade
```
POST /api/trades/{trade_id}/cancel
```

**Authentication**: Required

---

## Using the Filters

### Via Web Interface

1. Navigate to `/items/browse`
2. Use the filter sidebar:
   - Enter search keywords
   - Select item type
   - Choose category
   - Pick condition
3. Click "Apply" to apply filters
4. Use sort dropdown to change sorting
5. Click "Reset" to clear filters

### Via API

```javascript
// Example: Get electronics items sorted by newest
fetch('http://localhost:8000/api/items?category=Electronics&sort=newest')
  .then(response => response.json())
  .then(data => console.log(data));
```

---

## Database Queries

### Get Active Items
```php
$items = Item::active()->get();
```

### Get Items by Category
```php
$items = Item::where('category', 'Electronics')->get();
```

### Search Items
```php
$items = Item::where('title', 'like', '%laptop%')
    ->orWhere('description', 'like', '%laptop%')
    ->get();
```

### Get Most Viewed Items
```php
$items = Item::mostViewed()->get();
```

### Get Highest Rated Items
```php
$items = Item::highestRated()->get();
```

### Get Most Wishlisted Items
```php
$items = Item::orderBy('wishlist_count', 'desc')->get();
```

---

## Performance Optimization

### Database Indexes
The following columns are indexed for faster queries:
- `user_id`
- `category`
- `item_type`
- `status`
- `posted_at`

### Pagination
All list endpoints use pagination to reduce memory usage:
- Default: 20 items per page
- Configurable via `per_page` parameter
- Maximum: 100 items per page (recommended)

### Eager Loading
Related data is loaded efficiently:
```php
$items = Item::with('user', 'reviews')->get();
```

### Caching
Consider caching frequently accessed data:
```php
$categories = Cache::remember('item.categories', 3600, function () {
    return Item::distinct()->pluck('category');
});
```

---

## Error Handling

### Common Errors

**400 Bad Request**
```json
{
  "success": false,
  "message": "Validation error message"
}
```

**401 Unauthorized**
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

**403 Forbidden**
```json
{
  "success": false,
  "message": "Unauthorized"
}
```

**404 Not Found**
```json
{
  "success": false,
  "message": "Resource not found"
}
```

**409 Conflict**
```json
{
  "success": false,
  "message": "Item already in wishlist"
}
```

---

## Testing

### Using cURL
```bash
# Get all items
curl -X GET "http://localhost:8000/api/items"

# Get items with filters
curl -X GET "http://localhost:8000/api/items?category=Electronics&sort=newest"

# Create item (requires token)
curl -X POST "http://localhost:8000/api/items" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Test Item",
    "description": "Test Description",
    "category": "Electronics",
    "condition": "New",
    "item_type": "Barter"
  }'
```

### Using Postman
1. Import the API collection
2. Set up environment variables
3. Test each endpoint
4. Save requests for future use

### Using Browser Console
```javascript
// Get all items
fetch('http://localhost:8000/api/items')
  .then(r => r.json())
  .then(d => console.log(d));

// Get items with filters
fetch('http://localhost:8000/api/items?category=Electronics&sort=newest')
  .then(r => r.json())
  .then(d => console.log(d));
```

---

## Summary

The UBarter application now has:
- ✅ Fully functional browse filters
- ✅ Complete API endpoints for all resources
- ✅ Proper error handling and validation
- ✅ Pagination support
- ✅ Authentication with Sanctum
- ✅ Database optimization with indexes
- ✅ Comprehensive documentation

The application is ready for frontend integration and production deployment.

---

**Last Updated**: May 19, 2026
**Status**: Complete and Ready for Integration
