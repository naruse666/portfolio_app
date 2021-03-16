@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Mincho&display=swap" rel="stylesheet">
@endpush
@section('content')
<div class="row rounded">
  <div class="col-md-8 offset-md-2">
    <div class="p-md-3 p-1 bg-white rounded">
      <div class="text-center">
        <div class="row">
          <div class="col-lg-3 offset-lg-4">
            <h1 style="font-family: 'Sawarabi Mincho', sans-serif;">ユーザ一覧</h1>
          </div>
          <div class="col-lg-5">
            @include('users.search-form')
          </div>
        </div>
        @include('users.search')
      </div>
      @foreach($users as $user)
        <div class="row shadow p-md-3 mx-md-2 my-md-4 my-3 border rounded bg-light align-items-baseline">
          <div class="col-lg-4 col-6">
            {{ link_to_route('users.show', $user->name , ['id' => $user->id], ['class' => 'font-weight-bold mr-md-2 mr-1']) }}
            @if(Auth::user()->both_following(Auth::id(), $user->id) == true && Auth::id() != $user->id)
            <span class="badge badge-secondary">
              相互フォロー
            </span>
            @endif
          </div>
          <div class="col-lg-3 col-6">
            @include('users.follow')
          </div>
          <div class="col-lg-4 offset-md-1">
            @if($user->description == null)
            自己紹介がありません。
            @else
              @if(strlen($user->description) <= 20)
                {{ $user->description }}
              @else
                {{ substr($user->description, 0, 20) }} ...
              @endif
            @endif
          </div>
        </div>
      @endforeach

      {{ $users->links() }}
    </div>
  </div>
</div>
@endsection