@extends('layouts/contentLayoutMaster')

@section('title', 'Add Event')

@section('page-style')
@endsection

@section('content')
    <section>
        <div class="row match-height">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <x-card title="Add Event">

                    <x-form id="add-age-group" method="POST" class="" :route="route('admin.add-event')">

                        <div class="col-md-12 col-12 ">
                            <x-input name="title" />
                        </div>
                        <div class="col-md-12 col-12 ">
                            <x-input name="start_date" />
                        </div>
                        <div class="col-md-12 col-12 ">
                            <x-input name="end_date" />
                        </div>
                        <div class="col-md-12 col-12 ">
                            <x-input-file :multiple="true" name="images" />
                        </div>
                        <div class="col-md-12 col-12 ">
                            <x-editor name="description" label="Event Description" />
                        </div>
                    </x-form>

                </x-card>
            </div>
        </div>
    </section>


@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            $('#start_date').flatpickr();
            $('#end_date').flatpickr();
        });
    </script>
@endsection
