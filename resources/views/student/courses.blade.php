@extends('layouts.base')

@section('title', 'Manage Courses - Student Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Courses</h1>

        <h2 class="text-lg font-semibold">Courses you're enrolled in</h2>
        @if (count($student_courses) > 0)
            <div class="grid grid-cols-4">
                @foreach ($student_courses as $student_course)
                    <section class="border grid p-2.5 rounded-lg [&>img]:rounded space-y-2">
                        <img src="/course.png" alt="">
                        <small>Course ID: {{ $student_course->course->id }}</small>
                        <strong>{{ $student_course->course->name }}</strong>
                        @isset($student_course->course->description)
                            <p>{{ $student_course->course->description }}</p>
                        @endisset
                        <form action="{{ route('student.unenroll_course', ['id' => $student_course->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Unenroll"
                                class="bg-red-500 text-white text-sm font-medium rounded p-2">
                        </form>
                    </section>
                @endforeach
            </div>
        @else
            <p>
                <em>You're not enrolled to any courses.</em>
            </p>
        @endif


        <h2 class="text-lg font-semibold">Courses available</h2>
        @if (count($courses) > 0)
            <div class="grid grid-cols-4">
                @foreach ($courses as $course)
                    <section class="border grid p-2.5 rounded-lg [&>img]:rounded space-y-2">
                        <img src="/course.png" alt="">
                        <small>Course ID: {{ $course->id }}</small>
                        <strong>{{ $course->name }}</strong>
                        @isset($course->description)
                            <p>{{ $course->description }}</p>
                        @endisset
                        <form action="{{ route('student.enroll_to_course', ['id' => $course->id]) }}" method="post">
                            @csrf
                            <input type="submit" value="Enroll"
                                class="bg-green-500 text-white text-sm font-medium rounded p-2">
                        </form>
                    </section>
                @endforeach
            </div>
        @else
            <p>
                <em>No courses available at the moment. Check this space later on.</em>
            </p>
        @endif
    </div>
@endsection
