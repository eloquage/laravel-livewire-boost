# Nesting & Communication

Livewire components can be nested for complex UIs.

## Passing Data to Children

```blade
<livewire:show-post :post="$post" />
```

Child receives in `mount()` or as typed property:

```php
class ShowPost extends Component
{
    public Post $post;
}
```

## Reactive Properties

Child re-renders when parent updates the passed prop:

```php
use Livewire\Attributes\Reactive;

class PostCount extends Component
{
    #[Reactive]
    public int $count;
}
```

```blade
<!-- Parent -->
<livewire:post-count :count="$this->posts->count()" />
```

## Modelable (wire:model on Component)

Allow parent to bind value:

```php
use Livewire\Attributes\Modelable;

class DatePicker extends Component
{
    #[Modelable]
    public $value;
}
```

```blade
<!-- Parent -->
<livewire:date-picker wire:model="selectedDate" />
```

## Events

### Dispatch from Child

```php
$this->dispatch('post-created', title: $post->title);
```

### Listen in Parent

```php
use Livewire\Attributes\On;

#[On('post-created')]
public function refreshList($title) { ... }
```

### Listen in Blade

```blade
<livewire:create-post @saved="close" />
<livewire:create-post @saved="close($event.detail.id)" />
```

### Targeted Dispatch

```php
// To specific component class
$this->dispatch('refresh')->to(Dashboard::class);

// To self only
$this->dispatch('internal')->self();
```

## Accessing Parent

From child Blade:

```blade
<button wire:click="$parent.save()">Save via Parent</button>
```

## Key on Nested Components

Always use `wire:key` when rendering components in loops:

```blade
@foreach ($posts as $post)
    <livewire:show-post :post="$post" :wire:key="$post->id" />
@endforeach
```

## Reactive vs Modelable

| Feature | #[Reactive] | #[Modelable] |
|---------|-------------|--------------|
| Direction | Parent → Child (one-way) | Parent ↔ Child (two-way) |
| Use Case | Display data, re-render on change | Form inputs, shared state |
| Syntax | `:prop="$value"` | `wire:model="prop"` |

## Communication Patterns

### Parent to Child

1. Pass data via props (`:prop`)
2. Use `#[Reactive]` for updates

### Child to Parent

1. Dispatch event from child
2. Listen with `#[On]` or `@event` in Blade

### Sibling to Sibling

1. Child A dispatches event
2. Child B listens (or parent relays)

## Gotchas

- **Props without #[Reactive]** don't trigger re-render on change.
- **#[Modelable]** only works with `wire:model`, not `:prop`.
- **Events bubble** - use `->self()` to restrict to component.
- **Missing wire:key** causes stale/incorrect component instances.

## Specification Format

```
**Parent**: Dashboard
**Children**:
  - PostList: :posts="$this->posts" (Reactive)
  - CreatePostModal: wire:model="showModal" (Modelable)
**Communication**:
  - CreatePostModal dispatches 'post-created'
  - Dashboard listens: #[On('post-created')] refreshPosts()
  - PostList re-renders via Reactive :posts
```
