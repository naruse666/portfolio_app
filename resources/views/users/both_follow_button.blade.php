@if(Auth::user()->both_following(Auth::id(), App\User::find($mutter->user_id)->id) == true )
  <span class="badge badge-secondary">
    相互フォロー
  </span>
@endif