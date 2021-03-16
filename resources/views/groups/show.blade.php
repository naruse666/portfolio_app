@extends('layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('css/background.css') }}">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
@endpush
@section('content')
<div class="container bg-white border p-md-4 p-3 mb-md-5 mb-3">
  <h1 class="text-center">
    {{ $group->name }}
  </h1>
  <div class="text-center">
    作成者: {{ link_to_route('users.show', App\User::findOrFail($group->created_by)->name, ['id' => App\User::findOrFail($group->created_by)->id]) }}
  </div>
</div>
{{-- 参加・退出・編集ボタン --}}
<div class="container">
  <div class="row">
    <div class="col-5">
      @if($group->joining(Auth::id(), $group->id))
        @if($group->created_by == Auth::id())
          {{ link_to_route('groups.edit', '編集', ['id' => $group->id], ['class' => 'btn btn-block btn-success border']) }}
        @else 
          {{ link_to_route('groups.talk', 'トーク', ['id' => $group->id], ['class' => 'btn btn-block btn-info border']) }}
        @endif
      @else
        {!! Form::open(['route' => ['groups.join', [Auth::id(), $group->id]]]) !!}
          {!! Form::submit('参加', ['class' => 'btn btn-block btn-primary border']) !!}
        {!! Form::close() !!}
      @endif
    </div>
    <div class="col-5 offset-2">
      @if($group->joining(Auth::id(), $group->id))
        @if($group->created_by == Auth::id())
          {!! Form::open(['route' => ['groups.delete', $group->id], 'method' => 'delete']) !!}
            {!! Form::submit('削除', ['class' => 'btn btn-block btn-danger border']) !!}
          {!! Form::close() !!}
        @else 
          {!! Form::open(['route' => ['groups.exit', [Auth::id(), $group->id]], 'method' => 'delete']) !!}
            {!! Form::submit('退会', ['class' => 'btn btn-block btn-danger border']) !!}
          {!! Form::close() !!}
        @endif
      @endif
    </div>
  </div>
</div>
{{-- コンテンツ --}}
<div class="container mt-md-4 mt-3">
  <div class="row">
    <div class="col-5 p-md-4 p-3 bg-white border rounded">
      <div class="border-bottom pb-1">
        説明(目的・方針)
        <i class="fas fa-info-circle"></i>
      </div>
      <br>
        {!! nl2br(e($group->description)) !!}
    </div>
    <div class="col-5 offset-2 bg-white border rounded">
      {{-- グループ人数 --}}
      <div class="border-bottom p-1">
        <h5 class="text-center">
          人数
          <i class="fas fa-users"></i>
        </h5>
      </div>
      <div class="mt-md-3 mt-2">
        <h2 class="text-center text-info">
          {{ count($group->number_of_people()) }}
        </h2>
      </div>
      {{-- コメント数 --}}
      <div class="border-bottom p-1 mt-md-4 mt-3">
        <h5 class="text-center">
          コメント総数
          <i class="fas fa-comments"></i>
        </h5>
      </div>
      <div class="mt-md-3 mt-2">
        <h2 class="text-center text-info">
          {{ count($group->get_chats($group->id)->get()) }}
        </h2>
      </div>
    </div>
  </div>
</div>
@endsection