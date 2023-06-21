<?php

namespace App\Http\Controllers;

use App\Models\SettingCountry;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Session;

class UserController extends Controller
{
    public function user_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['user_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'user_gender' =>  $request->input('user_gender'),
                        'user_nationality' =>  $request->input('user_nationality'),
                        'user_status' =>  $request->input('user_status'),
                        'order_by' =>  $request->input('order_by'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('user_search');
                    break;
            }
        }

        $search = session('user_search') ? session('user_search') : $search;

        return view('pages.user.listing', [
            'title' => trans('public.listing'),
            'heading' => trans('public.users'),
            'search' => $search,
            'records' => User::get_record($search, 10),
            'user_gender_sel'=> array('male' => trans('public.male'), 'female' => trans('public.female')),
            'user_status_sel'=> [User::STATUS_ACTIVE => 'Active', User::STATUS_INACTIVE => 'Inactive'],
            'user_nationality_sel' => SettingCountry::get_country_sel(),
            'get_order_sel' => ['asc' => trans('public.asc_create_date'), 'desc' => trans('public.desc_create_date')],
        ]);
    }

    public function user_add(Request $request)
    {
        $validator = null;
        $post = null;

        if($request->isMethod('post')){

            $validator = Validator::make($request->all(), [
                'user_email' => "required|max:100|unique:tbl_user,user_email",
                'password' => ['required', 'string', 'confirmed', Password::min(8)->letters()->mixedCase()->symbols()->numbers()],
                'user_fullname' => 'required|regex:/^[a-zA-Z0-9\p{Han}. -_]+$/u|max:100',
                'user_gender' => 'required',
                'user_role' => 'required',
                'user_address' => 'required',
                'user_nationality' => 'required',
                'user_phone' => 'required',
                'user_status' => 'required',
            ])->setAttributeNames([
                'user_email' => trans('public.email'),
                'password' => trans('public.password'),
                'user_fullname' => trans('public.full_name'),
                'user_gender' => trans('public.gender'),
                'user_role' => trans('public.role'),
                'user_address' => trans('public.address'),
                'user_phone' => trans('public.phone'),
                'user_nationality' => trans('public.country'),
                'user_status' => trans('public.status'),
            ]);

            if (!$validator->fails()) {
                $user = User::create([
                    'user_email' => $request->input('user_email'),
                    'password' => Hash::make($request->input('password')),
                    'user_fullname' => $request->input('user_fullname'),
                    'user_gender' => $request->input('user_gender'),
                    'user_nationality' => $request->input('user_nationality'),
                    'user_address' => $request->input('user_address'),
                    'user_phone' => $request->input('user_phone'),
                    'role_as' => $request->input('role_as'),
                    'user_status' => $request->input('user_status'),
                ]);

                if ($request->input('user_profile_photo')) {
                    $temporary_file = TemporaryFile::where('temporary_file_folder', $request->user_profile_photo)->first();
                    if ($temporary_file) {
                        $user->addMedia(storage_path('app/uploads/user_profile_photo/tmp/' . $request->user_profile_photo . '/' . $temporary_file->temporary_file_name))->toMediaCollection('user_profile_photo');

                        rmdir(storage_path('app/uploads/user_profile_photo/tmp/' . $request->user_profile_photo));
                        $temporary_file->delete();
                    }
                }

                Session::flash('success_msg', trans('public.success_created_user', ['user_fullname' => $request->input('user_fullname')]));
                return redirect()->route('user_listing');
            }
            $post = (object) $request->all();
        }
        return view('pages.user.form', [
            'submit'=> route('user_add'),
            'heading'=> trans('public.users'),
            'title'=> 'Add',
            'post'=> $post,
            'user_gender_sel'=> array('male' => trans('public.male'), 'female' => trans('public.female')),
            'user_role_sel'=> [User::ADMIN_ROLE => trans('public.admin'), User::USER_ROLE => trans('public.user')],
            'user_status_sel'=> [User::STATUS_ACTIVE => trans('public.active'), User::STATUS_INACTIVE => trans('public.inactive')],
            'user_nationality_sel' => SettingCountry::get_country_sel(),
        ])->withErrors($validator);
    }

    public function user_edit(Request $request, $user_id)
    {
        $validator = null;
        $post = User::find($user_id);
        $user = User::find($user_id);

        if(!$user){
            Session::flash('fail_msg', 'Invalid user, Please try again later.');
            return redirect()->route('user_listing');
        }

        $post->password = 'X123.xxxx';

        if($request->isMethod('post')){

            $validator = Validator::make($request->all(), [
                'user_email' => "required|max:100|unique:tbl_user,user_email,{$user_id},user_id",
                'password' => ['required', 'string', 'confirmed', Password::min(8)->letters()->mixedCase()->symbols()->numbers()],
                'user_fullname' => 'required|regex:/^[a-zA-Z0-9\p{Han}. -_]+$/u|max:100',
                'user_gender' => 'required',
                'user_role' => 'required',
                'user_address' => 'required',
                'user_nationality' => 'required',
                'user_phone' => 'required',
                'user_status' => 'required',
            ])->setAttributeNames([
                'user_email' => trans('public.email'),
                'password' => trans('public.password'),
                'user_fullname' => trans('public.full_name'),
                'user_gender' => trans('public.gender'),
                'user_role' => trans('public.role'),
                'user_address' => trans('public.address'),
                'user_phone' => trans('public.phone'),
                'user_nationality' => trans('public.country'),
                'user_status' => trans('public.status'),
            ]);

            if (!$validator->fails()) {
                $update_detail = [
                    'user_email' => $request->input('user_email'),
                    'user_fullname' => $request->input('user_fullname'),
                    'user_gender' => $request->input('user_gender'),
                    'user_nationality' => $request->input('user_nationality'),
                    'user_address' => $request->input('user_address'),
                    'user_phone' => $request->input('user_phone'),
                    'role_as' => $request->input('role_as'),
                    'user_status' => $request->input('user_status'),
                ];
                if ($request->input('password') != 'X123.xxxx') {
                    $update_detail['password'] = Hash::make($request->input('password'));
                }
                $user->update($update_detail);

                if ($request->input('user_profile_photo')) {
                    $temporary_file = TemporaryFile::where('temporary_file_folder', $request->user_profile_photo)->first();
                    if ($temporary_file) {
                        $user->clearMediaCollection('user_profile_photo');
                        $user->addMedia(storage_path('app/uploads/user_profile_photo/tmp/' . $request->user_profile_photo . '/' . $temporary_file->temporary_file_name))->toMediaCollection('user_profile_photo');

                        rmdir(storage_path('app/uploads/user_profile_photo/tmp/' . $request->user_profile_photo));
                        $temporary_file->delete();
                    }
                }

                Session::flash('success_msg', trans('public.success_updated_user', ['user_fullname' => $request->input('user_fullname')]));

                return redirect()->route('user_listing');
            }
            $post = (object) $request->all();
        }
        return view('pages.user.form', [
            'submit'=>route('user_edit', $user_id),
            'title' => 'Edit',
            'heading' => trans('public.users'),
            'post'=> $post,
            'user' => $user,
            'user_gender_sel'=> array('male' => trans('public.male'), 'female' => trans('public.female')),
            'user_role_sel'=> [User::ADMIN_ROLE => trans('public.admin'), User::USER_ROLE => trans('public.user')],
            'user_status_sel'=> [User::STATUS_ACTIVE => trans('public.active'), User::STATUS_INACTIVE => trans('public.inactive')],
            'user_nationality_sel' => SettingCountry::get_country_sel(),
        ])->withErrors($validator);
    }

    public function user_profile_photo_upload(Request $request)
    {
        if ($request->hasFile('user_profile_photo'))
        {
            $file = $request->file('user_profile_photo');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('/uploads/user_profile_photo/tmp/' . $folder, $filename);

            TemporaryFile::create([
                'temporary_file_folder' => $folder,
                'temporary_file_name' => $filename,
            ]);

            return $folder;
        }

        return '';
    }

    public function user_profile_photo_delete()
    {
        $tmp_file = TemporaryFile::where('temporary_file_folder', request()->getContent())->first();

        if ($tmp_file)
        {
            Storage::deleteDirectory('uploads/user_profile_photo/tmp/' . $tmp_file->temporary_file_folder);
            $tmp_file->delete();

            return response('');

        }

        return '';
    }

    public function user_delete(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);

        if (!$user) {
            Session::flash('fail_msg', trans('public.invalid_action'));
            return redirect()->route('user_listing');
        }

        $user->update([
            'is_deleted' => 1,
            'user_status' => User::STATUS_INACTIVE
        ]);

        Session::flash('success_msg', trans('public.success_deleted_user'));
        return redirect()->route('user_listing');
    }
}
