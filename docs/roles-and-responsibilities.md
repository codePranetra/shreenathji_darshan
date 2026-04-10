# Roles And Responsibilities

See also: [project-technical-review.md](./project-technical-review.md) for the system architecture, API map, and detailed review findings that inform these role definitions.

## 1. How To Read This Document

This document has two separate meanings of "role":

- Application roles: user access roles inside the product
- Project roles: people responsible for building, operating, and supporting the product

Important constraint:

- The repository confirms the RBAC framework and data model.
- The repository does **not** confirm a canonical seeded list of business roles such as "Admin", "Staff", or "Viewer".
- Any named business-role examples below are proposed defaults or inferred examples, not confirmed production data.

## 2. Application Roles

### 2.1 Confirmed role framework

The codebase confirms the following RBAC structure:

- A user belongs to one role through `users.role_id`
- Roles are stored in `roles`
- Permissions are stored in `permissions`
- Role-to-permission mappings are stored in `role_permissions`
- User-specific permission assignments are stored in `user_has_permissions`
- Protected API access is enforced by authentication
- Fine-grained permission enforcement is not consistently active in controllers

This means the current application supports a role framework, not a fixed hardcoded role catalog.

### 2.2 Source of truth for app-role behavior

Use these sources as the authority:

- `roles`
- `permissions`
- `role_permissions`
- `user_has_permissions`
- `routes/api.php`
- Controller logic for actual enforcement behavior

### 2.3 Application role template

Use the template below whenever documenting or creating a real business role for this system:

- Role name
- Purpose
- Related endpoints
- Expected permissions
- Affected entities
- Operational limits
- Whether permissions come from role mapping, user override, or both

### 2.4 Role matrix template

The matrix below is intentionally capability-based so it matches the current system without inventing hardcoded production roles.

| Capability | Backing route/table | Public now | Should usually require auth | Should usually require permission |
| --- | --- | --- | --- | --- |
| View roles | `GET /role`, `GET /role/{id}` | Yes | Usually yes in admin contexts | Often yes |
| Create/update/delete roles | `/role` write routes | No | Yes | Yes |
| View users | `GET /user`, `GET /user/{id}` | Yes | Yes | Yes |
| Create/update/delete users | `/user` write routes | No | Yes | Yes |
| View permission catalog | `/permissions` routes | Yes | Usually yes | Often yes |
| Assign role permissions | `POST /role-has-permissions` | No | Yes | Yes |
| Assign user permissions | `POST /user-has-permissions` | No | Yes | Yes |
| View features | `/features` read routes | Yes | Optional | Optional |
| Manage features | `/features` write routes | No | Yes | Yes |
| View packages | `/package` read routes | Yes | Optional | Optional |
| Manage packages | `/package` write routes | No | Yes | Yes |
| View darshan timings | `/darshantiming` read routes | Yes | Optional | Optional |
| Manage darshan timings | `/darshantiming` write routes | No | Yes | Yes |
| Create booking | `POST /booking` | Yes | No | No |
| View one booking | `GET /booking/{id}` | Yes | Usually contextual | Usually no for public self-service |
| List/update/delete bookings | protected booking routes | No | Yes | Yes |

### 2.5 Inferred example application roles

These are examples to help stakeholders structure real role data. They are not confirmed seeded roles from the repository.

#### Example: Admin (inferred/proposed)

- Purpose: full operational control over users, roles, permissions, bookings, packages, features, and darshan timings
- Related endpoints: all protected management endpoints
- Expected permissions: create, update, delete, and view across all managed entities
- Affected entities: users, roles, permissions, packages, features, darshan timings, bookings
- Operational limits: should be tightly restricted because current code exposes many powerful actions once authenticated

#### Example: Content Or Operations Staff (inferred/proposed)

- Purpose: manage darshan timings, packages, features, and possibly booking verification
- Related endpoints: features, package, darshantiming, selected booking routes
- Expected permissions: view/create/update relevant content entities; limited booking actions
- Affected entities: packages, features, darshan timings, bookings
- Operational limits: should not manage users, roles, or permission mappings

#### Example: Viewer Or Support Role (inferred/proposed)

- Purpose: read-only visibility into operational data
- Related endpoints: selected read routes for bookings, packages, timings, and features
- Expected permissions: list/view only
- Affected entities: primarily bookings and display entities
- Operational limits: no write access, no security administration

### 2.6 App-role implementation notes

- If the team wants named roles, they should be created and documented as data, not assumed from code comments.
- If user-specific permissions are meant as overrides, that policy should be documented explicitly.
- If user-specific permissions are meant as denormalized copies of role permissions, synchronization rules must be enforced in code.

## 3. Project / Team Responsibilities

### 3.1 Product Owner

- Responsibilities: define business rules, approve role definitions, prioritize fixes, and decide what should be public vs admin-only
- Key touchpoints: booking flow, package offerings, darshan timing behavior, user-role policy
- Required access: documentation, staging review access, issue tracking, decision authority on requirements
- Routine tasks: confirm workflows, review release scope, approve role matrix and permission expectations
- Handoff dependencies: works with backend for API rules, frontend for user journeys, QA for acceptance criteria

### 3.2 Backend Developer

- Responsibilities: maintain Laravel routes, controllers, models, migrations, auth, RBAC, notification integration, and API consistency
- Key touchpoints: `routes/api.php`, controllers under `app/Http/Controllers/API`, models, helpers, migrations, service providers
- Required access: repo write access, database access in dev/staging, env setup for Passport/Firebase/mail
- Routine tasks: implement features, fix validation/security issues, align schema and model behavior, add tests
- Handoff dependencies: receives requirements from product owner; coordinates with QA on test scenarios; supports DevOps on runtime setup

### 3.3 Frontend Developer

- Responsibilities: maintain Blade views, assets, Vite integration, and any frontend consumption of the API
- Key touchpoints: `resources/views`, `resources/js`, `resources/css`, public assets, API contract expectations
- Required access: repo write access and environment access for frontend build validation
- Routine tasks: update landing pages, booking UI, admin-facing forms if added, align UI with API responses
- Handoff dependencies: depends on backend API behavior and product requirements; works with QA on user flows

### 3.4 QA Engineer

- Responsibilities: verify route behavior, access control, validation, booking flows, and regression coverage
- Key touchpoints: API route map, acceptance criteria, bug reproduction steps, test environments
- Required access: staging environment, test credentials, seeded data, API collection
- Routine tasks: run smoke tests, verify auth boundaries, validate booking math, confirm role restrictions, document regressions
- Handoff dependencies: depends on backend/frontend changes; reports issues back with reproducible cases

### 3.5 Deployment / DevOps

- Responsibilities: environment provisioning, secret management, deployment automation, storage permissions, mail/Firebase/Passport setup
- Key touchpoints: `.env`, queue/session/cache setup, storage paths, Firebase service account, OAuth keys
- Required access: infrastructure credentials, deployment pipeline access, secret stores, server logs
- Routine tasks: provision environments, manage keys, monitor runtime errors, verify file/storage permissions, maintain release process
- Handoff dependencies: depends on backend for setup requirements and product owner for environment policy

### 3.6 Content / Admin Operator

- Responsibilities: maintain operational business data inside the app after deployment
- Key touchpoints: packages, features, darshan timings, bookings, and potentially user records depending on granted permissions
- Required access: authenticated app access with a scoped operational role
- Routine tasks: update package prices/details, manage feature icons/titles, maintain darshan schedule, review bookings
- Handoff dependencies: depends on product owner for policy and backend team for correct permission boundaries

## 4. Recommended Ownership Boundaries

- Product owner should own final approval for which endpoints are public and which roles exist in production.
- Backend should own RBAC enforcement and API correctness.
- Frontend should own user-facing clarity and API integration on the web side.
- QA should own release confidence, especially around auth and booking behavior.
- DevOps should own secrets, deployability, and runtime configuration.
- Content/admin operators should own day-to-day business data, not platform-level security settings.

## 5. Immediate Role-Documentation Gaps To Close

- Define and seed the real business roles expected in production.
- Decide whether user permissions are overrides or synchronized copies.
- Document which read endpoints are intentionally public.
- Align runtime authorization with the intended role matrix.

## 6. Working Default

Until canonical roles are seeded and enforced, treat the current application as:

- authentication-aware
- role-structured
- permission-modeled
- not yet fully authorization-enforced

That distinction is critical for both engineering and operations planning.
