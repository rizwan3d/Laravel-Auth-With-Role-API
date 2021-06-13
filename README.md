
```php
//You can also determine if a user has any of a given list of roles:
$user->hasRole('writer');
$user->hasAnyRole(['writer', 'reader']);

//You can determine if a role has a certain permission:
$user->hasPermissionTo('edit articles');

//You can check if a user has Any of an array of permissions:
$user->hasAnyPermission(['edit articles', 'publish articles', 'unpublish articles']);

//if a user has All of an array of permissions:
$user->hasAllPermissions(['edit articles', 'publish articles', 'unpublish articles']);




// get a list of all permissions directly assigned to the user
$permissionNames = $user->getPermissionNames(); // collection of name strings
$permissions = $user->permissions; // collection of permission objects

// get all permissions for the user
$permissions = $user->getAllPermissions();

// get the names of the user's roles
$roles = $user->getRoleNames(); // Returns a collection
```

