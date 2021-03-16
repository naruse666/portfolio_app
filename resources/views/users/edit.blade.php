@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('css/background.css') }}">
@endpush
@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2 bg-white rounded p-md-4 p-2">
    <h4 class="text-center">{{ $user->name }} ユーザ編集ページ</h4>
    {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'post']) !!}
      <div class="form-group">
        {!! Form::label('name', '名前:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('description', '自己紹介:') !!}
        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3']) !!}
      </div>
      {!! Form::submit('更新', ['class' => 'btn btn-primary btn-block']) !!}
    {!! Form::close() !!}
    @if (session('s3url'))
      <h1>いまアップロードしたファイル</h1>
      <img src="{{ session('s3url') }}">
    @endif
  </div>
</div>
@endsection