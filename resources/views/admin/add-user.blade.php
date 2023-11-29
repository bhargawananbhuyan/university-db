@extends('layouts.base')

@section('title', 'Add User - Admin Dashboard')

@section('main')
    <div>
        <h1>Add a user</h1>

        <form action="{{ route('administrator.add_user') }}" method="post">
            @csrf
            <div>
                <label for="name">Full name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}">
                @error('email')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <div>
                <label for="role">Register as</label>
                <select name="role" id="role">
                    <option value="---">---</option>
                    <option value="student">Student</option>
                    <option value="instructor">Instructor</option>
                    <option value="program_coordinator">Program Coordinator</option>
                    <option value="quality_assurance_officer">Quality Assurance Officer</option>
                </select>
                @error('role')
                    <small>{{ $message }}</small>
                @enderror
            </div>

            <input type="submit" value="Add">
        </form>

        <p>
            Default password is <strong>12345678</strong>
        </p>
    </div>
@endsection
