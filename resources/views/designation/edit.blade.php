@extends('layouts.admin')

@section('content')
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">

                    <!--begin::Basic info-->
                    <div class="card mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                            data-bs-target="#kt_account_profile_details" aria-expanded="true"
                            aria-controls="kt_account_profile_details">
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Edit Designation</h3>
                            </div>
                        </div>
                        <div id="kt_account_settings_profile_details" class="collapse show">
                            <form id="kt_account_profile_details_form" class="form" method="POST"
                                action="{{ route('designation.update', $designations->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body border-top p-9">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Title</label>

                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="title"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 @error('title') is-invalid @enderror"
                                                placeholder="Title" value="{{ old('title', $designations->title) }}" />
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                            Code
                                        </label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="code"
                                                class="form-control form-control-lg form-control-solid @error('code') is-invalid @enderror"
                                                placeholder="Code" value="{{ old('code', $designations->code) }}" />
                                            @error('code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                            Travel Mode
                                        </label>
                                        <div class="col-lg-8 fv-row">
                                            <select
                                                class="form-control form-control-lg form-control-solid @error('travel_mode') is-invalid @enderror"
                                                name="travel_mode[]" multiple>
                                                @foreach ($travelModes as $parent)
                                                    @if ($parent->children->count())
                                                        @foreach ($parent->children as $child)
                                                            <option value="{{ $child->id }}"
                                                                {{ in_array($child->id, old('travel_mode', $designations->travelModes->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                                {{ $parent->name }} : {{ $child->name }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option value="{{ $parent->id }}"
                                                            {{ in_array($parent->id, old('travel_mode', $designations->travelModes->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                            {{ $parent->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('travel_mode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary"
                                        id="kt_account_profile_details_submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
