# Life-Line

Life-Line is a RESTful API built with **Laravel 11** for managing **projects, meetings, tasks, and task steps** with role-based authentication and a clean service-layer architecture.  
This project demonstrates a scalable backend structure suitable for real-world applications and portfolio presentation.

---

## Tech Stack

-   PHP 8.2
-   Laravel 11
-   MySQL
-   JWT Authentication
-   RESTful API
-   Service Layer Architecture
-   Form Request Validation
-   API Resources
-   Middleware for role-based authorization

---

## Architecture

The project follows a clean and scalable architecture:

-   **Controllers**: Handle HTTP requests and responses.
-   **Services**: Contain business logic (Service Layer pattern).
-   **Requests**: Handle validation for create/update actions.
-   **Resources**: Transform models to JSON responses.
-   **Middleware**: Handle authentication and role-based authorization.

### Example:

# 1 - **GetByIdProject**

### GET :  http://127.0.0.1:8000/api/GetByIdProject/1

**Response**

```json
{
    "message": "Project retrieved successfully",
    "project": {
        "id": 1,
        "project_no": "20",
        "project_name": "Charlie Schoen",
        "start_date": "2000-07-18",
        "end_date": "1996-02-10",
        "real_start_date": "2009-04-30",
        "real_end_date": "1979-10-01",
        "created_at": "2025-12-15T18:09:42.000000Z",
        "board_dee": {
            "id": 4,
            "board_no": 40
        }
    }
}
```

# 2 - **Create Task**

### POST : http://127.0.0.1:8000/api/AddTask/?task_name=task 1&project_id=11

**Response**

```json
{
    "task": {
        "id": 23,
        "task_name": "task 1",
        "duration": null,
        "responsible": null,
        "description": null,
        "start_date": null,
        "end_date": null,
        "real_start_date": null,
        "real_end_date": null
    },
    "message": "task created successfully"
}
```

---
##  Authentication & Authorization

- JWT-based authentication
- Role-based authorization (Admin / User)
- Protected routes using middleware

### Authorization: Bearer {token}

## Features

-   User registration, login, logout
-   Role-based access control (admin/user)
-   Project management (CRUD)
-   Meeting management (CRUD)
-   Assign users to meetings
-   Task management per project
-   Task steps management per task
-   Validation using Form Requests
-   Clean API responses with Resource classes

---

## API Endpoints

### Auth

-   `POST /api/register` – Register a new user
-   `POST /api/login` – Login user
-   `POST /api/logout` – Logout user

### Projects

-   `GET /api/projects` – List all projects
-   `POST /api/projects` – Create a project
-   `PUT /api/projects/{id}` – Update a project
-   `DELETE /api/projects/{id}` – Delete a project

### Meetings

-   `GET /api/meetings` – List all meetings
-   `POST /api/meetings` – Create a meeting
-   `PUT /api/meetings/{id}` – Update a meeting
-   `DELETE /api/meetings/{id}` – Delete a meeting
-   `POST /api/meetings/{id}/users` – Assign users to meeting
-   `DELETE /api/meetings/{id}/users` – Remove users from meeting

### Tasks

-   `GET /api/projects/{id}/tasks` – List tasks by project
-   `POST /api/tasks` – Create a task
-   `PUT /api/tasks/{id}` – Update a task
-   `DELETE /api/tasks/{id}` – Delete a task

### Task Steps

-   `GET /api/tasks/{id}/steps` – List task steps by task
-   `POST /api/task-steps` – Create a task step
-   `PUT /api/task-steps/{id}` – Update a task step
-   `DELETE /api/task-steps/{id}` – Delete a task step

---

## Installation

Clone the repository and set up locally:

```bash
git clone https://github.com/ZiadSalameh/Life-Line.git
cd Life-Line
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=WrokProject
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=your_jwt_secret_here
```