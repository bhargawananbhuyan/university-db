@extends('layouts.base')

@section('title', 'Manage Courses - Instructor Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Manage courses</h1>

        <h2 class="text-lg font-semibold">My courses</h2>

        <div>
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
                            <form action="{{ route('instructor.remove_course', ['id' => $course->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <input type="submit" value="Remove"
                                    class="bg-red-500 text-white text-sm font-medium rounded p-2">
                            </form>
                        </section>
                    @endforeach
                </div>
            @else
                <p>No course added.</p>
            @endif
        </div>

        <h2 class="text-lg font-semibold">Add a course</h2>

        <form action="{{ route('instructor.add_course') }}" method="post" class="base-form">
            @csrf
            <div>
                <label for="name">Course name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <div>
                <label for="description">Course details</label>
                <textarea name="description" id="description" rows="5"></textarea>
            </div>
            <button type="submit">Add</button>
        </form>
    </div>
@endsection
