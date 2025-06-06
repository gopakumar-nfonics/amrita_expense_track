@extends('layouts.admin')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Non-Invoice Payment Listing
                </h1>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('noninvoicepayment.create') }}" class="btn btn-sm btn-primary">
                    Add
                </a>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card mb-5 mb-xl-8">
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <div class="overlay" id="loaderOverlay">
                            <div class="loader"></div>
                        </div>
                        
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                            id="budgettable">
                            <thead>
                                <tr class="fw-bold">
                                    <th class="min-w-150px">Reference ID</th>
                                    <th class="min-w-200px">Title</th>
                                    <th class="min-w-150px">Category</th>
                                    <th class="min-w-150px">Program</th>
                                    <th class="min-w-150px">Amount</th>
                                    <th class="min-w-150px text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $key => $payment)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <div class="text-dark fw-bold text-hover-primary fs-6">
                                                    #{{$payment->reference_id }}
                                                </div>
                                                <div class="text-gray-400 fw-semibold fs-9">
                                                    @if($payment->payment_status == "pending")
                                                    <span class="badge badge-light-info fs-8">
                                                        <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                            <i
                                                                class="fa-regular fa-circle-dot color-blue fs-8 me-1 "></i>
                                                        </span>
                                                        Payment Pending
                                                    </span>
                                                    @elseif($payment->payment_status == "completed")
                                                    <span class="badge badge-light-success fs-8">
                                                        <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                            <i class="fa-solid fa-check light-green fs-8 me-1 "></i>
                                                        </span>
                                                        Payment Completed
                                                    </span>
                                                    
                                                    <div>
                                                        <span class="text-muted fw-semibold text-muted d-block fs-8">
                                                            Date : {{ \Carbon\Carbon::parse($payment->transaction_date)->format('d-M-Y') }}
                                                        </span>
                                                        @if($payment->utr_number)
                                                            <span class="text-muted fw-semibold text-muted d-block fs-8">
                                                                UTR : {{$payment->utr_number}}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <div class="text-dark text-hover-primary fs-6 fw-bold ">
                                                    {{$payment->title}}
                                                </div>
                                                
                                                <div class="d-flex justify-content-start flex-column">
                                                    <div class="text-dark fw-bold text-muted text-hover-primary fs-8">
                                                        Year : {{ $payment->year->year}}
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        @if($payment->remarks)
                                            <div class="d-flex align-items-center">
                                                <div class="fw-400 d-block fs-6">
                                                    <div class="text-dark fw-bold text-muted text-hover-primary fs-8">
                                                        {{$payment->remarks}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                @if($payment->category)
                                                @if($payment->category->parent){{$payment->category->parent->category_name}}@else{{$payment->category->category_name}}@endif
                                                @if($payment->category->parent) </br> <span
                                                    class="d-flex justify-content-start text-muted fs-7">
                                                    {{$payment->category->category_name}}</span>
                                                @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <span class="d-flex justify-content-start fw-semibold fs-7">
                                                    {{$payment->stream->stream_name}}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <span class="fs-2 fw-semibold text-gray-500 align-self-start me-0">
                                                    &#x20b9;
                                                </span>
                                                <span class="total-cost-span fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2">
                                                    {{ number_format($payment->amount, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            Actions <i class="fa-solid fa-angle-down"></i>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
        									<div class="menu-item px-3">
												<a href="{{route('noninvoicepayment.edit',$payment->id)}}" class="menu-link px-3">
                                                    Edit
                                                </a>
											</div>				
											<div class="menu-item px-3">
												<a href="javascript:void(0)" onclick="removePayment('{{$payment->id}}')" class="menu-link px-3" data-kt-customer-table-filter="delete_row">
                                                    Delete
                                                </a>
											</div>					
										</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">No data found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pageScripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {

        $('#budgettable').DataTable({
            "iDisplayLength": 10,
            "searching": true,
            "ordering": false
        });
    });
</script>

<script>
	function removePayment(paymentId) {
		swal({
			title: "Are you sure?",
			text: "You want to remove this Non-Invoice Payment",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: "/noninvoicepayment/" + paymentId,
					type: 'DELETE',
					data: {
						_token: '{{ csrf_token() }}'
					},
					success: function(response) {
						if (response.success) {
							swal(response.success, {
								icon: "success",
								buttons: false,
							});
							setTimeout(() => {
								location.reload();
							}, 1000);
						} else {
							swal(response.error || 'Something went wrong.', {
								icon: "warning",
								buttons: false,
							});
							setTimeout(() => {
								location.reload();
							}, 1000);
						}
					},
					error: function(xhr) {
						swal('Error: Something went wrong.', {
							icon: "error",
						}).then(() => {
							location.reload();
						});
					}
				});
			}
		});
	}
</script>

@endsection