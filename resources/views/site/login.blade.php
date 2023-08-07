<x-site.layout>
    <section class="choose-area pt-5 pb-120 p-relative" style="background:#f5f8fa;">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="choose-wrap">
                        <div class="section-title w-title left-align mb-35 wow fadeInDown animated" data-animation="fadeInDown animated" data-delay=".2s">
                            <h2>Login</h2>
                        </div>
                        <div class="choose-content wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                            <div class="card p-4">
                                <form id="login-form" class="contact-form wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                                    <div class="row pt-5">
                                        <div class="col-lg-12">
                                            <div class="contact-field p-relative  mb-40">
                                                <input type="email" name="email" placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="contact-field p-relative  mb-40">
                                                <input type="password" name="password" placeholder="Password">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <button type="submit" class="btn">Login</button>
                                            </div>
                                            <small> Dont have an account ? <a href="/register">Sign Up</a></small>
                                            or <a href="{{route('forget-password')}}">
                                                Forget Password ?
                                            </a>
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
        Notiflix.Notify.init({
    zindex: 99999999,
    position: "right-bottom",
    cssAnimation: true,
    cssAnimationDuration: 400,
    cssAnimationStyle: "zoom",
    timeout:10000,
});
            $('#login-form').submit(function(e) {
                e.preventDefault();
                rebound({
                    form: $(this)
                    , url: '{{ route("login") }}'
                    , successCallback: function(data) {
                        location.href = '/';
                    },
                    // errorCallback:function(res){
                    //     n
                    // }
                })
            });

        </script>
    </x-slot>
</x-site.layout>
