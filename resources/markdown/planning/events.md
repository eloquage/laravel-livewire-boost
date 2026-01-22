# Events

Livewire's event system enables communication between components.

## Dispatching Events

```php
// Basic dispatch
$this->dispatch('post-created');

// With data
$this->dispatch('post-created', title: $post->title);

// To specific component
$this->dispatch('refresh')->to(Dashboard::class);

// To self only
$this->dispatch('internal-event')->self();
```

## Listening for Events

```php
use Livewire\Attributes\On;

#[On('post-created')]
public function handlePostCreated($title)
{
    // ...
}
```

### Dynamic Event Names

```php
#[On('post-updated.{post.id}')]
public function refreshPost() { ... }
```

### Listen from Specific Child

```blade
<livewire:edit-post @saved="close" />

<!-- With parameters -->
<livewire:edit-post @saved="close($event.detail.postId)" />
```

## JavaScript Events

### Dispatch from JS

```html
<script>
    this.$dispatch('post-created', { title: 'New Post' });
    this.$dispatchSelf('internal'); // Only to this component
</script>
```

### Listen in JS

```html
<script>
    this.$on('post-created', (event) => {
        console.log(event.detail.title);
    });
</script>
```

### Global JS Listener

```html
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('post-created', (event) => { ... });
    });
</script>
```

## Alpine Integration

```blade
<!-- Listen -->
<div x-on:post-created.window="..."></div>

<!-- Dispatch -->
<button x-on:click="$dispatch('post-created', { title: 'Title' })">
```

## Blade Dispatch

```blade
<button wire:click="$dispatch('show-modal', { id: {{ $post->id }} })">

<button wire:click="$dispatchTo('posts', 'refresh')">
```

## Laravel Echo (Real-time)

```php
#[On('echo:orders,OrderShipped')]
public function notifyNewOrder() { ... }

// Private channel
#[On('echo-private:orders,OrderShipped')]

// Dynamic channel
#[On('echo:orders.{order.id},OrderShipped')]
```

## Testing Events

```php
Livewire::test(CreatePost::class)
    ->call('save')
    ->assertDispatched('post-created');

// With params
->assertDispatched('notify', message: 'Post deleted');

// Test listener
Livewire::test(Dashboard::class)
    ->dispatch('post-created')
    ->assertSee('Posts: 1');
```

## Specification Format

```
**Event**: post-created
**Dispatched By**: PostCreate component, save() action
**Payload**: title (string)
**Listeners**:
  - Dashboard: #[On('post-created')] refreshStats()
  - Sidebar: @post-created="$refresh"
```
