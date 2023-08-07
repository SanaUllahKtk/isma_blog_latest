<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <div class="card">
    
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
            <svg style="fill: #fff;
                        position: absolute;
                        top: 125px;
                        left: 140px;
                        background: blue;
                        padding: 5px;
                        border-radius: 20px;
                        border: 2px solid #fff;" xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 512 512">
                <path d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6h96 32H424c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z" />
            </svg>
            <h2 class="fw-bold mt-3" style="font-size: 20px;">{{ auth()->user()->name }}</h2>
            <h3 style="font-size: 15px;">{{ auth()->user()->name }}</h3>

        </div>
    </div>



    <ul class="sidebar-nav" id="sidebar-nav">

       <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('dashboard.add-feed') }}">
                <i class="bi bi-grid"></i>
                <span>Add Your Discussion Forum</span>
            </a>
        </li>

        <!-- End Discussion Forum Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="/chatify">
                <i class="bi bi-menu-button-wide"></i><span>Private Messaging</span><i class="bi bi-chevron-right ms-auto"></i>
            </a>
        </li>

        <!-- End Private Messaging Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed"  href="{{route('dashboard.blog.emailblogs')}}">
                <i class="bi bi-journal-text"></i><span>Emailer Option</span><i class="bi bi-chevron-right ms-auto"></i>
            </a>
        </li>

        <!-- End Emailer Option Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('dashboard.blog.sharedblogs') }}">
                <i class="bi bi-share-fill"></i><span>Share</span><i class="bi bi-chevron-right ms-auto"></i>
            </a>
        </li>

        <!-- End Share Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="bi bi-bar-chart"></i><span>Invitaton</span><i class="bi bi-chevron-right ms-auto"></i>
            </a>
        </li>

        <!-- End Invitation Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('dashboard.blog.favoriteblogs') }}">
                <i class="bi bi-gem"></i><span>Favorite Blogs</span><i class="bi bi-chevron-right ms-auto"></i>
            </a>
        </li>

        <!-- End Favorite Blogs Nav -->
</aside>

<!-- End Sidebar-->