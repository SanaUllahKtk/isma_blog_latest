@extends('layouts/contentLayoutMaster')

@section('title', 'Add blog')

@section('page-style')
@endsection

@section('content')
    <section>
        <div class="row match-height">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <x-card title="Add Blog">

                    <x-form id="add-age-group" method="POST" class="" :route="auth()->user()->isAdmin === '1'
                        ? route('admin.blog.store')
                        : route('dashboard.blog.store')">

                        <div class="col-md-12 col-12 ">
                            <x-input name="title" />
                        </div>
                        <div class="col-md-12 col-12 ">
                            <x-input-file name="image" />
                        </div>
                        <div class="col-md-12 col-12 ">
                            <x-editor name="content" label="Blog Body" />
                        </div>
                    </x-form>

                </x-card>
            </div>
        </div>
    </section>


@endsection
@section('page-script')
@endsection
