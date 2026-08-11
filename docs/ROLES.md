# Roles & Permissions

The API uses role-based access control with four access levels:

* **Guest** — unauthenticated user
* **User** — authenticated user with limited access
* **Manager** — authenticated user who can manage events and participants
* **Admin** — authenticated user with full administrative access

## Permissions

| Action                                 | Guest | User | Manager | Admin |
| -------------------------------------- | :---: | :--: | :-----: | :---: |
| View list of events                    |   ✅   |   ✅  |    ✅    |   ✅   |
| View a single event                    |   ✅   |   ✅  |    ✅    |   ✅   |
| View participants assigned to an event |   ❌   |   ✅  |    ✅    |   ✅   |
| View all participants                  |   ❌   |   ❌  |    ✅    |   ✅   |
| Create participants                    |   ❌   |   ❌  |    ✅    |   ✅   |
| Edit participants                      |   ❌   |   ❌  |    ✅    |   ✅   |
| Delete participants                    |   ❌   |   ❌  |    ✅    |   ✅   |
| Create events                          |   ❌   |   ❌  |    ✅    |   ✅   |
| Edit events                            |   ❌   |   ❌  |    ✅    |   ✅   |
| Delete events                          |   ❌   |   ❌  |    ✅    |   ✅   |
| Assign participants to events          |   ❌   |   ❌  |    ✅    |   ✅   |
| Remove participants from events        |   ❌   |   ❌  |    ✅    |   ✅   |
| View users                             |   ❌   |   ❌  |    ❌    |   ✅   |
| Change user roles                      |   ❌   |   ❌  |    ❌    |   ✅*  |
| Delete users                           |   ❌   |   ❌  |    ❌    |   ✅** |

### Admin restrictions

An admin cannot:

* change their own role;
** delete their own account.

These restrictions prevent an administrator from accidentally removing their own administrative access.

## Authentication

### Guest

Guests do not need authentication to:

* view the list of events;
* view a single event.

All other API operations require authentication.

### User

Users must authenticate with a Laravel Sanctum Bearer token.

A regular user can:

* view events;
* view participants assigned to an event.

A user cannot create, edit, or delete events or participants.

### Manager

Managers must authenticate with a Laravel Sanctum Bearer token.

A manager can manage:

* events;
* participants;
* event participant assignments.

A manager cannot manage users or change user roles.

### Admin

Administrators must authenticate with a Laravel Sanctum Bearer token.

An admin can perform all available management operations, including:

* managing events;
* managing participants;
* managing event participant assignments;
* viewing users;
* changing user roles;
* deleting users.

The admin restrictions described above also apply.

## Role Assignment

New users registered through the public registration endpoint receive the `user` role by default.

Administrative roles are assigned by an authorized administrator.