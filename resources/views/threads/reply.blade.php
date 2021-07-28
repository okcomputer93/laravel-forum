<div class="card mt-4">
    <div class="card-header">
       <div class="level">
           <div>
               <a href="#">{{ $reply->owner->name }}</a> said
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
        {{ $reply->body }}
    </div>
</div>
