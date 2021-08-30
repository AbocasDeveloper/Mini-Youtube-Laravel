@extends('layouts.app')

@section('content')
<center>
<div class="container">
    <div class="row">

        <div class="container">
            @if(session('message'))
                <hr>
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                <hr>
            @endif

            @include('video.videosList')

        </div>
    </div>
</div>
</center>
@endsection
