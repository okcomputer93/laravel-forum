@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach ($threads as $thread)
                    <div class="card mt-4">
                        <div class="card-header">
                            <div class="level">
                                <h4>
                                    <a href="{{ $thread->path() }}">
                                        {{ $thread->title }}
                                    </a>
                                </h4>
                                <a href="{{ $thread->path() }}" class="font-weight-bold">
                                    {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="body">{{ $thread->body }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
