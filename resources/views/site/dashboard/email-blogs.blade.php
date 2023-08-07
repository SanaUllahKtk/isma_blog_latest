@extends('layouts/user_layout')

@section('title', 'Shared Blogs')
@section('page-style')
@endsection

@section('content')
<section class="" style="min-height: 70vh;">
  <h3>All Latest Blogs</h3>
      

   <div class="row">
    @if(count($blogs) > 0)
      @foreach($blogs as $blog)
      <div class="col-md-4">
        <a href="/dashboard/blogs/{{$blog->id}}" class="text-dark">
            <div class="card" style="width: 18rem; min-height: 400px;">
                @if(!isset($blog->image) || empty($blog->image) || !file_exists($blog->image))
               <img src="{{asset('images/not_found.png')}}" alt="" class="card-img-top" style="height: 200px;">
                @else
                <img class="card-img-top" src="{{ asset($blog->image) }}" alt="image" style="height: 200px;">
                @endif
              
               <div class="card-body py-2" style="position: relative;">
                 <h5 class="card-title">{{$blog->title}}</h5>
   
                 <p class="card-text">
                   @php
                   $truncatedDescription = mb_substr($blog->description, 0, 100);
                   $isTruncated = strlen($blog->description) > 100;
                   @endphp
                   {!! $truncatedDescription !!}
                   @if ($isTruncated)
                   ... <a href="/dashboard/blogs/{{$blog->id}}"> (More)</a>
                   @endif
                 </p>

                 <div style="position: absolute; bottom: 1rem;">
                     <a href="javascript:void(0)" class="bi bi-envelope email-model-button" data-user-id="{{$blog->user_id}}"  data-bs-toggle="modal" data-bs-target="#exampleModal"></a>
                 </div>
               </div>
             </div>

        </a>
    </div>
      @endforeach
    @endif
    
   </div>
</section>
@endsection


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Email</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
            <form action="{{route('dashboard.blog.sending-mail')}}" class="" method="POST">
                @csrf

                <div class="form-group">
                    <label for="" class="">To</label>
                    <input type="text" class="form form-control mail_to" name="to" value="" readonly>
                </div>

                <div class="form-group">
                    <label for="" class="">Subject</label>
                    <input type="text" class="form form-control mail_subject" name="subject" value="" required>
                    <span class="subject_error_message text-danger d-none">Please enter subject</span>
                </div>


                <div class="form-group">
                    <label for="" class="">Message</label>
                   <textarea name="message" id="" cols="30" rows="10" class="form form-control mail_message" required></textarea>
                   <span class="message_error_message text-danger d-none">Please enter message</span>
                </div>


           

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary send_email_button">Send</button>
        </div>

        </form>
      </div>
    </div>
  </div>




@pushonce('component-script')
<script>
    $(function(){
        $(".email-model-button").on("click", function(){
            var user_id = $(this).attr('data-user-id');
            var user_mail = @json($user_emails);
            $(".mail_to").val(user_mail[user_id]);
        })


        $(".send_email_button").on("click", function(){
            var send_email = true;

            if($(".mail_subject").val() == ''){
                send_email = false;
                $(".subject_error_message").removeClass('d-none');
            }


            if($(".mail_message").val() == ''){
                send_email = false;
                $(".message_error_message").removeClass('d-none');
            }

        })
    })
</script>
@endpushonce