<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $heading }} - {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            {{-- @vite(['resources/scss/light/assets/components/timeline.scss']) --}}
            <link rel="stylesheet" href="{{asset('plugins/filepond/filepond.min.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">

            @vite(['resources/scss/light/plugins/filepond/custom-filepond.scss'])
            @vite(['resources/scss/light/assets/components/tabs.scss'])
            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
            @vite(['resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss'])
            @vite(['resources/scss/light/assets/forms/switches.scss'])
            @vite(['resources/scss/light/assets/components/list-group.scss'])
            @vite(['resources/scss/light/assets/users/account-setting.scss'])

            @vite(['resources/scss/dark/plugins/filepond/custom-filepond.scss'])
            @vite(['resources/scss/dark/assets/components/tabs.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
            @vite(['resources/scss/dark/plugins/notification/snackbar/custom-snackbar.scss'])
            @vite(['resources/scss/dark/assets/forms/switches.scss'])
            @vite(['resources/scss/dark/assets/components/list-group.scss'])
            @vite(['resources/scss/dark/assets/users/account-setting.scss'])

            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ $heading }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title == 'Add' ? trans('public.add') : trans('public.edit') }}</li>
                    </ol>
                </nav>
            </div>
            <!-- /BREADCRUMB -->

            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert alert-light-danger alert-dismissible fade show border-0 mt-2" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> {{ $error }} </div>
                @endforeach
            @endif

            <div class="account-settings-container layout-top-spacing">

                <div class="account-content">

                    <form action="{{ $submit }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <div class="section general-info">
                                    <div class="info">
                                        <h6 class="">@lang('public.general_info')</h6>
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-xl-2 col-lg-12 col-md-4">
                                                        <div class="profile-image">

                                                            <div class="img-uploader-content">
                                                                <input type="file" class="filepond"
                                                                       name="user_profile_photo" id="user_profile_photo" accept="image/png, image/jpeg, image/gif"/>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                        <div class="form">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="fullName">@lang('public.full_name')</label>
                                                                        <input type="text" class="form-control mb-3" id="fullName" name="user_fullname" placeholder="@lang('public.full_name')" value="{{ @$post->user_fullname }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="user_status">@lang('public.status')</label>
                                                                        {!! Form::select('user_status', $user_status_sel, @$post->user_status, ['class' => 'form-select', 'id' => 'user_status', 'placeholder' => trans('public.choose_status')]) !!}
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="user_gender">@lang('public.gender')</label>
                                                                        {!! Form::select('user_gender', $user_gender_sel, @$post->user_gender, ['class' => 'form-select', 'id' => 'user_gender', 'placeholder' => trans('public.gender')]) !!}
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="address">@lang('public.address')</label>
                                                                        <input type="text" class="form-control mb-3" id="address" name="user_address" placeholder="@lang('public.address')" value="{{ @$post->user_address }}" >
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="country">@lang('public.country')</label>
                                                                        {!! Form::select('user_nationality', $user_nationality_sel, @$post->user_nationality, ['class' => 'form-select', 'id' => 'country', 'placeholder' => trans('public.choose_country')]) !!}
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="user_phone">@lang('public.phone')</label>
                                                                        <input type="text" class="form-control mb-3" id="user_phone" name="user_phone" placeholder="+60 123456789" value="{{ @$post->user_phone }}">
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <div id="social" class="section social">
                                    <div class="info">
                                        <h5 class="">@lang('public.user_access')</h5>
                                        <div class="row">

                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group social-linkedin mb-3">
                                                            <span class="input-group-text me-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                                            </span>
                                                            <input type="text" class="form-control" name="user_email" placeholder="@lang('public.email')" aria-label="User Email" aria-describedby="user_email" value="{{ @$post->user_email }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="input-group social-linkedin mb-3">
                                                            <span class="input-group-text me-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                                                            </span>
                                                            {!! Form::select('user_role', $user_role_sel, @$post->user_role, ['class' => 'form-select', 'id' => 'user_role', 'placeholder' => trans('public.select_role')]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group social-fb mb-3">
                                                            <span class="input-group-text me-3" id="fb"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></span>
                                                            <input name="password" type="password" class="form-control" aria-label="Password" placeholder="@lang('public.password')" aria-describedby="password" maxlength="100" value="{{ @$post->password }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="input-group social-github mb-3">
                                                            <span class="input-group-text me-3" id="github"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></span>
                                                            <input name="password_confirmation" type="password" class="form-control" placeholder="@lang('public.confirm_password')" aria-label="Confirm Password" aria-describedby="confirm_password" maxlength="100" value="{{ @$post->confirm_password ?? @$post->password }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-1">
                                                    @if($title == 'Add')
                                                        <div class="form-group text-end">
                                                            <button type="submit" class="btn btn-success">@lang('public.add') @lang('public.user')</button>
                                                        </div>
                                                    @else
                                                        <div class="form-group text-end">
                                                            <button type="submit" class="btn btn-secondary">@lang('public.update')</button>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>


            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                <script src="{{asset('plugins/filepond/filepond.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginImagePreview.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginImageCrop.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginImageResize.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginImageTransform.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/filepondPluginFileValidateSize.min.js')}}"></script>

                <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>


                <script>
                    /**
                     * ==================
                     * Single File Upload
                     * ==================
                     */

                    // We register the plugins required to do
                    // image previews, cropping, resizing, etc.
                    FilePond.registerPlugin(
                        FilePondPluginFileValidateType,
                        FilePondPluginImageExifOrientation,
                        FilePondPluginImagePreview,
                        FilePondPluginImageCrop,
                        FilePondPluginImageResize,
                        FilePondPluginImageTransform,
                        //   FilePondPluginImageEdit
                    );

                    // Select the file input and use
                    // create() to turn it into a pond
                    window.userProfile = FilePond.create(
                        document.querySelector('.filepond'),
                        {
                            imagePreviewHeight: 170,
                            imageCropAspectRatio: '1:1',
                            imageResizeTargetWidth: 200,
                            imageResizeTargetHeight: 200,
                            stylePanelLayout: 'compact circle',
                            styleLoadIndicatorPosition: 'center bottom',
                            styleProgressIndicatorPosition: 'right bottom',
                            styleButtonRemoveItemPosition: 'left bottom',
                            styleButtonProcessItemPosition: 'right bottom',
                        }
                    );

                    @if($title == 'Edit')
                    const image = "{{ @$post->getFirstMediaUrl('user_profile_photo') }}";
                    if (image) {
                        userProfile.addFiles([{
                            source: image,
                            options: {
                                type: 's3' // Assuming the image is stored locally
                            }
                        }]);
                    }
                    @endif

                </script>
                <script>
                    const inputElement = document.querySelector('input[id="user_profile_photo"]');
                    const pond = FilePond.create( inputElement);

                    FilePond.setOptions({
                        server: {
                            process: '/modern-dark-menu/user/user_profile_photo_upload',
                            revert: '/modern-dark-menu/user/user_profile_photo_delete',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }
                    })
                </script>

                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
