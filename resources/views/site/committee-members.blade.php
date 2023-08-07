<x-site.layout>
    <section class="services-bg pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12">
                    <div class="section-title text-center pl-40 pr-40 mb-80 wow fadeInDown animated"
                        data-animation="fadeInDown animated" data-delay=".2s">
                        <h2>Committee Members List</h2>
                    </div>
                </div>

                <div class="col-12">

                    <ul class="activity-list member-list choose-list ">

                        @foreach ($members as $key => $m)
                            <li class="wow slideInLeft d-flex justify-content-between align-items-center"
                                data-wow-duration="1s" data-wow-delay="0s">
                                <p class="fs-5">
                                    <strong>{{ $key + 1 }}. {{ $m->name }} </strong>
                                </p>
                                <p class="fs-5">{{ $m->designation }}</p>
                            </li>
                        @endforeach
                    </ul>

                </div>



            </div>
        </div>
    </section>
</x-site.layout>
