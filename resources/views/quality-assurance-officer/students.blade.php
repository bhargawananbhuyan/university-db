@extends('layouts.base')

@section('title', 'Student Reports - QA Officer Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Student Reports</h1>

        <div class="flex items-center gap-x-2 [&>select]:border-b [&>select]:py-1.5 focus:[&>select]:ring-0">
            <label for="course_id">Select a course</label>
            <select name="course_id" id="course_id">
                <option value="">---</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" @selected(Request::get('course'))>{{ $course->name }}</option>
                @endforeach
            </select>
        </div>

        @isset($student_courses)
            @if (count($student_courses) > 0)
                <table class="base-table text-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student_courses as $student_course)
                            <tr>
                                <td>{{ $student_course->student->name }}</td>
                                <td>{{ $student_course->student->email }}</td>
                                <td>{{ $student_course->student->contact ?? 'NA' }}</td>
                                <td>
                                    <a href="{{ route('quality_assurance_officer.student_details', [
                                        'course_id' => $student_course->course_id,
                                        'student_id' => $student_course->student_id,
                                    ]) }}"
                                        class="underline text-blue-500">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No students enrolled in this course.</p>
            @endif
        @endisset
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectCourse = document.querySelector('#course_id')
            selectCourse.addEventListener('change', (e) => {
                window.location.href = `{{ Request::url() }}?course=${e.target.value}`
            })
        })
    </script>
@endsection
