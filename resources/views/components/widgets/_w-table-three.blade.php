{{--

/**
*
* Created a new component <x-rtl.widgets._w-table-three/>.
*
*/

--}}


<div class="widget widget-table-three">

    <div class="widget-heading">
        <h5 class="">{{$title}}</h5>
    </div>

    <div class="widget-content">
        <div class="table-responsive">
            <table class="table table-scroll">
                <thead>
                    <tr>
                        <th><div class="th-content">@lang('public.product')</div></th>
                        <th><div class="th-content th-heading">@lang('public.price')</div></th>
                        <th><div class="th-content th-heading">@lang('public.discount')</div></th>
                        <th><div class="th-content">@lang('public.sold')</div></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($topProducts as $product)
                    <tr>
                        <td>
                            <div class="td-content product-name">
                                @if($product->product->hasMedia('product_images'))
                                    <img src="{{ $product->product->getFirstMediaUrl('product_images') }}" style="object-fit: cover" alt="product">
                                @else
                                    <img src="{{ Vite::asset('resources/images/product-headphones.jpg') }}" alt="product">
                                @endif
                                <div class="align-self-center">
                                    @php
                                        $categoryColors = [
                                            1 => 'text-warning',
                                            2 => 'text-primary',
                                            3 => 'text-danger',
                                        ];
                                    @endphp
                                    <p class="prd-name">{{ $product->product->product_title }}</p>
                                    <p class="prd-category {{ $categoryColors[$product->product->category_id] }}">{{ $product->product->category->category_name }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="td-content">
                                <span class="pricing">${{ $product->product->product_price }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="td-content">
                                <span class="discount-pricing">{{ $product->product->product_offer_price }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="td-content">{{ $product->total }}</div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
