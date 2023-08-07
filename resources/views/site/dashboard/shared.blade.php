@extends('layouts/user_layout')

@section('title', 'Shared Blogs')
@section('page-style')
@endsection

@section('content')
<section class="" style="min-height: 70vh;">
  <h3>{{$title}}</h3>
      

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
           
            <div class="card-body py-2">
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
            </div>
          </div>

        </a>
    </div>
      @endforeach
    @endif
    
   </div>
</section>
@endsection