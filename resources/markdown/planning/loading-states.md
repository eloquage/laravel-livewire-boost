# Loading States

Provide visual feedback during network requests.

## data-loading Attribute (Recommended)

Livewire automatically adds `data-loading` to elements triggering requests.

### Tailwind v4 Variants

| Variant | Description |
|---------|-------------|
| `data-loading:` | Style when this element is loading |
| `not-data-loading:` | Style when NOT loading (use for show on load) |
| `in-data-loading:` | Style when any ancestor is loading |
| `not-in-data-loading:` | Style when no ancestor is loading |
| `has-data-loading:` | Style when any child is loading |
| `peer-data-loading:` | Style based on sibling's loading state |

### Common Patterns

```blade
<!-- Dim button while loading -->
<button wire:click="save" class="data-loading:opacity-50">Save</button>

<!-- Show spinner only during load -->
<span class="not-data-loading:hidden">Saving...</span>

<!-- Style children when parent loads -->
<button wire:click="save">
    <span class="in-data-loading:hidden">Save</span>
    <span class="not-in-data-loading:hidden">Saving...</span>
</button>
```

### Plain CSS

```css
[data-loading] { opacity: 0.5; }
[data-loading] .spinner { display: block; }
```

## wire:loading Directive (Alternative)

```blade
<!-- Show during any request -->
<div wire:loading>Loading...</div>

<!-- Hide during request -->
<div wire:loading.remove>Content</div>

<!-- Target specific action -->
<div wire:loading wire:target="save">Saving...</div>

<!-- Add class during loading -->
<button wire:loading.class="opacity-50" wire:click="save">Save</button>

<!-- Remove class during loading -->
<button wire:loading.class.remove="bg-blue" wire:click="save">Save</button>

<!-- Delay showing (avoid flicker) -->
<div wire:loading.delay>Loading...</div>
<div wire:loading.delay.long>Loading...</div>
```

## wire:dirty Directive

Show when form has unsaved changes.

```blade
<span wire:dirty>Unsaved changes</span>

<!-- Target specific input -->
<span wire:dirty wire:target="title">Title changed</span>
```

## wire:offline Directive

Show when browser is offline.

```blade
<div wire:offline>You are offline</div>
```

## Gotchas

- `data-loading` is preferred over `wire:loading` for most use cases.
- `wire:loading` requires `wire:target` for specificity; `data-loading` auto-scopes.
- `in-data-loading:` applies to ALL ancestors - can cause unexpected styling.
- Tailwind v4 required for advanced `data-loading:` variants.

## Specification Format

```
**Element**: Save button
**Loading State**:
  - Dim to 50% opacity during save
  - Change text to "Saving..."
**Implementation**: 
  - class="data-loading:opacity-50"
  - Child spans with in-data-loading:/not-in-data-loading:hidden
```
