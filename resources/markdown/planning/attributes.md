# Attributes

PHP Attributes modify component, property, and method behavior.

## Property Attributes

| Attribute | Namespace | Use When |
|-----------|-----------|----------|
| `#[Url]` | `Livewire\Attributes\Url` | Sync property with query string. Supports `as:`, `history:`, `keep:`. |
| `#[Session]` | `Livewire\Attributes\Session` | Persist property value in session across requests. |
| `#[Locked]` | `Livewire\Attributes\Locked` | Prevent client-side modification. Throws error on tampering. |
| `#[Reactive]` | `Livewire\Attributes\Reactive` | Child re-renders when parent updates this prop. |
| `#[Modelable]` | `Livewire\Attributes\Modelable` | Allow parent to bind via `wire:model`. |
| `#[Validate]` | `Livewire\Attributes\Validate` | Validation rules. Supports `as:`, `message:`, `onUpdate:`. |

## Method Attributes

| Attribute | Namespace | Use When |
|-----------|-----------|----------|
| `#[Computed]` | `Livewire\Attributes\Computed` | Memoized derived value. Access via `$this->propName`. Supports `persist:`, `cache:`. |
| `#[On]` | `Livewire\Attributes\On` | Listen for dispatched event. Supports dynamic names `{prop.id}`. |
| `#[Renderless]` | `Livewire\Attributes\Renderless` | Skip render after action. Good for performance. |
| `#[Js]` | `Livewire\Attributes\Js` | Execute method in browser, not server. Return JS code string. |

## Class Attributes

| Attribute | Namespace | Use When |
|-----------|-----------|----------|
| `#[Layout]` | `Livewire\Attributes\Layout` | Set layout for full-page component. |
| `#[Title]` | `Livewire\Attributes\Title` | Set page title for full-page component. |
| `#[Lazy]` | `Livewire\Attributes\Lazy` | Defer component loading until visible. |
| `#[Isolate]` | `Livewire\Attributes\Isolate` | Prevent batching with sibling components. |
| `#[Async]` | `Livewire\Attributes\Async` | Execute actions in parallel. |

## Common Patterns

### URL-bound Search

```php
#[Url(as: 'q', history: true)]
public string $search = '';
```

### Validated Property with Custom Message

```php
#[Validate('required', message: 'Please provide a title')]
#[Validate('min:5', message: 'Title too short')]
public string $title = '';
```

### Computed with Caching

```php
#[Computed(persist: true, cache: true)]
public function posts()
{
    return Post::all();
}
```

### Event Listener with Dynamic Name

```php
#[On('post-updated.{post.id}')]
public function refreshPost() { ... }
```

## Specification Format

```
**Attribute**: #[Url(as: 'q', history: true)]
**Applied To**: $search property
**Purpose**: Sync search with ?q= query param, push to history
```
