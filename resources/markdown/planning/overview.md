# Plan Structure

> **For planning agents**: Your plan is the ONLY thing the implementing agent
> sees. Copy all relevant information from the guideline files into your plan.
> The implementing agent cannot access these files—if something isn't in your
> plan, they won't know it.

Your plan is a specification document for an implementing agent. It must be
complete enough that the implementing agent can write code without making
decisions.

## Before You Plan

Ask the user to clarify ambiguities before producing the plan. Don't guess.

| If the request mentions... | Ask about... |
| -------------------------- | ---------------------------------------------- |
| "Users can manage X" | Full-page component or modal? |
| "Real-time updates" | Polling interval or Broadcasting (Echo)? |
| "Multi-step form" | Single component with state or wizard? |
| "Form validation" | Real-time (wire:model.live) or on submit? |
| "Search functionality" | URL query strings (#[Url])? Reset pagination? |
| "File uploads" | Single or multiple? Max size? Allowed types? |
| "Remember state" | URL (#[Url]) or Session (#[Session])? |

**When to ask vs proceed:**

- Ask when the answer affects database schema or authorization
- Ask when there are multiple valid approaches with different tradeoffs
- Proceed when the choice is cosmetic or easily changed later

## Verifying Syntax

Before finalizing your plan, verify configuration methods using search-docs:

| Verify | How |
| ----------------------- | ----------------------------------------- |
| Lifecycle hooks | Check [lifecycle.md] |
| Property attributes | Check [attributes.md] |
| Blade directives | Check [directives.md] |
| Validation rules | Search Laravel validation docs |

**Keep URLs in plans**: After verifying, include documentation URLs as backup
references. Don't replace URLs with "search for X" - implementing agents need
direct links.

## Planning Order

Build your plan in this order:

1. **Models first** - Define tables, attributes, relationships
2. **Components second** - Properties, methods, and render logic
3. **Views third** - Blade templates, directives, and UI components
4. **Authorization fourth** - Policies and gate checks
5. **Tests last** - Test what you've specified above

This order ensures you don't reference things that aren't yet defined.

## Required Formats

Every plan element MUST include these lines. Do not omit any.

**Property**: Name, Type, Initial Value, Attributes (with full namespace)

**Method/Action**: Name, Parameters, Return Type, Authorization, Logic Description

**View Element**: Tag/Component, Wire Directives, Loading States

**Component**: Command (for new), Location (full path), Type (full-page/inline)

### Why Namespaces Matter

The implementing agent uses namespaces to write correct imports.

**Always include full namespaces**:

| Element | Namespace Pattern |
| -------------- | ----------------------------------------- |
| Components | `App\Livewire\{Component}` |
| Models | `App\Models\{Model}` |
| Attributes | `Livewire\Attributes\{Attribute}` |
| Form Objects | `App\Livewire\Forms\{Form}` |
| Traits | `Livewire\{Trait}` |

## New vs Update Plans

| Scenario | Commands | Specifications |
| --------------- | ------------------------ | -------------------------------- |
| New component | `php artisan make:livewire` | Full specification |
| Update component| No scaffold command | Only changes (Add/Modify/Remove) |
| New model | Create migration | Full attributes |
| Update model | Alter migration | Only changed attributes |

## Required Sections

Every plan needs these sections:

### 1. Commands

List every artisan command to run before writing code.

### 2. Models

Define every model with exact attributes and relationships. See Laravel docs.

### 3. Components

Specify every Livewire component. See [components.md].

### 4. Authorization

Describe who can do what. See [security.md].

### 5. Tests

List what to test. See [testing.md].

## File Directory

| File | Purpose |
| --------------------- | ---------------------------------------- |
| [overview.md] | Plan structure and required sections |
| [components.md] | Component anatomy, types, lifecycle |
| [properties.md] | Property types, attributes, security |
| [attributes.md] | All PHP attributes reference |
| [directives.md] | All wire:* directives reference |
| [actions.md] | Methods, triggers, authorization |
| [forms.md] | Data binding, form objects, validation |
| [events.md] | Dispatch, listen, Alpine integration |
| [lifecycle.md] | Hooks: mount, boot, hydrate, etc. |
| [nesting.md] | Parent-child communication |
| [loading-states.md] | data-loading, wire:loading, wire:dirty |
| [uploads.md] | File uploads, progress, testing |
| [pagination.md] | WithPagination, URL sync, reset |
| [navigation.md] | wire:navigate, @persist, redirects |
| [javascript-alpine.md]| $wire, @script, Alpine integration |
| [performance.md] | Lazy, computed, polling, islands |
| [security.md] | Authorization, #[Locked], middleware |
| [testing.md] | Pest-first test specifications |
| [checklist.md] | Common mistakes to avoid |
| [troubleshooting.md] | Diagnostic checks for common issues |

## When You're Stuck

| Situation | What to do |
| ---------------------------------- | -------------------------------------------- |
| Requirements contradict each other | Ask user which takes priority |
| Feature seems impossible | Ask user if you understood correctly |
| Multiple valid approaches | Explain tradeoffs, ask user to choose |
| Missing critical information | Ask user (see "Before You Plan" above) |
| Request is too large | Propose splitting into phases, confirm scope |

Don't guess on schema or authorization decisions.

## Before Finalizing

**You must review [checklist.md] before submitting your plan.**
