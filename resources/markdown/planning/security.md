# Security

Livewire components require careful security consideration.

## Core Principle

**Treat all public properties and action parameters as untrusted user input.**

## Action Parameter Authorization

**INSECURE:**

```php
public function delete($id)
{
    Post::find($id)->delete(); // Anyone can delete any post!
}
```

**SECURE:**

```php
public function delete($id)
{
    $post = Post::find($id);
    $this->authorize('delete', $post); // Throws if unauthorized
    $post->delete();
}
```

## Public Property Security

**INSECURE:**

```php
public $postId;

public function delete()
{
    Post::find($this->postId)->delete(); // postId can be modified!
}
```

### Solution 1: Use Eloquent Model (Recommended)

```php
public Post $post; // ID is auto-locked

public function delete()
{
    $this->post->delete(); // Safe - model ID can't be changed
}
```

### Solution 2: Lock the Property

```php
#[Locked]
public $postId;

public function delete()
{
    Post::find($this->postId)->delete(); // Safe - locked
}
```

### Solution 3: Authorize Anyway

```php
public $postId;

public function delete()
{
    $post = Post::find($this->postId);
    $this->authorize('delete', $post); // Catches tampering
    $post->delete();
}
```

## Middleware Persistence

Route middleware is automatically re-applied to Livewire requests:

```php
Route::livewire('/posts/{post}', 'posts.edit')
    ->middleware('can:update,post'); // Persisted!
```

### Add Custom Persistent Middleware

```php
// In AppServiceProvider
Livewire::addPersistentMiddleware([
    App\Http\Middleware\EnsureUserHasRole::class,
]);
```

## Snapshot Checksums

Livewire checksums prevent payload tampering. A `CorruptComponentPayloadException` is thrown if tampering is detected.

## Hiding Class Names

Use Laravel's morphMap to hide model class names:

```php
// In AppServiceProvider
Relation::morphMap([
    'post' => App\Models\Post::class,
]);
```

## Security Checklist

- [ ] All action parameters are validated/authorized
- [ ] Sensitive property IDs use `#[Locked]` or Eloquent models
- [ ] `$this->authorize()` called before destructive operations
- [ ] Custom middleware added to persistent middleware list
- [ ] Validation runs before persisting any data

## Gotchas

- **Locked properties can still be changed server-side** - don't pass untrusted input.
- **Eloquent models auto-lock ID only** - other attributes can still be modified.
- **Middleware arguments not supported** in persistent middleware.

## Specification Format

```
**Security**: Post deletion
**Risks**: Unauthorized deletion via ID tampering
**Mitigations**:
  - Use Post $post (model property, auto-locked)
  - $this->authorize('delete', $post) before delete
  - Route middleware: can:update,post
```
