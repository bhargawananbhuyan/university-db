@extends('layouts.base')

@section('title', 'Manage Instructors - Program Coordinator Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">{{ $instructor->name }}'s courses</h1>

        @if (count($courses) > 0)
            <table class="base-table text-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Details</th>
                        <th>Total Students</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->description ?? 'NA' }}</td>
                            <td>{{ count($course->students) }}</td>
                            <td>
                                <form
                                    action="{{ route('program_coordinator.remove_instructor_course', ['course_id' => $course->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" value="Remove" class="bg-red-500 text-white font-medium p-2 rounded">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No courses added.</p>
        @endif

        <h2 class="text-lg font-semibold">Add a course</h2>
        <form action="{{ route('program_coordinator.add_instructor_course', ['id' => $instructor->id]) }}" method="post"
            class="base-form">
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
