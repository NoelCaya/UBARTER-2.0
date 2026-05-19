# Browse Filters Implementation Guide

## Current Status
✅ Filters are fully implemented and functional in the browse page.

## How Filters Work

### 1. Filter Form (Sidebar)
**Location**: `resources/views/items/browse.blade.php` (lines 100-180)

The filter form includes:
- **Search**: Text input for searching by title or description
- **Type**: Radio buttons for Barter/Donation
- **Category**: Radio buttons for all available categories
- **Condition**: Radio buttons for New/Slightly Used/Used
- **Apply Button**: Submits the form with selected filters
- **Reset Button**: Clears all filters

### 2. Backend Processing
**Location**: `app/Http/Controllers/ItemController.php` (lines 12-60)

The `browse()` method:
1. Starts with `Item::active()` query
2. Applies search filter using LIKE on title and description
3. Applies category filter if selected
4. Applies type filter if selected
5. Applies condition filter if selected
6. Applies sorting (newest, most_viewed, highest_rated, most_wishlisted)
7. Paginates results (20 items per page)
8. Returns filtered items and filter options to view

### 3. Filter Parameters

#### Search
- **Parameter**: `search`
- **Type**: String
- **Behavior**: Searches in title and description fields
- **Example**: `?search=textbook`

#### Type
- **Parameter**: `type`
- **Type**: String (Barter, Donation, or 'all')
- **Default**: 'all'
- **Example**: `?type=Barter`

#### Category
- **Parameter**: `category`
- **Type**: String (category name or 'all')
- **Default**: 'all'
- **Example**: `?category=Books%20%26%20Textbooks`

#### Condition
- **Parameter**: `condition`
- **Type**: String (New, Slightly Used, Used, or 'all')
- **Default**: 'all'
- **Example**: `?condition=New`

#### Sort
- **Parameter**: `sort`
- **Type**: String
- **Options**:
  - `newest` (default) - Most recently posted
  - `most_viewed` - Most viewed items
  - `highest_rated` - Highest seller rating
  - `most_wishlisted` - Most wishlisted items
- **Example**: `?sort=highest_rated`

#### Pagination
- **Parameter**: `page`
- **Type**: Integer
- **Default**: 1
- **Example**: `?page=2`

### 4. Filter Combinations

You can combine multiple filters:

```
/items/browse?search=textbook&category=Books%20%26%20Textbooks&type=Barter&condition=New&sort=newest&page=1
```

This will:
1. Search for "textbook" in title/description
2. Filter by "Books & Textbooks" category
3. Filter by "Barter" type
4. Filter by "New" condition
5. Sort by newest
6. Show page 1

### 5. Current Filter State

The view displays the current filter state in `$currentFilters`:

```php
'currentFilters' => [
    'type' => $request->type ?? 'all',
    'category' => $request->category ?? 'all',
    'condition' => $request->condition ?? 'all',
    'search' => $request->search ?? '',
    'sort' => $sort,
]
```

This is used to:
- Pre-select radio buttons
- Populate search input
- Show current sort option
- Preserve filters during pagination

## Testing Filters

### Manual Testing Steps

1. **Test Search Filter**
   - Go to `/items/browse`
   - Type "textbook" in search box
   - Click Apply
   - Verify only items with "textbook" in title/description appear

2. **Test Type Filter**
   - Select "Barter" type
   - Click Apply
   - Verify only Barter items appear

3. **Test Category Filter**
   - Select "Books & Textbooks" category
   - Click Apply
   - Verify only items from that category appear

4. **Test Condition Filter**
   - Select "New" condition
   - Click Apply
   - Verify only new items appear

5. **Test Sorting**
   - Use the sort dropdown in toolbar
   - Select "Most Popular"
   - Verify items are sorted by views (descending)

6. **Test Combined Filters**
   - Select multiple filters
   - Click Apply
   - Verify all filters are applied correctly

7. **Test Reset**
   - Apply some filters
   - Click Reset button
   - Verify all filters are cleared

8. **Test Pagination**
   - Apply filters that return more than 20 items
   - Click next page
   - Verify filters are preserved in pagination links

### API Testing

Test the API endpoint directly:

```bash
# Get all items
curl http://localhost:8000/api/items

# Search for textbooks
curl "http://localhost:8000/api/items?search=textbook"

# Filter by category and type
curl "http://localhost:8000/api/items?category=Books&type=Barter"

# Sort by most viewed
curl "http://localhost:8000/api/items?sort=most_viewed"

# Combine filters
curl "http://localhost:8000/api/items?search=textbook&category=Books&type=Barter&sort=newest&per_page=12"
```

## Database Queries

### Query Scopes Used

The Item model has several scopes for filtering:

```php
// Get active items only
Item::active()

// Sort by newest
->newest()

// Sort by most viewed
->mostViewed()

// Sort by highest rated
->highestRated()

// Filter by category
->where('category', $category)

// Filter by type
->where('item_type', $type)

// Filter by condition
->where('condition', $condition)
```

### Example Query

```php
$items = Item::active()
    ->where('title', 'like', '%textbook%')
    ->orWhere('description', 'like', '%textbook%')
    ->where('category', 'Books & Textbooks')
    ->where('item_type', 'Barter')
    ->where('condition', 'New')
    ->newest()
    ->paginate(20);
```

## Performance Considerations

### Database Indexes
The items table has indexes on:
- `user_id`
- `category`
- `item_type`
- `status`

These help with filter performance.

### Optimization Tips
1. **Search**: Uses LIKE which can be slow on large datasets. Consider full-text search for production.
2. **Sorting**: Ensure columns used in ORDER BY are indexed.
3. **Pagination**: Always paginate to avoid loading too many items.
4. **Caching**: Consider caching category list and popular items.

## Mobile Filters

The browse page includes mobile-responsive filters:

**Location**: `resources/views/items/browse.blade.php` (lines 200-240)

Mobile filters use:
- Collapsible filter panel (hidden by default)
- Dropdown selects instead of radio buttons
- Same filtering logic as desktop

Toggle with: `document.getElementById('mobileFilters').classList.toggle('hidden')`

## Future Enhancements

### Recommended Improvements

1. **AJAX Filtering**
   - Update results without page reload
   - Show loading indicator
   - Preserve scroll position

2. **Advanced Filters**
   - Price range slider
   - Date range picker
   - Multiple category selection
   - Rating filter

3. **Filter Presets**
   - Save favorite filter combinations
   - Quick filter buttons (e.g., "New Items", "Most Popular")

4. **Search Suggestions**
   - Auto-complete search
   - Popular searches
   - Search history

5. **Filter Analytics**
   - Track which filters are used most
   - Optimize filter options based on usage

6. **Full-Text Search**
   - Replace LIKE with full-text search
   - Better performance on large datasets
   - Relevance ranking

## Troubleshooting

### Filters Not Working

**Problem**: Filters don't seem to apply
**Solution**: 
1. Check browser console for errors
2. Verify form is submitting to correct route
3. Check ItemController::browse() method
4. Verify database has items with correct data

### No Results Returned

**Problem**: Filters return no items
**Solution**:
1. Check if items exist in database
2. Verify filter values match database values exactly
3. Try removing filters one by one
4. Check item status is 'Active'

### Pagination Not Working

**Problem**: Pagination links don't preserve filters
**Solution**:
1. Verify `appends(request()->query())` is used in pagination
2. Check all filter parameters are included in hidden inputs
3. Verify page parameter is being passed correctly

## Code Examples

### Adding a New Filter

To add a new filter (e.g., price range):

1. **Update Migration**
```php
$table->decimal('price', 8, 2)->nullable();
```

2. **Update Controller**
```php
if ($request->min_price && $request->max_price) {
    $query->whereBetween('price', [$request->min_price, $request->max_price]);
}
```

3. **Update View**
```html
<div>
    <label>Min Price</label>
    <input type="number" name="min_price" value="{{ $currentFilters['min_price'] ?? '' }}">
    <label>Max Price</label>
    <input type="number" name="max_price" value="{{ $currentFilters['max_price'] ?? '' }}">
</div>
```

4. **Update currentFilters**
```php
'min_price' => $request->min_price ?? '',
'max_price' => $request->max_price ?? '',
```

## Summary

The browse filters are fully functional and ready for use. They support:
- ✅ Text search
- ✅ Category filtering
- ✅ Type filtering (Barter/Donation)
- ✅ Condition filtering
- ✅ Sorting (newest, most viewed, highest rated, most wishlisted)
- ✅ Pagination with filter preservation
- ✅ Mobile-responsive design
- ✅ API endpoints for programmatic access

The implementation is clean, performant, and ready for production use.
