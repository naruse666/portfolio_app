@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('css/background.css') }}">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Sawarabi+Mincho&display=swap" rel="stylesheet">
<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
<style>
  .pink{
  color: #FF0230;
  }
  .gray{
    color: gray;
  }
</style>
@endpush
@section('content')
<div class="container bg-white py-md-5 py-3 rounded">
  <div class="row">
    <div class="col-12 my-md-3">
      <h1 class="text-center" style="font-family: 'Sawarabi Mincho', sans-serif;">プロフィール</h1>
    </div>
  </div>
  <div class="row mt-md-4 mt-sm-3">
    <div class="col-lg-4">
      <div class="card" style="width: 18rem;">
        {{-- <img src="{{ $user->image }}" class="card-img-top" alt="{{ $user->image }}"> --}}
        <div class="card-body">
          <div class="border-bottom text-lg mb-md-2 mb-1">名前</div>
          <h5 class="card-title mb-md-4 text-center">
            {{ $user->name }}
            @if(Auth::id() == $user->id)
            {{ link_to_route('users.edit', '編集', ['id' => $user->id], ['class' => 'ml-md-3 ml-2 font-weight-light text-success']) }}
            @endif
          </h5>
          <div class="row">
            <div class="col-6 text-center">フォロー数<div>{{ count($user->followings()->get()) }}</div>
            </div>
            <div class="col-6 text-center">フォロワー数<div>{{ count($user->followers()->get()) }}</div></div>
          </div>
          {{-- フォローボタン --}}
          @include('users.follow')

          <p class="card-text mt-md-3">
            <div class="border-bottom text-lg mb-md-2 mb-1">
              自己紹介
              <i class="fas fa-pen"></i>
            </div>
            @if(isset($user->description))
              {!! nl2br(e($user->description)) !!} 
            @elseif($user->id == Auth::id()) 
              <p class="text-muted">「編集」から自己紹介をしよう!</p>
            @else
              <p class="text-muted">自己紹介はまだありません。</p>
            @endif
          </p>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <nav>
        <div class="nav nav-tabs flex-nowrap" id="nav-tab" role="tablist">
          {{-- フォロー中タブ --}}
          <a class="nav-item nav-link active px-md-4" id="nav-follow-tab" data-toggle="tab" href="#nav-follow" role="tab" aria-controls="nav-follow" aria-selected="true">
            フォロー中
            <span class="badge badge-secondary">{{ count($user->followings()->get()) }}</span>
          </a>
          {{-- フォロワータブ --}}
          <a class="nav-item nav-link px-md-4" id="nav-follower-tab" data-toggle="tab" href="#nav-follower" role="tab" aria-controls="nav-follower" aria-selected="false">フォロワー <span class="badge badge-secondary">{{ count($user->followers()->get()) }}</span></a>
          {{-- つぶやきタブ --}}
          <a class="nav-item nav-link px-md-4" id="nav-mutter-tab" data-toggle="tab" href="#nav-mutter" role="tab" aria-controls="nav-mutter" aria-selected="false">つぶやき
            <span class="badge badge-secondary">{{ count($user->mutters()->get()) }}</span>
          </a>
          {{-- いいねタブ --}}
          <a class="nav-item nav-link px-md-4" id="nav-like-tab" data-toggle="tab" href="#nav-like" role="tab" aria-controls="nav-like" aria-selected="false">いいね一覧
            <span class="badge badge-secondary">{{ count($user->like_to_mutter()->get()) }}</span>
          </a>
          {{-- グループタブ --}}
          <a class="nav-item nav-link px-md-4" id="nav-group-tab" data-toggle="tab" href="#nav-group" role="tab" aria-controls="nav-group" aria-selected="false">所属グループ <span class="badge badge-secondary">{{ count($user->users_group()->get()) }}</span></a>
        </div>
      </nav>
      {{-- フォロー中ユーザ表示 --}}
      <div class="tab-content border border-top-0 p-md-4 p-3" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-follow" role="tabpanel" aria-labelledby="nav-follow-tab">
          @foreach($followings as $following)
            <div class="row p-md-3 p-2  my-md-4 my-3 shadow-sm rounded border">
              <div class="col-4">
                {{ link_to_route('users.show', $following->name, ['id' => $following->id]) }}
              </div>
              <div class="col-4 offset-4">
                @if($following->description == null)
                  自己紹介がありません。
                @else
                    {!! nl2br(e($following->description)) !!}
                @endif
              </div>
            </div>
          @endforeach
        </div>
        {{-- フォロワー表示 --}}
        <div class="tab-pane fade" id="nav-follower" role="tabpanel" aria-labelledby="nav-follower-tab">
          @foreach($followers as $follower)
            <div class="row p-md-3 p-2  my-md-4 my-3 shadow-sm rounded border">
              <div class="col-4">
                {{ link_to_route('users.show', $follower->name, ['id' => $follower->id]) }}
              </div>
              <div class="col-4 offset-4">
                @if($follower->description == null)
                  自己紹介がありません。
                @else
                  {!! nl2br(e($follower->description)) !!}
                @endif
              </div>
            </div>
          @endforeach
        </div>
        {{-- つぶやき表示 --}}
        <div class="tab-pane fade" id="nav-mutter" role="tabpanel" aria-labelledby="nav-mutter-tab">
          @foreach($mutters as $mutter)
            <div class="row p-md-3 p-2  my-md-4 my-3 shadow-sm rounded border">
              <div class="col-4">
                {!! nl2br(e($mutter->mutter)) !!}
                <i class="fas fa-heart pink">{{ count(App\Mutter::findOrFail($mutter->id)->like_from_user()->get()) }}</i>
              </div>
              {{-- 削除ボタン追加 --}}
              <div class="col-4">
                投稿日：{{ $mutter->created_at }}
              </div>
              <div class="col-4">
                @if(Auth::id() == $user->id)
                  <div class="row">
                    <div class="col-md-6">
                      {{ link_to_route('mutters.edit', '編集', ['id' => $mutter->id], ['class' => 'btn btn-block btn-success']) }}
                    </div>
                    <div class="col-md-6">
                      {!! Form::open(['route' => ['mutters.delete', $mutter->id], 'method' => 'delete']) !!}
                        {!! Form::submit('削除', ['class' => 'btn btn-block btn-danger']) !!}
                      {!! Form::close() !!}
                    </div>
                  </div>
                @endif
              </div>
            </div>
          @endforeach
        </div>
        {{-- いいねしたつぶやき --}}
        <div class="tab-pane fade" id="nav-like" role="tabpanel" aria-labelledby="nav-like-tab">
          @foreach($likes_mutter as $like_mutter)
            <div class="row p-md-3 p-2  my-md-4 my-3 shadow-sm rounded border">
              <div class="col-3">
                {{ link_to_route('users.show', App\User::findOrFail(App\Mutter::findOrFail($like_mutter->id)->user_id)->name, ['id' => App\User::findOrFail(App\Mutter::findOrFail($like_mutter->id)->user_id)->id]) }}
              </div>
              <div class="col-4">
                {!! nl2br(e(App\Mutter::findOrFail($like_mutter->id)->mutter)) !!}
              </div>
              {{-- いいねボタン --}}
              <div class="col-md-4">
                @if(Auth::id() == App\Mutter::findOrFail($like_mutter->id)->user_id)
                 <span class="badge badge-secondary">It's me</span>
                @elseif(App\Mutter::findOrFail($like_mutter->id)->liked(Auth::id()))
                  {!! Form::open(['route' => ['mutters.unlike', App\Mutter::findOrFail($like_mutter->id)->id], 'method' => 'delete']) !!}
                    <button type="submit" class="border-0 bg-transparent btn-block">
                      <h1><i class="fas fa-heart pink">{{ count(App\Mutter::findOrFail($like_mutter->id)->like_from_user()->get()) }}</i></h1>
                    </button>
                  {!! Form::close() !!}
                @else 
                  {!! Form::open(['route' => ['mutters.like', App\Mutter::findOrFail($like_mutter->id)->id]]) !!}
                    <button type="submit" class="border-0 bg-transparent btn-block">
                      <h1><i class="fas fa-heart gray">{{ count(App\Mutter::findOrFail($like_mutter->id)->like_from_user()->get()) }}</i></h1>
                    </button>
                  {!! Form::close() !!}
                @endif
              </div>
            </div>
          @endforeach
        </div>
        {{-- グループ表示 --}}
        <div class="tab-pane fade" id="nav-group" role="tabpanel" aria-labelledby="nav-group-tab">
          @foreach($groups as $group)
            <div class="row p-md-3 p-2  my-md-4 my-3 shadow-sm rounded border">
              <div class="col-3">
                {{ link_to_route('groups.show', $group->name, ['id' => $group->id]) }}
              </div>
              <div class="col-5">
                {{ $group->description }}
              </div>
              <div class="col-3">
                作成者: {{ App\User::findOrFail(App\Group::findOrFail($group->id)->created_by)->id == Auth::id() ? App\User::findOrFail(App\Group::findOrFail($group->id)->created_by)->name
                 :  
                 link_to_route('users.show', App\User::findOrFail(App\Group::findOrFail($group->id)->created_by)->name, ['id' => App\User::findOrFail(App\Group::findOrFail($group->id)->created_by)->id])}}
                 @if(App\User::findOrFail(App\Group::findOrFail($group->id)->created_by)->id == Auth::id())
                 <span class="badge badge-secondary">It's me</span>
                 @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
