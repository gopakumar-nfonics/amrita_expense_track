@extends('modules.Staff.layouts.staff')

@section('content')
<style>
    table tr:first-child td:nth-child(5) button {
        display: none;
    }
</style>
<div class="app-main flex-column flex-row-fluid" id="kt_app_main" data-select2-id="select2-data-kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid" data-select2-id="select2-data-122-9irx">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Submit Travel Expense</h1>
                    <!--end::Title-->

                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-lg-row">
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body p-12">
                                <div class="overlay" id="loaderOverlay">
                                    <div class="loader"></div>
                                </div>
                                <!--begin::Form-->
                                <form id="kt_invoice_form" method="POST" action="{{ route('travel.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <!-- First Row: From Date and To Date -->
                                    <div class="row gx-10 mb-5">
                                        <div class="col-lg-6">
                                            <label class="required form-label">From Date</label>
                                            <input type="date" name="from_date" class="form-control @error('from_date') is-invalid @enderror"
                                                value="{{ old('from_date') }}">
                                            @error('from_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="required form-label">To Date</label>
                                            <input type="date" name="to_date" class="form-control @error('to_date') is-invalid @enderror"
                                                value="{{ old('to_date') }}">
                                            @error('to_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <!-- Second Row: City and Amount -->
                                    <div class="row gx-10 mb-5">
                                        <div class="col-lg-6">
                                            <label class="required form-label">City</label>
                                            <select name="city" class="form-select @error('city') is-invalid @enderror">
                                                <option value="">Select a city</option>
                                                <option value="Kochi" {{ old('city') == 'Kochi' ? 'selected' : '' }}>Kochi</option>
                                                <option value="Trivandrum" {{ old('city') == 'Trivandrum' ? 'selected' : '' }}>Trivandrum</option>
                                                <option value="Calicut" {{ old('city') == 'Calicut' ? 'selected' : '' }}>Calicut</option>
                                                <option value="Thrissur" {{ old('city') == 'Thrissur' ? 'selected' : '' }}>Thrissur</option>
                                            </select>
                                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="required form-label">Amount</label>
                                            <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror"
                                                value="{{ old('amount') }}" placeholder="Enter amount">
                                            @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <!-- Third Row: Description -->
                                    <div class="mb-5">
                                        <label class="required form-label">Description</label>
                                        <textarea id="summernote" name="description"
                                            class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>

                                <!--end::Form-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Sidebar-->

                    <!--end::Sidebar-->
                </div>
                <!--end::Layout-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->

</div>
@endsection
@section('pageScripts')

<!-- Summernote CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 125, // Set the editor height
            placeholder: 'Add description...',
            tabsize: 2,
            toolbar: [
                // [groupName, [list of buttons]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['superscript', 'subscript']],
                ['para', ['ul', 'ol']],
            ]
        });

    });
</script>

@endsection