<x-site.layout>
    <x-slot name="title">
        Events
    </x-slot>
    <x-slot name="styles">
        <link rel="stylesheet" href="/site/css/event.css">
    </x-slot>
    <section id="contact" class="contact-area contact-bg pt-5 pb-120 p-relative fix" style="background:#f5f8fa;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8">
                    <div class="section-title text-center mb-80 wow fadeInDown animated"
                        data-animation="fadeInDown animated" data-delay=".2s">

                        <h2>Event Lists</h2>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-12">
                    <div id="app"></div>

                </div>
            </div>

        </div>

    </section>

    <x-slot name="scripts">
        <script src="/site/js/event.js"></script>

        <script>
            function fetchEvents(date) {
                console.log(date);
                $('#eventData').html(`
                   <div class="d-flex w-100 h-100 justify-content-center align-items-center">
                    <i style="color: white;" class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                    </div>
                `);


                rebound({
                    url: '{{ route('event-by-date') }}',
                    method: 'GET',
                    data: {
                        date: date
                    },
                    processData: true,
                    block: '#app',
                    notification: false,
                    successCallback: function(response) {
                        console.log(response);

                        if (response.length == 0) {
                            $('#eventData').html(`
                                <div class="d-flex w-100 h-100 justify-content-center align-items-center">
                                    <h3 style="color: white;">No Event Found</h3>
                                </div>
                            `);
                            return;
                        }



                        let html = '<ul class="list-group">';
                        response.forEach(event => {
                            html += `
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <h4>
                                            <a href="/event/${event.slug}">${event.name}</a>
                                            </h4>
                                        <span><strong>Start Date</strong> ${event.start_date}</span><br>
                                        <span><strong>End Date</strong> ${event.end_date}</span>
                                    </div>
                                </div>
                            </li>
                            `;
                        });
                        html += '</ul>';
                        $('#eventData').html(html);
                    }
                })
            }
        </script>
    </x-slot>

</x-site.layout>
