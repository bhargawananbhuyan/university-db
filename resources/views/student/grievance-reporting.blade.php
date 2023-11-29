@extends('layouts.base')

@section('title', 'Grievance Reporting - Student Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Grievance Reporting</h1>

        <div class="flex items-center gap-x-2 [&>select]:border-b [&>select]:py-1.5 focus:[&>select]:ring-0">
            <label for="user_id">Select a user</label>
            <select name="user_id" id="user_id">
                <option value="">---</option>
                @foreach ($other_users as $user)
                    <option value="{{ $user->id }}" @selected(Request::get('to'))>{{ $user->name }}
                        ({{ ucwords(str_replace('_', ' ', $user->role)) }})
                    </option>
                @endforeach
            </select>
        </div>

        @if (Request::has('to'))
            <form action="{{ route('student.add_grievance', ['to' => Request::get('to')]) }}" method="post"
                class="base-form">
                @csrf
                <div>
                    <label for="subject">Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}">
                    @error('subject')
                        <small>{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label for="details">Details</label>
                    <textarea name="details" id="details" rows="5"></textarea>
                    @error('details')
                        <small>{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit">Submit</button>
            </form>
        @endif

        @isset($tickets)
            <h2 class="text-lg font-semibold">Your tickets</h2>
            <table class="base-table">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Details</th>
                        <th>Correspondent</th>
                        <th>Reply</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->subject }}</td>
                            <td>{{ $ticket->details }}</td>
                            <td>
                                {{ $ticket->to_user->name }}
                                ({{ ucwords(str_replace('_', ' ', $ticket->to_user->role)) }})
                            </td>
                            <td>{{ $ticket->reply ?? 'NA' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endisset
    </div>

    @push('body_scripts')
        <script>
            document.addEventListener('DOMContentLoaded', (e) => {
                const selectUser = document.querySelector('#user_id')
                selectUser.addEventListener('change', (e) => {
                    const selectValue = e.target.value
                    if (selectValue)
                        window.location.href = `{{ Request::url() }}?to=${selectValue}`
                })
            })
        </script>
    @endpush
@endsection
