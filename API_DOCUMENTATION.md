# UBarter API Documentation

## Base URL
```
http://localhost:8000/api
```

## Authentication
The API uses Laravel Sanctum for authentication. Include the token in the `Authorization` header:
```
Authorization: Bearer {token}
```

## Response Format
All responses are in JSON format with the following structure:
```json
{
  "success": true/false,
  "message": "Optional message",
  "data": {},
  "pagination": {}
}
```

---

## Endpoints

### Health Check
- **GET** `/health`
- **Description**: Check if API is running
- **Authentication**: Not required
- **Response**:
```json
{
  "status": "ok",
  "message": "API is running"
}
```

---

## Items

### Get All Items
- **GET** `/items`
- **Authentication**: Not required
- **Query Parameters**:
  - `search` (string): Search by title or description
  - `category` (string): Filter by category
  - `type` (string): Filter by type (Barter/Donation)
  - `condition` (string): Filter by condition (New/Slightly Used/Used)
  - `sort` (string): Sort by (newest/most_viewed/highest_rated/most_wishlisted)
  - `per_page` (integer): Items per page (default: 20)
  - `page` (integer): Page number

**Example**:
```
GET /items?category=Electronics&sort=newest&per_page=10
```

### Get Item Details
- **GET** `/items/{id}`
- **Authentication**: Not required
- **Response**: Item object with user details and related items

### Create Item
- **POST** `/items`
- **Authentication**: Required
- **Request Body**:
```json
{
  "title": "string",
  "description": "string",
  "category": "string",
  "condition": "New|Slightly Used|Used",
  "item_type": "Barter|Donation",
  "image_url": "url (optional)"
}
```

### Update Item
- **PATCH** `/items/{id}`
- **Authentication**: Required (must be item owner)
- **Request Body**: Same as create (all fields optional)

### Delete Item
- **DELETE** `/items/{id}`
- **Authentication**: Required (must be item owner)

### Search Items
- **GET** `/items/search`
- **Authentication**: Not required
- **Query Parameters**:
  - `q` (string): Search query
  - `category` (string): Filter by category
  - `type` (string): Filter by type
  - `condition` (string): Filter by condition
  - `per_page` (integer): Items per page
  - `page` (integer): Page number

### Get Filter Options
- **GET** `/items/filters`
- **Authentication**: Not required
- **Response**:
```json
{
  "success": true,
  "data": {
    "categories": ["Books & Textbooks", "Electronics", ...],
    "conditions": ["New", "Slightly Used", "Used"],
    "types": ["Barter", "Donation"]
  }
}
```

---

## Users

### Get Current User
- **GET** `/user`
- **Authentication**: Required
- **Response**: Current user object

### Update User Profile
- **PATCH** `/user`
- **Authentication**: Required
- **Request Body**:
```json
{
  "name": "string (optional)",
  "email": "email (optional)",
  "bio": "string (optional)",
  "avatar_url": "url (optional)",
  "phone": "string (optional)"
}
```

### Get User Profile
- **GET** `/users/{id}`
- **Authentication**: Not required
- **Response**: User object with stats

### Get User's Items
- **GET** `/users/{id}/items`
- **Authentication**: Not required
- **Query Parameters**:
  - `per_page` (integer): Items per page
  - `page` (integer): Page number

### Get User's Rating
- **GET** `/users/{id}/rating`
- **Authentication**: Not required
- **Response**:
```json
{
  "success": true,
  "data": {
    "average_rating": 4.5,
    "total_reviews": 10,
    "reviews": [...]
  },
  "pagination": {}
}
```

---

## Wishlist

### Get Wishlist
- **GET** `/wishlist`
- **Authentication**: Required
- **Query Parameters**:
  - `per_page` (integer): Items per page
  - `page` (integer): Page number

### Add to Wishlist
- **POST** `/wishlist/{item_id}`
- **Authentication**: Required
- **Response**: Success message

### Remove from Wishlist
- **DELETE** `/wishlist/{item_id}`
- **Authentication**: Required
- **Response**: Success message

### Check if in Wishlist
- **GET** `/wishlist/check/{item_id}`
- **Authentication**: Required
- **Response**:
```json
{
  "success": true,
  "in_wishlist": true/false
}
```

---

## Reviews

### Get Item Reviews
- **GET** `/items/{item_id}/reviews`
- **Authentication**: Not required
- **Query Parameters**:
  - `per_page` (integer): Reviews per page
  - `page` (integer): Page number

### Create Review
- **POST** `/items/{item_id}/reviews`
- **Authentication**: Required
- **Request Body**:
```json
{
  "rating": 1-5,
  "comment": "string"
}
```

### Update Review
- **PATCH** `/reviews/{review_id}`
- **Authentication**: Required (must be review author)
- **Request Body**:
```json
{
  "rating": 1-5 (optional),
  "comment": "string (optional)"
}
```

### Delete Review
- **DELETE** `/reviews/{review_id}`
- **Authentication**: Required (must be review author)

### Get My Reviews
- **GET** `/reviews/my`
- **Authentication**: Required
- **Query Parameters**:
  - `per_page` (integer): Reviews per page
  - `page` (integer): Page number

---

## Trades

### Get My Trades
- **GET** `/trades`
- **Authentication**: Required
- **Query Parameters**:
  - `per_page` (integer): Trades per page
  - `page` (integer): Page number

### Get Trade Details
- **GET** `/trades/{trade_id}`
- **Authentication**: Required (must be involved in trade)

### Create Trade Request
- **POST** `/trades`
- **Authentication**: Required
- **Request Body**:
```json
{
  "initiator_item_id": integer,
  "receiver_item_id": integer,
  "receiver_id": integer,
  "message": "string (optional)"
}
```

### Update Trade Status
- **PATCH** `/trades/{trade_id}`
- **Authentication**: Required (must be receiver)
- **Request Body**:
```json
{
  "status": "Accepted|Rejected|Completed|Cancelled"
}
```

### Cancel Trade
- **POST** `/trades/{trade_id}/cancel`
- **Authentication**: Required (must be involved in trade)
- **Response**: Success message

---

## Error Responses

### 400 Bad Request
```json
{
  "success": false,
  "message": "Validation error message"
}
```

### 401 Unauthorized
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

### 403 Forbidden
```json
{
  "success": false,
  "message": "Unauthorized"
}
```

### 404 Not Found
```json
{
  "success": false,
  "message": "Resource not found"
}
```

### 409 Conflict
```json
{
  "success": false,
  "message": "Item already in wishlist"
}
```

### 500 Server Error
```json
{
  "success": false,
  "message": "Server error message"
}
```

---

## Rate Limiting
Currently no rate limiting is implemented. This should be added in production.

## CORS
CORS is configured in `config/cors.php`. Update as needed for your frontend domain.

## Testing
Use Postman or similar tools to test the API endpoints. Import the collection for easier testing.

---

## Frontend Integration Notes

1. **Authentication Flow**:
   - User logs in via `/login` endpoint
   - Receive authentication token
   - Include token in all subsequent API requests

2. **Pagination**:
   - All list endpoints support pagination
   - Use `page` and `per_page` query parameters
   - Response includes pagination metadata

3. **Error Handling**:
   - Always check `success` field in response
   - Handle different HTTP status codes appropriately
   - Display user-friendly error messages

4. **Image URLs**:
   - Currently using Unsplash for stock images
   - In production, implement file upload functionality
   - Store images in `storage/app/public/items/`

5. **Real-time Updates**:
   - Consider implementing WebSockets for live notifications
   - Use Laravel Broadcasting for trade updates
   - Implement real-time chat functionality

---

## Future Enhancements

1. **Notifications API**
   - Get user notifications
   - Mark as read
   - Delete notifications

2. **Chat API**
   - Send messages
   - Get conversation history
   - Real-time messaging with WebSockets

3. **Analytics API**
   - User statistics
   - Trade statistics
   - Platform statistics

4. **Admin API**
   - User management
   - Item moderation
   - Report handling

5. **File Upload API**
   - Upload item images
   - Upload user avatars
   - Validate file types and sizes
