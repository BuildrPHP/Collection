---
currentMenu: map
baseUrl: ..
---

# Map

### A description of `Map`:

 - Contains duplicates (values)
 - cannot contain duplicated keys
 - Allows scalar types as key
 - Store any type of element
 - Maybe ordered (Depend by implementation)

### Typical application of set:

A list typically store a "set" of data (Like `Set`), but lists provide more precise control over
where elements are inserted, list also provide more advanced filtering.

### Numeric keys

Because list is integer indexed, all index must be numeric type. Keys checked by `is_numeric()` function and if
this returns TRUE the key is casted to integer.

### Current implementations

 - [HashMap](https://docs.buildr-framework.io/collection_api/class-BuildR.Collection.Map.HashMap.html)

### `List` In example:

```php
...
//getAllUsers() returns an array indexed by userName and the value is the users data
$allUsers = (new HashMap)->putAll($userRepository->getAllUsers());

//Find a user by username
$user = $allUsers->get('Josh');
...
```

