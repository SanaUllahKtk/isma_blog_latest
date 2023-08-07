<x-site.layout>
    <section id="blog" class="blog-area  p-relative pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="section-title text-center mb-80 wow fadeInDown animated"
                        data-animation="fadeInDown animated" data-delay=".2s">
                        <h2>Latest Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">

                @forelse ($blogs as $blog)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-post active mb-30 wow fadeInUp animated" data-animation="fadeInDown animated"
                            data-delay=".2s">

                            @php
                             $is_favorite = \App\Models\BlogFavorite::where(['blog_id' => $blog->id, 'user_id' => isset(auth()->user()->id) ? auth()->user()->id : 0 ])->first();
                            @endphp
                            <a href="javascript:void()" data-blog-id={{$blog->id}} class="{{ isset($is_favorite) ? 'text-danger' : 'text-secondary' }} favorite-blog" style="position: absolute; top: 1rem; right: 1rem;"> <span><i class="fa fa-heart fs-5"></i></span></a>


                            <div class="blog-thumb">
                                <a href="{{ route('blog-details', $blog->id) }}">

                                    
                                
                                    @if(!isset($blog->image) || empty($blog->image) || !file_exists($blog->image))
                                    <img src="{{asset('images/not_found.png')}}" alt="" class="card-img-top" style="height: 300px;object-fit: cover;">
                                     @else
                                     <img style="height: 300px;object-fit: cover;" src="{{ asset($blog->image) }}" alt="img">
                                     @endif
                                
                                
                                </a>

                            </div>
                            <div class="blog-content" style="height: 350px; position: relative;">
                                
                                <div class="content">
                                    <div class="b-meta mb-20">
                                        <ul>
                                            <li><a href="#">By {{ $users[$blog->user_id] }} .</a></li>
                                            <li><a href="#">
                                                @php
                                                $createdDate = \Carbon\Carbon::parse($blog->created_at);
                                            @endphp
                                            
                                                   {{ $createdDate->diffForHumans() }}
                                                </a></li>
                                        </ul>
                                    </div>
                                    <h4><a href="{{ route('blog-details', $blog->slug) }}">{{ $blog->title }}</a>
                                    </h4>
                                    <p>
    
                                        {!! Str::limit($blog->description, 100) !!}
    
                                    </p>
                                </div>
                                <a href="{{ route('blog-details', $blog->id) }}" class="btn blog-btn" style="position: absolute; bottom: 3.5rem;">Read More</a>

                                @php
                                    $is_liked = \App\Models\BlogLike::where(['blog_id' => $blog->id, 'user_id' => isset(auth()->user()->id) ? auth()->user()->id : 0])->first();

                                @endphp
                                <div class="" style="position: absolute; bottom: 1rem;">
                                   <a href="javascript:void();" class=""> <span><i class="fas fa-comment-dots fs-5"></i><span class="total_comments mx-1">{{$blog->blogcomments}}</span></span></a>
                                   <a href="javascript:void();" class=""> <span class="mx-3"><i class="fa fa-eye fs-5"></i> <span class="total_views">{{$blog->blogviews}}</span></span></a>
                                  
                                   
                                   <a href="javascript:void(0)" class="fa fa-location-arrow fs-5 share-modal-button" type="button" data-toggle="modal" data-target="#exampleModal" data-blog-id="{{$blog->id}}"><span class="total_shares mx-1">{{$blog->blogshares}}</span></a>
                                   
                                    <a href="javascript:void(0);" class="{{ $is_liked ? 'text-success' : 'text-secondary'}} like-blog" data-blog-id="{{$blog->id}}"><span class="mx-3"><i class="fa fa-thumbs-up fs-5"></i> <span class="total_likes">{{$blog->bloglikes}}</span></span></a>
                                </div>



                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>

        </div>
    </section>

    <style>
        .ui-autocomplete {
            z-index: 9999 !important; /* Set a high z-index value */
        }
    </style>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Share Blog</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                    <label for="">Enter member name</label>
                    <input type="text" class="form form-control" id="tags" value="">
                    <input type="hidden" class="selected_value" value="">
                    <input type="hidden" class="blog-id" value="">
               </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary shared-button">Share <i class="fa fa-location-arrow"></i></button>
            </div>
          </div>
        </div>
      </div>
      <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <x-slot name="scripts">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script>
            $(function() {
                isLoggedIn =  {{ Auth::check() ? 'true' : 'false' }}
                var availableTags = [];

                @foreach($users as $key => $user)
                    availableTags.push({
                        value: {{ json_encode($key) }},
                        label: {!! json_encode($user) !!}
                    });
                @endforeach

                $("#tags").autocomplete({
                    source: availableTags,
                    select: function (event, ui) {
                            $(this).val(ui.item.label);
                            var selectedValue = ui.item.value;
                            $(".selected_value").val(selectedValue);
                            event.preventDefault();
                        }
                });

                $(".share-modal-button").on("click", function(){
                    check_login();
                    var blog_id = $(this).attr('data-blog-id');
                    $('.blog-id').val(blog_id);
                })
      

                $(".shared-button").on("click", function(){
                    check_login();
                    var id = $('.blog-id').val();
                    var share_to =  $(".selected_value").val();

                    $.ajax({
                        url: '{{ route('dashboard.blog.sharing-blog') }}',
                        type: 'POST',
                        data: { id: id, share_to},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                           if(response.status == 'success'){
                                $(".total_shares").text(response.total_share);
                                Notiflix.Notify.success(response.message, {
                                    ID: 'MKA',
                                    timeout: 1500,
                                    showOnlyTheLastOne: true,
                                });
                           }else{
                                Notiflix.Notify.failure(response.message, {
                                    ID: 'MKA',
                                    timeout: 1500,
                                    showOnlyTheLastOne: true,
                                });
                           }
                        }
                    });

                    $("#tags").val('');
                    $(".selected_value").val('');
                    $("#exampleModal").modal("hide");
                })
        
        
                $(".favorite-blog").on("click", function(){
                    check_login();
                    var favorite = '';
                    var id = $(this).attr('data-blog-id');
                    
                    if($(this).hasClass('text-secondary')){
                        $(this).removeClass('text-secondary');
                        $(this).addClass('text-danger');
                        favorite = 'favorite';
                    }else if($(this).hasClass('text-danger')){
                        $(this).removeClass('text-danger');
                        $(this).addClass('text-secondary');
                        favorite = 'unfavorite';
                    }
                    url = '{{ route('dashboard.blog.make-favorite') }}';

                    callAjax(url, id, favorite)
                });

                $(".like-blog").on("click", function(){
                    check_login();
                    var favorite = '';
                    var id = $(this).attr('data-blog-id');
                    
                    if($(this).hasClass('text-secondary')){
                        $(this).removeClass('text-secondary');
                        $(this).addClass('text-success');
                        favorite = 'like';
                    }else if($(this).hasClass('text-success')){
                        $(this).removeClass('text-success');
                        $(this).addClass('text-secondary');
                        favorite = 'unlike';
                    }


                    $.ajax({
                        url: '{{ route('dashboard.blog.make-like') }}',
                        type: 'POST',
                        data: { id: id, favorite},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                           if(response.status == 'success'){
                                $(".total_likes").text(response.total_likes);
                           }
                        }
                    });
                });

                function callAjax(url, id, favorite){
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: { id: id, favorite},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                        }
                    });
                }
        
                function check_login(){                    
                    if(!isLoggedIn){
                        Notiflix.Notify.failure('Please login first', {
                            ID: 'MKA',
                            timeout: 1500,
                            showOnlyTheLastOne: true,
                        });

                        return false;
                    }
                }

                
            });
        </script>
        </x-slot>
</x-site.layout>






