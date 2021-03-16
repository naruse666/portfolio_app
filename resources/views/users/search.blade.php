@if($search == true && $result == '' || $search == true && $len == 0)
<div class="row shadow p-md-3 mx-md-2 my-md-4 border rounded">
  <div class="col-12 text-center">
    {{ $result }} に関するユーザは存在しません。
  </div>
</div>
@elseif($search != false )
<div class="row shadow p-md-3 mx-md-2 my-md-4 border rounded">
  <div class="col-12 text-center">
    {{ $result }} に関する検索は{{ $len }}件ヒットしました。
  </div>
</div>
@endif