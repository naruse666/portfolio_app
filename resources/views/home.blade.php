@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Mincho&display=swap" rel="stylesheet">
@endpush
@section('content')
<div class="container my-5">
    <div class="row my-5 mx-3 justify-content-center bg-danger rounded shadow">
        <div class="col-md-8 rounded">
            <h1 class="text-center p-md-5 text-white">Nanndemoへようこそ!</h1>
        </div>
    </div>
    <div class="row my-5">
        <div class="col-8 offset-4 my-5">
            <div class="my-4 text-center bg-warning p-md-5 p-2 rounded">
                <h2 class="text-white" style="font-family: 'Sawarabi Mincho', sans-serif;">普段の不満を</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8 my-5">
            <div class="my-4 text-center bg-info p-md-5 p-2 rounded">
                <h2 class="text-white" style="font-family: 'Sawarabi Mincho', sans-serif;">自由にコメント</h2>
            </div>
        </div>
    </div>
    <div class="row my-5">
        <div class="col-8 offset-4 my-5">
            <div class="mt-4 text-center bg-success p-md-5 p-2 rounded">
                <h2 class="text-white" style="font-family: 'Sawarabi Mincho', sans-serif;">デモをしよう!</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="text-center text-light">
                <h1>
                    <i class="fas fa-arrow-down mx-2"></i>
                    <i class="fas fa-arrow-down mx-2"></i>
                </h1>
            </div>
        </div>
    </div>
    <div class="row my-5 mx-3 justify-content-center rounded shadow">
        <div class="col-md-8 bg-light rounded mt-5">
            <h2 class="text-center p-md-5 block" style="font-family: 'Sawarabi Mincho', sans-serif;">{{ link_to_route('groups.index', 'デモを始める') }}</h2>     
        </div>
    </div>
</div>
@endsection
