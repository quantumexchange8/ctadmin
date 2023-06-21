<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $heading }} - {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            @vite(['resources/scss/light/assets/elements/custom-pagination.scss', 'resources/scss/dark/assets/elements/custom-pagination.scss'])
            @vite(['resources/scss/light/assets/components/modal.scss'])
            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])
            @vite(['resources/scss/light/plugins/editors/quill/quill.snow.scss'])
            @vite(['resources/scss/dark/plugins/editors/quill/quill.snow.scss'])
            <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
            @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
            @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
            @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
            @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])
            <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">

            <link rel="stylesheet" href="{{asset('plugins/animate/animate.css')}}">

            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ $heading }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $heading }} {{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <!-- /BREADCRUMB -->

            <!-- CONTENT AREA -->
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <form method="POST" action="{{ route('order_listing') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="search" class="mb-2">@lang('public.freetext')</label>
                                            <input type="text" class="form-control select_active" id="search"
                                                   name="freetext" placeholder="@lang('public.search_for')"
                                                   value="{{ @$search['freetext'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="rangeCalendarFlatpickr" class="mb-2">@lang('public.date_range')</label>
                                            <input id="basicFlatpickr" value="2022-09-04" class="form-control flatpickr flatpickr-input d-none" disabled type="text" placeholder="Select Date..">
                                            <input id="dateTimeFlatpickr" value="2022-09-19 12:00" class="form-control flatpickr flatpickr-input d-none" disabled type="text" placeholder="Select Date..">
                                            <input id="rangeCalendarFlatpickr" name="date_range" value="{{ @$search['date_range'] }}" class="form-control flatpickr flatpickr-input active" type="text" placeholder="@lang('public.select_date')">
                                            <input id="timeFlatpickr" class="form-control flatpickr flatpickr-input d-none" disabled type="text" placeholder="Select Date..">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="product_status" class="mb-2">@lang('public.status')</label>
                                            {!! Form::select('order_status', $get_order_status_sel, @$search['order_status'], ['class' => 'form-select', 'placeholder' => trans('public.choose_status')]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-2"
                                                name="submit" value="search">
                                            <i class="fas fa-search mr-1"></i> @lang('public.search')
                                        </button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light mx-2"
                                                name="submit" value="reset">
                                            <i class="fas fa-times mr-1"></i> @lang('public.reset')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if($records->isNotEmpty())
                    <div id="tableWithoutBorder" class="col-lg-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>{{ $heading }} {{ $title }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">@lang('public.order_no')</th>
                                            <th scope="col">@lang('public.name')</th>
                                            <th scope="col">@lang('public.email')</th>
                                            <th scope="col">@lang('public.price')</th>
                                            <th class="text-center" scope="col">@lang('public.status')</th>
                                            <th scope="col">@lang('public.date')</th>
                                            <th class="text-center" scope="col">@lang('public.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $record)
                                            <tr>
                                                <td>{{ $record->order_number }}</td>
                                                <td>
                                                    {{ $record->user->user_fullname }}
                                                </td>
                                                <td>
                                                    {{ $record->user->user_email }}
                                                </td>
                                                <td>
                                                    $ {{ $record->order_total_price ?? $record->getSubTotal() }}
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $statusLabels = [
                                                            \App\Models\Order::STATUS_PROCESSING => [trans('public.processing'), 'badge-primary'],
                                                            \App\Models\Order::STATUS_PENDING => [trans('public.pending'), 'badge-secondary'],
                                                            \App\Models\Order::STATUS_AWAITING => [trans('public.awaiting_payment'), 'badge-info'],
                                                            \App\Models\Order::STATUS_COMPLETED => [trans('public.completed'), 'badge-success'],
                                                            \App\Models\Order::STATUS_CANCELLED => [trans('public.cancelled'), 'badge-danger']
                                                        ];
                                                    @endphp
                                                    @if (isset($statusLabels[$record->order_status]))
                                                        @php
                                                            $status = $statusLabels[$record->order_status];
                                                        @endphp
                                                        <span class="badge {{ $status[1] }}">{{ $status[0] }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="inv-date"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="feather feather-calendar"><rect
                                                                x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line
                                                                x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2"
                                                                                                           x2="8"
                                                                                                           y2="6"></line><line
                                                                x1="3" y1="10" x2="21" y2="10"></line></svg>
                                                        {{ $record->order_created->format('j M Y') }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="action-btns">
                                                        <a href="javascript:void(0);" data-bs-toggle="modal"
                                                           data-bs-target="#mail_modal-{{ $record->order_id }}"
                                                           class="action-btn btn-view bs-tooltip me-2"
                                                           data-toggle="tooltip" data-placement="top" data-id="{{ $record->order_id }}" title="@lang('public.mail')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24" viewBox="0 0 24 24" fill="none"
                                                                 stroke="currentColor" stroke-width="2"
                                                                 stroke-linecap="round" stroke-linejoin="round"
                                                                 class="feather feather-mail">
                                                                <path
                                                                    d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                                <polyline points="22,6 12,13 2,6"></polyline>
                                                            </svg>
                                                        </a>
                                                        @include('pages.order.mail-modal')
                                                        <a href="{{ route('receipt_preview', $record->order_id) }}"
                                                           target="_blank" class="action-btn btn-view bs-tooltip me-2"
                                                           data-toggle="tooltip" data-placement="top" title="@lang('public.receipt')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24" viewBox="0 0 24 24" fill="none"
                                                                 stroke="currentColor" stroke-width="2"
                                                                 stroke-linecap="round" stroke-linejoin="round"
                                                                 class="feather feather-archive">
                                                                <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                                                <rect x="1" y="3" width="22" height="5"></rect>
                                                                <line x1="10" y1="12" x2="14" y2="12"></line>
                                                            </svg>
                                                        </a>
                                                        <a href="{{ route('invoice_preview', $record->order_id) }}"
                                                           target="_blank" class="action-btn btn-view bs-tooltip me-2"
                                                           data-toggle="tooltip" data-placement="top" title="@lang('public.invoice')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24" viewBox="0 0 24 24" fill="none"
                                                                 stroke="currentColor" stroke-width="2"
                                                                 stroke-linecap="round" stroke-linejoin="round"
                                                                 class="feather feather-dollar-sign">
                                                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                                            </svg>
                                                        </a>
                                                        <a href="{{ route('order_edit', $record->order_id) }}"
                                                           class="action-btn btn-edit bs-tooltip me-2"
                                                           data-toggle="tooltip" data-placement="top" title="@lang('public.edit')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24" viewBox="0 0 24 24" fill="none"
                                                                 stroke="currentColor" stroke-width="2"
                                                                 stroke-linecap="round" stroke-linejoin="round"
                                                                 class="feather feather-edit-2">
                                                                <path
                                                                    d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                            </svg>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                           class="action-btn btn-delete bs-tooltip cancel"
                                                           data-toggle="tooltip" data-placement="top" data-id="{{ $record->order_id }}"
                                                           data-bs-toggle="modal" data-bs-target="#order_cancel"
                                                           title="@lang('public.cancel')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24" viewBox="0 0 24 24" fill="none"
                                                                 stroke="currentColor" stroke-width="2"
                                                                 stroke-linecap="round" stroke-linejoin="round"
                                                                 class="feather feather-x-circle text-danger">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                                                <line x1="9" y1="9" x2="15" y2="15"></line>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {!! $records->links('pagination.custom') !!}
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            @else
                <div class="col-12">
                    <div
                        class="alert alert-arrow-right alert-icon-right alert-light-warning alert-dismissible fade show mb-4"
                        role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-alert-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12" y2="16"></line>
                        </svg>
                        <strong>Warning!</strong> No Record Found.
                    </div>
                </div>
            @endif

            <!-- Cancel Modal -->
            <div class="modal fade modal-notification" id="order_cancel" tabindex="-1" role="dialog"
                 aria-labelledby="order_cancelTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('order_cancel') }}">
                            @csrf
                            <div class="modal-body text-center">
                                <div class="icon-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x text-danger">
                                        <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </div>
                                <p class="modal-text">Are you sure you want to CANCEL this order?</p>
                                <input type="hidden" name="order_id" id="order_id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary"
                                        data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-danger ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Cancel</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- CONTENT AREA -->

            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
                <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
                <script type="module" src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
                <script type="module" src="{{asset('plugins/flatpickr/custom-flatpickr.js')}}"></script>
                <script>
                    $(document).ready(function (e) {
                        $(document).on('click', '.cancel', function () {
                            var id = $(this).attr('data-id');
                            $(".modal-body #order_id").val(id);
                        });

                        var type = $('#category_type').val();
                        category_display();

                        $('#category_type').on('change', function () {
                            type = this.value;
                            category_display();
                        });

                        function category_display() {
                            if (type == 2) {
                                $('.web-template-category').show();
                                $('.pos-system-category').hide();
                            } else if (type == 3) {
                                $('.web-template-category').hide();
                                $('.pos-system-category').show();
                            } else {
                                $('.web-template-category').hide();
                                $('.pos-system-category').hide();
                            }
                        }

                        $('.btn-view').on('click', function () {
                            const form_id = $(this).attr('data-id');
                            $('#mail_form-'+form_id).on('submit', function (e) {
                                e.preventDefault(); // Prevent the default form submission

                                var formData = new FormData(this);
                                var form = $(this); // Get the current form

                                // Send the content to the server using AJAX
                                $.ajax({
                                    url: '/modern-dark-menu/order/send_mail',
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    data: formData,
                                    processData: false, // Prevent jQuery from processing the data
                                    contentType: false, // Prevent jQuery from setting content type
                                    success: function (data) {
                                        if(data.status == 0) {
                                            form.find('.form-control').removeClass('border-danger');
                                            form.find('.input-error').text('');

                                            // Display input errors for the current form only
                                            $.each(data.error, function(prefix, val) {
                                                form.find('span.' + prefix + '_error').text(val[0]);
                                                form.find('#' + prefix).addClass('border-danger');
                                            });
                                        } else {
                                            $('#mail_form-'+form_id)[0].reset();
                                            Swal.fire({
                                                title: 'Done!',
                                                text: data.msg,
                                                icon: 'success',
                                                confirmButtonText: 'OK',
                                                timer: 3000,
                                                timerProgressBar: false,
                                            }).then(function() {
                                                location.reload();
                                            });
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        // Handle errors if necessary
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'An error occurred: ' + error,
                                            icon: 'error',
                                            confirmButtonText: 'OK',
                                        });
                                    }
                                });
                            });
                        })


                    });
                </script>

                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
