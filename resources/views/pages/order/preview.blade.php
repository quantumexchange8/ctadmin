<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            @vite(['resources/scss/light/assets/apps/invoice-preview.scss'])
            @vite(['resources/scss/dark/assets/apps/invoice-preview.scss'])
            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <div class="row invoice layout-top-spacing layout-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="doc-container">

                        <div class="row">

                            <div class="col-xl-9">

                                <div class="invoice-container">
                                    <div class="invoice-inbox">

                                        <div id="ct" class="">

                                            <div class="invoice-00001">
                                                <div class="content-section">

                                                    <div class="inv--head-section inv--detail-section">

                                                        <div class="row">

                                                            <div class="col-sm-6 col-12 mr-auto">
                                                                <div class="d-flex">
                                                                    <img class="company-logo bg-white rounded" src="{{Vite::asset('resources/images/ct-logo.png')}}" alt="company">
                                                                    <h3 class="in-heading align-self-center">Current Tech Industries</h3>
                                                                </div>
                                                                <p class="inv-street-addr mt-3">VO6-03-08, Signature 2, Lingkaran SV, Sunway Velocity, 55100 Cheras, Federal Territory of Kuala Lumpur</p>
                                                                <p class="inv-email-address">support@currenttech.pro</p>
                                                                <p class="inv-email-address">03-4819 2623</p>
                                                            </div>

                                                            <div class="col-sm-6 text-sm-end">
                                                                <p class="inv-list-number mt-sm-3 pb-sm-2 mt-4"><span class="inv-title">Order : </span> <span class="inv-number">#{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}</span></p>
                                                                <p class="inv-created-date mt-sm-5 mt-3"><span class="inv-title">Order Date : </span> <span class="inv-date">{{ date_format($order->order_created, ('j M Y')) }}</span></p>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="inv--detail-section inv--customer-detail-section">

                                                        <div class="row">

                                                            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4 align-self-center">
                                                                <p class="inv-to">Payment Info</p>
                                                            </div>

                                                            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 align-self-center order-sm-0 order-1 text-sm-end mt-sm-0 mt-5">
                                                                <h6 class=" inv-title">Customer Info</h6>
                                                            </div>

                                                            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4">
                                                                <p class="inv-customer-name">Jesse Cory</p>
                                                                <p class="inv-street-addr">1172 9091 1231</p>
                                                                <p class="inv-email-address">Maybank</p>
                                                            </div>

                                                            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-12 order-sm-0 order-1 text-sm-end">
                                                                <p class="inv-customer-name">{{ $order->user->user_fullname }}</p>
                                                                <p class="inv-street-addr">{{ $order->user->user_address }}</p>
                                                                <p class="inv-email-address">{{ $order->user->user_email }}</p>
                                                                <p class="inv-email-address">{{ $order->user->user_phone }}</p>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="inv--product-table-section">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead class="">
                                                                <tr>
                                                                    <th scope="col">No.</th>
                                                                    <th scope="col">Items</th>
                                                                    <th class="text-end" scope="col">Qty</th>
                                                                    <th class="text-end" scope="col">Price</th>
                                                                    <th class="text-end" scope="col">Offer Price</th>
                                                                    <th class="text-end" scope="col">Amount</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @php
                                                                    $no = 1
                                                                @endphp
                                                                @foreach($order->order_item as $items)
                                                                    <tr>
                                                                        <td>{{ $no }}</td>
                                                                        <td>{{ $items->order_item_name }}</td>
                                                                        <td class="text-end">{{ $items->order_item_quantity }}</td>
                                                                        <td class="text-end">$ {{ $items->order_item_price }}</td>
                                                                        <td class="text-end">$ {{ $items->order_offer_price ?? '0.00' }}</td>
                                                                        <td class="text-end">$ {{ $items->order_item_price }}</td>
                                                                    </tr>
                                                                    @php
                                                                        $no++
                                                                    @endphp
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="inv--total-amounts">

                                                        <div class="row mt-4">
                                                            <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                            </div>
                                                            <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                                <div class="text-sm-end">
                                                                    <div class="row">
                                                                        <div class="col-sm-8 col-7 grand-total-title mt-3">
                                                                            <h4 class="">Grand Total : </h4>
                                                                        </div>
                                                                        <div class="col-sm-4 col-5 grand-total-amount mt-3">
                                                                            <h4 class="">$ {{ $order->getTotalPrice() }}</h4>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="inv--note">

                                                        <div class="row mt-4">
                                                            <div class="col-sm-12 col-12 order-sm-0 order-1">
                                                                <p>Note: Thank you for doing Business with us.</p>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                        </div>


                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-3">

                                <div class="invoice-actions-btn">

                                    <div class="invoice-action-btn">

                                        <div class="row">
                                            <div class="col-xl-12 col-md-3 col-sm-6">
                                                <a href="javascript:void(0);" class="btn btn-primary btn-send">Send Invoice</a>
                                            </div>
                                            <div class="col-xl-12 col-md-3 col-sm-6">
                                                <a href="javascript:void(0);" class="btn btn-secondary btn-print action-print">Print</a>
                                            </div>
                                            <div class="col-xl-12 col-md-3 col-sm-6">
                                                <a href="javascript:void(0);" class="btn btn-success btn-download">Download</a>
                                            </div>
                                            <div class="col-xl-12 col-md-3 col-sm-6">
                                                <a href="{{ route('order_edit', $order->order_id) }}" class="btn btn-dark btn-edit">Edit</a>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                @vite(['resources/assets/js/apps/invoice-preview.js'])
                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
