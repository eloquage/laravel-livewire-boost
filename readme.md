# Livewire Boost

![Livewire Boost](art/banner.png)

**A Laravel Boost extension that helps AI agents produce accurate, detailed
implementation plans for Livewire v4.**

## Requirements

- PHP 8.2 or later
- Laravel Boost 1.8 or 2.x
- Filament 5

## Setup

Install Livewire Boost using Composer:

```bash
composer require eloquage/laravel-livewire-boost --dev
```

Then run the Boost installer and select **Livewire Boost** when prompted:

```bash
php artisan boost:install
```

To verify installation, check your `AGENTS.md`, `CLAUDE.md`, or similar file for
a new **Livewire Boost** section.

## Usage

1. Enable **planning mode** in your AI agent (Claude Code, Cursor, etc.)
2. Ask the agent to create a **Livewire Boost plan** for your feature

Example prompt:

```
Create a Livewire Boost plan for a task management dashboard.

Users can create, edit, and delete their own tasks. Each task has a title,
description, due date, priority (low, medium, high), and status (pending,
in_progress, completed).

I need real-time search with URL query string sync, filtering by status and
priority, and pagination. The task form should validate in real-time as users
type. Show loading states during saves and use optimistic UI where possible.
Only task owners can edit or delete their tasks.
```

The agent will produce a detailed specification document ready for direct
implementation. The planning guide asks for clarification when requirements
leave important implementation choices open.

## What's Included

Livewire Boost provides comprehensive planning guides covering:

- Components, properties, and lifecycle hooks
- Actions, forms, and validation patterns
- Events and parent-child communication
- Loading states, file uploads, and pagination
- Navigation, JavaScript/Alpine integration
- Security, performance, and testing

## License

MIT. Please see the [license file](license.md) for more information.
