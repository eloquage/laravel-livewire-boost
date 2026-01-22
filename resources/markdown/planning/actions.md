# Actions

Actions are public methods on components that handle user interactions.

## Triggering Actions

| Directive | Trigger |
|-----------|---------|
| `wire:click="method"` | Click |
| `wire:submit="method"` | Form submit |
| `wire:keydown="method"` | Key down |
| `wire:keydown.enter="method"` | Enter key |
| `wire:change="method"` | Input change |
| `wire:input="method"` | Input event |

### With Parameters

```blade
<button wire:click="delete({{ $post->id }})">Delete</button>
```

## Action Modifiers

| Modifier | Description |
|----------|-------------|
| `.prevent` | Prevent default browser behavior |
| `.stop` | Stop event propagation |
| `.self` | Only if event from this element |
| `.debounce.Xms` | Debounce (e.g., `.debounce.500ms`) |
| `.throttle.Xms` | Throttle |
| `.window` | Listen on window |
| `.document` | Listen on document |

## Magic Actions (No PHP Method)

| Action | Description |
|--------|-------------|
| `$set('prop', value)` | Set property |
| `$toggle('prop')` | Toggle boolean |
| `$refresh` | Refresh component |
| `$dispatch('event')` | Dispatch event |
| `$parent.method()` | Call parent method |

## Method Attributes

| Attribute | Effect |
|-----------|--------|
| `#[Renderless]` | Skip re-render after action (performance) |
| `#[Js]` | Execute in browser, not server |

## Confirmation

```blade
<button
    wire:click="delete"
    wire:confirm="Are you sure?"
>Delete</button>
```

## Authorization (CRITICAL)

**Action parameters are user input. Always authorize.**

```php
public function delete($id)
{
    $post = Post::find($id);
    $this->authorize('delete', $post); // REQUIRED
    $post->delete();
}
```

## Redirecting

```php
public function save()
{
    // ...
    return $this->redirect('/posts');
    
    // With wire:navigate
    return $this->redirect('/posts', navigate: true);
    
    // To route
    return $this->redirectRoute('posts.index');
    
    // To intended
    return $this->redirectIntended('/dashboard');
}
```

## Returning Values

Actions can return:

- `void` - Normal render
- `redirect()` - Redirect response
- File download via `$this->download()`

## Flash Messages

```php
session()->flash('message', 'Post created!');
```

## Validation in Actions

```php
public function save()
{
    $validated = $this->validate([
        'title' => 'required|min:3',
        'content' => 'required',
    ]);
    
    Post::create($validated);
}
```

## Async/Parallel Execution

```php
#[Async]
public function refreshStats() { ... }
```

Or in Blade:

```blade
<button wire:click.async="refreshStats">Refresh</button>
```

## Testing Actions

```php
Livewire::test(CreatePost::class)
    ->set('title', 'Test')
    ->call('save')
    ->assertRedirect('/posts');
```

## Gotchas

- **Never trust parameters** - Always validate/authorize.
- **Renderless skips UI update** - Use only when no visual change needed.
- **`#[Js]` returns JS code** - Not PHP, executes in browser.

## Specification Format

```
**Action**: delete
**Trigger**: wire:click="delete({{ $post->id }})"
**Confirmation**: "Are you sure you want to delete this post?"
**Parameters**: $id (int) - Post ID
**Authorization**: $this->authorize('delete', $post)
**Logic**:
  1. Find Post by ID
  2. Authorize deletion
  3. Delete post
  4. Dispatch 'post-deleted' event
  5. Redirect to /posts
```
