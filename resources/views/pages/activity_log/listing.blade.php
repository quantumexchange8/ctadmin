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
                            <form method="POST" action="{{ route('activity_log_listing') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="search" class="mb-2">Freetext</label>
                                            <input type="text" class="form-control select_active" id="search" name="freetext" placeholder="Search for..." value="{{ @$search['freetext'] }}">
                                        </div>
                                    </div>
{{--                                    <div class="col-md-4">--}}
{{--                                        <div class="form-group mb-3">--}}
{{--                                            <label for="category_type" class="mb-2">Category</label>--}}
{{--                                            {!! Form::select('category_id', $get_category_sel, @$search['category_id'], ['class' => 'form-select', 'id' => 'category_type', 'placeholder' => 'Choose Category']) !!}--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-4 web-template-category">--}}
{{--                                        <div class="form-group mb-3">--}}
{{--                                            <label for="web_template_category_id" class="mb-2">Web Template Category</label>--}}
{{--                                            {!! Form::select('web_template_category_id', $get_web_template_category_sel, @$search['web_template_category_id'], ['class' => 'form-select', 'id' => 'web_template_category_id', 'placeholder' => 'Choose Template Category..']) !!}--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
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
                                        <h4>{{ $heading }} {{ $title }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <p class="mb-4"> Keep track of all your actions and events in one place. Stay updated with the latest changes and monitor your activity history easily</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="" scope="col">Log Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Properties</th>
                                            <th scope="col">Caused By</th>
                                            <th class="text-center" scope="col">Datetime</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $record)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td class="">
                                                    {{ $record->log_name }}
                                                </td>
                                                <td>
                                                    {{ $record->description }}
                                                </td>
                                                <td>
                                                    @if ($record->properties)
                                                        <ul>
                                                            @foreach ($record->properties as $key => $value)
                                                                @php
                                                                    $valueString = is_array($value) ? implode("\n", array_map(function ($old_heading, $old_value) {
                                                                        return "- " . ucfirst($old_heading) . ": " . $old_value;
                                                                    }, array_keys($value), $value)) : "- " . $value;
                                                                @endphp
                                                                <li>{{ ucfirst($key) }}<br>{!! nl2br($valueString) !!}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $record->causer->user_fullname ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ date_format($record->created_at, 'Y-m-d H:i A') }}
                                                </td>
                                            </tr>
                                                <?php
                                                $no++;
                                                ?>
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

                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
