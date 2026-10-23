## Livewire Boost

You are writing Livewire v4 implementation plans. Plans must be specific enough
that an implementing agent can write code without making decisions.

**Start here**: Read
`vendor/eloquage/laravel-livewire-boost/resources/markdown/planning/overview.md`
from the project root for the plan format, required sections, and questions to
clarify before planning.

### Planning Guides

| Guide | Purpose |
|-------|---------|
| `overview.md` | Plan structure, required sections, file index |
| `components.md` | Component types, lifecycle, properties |
| `properties.md` | Property types, attributes, security |
| `attributes.md` | All PHP attributes (#[Url], #[Validate], etc.) |
| `directives.md` | All wire:* directives and modifiers |
| `actions.md` | Methods, triggers, authorization |
| `forms.md` | Data binding, validation, form objects |
| `events.md` | Dispatch, listen, Alpine, Echo |
| `lifecycle.md` | mount, boot, hydrate, updated hooks |
| `nesting.md` | Parent-child, Reactive, Modelable |
| `loading-states.md` | data-loading, wire:loading, wire:dirty |
| `uploads.md` | File uploads, progress, testing |
| `pagination.md` | WithPagination, URL sync |
| `navigation.md` | wire:navigate, @@persist, redirects |
| `javascript-alpine.md` | $wire, @@script, Alpine integration |
| `performance.md` | Lazy, computed, polling, islands |
| `security.md` | Authorization, #[Locked], middleware |
| `testing.md` | Pest-first testing patterns |
| `checklist.md` | Common mistakes to avoid |
| `troubleshooting.md` | Diagnostic checks |

**Before finalizing**: Review `checklist.md` to catch common planning mistakes.
