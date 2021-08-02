<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div ref="reply-{{ $reply->id }}" class="card mt-4" >
        <div class="card-header">
           <div class="level">
               <div>
                   <a href="/profiles/{{ $reply->owner->name }}">{{ $reply->owner->name }}</a> said
                   {{ $reply->created_at->diffForHumans() }}:
               </div>

               @auth
                   <form method="post" action="/replies/{{ $reply->id }}/favorites">
                       @csrf
                       <button type="submit" class="btn btn-outline-secondary"
                               @if( $reply->isFavorited() )
                                   disabled
                               @endif
                       >
                           {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
                       </button>
                   </form>
               @endauth
           </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        @can('delete', $reply)
            <div class="card-footer d-flex">
                <button class="btn btn-sm btn-primary mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-sm btn-danger" @click="destroy">Delete</button>
            </div>
        @endcan
    </div>
</reply>
