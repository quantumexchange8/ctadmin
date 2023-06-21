<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }} {{ $heading }}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Comfortaa&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="{{asset('plugins/filepond/filepond.min.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/tagify/tagify.css')}}">
            <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
            <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-custom.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/splide/splide.min.css')}}">
            @vite(['resources/scss/light/plugins/splide/custom-splide.min.scss'])
            @vite(['resources/scss/dark/plugins/splide/custom-splide.min.scss'])
            <style>
                body.layout-dark .form-control-file {
                    width: 100%;
                    color: #805dca;
                    border-color: transparent;
                    border-radius: 6px;
                    background-color: #1b2e4b;
                }
            </style>
            @vite(['resources/scss/light/assets/components/tabs.scss'])
            @vite(['resources/scss/dark/assets/components/tabs.scss'])
            @vite(['resources/scss/light/assets/forms/switches.scss'])
            @vite(['resources/scss/light/plugins/filepond/custom-filepond.scss'])
            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/forms/switches.scss'])
            @vite(['resources/scss/dark/plugins/filepond/custom-filepond.scss'])
            @vite(['resources/scss/light/assets/apps/ecommerce-create.scss'])
            @vite(['resources/scss/dark/assets/apps/ecommerce-create.scss'])
            @vite(['resources/scss/dark/assets/apps/ecommerce-details.scss'])

            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ $heading }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }} {{ $heading }}</li>
                    </ol>
                </nav>
            </div>
            <!-- /BREADCRUMB -->
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert alert-light-danger alert-dismissible fade show border-0 mt-2" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> {{ $error }} </div>
                @endforeach
            @endif

            <form method="POST" action="{{ $submit }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-4 layout-spacing layout-top-spacing">
                    <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="widget-content widget-content-area ecommerce-create-section">
                            <div class="simple-tab">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach($languages as $locale)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link @if($locale == 'en') active @endif" id="home-tab" data-bs-toggle="tab" data-bs-target="#web_template-{{ $locale }}-pane" type="button" role="tab" aria-controls="web_template-{{ $locale }}-pane" aria-selected="true">{{ $locale }}</button>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    @foreach($languages as $locale)
                                        <div class="tab-pane fade @if($locale == 'en') show active @endif" id="web_template-{{ $locale }}-pane" role="tabpanel" aria-labelledby="web_template-{{ $locale }}" tabindex="0">
                                            <div class="row my-4">
                                                <div class="col-sm-12">
                                                    <label for="web_template_name" class="form-label">Name ({{ $locale }})</label>
                                                    <input type="text" class="form-control" id="web_template_name" name="{{ $locale }}[web_template_name]"
                                                           @if($title == 'Add')
                                                               value="{{ @$post->$locale['web_template_name'] }}"
                                                           @else
                                                               value="{{ @$web_template->translate($locale)->web_template_name }}"
                                                        @endif
                                                    >
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-sm-12">
                                                    <label for="web_template_description" class="form-label">Description ({{ $locale }})</label>
                                                    <textarea class="form-control" id="summernote-{{ $locale }}" name="{{ $locale }}[web_template_description]" >@if($title == 'Add'){{ @$post->$locale['web_template_description'] }}@else{{ @$web_template->translate($locale)->web_template_description }}
                                                        @endif</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!--  NOT FOR DISPLAYING  -->
                        <div class="row layout-top-spacing d-none">
                            <div id="splider_Basic" class="col-lg-12 layout-spacing">
                                <div class="statbox widget box box-shadow">
                                    <div class="widget-header">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                <h4>Default</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content widget-content-area  style-custom-1">

                                        <div class="position-relative">
                                            <div class="container" style="max-width: 560px">
                                                <div class="splide">
                                                    <div class="splide__track">
                                                        <ul class="splide__list">
                                                            <li class="splide__slide">
                                                                <img alt="slider-image" class="img-fluid" src="{{Vite::asset('resources/images/product-1.jpg')}}">
                                                            </li>
                                                            <li class="splide__slide">
                                                                <img alt="slider-image" class="img-fluid" src="{{Vite::asset('resources/images/product-2.jpg')}}">
                                                            </li>
                                                            <li class="splide__slide">
                                                                <img alt="slider-image" class="img-fluid" src="{{Vite::asset('resources/images/product-3.jpg')}}">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="code-section-container show-code">

                                            <button class="btn toggle-code-snippet"><span>Code</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down toggle-code-icon"><polyline points="6 9 12 15 18 9"></polyline></svg></button>

                                            <div class="code-section text-left">
                                <pre>
// Basic

var splide = new Splide( '.splide' );
splide.mount();</pre>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  NOT FOR DISPLAYING  -->

                        <div class="widget-content widget-content-area ecommerce-create-section mt-4">
                            @if($title == 'Edit')
                                <div class="row">
                                    <div id="splider_MultipleSlider" class="col-lg-12 col-md-12 mb-5">
                                        <div>
                                            <div class="widget-header">
                                                <div class="row">
                                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                        <h4>Images to display</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content widget-content-area">
                                                <div class="position-relative">
                                                    <div class="container" style="max-width: 700px">
                                                        <div class="splide-multiple">
                                                            <div class="splide__track">
                                                                <ul class="splide__list">
                                                                    @foreach($web_template->getMedia('web_template_images') as $image)
                                                                        <li class="splide__slide">
                                                                            <img alt="slider-image" class="img-fluid" src="{{ $image->getUrl() }}">
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-12">
                                    <label for="web_template_image">Upload Images</label>
                                    <small>(The Top image will be the THUMBNAIL.)</small>
                                    <div class="multiple-file-upload">
                                        <input type="file"
                                               class="filepond file-upload-multiple"
                                               name="web_template_image[]"
                                               id="web_template_image"
                                               multiple
                                               data-allow-reorder="true"
                                               data-max-file-size="3MB"
                                               data-max-files="10">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                        <div class="row">
                            <div class="col-xxl-12 col-xl-8 col-lg-8 col-md-7 mt-xxl-0 mt-4">
                                <div class="widget-content widget-content-area ecommerce-create-section">
                                    <div class="row">
                                        <div class="col-xxl-12 mb-4">
                                            <label for="web_template_slug">Slug</label>
                                            @if($title == 'Edit')
                                                <input type="text" class="form-control" id="web_template_slug" name="web_template_slug" value="{{ @$web_template->web_template_slug }}" disabled>
                                            @else
                                                <input type="text" class="form-control" id="web_template_slug" name="web_template_slug" value="{{ @$post->web_template_slug }}">
                                            @endif
                                        </div>
                                        <div class="col-xxl-12 col-md-6 mb-4">
                                            <label for="category_id">Category</label>
                                            {!! Form::select('category_id', $get_category_sel, @$post->category_id, ['class' => 'form-select', 'id' => 'category_id', 'placeholder' => 'Choose Category..']) !!}
                                        </div>
                                        <div class="col-xxl-12 col-lg-6 col-md-12">
                                            <label for="web_template_visibility" class="form-label">Visibility</label> <br>
                                            <div class="switch form-switch-custom switch-inline form-switch-success">
                                                <div class="input-checkbox">
                                                    <input class="switch-input" type="checkbox" role="switch" name="web_template_visibility" id="web_template_visibility"
                                                           @if($title == 'Add') checked @endif
                                                           @if(@$post->web_template_visibility == 1) checked @endif>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-12 col-xl-4 col-lg-4 col-md-5 mt-4">
                                <div class="widget-content widget-content-area ecommerce-create-section">
                                    <div class="row">
                                        <div class="col-sm-12 mb-2">
                                            <label for="web_template_price">Regular Price</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">$</span>
                                                <input type="text" class="form-control" id="web_template_price" name="web_template_price" value="{{ @$post->web_template_price }}" data-inputmask="'alias': 'numeric', 'digits' : '2', 'groupSeperator' : ',', 'autoGroup' : true, 'digitsOptional': false, 'removeMaskOnSubmit': true">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-2">
                                            <label for="web_template_offer_price">Sale Price</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">$</span>
                                                <input type="text" class="form-control" id="web_template_offer_price" name="web_template_offer_price" value="{{ @$post->web_template_offer_price }}" data-inputmask="'alias': 'numeric', 'digits' : '2', 'groupSeperator' : ',', 'autoGroup' : true, 'digitsOptional': false, 'removeMaskOnSubmit': true">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            @if($title == 'Add')
                                                <button type="submit" class="btn btn-success mb-2">Add Template</button>
                                                <a href="{{ route('web_template_listing') }}" class="btn btn-secondary mb-2">Cancel</a>
                                            @else
                                                <button type="submit" class="btn btn-primary mb-2">Update</button>
                                                <a href="{{ route('web_template_listing') }}" class="btn btn-secondary mb-2">Cancel</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                <!--  Filepond  -->
                <script src="{{asset('plugins/editors/quill/quill.js')}}"></script>
                <script src="{{asset('plugins/filepond/filepond.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginImagePreview.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginImageCrop.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginImageResize.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginImageTransform.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/filepondPluginFileValidateSize.min.js')}}"></script>
                <script src="{{asset('plugins/input-mask/jquery.inputmask.bundle.min.js')}}"></script>
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
                <script src="{{asset('plugins/splide/splide.min.js')}}"></script>
                <script src="{{asset('plugins/splide/custom-splide.js')}}"></script>

                <script>
                    /**
                     * ====================
                     *      File Pond
                     * ====================
                     */

                    // We want to preview images, so we register
                    // the Image Preview plugin, We also register
                    // exif orientation (to correct mobile image
                    // orientation) and size validation, to prevent
                    // large files from being added
                    FilePond.registerPlugin(
                        FilePondPluginImagePreview,
                        FilePondPluginImageExifOrientation,
                        FilePondPluginFileValidateSize,
                        // FilePondPluginImageEdit
                    );

                    // Select the file input and use
                    // create() to turn it into a pond
                    window.ecommerce = FilePond.create(document.querySelector('.file-upload-multiple'));
                </script>

                <script>
                    $(document).ready(function() {
                        @foreach($languages as $locale)
                            $('#summernote-{{ $locale }}').summernote({
                                placeholder: 'Enter product description..',
                                tabsize: 2,
                                height: 200,
                                toolbar: [
                                    ['style', ['style']],
                                    ['font', ['bold', 'underline', 'clear']],
                                    ['fontname', ['fontname']],
                                    ['color', ['color']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['table', ['table']],
                                    ['insert', ['link', 'picture', 'video']],
                                    ['view', ['fullscreen', 'codeview']]
                                ],
                                fontNames: ['Arial', 'Arial Black', 'Comfortaa', 'Comic Sans MS', 'Courier New'],
                                fontNamesIgnoreCheck: ['Comfortaa']
                            });
                        @endforeach

                        $("#web_template_price").inputmask();
                        $("#web_template_offer_price").inputmask();

                    });

                    const inputElement = document.querySelector('input[id="web_template_image"]');
                    const pond = FilePond.create(inputElement);

                    FilePond.setOptions({
                        server: {
                            process: '/modern-dark-menu/web_template/web_template_upload',
                            revert: '/modern-dark-menu/web_template/web_template_image_delete',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }
                    })
                </script>

                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
