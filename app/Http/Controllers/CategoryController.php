<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Session;

class CategoryController extends Controller
{
    public function category_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['category_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'product_id' =>  $request->input('product_id'),
                        'category_status' =>  $request->input('category_status'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('category_search');
                    break;
            }
        }

        $search = session('category_search') ? session('category_search') : $search;

        return view('pages.category.listing', [
            'title' => 'Listing',
            'heading' => 'Category',
            'search' =>  $search,
            'get_product_sel' => Product::get_product_sel(),
            'get_status_sel' => [1 => 'Visible', 0 => 'Not Visible'],
            'records' => Category::get_record($search, 10),
        ]);
    }

    public function category_add(Request $request)
    {
        $validator = null;
        $post = null;
        $languages = config('translatable.locales');
        $rules = [];

        if ($request->isMethod('post')) {
            $attributeNames = [
                'category_image' => trans('public.category_image'),
                'category_slug' => trans('public.slug'),
            ];

            foreach ($languages as $lang) {
                $rules["{$lang}.category_name"] = 'required';
                $rules["{$lang}.category_caption"] = 'required';
                $rules["{$lang}.category_description"] = 'required';

                $attributeNames["{$lang}.category_name"] = trans('public.category_name').' ('.trans("public.{$lang}").')';
                $attributeNames["{$lang}.category_caption"] = trans('public.category_caption').' ('.trans("public.{$lang}").')';
                $attributeNames["{$lang}.category_description"] = trans('public.category_description').' ('.trans("public.{$lang}").')';
            }

            $validator = Validator::make($request->all(), $rules+[
                'category_image' => 'required' ,
                'category_slug' => 'required|max:100|unique:tbl_category',
            ])->setAttributeNames($attributeNames);

            if (!$validator->fails()) {

                $categories_data = [];

                foreach ($languages as $lang) {
                    $category_name_key = $lang . '.category_name';
                    $category_caption_key = $lang . '.category_caption';
                    $category_description_key = $lang . '.category_description';

                    $categories_data[$lang] = [
                        'category_name' => $request->input($category_name_key),
                        'category_caption' => $request->input($category_caption_key),
                        'category_description' => $request->input($category_description_key),
                    ];
                }

                $category_slug = Str::slug($request->input('category_slug'), '-');

                $category = Category::create($categories_data+[
                    'category_slug' => $category_slug,
                    'category_status' => $request->input('category_status') == 'on' ? 1 : 0,
                ]);

                if ($request->input('category_image')) {
                    $temporary_file = TemporaryFile::where('temporary_file_folder', $request->category_image)->first();
                    if ($temporary_file) {
                        $category->addMedia(storage_path('app/uploads/category_image/tmp/' . $request->category_image . '/' . $temporary_file->temporary_file_name))->toMediaCollection('category_image');

                        rmdir(storage_path('app/uploads/category_image/tmp/' . $request->category_image));
                        $temporary_file->delete();
                    }
                }

                Session::flash('success_msg', 'Successfully Created Category!');
                return redirect()->route('category_listing');
            }

            $post = (object) $request->all();

        }

        return view('pages.category.form', [
            'title' => 'Add',
            'heading' => 'Category',
            'submit' => route('category_add'),
            'post' => $post,
            'languages' => $languages,
        ])->withErrors($validator);
    }

    public function category_edit(Request $request, $category_id)
    {
        $validator = null;
        $post = $category = Category::find($category_id);
        $languages = config('translatable.locales');
        $rules = [];

        if ($request->isMethod('post')) {
            foreach ($languages as $lang) {
                $rules["{$lang}.category_name"] = 'required';
                $rules["{$lang}.category_caption"] = 'required';
                $rules["{$lang}.category_description"] = 'required';

                $attributeNames["{$lang}.category_name"] = trans('public.category_name').' ('.trans("public.{$lang}").')';
                $attributeNames["{$lang}.category_caption"] = trans('public.category_caption').' ('.trans("public.{$lang}").')';
                $attributeNames["{$lang}.category_description"] = trans('public.category_description').' ('.trans("public.{$lang}").')';
            }

            $validator = Validator::make($request->all(), $rules)->setAttributeNames($attributeNames);

            if (!$validator->fails()) {

                $categories_data = [];

                foreach ($languages as $lang) {
                    $category_name_key = $lang . '.category_name';
                    $category_caption_key = $lang . '.category_caption';
                    $category_description_key = $lang . '.category_description';

                    $categories_data[$lang] = [
                        'category_name' => $request->input($category_name_key),
                        'category_caption' => $request->input($category_caption_key),
                        'category_description' => $request->input($category_description_key),
                    ];
                }

                $category->update($categories_data+[
                        'category_status' => $request->input('category_status') == 'on' ? 1 : 0,
                    ]);

                if ($request->input('category_image')) {
                    $temporary_file = TemporaryFile::where('temporary_file_folder', $request->category_image)->first();
                    if ($temporary_file) {
                        $category->clearMediaCollection('category_image');
                        $category->addMedia(storage_path('app/uploads/category_image/tmp/' . $request->category_image . '/' . $temporary_file->temporary_file_name))->toMediaCollection('category_image');

                        rmdir(storage_path('app/uploads/category_image/tmp/' . $request->category_image));
                        $temporary_file->delete();
                    }
                }

                Session::flash('success_msg', 'Successfully Updated Category!');
                return redirect()->route('category_listing');
            }

            $post = (object) $request->all();

        }

        return view('pages.category.form', [
            'title' => 'Edit',
            'heading' => 'Category',
            'submit' => route('category_edit', $category_id),
            'post' => $post,
            'category' => $category,
            'languages' => $languages,
        ])->withErrors($validator);
    }

    public function category_upload(Request $request)
    {
        if ($request->hasFile('category_image'))
        {
            $file = $request->file('category_image');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('/uploads/category_image/tmp/' . $folder, $filename);

            TemporaryFile::create([
                'temporary_file_folder' => $folder,
                'temporary_file_name' => $filename,
            ]);

            return $folder;
        }

        return '';
    }

    public function category_image_delete()
    {
        $tmp_file = TemporaryFile::where('temporary_file_folder', request()->getContent())->first();

        if ($tmp_file)
        {
            Storage::deleteDirectory('uploads/category_image/tmp/' . $tmp_file->temporary_file_folder);
            $tmp_file->delete();

            return response('');

        }

        return '';
    }

    public function category_delete(Request $request)
    {
        $category_id = $request->input('category_id');
        $category = Category::find($category_id);

        if (!$category) {
            Session::flash('fail_msg', trans('public.invalid_category'));
            return redirect()->route('category_listing');
        }

        $category->update([
            'is_deleted' => 1,
        ]);

        Session::flash('success_msg', trans('public.successfully_deleted_category!'));
        return redirect()->route('category_listing');
    }
}
