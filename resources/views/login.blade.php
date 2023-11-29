@extends('layouts.base')

@section('title', 'Login - SchoolManagement')

@section('main')
    <div class="px-8 py-12">
        <h1 class="text-xl font-bold">Login</h1>

        <form action="{{ route('login') }}" method="post" class="base-form">
            @csrf
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}">
                @error('email')
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

            <button type="submit">Login</button>
        </form>

        <p class="mt-5 [&>a]:text-blue-500 [&>a]:underline">
            Not yet registered? <a href="{{ route('register') }}">Create new account</a>
        </p>
    </div>
@endsection
