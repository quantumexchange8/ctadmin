<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\TemporaryFile;
use App\Models\WebTemplateCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Session;

class ProductController extends Controller
{
    public function product_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['product_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'category_id' => $request->input('category_id'),
                        'web_template_category_id' => $request->input('web_template_category_id'),
                        'pos_system_category_id' => $request->input('pos_system_category_id'),
                        'product_status' =>  $request->input('product_status'),
                        'product_visibility' =>  $request->input('product_visibility'),
                        'order_by' =>  $request->input('order_by'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('product_search');
                    break;
            }
        }

        $search = session('product_search') ? session('product_search') : $search;

        return view('pages.product.listing', [
            'title' => 'Listing',
            'heading' => 'Product',
            'search' =>  $search,
            'records' => Product::get_record($search, 10),
            'get_visibility_sel' => [1 => 'Visible', 0 => 'Not Visible'],
            'get_status_sel' => [Product::STATUS_NORMAL => 'Normal Price', Product::STATUS_OFFER => 'Has Offer'],
            'get_order_sel' => ['asc' => 'Created Date ASC', 'desc' => 'Created Date DESC'],
            'get_category_sel' => Category::get_category_sel(),
            'get_web_template_category_sel' => WebTemplateCategory::get_web_template_category_sel(),
            'get_pos_system_category_sel' => ['cloud' => 'Cloud', 'offline' => 'Offline'],
        ]);
    }

    public function product_add(Request $request)
    {
        $validator = null;
        $post = null;
        $languages = config('translatable.locales');
        $rules = [];

        if ($request->isMethod('post')) {

            $attributeNames = [
                'product_slug' => trans('public.slug'),
                'product_price' => trans('public.price'),
                'product_visibility' => trans('public.product_visibility'),
                'product_image' => trans('public.image'),
                'category_id' => trans('public.category'),
                'web_template_category_id' => trans('public.web_template_category_id'),
                'pos_system_category_id' => trans('public.pos_system_category_id'),
            ];

            foreach ($languages as $lang) {
                $rules["{$lang}.product_title"] = 'required|max:255';
                $rules["{$lang}.product_description"] = 'required';

                $attributeNames["{$lang}.product_title"] = trans('public.product_title').' ('.trans("public.{$lang}").')';
                $attributeNames["{$lang}.product_description"] = trans('public.product_description').' ('.trans("public.{$lang}").')';
            }

            $validator = Validator::make($request->all(), $rules+[
                    'product_slug' => 'required|max:100|unique:tbl_product',
                    'category_id' => 'required|numeric',
                    'web_template_category_id' => 'required_if:category_id,2',
                    'pos_system_category_id' => 'required_if:category_id,3',
                    'product_image' => 'required',
                    'product_price' => 'required|numeric'
                ])->setAttributeNames($attributeNames);

            if (!$validator->fails()) {

                $products_data = [];

                foreach ($languages as $lang) {
                    $product_title_key = $lang . '.product_title';
                    $product_description_key = $lang . '.product_description';

                    $products_data[$lang] = [
                        'product_title' => $request->input($product_title_key),
                        'product_description' => $request->input($product_description_key),
                    ];
                }

                $product_slug = Str::slug($request->input('product_slug'), '-');
                $product_offer_price = $request->input('product_offer_price');

                $product = Product::create($products_data+[
                    'product_slug' => $product_slug,
                    'product_price' => $request->input('product_price'),
                    'product_visibility' => $request->input('product_visibility') == 'on' ? 1 : 0,
                    'category_id' => $request->input('category_id'),
                    'web_template_category_id' => $request->input('web_template_category_id'),
                    'pos_system_category_id' => $request->input('pos_system_category_id'),
                ]);

                if ($product_offer_price > 0)
                {
                    $product->update([
                        'product_offer_price' => $product_offer_price,
                        'product_status' => Product::STATUS_OFFER,
                    ]);
                }

                if ($images = $request->input('product_image')) {

                    foreach ($images as $image)
                    {
                        $temporary_file = TemporaryFile::where('temporary_file_folder', $image)->first();

                        if ($temporary_file) {
                            $product->addMedia(storage_path('app/uploads/product_image/tmp/' . $image . '/' . $temporary_file->temporary_file_name))->toMediaCollection('product_images');

                            rmdir(storage_path('app/uploads/product_image/tmp/' . $image));
                            $temporary_file->delete();
                        }
                    }
                }

                Session::flash('success_msg', 'Successfully Created Product!');
                return redirect()->route('product_listing');
            }

            $post = (object) $request->all();

        }

        return view('pages.product.form', [
            'title' => 'Add',
            'heading' => 'Product',
            'post' => $post,
            'languages' => $languages,
            'submit' => route('product_add'),
            'get_category_sel' => Category::get_category_sel(),
            'get_web_template_category_sel' => WebTemplateCategory::get_web_template_category_sel(),
            'get_pos_system_category_sel' => ['cloud' => 'Cloud', 'offline' => 'Offline'],
        ])->withErrors($validator);
    }

    public function product_edit(Request $request, $product_id)
    {
        $validator = null;
        $post = $product = Product::find($product_id);
        $languages = config('translatable.locales');
        $rules = [];

        if ($request->isMethod('post')) {
            $attributeNames = [
                'product_price' => trans('public.price'),
                'product_visibility' => trans('public.product_visibility'),
                'category_id' => trans('public.category'),
                'web_template_category_id' => trans('public.web_template_category_id'),
                'pos_system_category_id' => trans('public.pos_system_category_id'),
            ];

            foreach ($languages as $lang) {
                $rules["{$lang}.product_title"] = 'required|max:255';
                $rules["{$lang}.product_description"] = 'required';

                $attributeNames["{$lang}.product_title"] = trans('public.product_title').' ('.trans("public.{$lang}").')';
                $attributeNames["{$lang}.product_description"] = trans('public.product_description').' ('.trans("public.{$lang}").')';
            }

            $validator = Validator::make($request->all(), $rules+[
                    'category_id' => 'required|numeric',
                    'web_template_category_id' => 'required_if:category_id,2',
                    'pos_system_category_id' => 'required_if:category_id,3',
                    'product_price' => 'required|numeric'
                ])->setAttributeNames($attributeNames);

            if (!$validator->fails()) {

                $products_data = [];

                foreach ($languages as $lang) {
                    $product_title_key = $lang . '.product_title';
                    $product_description_key = $lang . '.product_description';

                    $products_data[$lang] = [
                        'product_title' => $request->input($product_title_key),
                        'product_description' => $request->input($product_description_key),
                    ];
                }

                $product_offer_price = $request->input('product_offer_price');

                $product->update($products_data+[
                        'product_price' => $request->input('product_price'),
                        'product_visibility' => $request->input('product_visibility') == 'on' ? 1 : 0,
                        'category_id' => $request->input('category_id'),
                        'web_template_category_id' => $request->input('web_template_category_id'),
                        'pos_system_category_id' => $request->input('pos_system_category_id'),
                    ]);

                if ($product_offer_price > 0)
                {
                    $product->update([
                        'product_offer_price' => $product_offer_price,
                        'product_status' => Product::STATUS_OFFER,
                    ]);
                }

                if ($images = $request->input('product_image')) {

                    $product->clearMediaCollection('product_images');

                    foreach ($images as $image)
                    {
                        $temporary_file = TemporaryFile::where('temporary_file_folder', $image)->first();

                        if ($temporary_file) {
                            $product->addMedia(storage_path('app/uploads/product_image/tmp/' . $image . '/' . $temporary_file->temporary_file_name))->toMediaCollection('product_images');

                            rmdir(storage_path('app/uploads/product_image/tmp/' . $image));
                            $temporary_file->delete();
                        }
                    }
                }

                Session::flash('success_msg', 'Successfully Updated Product!');
                return redirect()->route('product_listing');
            }

            $post = (object) $request->all();

        }

        return view('pages.product.form', [
            'title' => 'Edit',
            'heading' => 'Product',
            'post' => $post,
            'product' => $product,
            'languages' => $languages,
            'submit' => route('product_edit', $product_id),
            'get_category_sel' => Category::get_category_sel(),
            'get_web_template_category_sel' => WebTemplateCategory::get_web_template_category_sel(),
            'get_pos_system_category_sel' => ['cloud' => 'Cloud', 'offline' => 'Offline'],
        ])->withErrors($validator);
    }

    public function product_upload(Request $request)
    {
        if ($request->hasFile('product_image'))
        {

            $files = $request->file('product_image');
            if ($files)
                foreach ($files as $file)
                {
                    $filename = $file->getClientOriginalName();
                    $folder = uniqid() . '-' . now()->timestamp;
                    $file->storeAs('/uploads/product_image/tmp/' . $folder, $filename);

                    TemporaryFile::create([
                        'temporary_file_folder' => $folder,
                        'temporary_file_name' => $filename,
                    ]);

                    return $folder;

                }

        }

        return '';
    }

    public function product_image_delete()
    {
        $tmp_file = TemporaryFile::where('temporary_file_folder', request()->getContent())->first();

        if ($tmp_file)
        {
            Storage::deleteDirectory('uploads/product_image/tmp/' . $tmp_file->temporary_file_folder);
            $tmp_file->delete();

            return response('');

        }

        return '';
    }

    public function product_delete(Request $request)
    {
        $product_id = $request->input('product_id');
        $product = Product::find($product_id);

        if (!$product) {
            Session::flash('fail_msg', trans('public.invalid_product'));
            return redirect()->route('product_listing');
        }

        $product->update([
            'is_deleted' => 1,
        ]);

        Session::flash('success_msg', trans('public.successfully_deleted_product!'));
        return redirect()->route('product_listing');
    }
}
