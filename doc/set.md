---
currentMenu: set
baseUrl: ..
---

# Set

### A description of `Set`:

 - Sets is un-ordered (sorted by natural order)
 - Sets contains no duplicates
 - Sets only store scalar types of elements
 - Not provide method to get element from the set.
 - Only used in iteration

### Typical application of set:

A set mainly used to store a "set" of data. In example this set of data
can be a list of string values, when you have 2 different list with same kind of data
(e.g. list user names) you can easily compare and merge this two set together ore remove
elements from it (or duplicates), and used the result as iterator.

### Scalar values

Set only contains scalar types of values:

 - boolean
 - integer
 - float (double)
 - string

If You try to add a value that is not a scalar type, the add functions (`HashSet::add()` and `HashSet::addAll()`)
will throw a `CollectionException`.

### Current implementations

 - [HashSet](https://docs.buildr-framework.io/collection_api/class-BuildR.Collection.Set.HashSet.html)

### `Set` In example:

```php
...
$adminUsers = [12, 18];
$activeUsers = (new HashSet())->addAll($userRepository->getUsersByStatus(UserStatus::ACTIVE));
$modifiedUsers = (new HashSet())->addAll($userRepository->getUsersByStatus(UserStatus::MODIFIED));

//Get a list of active AND modified users
$activeAndModifiedUsers = $activeUsers->retainAll($modifiedUsers);

//Or get a list of users that active and NOT modified
$activeUsers = $activeUsers->removeAll($modifiedUsers);

//Chack that currently has any active administrator
$activeUsers->containsAny($adminUsers);

//Or cahcks that all admins are active
$activeUsers->containsAll($adminUsers);

//Checks that only the admins are active
$adminSet = new HashSet($adminUsers);
echo ($activeUsers->eqauls($adminSet));
...
```

