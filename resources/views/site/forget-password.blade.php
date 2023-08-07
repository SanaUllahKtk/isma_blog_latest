<x-site.layout>

    <x-slot name="styles">
    </x-slot>
    <section id="send-otp" class="choose-area pt-5 pb-120 p-relative" style="background:#f5f8fa;">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="choose-wrap">
                        <div class="section-title w-title left-align mb-35 wow fadeInDown animated" data-animation="fadeInDown animated" data-delay=".2s">
                            <h2>Reset Password</h2>
                        </div>
                        <div class="choose-content wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                            <div class="card p-4">
                                <form id="send-otp-form" class="contact-form wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                                    <div class="row pt-5">
                                        <div class="col-lg-12">
                                            <div class="contact-field p-relative  mb-40">
                                                <input type="email" name="email" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <button type="submit" class="btn">Send OTP</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="confirm-otp" class="choose-area pt-5 pb-120 p-relative d-none" style="background:#f5f8fa;">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="choose-wrap">
                        <div class="section-title w-title left-align mb-35 wow fadeInDown animated" data-animation="fadeInDown animated" data-delay=".2s">
                            <h2>Reset Password</h2>
                        </div>
                        <div class="choose-content wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                            <div class="card p-4">
                                <form id="confirm-otp-form" class="contact-form wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                                    <div class="row pt-5">
                                        <div class="col-lg-12">
                                            <div class="contact-field p-relative  mb-40">
                                                <input type="text" maxlength="6" minlength="6" name="otp" placeholder="Otp">
                                            </div>

                                            <input type="email" name="email" hidden>

                                            <div class="contact-field p-relative  mb-40">
                                                <input type="password" name="password" placeholder="password">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <button type="submit" class="btn">Reset Password</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-slot name="scripts">
        <script>
            $('#send-otp-form').submit(function(e) {
                e.preventDefault();
                const email = $(this).find('input[name="email"]').val();
                $('#confirm-otp-form').find('input[name="email"]').val(email);
                rebound({
                    form: $(this)
                    , url: '{{ route("send-otp") }}'
                    , successCallback: function(data) {
                        $('#send-otp').addClass('d-none');
                        $('#confirm-otp').removeClass('d-none');
                    }
                })
            });


            $('#confirm-otp-form').submit(function(e) {
                e.preventDefault();
                rebound({
                    form: $(this)
                    , url: '{{ route("confirm-otp") }}'
                    , successCallback: function(data) {
                        $('#send-otp').addClass('d-none');
                        $('#confirm-otp').removeClass('d-none');
                    }
                })
            });

        </script>
    </x-slot>
</x-site.layout>
