@extends('Dashboard.master')

@section('title')
     Join Program Request
@endsection

@section('css')

@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
				<span class="card-icon">
                    <i class="flaticon2-favourite text-primary"></i>
				</span>
                <h3 class="card-label">Join Program Request </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{route('trainees-programs.create')}}" class="btn btn-sm btn-light-primary er fs-6 px-8 py-4"
                   data-bs-toggle="modal"
                   data-bs-target="#kt_modal_new_target" data-toggle="modal"
                   data-target="#exampleModal">
                    <i class="la la-plus"></i> apply for training program
                </a>


                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                   style="margin-top: 13px !important">
                <thead>
                <tr>

                    <th>#</th>
                    <th>Program</th>
                    <th>Payment Status</th>
                    <th>status for Request</th>
                    <th>Reason</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($programs as $program)
                    <tr data-entry-id="{{ $program->id }}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$program->program_name}}</td>
                        <td>
                            @if ($program->program_type == 'paid')
                                @if ($program->payment_status == 'paid')
                                    <span
                                        class="label font-weight-bold label-lg label-light-primary label-inline">Paid</span>
                                @else
                                    <span class="label font-weight-bold label-lg label-light-danger label-inline">Not Paid</span>
                                @endif
                            @else
                                <span class="label font-weight-bold label-lg label-light-info label-inline">Course is Free</span>

                            @endif
                        </td>

                        <td>
                            @if ($program->status == 'rejected')
                                <span
                                    class="label font-weight-bold label-lg label-light-danger label-inline">Reject</span>
                            @elseif ($program->status == 'pending')
                                <span
                                    class="label font-weight-bold label-lg label-light-warning label-inline">Pending</span>
                            @else
                                <span
                                    class="label font-weight-bold label-lg label-light-success label-inline">Accept</span>
                            @endif
                        </td>
                        <td>{{$program->reason}}</td>
                        <td>
                            @if ($program->program_type == 'paid')
                                <div class="text-center">
                                    <a href="{{ route('payment.index') }}" class="btn btn-primary">Pay Now</a>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>

            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <form method="POST" action="{{ route("trainees-programs.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Apply to new Program</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">

                            <div class="col-lg-12">
                                <label>Program Field<span class="text-danger">*</span></label>
                                <select required name="" id="field_id" class="form-control">
                                    <option value="">Select Option</option>
                                    @foreach($fields as $field)
                                        <option value="{{ $field->id }}">{{ $field->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="form-group row pt-4">


                            <div class="col-lg-12">
                                <label>Available Program<span class="text-danger">*</span></label>
                                <select required name="program_id" id="program_id" class="form-control">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close
                        </button>
                        <button type="submit" class="btn btn-primary font-weight-bold">
                            <span class="indicator-label">Add</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection


@section('js')
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
        function deleteRows(id, reference) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1BC5BD',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/programs/' + id,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Course has been deleted.',
                                'success'
                            ).then(() => {
                                // Reload the page
                                location.reload();
                            });
                        },
                        error: function (xhr, status, error) {
                            console(error);
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting Course.',
                                'error'
                            );
                        }
                    });
                }
            });

        }
    </script>
    <script>
        $(document).ready(function () {
            $('#field_id').on('change', function () {
                var fieldId = $(this).val();

                // Clear the options in the "Available Program" select dropdown
                $('#program_id').html('<option value="">Select Option</option>');

                // Send an AJAX request to fetch the available programs based on the selected field
                $.ajax({
                    url: '/get-available-programs/' + fieldId,
                    type: 'GET',
                    success: function (response) {
                        // Add the fetched programs to the "Available Program" select dropdown
                        response.forEach(function (program) {
                            $('#program_id').append('<option value="' + program.id + '">' + program.name + '</option>');
                        });
                    },
                    error: function (xhr, status, error) {
                        // Handle the error if necessary
                    }
                });
            });
        });
    </script>

@endsection
