{!! Form::open(['route' => 'users.index']) !!}
<div class="form-group d-flex justify-content-center">
  {!! Form::text('search', null,  ['class' => 'form-controll', 'placeholder' => 'キーワードを入力']) !!}
  {!! Form::submit('検索', ['class' => 'btn btn-primary rounded-pill ml-1']) !!}
</div>
{!! Form::close() !!}