# JavaScript & Alpine

Livewire is built on Alpine.js. Every Livewire component is an Alpine component.

## Accessing $wire

The `$wire` object provides JavaScript access to your component:

```blade
<div x-data>
    <span x-text="$wire.title"></span>
    <button x-on:click="$wire.title = ''">Clear</button>
    <button x-on:click="$wire.save()">Save</button>
</div>
```

### $wire Methods

| Method | Description |
|--------|-------------|
| `$wire.property` | Get/set property value |
| `$wire.method()` | Call component method |
| `$wire.set('prop', value)` | Set property (triggers request) |
| `$wire.set('prop', value, false)` | Set property (no request) |
| `$wire.$refresh()` | Refresh component |
| `$wire.$commit()` | Alias for $refresh |
| `$wire.upload(...)` | Upload file |
| `$wire.cancelUpload(...)` | Cancel upload |

## Script Tags in Components

### Single-file Components

Use bare `<script>` tags:

```blade
<div>
    <!-- template -->
</div>

<script>
    $wire.on('post-created', () => { ... });
    this.$on('custom-event', () => { ... });
    this.$dispatch('notify', { message: 'Hello' });
</script>
```

### Class-based Components

Wrap with `@script` directive:

```blade
@script
<script>
    $wire.on('post-created', () => { ... });
</script>
@endscript
```

## #[Js] Attribute

Execute method in browser, not server:

```php
#[Js]
public function clearTitle()
{
    return '$wire.title = ""';
}
```

```blade
<button wire:click="clearTitle">Clear</button>
```

## Alpine Modifiers

All Alpine modifiers work on `wire:` directives:

| Modifier | Description |
|----------|-------------|
| `.prevent` | Prevent default |
| `.stop` | Stop propagation |
| `.self` | Only if event from this element |
| `.debounce.Xms` | Debounce |
| `.throttle.Xms` | Throttle |
| `.window` | Listen on window |
| `.document` | Listen on document |
| `.outside` | Click outside |
| `.once` | Run once |

## Event Handling

```blade
<!-- Alpine listening for Livewire event -->
<div x-on:post-created.window="alert('Created!')"></div>

<!-- Dispatch to Livewire from Alpine -->
<button x-on:click="$dispatch('refresh-posts')">Refresh</button>
```

## Accessing Errors

```blade
<div wire:show="$errors.has('email')">
    <span wire:text="$errors.first('email')"></span>
</div>
```

Or via Alpine:

```blade
<span x-text="$wire.$errors.first('email')"></span>
```

## Gotchas

- **Single-file components**: Use bare `<script>`, NOT `@script`.
- **Class-based components**: MUST use `@script` wrapper.
- **`$wire.set()` default triggers request** - pass `false` as 3rd arg to defer.
- **Alpine `x-data` not needed** - Livewire components are already Alpine components.

## Specification Format

```
**JS Integration**: Character counter
**Implementation**:
  - x-text="$wire.title.length" for live count
  - No server request needed
**Script**: None required (uses Alpine directives only)
```
