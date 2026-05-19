# Quick Start Guide - UBarter API

## Server Setup

### Start the Development Server
```bash
php artisan serve --host=127.0.0.1 --port=8000
```

The API will be available at: `http://127.0.0.1:8000/api`

## Testing the API

### 1. Health Check
```bash
curl http://127.0.0.1:8000/api/health
```

Response:
```json
{
  "status": "ok",
  "message": "API is running"
}
```

### 2. Get All Items
```bash
curl http://127.0.0.1:8000/api/items
```

### 3. Search Items
```bash
curl "http://127.0.0.1:8000/api/items?search=textbook"
```

### 4. Filter by Category
```bash
curl "http://127.0.0.1:8000/api/items?category=Electronics"
```

### 5. Filter by Type
```bash
curl "http://127.0.0.1:8000/api/items?type=Barter"
```

### 6. Combine Filters
```bash
curl "http://127.0.0.1:8000/api/items?search=textbook&category=Books&type=Barter&sort=newest"
```

### 7. Sort Options
```bash
# Newest items
curl "http://127.0.0.1:8000/api/items?sort=newest"

# Most viewed
curl "http://127.0.0.1:8000/api/items?sort=most_viewed"

# Highest rated
curl "http://127.0.0.1:8000/api/items?sort=highest_rated"

# Most wishlisted
curl "http://127.0.0.1:8000/api/items?sort=most_wishlisted"
```

### 8. Pagination
```bash
# Get 12 items per page
curl "http://127.0.0.1:8000/api/items?per_page=12"

# Get page 2
curl "http://127.0.0.1:8000/api/items?page=2"
```

### 9. Get Single Item
```bash
curl http://127.0.0.1:8000/api/items/1
```

### 10. Get Related Items
```bash
curl http://127.0.0.1:8000/api/items/1/related
```

### 11. Get All Categories
```bash
curl http://127.0.0.1:8000/api/categories
```

### 12. Get User Profile
```bash
curl http://127.0.0.1:8000/api/users/1
```

### 13. Get User's Items
```bash
curl http://127.0.0.1:8000/api/users/1/items
```

### 14. Get User's Reviews
```bash
curl http://127.0.0.1:8000/api/users/1/reviews
```

## API Response Format

All responses follow this format:

```json
{
  "success": true,
  "message": "Optional message",
  "data": [],
  "pagination": {
    "total": 100,
    "per_page": 20,
    "current_page": 1,
    "last_page": 5,
    "from": 1,
    "to": 20
  },
  "filters": {
    "search": "",
    "category": "all",
    "type": "all",
    "condition": "all",
    "sort": "newest"
  }
}
```

## Filter Parameters

| Parameter | Type | Values | Default | Example |
|-----------|------|--------|---------|---------|
| search | string | Any text | "" | `?search=textbook` |
| category | string | Category name or "all" | "all" | `?category=Electronics` |
| type | string | Barter, Donation, or "all" | "all" | `?type=Barter` |
| condition | string | New, Slightly Used, Used, or "all" | "all" | `?condition=New` |
| sort | string | newest, most_viewed, highest_rated, most_wishlisted | newest | `?sort=highest_rated` |
| per_page | integer | 1-100 | 20 | `?per_page=12` |
| page | integer | 1+ | 1 | `?page=2` |

## Common Filter Combinations

### Find New Textbooks for Bartering
```bash
curl "http://127.0.0.1:8000/api/items?search=textbook&category=Books&type=Barter&condition=New"
```

### Find Most Popular Electronics
```bash
curl "http://127.0.0.1:8000/api/items?category=Electronics&sort=most_viewed"
```

### Find Highest Rated Donations
```bash
curl "http://127.0.0.1:8000/api/items?type=Donation&sort=highest_rated"
```

### Find Recently Posted Lab Supplies
```bash
curl "http://127.0.0.1:8000/api/items?category=Lab%20Supplies&sort=newest"
```

## Frontend Integration

### JavaScript Example - Fetch Items with Filters

```javascript
// Fetch items with filters
async function getItems(filters = {}) {
  const params = new URLSearchParams({
    search: filters.search || '',
    category: filters.category || 'all',
    type: filters.type || 'all',
    condition: filters.condition || 'all',
    sort: filters.sort || 'newest',
    per_page: filters.per_page || 20,
    page: filters.page || 1
  });

  const response = await fetch(`/api/items?${params}`);
  const data = await response.json();
  
  return data;
}

// Usage
const items = await getItems({
  search: 'textbook',
  category: 'Books & Textbooks',
  type: 'Barter',
  sort: 'newest'
});

console.log(items.data); // Array of items
console.log(items.pagination); // Pagination info
console.log(items.filters); // Applied filters
```

### React Example

```jsx
import { useState, useEffect } from 'react';

function BrowseItems() {
  const [items, setItems] = useState([]);
  const [filters, setFilters] = useState({
    search: '',
    category: 'all',
    type: 'all',
    condition: 'all',
    sort: 'newest'
  });

  useEffect(() => {
    const params = new URLSearchParams(filters);
    fetch(`/api/items?${params}`)
      .then(res => res.json())
      .then(data => setItems(data.data));
  }, [filters]);

  return (
    <div>
      <input 
        placeholder="Search..."
        onChange={(e) => setFilters({...filters, search: e.target.value})}
      />
      <select onChange={(e) => setFilters({...filters, category: e.target.value})}>
        <option value="all">All Categories</option>
        <option value="Electronics">Electronics</option>
        <option value="Books & Textbooks">Books & Textbooks</option>
      </select>
      
      <div className="items-grid">
        {items.map(item => (
          <div key={item.id} className="item-card">
            <img src={item.image_url} alt={item.title} />
            <h3>{item.title}</h3>
            <p>{item.category}</p>
            <p>Rating: {item.seller_rating}</p>
          </div>
        ))}
      </div>
    </div>
  );
}
```

## Database Seeding

To populate the database with sample items:

```bash
php artisan db:seed --class=ItemSeeder
```

This creates 25 sample items with:
- Random users
- Various categories
- Different conditions
- Barter and Donation types
- Stock images from Unsplash
- Random view counts and ratings

## Troubleshooting

### API Returns 404
- Ensure the server is running: `php artisan serve`
- Check the URL is correct: `http://127.0.0.1:8000/api/...`
- Verify routes/api.php is configured in bootstrap/app.php

### No Items Returned
- Check database has items: `php artisan db:seed --class=ItemSeeder`
- Verify items have status='Active'
- Check filter parameters match database values

### CORS Errors (Frontend)
- Update `config/cors.php` with your frontend domain
- Ensure API is accessible from frontend URL

## Next Steps

1. **Read Full Documentation**: See `API_DOCUMENTATION.md`
2. **Backend Integration**: See `BACKEND_INTEGRATION_GUIDE.md`
3. **Filter Details**: See `FILTERS_IMPLEMENTATION.md`
4. **Test Authenticated Endpoints**: Create a user and get API token
5. **Build Frontend**: Use the API endpoints to build your frontend

## Support

For detailed API documentation, see `API_DOCUMENTATION.md`
For integration help, see `BACKEND_INTEGRATION_GUIDE.md`
For filter details, see `FILTERS_IMPLEMENTATION.md`
