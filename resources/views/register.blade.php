@extends('layouts.base')

@section('title', 'Register - SchoolManagement')

@section('main')
    <div class="px-8 py-12">
        <h1 class="text-xl font-bold">Register</h1>

        <form action="{{ route('register') }}" method="post" class="base-form">
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
                    <option value="administrator">Administrator</option>
                </select>
                @error('role')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value="{{ old('password') }}">
                @error('password')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <div>
                <label for="password_confirmation">Confirm password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    value="{{ old('password_confirmation') }}">
                @error('password_confirmation')
                    <small>{{ $message }}</small>
                @enderror
            </div>

            <button type="submit">Register</button>
        </form>

        <p class="[&>a]:underline [&>a]:text-blue-500 mt-5">
            Already registered? <a href="{{ route('login') }}">Login</a>
        </p>
    </div>
@endsection
