@extends('layouts.base')

@section('title', 'Queries - Admin Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Queries</h1>

        @if (count($queries) > 0)
            <table class="base-table text-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Query</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($queries as $query)
                        <tr>
                            <td>{{ $query->name }}</td>
                            <td>
                                <a href="mailto:{{ $query->email }}" class="underline text-blue-500">{{ $query->email }}</a>
                            </td>
                            <td>{{ $query->query }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No queries posted.</p>
        @endif
    </div>
@endsection
