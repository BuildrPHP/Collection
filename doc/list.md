---
currentMenu: list
baseUrl: ..
---

# List

### A description of `List`:

 - Contains duplicates
 - Allows only numeric keys (indexes)
 - Store any type of element
 - Ordered (By numerical index)
 - Precise control over elements positions

### Typical application of set:

A list typically store a "set" of data (Like `Set`), but lists provide more precise control over
where elements are inserted, list also provide more advanced filtering.

### Numeric keys

Because list is integer indexed, all index must be numeric type. Keys checked by `is_numeric()` function and if
this returns TRUE the key is casted to integer.

### Current implementations

 - [ArrayList](https://docs.buildr-framework.io/collection_api/class-BuildR.Collection.ArrayList.ArrayList.html)

### `List` In example:

```php
...
$adminUserId = 25478;
$userList = (new ArrayList())->addAll($userRepository->getAllUsers());

//Get user by its index (The userId is used for index)
$singleUser = $userList->get($adminUserId);

//Get all inactiveUser
$inactiveUsers = $userList->filter(function($index, $value) {
    return $value->status === UserStatus::INACTIVE;
});

//Add a new (dummy) user
$dummyUser = new User(...);
$userList->addTo(0, $dummyUser);
...
```

