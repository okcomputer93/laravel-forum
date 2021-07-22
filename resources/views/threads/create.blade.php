@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a New Thread</div>

                    <div class="card-body">
                        <form method="POST" action="/threads">
                            @csrf

                            <div class="form-group">
                                <label for="channel_id">Choose a Channel</label>
                                <select name="channel_id"
                                        id="channel_id"
                                        class="custom-select"
                                        required
                                >
                                    <option @if (! old('channel_id'))
                                                selected
                                            @endif
                                    >
                                        Select One...
                                    </option>

                                    @foreach($channels as $channel)

                                        <option value="{{ $channel->id }}"
                                                @if (old('channel_id') === strval($channel->id))
                                                    selected
                                                @endif
                                        >
                                            {{ ucwords($channel->name) }}
                                        </option>

                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input class="form-control"
                                       type="text"
                                       name="title"
                                       id="title"
                                       value="{{ old('title') }}"
                                       required
                                >
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea class="form-control"
                                          type="text"
                                          name="body"
                                          id="body"
                                          rows="8"
                                          required
                                >
                                    {{ old('body') }}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary"
                                        type="submit"
                                >
                                    Publish
                                </button>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
