@php
    $role = Auth::user()->role;
@endphp

@if ($role === 'student')
    <a href="{{ route('student.courses') }}" @class(['text-yellow-500' => Route::is('student.courses')])>Manage Courses</a>
    <a href="{{ route('student.exams') }}" @class(['text-yellow-500' => Route::is('student.exams')])>Exams</a>
    <a href="{{ route('student.feedback') }}" @class(['text-yellow-500' => Route::is('student.feedback')])>Feedback</a>
    <a href="{{ route('student.grievances') }}" @class(['text-yellow-500' => Route::is('student.grievances')])>Grievance Reporting</a>
    <a href="{{ route('student.policies') }}" @class(['text-yellow-500' => Route::is('student.policies')])>Policies</a>
    <a href="{{ route('student.chat') }}" @class(['text-yellow-500' => Route::is('student.chat')])>Chat</a>
@endif

@if ($role === 'instructor')
    <a href="{{ route('instructor.courses') }}" @class(['text-yellow-500' => Route::is('instructor.courses')])>Manage Courses</a>
    <a href="{{ route('instructor.exams') }}" @class(['text-yellow-500' => Route::is('instructor.exams')])>Manage Exams</a>
    <a href="{{ route('instructor.students') }}" @class(['text-yellow-500' => Route::is('instructor.students')])>Manage Students</a>
    <a href="{{ route('instructor.feedback') }}" @class(['text-yellow-500' => Route::is('instructor.feedback')])>Feedback</a>
    <a href="{{ route('instructor.policies') }}" @class(['text-yellow-500' => Route::is('instructor.policies')])>Policies</a>
    <a href="{{ route('instructor.chat') }}" @class(['text-yellow-500' => Route::is('instructor.chat')])>Chat</a>
@endif

@if ($role === 'program_coordinator')
    <a href="{{ route('program_coordinator.students') }}" @class([
        'text-yellow-500' => Route::is('program_coordinator.students'),
    ])>Monitor Students</a>
    <a href="{{ route('program_coordinator.instructors') }}" @class([
        'text-yellow-500' => Route::is('program_coordinator.instructors'),
    ])>Manage Instructors</a>
    <a href="{{ route('program_coordinator.feedback') }}" @class([
        'text-yellow-500' => Route::is('program_coordinator.feedback'),
    ])>Grievance Redressal</a>
    <a href="{{ route('program_coordinator.chat') }}" @class(['text-yellow-500' => Route::is('program_coordinator.chat')])>Chat</a>
@endif

@if ($role === 'quality_assurance_officer')
    <a href="{{ route('quality_assurance_officer.students') }}" @class([
        'text-yellow-500' => Route::is('quality_assurance_officer.students'),
    ])>Student Reports</a>
    <a href="{{ route('quality_assurance_officer.policies') }}" @class([
        'text-yellow-500' => Route::is('quality_assurance_officer.policies'),
    ])>Manage Policies</a>
    <a href="{{ route('quality_assurance_officer.chat') }}" @class([
        'text-yellow-500' => Route::is('quality_assurance_officer.chat'),
    ])>Chat</a>
@endif

@if ($role === 'administrator')
    <a href="{{ route('administrator.manage_users') }}" @class(['text-yellow-500' => Route::is('administrator.manage_users')])>Manage Users</a>
    <a href="{{ route('administrator.user_permissions') }}" @class([
        'text-yellow-500' => Route::is('administrator.user_permissions'),
    ])>Manage User Permissions</a>
    <a href="{{ route('administrator.students') }}" @class(['text-yellow-500' => Route::is('administrator.students')])>Student Reports</a>
    <a href="{{ route('administrator.feedback') }}" @class(['text-yellow-500' => Route::is('administrator.feedback')])>User Feedback</a>
    <a href="{{ route('administrator.queries') }}" @class(['text-yellow-500' => Route::is('administrator.queries')])>Queries</a>
    <a href="{{ route('administrator.chat') }}" @class(['text-yellow-500' => Route::is('administrator.chat')])>Chat</a>
@endif
