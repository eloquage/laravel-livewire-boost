# Testing

Livewire provides a powerful testing API. **Use Pest** as the testing framework.

## Basic Test

```php
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('post.create')
        ->assertStatus(200);
});
```

## Setup Methods

| Method | Description |
|--------|-------------|
| `Livewire::test('component')` | Test component by name |
| `Livewire::test(Component::class, ['post' => $post])` | With mount params |
| `Livewire::actingAs($user)` | Authenticate user |
| `Livewire::withQueryParams(['search' => 'test'])` | Set URL params |
| `Livewire::withCookies(['key' => 'value'])` | Set cookies |
| `Livewire::withoutLazyLoading()` | Disable lazy loading |

## Interacting

| Method | Description |
|--------|-------------|
| `->set('prop', value)` | Set property |
| `->set(['a' => 1, 'b' => 2])` | Set multiple |
| `->toggle('active')` | Toggle boolean |
| `->call('method')` | Call action |
| `->call('method', $arg)` | Call with args |
| `->refresh()` | Refresh component |
| `->dispatch('event')` | Dispatch event |

## Assertions

### View

| Assertion | Description |
|-----------|-------------|
| `->assertSee('text')` | Text in HTML |
| `->assertDontSee('text')` | Text NOT in HTML |
| `->assertSeeHtml('<div>')` | Raw HTML present |
| `->assertViewHas('key', $value)` | View data |

### Properties

| Assertion | Description |
|-----------|-------------|
| `->assertSet('prop', value)` | Property equals |
| `->assertNotSet('prop', value)` | Property not equals |
| `->assertCount('items', 3)` | Array count |

### Validation

| Assertion | Description |
|-----------|-------------|
| `->assertHasErrors('field')` | Has validation error |
| `->assertHasErrors(['field' => 'required'])` | Specific rule |
| `->assertHasNoErrors()` | No errors |

### Events

| Assertion | Description |
|-----------|-------------|
| `->assertDispatched('event')` | Event dispatched |
| `->assertDispatched('event', key: 'value')` | With params |
| `->assertNotDispatched('event')` | NOT dispatched |

### Navigation

| Assertion | Description |
|-----------|-------------|
| `->assertRedirect('/path')` | Redirected |
| `->assertRedirectToRoute('name')` | To named route |
| `->assertNoRedirect()` | No redirect |

### Authorization

| Assertion | Description |
|-----------|-------------|
| `->assertForbidden()` | 403 response |
| `->assertUnauthorized()` | 401 response |
| `->assertStatus(500)` | Specific status |

## Testing Patterns

### Page Contains Component

```php
it('shows component on page', function () {
    $this->get('/posts/create')
        ->assertSeeLivewire('post.create');
});
```

### Create with Validation

```php
it('validates required fields', function () {
    Livewire::test('post.create')
        ->call('save')
        ->assertHasErrors(['title', 'content']);
});

it('creates post with valid data', function () {
    Livewire::test('post.create')
        ->set('title', 'Test Post')
        ->set('content', 'Content here')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect('/posts');

    expect(Post::where('title', 'Test Post')->exists())->toBeTrue();
});
```

### Authorization

```php
it('forbids unauthorized deletion', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(); // Different user

    Livewire::actingAs($user)
        ->test('post.edit', ['post' => $post])
        ->call('delete')
        ->assertForbidden();
});
```

### Events

```php
it('dispatches event on save', function () {
    Livewire::test('post.create')
        ->set('title', 'Test')
        ->call('save')
        ->assertDispatched('post-created');
});

it('listens to event', function () {
    Livewire::test('post-counter')
        ->assertSee('0')
        ->dispatch('post-created')
        ->assertSee('1');
});
```

### File Uploads

```php
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('uploads photo', function () {
    Storage::fake('photos');
    $file = UploadedFile::fake()->image('photo.jpg');

    Livewire::test('upload-photo')
        ->set('photo', $file)
        ->call('save');

    Storage::disk('photos')->assertExists('photo.jpg');
});
```

### URL/Query Params

```php
it('filters via URL', function () {
    Post::factory()->create(['title' => 'Laravel Tips']);
    Post::factory()->create(['title' => 'Vue Guide']);

    Livewire::withQueryParams(['search' => 'Laravel'])
        ->test('posts.index')
        ->assertSee('Laravel Tips')
        ->assertDontSee('Vue Guide');
});
```

### Pagination

```php
it('paginates results', function () {
    Post::factory()->count(25)->create();

    Livewire::test('posts.index')
        ->call('gotoPage', 2)
        ->assertSet('page', 2);
});

it('resets page on filter', function () {
    Livewire::test('posts.index')
        ->call('gotoPage', 3)
        ->set('search', 'test')
        ->assertSet('page', 1);
});
```

## Browser Testing (Pest v4)

```php
it('creates post in browser', function () {
    Livewire::visit('post.create')
        ->type('[wire\:model="title"]', 'Browser Test')
        ->press('Save')
        ->assertSee('Post created');
});
```

## Specification Format

```
**Test**: CreatePost component
**Cases**:
  1. Renders successfully
     - assertStatus(200)
  2. Validates required fields
     - call('save') without data
     - assertHasErrors(['title', 'content'])
  3. Creates post with valid data
     - set title, content
     - call('save')
     - assertRedirect('/posts')
     - DB has post
  4. Forbids unauthenticated
     - No actingAs
     - assertUnauthorized()
```
