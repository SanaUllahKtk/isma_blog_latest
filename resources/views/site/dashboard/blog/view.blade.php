@extends('layouts/user_layout')

@section('title', 'Blog View')
@section('page-style')

@endsection

@section('content')

<!-- Post -->
<div class="container">
    <div class=" card p-3 m-3" style="border-radius: 10px;">
       

        <div class="col-12 px-3 my-3">
            <img src="{{ asset($blog->image) }}" class="img-fluid w-100" style="max-height: 400px;">
        </div>
        <div class="col-md-12 my-3 px-3">
            <h5 class="" style="font-weight: bold;">{{$blog->title}}</h5>
            <span>
                {!! $blog->description  !!}
            </span>
        </div>
        <div class="d-flex mw-100 justify-content-between">
            <div class="col-9 mx-3">
                <span><i class="bi bi-chat-dots-fill fs-5"></i> {{ $blog->blogcomments }}</span>
                <span class="mx-3"><i class="bi bi-eye fs-5"></i> {{ $blog->blogcomments }}</span>
                <span><i class="bi bi-send-fill fs-5"></i> {{ $blog->blogshares }}</span>
                <span class="mx-3"><i class="bi bi-hand-thumbs-up-fill fs-5"></i> {{ $blog->bloglikes }}</span>
            </div>
            <div class="col-3 d-flex justify-content-center">
                <span><i class="bi bi-bookmark-fill fs-5 mx-1"></i></span>
                <span><i class="bi bi-exclamation-triangle-fill fs-5 mx-1"></i></span>
            </div>
        </div>

    </div>
</div>
<!-- 2nd -->



@endsection

