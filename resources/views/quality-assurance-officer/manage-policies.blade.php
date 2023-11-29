@extends('layouts.base')

@section('title', 'Manage Policies - QA Officer Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Manage Policies</h1>


        <h2 class="text-lg font-semibold">Policies</h2>
        @if (count($policies) > 0)
            <table class="base-table text-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>For</th>
                        <th>Content</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($policies as $policy)
                        <tr>
                            <td>{{ $policy->id }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $policy->for_role)) }}</td>
                            <td>{{ $policy->content }}</td>
                            <td>
                                <form action="{{ route('quality_assurance_officer.remove_policy', ['id' => $policy->id]) }}"
                                    method="post">
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
            <p>No policies have been added.</p>
        @endif

        <h2 class="text-lg font-semibold">Add policy</h2>
        <form action="{{ route('quality_assurance_officer.add_policy') }}" method="post" class="base-form">
            @csrf
            <div>
                <label for="for_role">For</label>
                <select name="for_role" id="for_role">
                    <option value="">---</option>
                    <option value="student">Student</option>
                    <option value="instructor">Instructor</option>
                </select>
                @error('for_role')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <div>
                <label for="content">Content</label>
                <textarea name="content" id="content" rows="5"></textarea>
                @error('content')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            <button type="submit">Add</button>
        </form>
    </div>
@endsection
