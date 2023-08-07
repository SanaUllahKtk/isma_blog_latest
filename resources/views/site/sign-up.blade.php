<x-site.layout>
  <style>
    .download-link {
      position: absolute;
      right: 1rem;
      bottom: 1rem;
    }
    .is-invalid {
      border-color: #dc3545 !important;
    }

    select {
      width: 100%;
      border: none;
      background: #fff;
      padding: 20px 40px;
      transition: 0.3s;
      border: 1px solid #dfdfdf;
      font-weight: normal;
      color: #687068;
      font-style: normal;
    }
  </style>
  <section
    class="choose-area pt-5 pb-120 p-relative"
    style="background: #f5f8fa"
  >
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-8">
          <div class="choose-wrap">
            <div
              class="section-title w-title left-align mb-35 wow fadeInDown animated"
              data-animation="fadeInDown animated"
              data-delay=".2s"
            >
              <h2>Sign Up</h2>
            </div>
            <div
              class="choose-content wow fadeInUp animated"
              data-animation="fadeInDown animated"
              data-delay=".2s"
            >
              <div class="card p-4">
                <form
                  id="sign-up-form"
                  class="contact-form wow fadeInUp animated"
                  data-animation="fadeInDown animated"
                  data-delay=".2s"
                >
                  <div id="step-1" class="row pt-5">
                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Username</label>
                        <input
                          required
                          type="text"
                          name="name"
                          placeholder="Username"
                        />
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>email</label>
                        <input
                          required
                          type="email"
                          name="email"
                          placeholder="email"
                        />
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Mobile Number</label>
                        <input
                          required
                          type="number"
                          name="number"
                          placeholder="Mobile Number"
                        />
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Password</label>
                        <input
                          required
                          type="password"
                          name="password"
                          placeholder="Password"
                        />
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Confirm Password</label>
                        <input
                          required
                          type="password"
                          name="password_confirmation"
                          placeholder="Confirm Password"
                        />
                      </div>
                    </div>

                    <div class="col-md-12">
                      <button
                        type="button"
                        class="btn btn-primary"
                        id="next-btn"
                      >
                        Next
                      </button>
                    </div>
                  </div>
                  <!--<div class="col-lg-12">-->
                  <!--    <div class="contact-field p-relative  mb-40">-->
                  <!--<label ></label>      
                                          <input required type="file" accept="application/pdf,image/*,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"-->
                  <!--            name="form" placeholder="Upload From">-->
                  <!--    </div>-->

                  <!--    <small class="download-link">-->
                  <!--        <a href="{{ asset($form->path) }}" download="">Download From</a>-->
                  <!--    </small>-->
                  <!--</div>-->
                  <div id="step-2" style="display: none" class="row">
                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Company Name</label>
                        <input
                          required
                          type="text"
                          name="company_name"
                          placeholder="Company Name"
                        />
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Company Address</label>
                        <input
                          required
                          type="text"
                          name="company_address"
                          placeholder="Company Address"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Company Logo</label>
                        <input
                          required
                          type="file"
                          accept="image/*"
                          name="company_logo"
                          placeholder="Company logo"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>State</label>
                        <input
                          required
                          type="text"
                          name="state"
                          placeholder="State"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>City</label>
                        <input
                          required
                          type="text"
                          name="city"
                          placeholder="City"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Pin Code</label>
                        <input
                          required
                          type="number"
                          name="pin_code"
                          placeholder="Pin Code"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Type of company</label>
                        <input
                          required
                          type="text"
                          name="type_of_company"
                          placeholder="Type of company"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Pan No</label>
                        <input
                          required
                          type="text"
                          name="pan_no"
                          placeholder="Pan No"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Pan Document</label>
                        <input
                          required
                          type="file"
                          accept="image/*"
                          name="pan_document"
                          placeholder="Pan Document"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>GST No</label>
                        <input
                          required
                          type="text"
                          name="gst_no"
                          placeholder="GST No"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Name Of Owner</label>
                        <input
                          required
                          type="text"
                          name="name_of_owner"
                          placeholder="Name Of Owner"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Turnover in Cr (Rs)</label>
                        <input
                          required
                          type="number"
                          name="turnover_in_cr"
                          placeholder="Turnover in Cr (Rs)"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Office Phone number</label>
                        <input
                          required
                          type="number"
                          name="office_phone_number"
                          placeholder="Office Phone number"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Mobile Number</label>
                        <input
                          required
                          type="number"
                          name="mobile_number"
                          placeholder="Mobile Number"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Company email</label>
                        <input
                          required
                          type="email"
                          name="company_email"
                          placeholder="Company email"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Official website link</label>
                        <input
                          required
                          type="text"
                          name="official_website_link"
                          placeholder="Official website link"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Year of establishment</label>
                        <input
                          required
                          type="number"
                          name="year_of_establishment"
                          placeholder="Year of establishment"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>No of locations</label>
                        <input
                          required
                          type="number"
                          name="no_of_locations"
                          placeholder="No of locations"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Total employes</label>
                        <input
                          required
                          type="number"
                          name="total_employes"
                          placeholder="Total employes"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Quality Certifications: ISO, QS, TS, IATF.</label>
                        <input
                          required
                          type="file"
                          name="quality_certifications"
                          placeholder="Quality Certifications: ISO, QS, TS, IATF."
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Any other Accreditation </label>
                        <input
                          required
                          type="text"
                          name="any_other_accreditation"
                          placeholder="Any other Accreditation "
                        />
                      </div>
                    </div>

                    <!-- 
Major markets
Manufacturing scope/Range
Product category
Are you currently using any spring calculation software Yes/No
26.	If Yes – which software -->

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Major markets</label>
                        <input
                          required
                          type="text"
                          name="major_markets"
                          placeholder="Major markets"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Manufacturing scope/Range</label>
                        <input
                          required
                          type="text"
                          name="manufacturing_scope"
                          placeholder="Manufacturing scope/Range"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>Product category</label>
                        <input
                          required
                          type="text"
                          name="product_category"
                          placeholder="Product category"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label for="">
                            Are you currently using any spring calculation
                            software
                        </label>
                        <select
                          name="are_you_currently_using_any_spring_calculation_software"
                          id="using_software"
                          required
                        >
                          <option selected disabled>
                            Are you currently using any spring calculation
                            software
                          </option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field p-relative mb-40">
                        <label>If Yes – which software</label>
                        <input
                          required
                          type="text"
                          name="if_yes_which_software"
                          placeholder="If Yes – which software"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="text-center">
                        <button type="submit" class="btn">Register</button>
                      </div>
                      <small>
                        Already have an account ?
                        <a href="/login">Login</a></small
                      >
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
          timeout: 10000,
      });
      $('#sign-up-form').submit(function (e) {
          e.preventDefault();
          rebound({
              form: $(this),
              url: '{{ route('register') }}',
              succssCallback: function (data) {
                  location.href = '/';
              }
          })
      });


      $('#next-btn').click(function (e) {
          e.preventDefault();
          //    validate all fields in step-1
          $('#step-1').find('input').each(function (index, element) {
              if ($(element).val() == '') {
                  $(element).addClass('is-invalid');
              } else {
                  $(element).removeClass('is-invalid');
              }
          });
          if ($('#step-1').find('.is-invalid').length == 0) {
              $('#step-1').hide();
              $('#step-2').show();
          }


          $('#step-1').find('input').on('keyup', function () {
              if ($(this).val() != '') {
                  $(this).removeClass('is-invalid');
              }
          });

          $('#using_software').change(function (e) {
              e.preventDefault();
              if($(this).val() == 'yes'){
                  $('input[name="if_yes_which_software"]').parent().parent().show();
                  $('input[name="if_yes_which_software"]').attr('required', true);
              }else{
                  $('input[name="if_yes_which_software"]').parent().parent().hide();
                  $('input[name="if_yes_which_software"]').attr('required', false);
              }


          });


      });
    </script>
  </x-slot>
</x-site.layout>
