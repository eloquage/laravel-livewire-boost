# Navigation

Livewire provides SPA-style navigation without full page reloads.

## wire:navigate

Add to links for instant navigation:

```blade
<a href="/posts" wire:navigate>Posts</a>
```

### Prefetch on Hover

```blade
<a href="/posts" wire:navigate.hover>Posts</a>
```

## Redirects with Navigate

```php
return $this->redirect('/posts', navigate: true);
```

## Page Components

Register full-page components as routes:

```php
Route::livewire('/', 'pages::dashboard');
Route::livewire('/posts', 'pages::posts.index');
Route::livewire('/posts/{post}', 'pages::posts.show');
```

## Active Link Styling

### data-current Attribute (Recommended)

Livewire auto-adds `data-current` to matching links:

```blade
<a href="/posts" wire:navigate class="data-current:font-bold">Posts</a>
```

### wire:current Directive

```blade
<a href="/posts" wire:navigate wire:current="font-bold text-blue-600">Posts</a>
```

## Persisting Elements

Keep elements (like audio players) across navigations:

```blade
@persist('player')
    <audio src="{{ $episode->file }}" controls></audio>
@endpersist
```

Must be outside Livewire components (in layout).

### Preserve Scroll

```blade
@persist('sidebar')
    <div wire:navigate:scroll class="overflow-y-scroll">...</div>
@endpersist
```

## JavaScript Hooks

```js
document.addEventListener('livewire:navigate', (e) => {
    // Before navigation, can preventDefault()
    e.detail.url; // Destination URL
    e.detail.history; // Is back/forward
    e.detail.cached; // Has cached version
});

document.addEventListener('livewire:navigating', (e) => {
    // HTML about to swap
    e.detail.onSwap(() => { /* after swap, before scripts */ });
});

document.addEventListener('livewire:navigated', () => {
    // Navigation complete (also fires on initial load)
});
```

## Manual Navigation

```js
Livewire.navigate('/new/url');
```

## Script Considerations

- **Replace `DOMContentLoaded`** with `livewire:navigated`.
- **Head scripts** run once; body scripts run on every page.
- **Use `data-navigate-once`** on body scripts to run only once.
- **Use `data-navigate-track`** on assets to reload page on version change.

## Progress Bar

Configure in `config/livewire.php`:

```php
'navigate' => [
    'show_progress_bar' => true,
    'progress_bar_color' => '#2299dd',
],
```

## Gotchas

- **Event listeners persist** across pages - use `{ once: true }` or clean up.
- **`@persist` must be outside components** (in layout).
- **`DOMContentLoaded` only fires once** - use `livewire:navigated` instead.

## Specification Format

```
**Navigation**: Main nav links
**Implementation**: wire:navigate on all links
**Prefetch**: .hover on primary links
**Active Styling**: data-current:font-bold
**Persisted Elements**: Audio player in layout
```
