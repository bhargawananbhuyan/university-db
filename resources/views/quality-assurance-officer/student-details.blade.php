@extends('layouts.base')

@section('title', 'Student Details - Program Coordinator Dashboard')

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
                            <td>{{ $student_exam->marks_secured ?? 'NA' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No exams listed yet.</p>
        @endif

        <h2 class="text-lg font-semibold">Post a feedback</h2>
        <form action="{{ route('quality_assurance_officer.add_feedback', ['to' => $student_course->student->id]) }}"
            method="post" class="base-form">
            @csrf
            <div>
                <label for="subject">Subject</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}">
                @error('subject')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <div>
                <label for="details">Details</label>
                <textarea name="details" id="details" rows="5"></textarea>
                @error('details')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
@endsection
