# Lifecycle Hooks

Livewire provides hooks to execute code at specific points during a component's lifecycle.

## Hook Reference

| Hook | When Called | Use For |
|------|-------------|---------|
| `mount()` | Once, on first render | Initialize properties, receive route params |
| `boot()` | Every request (initial + subsequent) | Dependency injection, global setup |
| `hydrate()` | Every subsequent request, after re-hydration | Restore non-serializable state |
| `dehydrate()` | End of every request, before response | Convert objects to arrays |
| `updating($prop, $value)` | Before a property is updated | Validate/reject updates |
| `updated($prop, $value)` | After a property is updated | Transform values, side effects |
| `rendering($view, $data)` | Before view renders | Modify view data |
| `rendered($view, $html)` | After view renders | Post-process HTML |
| `exception($e, $stopPropagation)` | When exception is thrown | Custom error handling |

## Common Patterns

### Initialize from Route

```php
public function mount(Post $post)
{
    $this->title = $post->title;
}
```

### Dependency Injection (Every Request)

```php
public function boot()
{
    $this->service = app(MyService::class);
}
```

### Transform Property on Update

```php
public function updatedUsername()
{
    $this->username = strtolower($this->username);
}
```

### Hydrate Non-Serializable Data

```php
public function hydrate()
{
    $this->dto = new PostDto($this->post);
}

public function dehydrate()
{
    $this->post = $this->dto->toArray();
}
```

### Custom Exception Handling

```php
public function exception($e, $stopPropagation)
{
    if ($e instanceof NotFoundException) {
        $this->notify('Not found');
        $stopPropagation();
    }
}
```

## Trait Hooks

Prefix hook with trait name (camelCase) to avoid conflicts:

```php
trait HasPostForm
{
    public function mountHasPostForm() { ... }
    public function bootHasPostForm() { ... }
    public function updatedHasPostForm() { ... }
}
```

## Form Object Hooks

Form objects support `updating()` and `updated()` hooks:

```php
class PostForm extends Form
{
    public function updatedTitle($value)
    {
        // ...
    }
}
```

## Gotchas

- **Don't use `__construct()`** - Components are reconstructed on every request.
- **`mount()` only runs once** - Use `boot()` for every-request logic.
- **Use computed properties** instead of `boot()` when possible for performance.
- **Trait hooks are prefixed** to avoid method name conflicts.

## Specification Format

```
**Hook**: mount()
**Purpose**: Initialize form with Post model data
**Logic**:
  1. Receive $post via route model binding
  2. Fill $title, $content from $post
```
