@extends('layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('css/background.css') }}">
  <style>
    .drop-after-none::after{
    display: none;
  }
  </style>
@endpush
@section('content')
<div class="container bg-white p-md-4 p-3">
  <div class="row mb-md-4 mb-3">
    {{-- グループ作成ボタン --}}
    <div class="col-12">
      <h1>
        {!! link_to_route('groups.create', 'グループを作成', [], ['class' => 'btn btn-block btn-primary py-md-4 py-3']) !!}
      </h1>
    </div>
  </div>
  {{-- グループ一覧 --}}
  @foreach($groups as $group)
    <div class="row rounded border shadow p-md-3 p-2 mx-md-2 my-md-4 my-3">
      <div class="col-md-2 col-3">
        {{ link_to_route('groups.show', $group->name, ['id' => $group->id]) }}
      </div>
      <div class="col-md-3 col-4">
        <span class="badge badge-secondary">説明</span>
        {!! nl2br(e($group->description)) !!}
      </div>
      <div class="col-md-2 col-3">
        <span class="badge badge-secondary">作成者</span>
        {{ link_to_route('users.show', App\User::findOrFail($group->created_by)->name, ['id' => App\User::findOrFail($group->created_by)->id]) }}
      </div>
      <div class="col-md-1 col-2">
        <span class="badge badge-secondary">人数</span>
        {{ count($group->number_of_people()) }}
      </div>
      <div class="col-md-2 col-5">
        @if($group->joining(Auth::id(), $group->id) == true)
          {{ link_to_route('groups.talk', 'トーク', ['id' => $group->id], ['class' => 'btn btn-block btn-info']) }}
        @else 
          {!! Form::open(['route' => ['groups.join', [Auth::id(), $group->id]]]) !!}
            {!! Form::submit('参加', ['class' => 'btn btn-block btn-primary']) !!}
          {!! Form::close() !!}
        @endif
      </div>
      <div class="col-md-2 col-5">
        @if($group->created_by == Auth::id())
          <div class="dropdown">
            <button class="btn dropdown-toggle drop-after-none border text-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              ・・・
            </button>
            <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton">
            {{ link_to_route('groups.edit', '編集', ['id' => $group->id], ['class' => 'btn btn-block btn-success']) }}
            {!! Form::open(['route' => ['groups.delete', $group->id], 'method' => 'delete']) !!}
              {!! Form::submit('削除', ['class' => 'btn btn-block btn-danger']) !!}
            {!! Form::close() !!}
            </div>
          </div>
        @elseif($group->created_by != Auth::id() && $group->joining(Auth::id(), $group->id))
          {!! Form::open(['route' => ['groups.exit', [Auth::id(), $group->id]], 'method' => 'delete']) !!}
            {!! Form::submit('退会', ['class' => 'btn btn-block btn-danger']) !!}
          {!! Form::close() !!}
        @endif
      </div>
    </div>
  @endforeach
</div>
@endsection