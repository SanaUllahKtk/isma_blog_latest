@php
use App\Models\Notification;
$notifications = Notification::where(['user_id' => auth()->user()->id, 'seen' => '0'])->orderBy('created_at', 'DESC')->get();
@endphp


<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex justify-content-between bg-secondary">

    <div class="d-flex align-items-center justify-content-between">
        <i class="bi bi-list toggle-sidebar-btn"></i>
        <a href="index.html" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block mx-3">ISMA</span>
        </a>
    </div>

    <!-- End Logo -->


    <nav class="header-nav d-flex flex-row mt-2">

        <div>
            <ul class="nav justify-content-end">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('site.home')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('blogs')}}">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('events')}}">Events</a>
                </li>
            </ul>
        </div>

        <div>
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number"><span class="total_noti1">{{count($notifications) }}</span></span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style="max-height: 300px; overflow-y: scroll;">
                        <li class="dropdown-header">
                            You have <span class="total_noti2">{{count($notifications)}}</span> new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        @foreach($notifications as $noti)
                        <li class="notification-item" data-notification-id="{{$noti->id}}">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>{{$noti->title}}</h4>
                                <p>{{$noti->message}}</p>
                                <p>
                                    @php
                                    $createdDate = \Carbon\Carbon::parse($noti->created_at);
                                @endphp
                                
                                       {{ $createdDate->diffForHumans() }}
                                </p>
                            </div>
                        </li>
                        @endforeach

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">Menu</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="@if (auth()->user()->isAdmin === '1') #
            @else
                {{ route('dashboard.profile') }} @endif">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="">
                                <i class="bi bi-question-circle"></i>
                                <span>Need Help?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="@if (auth()->user()->isAdmin === '1') #
                @else
                    {{ route('logout') }} @endif">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li>

                <!-- End Profile Nav -->

            </ul>
        </div>


    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->


@pushonce('component-script')
<script>
  $(".notification-item").on("click", function(){
    event.preventDefault(); 

     var id = $(this).attr('data-notification-id');
     var cur = $(this);

        $.ajax({
            url: '{{ route('dashboard.blog.remove.notification') }}',
            type: 'POST',
            data: {id: id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
            
                // Handle the success response from the server
                if (response.status == 'success') {
                  $(".total_noti1").text(response.total_noti);
                  $(".total_noti2").text(response.total_noti);
                  cur.remove();
                }

            }
        });
  })
</script>
@endpushonce