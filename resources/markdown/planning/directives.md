# Directives

Livewire directives (`wire:*`) connect Blade templates to component behavior.

## Action Directives

| Directive | Description |
|-----------|-------------|
| `wire:click="method"` | Call method on click |
| `wire:submit="method"` | Call method on form submit |
| `wire:keydown="method"` | Call method on keydown |
| `wire:keyup="method"` | Call method on keyup |
| `wire:change="method"` | Call method on change |
| `wire:input="method"` | Call method on input |

## Data Binding

| Directive | Description |
|-----------|-------------|
| `wire:model="prop"` | Two-way bind to property (syncs on action) |
| `wire:model.live="prop"` | Sync as user types (debounced 150ms) |
| `wire:model.blur="prop"` | Sync when input loses focus |
| `wire:model.change="prop"` | Sync on change event |
| `wire:model.number="prop"` | Cast to int |
| `wire:model.boolean="prop"` | Cast to bool |
| `wire:model.fill="prop"` | Use HTML `value` attribute as initial |

## UI Directives

| Directive | Description |
|-----------|-------------|
| `wire:loading` | Show element during any request |
| `wire:loading.remove` | Hide element during any request |
| `wire:dirty` | Show element when form is dirty |
| `wire:offline` | Show element when offline |
| `wire:target="method"` | Scope loading/dirty to specific action |
| `wire:confirm="message"` | Show confirmation before action |

## Navigation

| Directive | Description |
|-----------|-------------|
| `wire:navigate` | SPA-style navigation |
| `wire:navigate.hover` | Prefetch on hover |
| `wire:current="classes"` | Add classes when link is current |

## Other

| Directive | Description |
|-----------|-------------|
| `wire:key="unique"` | Unique key for list items (REQUIRED in loops) |
| `wire:ignore` | Exclude element from Livewire DOM diffing |
| `wire:poll="method"` | Call method at interval |
| `wire:init="method"` | Call method when component initializes |
| `wire:transition` | Apply view transitions |

## Action Modifiers

| Modifier | Description |
|----------|-------------|
| `.prevent` | Prevent default browser behavior |
| `.stop` | Stop event propagation |
| `.self` | Only trigger if event originated on this element |
| `.debounce.Xms` | Debounce action (e.g., `.debounce.500ms`) |
| `.throttle.Xms` | Throttle action |
| `.window` | Listen on `window` object |
| `.document` | Listen on `document` object |

## Magic Actions (No PHP Method Needed)

| Action | Description |
|--------|-------------|
| `$set('prop', value)` | Set property value |
| `$toggle('prop')` | Toggle boolean property |
| `$refresh` | Refresh component |
| `$dispatch('event')` | Dispatch browser event |
| `$parent.method()` | Call method on parent component |

## Specification Format

```
**Element**: <button>
**Directives**:
  - wire:click="save"
  - wire:loading.class="opacity-50"
  - wire:confirm="Are you sure?"
**Purpose**: Submit form with loading state and confirmation
```
