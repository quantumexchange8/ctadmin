<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $heading }} {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            @vite(['resources/scss/light/assets/elements/custom-pagination.scss', 'resources/scss/dark/assets/elements/custom-pagination.scss'])
            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])
            @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
            @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])
            <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/noUiSlider/nouislider.min.css')}}">
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
                            <form method="POST" action="{{ route('report_listing') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="search" class="mb-2">Freetext</label>
                                            <input type="text" class="form-control select_active" id="search" name="freetext" placeholder="Search for..." value="{{ @$search['freetext'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="order_status" class="mb-2">Status</label>
                                            {!! Form::select('order_status', $get_order_status_sel, @$search['order_status'], ['class' => 'form-select', 'placeholder' => 'Search Status..']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="rangeCalendarFlatpickr" class="mb-2">Date Range</label>
                                            <input id="basicFlatpickr" value="2022-09-04" class="form-control flatpickr flatpickr-input d-none" disabled type="text" placeholder="Select Date..">
                                            <input id="dateTimeFlatpickr" value="2022-09-19 12:00" class="form-control flatpickr flatpickr-input d-none" disabled type="text" placeholder="Select Date..">
                                            <input id="rangeCalendarFlatpickr" name="date_range" value="{{ @$search['date_range'] }}" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date..">
                                            <input id="timeFlatpickr" class="form-control flatpickr flatpickr-input d-none" disabled type="text" placeholder="Select Date..">
                                        </div>
                                    </div>
                                    {{--                                    <div class="col-md-4 pos-system-category">--}}
                                    {{--                                        <div class="form-group mb-3">--}}
                                    {{--                                            <label for="pos_system_category" class="mb-2">POS System Category</label>--}}
                                    {{--                                            {!! Form::select('pos_system_category', $get_pos_system_category_sel, @$search['pos_system_category'], ['class' => 'form-select', 'id' => 'pos_system_category', 'placeholder' => 'Choose POS Category..']) !!}--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="col-md-4">--}}
                                    {{--                                        <div class="form-group mb-3">--}}
                                    {{--                                            <label for="product_status" class="mb-2">Status</label>--}}
                                    {{--                                            {!! Form::select('product_status', $get_status_sel, @$search['product_status'], ['class' => 'form-select', 'placeholder' => 'Search Status..']) !!}--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="col-md-4">--}}
                                    {{--                                        <div class="form-group mb-3">--}}
                                    {{--                                            <label for="product_visibility" class="mb-2">Visibility</label>--}}
                                    {{--                                            {!! Form::select('product_visibility', $get_visibility_sel, @$search['product_visibility'], ['class' => 'form-select', 'placeholder' => 'Search Visibility..']) !!}--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="col-md-4">--}}
                                    {{--                                        <div class="form-group mb-3">--}}
                                    {{--                                            <label for="order_by" class="mb-2">Order By</label>--}}
                                    {{--                                            {!! Form::select('order_by', $get_order_sel, @$search['order_by'], ['class' => 'form-select']) !!}--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-2" name="submit" value="search">
                                            <i class="fas fa-search mr-1"></i> Search
                                        </button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light mx-2" name="submit" value="reset">
                                            <i class="fas fa-times mr-1"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-dark waves-effect waves-light ml-2" name="submit" value="export">
                                            <i class="fas fa-times mr-1"></i> Export
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
                                <p class="mb-4"> Overview of Order Details and Sales Statistics</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Order Number</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Order Items</th>
                                            <th scope="col">Price</th>
                                            <th scope="col" class="text-center">Completed At</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $record)
                                            <tr>
                                                <td>
                                                    {{ $record->order_number }}
                                                </td>
                                                <td>
                                                    {{ $record->user->user_fullname }}
                                                </td>
                                                <td>
                                                    @php
                                                        $statusLabels = [
                                                            \App\Models\Order::STATUS_PROCESSING => ['Processing', 'badge-primary'],
                                                            \App\Models\Order::STATUS_PENDING => ['Pending', 'badge-secondary'],
                                                            \App\Models\Order::STATUS_AWAITING => ['Awaiting Payment', 'badge-info'],
                                                            \App\Models\Order::STATUS_COMPLETED => ['Completed', 'badge-success'],
                                                            \App\Models\Order::STATUS_CANCELLED => ['Cancelled', 'badge-danger']
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
                                                    <ul>
                                                        @foreach ($record->order_item as $item)
                                                            <li>{{ $item->order_item_name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    ${{ $record->order_total_price }}
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $completedTime = date('Y-m-d g:i A', strtotime($record->order_completed_at));
                                                    @endphp
                                                    @if($record->order_status == \App\Models\Order::STATUS_COMPLETED)
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
                                                        {{ $completedTime }}
                                                    @else
                                                        <p>-</p>
                                                    @endif
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
                    <div class="alert alert-arrow-right alert-icon-right alert-light-warning alert-dismissible fade show mb-4" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                        <strong>Warning!</strong> No Record Found.
                    </div>
                </div>
            @endif

            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                <script type="module" src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
                <script type="module" src="{{asset('plugins/flatpickr/custom-flatpickr.js')}}"></script>
                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
