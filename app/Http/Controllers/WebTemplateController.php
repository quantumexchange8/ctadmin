<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\TemporaryFile;
use App\Models\WebTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Session;

class WebTemplateController extends Controller
{
    public function web_template_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['web_template_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'category_id' =>  $request->input('category_id'),
                        'web_template_visibility' =>  $request->input('web_template_visibility'),
                        'order_by' =>  $request->input('order_by'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('web_template_search');
                    break;
            }
        }

        $search = session('web_template_search') ? session('web_template_search') : $search;

        return view('pages.web_template.listing', [
            'title' => 'Listing',
            'heading' => 'Web Template',
            'search' =>  $search,
            'get_category_sel' => Category::get_category_sel(),
            'get_status_sel' => [1 => 'Visible', 0 => 'Not Visible'],
            'get_order_sel' => ['asc' => 'Created Date ASC', 'desc' => 'Created Date DESC'],
            'records' => WebTemplate::get_record($search, 10),
        ]);
    }

    public function web_template_add(Request $request)
    {
        $validator = null;
        $post = null;
        $languages = config('translatable.locales');
        $rules = [];

        if ($request->isMethod('post')) {
            $attributeNames = [
                'web_template_slug' => trans('public.slug'),
                'category_id' => trans('public.category'),
                'web_template_image' => trans('public.image'),
                'web_template_price' => trans('public.web_template_price'),
            ];

            foreach ($languages as $lang) {
                $rules["{$lang}.web_template_name"] = 'required';
                $rules["{$lang}.web_template_description"] = 'required';

                $attributeNames["{$lang}.web_template_name"] = trans('public.web_template_name').' ('.trans("public.{$lang}").')';
                $attributeNames["{$lang}.web_template_description"] = trans('public.web_template_description').' ('.trans("public.{$lang}").')';
            }

            $validator = Validator::make($request->all(), $rules+[
                    'web_template_slug' => 'required|max:100',
                    'category_id' => 'required|numeric',
                    'web_template_image' => 'required',
                    'web_template_price' => 'required|numeric'
                ])->setAttributeNames($attributeNames);

            if (!$validator->fails()) {

                $categories_data = [];

                foreach ($languages as $lang) {
                    $web_template_name_key = $lang . '.web_template_name';
                    $web_template_description_key = $lang . '.web_template_description';

                    $categories_data[$lang] = [
                        'web_template_name' => $request->input($web_template_name_key),
                        'web_template_description' => $request->input($web_template_description_key),
                    ];
                }

                $web_template_slug = Str::slug($request->input('web_template_slug'), '-');
                $web_template_offer_price = $request->input('web_template_offer_price');

                $web_template = WebTemplate::create($categories_data+[
                        'web_template_slug' => $web_template_slug,
                        'category_id' => $request->input('category_id'),
                        'web_template_visibility' => $request->input('web_template_visibility') == 'on' ? 1 : 0,
                        'web_template_price' => $request->input('web_template_price'),
                        'user_id' => Auth::user()->user_id,
                    ]);

                if ($web_template_offer_price > 0)
                {
                    $web_template->update([
                        'web_template_offer_price' => $web_template_offer_price,
                        'web_template_status' => WebTemplate::STATUS_OFFER,
                    ]);
                }

                if ($images = $request->input('web_template_image')) {
                    foreach ($images as $image)
                    {
                        $temporary_file = TemporaryFile::where('temporary_file_folder', $image)->first();

                        if ($temporary_file) {
                            $web_template->addMedia(storage_path('app/uploads/web_template_image/tmp/' . $image . '/' . $temporary_file->temporary_file_name))->toMediaCollection('web_template_images');

                            rmdir(storage_path('app/uploads/web_template_image/tmp/' . $image));
                            $temporary_file->delete();
                        }
                    }

                }

                Session::flash('success_msg', 'Successfully Created Web Template!');
                return redirect()->route('web_template_listing');
            }

            $post = (object) $request->all();

        }

        return view('pages.web_template.form', [
            'title' => 'Add',
            'heading' => 'Web Template',
            'submit' => route('web_template_add'),
            'post' => $post,
            'languages' => $languages,
            'get_category_sel' => Category::get_category_sel(),
        ])->withErrors($validator);
    }

    public function web_template_edit(Request $request, $web_template_id)
    {
        $validator = null;
        $post = $web_template = WebTemplate::find($web_template_id);
        $languages = config('translatable.locales');
        $rules = [];

        if ($request->isMethod('post')) {
            $attributeNames = [
                'category_id' => trans('public.category'),
                'web_template_price' => trans('public.web_template_price'),
            ];

            foreach ($languages as $lang) {
                $rules["{$lang}.web_template_name"] = 'required';
                $rules["{$lang}.web_template_description"] = 'required';

                $attributeNames["{$lang}.web_template_name"] = trans('public.web_template_name').' ('.trans("public.{$lang}").')';
                $attributeNames["{$lang}.web_template_description"] = trans('public.web_template_description').' ('.trans("public.{$lang}").')';
            }

            $validator = Validator::make($request->all(), $rules+[
                    'category_id' => 'required',
                    'web_template_price' => 'required|numeric|gt:0'
                ])->setAttributeNames($attributeNames);

            if (!$validator->fails()) {

                $categories_data = [];

                foreach ($languages as $lang) {
                    $web_template_name_key = $lang . '.web_template_name';
                    $web_template_description_key = $lang . '.web_template_description';

                    $categories_data[$lang] = [
                        'web_template_name' => $request->input($web_template_name_key),
                        'web_template_description' => $request->input($web_template_description_key),
                    ];
                }

                $web_template_offer_price = $request->input('web_template_offer_price');

                $web_template->update($categories_data+[
                    'category_id' => $request->input('category_id'),
                    'web_template_visibility' => $request->input('web_template_visibility') == 'on' ? 1 : 0,
                    'web_template_price' => $request->input('web_template_price'),
                    'web_template_offer_price' => 0,
                    'web_template_status' => WebTemplate::STATUS_NORMAL,
                ]);

                if ($web_template_offer_price > 0)
                {
                    $web_template->update([
                        'web_template_offer_price' => $web_template_offer_price,
                        'web_template_status' => WebTemplate::STATUS_OFFER,
                    ]);
                }

                if ($images = $request->input('web_template_image')) {
                    $web_template->clearMediaCollection('web_template_images');
                    foreach ($images as $image)
                    {
                        $temporary_file = TemporaryFile::where('temporary_file_folder', $image)->first();

                        if ($temporary_file) {
                            $web_template->addMedia(storage_path('app/uploads/web_template_image/tmp/' . $image . '/' . $temporary_file->temporary_file_name))->toMediaCollection('web_template_images');

                            rmdir(storage_path('app/uploads/web_template_image/tmp/' . $image));
                            $temporary_file->delete();
                        }
                    }

                }

                Session::flash('success_msg', 'Successfully Updated Web Template!');
                return redirect()->route('web_template_listing');
            }

            $post = (object) $request->all();

        }

        return view('pages.web_template.form', [
            'title' => 'Edit',
            'heading' => 'Category',
            'submit' => route('web_template_edit', $web_template_id),
            'post' => $post,
            'web_template' => $web_template,
            'languages' => $languages,
            'get_category_sel' => Category::get_category_sel(),
        ])->withErrors($validator);
    }

    public function web_template_upload(Request $request)
    {
        if ($request->hasFile('web_template_image'))
        {
            $files = $request->file('web_template_image');
            if ($files)
                foreach ($files as $file)
                {
                    $filename = $file->getClientOriginalName();
                    $folder = uniqid() . '-' . now()->timestamp;
                    $file->storeAs('/uploads/web_template_image/tmp/' . $folder, $filename);

                    TemporaryFile::create([
                        'temporary_file_folder' => $folder,
                        'temporary_file_name' => $filename,
                    ]);

                    return $folder;

                }

        }

        return '';
    }

    public function web_template_image_delete()
    {
        $tmp_file = TemporaryFile::where('temporary_file_folder', request()->getContent())->first();

        if ($tmp_file)
        {
            Storage::deleteDirectory('uploads/web_template_image/tmp/' . $tmp_file->temporary_file_folder);
            $tmp_file->delete();

            return response('');

        }

        return '';
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
}
