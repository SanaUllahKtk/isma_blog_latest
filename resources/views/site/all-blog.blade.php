@extends('layouts/contentLayoutMaster')

@section('title', 'Blogs')
@section('page-style')
@endsection

@section('content')

<section class="card">
    <div class="row match-height">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <table class="table dataTable table-borderless table-hover-animation" style="overflow-x: scroll;">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>User</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    @if(count($blogs) > 0)
                      @foreach($blogs as $key => $blog)
                        <tr>
                            <td> {{ $key+1 }}</td>
                            <td> {{ $blog->title }}</td>
                            <td> {{ $blog->user->name }}</td>
                            <td> 

                                <div class="custom-control custom-control-success custom-switch">
                                    <input type="checkbox" class="custom-control-input status-switches" value="{{$blog->id}}" id="switchCheckbox-{{$blog->id}}" data-blog-id="{{$blog->id}}" name="switchValue" {{ $blog->status == 'active' ? 'checked' : ''}} >
                                    <label class="custom-control-label" for="switchCheckbox-{{$blog->id}}"></label>
                                </div>

                            </td>
                        </tr>
                      @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>


@endsection
@section('page-script')
@endsection

@pushonce('component-script')
<script>
 $('.status-switches').on("change", function(){
    var id = $(this).attr('data-blog-id') // Assuming you have a data-id attribute on the checkbox
    var status = this.checked ? 'active' : 'inactive';
    let block = ".card";

    blockDiv(block);
    $.ajax({
        url: '{{ route('admin.blogs.status') }}',
        type: 'PUT',
        data: { id: id, status: status },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            unblockDiv(block);
            if(response.status == 'success'){
                snb('success', response.header ?? 'Success', response.message ?? 'Status Changed');
            }
        },
        error: function(xhr, status, error) {
            // Handle the error response from the server
        }
    });
 })
</script>
@endpushonce