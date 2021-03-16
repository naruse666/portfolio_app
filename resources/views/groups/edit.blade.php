@extends('layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('css/background.css') }}">
@endpush
@section('content')
  <div class="container bg-white rounded p-md-4 p-3">
    <div class="row">
      <div class="col-12">
        <h1 class="text-center">グループ編集</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        {{ Form::model($group, ['route' => ['groups.update', $group->id], 'method' => 'post']) }}
        <div class="form-group">
          {{ Form::label('name', '名前:') }}
          {{ Form::text('name', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
          {{ Form::label('description', '説明:') }}
          {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'グループのコンセプトや目的などを書こう！', 'rows' => '4', ]) }}
        </div>
        {{ Form::submit('更新', ['class' => 'btn btn-block btn-primary py-md-4 py-3']) }}
        {{ Form::close() }}
      </div>
    </div>
  </div>
@endsection