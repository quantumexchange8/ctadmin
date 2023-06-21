<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $heading }} - {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            @vite(['resources/scss/light/assets/elements/custom-pagination.scss', 'resources/scss/dark/assets/elements/custom-pagination.scss'])
            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])
            <link rel="stylesheet" href="{{asset('plugins/animate/animate.css')}}">

            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ $heading }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <!-- /BREADCRUMB -->

            <!-- CONTENT AREA -->
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <form method="POST" action="{{ route('user_listing') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="search" class="mb-2">@lang('public.freetext')</label>
                                            <input type="text" class="form-control select_active" id="search" name="freetext" placeholder="@lang('public.search_for')" value="{{ @$search['freetext'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="user_gender" class="mb-2">@lang('public.gender')</label>
                                            {!! Form::select('user_gender', $user_gender_sel, @$search['user_gender'], ['class' => 'form-select', 'id' => 'user_gender', 'placeholder' => trans('public.gender')]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="user_nationality" class="mb-2">@lang('public.country')</label>
                                            {!! Form::select('user_nationality', $user_nationality_sel, @$search['user_nationality'], ['class' => 'form-select', 'id' => 'user_nationality', 'placeholder' => trans('public.choose_country')]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="user_status" class="mb-2">@lang('public.status')</label>
                                            {!! Form::select('user_status', $user_status_sel, @$search['user_status'], ['class' => 'form-select', 'placeholder' => trans('public.choose_status')]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="order_by" class="mb-2">@lang('public.order_by')</label>
                                            {!! Form::select('order_by', $get_order_sel, @$search['order_by'], ['class' => 'form-select']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-2" name="submit" value="search">
                                            <i class="fas fa-search mr-1"></i> @lang('public.search')
                                        </button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light mx-2" name="submit" value="reset">
                                            <i class="fas fa-times mr-1"></i> @lang('public.reset')
                                        </button>
                                        <div class="float-end">
                                            <a href="{{ route('user_add') }}" class="btn btn-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                                <span class="btn-text-inner">@lang('public.create')</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if($records->isNotEmpty())
                    <?php
                    $no = $records->firstItem();
                    ?>
                    <div id="tableWithoutBorder" class="col-lg-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>{{ $heading }} / {{ $title }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <p class="mb-4">@lang('public.add_users_caption')</p>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">@lang('public.name')</th>
                                            <th scope="col">@lang('public.phone')</th>
                                            <th scope="col">@lang('public.gender')</th>
                                            <th scope="col">@lang('public.country')</th>
                                            <th class="text-center" scope="col">@lang('public.status')</th>
                                            <th class="text-center" scope="col">@lang('public.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($records as $record)
                                                <tr>
                                                    <td>
                                                        <p class="mb-0">{{ $no }}</p>
                                                    </td>
                                                    <td>
                                                        <div class="media">
                                                            <div class="avatar me-2">
                                                                @if($record->hasMedia('user_profile_photo'))
                                                                    <img alt="avatar" src="{{ $record->getFirstMediaUrl('user_profile_photo') }}" class="rounded-circle" />
                                                                @else
                                                                    <img alt="avatar" src="{{Vite::asset('resources/images/profile-3.jpeg')}}" class="rounded-circle" />
                                                                @endif
                                                            </div>
                                                            <div class="media-body align-self-center">
                                                                <h6 class="mb-0">{{ $record->user_fullname }}</h6>
                                                                <span>{{ $record->user_email }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">
                                                            {{ $record->user_phone }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">
                                                            {{ ucfirst($record->user_gender ?? '-') }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">
                                                            {{ $record->user_nationality }}
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        @if($record->user_status == \App\Models\User::STATUS_ACTIVE)
                                                            <span class="badge badge-primary">@lang('public.active')</span>
                                                        @elseif($record->user_status == \App\Models\User::STATUS_INACTIVE)
                                                            <span class="badge badge-warning">@lang('public.inactive')</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="action-btns">
                                                            <a href="{{ route('user_edit', $record->user_id) }}" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="@lang('public.edit')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                            </a>
                                                            <a href="javascript:void(0);" class="action-btn btn-delete bs-tooltip delete" data-toggle="tooltip" data-placement="top" title="@lang('public.delete')" data-id="{{ $record->user_id }}" data-bs-toggle="modal" data-bs-target="#user_delete">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                                $no++
                                                ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            @else
                <div class="col-12">
                    <div class="alert alert-arrow-right alert-icon-right alert-light-warning alert-dismissible fade show mb-4" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                        <strong>@lang('public.warning')</strong> @lang('public.no_record')
                    </div>
                </div>
            @endif

            <!-- Delete Modal -->
            <div class="modal fade modal-notification" id="user_delete" tabindex="-1" role="dialog" aria-labelledby="user_deleteTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('user_delete') }}">
                            @csrf
                            <div class="modal-body text-center">
                                <div class="icon-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 delete-note"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </div>
                                <p class="modal-text">@lang('public.delete_user_confirmation')</p>
                                <input type="hidden" name="user_id" id="user_id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary"
                                        data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">@lang('public.close')</span>
                                </button>
                                <button type="submit" class="btn btn-danger ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">@lang('public.delete')</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- CONTENT AREA -->

            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                <script>
                    $(document).ready(function(e) {
                        $(document).on('click', '.delete', function() {
                            var id = $(this).attr('data-id');
                            $(".modal-body #user_id").val(id);
                        });
                    });
                </script>

                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
