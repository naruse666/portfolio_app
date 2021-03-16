@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/background.css') }}">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Sawarabi+Mincho&display=swap" rel="stylesheet">
<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
<style>
  .drop-after-none::after{
    display: none;
  }
  .text-transparent{
    color: transparent;
  }
  .pink{
  color: #FF0230;
  }
  .gray{
    color: gray;
  }
</style>
@endpush
@section('content')
<div class="container">
  <div class="row bg-white rounded border shadow p-md-3 p-2 mb-md-3 mb-2">
    <div class="col-12 text-center">
      <h1 class="text-center" style="font-family: 'Sawarabi Mincho', sans-serif;">
        つぶやき一覧
      </h1>
      <span>(フォロー中ユーザのみいいね可能)</span>
    </div>
  </div>
@if($count > 0)
  @foreach($mutters as $mutter)
    <div class="row shadow p-md-3 p-2 rounded border mb-md-4 mb-2 {{ $mutter->user_id == $user->id ? 'bg-info text-white' : 'bg-white' }}">
      <div class="col-3">
        @if($mutter->user_id == $user->id)
          {{ App\User::find($mutter->user_id)->name }}
        @else
          {!! link_to_route('users.show', App\User::find($mutter->user_id)->name, ['id' => $mutter->user_id], ['class' => 'mr-md-2 mr-1']) !!}
          {{-- 相互フォローバッジ --}}
          @include('users.both_follow_button')
        @endif
      </div>
      <div class="col-md-4 col-5">
        {!! nl2br(e($mutter->mutter)) !!}
      </div>
      <div class="col-md-1 col-3">
        {{-- いいねボタン --}}
        @if(!Auth::user()->following($mutter->user_id) && $mutter->user_id != Auth::id())
          フォローしていません。
        @elseif($mutter->user_id != Auth::id())
          @include('mutters.like_button')
        @else 
          <h1><i class="fas fa-heart pink">{{ count($mutter->like_from_user()->get()) }}</i></h1>
        @endif
      </div>
      <div class="col-md-2">
        投稿日：
        {{ $mutter->created_at }}
      </div>
      <div class="col-md-2">
        @if(Auth::id() == $mutter->user_id)
          <div class="dropdown">
            <button class="btn dropdown-toggle drop-after-none border text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              ・・・
            </button>
            <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton">
             {{ link_to_route('mutters.edit', '編集', ['id' => $mutter->id], ['class' => 'btn btn-block btn-success']) }}
             {!! Form::open(['route' => ['mutters.delete', $mutter->id], 'method' => 'delete']) !!}
              {!! Form::submit('削除', ['class' => 'btn btn-block btn-danger']) !!}
             {!! Form::close() !!}
            </div>
          </div>
        @endif
      </div>
    </div>
  @endforeach
  @else 
  <div class="row bg-white rounded border shadow p-md-3 p-2">
    <div class="col-12 text-center">
      つぶやきがありません。
    </div>
  </div>
  @endif
</div>
<div class="p-5 text-transparent">fixed</div>
{!! Form::open(['route' => ['mutters.store', Auth::id()]]) !!}
  <div class="row fixed-bottom">
    <div class="col-10 bg-transparent p-md-4 p-3 rounded border">
      {!! Form::textarea('mutter', null, ['rows' => '2', 'cols' => '400', 'class' => 'form-control', 'placeholder' => '自分の意見を呟こう!']) !!}
    </div>
      {!! Form::submit('送信', ['class' => 'btn btn-block btn-primary col-2']) !!}
  </div>
{!! Form::close() !!}
@endsection