@if($mutter->liked(Auth::id()))
  {!! Form::open(['route' => ['mutters.unlike', $mutter->id], 'method' => 'delete']) !!}
    <button type="submit" class="border-0 bg-transparent btn-block">
      <h1><i class="fas fa-heart pink">{{ count($mutter->like_from_user()->get()) }}</i></h1>
    </button>
  {!! Form::close() !!}
@else 
  {!! Form::open(['route' => ['mutters.like', $mutter->id]]) !!}
    <button type="submit" class="border-0 bg-transparent btn-block">
      <h1><i class="fas fa-heart gray">{{ count($mutter->like_from_user()->get()) }}</i></h1>
    </button>
  {!! Form::close() !!}
@endif