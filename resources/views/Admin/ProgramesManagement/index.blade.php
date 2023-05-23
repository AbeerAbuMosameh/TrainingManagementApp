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
                <h3 class="card-label">Advisor Data</h3>
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
                    <th>field</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Language</th>
                    <th>Actions</th>
                    <th>Documents</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($advisors as $advisor)
                    <tr data-entry-id="{{ $advisor->id }}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$advisor->first_name}} {{$advisor->last_name}}</td>
                        <td>{{$advisor->email}}</td>
                        <td>{{$advisor->phone}}</td>
                        <td>{{$advisor->education}}</td>
                        <td>{{$advisor->field}}</td>
                        <td>{{$advisor->address}}</td>
                        <td>{{$advisor->city}}</td>


                        @if($advisor->is_approved == 1 )
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
                        <td>{{$advisor->language}}</td>
                        <td>
                                <a href="{{ route('advisors.edit', $advisor->id) }}"
                                   class="btn btn-sm btn-clean btn-icon"
                                   title="Edit details">
                                    <i class="la la-edit"></i>
                                </a>

                                <a onclick="sweet('{{$advisor->id}}',this)"
                                   class="btn btn-sm btn-clean btn-icon btn-delete " title="Delete">
                                    <i class="nav-icon la la-trash"></i>
                                </a>
                            <a href="{{ route('sendmailtoavisor', $advisor->id) }}" class="btn btn-sm btn-clean btn-icon" title="Approve">
                                <i class="la la-check-circle"></i>
                            </a>

                        </td>
                        <td>
                            @if($advisor->cv)
                                <a href="{{ $advisor->cv}}" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Download CV</a>
                            @endif

                                @if($advisor->certification)
                                    <a href="{{ $advisor->certification }}" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Download Certification</a>
                                @endif

                                @if(count($advisor->otherFile ?? []) > 0)
                                    @foreach($advisor->otherFile as $otherFileUrl)
                                        <a href="{{ $otherFileUrl }}" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Related File</a>
                                    @endforeach
                                @endif
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
