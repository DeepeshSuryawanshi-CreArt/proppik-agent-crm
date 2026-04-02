# Roles & Permissions Setup Complete!

## Installed Package
- **spatie/laravel-permission** v7.2.4 - Full-featured role and permission management

## Database Tables Created
The following tables are created when you run migrations:
- `permissions` - All available permissions
- `roles` - All available roles
- `role_has_permissions` - Links roles to permissions
- `model_has_roles` - Links users to roles
- `model_has_permissions` - Direct user permissions

## Roles Defined
1. **admin** - Full access to all system functions
2. **editor** - Can view users, roles, and permissions
3. **viewer** - Can view dashboard and own profile

## Permissions Defined
### User Management
- view users
- create users
- edit users
- delete users

### Role Management
- view roles
- create roles
- edit roles
- delete roles

### Permission Management
- view permissions
- create permissions
- edit permissions
- delete permissions

### Dashboard
- view dashboard

### Profile
- view own profile
- edit own profile

## Usage Examples

### Assigning Roles
```php
$user = User::find(1);
$user->assignRole('admin');
$user->assignRole(['admin', 'editor']);
```

### Removing Roles
```php
$user->removeRole('editor');
$user->syncRoles('admin'); // Remove all other roles
```

### Checking Roles
```php
if ($user->hasRole('admin')) {
    // User is admin
}

if ($user->hasAnyRole(['admin', 'editor'])) {
    // User is admin or editor
}
```

### Assigning Permissions Directly to Users
```php
$user->givePermissionTo('edit users');
$user->givePermissionTo(['view users', 'create users']);
```

### Checking Permissions
```php
// Check if user has permission
if ($user->hasPermissionTo('edit users')) {
    // User can edit users
}

// Check in routes
Route::get('/users', function () {
    // Only users with 'view users' permission
})->middleware('permission:view users');

// Multiple permissions (all required)
Route::post('/users', function () {
    // Only users with both permissions
})->middleware('permission:create users|edit users');
```

### In Blade Templates
```blade
@can('view users')
    {{-- User can view users --}}
@endcan

@canany(['edit users', 'delete users'])
    {{-- User can either edit or delete users --}}
@endcanany

@role('admin')
    {{-- User is admin --}}
@endrole
```

### Using the CheckPermission Middleware
Register in `app/Http/Kernel.php`:
```php
protected $routeMiddleware = [
    // ...
    'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
    'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
];
```

Then use in routes:
```php
Route::middleware(['auth', 'permission:view users'])->group(function () {
    // Routes here require 'view users' permission
});
```

## Seeding the Database
To seed roles and permissions to your database:
```bash
php artisan migrate
php artisan db:seed
```

This will:
1. Create all permissions
2. Create all roles
3. Assign appropriate permissions to each role
4. Create a test user with admin role (email: test@example.com)

## Next Steps
1. Run migrations: `php artisan migrate`
2. Run seeders: `php artisan db:seed`
3. Update your routes/controllers to use permissions
4. Create authorization gates/policies as needed

## Documentation
For more information, see: https://spatie.be/docs/laravel-permission/v6/introduction
