@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('css/background.css') }}">
@endpush
@section('content')
<div class="container bg-white py-md-4 py-3 mb-md-5 mb-4">
  <div class="row">
    <div class="col-12">
      <h1 class="text-center">
        つぶやき編集
      </h1>
    </div>
  </div>
  <div class="row mt-md-5 mt-3">
    <div class="col-12">
      <h5 class="text-center">
        ユーザ:{{ App\User::findOrFail($mutter->user_id)->name }}
      </h5>
      <h5 class="text-center">
        投稿日:{{ $mutter->created_at }}
      </h5>
      {!! Form::model($mutter, ['route' => ['mutters.update', $mutter->id], 'method' => 'post']) !!}
      <div class="form-group">
        <h5 class="text-center">
          {!! Form::label('mutter', 'つぶやき内容:') !!}
        </h5>
        {!! Form::textarea('mutter', null, ['rows' => '2', 'cols' => '400', 'class' => 'form-control']) !!}
      </div>
        {!! Form::submit('更新', ['class' => 'btn btn-block btn-primary']) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection