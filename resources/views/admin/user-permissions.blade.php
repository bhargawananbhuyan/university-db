@extends('layouts.base')

@section('title', 'User Permissions - Admin Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">User Permissions</h1>

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
                                <form action="{{ route('administrator.update_user', ['id' => $user->id]) }}" method="post">
                                    @csrf
                                    @method('put')
                                    @if ($user->blocked)
                                        <input type="submit" value="Unblock"
                                            class="p-2 bg-green-500 text-white rounded font-medium">
                                    @else
                                        <input type="submit" value="Block"
                                            class="p-2 bg-red-500 text-white rounded font-medium">
                                    @endif
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
