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
                            <form method="POST" action="{{ route('product_listing') }}">
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
                                            <label for="category_type" class="mb-2">@lang('public.category')</label>
                                            {!! Form::select('category_id', $get_category_sel, @$search['category_id'], ['class' => 'form-select', 'id' => 'category_type', 'placeholder' => trans('public.choose_category')]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4 web-template-category">
                                        <div class="form-group mb-3">
                                            <label for="web_template_category_id" class="mb-2">@lang('public.web_template_category')</label>
                                            {!! Form::select('web_template_category_id', $get_web_template_category_sel, @$search['web_template_category_id'], ['class' => 'form-select', 'id' => 'web_template_category_id', 'placeholder' => trans('public.choose_template_category')]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4 pos-system-category">
                                        <div class="form-group mb-3">
                                            <label for="pos_system_category" class="mb-2">@lang('public.pos_category')</label>
                                            {!! Form::select('pos_system_category', $get_pos_system_category_sel, @$search['pos_system_category'], ['class' => 'form-select', 'id' => 'pos_system_category', 'placeholder' => trans('public.choose_pos_category')]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="product_status" class="mb-2">@lang('public.status')</label>
                                            {!! Form::select('product_status', $get_status_sel, @$search['product_status'], ['class' => 'form-select', 'placeholder' => trans('public.choose_status')]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="product_visibility" class="mb-2">@lang('public.visibility')</label>
                                            {!! Form::select('product_visibility', $get_visibility_sel, @$search['product_visibility'], ['class' => 'form-select', 'placeholder' => trans('public.choose_visibility')]) !!}
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
                                            <a href="{{ route('product_add') }}" class="btn btn-success">
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
                                <p class="mb-4"> @lang('public.add_products_caption')</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="" scope="col">@lang('public.title')</th>
                                            <th scope="col">@lang('public.price')</th>
                                            <th scope="col">@lang('public.category')</th>
                                            <th scope="col">@lang('public.product_category')</th>
                                            <th class="text-center" scope="col">@lang('public.status')</th>
                                            <th scope="col">@lang('public.date_created')</th>
                                            <th scope="col" class="text-center">@lang('public.total_view')</th>
                                            <th class="text-center" scope="col">@lang('public.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $record)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td class="">
                                                    {{ $record->product_title }}
                                                </td>
                                                <td>
                                                    @if($record->product_status == \App\Models\WebTemplate::STATUS_NORMAL)
                                                        $ {{ $record->product_price }}
                                                    @else
                                                        <span>
                                                            <span class="text-secondary">$ {{ $record->product_offer_price }}</span>
                                                            <span class="badge badge-danger mt-1">OFFER</span>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $record->category->category_name }}
                                                </td>
                                                <td>
                                                    @if($record->category_id == 1)
                                                        -
                                                    @elseif($record->category_id == 2)
                                                        {{ $record->web_template_category->web_template_category_name }}
                                                    @elseif($record->category_id == 3)
                                                        {{ ucfirst($record->pos_system_category) }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge {{ $record->product_visibility == 1 ? 'badge-light-success' : "badge-light-secondary" }}">{{ $record->product_visibility == 1 ? trans('public.visible') : trans('public.not_visible') }}</span>
                                                </td>
                                                <td>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                                    <span class="table-inner-text">{{ date_format($record->product_created, 'Y-m-d') }}</span>
                                                </td>
                                                <td class="text-center">
                                                    {{ views($record)->count() }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="action-btns">
                                                        <a href="javascript:void(0);" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" data-bs-target="#product_view-{{ $record->id }}" title="@lang('public.view')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                        </a>
                                                        @include('pages.product.product_view_modal')
                                                        <a href="{{ route('product_edit', $record->id) }}" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="@lang('public.edit')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                        </a>
                                                        <a href="javascript:void(0);" class="action-btn btn-delete bs-tooltip delete" data-id='{{ $record->id }}' data-toggle="tooltip" data-placement="top" title="@lang('public.delete')" data-bs-toggle="modal" data-bs-target="#product_delete">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                        </a>
                                                    </div>
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
                        <strong>@lang('public.warning')</strong> @lang('public.no_record').
                    </div>
                </div>
            @endif

            <!-- Delete Modal -->
            <div class="modal fade modal-notification" id="product_delete" tabindex="-1" role="dialog" aria-labelledby="product_deleteTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('product_delete') }}">
                            @csrf
                            <div class="modal-body text-center">
                                <div class="icon-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 delete-note"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </div>
                                <p class="modal-text">@lang('public.product_delete')</p>
                                <input type="hidden" name="product_id" id="product_id">
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

            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                <script>
                    $(document).ready(function(e) {
                        $(document).on('click', '.delete', function() {
                            var id = $(this).attr('data-id');
                            $(".modal-body #product_id").val(id);
                        });

                        var type = $('#category_type').val();
                        category_display();

                        $('#category_type').on('change', function() {
                            type = this.value;
                            category_display();
                        });
                        function category_display() {
                            if(type == 2) {
                                $('.web-template-category').show();
                                $('.pos-system-category').hide();
                            } else if(type == 3) {
                                $('.web-template-category').hide();
                                $('.pos-system-category').show();
                            }
                            else {
                                $('.web-template-category').hide();
                                $('.pos-system-category').hide();
                            }
                        }
                    });
                </script>

                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
