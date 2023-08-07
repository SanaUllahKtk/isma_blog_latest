@extends('layouts/contentLayoutMaster')

@section('title', 'Add feed')

@section('page-style')
@endsection

@section('content')
    <section>
        <div class="row match-height">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <x-card title="Add Form">

                    <x-form id="add-age-group" method="POST" class="" :route="route('admin.storeForm')">
            
                        <div class="col-md-12 col-12 ">
                            <x-input-file name="form" />
                        </div>
                    </x-form>
 <a download="" href="{{asset($form->path)}}" >Old Form</a>
                </x-card>
            </div>
        </div>
    </section>


@endsection
@section('page-script')
@endsection
