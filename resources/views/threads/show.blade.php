@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-start">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{  $thread->creator->name  }}</a> posted:
                        {{ $thread->title }}
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>

                @foreach ($replies as $reply)
                    @include ('threads.reply')
                @endforeach

                <div class="mt-4">
                    {{ $replies->links() }}
                </div>

                @auth
                    <form class="mt-4" method="POST" action="{{ $thread->path() . '/replies' }}">
                        @csrf
                        <div class="form-group">
                            <textarea placeholder="Have something to say?" name="body" id="body" rows="5"
                                      class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                @endauth

                @guest
                    <p class="text-center mt-4">Please <a href="{{ route('login') }}">sign in</a> to participate in this
                        discussion.</p>
                @endguest

            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p class="text-break">
                            This thread was published {{ $thread->created_at->diffForHumans() }} by <a
                                href="#">{{ $thread->creator->name }}</a>, and currently
                            has {{ $thread->replies_count  }} {{ Str::plural('comment', $thread->replies_count) }}.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
