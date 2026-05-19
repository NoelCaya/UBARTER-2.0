# Backend Integration Guide

## Overview
This guide explains how to integrate the UBarter frontend with the backend API. The application is now ready for full backend integration with all necessary API endpoints implemented.

## Current Status

### ✅ Completed
- [x] Database schema and migrations
- [x] Models with relationships
- [x] API endpoints for all resources
- [x] Authentication with Laravel Sanctum
- [x] Filter and search functionality
- [x] Pagination support
- [x] Error handling and validation
- [x] Browse page with working filters

### 🔄 In Progress
- [ ] Frontend API integration (JavaScript/Vue)
- [ ] Real-time notifications
- [ ] File upload functionality
- [ ] WebSocket implementation for chat

### 📋 To Do
- [ ] Admin dashboard
- [ ] Advanced analytics
- [ ] Email notifications
- [ ] SMS notifications
- [ ] Payment integration (if needed)

---

## API Endpoints Summary

### Items
- `GET /api/items` - List all items with filters
- `GET /api/items/{id}` - Get item details
- `POST /api/items` - Create new item
- `PATCH /api/items/{id}` - Update item
- `DELETE /api/items/{id}` - Delete item
- `GET /api/items/search` - Search items
- `GET /api/items/filters` - Get filter options

### Users
- `GET /api/user` - Get current user
- `PATCH /api/user` - Update profile
- `GET /api/users/{id}` - Get user profile
- `GET /api/users/{id}/items` - Get user's items
- `GET /api/users/{id}/rating` - Get user's rating

### Wishlist
- `GET /api/wishlist` - Get wishlist
- `POST /api/wishlist/{item_id}` - Add to wishlist
- `DELETE /api/wishlist/{item_id}` - Remove from wishlist
- `GET /api/wishlist/check/{item_id}` - Check if in wishlist

### Reviews
- `GET /api/items/{item_id}/reviews` - Get item reviews
- `POST /api/items/{item_id}/reviews` - Create review
- `PATCH /api/reviews/{id}` - Update review
- `DELETE /api/reviews/{id}` - Delete review
- `GET /api/reviews/my` - Get my reviews

### Trades
- `GET /api/trades` - Get my trades
- `POST /api/trades` - Create trade request
- `GET /api/trades/{id}` - Get trade details
- `PATCH /api/trades/{id}` - Update trade status
- `POST /api/trades/{id}/cancel` - Cancel trade

---

## Frontend Integration Steps

### 1. Set Up API Client
Create a JavaScript/Vue API client to handle all API requests:

```javascript
// api/client.js
const API_BASE_URL = 'http://localhost:8000/api';

class ApiClient {
  constructor() {
    this.token = localStorage.getItem('auth_token');
  }

  async request(method, endpoint, data = null) {
    const options = {
      method,
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${this.token}`
      }
    };

    if (data) {
      options.body = JSON.stringify(data);
    }

    const response = await fetch(`${API_BASE_URL}${endpoint}`, options);
    return response.json();
  }

  // Items
  getItems(filters = {}) {
    const params = new URLSearchParams(filters);
    return this.request('GET', `/items?${params}`);
  }

  getItem(id) {
    return this.request('GET', `/items/${id}`);
  }

  createItem(data) {
    return this.request('POST', '/items', data);
  }

  updateItem(id, data) {
    return this.request('PATCH', `/items/${id}`, data);
  }

  deleteItem(id) {
    return this.request('DELETE', `/items/${id}`);
  }

  // Wishlist
  getWishlist() {
    return this.request('GET', '/wishlist');
  }

  addToWishlist(itemId) {
    return this.request('POST', `/wishlist/${itemId}`);
  }

  removeFromWishlist(itemId) {
    return this.request('DELETE', `/wishlist/${itemId}`);
  }

  // Reviews
  getItemReviews(itemId) {
    return this.request('GET', `/items/${itemId}/reviews`);
  }

  createReview(itemId, data) {
    return this.request('POST', `/items/${itemId}/reviews`, data);
  }

  // Trades
  getTrades() {
    return this.request('GET', '/trades');
  }

  createTrade(data) {
    return this.request('POST', '/trades', data);
  }

  updateTrade(id, data) {
    return this.request('PATCH', `/trades/${id}`, data);
  }
}

export default new ApiClient();
```

### 2. Update Browse Page
Replace hardcoded data with API calls:

```javascript
// In browse.blade.php or Vue component
async function loadItems() {
  const filters = {
    search: document.querySelector('[name="search"]').value,
    category: document.querySelector('[name="category"]').value,
    type: document.querySelector('[name="type"]').value,
    condition: document.querySelector('[name="condition"]').value,
    sort: document.querySelector('[name="sort"]').value,
    per_page: 20
  };

  const response = await apiClient.getItems(filters);
  
  if (response.success) {
    displayItems(response.data);
    updatePagination(response.pagination);
  }
}
```

### 3. Update Item Creation
Replace form submission with API call:

```javascript
async function submitItemForm(formData) {
  const response = await apiClient.createItem({
    title: formData.title,
    description: formData.description,
    category: formData.category,
    condition: formData.condition,
    item_type: formData.item_type,
    image_url: formData.image_url
  });

  if (response.success) {
    showSuccessMessage('Item posted successfully!');
    redirectToBrowse();
  } else {
    showErrorMessage(response.message);
  }
}
```

### 4. Implement Wishlist Functionality
Add wishlist buttons to item cards:

```javascript
async function toggleWishlist(itemId) {
  const isInWishlist = await checkWishlist(itemId);
  
  if (isInWishlist) {
    await apiClient.removeFromWishlist(itemId);
  } else {
    await apiClient.addToWishlist(itemId);
  }
  
  updateWishlistButton(itemId);
}
```

### 5. Implement Reviews
Add review functionality to item details page:

```javascript
async function submitReview(itemId, rating, comment) {
  const response = await apiClient.createReview(itemId, {
    rating,
    comment
  });

  if (response.success) {
    showSuccessMessage('Review posted successfully!');
    loadItemReviews(itemId);
  }
}
```

### 6. Implement Trades
Add trade request functionality:

```javascript
async function initiateTradeRequest(initiatorItemId, receiverItemId, receiverId) {
  const response = await apiClient.createTrade({
    initiator_item_id: initiatorItemId,
    receiver_item_id: receiverItemId,
    receiver_id: receiverId,
    message: 'I would like to trade with you!'
  });

  if (response.success) {
    showSuccessMessage('Trade request sent!');
  }
}
```

---

## Database Models

### Item
```
- id (primary key)
- user_id (foreign key)
- title
- description
- category
- condition (enum: New, Slightly Used, Used)
- item_type (enum: Barter, Donation)
- image_url
- views (counter)
- wishlist_count (counter)
- rating
- seller_rating
- status (enum: Active, Pending, Traded, Archived)
- posted_at
- created_at
- updated_at
```

### User
```
- id (primary key)
- name
- email
- password
- google_id
- google_email
- avatar_url
- bio
- phone
- rating
- trades_count
- email_verified_at
- created_at
- updated_at
```

### Wishlist
```
- id (primary key)
- user_id (foreign key)
- item_id (foreign key)
- created_at
- updated_at
```

### Review
```
- id (primary key)
- reviewer_id (foreign key)
- reviewee_id (foreign key)
- item_id (foreign key)
- trade_id (foreign key, nullable)
- rating (1-5)
- comment
- created_at
- updated_at
```

### Trade
```
- id (primary key)
- initiator_id (foreign key)
- receiver_id (foreign key)
- initiator_item_id (foreign key)
- receiver_item_id (foreign key)
- status (enum: Pending, Accepted, Rejected, Completed, Cancelled)
- message
- created_at
- updated_at
```

---

## Authentication Flow

### 1. Login
```
POST /login
{
  "email": "user@example.com",
  "password": "password"
}

Response:
{
  "token": "auth_token",
  "user": { ... }
}
```

### 2. Store Token
```javascript
localStorage.setItem('auth_token', response.token);
```

### 3. Use Token in Requests
```javascript
headers: {
  'Authorization': `Bearer ${token}`
}
```

### 4. Logout
```javascript
localStorage.removeItem('auth_token');
```

---

## Error Handling

### Common Error Codes
- `400` - Bad Request (validation error)
- `401` - Unauthorized (not authenticated)
- `403` - Forbidden (not authorized)
- `404` - Not Found (resource doesn't exist)
- `409` - Conflict (duplicate entry)
- `500` - Server Error

### Error Response Format
```json
{
  "success": false,
  "message": "Error message"
}
```

### Handling Errors
```javascript
async function handleApiCall(apiFunction) {
  try {
    const response = await apiFunction();
    
    if (!response.success) {
      showErrorMessage(response.message);
      return null;
    }
    
    return response.data;
  } catch (error) {
    showErrorMessage('Network error. Please try again.');
    console.error(error);
    return null;
  }
}
```

---

## Testing the API

### Using cURL
```bash
# Get all items
curl -X GET "http://localhost:8000/api/items"

# Get item details
curl -X GET "http://localhost:8000/api/items/1"

# Create item (requires authentication)
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
2. Set up environment variables for base URL and token
3. Test each endpoint
4. Save requests for future use

---

## Performance Optimization

### 1. Pagination
Always use pagination for list endpoints:
```
GET /api/items?per_page=20&page=1
```

### 2. Eager Loading
Use eager loading to reduce database queries:
```php
Item::with('user', 'reviews')->get();
```

### 3. Caching
Implement caching for frequently accessed data:
```php
Cache::remember('items.filters', 3600, function () {
    return Item::distinct()->pluck('category');
});
```

### 4. Database Indexing
Ensure proper indexes on frequently queried columns:
- `user_id`
- `category`
- `item_type`
- `status`
- `posted_at`

---

## Security Considerations

### 1. CORS
Configure CORS in `config/cors.php`:
```php
'allowed_origins' => ['http://localhost:3000', 'https://ubarter.com'],
```

### 2. Rate Limiting
Implement rate limiting to prevent abuse:
```php
Route::middleware('throttle:60,1')->group(function () {
    // API routes
});
```

### 3. Input Validation
Always validate user input:
```php
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'required|string|max:1000',
]);
```

### 4. Authorization
Check user authorization before modifying resources:
```php
if ($item->user_id !== auth()->id()) {
    return response()->json(['success' => false], 403);
}
```

### 5. HTTPS
Always use HTTPS in production.

---

## Deployment Checklist

- [ ] Set up production database
- [ ] Configure environment variables
- [ ] Enable HTTPS
- [ ] Set up CORS for production domain
- [ ] Configure email notifications
- [ ] Set up file storage
- [ ] Enable caching
- [ ] Set up monitoring and logging
- [ ] Configure backups
- [ ] Test all API endpoints
- [ ] Load testing
- [ ] Security audit

---

## Support and Troubleshooting

### Common Issues

**Issue**: 401 Unauthorized
- **Solution**: Ensure token is included in Authorization header

**Issue**: 404 Not Found
- **Solution**: Check endpoint URL and resource ID

**Issue**: 422 Unprocessable Entity
- **Solution**: Check request body for validation errors

**Issue**: 500 Server Error
- **Solution**: Check server logs for detailed error message

### Getting Help
- Check API documentation
- Review error messages
- Check server logs
- Contact development team

---

## Next Steps

1. Set up frontend API client
2. Update browse page to use API
3. Implement authentication flow
4. Add wishlist functionality
5. Implement reviews
6. Add trade functionality
7. Set up real-time notifications
8. Implement file uploads
9. Add admin dashboard
10. Deploy to production
