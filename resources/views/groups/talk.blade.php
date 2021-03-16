@extends('layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('css/background.css') }}">
  <style>
    .text-transparent{
    color: transparent;
  }
  </style>
@endpush
@section('content')
  <div class="container bg-white border rounded p-md-4 p-3">
    <h3 class="text-center">
      グループ名:{{ link_to_route('groups.show', $group->name, ['id' => $group->id]) }}
      <div class="font-weight-light">新着順</div>
    </h3>
  </div>
  <div class="container p-md-4 p-3 mt-md-4 mt-3">
    @foreach($chats as $chat)
    {{-- 自分側のチャット --}}
      <div class="row mb-md-4 mb-3">
        @if($chat->user_id == Auth::id())
          <div class="col-6 offset-6 text-left text-white">
            <div class="row">
              <div class="col-10 bg-info p-md-4 p-3 rounded ">
                {!! nl2br(e($chat->content)) !!}
              </div>
              <div class="col-2 px-0">
                {!! Form::open(['route' => ['chat.delete', $chat->id], 'method' => 'delete']) !!}
                  {!! Form::submit('削除', ['class' => 'btn p-4 btn-danger']) !!}
                {!! Form::close() !!}
              </div>
            </div>
          </div>
        @else 
        {{-- 相手チャット --}}
        <div class="col-6 bg-white rounded text-right">
          <div class="row p-md-4 p-3 justify-content-start">
            <div class="col-3">
              ユーザー
              <br>
              @if($group->created_by == App\User::findOrFail($chat->user_id)->id)
              <span class="badge badge-secondary">管理者</span>
              @endif
              {{ link_to_route('users.show', App\User::findOrFail($chat->user_id)->name, ['id' => App\User::findOrFail($chat->user_id)->id]) }}
            </div>
            <div class="col-9">
                {!! nl2br(e($chat->content)) !!}
            </div>
          </div>
        </div>
        @endif
      </div>
    @endforeach
  </div>
  {{-- フォーム --}}
  <div class="p-5 text-transparent">fixed</div>
  {!! Form::open(['route' => ['chat.store', $group->id], 'method' => 'post']) !!}
  <div class="row fixed-bottom">
    <div class="col-10 p-md-4 p-3 rounded border">
      {!! Form::textarea('content', null, ['rows' => '2', 'cols' => '400', 'class' => 'form-control', 'placeholder' => 'メンバーと会話しよう！']) !!}
    </div>
      {!! Form::submit('送信', ['class' => 'btn btn-block btn-primary col-2']) !!}
  </div>
  {!! Form::close() !!}
@endsection

{{-- all:グループの詳細、root:編集削除を追加 --}}