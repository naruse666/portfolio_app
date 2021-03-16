@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('css/background.css') }}">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Sawarabi+Mincho&display=swap" rel="stylesheet">
@endpush
@section('content')
<div class="container bg-white p-md-4 p-3">
  <div class="col-12 text-center">
    <h1 style="font-family: 'Sawarabi Mincho', sans-serif;">グループ作成</h1>
  </div>
  <div class="row">
    <div class="col-12">
      {!! Form::open(['route' => 'groups.store', 'method' => 'post']) !!}
        <div class="form-group">
          {!! Form::label('name', 'グループ名:') !!}
          {!! Form::text('name', null, ['class' => 'form-control']) !!}
          @if($errors->has('name'))
            <span class="invalid-feedback d-block" role="alert">
              <strong>
                  {{ $errors->first('name') }}
              </strong>
            </span>
          @endif
        </div>
        <div class="form-group">
          {!! Form::label('description', '説明:') !!}
          {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'グループのコンセプトや目的などを書こう！', 'rows' => '4', ]) !!}
          @if($errors->has('description'))
            <span class="invalid-feedback d-block" role="alert">
              <strong>
                  {{ $errors->first('description') }}
              </strong>
            </span>
          @endif
        </div>
        {!! Form::submit('作成', ['class' => 'btn btn-block btn-primary py-md-4 py-3']) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection