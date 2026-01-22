# Properties

Properties store and manage state in Livewire components. They are public properties on the component class.

## Supported Types

| Type | Notes |
|------|-------|
| Primitives | `string`, `int`, `float`, `bool`, `array`, `null` |
| Collections | `Illuminate\Support\Collection` |
| Eloquent | `Model`, `Eloquent\Collection` (ID auto-locked) |
| DateTime | `DateTime`, `Carbon\Carbon` |
| Stringable | `Illuminate\Support\Stringable` |
| BackedEnum | PHP `BackedEnum` |
| Custom | Implement `Wireable` interface |

## Property Attributes

| Attribute | Namespace | Use When |
|-----------|-----------|----------|
| `#[Url]` | `Livewire\Attributes\Url` | Sync property with URL query string |
| `#[Session]` | `Livewire\Attributes\Session` | Persist property across requests via session |
| `#[Locked]` | `Livewire\Attributes\Locked` | Prevent client-side modification (security) |
| `#[Reactive]` | `Livewire\Attributes\Reactive` | Re-render child when parent changes prop |
| `#[Modelable]` | `Livewire\Attributes\Modelable` | Allow `wire:model` binding from parent |
| `#[Validate]` | `Livewire\Attributes\Validate` | Attach validation rules |
| `#[Computed]` | `Livewire\Attributes\Computed` | Memoized derived value (method, not property) |

## Initialization

Use `mount()` to set initial values, not `__construct()`.

```php
public function mount(Post $post)
{
    $this->title = $post->title;
}
```

### Bulk Assignment

```php
$this->fill($post->only('title', 'content'));
```

## Resetting Properties

```php
$this->reset('title');       // Reset single
$this->reset(['title', 'content']); // Reset multiple
$this->reset();              // Reset all

$value = $this->pull('title'); // Reset and return value
```

## Security

- **Treat public properties as user input** - always validate/authorize before persisting.
- **Use `#[Locked]`** on sensitive IDs to prevent tampering.
- **Eloquent models auto-lock their ID** - safe to use directly.
- **Property values are serialized to JSON** and exposed to the browser.

## Gotchas

- `reset()` resets to state *before* `mount()`, not after.
- Eloquent query constraints (like `select()`) are NOT preserved between requests. Use `#[Computed]` instead.
- Reserved property names: `id`, `rules`, `messages`.

## Specification Format

```
**Property**: $title
**Type**: string
**Initial**: ''
**Attributes**: #[Validate('required|min:3')], #[Url]
**Security**: N/A (validated, not persisted directly)
```
