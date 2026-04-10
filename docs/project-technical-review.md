# Shreenathji Darshan Project Technical Review

See also: [roles-and-responsibilities.md](./roles-and-responsibilities.md) for the RBAC interpretation and project ownership view.

## 1. Project Summary

This repository is a Laravel 10 application that serves two main purposes:

- A public-facing website rendered with Blade for the front page.
- A JSON API for authentication, user management, roles/permissions, darshan timings, packages, features, and bookings.

The domain model suggests a temple darshan booking system where administrators manage packages, feature cards, darshan schedule entries, user access, and booking records. The API is the main product surface; the Blade frontend is currently lightweight and mostly acts as a simple landing page.

## 2. Current Stack

The stack below is based on `composer.json`, `package.json`, and the active codebase:

- PHP `^8.1`
- Laravel Framework `^10.0`
- Laravel Passport `^12.2` for API token auth
- Laravel Sanctum `^3.2` is installed but not the primary auth mechanism in the current API routes
- Vite `^4.0.0` with `laravel-vite-plugin`
- Axios in the frontend toolchain
- `maatwebsite/excel` present for import/export workflows
- `mike42/escpos-php` present for printing-related workflows
- Firebase messaging integration is implemented in code via `Kreait\Firebase\Factory`

## 3. Architecture Overview

### 3.1 Application shape

- `routes/web.php` exposes `/` and renders `resources/views/index.blade.php` through `FrontpageController`.
- `routes/api.php` contains the main application surface.
- Business logic is mostly controller-centric.
- Models map directly to application tables with light relationships.
- Role-based access data exists in the database layer, but route/controller enforcement is only partially implemented.

### 3.2 Main modules

- Authentication: login, register, logout, reset-password
- Users: CRUD plus device token registration
- Roles: CRUD with soft-delete via `flag`
- Permissions: permission catalog, role-to-permission mapping, user-to-permission mapping
- Packages: CRUD with price/description metadata
- Features: CRUD plus file upload for feature icons
- Darshan Timings: CRUD for schedule windows
- Bookings: public create/show, protected list/update/delete
- Notifications: Firebase push notifications triggered from booking creation

### 3.3 Frontend layer

- The frontend is minimal.
- The only active web route is `/`
- `FrontpageController` passes a placeholder `$result = 42` into the view, which indicates the web side is still thin or in-progress.

## 4. API Surface

The API is defined in `routes/api.php`.

### 4.1 Public routes

- `POST /login`
- `POST /register`
- `POST /reset-password`
- `GET /role`
- `GET /role/{id}`
- `POST /booking`
- `GET /booking/{id}`
- `GET /user`
- `GET /user/{id}`
- `GET /features`
- `GET /features/{id}`
- `GET /package`
- `GET /package/{id}`
- `GET /darshantiming`
- `GET /darshantiming/{id}`
- `GET /permissions`
- `GET /role-has-permissions/{id}`
- `GET /user-has-permissions/{id}`
- `GET /permissions/distinct/name`

### 4.2 Protected routes under `auth:api`

- `POST /logout`
- `POST /role`
- `PUT /role/{id}`
- `DELETE /role/{id}`
- `POST /user`
- `POST /user/{id}`
- `POST /user/device-token/{id}`
- `DELETE /user/{id}`
- `POST /features`
- `PUT /features/{id}`
- `DELETE /features/{id}`
- `POST /package`
- `PUT /package/{id}`
- `DELETE /package/{id}`
- `POST /darshantiming`
- `PUT /darshantiming/{id}`
- `DELETE /darshantiming/{id}`
- `POST /role-has-permissions`
- `POST /user-has-permissions`
- `PUT /booking/{id}`
- `GET /booking`
- `DELETE /booking/{id}`

### 4.3 Access control observation

Authentication is enforced for the protected route group, but business permission checks are mostly not enforced even though the tables and helper functions exist. This is an important gap between the intended RBAC design and the current runtime behavior.

## 5. Data Model Summary

### 5.1 Users

- Stored in `users`
- Important fields include `name`, `email`, `password`, `role_id`, `device_tokens`, `flag`
- `role_id` points to a record in `roles`
- `device_tokens` stores JSON for push notification targets

### 5.2 Roles

- Stored in `roles`
- Fields: `id`, `name`, `flag`, timestamps
- Roles are database-driven; no canonical role list is seeded in the repository
- Soft-delete behavior is implemented by setting `flag = 1`

### 5.3 Permissions

- Stored in `permissions`
- Fields: `name`, `action`, `guard_name`
- The design is action-oriented, for example a resource name plus action combination

### 5.4 Role-permission mapping

- Stored in `role_permissions`
- Connects a role to a set of permissions
- Used as the source for role-level capabilities

### 5.5 User-permission mapping

- Stored in `user_has_permissions`
- Connects a user to specific permissions while preserving the associated `role_id`
- Supports direct per-user permission assignment or override behavior

### 5.6 Packages

- Stored in `packages`
- Fields include `name`, `price`, `description`, `is_active`, `is_deleted`
- Used during booking amount calculation

### 5.7 Features

- Stored in `features`
- Fields include `title`, `icon`, `is_active`, `is_deleted`
- Supports uploaded icon assets under `public/uploads/features`

### 5.8 Darshan Timings

- Stored in `darshan_timings`
- The schema evolved from one `time` column to `start_time` and `end_time`
- Records also carry `title`, `type`, `is_active`, `is_deleted`

### 5.9 Bookings

- Stored in `bookings`
- Fields include `customer_name`, `phone_number`, `time`, `date`, `members`, `amount`, `darshan_id`, `package_id`, `is_verified`
- Booking amount is derived from package price multiplied by guest count

## 6. Authentication And RBAC Behavior

### 6.1 Authentication flow

- Login uses `Auth::attempt(...)`
- Successful login creates a Passport access token with `$user->createToken(...)->accessToken`
- Protected routes are grouped under `auth:api`

### 6.2 Role assignment

- Users are assigned one `role_id`
- The login response includes both `role` and `role_name`

### 6.3 Permission model

- Role permissions are assigned through `POST /role-has-permissions`
- User-specific permissions are assigned through `POST /user-has-permissions`
- Helper functions `assingPermission()` and `checkPermission()` exist in `app/Helpers/helper.php`

### 6.4 Enforcement gap

- The permission model is present structurally, but enforcement is largely inactive
- Example: `UserController` contains a commented permission check
- Most write endpoints rely only on authentication, not on fine-grained permission validation

## 7. Findings And Risks

The items below are grounded in the current codebase and should be treated as concrete review findings.

### 7.1 Missing or inactive permission enforcement

Severity: High

- The project defines roles, permissions, role-permission mapping, user-permission mapping, and helper functions for permission checks.
- Most controllers do not actively call `checkPermission()`.
- A commented example exists in `UserController`, showing the design intent but not current enforcement.
- Result: any authenticated user may be able to perform administrative actions that appear intended for privileged roles.

### 7.2 Public exposure of sensitive admin-style endpoints

Severity: High

- `GET /user`, `GET /user/{id}`, `GET /permissions`, `GET /role-has-permissions/{id}`, and `GET /user-has-permissions/{id}` are publicly accessible.
- This exposes internal application structure and user/permission data without authentication.
- Result: privacy and security risk, especially if production data is present.

### 7.3 Password reset references an undefined audit model

Severity: High

- `AuthController::resetPassword()` calls `AuditLog::create(...)`.
- The `use App\Models\AuditLog;` import is commented out and no `AuditLog` model was found in the repository.
- Result: password reset will likely fail at runtime when that code path is reached.

### 7.4 Booking notification flow likely mishandles device tokens

Severity: Medium

- Booking creation is a public route.
- `BookingController::store()` tries to read `auth()->user()->device_tokens`.
- On the public booking path, there may be no authenticated user.
- `device_tokens` are stored as JSON in the users table, but the controller treats the value like an iterable array without decoding it.
- Result: notification delivery may fail or behave unpredictably on booking creation.

### 7.5 Darshan timing schema/controller mismatch risk

Severity: Medium

- The original migration creates `time`.
- A later migration renames it to `start_time` and adds `end_time`.
- Controller/model logic expects `start_time`, `end_time`, `title`, and `type`, which aligns only after the later migration is applied successfully.
- The down migration is empty, so rollback safety is weak.
- Result: environment drift or partial migrations can break darshan timing behavior.

### 7.6 Package description type mismatch

Severity: Medium

- The `packages.description` column is `text`.
- Controller validation treats `description` as a nullable string.
- The `Package` model casts `description` as `array`.
- Result: retrieved package data may be cast unexpectedly and is not aligned with the write path.

### 7.7 Inconsistent validation and error response style

Severity: Medium

- Some endpoints use manual `Validator` flows with `{data, message, code}` envelopes.
- Others use `$request->validate(...)`, which can throw standard Laravel validation exceptions.
- Some update methods do not early-return after validation failure blocks.
- Result: API consumers may receive inconsistent response formats and edge-case behavior.

### 7.8 Role propagation is not consistently applied

Severity: Medium

- The helper `assingPermission()` exists to copy role permissions to user permissions.
- Calls to that helper are commented out in user creation/update flows.
- Result: the effective user permission set can drift from the assigned role unless permissions are managed manually.

### 7.9 Firebase integration dependency visibility

Severity: Low to Medium

- Firebase service code depends on `Kreait\Firebase\Factory`.
- That package is not declared in `composer.json`.
- Result: the app may rely on an untracked dependency or incomplete setup instructions.

### 7.10 Documentation and test coverage are minimal

Severity: Medium

- The README is still the default Laravel README.
- Test files are example placeholders rather than feature coverage for the actual domain flows.
- Result: onboarding and change safety are weak.

## 8. Recommendations

### 8.1 Critical fixes

- Protect internal read endpoints that currently expose users and permission mappings publicly.
- Implement and centralize permission enforcement for privileged actions.
- Fix `resetPassword()` by either adding a real audit log implementation or removing the dead reference.
- Correct booking notification handling for unauthenticated booking creation and JSON device token decoding.

### 8.2 Maintainability fixes

- Standardize response envelopes and validation behavior across all controllers.
- Align `Package` model casting with the actual schema and request validation.
- Review role-to-user permission synchronization and decide whether user permissions are overrides or denormalized copies.
- Clean up placeholder or legacy controller code in the web layer.
- Add missing rollback logic to migrations where feasible.

### 8.3 Documentation and testing priorities

- Replace the default README with project-specific setup and architecture notes.
- Add feature tests for auth, booking creation, role/permission assignment, and protected route access.
- Add documentation for required environment variables, Firebase setup, Passport setup, and any expected seed data.

## 9. Operational Notes

- The project currently mixes public booking flows with admin-style management APIs.
- The RBAC structure is present, but the effective security boundary is mostly authentication, not authorization.
- Any production deployment should review route exposure before launch.

## 10. Review Basis

This review was based on the repository’s current manifests, routes, controllers, models, helpers, migrations, and service wiring. It intentionally distinguishes implemented behavior from intended behavior.
