@extends('layouts.base')

@section('title', 'Policies - Student Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Policies</h1>

        @if (count($policies) > 0)
            <ul>
                @foreach ($policies as $policy)
                    <li><strong>[Policy {{ $policy->id }}]</strong> {{ $policy->content }}</li>
                @endforeach
            </ul>
        @else
            <p>No policies have been added.</p>
        @endif
    </div>
@endsection
