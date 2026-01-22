# Performance

Optimize Livewire component performance.

## Lazy Loading

Defer component rendering until visible in viewport:

```php
#[Lazy]
class HeavyComponent extends Component { ... }
```

Or in Blade:

```blade
<livewire:heavy-component lazy />
```

### Placeholder

```blade
<livewire:heavy-component lazy>
    <x-slot:placeholder>
        <div>Loading...</div>
    </x-slot:placeholder>
</livewire:heavy-component>
```

Or via `placeholder()` method:

```php
public function placeholder()
{
    return view('placeholders.skeleton');
}
```

### On Specific Events

```blade
<livewire:chart lazy="on-load" />  <!-- On page load -->
<livewire:chart lazy="on-intersect" />  <!-- On scroll into view (default) -->
```

## Computed Properties

Memoized per-request to avoid redundant queries:

```php
#[Computed]
public function posts()
{
    return Post::where('user_id', auth()->id())->get();
}
```

Access multiple times, query runs once:

```blade
Count: {{ $this->posts->count() }}
@foreach ($this->posts as $post) ...
```

### Caching Across Requests

```php
#[Computed(persist: true)]  // Session cache
#[Computed(cache: true)]    // Application cache
```

## Polling

Update component at intervals:

```blade
<div wire:poll>...</div>              <!-- Every 2s -->
<div wire:poll.5s>...</div>           <!-- Every 5s -->
<div wire:poll.visible>...</div>      <!-- Only when visible -->
<div wire:poll.keep-alive>...</div>   <!-- Even when tab inactive -->
```

Call specific method:

```blade
<div wire:poll="refreshStats">...</div>
```

## Renderless Actions

Skip re-render when action doesn't change UI:

```php
#[Renderless]
public function trackClick()
{
    Analytics::track('button_clicked');
}
```

## Isolate Components

Prevent batching with siblings (useful for independent updates):

```php
#[Isolate]
class IndependentWidget extends Component { ... }
```

## Islands

Render only part of a page as Livewire:

```blade
@island('chart-widget')
    <livewire:chart :data="$data" />
@endisland
```

## Wire:key

**Always use in loops** for efficient DOM updates:

```blade
@foreach ($posts as $post)
    <div wire:key="{{ $post->id }}">{{ $post->title }}</div>
@endforeach
```

## Reduce Payload Size

- **Don't store large collections** in properties - use computed properties.
- **Lock IDs** instead of full models when possible.
- **Use pagination** instead of loading all records.

## Gotchas

- **Lazy components** make separate request - add to initial page load if always needed.
- **Computed properties** only memoized within single request.
- **Polling** can strain server - use reasonable intervals and `.visible`.
- **Missing `wire:key`** causes DOM diffing issues in loops.

## Specification Format

```
**Optimization**: Dashboard widgets
**Techniques**:
  - Lazy load heavy charts
  - Computed properties for queries
  - wire:poll.30s.visible for real-time data
  - wire:key on all list items
```
