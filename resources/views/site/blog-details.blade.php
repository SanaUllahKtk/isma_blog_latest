<x-site.layout>

    <section class="inner-blog b-details-p pt-120 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-details-wrap">
                        <div class="bsingle__post-thumb mb-30">
                            <img src="{{ asset($blog->image) }}" alt="">
                        </div>
                        <div class="meta__info">
                            <ul>
                                <li><a href="#"><i class="far fa-user"></i>by
                                        {{ $blog->user->name }}
                                    </a></li>
                            </ul>
                        </div>
                        <div class="details__content pb-50">
                            <h2>{{ $blog->title }}</h2>
                            <p>
                                {!! $blog->description !!}
                            </p>


                        </div>

                        <div class="related__post mt-45 mb-85">
                            <div class="post-title">
                                <h4>Related Post</h4>
                            </div>
                            <div class="row">
                                @forelse ($related as $r)
                                    <div class="col-md-6">
                                        <div class="related-post-wrap mb-30">
                                            <div class="post-thumb">
                                                <img src="{{ asset($r->image) }}" alt="">
                                            </div>
                                            <div class="rp__content">
                                                <h3>
                                                    
                                                    @if($from =='feed')
                                                    <a href="{{route('feed-details', $r->slug)}}">
                                                        {{ $r->title }}
                                                    </a>
                                                    @else
                                                    <a href="route('blog-details', $r->slug) ">
                                                        {{ $r->title }}
                                                    </a>
                                                    @endif
                                                    
                                                </h3>
                                                <p>
                                                    {!! Str::limit($r->description, 100) !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <div class="col-12 card p-4">
                                        <h4 class="text-center">
                                            No Related Post
                                        </h4>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="comment__wrap pb-45 mb-45">
                            <div class="comment__wrap-title">
                                <h5>Comments</h5>
                            </div>
                            <div class="single__comment mb-35">
                                @forelse ($comments as $c)
                                    <div class="comment-text">
                                        <div
                                            class="avatar-name mb-15 d-flex align-items-center justify-content-between">
                                            <h6>{{ $c->user->name }}</h6>
                                            <span>
                                                {{ $c->created_at->format('dS M Y') }}
                                            </span>
                                        </div>
                                        <div class="comment-wrapper">
                                            <p>
                                                {{ $c->comment }}
                                            </p>

                                            <div class="dlt-btn-wrapper text-right">
                                                @auth()
                                                    @if (auth()->user()->id == $c->user_id)
                                                        <button data-id="{{ $c->id }}" class="dlt-btn">
                                                            <i class="fas fa-trash-alt delete-comment"></i>
                                                        </button>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 card p-4">
                                        <h4 class="text-center">
                                            No Comments
                                        </h4>
                                    </div>
                                @endforelse
                            </div>

                        </div>
                        @auth()
                            <div class="post-comments-form mb-50">
                                <div class="comment__wrap-title">
                                    <h5>Post Comment</h5>
                                </div>
                                <div class="comment-box">
                                    <form id="comment-form" class="comment__form">
                                        <div class="comment-field text-area mb-20">
                                            <i class="fas fa-pencil-alt"></i>
                                            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                            <textarea name="comment" id="comment" cols="30" rows="10" placeholder="Type your comments...."></textarea>
                                        </div>

                                        <button type="submit" class="btn">Post Comments</button>
                                    </form>
                                </div>
                            </div>
                        @endauth

                        @guest
                            <div class="unauth-wrapper position-relative">
                                <a href="/login" class="btn unauth-comment-btn">Login to comment</a>
                                <div class="post-comments-form mb-50 unauth-comment-section">

                                    <div class="comment__wrap-title">
                                        <h5>Post Comment</h5>
                                    </div>
                                    <div class="comment-box">
                                        <form action="#" class="comment__form">
                                            <div class="comment-field text-area mb-20">
                                                <i class="fas fa-pencil-alt"></i>
                                                <textarea disabled name="comment" id="comment" cols="30" rows="10" placeholder="Type your comments...."></textarea>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-4">
                    <aside>
                        <div class="widget mb-40">
                            <div class="widget-title text-center">
                                <h4>Search</h4>
                            </div>
                            <div class="slidebar__form">
                                <form method="get" action="/blogs">
                                    <input type="text" name="q" placeholder="Search your keyword...">
                                    <button><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="widget mb-40">
                            <div class="widget-title text-center">
                                <h4>Follow Us</h4>
                            </div>
                            <div class="widget-social text-center">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-wordpress"></i></a>
                            </div>
                        </div>


                    </aside>
                </div>
            </div>
        </div>
    </section>
    <x-slot name="scripts">
        <script>
            @if (auth()->user())


                $('#comment-form').submit(function(e) {
                    e.preventDefault();
                    rebound({
                        form: $(this),
                        url: '{{ route('comment') }}',
                        reset: false,
                        successCallback: function(data) {
                            console.log(data);
                            $('.single__comment')
                                .append(`
                                    <div class="comment-text">
                                        <div class="avatar-name mb-15">
                                            <h6>{{ auth()->user()->name }}</h6>
                                            <span>
                                                ${data.comment.created_at}
                                            </span>
                                        </div>
                                        <p>
                                            ${data.comment.comment}
                                        </p>
                                    </div>
                                   `);
                            $('#comment').val('');
                        },
                        block: '#comment-form',
                    })
                });


                $('.dlt-btn').click(function(e) {
                    e.preventDefault();
                    const id = $(this).data('id');
                    console.log(id);
                    Notiflix.Confirm.show(
                        'Delete Comment',
                        'Are you sure you want to delete this comment?',
                        'Yes',
                        'No',
                        function() {
                            rebound({
                                url: `{{ route('comment') }}`,
                                data: {
                                    id: id
                                },
                                processData: true,
                                method: 'DELETE',
                                successCallback: function(data) {
                                    console.log(data);
                                    $(`[data-id="${id}"]`).parent().parent().parent().slideUp();
                                },
                                block: '.single__comment',
                            })
                        },
                        function() {
                            // Notiflix.Notify.failure('Comment not deleted');
                        }
                    );

                });
            @endif
        </script>
    </x-slot>
</x-site.layout>
