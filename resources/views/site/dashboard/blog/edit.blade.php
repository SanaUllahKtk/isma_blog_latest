@extends('layouts/user_layout')

@section('title', 'Edit Feed')
@section('page-style')

@endsection
@section('content')

<section>
    <div class="row match-height">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.blog.update', ['blog' => $blog->id]) }}" method="POST" enctype="multipart/form-data" id="addFeedForm">
                        <h3 class="text-center">Edit Feed</h3>
                        @csrf
                        @method('PUT')
                        <div class="form form-group">
                            <label for="">Title</label>
                            <div class="form-group">
                                <div class="">
                                    <input type="text" name="title" class="form form-control" value="{{$blog->title}}" required>
                                </div>
                                <span class="invalid-tooltip">Please provide a valid title</span>
                            </div>
                        </div>


                        <div class="form form-group my-3">
                            <label for="">Image</label>
                            <div class="form-group">
                                <div class="">
                                    <input type="hidden" name="old_image" value="{{$blog->image}}">
                                    <img src="{{ asset($blog->image) }}" class="img-fluid" width="300px;">
                                    <input type="file" name="image" class="form form-control">
                                </div>
                                <span class="invalid-tooltip">Please provide a valid image</span>
                            </div>
                        </div>



                        <div class="form form-group">
                            <label for="">Blog Body</label>
                            <div class="form-group">
                                <div id="editor" style="min-height: 150px;">
                                {!! $blog->description !!}
                                </div>
                                <input type="hidden" name="content">
                                <span class="invalid-tooltip">Please provide a valid title</span>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary my-2 mx-auto" name="Submit" value="Update">

                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection


@pushonce('component-script')
<script>
    $(function() {
        var quill = new Quill('#editor', {
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block']
                ]
            },
            placeholder: 'Compose an epic...',
            theme: 'snow' // or 'bubble'
        });


        $('#addFeedForm').on('submit', function(event) {
            // Get the editor's content as HTML
            var content = quill.root.innerHTML;
            // Set the content as the value of the hidden input field
            $('input[name="content"]').val(content);
        });
    })
</script>

@endpushonce