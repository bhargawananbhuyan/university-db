@extends('layouts.base')

@section('title', 'Contact - SchoolManagement')

@section('main')
    <div class="px-8 py-12">
        <h1 class="text-xl font-bold">Get in touch with us</h1>

        <form action="{{ route('contact_query') }}" method="post" class="base-form">
            @csrf
            <div>
                <label for="name">Name</label>
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
                <label for="query_content">Query</label>
                <textarea name="query_content" id="query_content" rows="5"></textarea>
                @error('query_content')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
@endsection
