@extends('Dashboard.master')

@section('title')
    dashboard
@endsection

@section('css')

@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <div class="card-title align-items-start flex-column">
                    <h3 class="card-label font-weight-bolder text-dark">Change Password</h3>
                    <span class="text-muted font-weight-bold font-size-sm mt-1">Change your account password</span>
                </div>
                <div class="card-toolbar" style="margin-left: 311px;">
                    <button type="button" class="btn btn-primary mr-2" onclick="submitForm()">Save Changes</button>
                    <button type="reset" class="btn btn-secondary" onclick="resetForm()">Cancel</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Form-->
            <form id="passwordForm" class="form" action="{{route('updatePassword',\Illuminate\Support\Facades\Auth::user()->id)}}"
                  method="POST">
            @csrf
                <!--end::Alert-->
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-alert">Current Password</label>
                    <div class="col-lg-9 col-xl-6">
                        <input name="oldPassword" type="password" class="form-control form-control-lg form-control-solid mb-2" value=""
                               placeholder="Current password" required>
                        <a href="{{route('password.request')}}" class="text-sm font-weight-bold">Forgot password ?</a>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-alert">New Password</label>
                    <div class="col-lg-9 col-xl-6">
                        <input id="password" type="password"
                               class="form-control form-control-lg form-control-solid"
                               name="password"
                                autocomplete="new-password" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-alert">Verify Password</label>
                    <div class="col-lg-9 col-xl-6">
                        <input id="password_confirmation" type="password"
                               class="form-control form-control-lg form-control-solid"
                               name="password_confirmation"  autocomplete="new-password" required>
                    </div>

                </div>

            </form>
            <!--end::Form-->

        </div>
    </div>

@endsection


@section('js')

    <script>
        function submitForm() {
            // Get the form element
            var form = document.getElementById('passwordForm');

            // Submit the form
            form.submit();
        }
    </script>
    <script>
        function resetForm() {
            document.getElementById("myForm").reset();
        }
    </script>
@endsection
