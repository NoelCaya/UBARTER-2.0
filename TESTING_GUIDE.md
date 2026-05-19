# UBarter Testing Guide

## Quick Start

### 1. Start the Application
```bash
cd c:\Users\noeli\OneDrive\Desktop\ubarter
php artisan serve
```

The application will be available at `http://localhost:8000`

### 2. Access the Browse Page
Navigate to: `http://localhost:8000/items/browse`

### 3. Test the Filters
Use the filter sidebar to test different combinations of filters.

---

## Testing Browse Filters

### Test Case 1: Search Filter
**Steps**:
1. Go to `/items/browse`
2. Enter "laptop" in the search box
3. Click "Apply"

**Expected Result**:
- Only items with "laptop" in title or description are shown
- Item count updates
- URL shows: `?search=laptop`

### Test Case 2: Category Filter
**Steps**:
1. Go to `/items/browse`
2. Select "Electronics" category
3. Click "Apply"

**Expected Result**:
- Only Electronics items are shown
- URL shows: `?category=Electronics`

### Test Case 3: Type Filter
**Steps**:
1. Go to `/items/browse`
2. Select "Barter" type
3. Click "Apply"

**Expected Result**:
- Only Barter items are shown
- URL shows: `?type=Barter`

### Test Case 4: Condition Filter
**Steps**:
1. Go to `/items/browse`
2. Select "New" condition
3. Click "Apply"

**Expected Result**:
- Only New items are shown
- URL shows: `?condition=New`

### Test Case 5: Multiple Filters
**Steps**:
1. Go to `/items/browse`
2. Select "Electronics" category
3. Select "Barter" type
4. Select "New" condition
5. Click "Apply"

**Expected Result**:
- Only items matching ALL filters are shown
- URL shows: `?category=Electronics&type=Barter&condition=New`

### Test Case 6: Sort Options
**Steps**:
1. Go to `/items/browse`
2. Select "Most Popular" from sort dropdown

**Expected Result**:
- Items are sorted by views (descending)
- URL shows: `?sort=most_viewed`

**Test all sort options**:
- Newest: Items sorted by posted_at (descending)
- Most Popular: Items sorted by views (descending)
- Highest Rated: Items sorted by seller_rating (descending)
- Most Wishlisted: Items sorted by wishlist_count (descending)

### Test Case 7: Reset Filters
**Steps**:
1. Go to `/items/browse`
2. Apply some filters
3. Click "Reset"

**Expected Result**:
- All filters are cleared
- All items are shown
- URL is clean: `/items/browse`

### Test Case 8: Pagination
**Steps**:
1. Go to `/items/browse`
2. Scroll to bottom
3. Click next page

**Expected Result**:
- Next page of items is loaded
- URL shows: `?page=2`
- Item count shows correct range

---

## Testing API Endpoints

### Setup: Get Authentication Token

First, you need to get an authentication token. You can do this by:

1. **Register a new user** (if not already done)
   ```bash
   POST /register
   ```

2. **Login to get token**
   ```bash
   POST /login
   ```

3. **Store the token** for use in API requests

### Test Case 1: Get All Items (Public)
```bash
curl -X GET "http://localhost:8000/api/items"
```

**Expected Response**:
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "...",
      "category": "...",
      ...
    }
  ],
  "pagination": {
    "total": 25,
    "per_page": 20,
    "current_page": 1,
    "last_page": 2
  }
}
```

### Test Case 2: Get Items with Filters
```bash
curl -X GET "http://localhost:8000/api/items?category=Electronics&sort=newest"
```

**Expected Response**:
- Only Electronics items
- Sorted by newest first

### Test Case 3: Search Items
```bash
curl -X GET "http://localhost:8000/api/items/search?q=laptop"
```

**Expected Response**:
- Items matching "laptop" search

### Test Case 4: Get Filter Options
```bash
curl -X GET "http://localhost:8000/api/items/filters"
```

**Expected Response**:
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

### Test Case 5: Get Item Details
```bash
curl -X GET "http://localhost:8000/api/items/1"
```

**Expected Response**:
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "...",
    "description": "...",
    ...
  },
  "related_items": [...]
}
```

### Test Case 6: Create Item (Protected)
```bash
curl -X POST "http://localhost:8000/api/items" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Test Item",
    "description": "Test Description",
    "category": "Electronics",
    "condition": "New",
    "item_type": "Barter"
  }'
```

**Expected Response**:
```json
{
  "success": true,
  "message": "Item created successfully",
  "data": {
    "id": 26,
    "title": "Test Item",
    ...
  }
}
```

### Test Case 7: Update Item (Protected)
```bash
curl -X PATCH "http://localhost:8000/api/items/26" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Updated Test Item"
  }'
```

**Expected Response**:
```json
{
  "success": true,
  "message": "Item updated successfully",
  "data": { ... }
}
```

### Test Case 8: Delete Item (Protected)
```bash
curl -X DELETE "http://localhost:8000/api/items/26" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected Response**:
```json
{
  "success": true,
  "message": "Item deleted successfully"
}
```

### Test Case 9: Add to Wishlist (Protected)
```bash
curl -X POST "http://localhost:8000/api/wishlist/1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected Response**:
```json
{
  "success": true,
  "message": "Item added to wishlist"
}
```

### Test Case 10: Get Wishlist (Protected)
```bash
curl -X GET "http://localhost:8000/api/wishlist" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected Response**:
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "item": { ... }
    }
  ],
  "pagination": { ... }
}
```

---

## Testing with Postman

### 1. Import Collection
- Open Postman
- Click "Import"
- Select the API collection file (if available)

### 2. Set Up Environment
- Create a new environment
- Add variables:
  - `base_url`: `http://localhost:8000`
  - `api_url`: `http://localhost:8000/api`
  - `token`: (leave empty, will be filled after login)

### 3. Test Endpoints
- Use the imported requests
- Replace `{{base_url}}` with your environment variable
- Add token to Authorization header for protected endpoints

### 4. Save Responses
- Save successful responses for reference
- Document any issues

---

## Testing with Browser Console

### Test 1: Get All Items
```javascript
fetch('http://localhost:8000/api/items')
  .then(response => response.json())
  .then(data => console.log(data));
```

### Test 2: Get Items with Filters
```javascript
fetch('http://localhost:8000/api/items?category=Electronics&sort=newest')
  .then(response => response.json())
  .then(data => console.log(data));
```

### Test 3: Search Items
```javascript
fetch('http://localhost:8000/api/items/search?q=laptop')
  .then(response => response.json())
  .then(data => console.log(data));
```

### Test 4: Get Filter Options
```javascript
fetch('http://localhost:8000/api/items/filters')
  .then(response => response.json())
  .then(data => console.log(data));
```

---

## Performance Testing

### Test 1: Response Time
**Steps**:
1. Open browser DevTools (F12)
2. Go to Network tab
3. Navigate to `/items/browse`
4. Check response time

**Expected Result**:
- Page load: < 2 seconds
- API response: < 500ms

### Test 2: Large Dataset
**Steps**:
1. Create 100+ items in database
2. Test pagination
3. Test filtering with large dataset

**Expected Result**:
- Pagination works smoothly
- Filtering is fast (< 1 second)

### Test 3: Concurrent Requests
**Steps**:
1. Open multiple browser tabs
2. Load `/items/browse` in each tab
3. Apply different filters simultaneously

**Expected Result**:
- All requests complete successfully
- No errors or timeouts

---

## Error Testing

### Test 1: Invalid Filter Value
**Steps**:
1. Go to `/items/browse?category=InvalidCategory`

**Expected Result**:
- No items shown (or all items if filter is ignored)
- No error message

### Test 2: Invalid Page Number
**Steps**:
1. Go to `/items/browse?page=999`

**Expected Result**:
- Empty results or last page shown
- No error

### Test 3: Missing Required Fields (API)
**Steps**:
```bash
curl -X POST "http://localhost:8000/api/items" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Test Item"
  }'
```

**Expected Response**:
```json
{
  "success": false,
  "message": "Validation error message"
}
```

### Test 4: Unauthorized Access (API)
**Steps**:
```bash
curl -X POST "http://localhost:8000/api/items" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Test Item",
    ...
  }'
```

**Expected Response**:
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

### Test 5: Forbidden Access (API)
**Steps**:
```bash
# Try to update someone else's item
curl -X PATCH "http://localhost:8000/api/items/1" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Hacked Item"
  }'
```

**Expected Response**:
```json
{
  "success": false,
  "message": "Unauthorized"
}
```

---

## Database Testing

### Check Items in Database
```bash
php artisan tinker
```

```php
// Get all items
Item::all();

// Get items by category
Item::where('category', 'Electronics')->get();

// Get active items
Item::active()->get();

// Count items
Item::count();

// Get item with user
Item::with('user')->first();
```

### Check Filters Work
```php
// Search
Item::where('title', 'like', '%laptop%')->get();

// Filter by category
Item::where('category', 'Electronics')->get();

// Filter by type
Item::where('item_type', 'Barter')->get();

// Filter by condition
Item::where('condition', 'New')->get();

// Sort by newest
Item::orderBy('posted_at', 'desc')->get();

// Sort by most viewed
Item::orderBy('views', 'desc')->get();
```

---

## Checklist

### Browse Page
- [ ] Search filter works
- [ ] Category filter works
- [ ] Type filter works
- [ ] Condition filter works
- [ ] Sort options work
- [ ] Multiple filters work together
- [ ] Reset button clears all filters
- [ ] Pagination works
- [ ] Mobile filters work

### API Endpoints
- [ ] GET /api/items works
- [ ] GET /api/items/{id} works
- [ ] GET /api/items/search works
- [ ] GET /api/items/filters works
- [ ] POST /api/items works (with auth)
- [ ] PATCH /api/items/{id} works (with auth)
- [ ] DELETE /api/items/{id} works (with auth)
- [ ] GET /api/wishlist works (with auth)
- [ ] POST /api/wishlist/{item_id} works (with auth)
- [ ] GET /api/reviews/my works (with auth)

### Error Handling
- [ ] Invalid filters handled gracefully
- [ ] Missing required fields return error
- [ ] Unauthorized access returns 401
- [ ] Forbidden access returns 403
- [ ] Not found returns 404

### Performance
- [ ] Page loads in < 2 seconds
- [ ] API responds in < 500ms
- [ ] Pagination works with large datasets
- [ ] Concurrent requests handled correctly

---

## Troubleshooting

### Issue: Filters not working
**Solution**:
1. Check if items exist in database
2. Verify filter values match database values
3. Check browser console for errors
4. Check server logs

### Issue: API returns 404
**Solution**:
1. Verify endpoint URL is correct
2. Check if resource exists
3. Verify HTTP method (GET, POST, etc.)

### Issue: API returns 401
**Solution**:
1. Verify token is included in Authorization header
2. Check if token is valid
3. Try logging in again to get new token

### Issue: Slow performance
**Solution**:
1. Check database indexes
2. Verify pagination is used
3. Check for N+1 queries
4. Enable query caching

---

## Summary

This testing guide covers:
- ✅ Browse filter testing
- ✅ API endpoint testing
- ✅ Error handling testing
- ✅ Performance testing
- ✅ Database testing
- ✅ Troubleshooting

All tests should pass before deploying to production.

---

**Last Updated**: May 19, 2026
**Status**: Ready for Testing
