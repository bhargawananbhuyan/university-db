@extends('layouts.base')

@section('title', 'Exams - Student Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Exams</h1>

        <div class="flex items-center gap-x-2 [&>select]:border-b [&>select]:py-1.5 focus:[&>select]:ring-0">
            <label for="course_id">Select course</label>
            <select name="course_id" id="course_id">
                <option value="">---</option>
                @foreach ($student_courses as $student_course)
                    <option value="{{ $student_course->course->id }}" @selected(Request::get('course'))>
                        {{ $student_course->course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        @isset($student_exams)
            @if (count($student_exams) > 0)
                <table class="base-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Exam Title</th>
                            <th>Total Marks</th>
                            <th>Marks Secured</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student_exams as $student_exam)
                            <tr>
                                <td>{{ $student_exam->exam->id }}</td>
                                <td>{{ $student_exam->exam->title }}</td>
                                <td>{{ $student_exam->exam->total_marks }}</td>
                                <td>{{ $student_exam->marks_secured ?? 'NA' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No exams listed.</p>
            @endif
        @endisset
    </div>

    @push('body_scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const selectCourse = document.querySelector('#course_id')
                selectCourse.addEventListener('change', (e) => {
                    window.location.href = `{{ Request::url() }}?course=${e.target.value}`
                })
            })
        </script>
    @endpush
@endsection
