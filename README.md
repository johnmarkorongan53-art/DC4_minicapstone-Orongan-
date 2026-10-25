# Athlete Training Routine Scheduling and Monitoring System

**Student:** [Your Name Here]  
**Client:** School Sports Office / Local Athletic Club  
**Demo video:** [Add link]

Stride gives coaches and athletes one place to plan routines, record session effort, and review training progress. It replaces scattered notebook and chat records with a shared schedule and athlete-owned performance logs.

## Features

- Sanctum token login and athlete registration with role-based access.
- Coach dashboard, athlete roster management, search and filters.
- Athlete and coach session scheduling with overlap protection and a status workflow.
- Athlete performance logs, coach feedback, progress totals, and upcoming sessions.
- Responsive React interface for desktop and mobile.

## Stack

Laravel 12, PHP 8.2+, Sanctum, MySQL/MariaDB, React 18, Vite, React Router, Axios, and plain CSS.

## Setup

Requirements: PHP 8.2+ with PDO MySQL, Composer, Node.js 20+, npm, and MySQL/MariaDB.

1. Create a database named `athlete_training_db` using utf8mb4/InnoDB.
2. In `backend`, run `composer install`, copy `.env.example` to `.env`, set database credentials, then run `php artisan key:generate`.
3. Still in `backend`, run `php artisan migrate --seed` and `php artisan serve`.
4. In another terminal, go to `frontend`, run `npm install`, copy `.env.example` to `.env`, and run `npm run dev`.
5. Open the Vite URL (normally `http://localhost:5173`). The Laravel API runs at `http://localhost:8000/api`.

On this prepared workspace, start the API with `powershell -ExecutionPolicy Bypass -File .\backend\dev.ps1`. It uses the workspace-local PHP runtime when present. The local `.env` uses SQLite because no MySQL server is installed in this environment; fresh installations should use the MySQL settings from `.env.example`.

The configured database has the four requested domain tables. Sanctum also needs its `personal_access_tokens` infrastructure table to persist API tokens.

## Demo accounts

| Role | Email | Password |
|---|---|---|
| Coach / admin | `admin@example.com` | `password` |
| Athlete | `athlete@example.com` | `password` |

Change these credentials before using a deployed instance.

## API overview

All endpoints return JSON. Protected endpoints require `Authorization: Bearer <token>`.

| Method | Endpoint | Access | Purpose |
|---|---|---|---|
| POST | `/api/register`, `/api/login` | Public | Register athlete / sign in |
| POST, GET | `/api/logout`, `/api/user` | Authenticated | Sign out / current user |
| GET | `/api/training-types`, `/api/session-statuses` | Authenticated | Lookups |
| GET, PUT | `/api/my-profile` | Athlete | Read / update own profile |
| GET | `/api/my-progress` | Athlete | Own totals and history |
| GET, POST | `/api/my-sessions` | Athlete | List / schedule own sessions |
| GET, PUT, PATCH | `/api/my-sessions/{id}` | Athlete | View / edit / start / complete / cancel |
| GET | `/api/admin/dashboard` | Admin | Program summary |
| GET, POST | `/api/admin/athletes` | Admin | Search / create athletes |
| GET, PUT, DELETE | `/api/admin/athletes/{id}` | Admin | Manage athlete records |
| GET, POST | `/api/admin/training-sessions` | Admin | Search / schedule sessions |
| GET, PUT, DELETE | `/api/admin/training-sessions/{id}` | Admin | View / edit / delete sessions |
| PATCH | `/api/admin/training-sessions/{id}/status` | Admin | Transition a session |
| PATCH | `/api/admin/training-sessions/{id}/review` | Admin | Add coach feedback |
| POST, PUT, DELETE | `/api/admin/training-types[/{id}]` | Admin | Manage training categories |

Searchable list routes support pagination (`per_page`, maximum 100); session lists accept status, date, type, athlete, and keyword filters.

## Project documents

- [ER diagram](docs/ERD.md)
- [Postman collection](docs/postman_collection.json)
- [Slides placeholder](docs/slides/README.md)

## References

AI assistants (Codex/Claude) were used to help generate and review code. The project requirements and workflow were based on the student's mini-capstone proposal and assignment instructions.
