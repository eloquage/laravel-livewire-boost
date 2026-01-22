# Pagination

Livewire integrates with Laravel's pagination.

## Basic Setup

```php
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    #[Computed]
    public function posts()
    {
        return Post::paginate(10);
    }
};
```

```blade
<div>
    @foreach ($this->posts as $post)
        <div wire:key="{{ $post->id }}">{{ $post->title }}</div>
    @endforeach

    {{ $this->posts->links() }}
</div>
```

## URL Query String

Sync page number with URL:

```php
use Livewire\Attributes\Url;

#[Url]
public int $page = 1;
```

## Reset on Filter Change

```php
public $search = '';

public function updatedSearch()
{
    $this->resetPage();
}
```

## Multiple Paginators

```php
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    #[Computed]
    public function posts()
    {
        return Post::paginate(10, pageName: 'posts');
    }

    #[Computed]
    public function comments()
    {
        return Comment::paginate(10, pageName: 'comments');
    }

    public function updatedSearch()
    {
        $this->resetPage('posts');
        $this->resetPage('comments');
    }
};
```

## Custom Pagination Views

```php
{{ $this->posts->links('custom-pagination') }}
```

## Simple Pagination

```php
return Post::simplePaginate(10);
```

## Cursor Pagination

```php
return Post::cursorPaginate(10);
```

## Testing

```php
it('paginates posts', function () {
    Post::factory()->count(25)->create();

    Livewire::test('posts.index')
        ->assertSee('Post 1')
        ->call('nextPage')
        ->assertDontSee('Post 1')
        ->assertSee('Post 11');
});

it('resets page on search', function () {
    Post::factory()->count(25)->create();

    Livewire::test('posts.index')
        ->call('gotoPage', 2)
        ->set('search', 'test')
        ->assertSet('page', 1);
});
```

## Gotchas

- **Always use `wire:key`** in loops for proper DOM diffing.
- **Call `resetPage()`** when filtering to avoid empty results.
- **URL sync** requires `#[Url]` on `$page` property.
- **Multiple paginators** need unique `pageName` values.

## Specification Format

```
**Pagination**: Posts list
**Per Page**: 10
**Paginator**: Standard (with page numbers)
**URL Sync**: Yes, #[Url] on $page
**Reset On**: $search change
```
