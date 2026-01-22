# Troubleshooting

Common issues and diagnostic checks.

## Component Not Updating

**Symptoms**: UI doesn't reflect property changes.

**Checks**:
- [ ] Property is `public` (not `protected`/`private`)
- [ ] Using `wire:model` without `.live` (only syncs on action)
- [ ] Missing `wire:key` in loops
- [ ] JavaScript errors in console

**Fix**: Add `.live` for real-time updates, or ensure action triggers request.

## Hydration Errors

**Symptoms**: `CorruptComponentPayloadException` or similar.

**Checks**:
- [ ] Property type changed between requests
- [ ] Custom object doesn't implement `Wireable`
- [ ] Eloquent query constraints not preserved

**Fix**: Use `#[Computed]` for complex queries, implement `Wireable` for custom types.

## CSP (Content Security Policy) Errors

**Symptoms**: Livewire blocked by CSP, inline styles/scripts fail.

**Checks**:
- [ ] CSP nonce not configured
- [ ] Strict CSP blocking inline execution

**Fix**: Configure Livewire's CSP support:

```php
// In AppServiceProvider
Livewire::setScriptNonce($myNonce);
```

## @script Not Working

**Symptoms**: JavaScript in component doesn't execute.

**Checks**:
- [ ] Single-file component using `@script` (shouldn't)
- [ ] Class-based component NOT using `@script` (should)

**Fix**: 
- Single-file: Use bare `<script>` tags
- Class-based: Wrap with `@script`/`@endscript`

## wire:navigate Issues

**Symptoms**: Navigation breaks, scripts don't run.

**Checks**:
- [ ] Using `DOMContentLoaded` (should use `livewire:navigated`)
- [ ] Event listeners accumulating (not cleaned up)
- [ ] Third-party scripts need `data-spa="auto"`

**Fix**: Replace `DOMContentLoaded` with `livewire:navigated`, clean up listeners.

## File Upload Fails

**Symptoms**: Upload errors, validation fails on S3.

**Checks**:
- [ ] Missing `WithFileUploads` trait
- [ ] S3 files not publicly accessible for validation
- [ ] Using reserved `upload` method name

**Fix**: Add trait, configure S3 visibility, rename method.

## Validation Not Showing

**Symptoms**: Errors not displayed after submission.

**Checks**:
- [ ] Missing `@error` directive in Blade
- [ ] Using `rules()` method without `#[Validate]` attribute
- [ ] Form object errors need `form.` prefix

**Fix**: Add `@error('field')` blocks, ensure validation runs.

## Performance Issues

**Symptoms**: Slow responses, high server load.

**Checks**:
- [ ] Storing large collections in properties
- [ ] Missing computed property memoization
- [ ] Aggressive polling intervals
- [ ] Not using lazy loading for heavy components

**Fix**: Use `#[Computed]`, increase poll intervals, add `lazy`.

## Alpine Conflicts

**Symptoms**: Alpine directives don't work, errors in console.

**Checks**:
- [ ] Multiple Alpine versions loaded
- [ ] Conflicting x-data on Livewire component root

**Fix**: Livewire includes Alpine - don't load separately.

## Diagnostic Commands

```bash
# Clear all caches
php artisan optimize:clear

# Check Livewire config
php artisan livewire:config

# Verify component discovery
php artisan livewire:discover
```

## Browser DevTools

- **Network tab**: Check Livewire requests/responses
- **Console**: Look for JavaScript errors
- **Elements**: Verify `wire:` attributes present
- **Application > Local Storage**: Check for corrupted Livewire state
