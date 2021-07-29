@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="p-3 mt-2 mb-1 border-bottom">
                    {{ $profileUser->name }}
                    <small class="text-muted">
                        Since {{ $profileUser->created_at->diffForHumans() }}
                    </small>
                </h1>

                @foreach ($threads as $thread)
                    <div class="card mt-4">
                        <div class="card-header">
                            <div class="level">
                        <span>
                            <a href="#">{{  $thread->creator->name  }}</a> posted:
                            {{ $thread->title }}
                        </span>
                                <span>
                            {{ $thread->created_at->diffForHumans() }}
                        </span>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>
                @endforeach

                <div class="mt-4">
                    {{ $threads->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
