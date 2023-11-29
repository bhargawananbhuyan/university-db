<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProgramCoordinatorController;
use App\Http\Controllers\PublicAccessController;
use App\Http\Controllers\QualityAssuranceOfficerController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::controller(PublicAccessController::class)->group(function () {
    Route::get("/", 'home')->name('home');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contact_query')->name('contact_query');
});

Route::controller(StudentController::class)
    ->middleware(['auth', 'role:student'])
    ->prefix('student')
    ->group(function () {
        Route::get('/profile', 'profile')->name('student.profile');
        Route::get('/courses', 'courses')->name('student.courses');
        Route::post('/courses/{id}', 'enroll_to_course')->name('student.enroll_to_course');
        Route::delete('/courses/{id}', 'unenroll_course')->name('student.unenroll_course');
        Route::get('/exams', 'exams')->name('student.exams');
        Route::get('/grievances', 'grievances')->name('student.grievances');
        Route::post('/grievances', 'add_grievance')->name('student.add_grievance');
        Route::get('/feedback', 'feedback')->name('student.feedback');
        Route::get('/policies', 'policies')->name('student.policies');
        Route::get('/chat', 'chat')->name('student.chat');
    });

Route::controller(InstructorController::class)
    ->middleware(['auth', 'role:instructor'])
    ->prefix('instructor')
    ->group(function () {
        Route::get('/profile', 'profile')->name('instructor.profile');
        Route::get('/courses', 'courses')->name('instructor.courses');
        Route::post('/courses', 'add_course')->name('instructor.add_course');
        Route::delete('/courses/{id}', 'remove_course')->name('instructor.remove_course');
        Route::get('/exams', 'exams')->name('instructor.exams');
        Route::post('/exams', 'add_exam')->name('instructor.add_exam');
        Route::delete('/exams/{id}', 'remove_exam')->name('instructor.remove_exam');
        Route::get('/students', 'students')->name('instructor.students');
        Route::get('/students/{course_id}/{student_id}', 'student_details')->name('instructor.student_details');
        Route::put('/students/{id}', 'update_student_exam')->name('instructor.update_student_exam');
        Route::get('/feedback', 'feedback')->name('instructor.feedback');
        Route::put('/feedback/{id}', 'reply_to_feedback')->name('instructor.reply_to_feedback');
        Route::get('/policies', 'policies')->name('instructor.policies');
        Route::get('/chat', 'chat')->name('instructor.chat');
    });

Route::controller(ProgramCoordinatorController::class)
    ->middleware(['auth', 'role:program_coordinator'])
    ->prefix('program-coordinator')
    ->group(function () {
        Route::get('/profile', 'profile')->name('program_coordinator.profile');
        Route::get('/instructors', 'instructors')->name('program_coordinator.instructors');
        Route::get('/instructors/{id}', 'instructor_details')->name('program_coordinator.instructor_details');
        Route::post('/instructors/{id}', 'add_instructor_course')->name('program_coordinator.add_instructor_course');
        Route::delete('/instructors/{course_id}', 'remove_instructor_course')->name('program_coordinator.remove_instructor_course');
        Route::get('/feedback', 'feedback')->name('program_coordinator.feedback');
        Route::put('/feedback/{id}', 'reply_to_feedback')->name('program_coordinator.reply_to_feedback');
        Route::get('/students', 'students')->name('program_coordinator.students');
        Route::get('/students/{course_id}/{student_id}', 'student_details')->name('program_coordinator.student_details');
        Route::get('/chat', 'chat')->name('program_coordinator.chat');
    });

Route::controller(QualityAssuranceOfficerController::class)
    ->middleware(['auth', 'role:quality_assurance_officer'])
    ->prefix('quality-assurance-officer')
    ->group(function () {
        Route::get('/profile', 'profile')->name('quality_assurance_officer.profile');
        Route::get('/students', 'students')->name('quality_assurance_officer.students');
        Route::get('/students/{course_id}/{student_id}', 'student_details')->name('quality_assurance_officer.student_details');
        Route::post('/feedback', 'add_feedback')->name('quality_assurance_officer.add_feedback');
        Route::get('/policies', 'policies')->name('quality_assurance_officer.policies');
        Route::post('/policies', 'add_policy')->name('quality_assurance_officer.add_policy');
        Route::delete('/policies/{id}', 'remove_policy')->name('quality_assurance_officer.remove_policy');
        Route::get('/chat', 'chat')->name('quality_assurance_officer.chat');
    });

Route::controller(AdminController::class)
    ->middleware(['auth', 'role:administrator'])
    ->prefix('administrator')
    ->group(function () {
        Route::get('/profile', 'profile')->name('administrator.profile');
        Route::get('/feedback', 'feedback')->name('administrator.feedback');
        Route::put('/feedback/{id}', 'reply_to_feedback')->name('administrator.reply_to_feedback');
        Route::get('/manage-users', 'manage_users')->name('administrator.manage_users');
        Route::delete('/manage-users/{id}', 'remove_user')->name('administrator.remove_user');
        Route::get('/add-user', 'add_user_form')->name('administrator.add_user_form');
        Route::post('/add-user', 'add_user')->name('administrator.add_user');
        Route::get('/user-permissions', 'user_permissions')->name('administrator.user_permissions');
        Route::put('/user-permissions/{id}', 'update_user')->name('administrator.update_user');
        Route::get('/students', 'students')->name('administrator.students');
        Route::get('/students/{course_id}/{student_id}', 'student_details')->name('administrator.student_details');
        Route::get('/chat', 'chat')->name('administrator.chat');
        Route::get('/queries', 'queries')->name('administrator.queries');
    });