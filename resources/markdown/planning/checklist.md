# Common Planning Mistakes

> **For planning agents**: Review this checklist before finalizing your plan.

## Vague Specifications

| Bad | Good |
|-----|------|
| "Add a form" | Full form spec with fields, validation, submission |
| "Validate input" | `#[Validate('required\|email\|max:255')]` |
| "Update user" | `Action: save() -> validates -> $user->update() -> redirect` |
| "Handle events" | `Dispatches: 'post-created' / Listens: #[On('post-created')]` |
| "Add loading state" | `data-loading:opacity-50` on button |

## Missing Namespaces

Every element MUST have full namespace.

| Element | Pattern |
|---------|---------|
| Components | `App\Livewire\Posts\CreatePost` |
| Attributes | `Livewire\Attributes\Validate` |
| Form Objects | `App\Livewire\Forms\PostForm` |
| Traits | `Livewire\WithFileUploads` |

## Missing Component Elements

- [ ] Command (`php artisan make:livewire ...`)
- [ ] Route (if full-page)
- [ ] Layout attribute (if full-page)
- [ ] Properties with types and initial values
- [ ] Attributes on properties (Validate, Url, Locked, etc.)
- [ ] Methods with authorization
- [ ] View structure

## Security Gaps

- [ ] Action parameters not authorized
- [ ] Public property IDs not locked
- [ ] Missing `#[Locked]` on sensitive data
- [ ] No `$this->authorize()` before destructive operations
- [ ] Validation missing before database writes

## State Management Unclear

For each property, specify:

- [ ] Is it local or URL-bound (`#[Url]`)?
- [ ] Is it persisted (`#[Session]`)?
- [ ] Is it locked (`#[Locked]`)?
- [ ] Is it shared with children (`#[Reactive]` / `#[Modelable]`)?

## Missing Tests

- [ ] No happy path tests
- [ ] No validation failure tests
- [ ] No authorization failure tests
- [ ] No event dispatch/listen tests

## Script Tag Errors

| Scenario | Correct Approach |
|----------|------------------|
| Single-file component | Bare `<script>` tag |
| Class-based component | `@script` / `@endscript` wrapper |

## Wire Directive Issues

| Wrong | Right |
|-------|-------|
| `wire:model` expecting live updates | `wire:model.live` or `wire:model.blur` |
| Missing `wire:key` in loops | `wire:key="{{ $item->id }}"` |
| `wire:loading` without target | `wire:loading wire:target="save"` |

## Attribute Mistakes

| Wrong | Right |
|-------|-------|
| `#[Url]` on protected property | `#[Url]` on public property |
| `#[Computed]` on void method | `#[Computed]` on method returning value |
| `#[Validate]` without rules method | Empty `#[Validate]` triggers rules() validation |

## Navigation Pitfalls

- [ ] Using `DOMContentLoaded` (should use `livewire:navigated`)
- [ ] Event listeners not cleaned up
- [ ] `@persist` inside component (must be in layout)

## Performance Omissions

- [ ] Large collections stored in properties (use `#[Computed]`)
- [ ] Missing lazy loading on heavy components
- [ ] Aggressive polling without `.visible`
- [ ] Missing `wire:key` in loops

## Form Object Errors

- [ ] Forgot `form.` prefix in Blade (`@error('form.title')`)
- [ ] Forgot `form.` prefix in wire:model (`wire:model="form.title"`)

## Pagination Issues

- [ ] Missing `resetPage()` when filtering
- [ ] Missing `wire:key` on paginated items
- [ ] Multiple paginators without unique `pageName`

## File Upload Issues

- [ ] Missing `WithFileUploads` trait
- [ ] Using reserved `upload` method name
- [ ] S3 validation rules failing (need public access)

## Final Verification

Before submitting:

- [ ] All properties have types and initial values
- [ ] All attributes include full namespaces
- [ ] All actions have authorization specified
- [ ] All forms have validation rules
- [ ] All loops have `wire:key`
- [ ] All tests cover happy + failure paths
- [ ] Security checklist reviewed
