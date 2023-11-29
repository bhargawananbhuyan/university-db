@extends('layouts.base')

@section('title', 'Manage Instructors - Program Coordinator Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-8">
        <h1 class="text-xl font-bold">Manage Instructors</h1>

        @if (count($instructors) > 0)
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
                    @foreach ($instructors as $instructor)
                        <tr>
                            <td>{{ $instructor->name }}</td>
                            <td>{{ $instructor->email }}</td>
                            <td>{{ $instructor->contact ?? 'NA' }}</td>
                            <td>
                                <a href="{{ route('program_coordinator.instructor_details', ['id' => $instructor->id]) }}"
                                    class="underline text-blue-500">
                                    View Courses
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No instructors available.</p>
        @endif
    </div>
@endsection
