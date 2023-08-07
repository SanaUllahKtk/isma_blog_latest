@extends('layouts/user_layout')

@section('title', 'Dashboard')
@section('page-style')

@endsection

@section('content')


<div class="container text-center">
    <div class="card p-3 m-3 shadow" style="border-radius: 8px;">
        <div class="row">
            <div class="col">
                <img src="https://tricky-photoshop.com/wp-content/uploads/2017/08/final-1.png" width="45px" height="100%">
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control bg-light" id="exampleFormControlInput1" placeholder="WHAT DO YOU WANT TO ASK OR SHARE?" style="border-radius: 10px;">
            </div>
            <div class="col-md-3 mt-2">
                <span class="">
                    <i class="fa-solid fa-square-pen"></i>
                    POST
                </span>
                <span class="d-inline-block px-2">||</span>
                <span class="">
                    <i class="fa-solid fa-info pe-1"></i>
                    ASK
                </span>
            </div>
        </div>
    </div>
</div>

@if(count($blogs) > 0)
@foreach($blogs as $blog)
<!-- Post -->
<div class="container">
    <div class=" card p-3 m-3" style="border-radius: 10px;">
        <div class="d-flex justify-content-between">
            <div class="d-flex mx-3">
                <div>
                    <img src="https://tricky-photoshop.com/wp-content/uploads/2017/08/final-1.png" width="50px" height="100%">
                </div>
                <div class="mx-3">
                    <h5>{{ Auth()->user()->name }}</h5>
                    <span>{{ Auth()->user()->company_name }}</span>
                </div>
            </div>
            <div class="mt-3">
                <!-- <i class="fa-solid fa-rectangle-xmark"></i> -->
                <a href="{{ route('dashboard.blog.edit', ['blog' => $blog->id]) }}" class="btn btn-sm btn-primary bi bi-pencil-square"></a>
                <a href="javascript:void()" class="btn btn-sm btn-danger bi bi bi-trash delete-blog" data-blog-id="{{$blog->id}}"></a>
            </div>
        </div>

        <div class="col-12 px-3 my-3">
            <img src="{{ asset($blog->image) }}" class="img-fluid w-100" style="max-height: 400px;">
        </div>
        <div class="col-md-12 my-3 px-3">
            <h5>{{$blog->title}}</h5>
            <span>
                @php
                $truncatedDescription = mb_substr($blog->description, 0, 200);
                $isTruncated = strlen($blog->description) > 200;
                @endphp
                {!! $truncatedDescription !!}
                @if ($isTruncated)
                ...<a href="{{ route('dashboard.blog.show', ['blog' => $blog->id]) }}"> (More)</a>
                @endif
            </span>
        </div>
        <div class="d-flex mw-100 justify-content-between">
            <div class="col-9 mx-3">
                <span><i class="bi bi-chat-dots-fill fs-5"></i> {{ $blog->blogcomments }}</span>
                <span class="mx-3"><i class="bi bi-eye fs-5"></i> {{ $blog->blogviews }}</span>
                <span><i class="bi bi-send-fill fs-5"></i> {{ $blog->blogshares }}</span>
                <span class="mx-3"><i class="bi bi-hand-thumbs-up-fill fs-5"></i> {{ $blog->bloglikes }}</span>
            </div>
            <div class="col-3 d-flex justify-content-center">
            </div>
        </div>

    </div>
</div>
<!-- 2nd -->
@endforeach
@endif


@endsection

@pushonce('component-script')
<script>
    $(function() {
         $(".delete-blog").on("click", function(){
            var id = $(this).attr('data-blog-id');
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '/dashboard/blog/' + id, 
                        type: 'DELETE',
                        data: { id: id },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire(
                                    'Blog Deleted!',
                                    'Blog deleted successfully',
                                    'success'
                                    )
                                window.location.href='dashboard/';
                               // snb('success', response.header || 'Success', response.message || 'Blog Deleted');
                            }
                        }
                    });
                }
            })
         })
    });
</script>
@endpushonce