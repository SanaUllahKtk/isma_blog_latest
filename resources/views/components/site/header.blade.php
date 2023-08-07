<header class="header-area">
    <div id="header-sticky" class="menu-area">
        <div class="container">
            <div class="second-menu">
                <div class="row align-items-center">
                    <div class="col-xl-2 col-lg-2">
                        <div class="logo">
                            <a href="/"><img class="logo" src="/site/img/logo/logo.jpeg" alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-9">
                        <div class="responsive"><i class="icon dripicons-align-right"></i></div>
                        <div class="main-menu text-right text-xl-center">
                            <nav id="mobile-menu">
                                <ul>

                                    <li><a href="/">Home</a></li>
                                    <li class="has-sub">
                                        <a href="/about-us">About Us</a>
                                        <ul>
                                            <li><a href="/presidents-message">President's Message</a></li>
                                            <li><a href="/board">Executive Officers and Board</a></li>
                                            <li><a href="/committee-members">Committee Members</a></li>
                                            <li><a href="#">Staff List</a></li>
                                            <li><a href="#">Privacy Policy</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-sub"> <a href="/events">Events</a>
                                    </li>
                                    <li><a href="/contact-us">Contact Us</a></li>
                                    <li><a href="/blogs">Blog</a></li>

@auth
                                   
                                        <li> <a href="/feeds">Feeds</a></li>
     @endauth()                               

                                    @guest
                                        <li class="d-xl-none"> <a href="/login">Login</a></li>
                                    @endguest
                                    @auth
                                        <li class="d-xl-none"> <a
                                                href="@if (auth()->user()->isAdmin === '1') /admin
                                            @else
                                            /dashboard @endif">Dashboard</a>
                                        </li>

                                    @endauth

                                </ul>
                            </nav>
                        </div>
                    </div>
                    @guest
                        <div class="col-xl-2 text-right d-none d-xl-block">
                            <div class="header-btn second-header-btn">
                                <a href="/login" class="btn">Login</a>
                            </div>
                        </div>

                    @endguest

                    @auth
                        <div class="col-xl-2 text-right d-none d-xl-block">
                            <div class="header-btn
                            second-header-btn">
                                <a href="@if (auth()->user()->isAdmin === '1') /admin
                                @else
                                /dashboard @endif"
                                    class="btn">{{ auth()->user()->name }}</a>

                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>
