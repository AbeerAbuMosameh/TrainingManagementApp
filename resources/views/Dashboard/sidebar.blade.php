<div class="aside-primary aside aside-workspace aside-left aside-fixed d-flex flex-column flex-row-auto scrollable-element" id="kt_aside">
    <div class="brand flex-column-auto" id="kt_brand">
        <!--begin::Logo-->
        <a href="{{route('home')}}" class="brand-logo">
            <img alt="Logo" src="{{asset('admin/assets/media/logos/logoo.png')}}" width="200px" height="50px"
                 style="margin-left: 30px;"/>

        </a>        <!--end::Logo-->
        <!--begin::Toggle-->
        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
							<span class="svg-icon svg-icon svg-icon-xl">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24"/>
										<path
                                            d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                                            fill="#000000" fill-rule="nonzero"
                                            transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)"/>
										<path
                                            d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3"
                                            transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)"/>
									</g>
								</svg>
                                <!--end::Svg Icon-->
							</span>
        </button>
        <!--end::Toolbar-->
    </div>

    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
             data-menu-dropdown-timeout="500">
            <ul class="menu-nav">
                <li class="menu-item" aria-haspopup="true">
                    <a href="{{route('home')}}" class="menu-link">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
											<svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24"/>
													<path
                                                        d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                                        fill="#000000" fill-rule="nonzero"/>
													<path
                                                        d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                                        fill="#000000" opacity="0.3"/>
												</g>
											</svg>
                                            <!--end::Svg Icon-->
										</span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                @if(auth()->user()->level == 1)

                    <li class="menu-section">
                        <h4 class="menu-text">Advisores Management</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-user-tie"></i> <span class="menu-text">Advisors</span>

                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('advisors.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Show Advisors</span>
                                    </a>
                                </li>
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('advisors-fields')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Advisors Fields</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="menu-section">
                        <h4 class="menu-text">Trainees Management</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-users"></i> <span class="menu-text">Trainees</span>

                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('trainees.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Show Trainees</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="menu-section">
                        <h4 class="menu-text">Fields Management</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-book"></i> <span class="menu-text">Fields</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('fields.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Show Fields</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="menu-section">
                        <h4 class="menu-text">Programs Management</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas menu-icon fas fa-database"></i> <span class="menu-text">Programs</span>

                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('programs.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Show Program's</span>
                                    </a>
                                </li>

                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('programs.create')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Create Program</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="menu-section">
                        <h4 class="menu-text">Trainee Programs Request</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-check-square"></i> <span class="menu-text">Trainee Requests</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('trainees-programs-request')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Show Requests</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="menu-section">
                        <h4 class="menu-text">Payments Management</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-money-bill-wave"></i> <span class="menu-text">Payments</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('payments.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Show payments</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                     <li class="menu-section">

                        <h4 class="menu-text">Billing issues Management</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-money-check"></i> <span class="menu-text">Billing issues</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('trainees-billings')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">paid programs</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                @endif

                @if(auth()->user()->level == 2)

                    <li class="menu-section">
                        <h4 class="menu-text">Program Management</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-database"></i> <span class="menu-text">Programs</span>

                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('programs_to_advisor')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Show Programs</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="menu-section">
                        <h4 class="menu-text">Trainees Management</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-users"></i> <span class="menu-text">Trainees</span>

                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('trainees_to_advisor')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Show Trainees</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="menu-section">
                        <h4 class="menu-text">Task Management</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-tasks"></i> <span class="menu-text">Tasks</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('tasks.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">All Tasks</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('Training-tasks.solution')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">All Tasks Solution</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="menu-section">
                        <h4 class="menu-text">Meetings Component</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-clock"></i> <span class="menu-text">Meetings Request</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('advisor.meetings.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">All Requests</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </li>


                @endif

                @if(auth()->user()->level == 3)


                    <li class="menu-section">
                        <h4 class="menu-text">Program Component</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-chevron-circle-down"></i> <span class="menu-text">Accepted Program</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('program_to_trainee')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Accepted Program</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-registered"></i> <span class="menu-text">Apply in Program</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('trainees-programs.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">all Applied Program</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </li>

                    <li class="menu-section">
                        <h4 class="menu-text">Meeting Component </h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-clock"></i> <span class="menu-text">Meetings</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('meetings.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text"> All meeting</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </li>


                    <li class="menu-section">
                        <h4 class="menu-text">Training material To Tasks </h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-tasks"></i> <span class="menu-text">All Tasks</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <i class="menu-arrow"></i>

                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{route('Training-tasks.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text"> Tasks</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </li>

                @endif

                <li class="menu-section">
                    <h4 class="menu-text">SETTINGS</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                <li class="menu-item" aria-haspopup="true">
                    <a class="menu-link" href="{{route('password')}}">
                        <i class="menu-icon  fas fa-shield-alt">

                        </i>

                        <span class="menu-text">Update Password</span>


                    </a>
                </li>
                @if(auth()->user()->level != 1)
                <li class="menu-item" aria-haspopup="true">
                    <a class="menu-link" href="{{route('profile')}}">
                        <i class="menu-icon  far fa-user-circle">

                        </i>

                        <span class="menu-text">Profile</span>

                    </a>
                </li>
                @endif
                @if(auth()->user()->level == 1)
                    <li class="menu-item" aria-haspopup="true">
                        <a class="menu-link" href="{{route('logs')}}">
                            <i class="menu-icon  far fa-file">

                            </i>

                            <span class="menu-text">All user activities</span>

                        </a>
                    </li>
                @endif
                <li class="menu-item" aria-haspopup="true">
                    <a class="menu-link" onclick="document.getElementById('logout').submit()">
                        <i class="menu-icon
                                    fas fa-sign-out-alt">
                        </i>
                        <span class="menu-text"> <form id="logout" action="{{route('logout')}}" method="Post">
                                @csrf
                                Sign Out
                            </form></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>
<!--end::Aside-->
