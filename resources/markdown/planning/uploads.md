# File Uploads

Livewire handles file uploads via the `WithFileUploads` trait.

## Basic Setup

```php
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component {
    use WithFileUploads;

    #[Validate('image|max:1024')] // 1MB max
    public $photo;

    public function save()
    {
        $this->photo->store('photos');
    }
};
```

```blade
<form wire:submit="save">
    <input type="file" wire:model="photo">
    @error('photo') <span>{{ $message }}</span> @enderror
    <button type="submit">Upload</button>
</form>
```

## Multiple Files

```php
#[Validate(['photos.*' => 'image|max:1024'])]
public $photos = [];

public function save()
{
    foreach ($this->photos as $photo) {
        $photo->store('photos');
    }
}
```

```blade
<input type="file" wire:model="photos" multiple>
```

## Storage Options

```php
$this->photo->store('photos');                    // Default disk
$this->photo->store('photos', 's3');              // S3 disk
$this->photo->storeAs('photos', 'avatar.png');    // Custom name
$this->photo->storePublicly('photos', 's3');      // Public visibility
```

## Preview URLs

```blade
@if ($photo)
    <img src="{{ $photo->temporaryUrl() }}">
@endif
```

## Progress Indicators

```blade
<div
    x-data="{ uploading: false, progress: 0 }"
    x-on:livewire-upload-start="uploading = true"
    x-on:livewire-upload-finish="uploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
>
    <input type="file" wire:model="photo">
    <div x-show="uploading">
        <progress max="100" x-bind:value="progress"></progress>
    </div>
</div>
```

## Cancel Upload

```blade
<button wire:click="$cancelUpload('photo')">Cancel</button>
```

## JS API

```html
<script>
    $wire.upload('photo', file, 
        (filename) => { /* success */ },
        () => { /* error */ },
        (event) => { /* progress: event.detail.progress */ }
    );
    $wire.uploadMultiple('photos', files, ...);
    $wire.removeUpload('photos', filename, ...);
    $wire.cancelUpload('photos');
</script>
```

## Testing

```php
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can upload photo', function () {
    Storage::fake('photos');
    $file = UploadedFile::fake()->image('avatar.png');

    Livewire::test('upload-photo')
        ->set('photo', $file)
        ->call('save');

    Storage::disk('photos')->assertExists('avatar.png');
});
```

## Gotchas

- **Reserved name**: Don't use `upload` as a method/property name.
- **Temporary URLs** only work for image MIME types.
- **S3 validation** requires public file access for rules like `dimensions`.
- **Default validation**: `file|max:12288` (12MB) applied globally.

## Specification Format

```
**Upload**: Avatar photo
**Property**: $photo
**Validation**: image, max:1024 (1MB)
**Storage**: photos directory, default disk
**UI**:
  - Preview via temporaryUrl()
  - Progress bar with Alpine
  - Cancel button
```
