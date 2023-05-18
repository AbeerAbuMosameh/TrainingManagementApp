@extends('Dashboard.master')

@section('title')
    dashboard
@endsection

@section('css')

@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Trainee List
                    <span class="d-block text-muted pt-2 font-size-sm">Sorting &amp; pagination trainee</span></h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Dropdown-->
                <div class="dropdown dropdown-inline mr-2">
                    <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="svg-icon svg-icon-md">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
													<svg xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                         height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"/>
															<path
                                                                d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                                                fill="#000000" opacity="0.3"/>
															<path
                                                                d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                                                fill="#000000"/>
														</g>
													</svg>
                                                    <!--end::Svg Icon-->
												</span>Export
                    </button>
                    <!--begin::Dropdown Menu-->
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <!--begin::Navigation-->
                        <ul class="navi flex-column navi-hover py-2">
                            <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">
                                Choose an option:
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
																<span class="navi-icon">
																	<i class="la la-print"></i>
																</span>
                                    <span class="navi-text">Print</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
																<span class="navi-icon">
																	<i class="la la-copy"></i>
																</span>
                                    <span class="navi-text">Copy</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
																<span class="navi-icon">
																	<i class="la la-file-excel-o"></i>
																</span>
                                    <span class="navi-text">Excel</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
																<span class="navi-icon">
																	<i class="la la-file-text-o"></i>
																</span>
                                    <span class="navi-text">CSV</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
																<span class="navi-icon">
																	<i class="la la-file-pdf-o"></i>
																</span>
                                    <span class="navi-text">PDF</span>
                                </a>
                            </li>
                        </ul>
                        <!--end::Navigation-->
                    </div>
                    <!--end::Dropdown Menu-->
                </div>
                <!--end::Dropdown-->

            </div>
        </div>
        <div class="card-body">
            <!--begin: Search Form-->
            <!--begin::Search Form-->
            <div class="mb-12">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-xl-12">
                        <div class="row align-items-center">
                            <div class="col-md-3 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="Search..."
                                           id="kt_datatable_search_query"/>
                                    <span>
											<i class="flaticon2-search-1 text-muted"></i>
									</span>
                                </div>
                            </div>
                            <div class="col-md-3 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Status:</label>
                                    <select class="form-control" id="kt_datatable_search_status">
                                        <option value="" selected="selected">Select</option>

                                        <option value="">Approved</option>
                                        <option value="1">Not Approved</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Education:</label>
                                    <select class="form-control" id="kt_datatable_search_type">
                                        <option value="" selected="selected">Select</option>
                                        <option value="High School">High School</option>
                                        <option value="Diploma Degree">Diploma degree</option>
                                        <option value="Bachelor Degree">Bachelor's Degree</option>
                                        <option value="Master Degree">Master's Degree</option>
                                        <option value="Doctoral Degree">Doctoral Degree</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Language:</label>
                                    <select class="form-control" id="kt_datatable_search_type">
                                        <option value="English" selected="selected">Select</option>
                                        <option value="English">English</option>
                                        <option value="Arabic">Arabic</option>
                                        <option value="French">French</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--end::Search Form-->
            <!--end: Search Form-->
            <!--begin: Datatable-->
            @can('trainee-list')
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-separate datatable-head-custom" id="kt_daatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>email</th>
                                <th>phone</th>
                                <th>education</th>
                                <th>gpa</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>payment</th>
                                <th>language</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($trainees as $trainee)
                                    <tr data-entry-id="{{ $trainee->id }}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>@if ($trainee->image)
                                                <img class="pr-4" src="{{asset($trainee->image)}}" height="50px"
                                                     width="50px"
                                                     alt="Logo">
                                            @endif </td>
                                        <td>{{$trainee->first_name}} {{$trainee->last_name}}</td>
                                        <td>{{$trainee->email}}</td>
                                        <td>{{$trainee->phone}}</td>
                                        <td>{{$trainee->education}}</td>
                                        <td>{{$trainee->gpa}}</td>
                                        <td>{{$trainee->address}}</td>
                                        <td>{{$trainee->city}}</td>
                                        <td>{{$trainee->payment}}</td>
                                        <td>{{$trainee->language}}</td>

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
                                                <a href="{{ route('sendmail', $trainee->id) }}" class="btn btn-sm btn-clean btn-icon" title="Edit details">
                                                    <i class="la la-mail-bulk"></i>
                                                </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

            @endcan
            <!--end: Datatable-->
        </div>
    </div>
@endsection


@section('js')
    <script src="{{asset('admin/assets/js/pages/crud/ktdatatable/base/data-ajax.js')}}"></script>

@endsection
