<x-site.layout>
    <section id="blog" class="blog-area  p-relative pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="section-title text-center mb-80 wow fadeInDown animated"
                        data-animation="fadeInDown animated" data-delay=".2s">
                        <h2>Latest Feeds</h2>
                    </div>
                </div>
            </div>
            <div class="row">

                @forelse ($blogs as $blog)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-post active mb-30 wow fadeInUp animated" data-animation="fadeInDown animated"
                            data-delay=".2s">
                            <div class="blog-thumb">
                                <a href="{{ route('feed-details', $blog->slug) }}"><img
                                        style="height: 300px;object-fit: cover;" src="{{ asset($blog->image) }}"
                                        alt="img"></a>
                            </div>
                            <div class="blog-content">
                                <div class="b-meta mb-20">
                                    <ul>
                                        <li><a href="#">By {{ $blog->user->name }} .</a></li>
                                        <li><a href="#">
                                                {{ $blog->created_at->format('jS F Y') }}
                                            </a></li>
                                    </ul>
                                </div>
                                <h4>
                                    <a href="{{ route('feed-details', $blog->slug) }}">{{ $blog->title }}</a>
                                </h4>
                                <p>

                                    {!! Str::limit($blog->description, 100) !!}

                                </p>
                                <a href="{{ route('feed-details', $blog->slug) }}" class="btn blog-btn">Read More</a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>

        </div>
    </section>
</x-site.layout>
