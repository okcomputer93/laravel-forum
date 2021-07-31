@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="p-3 mt-2 mb-1 border-bottom">
                    {{ $profileUser->name }}
                </h1>

                @foreach ($activities as $date => $activity)
                    <h3 class="mt-4 text-muted">{{ $date }}</h3>
                    @foreach ($activity as $record)
                        @if (view()->exists("profiles.activities.$record->type"))
                            @include("profiles.activities.$record->type", ['activity' => $record])
                        @endif
                    @endforeach
                @endforeach
            </div>

        </div>
    </div>
@endsection
