<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>ISMA - {{ $title ?? '' }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="/site/img/favicon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="/site/css/bootstrap.min.css">
    <link rel="stylesheet" href="/site/css/animate.min.css">
    <link rel="stylesheet" href="/site/css/magnific-popup.css">
    <link rel="stylesheet" href="/site/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="/site/css/dripicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.5/swiper-bundle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notiflix@3.2.5/src/notiflix.css">
    <link rel="stylesheet" href="/site/css/default.css">
    <link rel="stylesheet" href="/site/css/style.css">
    <link rel="stylesheet" href="/site/css/responsive.css">
    <link rel="stylesheet" href="/site/css/override.css">

    <style>
        .activity-list>li {
            /* border: 1px solid; */
            padding: 10px 50px;
            /* box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; */
            box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px;
            margin-bottom: 20px;
            border-radius: 5px;
            background: #f5f8fa;
        }

        .fs-5 {
            margin: 0 !important;
            font-size: medium !important;
        }

        .swiper-holder {
            box-shadow: 0 .25rem 1.125rem rgba(75, 70, 92, .1);
        }

        .member-list {
            display: grid;
            grid-gap: 1rem;
            grid-template-columns: 1fr 1fr;
            grid-auto-flow: dense;
            padding: 0.5rem;
        }


        @media only screen and (max-width: 990px) {
            .member-list {
                grid-template-columns: 1fr;
            }
        }

        .row.match-height>div {
            display: flex;
            flex: 1 auto;
        }

        .logo {
            height: 65px;
            width: auto !important;
        }
    </style>

    {!! $styles ?? '' !!}
</head>

<body>

    <x-site.header />
    <main>

        {{ $slot }}
    </main>

    <x-site.footer />




    <script src="/site/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="/site/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="/site/js/popper.min.js"></script>
    <script src="/site/js/bootstrap.min.js"></script>
    <script src="/site/js/one-page-nav-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.5/swiper-bundle.min.js"></script>
    <script src="/site/js/ajax-form.js"></script>
    <script src="/site/js/paroller.js"></script>
    <script src="/site/js/wow.min.js"></script>
    <script src="/site/js/js_isotope.pkgd.min.js"></script>
    <script src="/site/js/imagesloaded.min.js"></script>
    <script src="/site/js/parallax.min.js"></script>
    <script src="/site/js/jquery.waypoints.min.js"></script>
    <script src="/site/js/jquery.counterup.min.js"></script>
    <script src="/site/js/jquery.scrollUp.min.js"></script>
    <script src="/site/js/parallax-scroll.js"></script>
    <script src="/site/js/jquery.magnific-popup.min.js"></script>
    <script src="/site/js/element-in-view.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3.2.5/src/notiflix.js"></script>
    <script src="/site/js/main.js"></script>
    <script src="/site/js/init.js"></script>


    {!! $scripts ?? '' !!}
</body>

</html>
