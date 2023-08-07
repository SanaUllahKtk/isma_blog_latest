<x-site.layout>
    <section class="choose-area pt-120 pb-120 p-relative" style="background:#f5f8fa;">

        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="choose-wrap">
                        <div class="section-title w-title left-align mb-35 wow fadeInDown animated"
                            data-animation="fadeInDown animated" data-delay=".2s">
                            <h2>{{ $event->name }}</h2>
                        </div>
                        <div class="choose-content wow fadeInUp animated" data-animation="fadeInDown animated"
                            data-delay=".2s">
                            {!! $event->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-site.layout>
