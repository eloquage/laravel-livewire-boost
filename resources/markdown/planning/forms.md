# Forms

Livewire excels at form handling with real-time validation.

## Data Binding

```blade
<input wire:model="title">
```

### Modifiers

| Modifier | Behavior |
|----------|----------|
| (none) | Sync on action (submit, click) |
| `.live` | Sync as user types (150ms debounce) |
| `.blur` | Sync when input loses focus |
| `.change` | Sync on change event |
| `.debounce.Xms` | Custom debounce (with `.live`) |
| `.number` | Cast to int |
| `.boolean` | Cast to bool |
| `.fill` | Use HTML value as initial |

## Input Types

```blade
<!-- Text -->
<input type="text" wire:model="title">

<!-- Textarea -->
<textarea wire:model="content"></textarea>

<!-- Checkbox (boolean) -->
<input type="checkbox" wire:model="active">

<!-- Checkbox (array) -->
<input type="checkbox" value="email" wire:model="notifications">
<input type="checkbox" value="sms" wire:model="notifications">

<!-- Radio -->
<input type="radio" value="yes" wire:model="subscribe">
<input type="radio" value="no" wire:model="subscribe">

<!-- Select -->
<select wire:model="status">
    <option value="">Select...</option>
    <option value="draft">Draft</option>
    <option value="published">Published</option>
</select>

<!-- Multi-select -->
<select wire:model="tags" multiple>...</select>
```

## Form Objects

Extract form logic to reusable class:

```php
namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;

class PostForm extends Form
{
    #[Validate('required|min:5')]
    public $title = '';

    #[Validate('required')]
    public $content = '';

    public function store()
    {
        return Post::create($this->all());
    }
}
```

Usage:

```php
class CreatePost extends Component
{
    public PostForm $form;

    public function save()
    {
        $post = $this->form->store();
        return $this->redirect('/posts');
    }
}
```

```blade
<input wire:model="form.title">
@error('form.title') {{ $message }} @enderror
```

## Validation

### Via Attribute

```php
#[Validate('required|min:3')]
public $title = '';
```

### Via Method

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

### Via rules() Method

```php
protected function rules()
{
    return [
        'title' => ['required', Rule::unique('posts')->ignore($this->post)],
    ];
}
```

### Custom Messages

```php
#[Validate('required', message: 'Title is required')]
#[Validate('min:5', message: 'Title too short')]
public $title = '';
```

## Displaying Errors

```blade
<input wire:model="title">
@error('title') <span class="text-red-500">{{ $message }}</span> @enderror
```

### JavaScript Access

```blade
<div wire:show="$errors.has('email')">
    <span wire:text="$errors.first('email')"></span>
</div>
```

## Real-time Validation

Use `wire:model.blur` or `wire:model.live` with `#[Validate]`:

```php
#[Validate('required|email')]
public $email = '';
```

```blade
<input wire:model.blur="email">
```

Validates on blur, shows error immediately.

## Manual Error Handling

```php
$this->addError('email', 'This email is taken');
$this->resetValidation('email');
$this->getErrorBag();
```

## File Uploads

See [uploads.md] for full documentation.

```php
use Livewire\WithFileUploads;

class Upload extends Component
{
    use WithFileUploads;

    #[Validate('image|max:1024')]
    public $photo;

    public function save()
    {
        $this->photo->store('photos');
    }
}
```

## Dependent Selects

```blade
<select wire:model.live="state">...</select>

<select wire:model="city" wire:key="{{ $state }}">
    @foreach (City::where('state_id', $state)->get() as $city)
        <option value="{{ $city->id }}">{{ $city->name }}</option>
    @endforeach
</select>
```

Note: `wire:key` is required on dependent select.

## Gotchas

- **wire:model without modifier** only syncs on action, not as you type.
- **Form object errors** use `form.field` prefix in @error.
- **rules() method** doesn't auto-validate on update - add empty `#[Validate]`.
- **Dependent selects** need `wire:key` to reset properly.

## Specification Format

```
**Form**: Create Post
**Object**: App\Livewire\Forms\PostForm (optional)
**Fields**:
  - title: text, wire:model.blur, required|min:5
  - content: textarea, wire:model, required
  - photo: file, wire:model, image|max:1024
**Submission**:
  - Button: "Create Post"
  - Loading: data-loading:opacity-50
  - Action: save()
**Validation**: Real-time on blur for title
```
