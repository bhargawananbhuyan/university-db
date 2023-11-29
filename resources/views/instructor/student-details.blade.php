@extends('layouts.base')

@section('title', 'Student Details - Instructor Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Student Details</h1>

        <section>
            <p>Name: {{ $student_course->student->name }}</p>
            <p>Email: <a href="mailto:{{ $student_course->student->email }}"
                    class="underline text-blue-500">{{ $student_course->student->email }}</a></p>
            <p>Contact: {{ $student_course->student->contact ?? 'NA' }}</p>
        </section>

        @if (count($student_exams) > 0)
            <table class="base-table text-sm">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Total Marks</th>
                        <th>Marks Secured</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student_exams as $student_exam)
                        <tr>
                            <td>{{ $student_exam->exam->title }}</td>
                            <td>{{ $student_exam->exam->total_marks }}</td>
                            <td>
                                @isset($student_exam->marks_secured)
                                    {{ $student_exam->marks_secured }}
                                @else
                                    <form action="{{ route('instructor.update_student_exam', ['id' => $student_exam->id]) }}"
                                        method="post" class="flex gap-x-1.5">
                                        @csrf
                                        @method('put')
                                        <input type="text" name="marks_secured" id="marks_secured"
                                            value="{{ old('marks_secured') }}"
                                            class="border p-2 rounded w-full @error('marks_secured') ring-2 ring-red-300 ring-offset-2 @enderror">
                                        <input type="submit" value="Submit"
                                            class="bg-gray-950 text-white font-medium p-2 rounded">
                                    </form>
                                @endisset
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No exams listed yet.</p>
        @endif
    </div>
@endsection
