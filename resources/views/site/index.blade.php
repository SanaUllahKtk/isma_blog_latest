<x-site.layout>
    <section id="home" class="slider-area fix p-relative">

        <div class="row justify-content-center mt-5">
            <div class="col-md-10 text-center swiper-holder">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @forelse ($sliders as $slide)
                            <div class="swiper-slide"> <img class="slider-image" src="{{ asset($slide->image) }}"
                                    alt="">
                            </div>
                        @empty

                            <div class="swiper-slide"> <img class="slider-image" src="https://placehold.co/1000x500"
                                    alt="">
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="choose-area pt-120 pb-120 p-relative mt-5" style="background:#f5f8fa;">
        <div class="chosse-img wow fadeInRight animated" data-animation="fadeInRight animated" data-delay=".2s"
            style="background-image:url(site/img/bg/president.jpeg)"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-6  d-md-none">
                    <img height="100%" width="100%" class="mb-sm-5" src="site/img/bg/president.jpeg" alt="">
                </div>
                <div class="col-xl-6">
                    <div class="choose-wrap">
                        <div class="section-title w-title left-align mb-35 wow fadeInDown animated"
                            data-animation="fadeInDown animated" data-delay=".2s">
                            <h2>ISMA Note</h2>
                        </div>
                        <div class="choose-content wow fadeInUp animated" data-animation="fadeInDown animated"
                            data-delay=".2s">

                            <p class="fs-5">
                                As an entrepreneur you have to manage many activities. In this condition it always helps
                                if someone from your field is there to support you. Keeping this in mind we have formed
                                this association wherein lots of technical information is shared amongst members. Our
                                endeavour is to reach globally and be very active in networking with like-minded
                                manufacturers and enhancing our knowledge.
                            </p>

                            <div class="text-right">
                                <h4>
                                    Utpal Shah
                                </h4>
                                <p class="m-0 p-0">
                                    President ISMA
                                    <br>
                                    Director,<br>
                                    Accurate Helical Springs Pvt Ltd.

                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="choose-area pt-120 pb-120 p-relative mt-5" style="background:#f5f8fa;">

        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="choose-wrap">
                        <div class="section-title w-title left-align mb-35 wow fadeInDown animated"
                            data-animation="fadeInDown animated" data-delay=".2s">
                            <h2>Become a member </h2>
                        </div>
                        <div class="choose-content wow fadeInUp animated" data-animation="fadeInDown animated"
                            data-delay=".2s">
                            <p>Become a member now to be part of a vibrant community of like-minded people from your
                                industry..</p>

                            <p>
                                Get access to our technical support by attending the training programs where we support
                                you to grow in terms of quality and productivity
                            </p>
                        </div>
                    </div>
                    @guest
                        <div class="choose-btn mt-4">
                            <a href="/register" class="btn">Click Here</a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <section class="choose-area pt-120 pb-120 p-relative mt-5" style="background:#f5f8fa;">

        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="choose-wrap">
                        <div class="section-title w-title left-align mb-35 wow fadeInDown animated"
                            data-animation="fadeInDown animated" data-delay=".2s">
                            <h2>Criteria</h2>
                        </div>
                        <div class="choose-content wow fadeInUp animated" data-animation="fadeInDown animated"
                            data-delay=".2s">
                            <p>Pellentesque habitant morbi tristique senectus et netus et fames acturpis egestas.
                                Vestibulum tortor quam, feugiat vitae, tempor sit amet, ante. Donec eu libero sit amet
                                quam egestas semper. mivitae est. Mauris placerat eleifend leo. Quisque sit amet est et
                                sapien.</p>

                            <div class="choose-list mb-45">
                                <ul>
                                    <li>
                                        <i class="icon dripicons-checkmark"></i>
                                        <span>
                                            Companies with a Turnover of Rs. 3 Cr – 10 Cr has to contribute Rs. 20000/-
                                            as Annual Membership.
                                        </span>
                                    </li>
                                    <li>
                                        <i class="icon dripicons-checkmark"></i>
                                        <span>
                                            Turnover of Rs. 10 Cr – 25 Cr has to contribute Rs. 30000/- as Annual
                                            Membership.
                                        </span>
                                    </li>
                                    <li>
                                        <i class="icon dripicons-checkmark"></i>
                                        <span>
                                            Turnover of Rs. 25 Cr & Above has to contribute Rs. 50000/- as Annual
                                            Membership.
                                        </span>
                                    </li>
                                    <li>
                                        <i class="icon dripicons-checkmark"></i>
                                        <span>
                                            Membership Criteria for the year 1st April 2020 to 31st March 2021.
                                        </span>
                                    </li>
                                    <li>
                                        <i class="icon dripicons-checkmark"></i>
                                        <span>
                                            ISO 9001 Certification can Qualify to become member after our selection
                                            committee’s approval.
                                        </span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="services-area services-bg pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="section-title text-center pl-40 pr-40 mb-80 wow fadeInDown animated"
                        data-animation="fadeInDown animated" data-delay=".2s">
                        <h2> Vision</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-30">
                    <div class="s-single-services active wow fadeInUp animated" data-animation="fadeInDown animated"
                        data-delay=".2s">
                        <div class="services-icon">
                            <i class="fal fa-tachometer-alt-fastest"></i>
                        </div>
                        <div class="second-services-content">
                            <h5>To Unite</h5>
                            <p>To unite & leverage spring manufacturers resources </p>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-30">
                    <div class="s-single-services active wow fadeInUp animated" data-animation="fadeInDown animated"
                        data-delay=".2s">
                        <div class="services-icon">
                            <i class="fal fa-users-crown"></i>
                        </div>
                        <div class="second-services-content">
                            <h5>To Educate</h5>
                            <p>To educate the industry about importance of springs. </p>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-30">
                    <div class="s-single-services active wow fadeInUp animated" data-animation="fadeInDown animated"
                        data-delay=".2s">
                        <div class="services-icon">
                            <i class="fal fa-gem"></i>
                        </div>
                        <div class="second-services-content">
                            <h5>To Upgrade</h5>
                            <p>To upgrade & enhance our skills through knowledge sharing. </p>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <section class="services-bg pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12">
                    <div class="section-title text-center pl-40 pr-40 mb-80 wow fadeInDown animated"
                        data-animation="fadeInDown animated" data-delay=".2s">
                        <h2>Our Activities</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">

                        <ul class="activity-list choose-list ">
                            <li class="wow slideInLeft" data-wow-duration="1s" data-wow-delay="0s">
                                <p class="fs-5">
                                    We will arrange 2-3 meetings per year for networking and solving our common issues
                                    we all have common problems.
                                </p>
                            </li>
                            <li class="wow slideInLeft" data-wow-duration="1s" data-wow-delay="0s">
                                <p class="fs-5">
                                    Technical support for springs design, manufacturing, testing, surface finishing,
                                    failure analysis etc. within members by internal sharing.
                                </p>
                            </li>
                            <li class="wow slideInLeft" data-wow-duration="1s" data-wow-delay="0s">
                                <p class="fs-5">
                                    Spring standard upgradation and Meeting & working with Steel Ministry and BIS.
                                    Independent testing & comparison of springs within ourselves for validation and
                                    showing
                                    to customers.
                                </p>
                            </li>
                            <li class="wow slideInLeft" data-wow-duration="1s" data-wow-delay="0s">
                                <p class="fs-5">
                                    Sharing of technical expertise, new ideas & problem solving.
                                </p>
                            </li>
                            <li class="wow slideInLeft" data-wow-duration="1s" data-wow-delay="0s">
                                <p class="fs-5">
                                    Providing various technical training by the members by positive sharing.
                                </p>
                            </li>
                            <li class="wow slideInLeft" data-wow-duration="1s" data-wow-delay="0s">
                                <p class="fs-5">
                                    Industry newsletters and updates sharing.
                                </p>
                            </li>
                            <li class="wow slideInLeft" data-wow-duration="1s" data-wow-delay="0s">
                                <p class="fs-5">
                                    Listing Surplus, non-moving stock of raw material & finished goods.
                                </p>
                            </li>

                            <li class="wow slideInLeft" data-wow-duration="1s" data-wow-delay="0s">
                                <p class="fs-5">
                                    Listing of Spare manufacturing capacity.
                                </p>
                            </li>
                            <li class="wow slideInLeft" data-wow-duration="1s" data-wow-delay="0s">
                                <p class="fs-5">
                                    WhatsApp group for quick discussion and solutions.
                                </p>
                            </li>
                            <li class="wow slideInLeft" data-wow-duration="1s" data-wow-delay="0s">
                                <p class="fs-5">
                                    Listing of used/ old spring machines for sale.
                                </p>
                            </li>

                        </ul>

                    </div>


                </div>
            </div>
        </div>
    </section>
    <section class="services-bg pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12">
                    <div class="section-title text-center pl-40 pr-40 mb-80 wow fadeInDown animated"
                        data-animation="fadeInDown animated" data-delay=".2s">
                        <h2>Members List</h2>
                    </div>
                </div>

                <div class="col-12">

                    <ul class="activity-list member-list choose-list ">

                        @foreach ($members as $key => $m)
                            <li class="wow slideInLeft" data-wow-duration="1s" data-wow-delay="0s">
                                <p class="fs-5">
                                    <strong> {{ $key + 1 }}. Company Name: </strong> {{ $m->name }}
                                </p>
                            </li>
                        @endforeach
                    </ul>

                </div>



            </div>
        </div>
    </section>
    <section class="choose-area pt-120 pb-120 p-relative" style="background:#f5f8fa;">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="choose-wrap">
                        <div class="section-title w-title left-align mb-35 wow fadeInDown animated"
                            data-animation="fadeInDown animated" data-delay=".2s">
                            <h2>Contact Us</h2>
                        </div>
                        <div class="choose-content wow fadeInUp animated" data-animation="fadeInDown animated"
                            data-delay=".2s">
                            <p>I look forward to hearing suggestions from you and if you require any more information
                                from us please do not hesitate to contact. At present we have 45 plus like-minded spring
                                manufacturers from 3-100 Cr turnover from Mumbai, Pune, Nasik, Baroda, Bangalore,
                                Chennai, Bangalore, Coimbatore, Delhi NCR, Anand, Jalgaon etc.
                                With this intent we propose that you be a member of our group. Please fill the
                                application form with all necessary proofs like GST certificate, PAN card and send us so
                                we can add you to WhatsApp group to start with.
                                More united we are more benefits we will have.</p>


                            <div class="choose-btn mt-4">
                                <a href="/contact-us" class="btn">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-slot name="scripts">
        <script>
            var swiper = new Swiper(".mySwiper", {});
        </script>
    </x-slot>
</x-site.layout>
