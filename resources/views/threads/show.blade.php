@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row justify-content-start">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                <div>
                                    <a href="/profiles/{{ $thread->creator->name }}">{{  $thread->creator->name  }}</a> posted:
                                    {{ $thread->title }}
                                </div>
                                @can('delete', $thread)
                                    <form action="{{ $thread->path() }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" type="submit">
                                            Delete Thread
                                        </button>
                                    </form>
                                @endcan
                            </div>

                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies :data="{{ $thread->replies }}"
                             @removed="repliesCount--"
                             @added="repliesCount++"
                    ></replies>

                    <div class="mt-4">
                        {{ $replies->links() }}
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-break">
                                This thread was published {{ $thread->created_at->diffForHumans() }} by <a
                                    href="/profiles/{{ $thread->creator->name }}">{{ $thread->creator->name }}</a>, and currently
                                has <span v-text="repliesCount"></span> comments.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </thread-view>
@endsection
