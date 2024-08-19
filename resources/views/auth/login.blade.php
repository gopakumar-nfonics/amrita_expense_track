@extends('layouts.login')

@section('content')
		<!--begin::Theme mode setup on page load-->
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root kt_app_root-login" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>body { background-image: url("{{ url('/') }}/assets/media/auth/bg4.jpg");background-size: cover; background-repeat: no-repeat; } </style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid flex-lg-row">
			
				<!--begin::Body-->
				<div class="d-flex flex-center w-lg-100 px-10">
					<!--begin::Card-->
					<div class="card rounded-3 w-md-500px login-div px-10 py-5">
						<!--begin::Card body-->
						<div class="card-body p-10">
							<!--begin::Form-->
							<form method="post" action="{{ route('login') }}" class="form w-100" id="kt_sign_in_form">
                            @csrf
								<!--begin::Heading-->
								<div class="text-center mb-15">
									<!--begin::Title-->
									<img alt="Logo" src="{{ url('/') }}/assets/media/logos/logo.svg" />
									<h6 class="text-white fw-normal mt-2 pt-3 br-t-3">EXPENSE TRACKER SYSTEM</h6>
								
									<!--end::Title-->
									<!--begin::Subtitle-->
									

									@if ($errors->has('email'))
        <strong style="color: #ff0000;font-size: 1.2em;">{{ $errors->first('email') }}</strong>
        @endif
									
									<!--end::Subtitle=-->
								</div>
								<!--begin::Heading-->
								
								<!--begin::Input group=-->
								<div class="fv-row mb-8">
									<!--begin::Email-->
									<input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
									
									<!--end::Email-->
								</div>
								<!--end::Input group=-->
								<div class="fv-row mb-3">
									<!--begin::Password-->
									<input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
									<!--end::Password-->
								</div>
								<!--end::Input group=-->
							

									<!--begin::Wrapper-->
									<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mt-5">
									<div></div>
									<!--begin::Link-->
									<a  href="{{ route('password.request') }}" class="link-secondary"><u>Forgot Password ?</u></a>
									<!--end::Link-->
								</div>
								<!--end::Wrapper-->

								<!--begin::Submit button-->
								<div class="d-grid mt-10 mb-5">
									<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
										<!--begin::Indicator label-->
										<span class="indicator-label">Sign In</span>
										<!--end::Indicator label-->
										<!--begin::Indicator progress-->
										<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										<!--end::Indicator progress-->
									</button>
								</div>
								<!--end::Submit button-->

								
								
							</form>
							<!--end::Form-->
							<footer class="page-copyright-inverse footer-label">  © 2024. Amrita Vishwa Vidyapeetham. All Rights Reserved.         					</footer>

						</div>
						<!--end::Card body-->
					</div>
					<!--end::Card-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		
        @endsection	