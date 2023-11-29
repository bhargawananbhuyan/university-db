@extends('layouts.base')

@section('title', 'Feedback - Admin Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Feedback</h1>

        @if (count($tickets) > 0)
            <table class="base-table text-sm">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Details</th>
                        <th>From</th>
                        <th>Reply</th>
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
                            <td>
                                @isset($ticket->reply)
                                    {{ $ticket->reply }}
                                @else
                                    <form action="{{ route('administrator.reply_to_feedback', ['id' => $ticket->id]) }}"
                                        method="post" class="flex gap-x-1.5">
                                        @csrf
                                        @method('put')
                                        <input name="reply" id="reply" value="{{ old('reply') }}"
                                            class="border p-2 rounded w-full @error('reply') ring-2 ring-red-300 ring-offset-2 @enderror">
                                        <input type="submit" value="Reply"
                                            class="bg-gray-950 text-white font-medium p-2 rounded">
                                    </form>
                                @endisset
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No feedbacks have been posted yet.</p>
        @endif
    </div>
@endsection
