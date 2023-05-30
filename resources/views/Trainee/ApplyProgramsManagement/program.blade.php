@extends('Dashboard.master')

@section('title')
    Accepted Program
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
                <h3 class="card-label">Accepted Program </h3>
            </div>
            <div class="card-toolbar">


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
                    <th>Image</th>
                    <th>Program Name</th>
                    <th>Advisor</th>
                    <th>Hours</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Number</th>
                    <th>Duration</th>
                    <th>Level</th>
                    <th>Language</th>
                    <th>Field</th>
                    <th>Program Description</th>
                </tr>
                </thead>
                <tbody>
                @if(!$programs->isEmpty())
                    @foreach($programs as $program)
                        <tr data-entry-id="{{ $program->id }}">
                            <td>{{$loop->iteration}}</td>
                            <td>
                                @if ($program->program->image)
                                    <img class="pr-4" src="{{ asset('images/' . $program->program->image) }}"
                                         height="50px"
                                         width="50px"
                                         alt="Logo">
                                @else
                                    <img class="pr-4" src="{{asset('admin/assets/media/users/blank2.jpg')}}"
                                         height="50px"
                                         width="50px"
                                         alt="Logo">
                                @endif
                            </td>
                            <td>{{ $program->program->name }}</td>
                            <td>
                                @if ($program->program->advisor)
                                    <a href="{{ route('advisors.show', $program->program->advisor->id) }}">{{ $program->program->advisor->first_name . " " . $program->program->advisor->last_name }}</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $program->program->hours }}</td>

                                @if($program->program->start_date <= now() && $program->program->end_date > now())
                            <td data-field="Status" data-autohide-disabled="false" aria-label="3"
                                class="datatable-cell"><span style="width: 108px;"><span
                                        class="label font-weight-bold label-lg  label-light-primary label-inline">Available</span></span>
                            </td>
                            @elseif($program->program->start_date >= now())
                                <td data-field="Status" data-autohide-disabled="false" aria-label="3"
                                    class="datatable-cell"><span style="width: 108px;"><span
                                            class="label font-weight-bold label-lg  label-light-danger label-inline">Not Available Yet</span></span>
                                </td>

                            @else
                                <td data-field="Status" data-autohide-disabled="false" aria-label="3"
                                    class="datatable-cell"><span style="width: 108px;"><span
                                            class="label font-weight-bold label-lg  label-light-danger label-inline">Finished program</span></span>
                                </td>
                            @endif
                            <td>{{ $program->program->start_date }}</td>
                            <td>{{ $program->program->end_date }}</td>
                            <td>{{ $program->program->type }}</td>
                            <td>    @if($program->program->type == 'free')
                                    No fees
                                @else
                                    {{ $program->program->price }}
                                @endif
                            </td>
                            <td>{{ $program->program->number }}</td>
                            <td>{{ $program->program->duration }}</td>
                            <td>{{ $program->program->level }}</td>
                            <td>{{ $program->program->language }}</td>
                            <td>{{ $program->program->field->name ?? 'N/A' }}</td>
                            <td>{{ $program->program->description ?? 'No Description' }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>

            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <form method="POST" action="{{ route("addmoney.stripe") }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pay To Program</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">

                            <div class="mb-3">
                                <label class='control-label'>Card Number</label>
                                <input autocomplete='off' class='form-control card-number' size='20' type='text'
                                       name="card_no">
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label class='control-label'>CVV</label>
                                    <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311'
                                           size='4' type='text' name="cvvNumber">
                                </div>
                                <div class="col-auto">
                                    <label class='control-label'>Expiration</label>
                                    <input class='form-control card-expiry-month' placeholder='MM' size='4' type='text'
                                           name="ccExpiryMonth">
                                </div>
                                <div class="col-auto">
                                    <label class='control-label'>Year</label>
                                    <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'
                                           name="ccExpiryYear">
                                    <input class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                           type='hidden' name="amount" value="300">
                                </div>
                            </div>

                            <div class="mb-3" style="padding-top:20px;">
                                <h5 class='total'>Total:<span class='amount'>$10</span></h5>
                            </div>


                            <div class="mb-3">
                                <div class='alert-danger alert' style="display:none;">
                                    Please correct the errors and try again.
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                                Close
                            </button>
                            <button class='btn btn-primary font-weight-bold' type='submit'>
                                <span class="indicator-label">Pay »</span>

                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection


@section('js')

    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="https://js.stripe.com/v3/"></script>

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
