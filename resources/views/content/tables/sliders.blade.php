@extends('layouts/contentLayoutMaster')

@section('title', 'Sliders')
@section('page-style')
@endsection

@section('content')

    <section>
        <div class="row match-height">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <x-card>
                    {!! $dataTable->table() !!}
                </x-card>
            </div>
        </div>
    </section>


    <x-side-modal title="Add Sliders" id="add-Sliders-modal">
        <x-form id="add-Sliders" method="POST" class="" :route="route('admin.slider.store')">

            <div class="col-md-12 col-12 ">
                <x-input-file name="image" />
            </div>
        </x-form>
    </x-side-modal>
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            $('#slider-table_wrapper .dt-buttons').append(
                `<button type="button" data-show="add-Sliders-modal" class="btn btn-flat-success waves-effect float-md-right">Add</button>`
            );
            $(document).on('click', '[data-show]', function() {
                const modal = $(this).data('show');
                $(`#${modal}`).modal('show');
            });
        });

        function setValue(data, modal) {
            $(`${modal} #id`).val(data.id);
            $(`${modal} #name`).val(data.name);
            $(modal).modal('show');
        }
    </script>
@endsection
