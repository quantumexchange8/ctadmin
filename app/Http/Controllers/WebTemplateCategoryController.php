<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TemporaryFile;
use App\Models\WebTemplateCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Session;

class WebTemplateCategoryController extends Controller
{
    public function web_template_category_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['web_template_category_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'web_template_category_group' =>  $request->input('web_template_category_group'),
                        'web_template_category_status' =>  $request->input('web_template_category_status'),
                        'order_by' =>  $request->input('order_by'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('web_template_category_search');
                    break;
            }
        }

        $search = session('web_template_category_search') ? session('web_template_category_search') : $search;

        return view('pages.web_template_category.listing', [
            'title' => 'Listing',
            'heading' => 'Web Template Category',
            'search' =>  $search,
            'get_category_group_sel' => ['Basic' => 'Basic', 'Finance' => 'Finance'],
            'get_status_sel' => [1 => 'Visible', 0 => 'Not Visible'],
            'get_order_sel' => ['asc' => 'Created Date ASC', 'desc' => 'Created Date DESC'],
            'records' => WebTemplateCategory::get_record($search, 10),
        ]);
    }

    public function web_template_category_add(Request $request)
    {
        $validator = null;
        $post = null;
        $languages = config('translatable.locales');
        $rules = [];

        if ($request->isMethod('post')) {
            $attributeNames = [
                'web_template_category_slug' => trans('public.slug'),
                'category_id' => trans('public.category'),
                'web_template_category_group' => trans('public.web_template_category_group'),
                'web_template_category_image' => trans('public.image'),
            ];

            foreach ($languages as $lang) {
                $rules["{$lang}.web_template_category_name"] = 'required';

                $attributeNames["{$lang}.web_template_category_name"] = trans('public.web_template_category_name').' ('.trans("public.{$lang}").')';
            }

            $validator = Validator::make($request->all(), $rules+[
                    'web_template_category_slug' => 'required|max:100|unique:tbl_web_template_category',
                    'category_id' => 'required|numeric',
                    'web_template_category_group' => 'required',
                    'web_template_category_image' => 'required',
                ])->setAttributeNames($attributeNames);

            if (!$validator->fails()) {

                $categories_data = [];

                foreach ($languages as $lang) {
                    $web_template_category_name_key = $lang . '.web_template_category_name';

                    $categories_data[$lang] = [
                        'web_template_category_name' => $request->input($web_template_category_name_key),
                    ];
                }

                $web_template_category_slug = Str::slug($request->input('web_template_category_slug'), '-');

                $web_template_category = WebTemplateCategory::create($categories_data+[
                        'web_template_category_slug' => $web_template_category_slug,
                        'category_id' => $request->input('category_id'),
                        'web_template_category_group' => $request->input('web_template_category_group'),
                        'web_template_category_status' => $request->input('web_template_category_status') == 'on' ? 1 : 0,
                    ]);

                if ($image = $request->input('web_template_category_image')) {
                    $temporary_file = TemporaryFile::where('temporary_file_folder', $image)->first();

                    if ($temporary_file) {
                        $web_template_category->addMedia(storage_path('app/uploads/web_template_category_image/tmp/' . $image . '/' . $temporary_file->temporary_file_name))->toMediaCollection('web_template_category_images');

                        rmdir(storage_path('app/uploads/web_template_category_image/tmp/' . $image));
                        $temporary_file->delete();
                    }
                }

                Session::flash('success_msg', 'Successfully Created Web Template!');
                return redirect()->route('web_template_category_listing');
            }

            $post = (object) $request->all();

        }

        return view('pages.web_template_category.form', [
            'title' => 'Add',
            'heading' => 'Web Template Category',
            'submit' => route('web_template_category_add'),
            'post' => $post,
            'languages' => $languages,
            'get_category_sel' => Category::get_category_sel(),
            'get_category_group_sel' => ['Basic' => 'Basic', 'Finance' => 'Finance'],
        ])->withErrors($validator);
    }

    public function web_template_category_edit(Request $request, $web_template_category_id)
    {
        $validator = null;
        $post = $web_template_category = WebTemplateCategory::find($web_template_category_id);
        $languages = config('translatable.locales');
        $rules = [];

        if ($request->isMethod('post')) {
            $attributeNames = [
                'category_id' => trans('public.category'),
                'web_template_category_group' => trans('public.web_template_category_group'),
            ];

            foreach ($languages as $lang) {
                $rules["{$lang}.web_template_category_name"] = 'required';

                $attributeNames["{$lang}.web_template_category_name"] = trans('public.web_template_category_name').' ('.trans("public.{$lang}").')';
            }

            $validator = Validator::make($request->all(), $rules+[
                    'category_id' => 'required',
                    'web_template_category_group' => 'required',
                ])->setAttributeNames($attributeNames);

            if (!$validator->fails()) {

                $categories_data = [];

                foreach ($languages as $lang) {
                    $web_template_category_name_key = $lang . '.web_template_category_name';

                    $categories_data[$lang] = [
                        'web_template_category_name' => $request->input($web_template_category_name_key),
                    ];
                }

                $web_template_category->update($categories_data+[
                        'category_id' => $request->input('category_id'),
                        'web_template_category_group' => $request->input('web_template_category_group'),
                        'web_template_category_status' => $request->input('web_template_category_status') == 'on' ? 1 : 0,
                    ]);

                if ($image = $request->input('web_template_category_image')) {
                    $web_template_category->clearMediaCollection('web_template_category_images');
                    $temporary_file = TemporaryFile::where('temporary_file_folder', $image)->first();

                    if ($temporary_file) {
                        $web_template_category->addMedia(storage_path('app/uploads/web_template_category_image/tmp/' . $image . '/' . $temporary_file->temporary_file_name))->toMediaCollection('web_template_category_images');

                        rmdir(storage_path('app/uploads/web_template_category_image/tmp/' . $image));
                        $temporary_file->delete();
                    }

                }

                Session::flash('success_msg', 'Successfully Updated Web Template!');
                return redirect()->route('web_template_category_listing');
            }

            $post = (object) $request->all();

        }

        return view('pages.web_template_category.form', [
            'title' => 'Edit',
            'heading' => 'Web Template Category',
            'submit' => route('web_template_category_edit', $web_template_category_id),
            'post' => $post,
            'web_template_category' => $web_template_category,
            'languages' => $languages,
            'get_category_sel' => Category::get_category_sel(),
            'get_category_group_sel' => ['Basic' => 'Basic', 'Finance' => 'Finance'],
        ])->withErrors($validator);
    }

    public function web_template_delete(Request $request)
    {
        $web_template_id = $request->input('web_template_id');
        $web_template = WebTemplate::find($web_template_id);

        if (!$web_template) {
            Session::flash('fail_msg', trans('public.invalid_web_template'));
            return redirect()->route('web_template_listing');
        }

        $web_template->update([
            'is_deleted' => 1,
        ]);

        Session::flash('success_msg', trans('public.successfully_deleted_web_template!'));
        return redirect()->route('web_template_listing');
    }
    public function web_template_category_upload(Request $request)
    {
        if ($request->hasFile('web_template_category_image'))
        {
            $file = $request->file('web_template_category_image');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('/uploads/web_template_category_image/tmp/' . $folder, $filename);

            TemporaryFile::create([
                'temporary_file_folder' => $folder,
                'temporary_file_name' => $filename,
            ]);

            return $folder;
        }

        return '';
    }

    public function web_template_category_image_delete()
    {
        $tmp_file = TemporaryFile::where('temporary_file_folder', request()->getContent())->first();

        if ($tmp_file)
        {
            Storage::deleteDirectory('uploads/web_template_category_image/tmp/' . $tmp_file->temporary_file_folder);
            $tmp_file->delete();

            return response('');

        }

        return '';
    }
}
