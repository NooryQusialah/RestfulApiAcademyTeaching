<?php

namespace App\Http\Controllers\ApiController;

use App\Exceptions\Handler;
use App\Exceptions\NotFoundException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollmentRequest;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\StudentResource;
use App\Services\StudentService;
use App\Services\UserCredentialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    protected $studentService;

    protected $userCredentialService;

    public function __construct(StudentService $studentService, UserCredentialService $userCredentialService)
    {
        $this->studentService = $studentService;
        $this->userCredentialService = $userCredentialService;
    }

    /**
     * Display a listing of all students.
     */
    public function index()
    {
        try {
            $students = $this->studentService->getAllStudents();

            return ResponseHelper::success(StudentResource::collection($students));
        } catch (\Exception $e) {
            Log::error('Error fetching students: '.$e->getMessage());

            return Handler::handle($e);
        }
    }

    /**
     * Display the specified student by ID.
     */
    public function show($id)
    {
        try {

            $student = $this->studentService->getStudentById($id);

            if (! $student) {
                throw new NotFoundException('Student not found.');
            }

            return ResponseHelper::success(new StudentResource($student));
        } catch (\Exception $e) {

            Log::error('Error fetching student: '.$e->getMessage());

            return Handler::handle($e);
        }
    }

    /**
     * Store a newly created student and user.
     */
    public function store(StudentRequest $studentRequest, UserRegisterRequest $userRequest)
    {
        try {
            $student = DB::transaction(function () use ($studentRequest, $userRequest) {
                // Step 1: Create user
                $user = $this->userCredentialService->register($userRequest->validated());

                // Step 2: Prepare and create student
                $studentData = array_merge($studentRequest->validated(), ['user_id' => $user->id]);
                $student = $this->studentService->createStudent($studentData);

                return $student;
                // return $student; // transaction returns this value if successful

            });

            return ResponseHelper::success(new StudentResource($student), 'Student created successfully.');

        } catch (\Exception $e) {
            Log::error('Error creating student: '.$e->getMessage());

            return Handler::handle($e);
        }
    }

    /**
     * Update the specified student and user.
     */
    public function update(StudentRequest $studentRequest, UserRegisterRequest $userRequest, $id)
    {
        try {

            $userRequestData = $userRequest->validated();
            $user = $this->userCredentialService->updateUser($userRequestData, $id);
            $student = $this->studentService->updateStudent($id, $studentRequest->validated());

            return ResponseHelper::success(new StudentResource($student), 'Student updated successfully.');

        } catch (\Exception $e) {
            Log::error('Error updating student: '.$e->getMessage());

            return Handler::handle($e);
        }
    }

    /**
     * Remove the specified student.
     */
    public function destroy($id)
    {
        try {
            $this->studentService->deleteStudent($id);

            return ResponseHelper::success(null, 'Student deleted successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function assignCourse(Request $request, EnrollmentRequest $enrollmentRequest)
    {
        try {

            return DB::transaction(function () use ($request, $enrollmentRequest) {

                $courseId = $request->input('course_id');
                $studentId = Auth::user()->student->id;

                // return  response()->json(['data'=> $enrollmentRequest->validated() ]);
                $enrollmentData = array_merge($enrollmentRequest->validated(), ['student_id' => $studentId, 'course_id' => $courseId]);
                $response = $this->studentService->assignCourseToStudent($studentId, $courseId);

                // If already enrolled, return error immediately
                if (isset($response) && $response instanceof \Illuminate\Http\JsonResponse) {
                    return $response;
                }

                $this->studentService->enrollmentInCourse($enrollmentData);

                return ResponseHelper::success(null, 'Course assigned to student successfully.');
            });
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function unassignCourse($courseId)
    {
        try {
            $studentId = Auth::user()->student->id;

            // Call the service method
            $response = $this->studentService->removeCourseFromStudent($studentId, $courseId);
            if (isset($response) && $response instanceof \Illuminate\Http\JsonResponse) {
                return $response;
            }

            $this->studentService->removeEnrollmentFromStudent($studentId, $courseId);

            return ResponseHelper::success(null, 'Course assigned to student successfully.');

        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    /**
     * Get all courses assigned to a student.
     */
    public function courses()
    {
        try {
            $id = Auth::user()->student->id;
            $courses = $this->studentService->getStudentCourses($id);

            return ResponseHelper::success($courses);
        } catch (\Exception $e) {
            return Handler::handle($e);
        }

    }

    public function studentCourse($courseId)
    {
        try {

            $course = $this->studentService->getStudentCourse($courseId);

            return ResponseHelper::success($course);
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    /**
     * Get all enrollments of a student.
     */
    public function enrollments($id)
    {
        try {
            $enrollments = $this->studentService->getStudentEnrollments($id);

            return ResponseHelper::success($enrollments);
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    /**
     * Get all payments of a student.
     */
    public function payments($id)
    {
        try {
            $payments = $this->studentService->getStudentPayments($id);

            return ResponseHelper::success($payments);
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    /**
     * Get all quiz attempts of a student.
     */
    public function quizAttempts($id)
    {
        try {
            $attempts = $this->studentService->getStudentQuizAttempts($id);

            return ResponseHelper::success($attempts);
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }
}
