# Husob Restful API Project

This repository contains the Husob learning platform RESTful API built with Laravel. The API provides endpoints for user authentication (Laravel Passport), course management, lessons, quizzes, questions, enrollments, comments, and role/permission administration (Spatie Permission).

This README documents how to get the project running, the database schema highlights, main models and relationships, and the most important API endpoints with request/response shapes and examples.

## Table of contents

- Project overview
- Requirements
- Installation
- Environment & configuration
- Database & migrations
- Main models and relationships
- Authentication & authorization
- API endpoints (selected)
- Running tests
- Contributing
- License

## Project overview

The API implements a learning platform backend. Key features:

- User registration, login, token refresh and logout (Laravel Passport)
- Role/permission management (Spatie Permission)
- CRUD for courses, lessons, quizzes, questions
- Student/teacher management and many-to-many assignments
- Commenting on lessons
- Quiz attempts and enrollments

The code follows a service -> repository pattern. Controllers call Services, Services call Repositories which interact with Eloquent models.

## Requirements

- PHP 8.x (project uses typed properties and modern features)
- Composer
- MySQL (or another supported database)
- Laravel compatible web server (valet, artisan serve, Apache, Nginx)
- Node.js + npm (for frontend assets if needed)

## Installation

1. Clone the repository

2. Install PHP dependencies

```powershell
composer install
```

3. Copy environment and generate app key

```powershell
cp .env.example .env; php artisan key:generate
```

4. Configure `.env` database credentials and Passport keys

- Set DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
- Provide Passport keys or generate them (see Environment & configuration)

5. Run migrations and seeders (if any)

```powershell
php artisan migrate
```

6. (Optional) Install frontend dependencies and build

```powershell
npm install; npm run build
```

## Environment & configuration

- Authentication uses Laravel Passport. Check `config/passport.php` and `.env` variables: `PASSPORT_PRIVATE_KEY` and `PASSPORT_PUBLIC_KEY`.
- Auth guard for API is configured to use Passport in `config/auth.php`.
- Role and permission data uses Spatie Permission package; migrations for permission tables are present.

## Database & migrations

The repository includes migrations for the main entities. Important migration files (timestamps vary):

- `create_students_table` - students table
- `create_teachers_table` - teachers table
- `create_courses_table` - courses table
- `create_lessons_table` - lessons table
- `create_enrollments_table` - enrollments table
- `create_quizzes_table` - quizzes table
- `create_questions_table` - questions table
- `create_quiz_attempts_table` - quiz attempts
- `create_comments_table` - comments table
- Passport and permission tables are included (oauth tables & permission tables)

Run `php artisan migrate` to create these tables.

## Main models and relationships

Below are the most important models and their primary attributes/relationships (from `app/Models`):

- User
  - fillable: name, email, password
  - relationships: hasMany(Lesson), hasOne(Student), belongsToMany(Role)

- Student
  - fillable: user_id, enrollment_number, level, major, date_of_birth
  - relationships: belongsTo(User), hasMany(Enrollment), belongsToMany(Course via student_course), hasMany(QuizAttempt)

- Teacher
  - fillable: user_id, expertise, qualification, experience_years, verified
  - relationships: belongsTo(User), belongsToMany(Course via teacher_course)

- Course
  - fillable: title, description, thumbnail, price, category, level, status
  - relationships: belongsToMany(Teacher), belongsToMany(Student), hasMany(Lesson), hasMany(Quiz), hasMany(Enrollment), hasMany(Payment)

- Lesson
  - fillable: title, content, video_url, duration, order, course_id
  - relationships: belongsTo(Course), hasMany(Comment)

- Quiz/Question/QuizAttempt
  - Quiz hasMany Question and hasMany QuizAttempt
  - Question belongsTo Quiz
  - QuizAttempt belongsTo Quiz and belongsTo Student

- Comment
  - fillable: user_id, lesson_id, content
  - relationships: belongsTo(User), belongsTo(Lesson)

## Authentication & Authorization

- Authentication: Laravel Passport. Tokens are created on register/login by `UserCredentialRepository` using `$user->createToken('authToken')->accessToken` and attached to responses.
- Authorization: Spatie Permission is used to manage roles and permissions; example middleware usage in routes (e.g., `role:student`, `role:teacher`, `role:admin`).

## API endpoints (selected)

Base URL: /api/v1

Authentication (UserCredentialController)

- POST /api/v1/register
  - Request: name, email, password, (role - optional)
  - Response (201): user object with `access_token`

- POST /api/v1/login
  - Request: email, password
  - Response (200): user object with `access_token`

- POST /api/v1/logout (auth required)
  - Revokes tokens for the authenticated user

- POST /api/v1/tokens/refresh (auth required)
  - Generates a new access token for the authenticated user

Comments (CommentController)

- GET /api/v1/lessons/{lessonId}/comments
  - Public: returns comments for a lesson

- POST /api/v1/lessons/{lessonId}/comments (auth required)
  - Request: content
  - Response (201): created comment

- GET /api/v1/lessons/{lessonId}/comments/{id}
  - Public: returns a single comment

- PUT /api/v1/lessons/{lessonId}/comments/{id} (auth required)
  - Request: content

- DELETE /api/v1/lessons/{lessonId}/comments/{id} (auth required)

Student routes (routes/student.php)

- Controller: `App\Http\Controllers\ApiController\StudentController`
- POST /api/student/ - create student (public route to register a student record)
- Authenticated student routes (middleware auth:api + role:student): index, show, update, destroy, enrollments, payments, quiz-attempts, courses list, assign/unassign course

Teacher routes (routes/teacher.php)

- Controller: `App\Http\Controllers\ApiController\TeacherController`
- POST /api/teacher/ - create teacher
- Authenticated teacher routes: index, show, update, destroy, teacher courses management, lessons, quizzes, questions CRUD under teacher scope

Admin routes (routes/admin.php)

- UserCredentialController endpoints mirrored for admin prefix
- RoleController and PermissionController provide endpoints for creating/managing roles and permissions. Routes support assigning/removing permissions to roles and assigning/removing roles to users.

Example request/response (login)

Request

```json
{
  "email": "admin@example.com",
  "password": "secret"
}
```

Response (200)

```json
{
  "user": {
    "user_id": 1,
    "full_name": "Admin User",
    "email_address": "admin@example.com",
    "registered_at": "2025-10-16 12:00:00",
    "last_updated_at": "2025-10-16 12:00:00",
    "access_token": "<passport-access-token>"
  }
}
```

## Validation rules (high level)

- User registration/update: `name` required, `email` required and unique, `password` required for create and optional for update (min 6)
- Course: title, description, thumbnail, price (numeric), category, level in [beginner, intermediate, advanced], status in [draft, published]
- Comment: content required (max 2000)

## Running tests

The project includes PHPUnit configuration. To run tests:

```powershell
php artisan test
```

or

```powershell
./vendor/bin/phpunit
```

Note: tests may require a testing database configured in `.env.testing`.

## Contributing

Contributions are welcome. Please open issues or pull requests and follow the repository coding style. Add tests when adding features.

## Next steps & optional improvements

- Add full OpenAPI/Swagger documentation (routes + schemas)
- Add example Postman collection or HTTPie/curl examples for each endpoint
- Add role-based example users seeders for easier local testing

## License

See repository LICENSE file (if present) or add a license.

---

If you'd like, I can:

- generate a Postman collection from the routes
- add OpenAPI/Swagger YAML
- create an example `.env.example` with recommended Passport environment variables

Tell me which next step you'd like.
