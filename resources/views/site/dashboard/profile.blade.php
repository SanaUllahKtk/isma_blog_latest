@extends('layouts/user_layout')

@section('title', 'Dashboard')
@section('page-style')

@endsection

@section('content')
<section>
    <div class="row match-height">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="fw-bolder border-bottom pb-50 mb-1">
                        {{ ucfirst($user->name) }}
                    </h4>
                    <div class="info-container">
                        <ul style="display:grid;" class="list-unstyled">
                            <li style=" grid-column-start: 1;
  grid-column-end: 3;" class="mb-75">
                                <span class="fw-bolder mr-25">Name:</span>
                                <span>{{ $user->name }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Phone:</span>
                                <span>{{ $user->phone ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Company name:</span>
                                <span>{{ $user->company_name ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Company Address:</span>
                                <span>{{ $user->company_address ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">City:</span>
                                <span>{{ $data['city'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">state:</span>
                                <span>{{ $data['state'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Gst No:</span>
                                <span>{{ $data['gst_no'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Pan No:</span>
                                <span>{{ $data['pan_no'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Pin Code:</span>
                                <span>{{ $data['pin_code'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Company Logo No:</span>
                                <div class="avatar">
                                    <img height="40" width="40" class="rounded" src="{{asset($data['company_logo'] ?? "")}}" </div>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Pan Document:</span>
                                <span>
                                    <a href="{{asset($data['pan_document']??'')}}">
                                        @if($data['pan_document']??false)
                                        pan
                                        @else
                                        NA
                                        @endif
                                    </a>
                                </span>
                            </li>

                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Company email:</span>
                                <span>{{ $data['company_email'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Mazor Markets:</span>
                                <span>{{ $data['major_markets'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Mobile No:</span>
                                <span>{{ $data['mobile_number'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Name of owner:</span>
                                <span>{{ $data['name_of_owner'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Gst No:</span>
                                <span>{{ $data['gst_no'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Total Employee:</span>
                                <span>{{ $data['total_employes'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Turnover in cr.:</span>
                                <span>{{ $data['turnover_in_cr'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Number of location:</span>
                                <span>{{ $data['no_of_locations'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Type of company:</span>
                                <span>{{ $data['type_of_company'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Product category:</span>
                                <span>{{ $data['product_category'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Manufacturing scope:</span>
                                <span>{{ $data['manufacturing_scope'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Office phone No:</span>
                                <span>{{ $data['office_phone_number'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Gst No:</span>
                                <span>{{ $data['gst_no'] ?? 'N/A' }}</span>
                            </li>


                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Official Link:</span>
                                <a href="{{ $data['official_website_link'] ?? '' }}">
                                    {{ $data['official_website_link'] ?? 'N/A' }}
                                </a>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Year of establishment:</span>
                                <span>{{ $data['year_of_establishment'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Quality sertifications:</span>
                                <a href="{{ asset($data['quality_certifications'] ?? '') }}">
                                    @if($data['quality_certifications']??false)
                                    certifications
                                    @else
                                    NA
                                    @endif
                                </a>

                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Any other accreditation</span>
                                <span>{{ $data['any_other_accreditation'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Gst No:</span>
                                <span>{{ $data['gst_no'] ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder mr-25">Uses ISMA software:</span>
                                <span>
                                    @if(($data['are_you_currently_using_any_spring_calculation_software'] ??'') !== 'no')
                                    yes
                                    @else
                                    no
                                    @endif
                                </span>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection