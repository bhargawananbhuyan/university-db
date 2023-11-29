@extends('layouts.base')

@section('title', 'Manage Exams - Instructor Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Manage Exams</h1>

        <h2 class="text-lg font-semibold">My exams</h2>
        @if (count($exams) > 0)
            <table class="base-table text-sm">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Course</th>
                        <th>Total Marks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exams as $exam)
                        <tr>
                            <td>{{ $exam->title }}</td>
                            <td>{{ $exam->course->name }}</td>
                            <td>{{ $exam->total_marks }}</td>
                            <td>
                                <form action="{{ route('instructor.remove_exam', ['id' => $exam->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" value="Remove" class="font-medium bg-red-500 text-white rounded p-2">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No exam added.</p>
        @endif

        <h2 class="text-lg font-semibold">Add an exam</h2>
        <form action="{{ route('instructor.add_exam') }}" method="post" class="base-form">
            @csrf
            <div>
                <label for="course_id">Select a course</label>
                <select name="course_id" id="course_id">
                    <option value="">---</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
                @error('course_id')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <div>
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}">
                @error('title')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <div>
                <label for="total_marks">Total marks</label>
                <input type="text" name="total_marks" id="total_marks" inputmode="numeric"
                    value="{{ old('total_marks') }}">
                @error('total_marks')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <button type="submit">Add</button>
        </form>
    </div>
@endsection
