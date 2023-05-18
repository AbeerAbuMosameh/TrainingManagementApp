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
				<span class="card-icon">
                    <i class="flaticon2-favourite text-primary"></i>
				</span>
                <h3 class="card-label">Trainee Data</h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                <thead>
                <tr>

                    <th>#</th>
                    <th>Name</th>
                    <th>email</th>
                    <th>phone</th>
                    <th>education</th>
                    <th>gpa</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>payment</th>
                    <th>Language</th>
                    <th>Actions</th>
                    <th>Documents</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($trainees as $trainee)
                    <tr data-entry-id="{{ $trainee->id }}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$trainee->first_name}} {{$trainee->last_name}}</td>
                        <td>{{$trainee->email}}</td>
                        <td>{{$trainee->phone}}</td>
                        <td>{{$trainee->education}}</td>
                        <td>{{$trainee->gpa}}</td>
                        <td>{{$trainee->address}}</td>
                        <td>{{$trainee->city}}</td>


                        @if($trainee->is_approved == 1 )
                            <td data-field="Status" data-autohide-disabled="false" aria-label="3"
                                class="datatable-cell"><span style="width: 108px;"><span
                                        class="label font-weight-bold label-lg  label-light-primary label-inline">Approved</span></span>
                            </td>
                        @else
                            <td data-field="Status" data-autohide-disabled="false" aria-label="2"
                                class="datatable-cell"><span style="width: 108px;"><span
                                        class="label font-weight-bold label-lg  label-light-danger label-inline">Not Approved</span></span>
                            </td>
                        @endif
                        <td>{{$trainee->payment}}</td>
                        <td>{{$trainee->language}}</td>
                        <td>
                            @can('trainee-edit')
                                <a href="{{ route('trainees.edit', $trainee->id) }}"
                                   class="btn btn-sm btn-clean btn-icon"
                                   title="Edit details">
                                    <i class="la la-edit"></i>
                                </a>
                            @endcan
                            @can('trainee-delete')
                                <a onclick="sweet('{{$trainee->id}}',this)"
                                   class="btn btn-sm btn-clean btn-icon btn-delete " title="Delete">
                                    <i class="nav-icon la la-trash"></i>
                                </a>
                            @endcan
                            <a href="{{ route('sendmail', $trainee->id) }}" class="btn btn-sm btn-clean btn-icon" title="Approve">
                                <i class="la la-check-circle"></i>
                            </a>

                        </td>
                        <td>
                            <a href="{{ asset('uploads/Trainee_files/cvs/' .$trainee->cv) }}" class="btn btn-primary" download>Download File</a>

                        @can('trainee-delete')
                                <a onclick="sweet('{{$trainee->id}}',this)"
                                   class="btn btn-sm btn-clean btn-icon btn-delete " title="Delete">
                                    <i class="nav-icon la la-trash"></i>
                                </a>
                            @endcan
                            <a href="{{ route('sendmail', $trainee->id) }}" class="btn btn-sm btn-clean btn-icon" title="Approve">
                                <i class="la la-check-circle"></i>
                            </a>

                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
@endsection


@section('js')
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>

@endsection
