# Components

Livewire components are the core building blocks. Each consists of a PHP class and a Blade view.

## Component Types

| Type | Use When |
|------|----------|
| **Single-file** | Simple components, co-located PHP + Blade |
| **Multi-file** | Larger components, separate class and view |
| **Full-page** | Route endpoint, has layout |
| **Inline** | Very simple, template in render() method |

## Single-file Component

```php
<?php // resources/views/components/post/⚡create.blade.php

use Livewire\Component;

new class extends Component {
    public $title = '';

    public function save() { ... }
};
?>

<form wire:submit="save">
    <input wire:model="title">
    <button>Save</button>
</form>
```

## Full-page Component

```php
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Create Post')]
class CreatePost extends Component { ... }
```

Route registration:

```php
Route::livewire('/posts/create', 'pages::post.create');
```

## Lifecycle Hooks

| Hook | When | Use For |
|------|------|---------|
| `mount()` | Once, first render | Initialize properties |
| `boot()` | Every request | Dependency injection |
| `hydrate()` | Subsequent requests | Restore state |
| `dehydrate()` | End of request | Serialize state |
| `updating($prop)` | Before update | Validate/reject |
| `updated($prop)` | After update | Transform values |

## Properties

Public properties are automatically available in the view.

### Supported Types

- Primitives: `string`, `int`, `bool`, `array`, `null`
- Objects: `Collection`, `Model`, `Carbon`, `BackedEnum`
- Custom: Implement `Wireable` interface

### Property Attributes

| Attribute | Purpose |
|-----------|---------|
| `#[Url]` | Sync with query string |
| `#[Session]` | Persist in session |
| `#[Locked]` | Prevent client modification |
| `#[Validate]` | Attach validation rules |
| `#[Reactive]` | Re-render child on change |
| `#[Modelable]` | Allow wire:model from parent |

## Render Method

Explicit render (optional):

```php
public function render()
{
    return view('livewire.create-post', [
        'posts' => Post::all(),
    ]);
}
```

Computed properties (preferred):

```php
#[Computed]
public function posts()
{
    return Post::all();
}
```

Access in view: `$this->posts`

## Key Rules

- **Single root element** - Components must have exactly one root HTML element.
- **No `__construct()`** - Use `mount()` for initialization.
- **Reserved names** - Avoid: `id`, `rules`, `messages`.
- **`wire:key` in loops** - Always add for proper DOM diffing.

## Gotchas

- `mount()` only runs once, not on subsequent requests.
- Eloquent query constraints are NOT preserved - use `#[Computed]`.
- Protected/private properties are not available in views.

## Specification Format

```
**Component**: App\Livewire\Posts\CreatePost
**Type**: Full-page
**Route**: /posts/create
**Layout**: layouts.app
**Title**: Create Post
**Properties**:
  - $title: string, '', #[Validate('required|min:3')]
  - $content: string, ''
**Methods**:
  - save(): void - Validates, creates Post, redirects
**View**: Single-file (resources/views/pages/post/⚡create.blade.php)
```
