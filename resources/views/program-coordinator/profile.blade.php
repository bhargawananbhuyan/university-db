@extends('layouts.base')

@section('title', 'Profile - Program Coordinator Dashboard')

@section('main')
    <div class="px-8 py-12">
        <h1 class="text-xl font-bold">Profile</h1>

        <form action="{{ route('user-profile-information.update') }}" method="post" class="base-form">
            @csrf
            @method('put')
            <div>
                <label for="name">Full name</label>
                <input type="text" name="name" id="name" value="{{ old('name') ?? Auth::user()->name }}">
                @error('name')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') ?? Auth::user()->email }}">
                @error('email')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <div>
                <label for="contact">Contact</label>
                <input type="tel" name="contact" id="contact" value="{{ old('contact') ?? Auth::user()->contact }}">
                @error('contact')
                    <small>{{ $message }}</small>
                @enderror
            </div>

            <button type="submit">Update</button>
        </form>
    </div>
@endsection
