@extends('layouts.base')

@section('title', 'Feedback - Student Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Feedback</h1>

        @if (count($tickets) > 0)
            <table class="base-table">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Details</th>
                        <th>Correspondent</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->subject }}</td>
                            <td>{{ $ticket->details }}</td>
                            <td>
                                {{ $ticket->from_user->name }}
                                ({{ ucwords(str_replace('_', ' ', $ticket->from_user->role)) }})
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No feedback posted.</p>
        @endif
    </div>
@endsection
