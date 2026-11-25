# FLORA APP — PERMANENT DEVELOPMENT RULES

These instructions apply to ALL future development and modifications in this Laravel project.

## Project Architecture

1. Follow the existing Laravel architecture.
2. Always inspect existing files before creating new ones.
3. Use consistent naming conventions.
4. Keep database logic, application logic, and presentation logic separated.
5. Use Laravel conventions whenever possible.
6. Avoid unnecessary dependencies and duplicated code.
7. Reuse existing models, controllers, components, and functionality where appropriate.

## Blade Views

1. All admin pages MUST extend the shared admin master layout.
2. Never create a separate sidebar or header for an individual admin page.
3. Use reusable Blade components for repeated interface elements.
4. Keep individual views focused on their own page content.
5. Follow the established CSS and design system.

## Icons

1. NEVER use emojis anywhere in the application.
2. Use Font Awesome icons consistently.
3. Reuse the existing Font Awesome integration.
4. Select icons according to their actual purpose.
5. Preserve meaningful text labels.
6. Use accessible labels and tooltips where necessary.

## Database

1. Follow consistent migration naming conventions.
2. Use appropriate column names and data types.
3. Define model relationships correctly.
4. Use validation for submitted data.
5. Never modify existing database structures without understanding their dependencies.
6. Use new migrations for changes to an already-applied database schema.
7. Never execute destructive database commands without explicit approval.

## Controllers and Routes

1. Keep controllers organized and readable.
2. Avoid unnecessarily complicated controller methods.
3. Follow consistent route naming.
4. Do not duplicate business logic.
5. Preserve existing routes and functionality unless a change is requested.

## AI Modification Rules

1. Inspect before modifying.
2. Explain the proposed changes before major implementation.
3. Prefer small, targeted modifications.
4. Never rewrite an entire file for an unrelated minor change.
5. Do not modify unrelated files.
6. Identify dependencies when modifying shared functionality.
7. Show meaningful changes and explain them.
8. Ask for approval before destructive or significant architectural changes.
9. Test modifications before declaring them complete.

## Teaching Requirements

I am still learning Laravel and PHP.

Whenever you implement or modify something:

- Explain what you changed.
- Explain why it was necessary.
- Identify the affected files.
- Explain how the files interact.
- Provide commands I need to execute.
- Explain how to test the result.

Always prioritize maintainability, consistency, readability, and beginner-friendly explanations.
