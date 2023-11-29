@extends('layouts.base')

@section('title', 'Manage Users - Admin Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Manage Users</h1>

        <p><a href="{{ route('administrator.add_user') }}" class="text-blue-500 underline">Add a new user</a></p>

        @if (count($users) > 0)
            <table class="base-table text-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $user->role)) }}</td>
                            <td>
                                <form action="{{ route('administrator.remove_user', ['id' => $user->id]) }}" method="post">
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
            <p>No users available.</p>
        @endif
    </div>
@endsection
