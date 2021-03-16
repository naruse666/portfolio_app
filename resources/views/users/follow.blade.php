@if(Auth::id() != $user->id)
<div class="mt-md-3 mt-1">

  @if(Auth::user()->following($user->id))
  {{-- アンフォローボタン --}}
  {!! Form::open(['route' => ['unfollow', $user->id], 'method' => 'delete']) !!}
  {!! Form::submit('フォローをやめる', ['class' => "btn btn-danger btn-block"]) !!}
  {!! Form::close() !!}
  @else
  {{-- フォローボタン --}}
  {!! Form::open(['route' => ['follow', $user->id]]) !!}
  {!! Form::submit('フォロー', ['class' => "btn btn-primary btn-block"]) !!}
  {!! Form::close() !!}
  @endif
</div>
@endif