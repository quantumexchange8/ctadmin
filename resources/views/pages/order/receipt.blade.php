<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Site Title -->
    <title>Receipt</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
<div class="tm_container">
    <div class="tm_invoice_wrap">
        <div class="tm_invoice tm_style1" id="tm_download_section">
            <div class="tm_invoice_in">
                <div class="tm_invoice_head tm_align_center tm_mb20">
                    <div class="tm_invoice_left">
                        <div class="tm_logo"><img src="{{ asset('assets/img/logo1.svg') }}" alt="Logo"></div>
                    </div>
                    <div class="tm_invoice_right tm_text_right">
                        <div class="tm_primary_color tm_f50 tm_text_uppercase">{{ $title }}</div>
                    </div>
                </div>
                <div class="tm_invoice_info tm_mb20">
                    <div class="tm_invoice_seperator tm_gray_bg"></div>
                    <div class="tm_invoice_info_list">
                        <p class="tm_invoice_number tm_m0">Receipt No: <b class="tm_primary_color">{{ $order->receipt_number }}</b></p>
                        <p class="tm_invoice_date tm_m0">Date: <b class="tm_primary_color">{{ date_format(today(), ('j M Y')) }}</b></p>
                    </div>
                </div>
                <div class="tm_invoice_head tm_mb10">
                    <div class="tm_invoice_left">
                        <p class="tm_mb2"><b class="tm_primary_color">Quotation To:</b></p>
                        <p>
                            {{ $order->user->user_fullname }} <br>
                            {{ $order->user->user_address }} <br>
                            {{ $order->user->user_email }} <br>
                            {{ $order->user->user_phone }}
                        </p>
                    </div>
                    <div class="tm_invoice_right tm_text_right">
                        <p class="tm_mb2"><b class="tm_primary_color">Pay To:</b></p>
                        <p>
                            Current Tech Industries Sdn Bhd <br>
                            VO6-03-08, Signature 2, Lingkaran SV, Sunway Velocity, <br>
                            55100 Cheras, Federal Territory of Kuala Lumpur <br>
                            support@currenttech.pro
                        </p>
                    </div>
                </div>
                <div class="tm_table tm_style1">
                    <div class="tm_round_border tm_radius_0">
                        <div class="tm_table_responsive">
                            <table>
                                <thead>
                                <tr>
                                    <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg">Item</th>
                                    <th class="tm_width_3 tm_semi_bold tm_primary_color tm_gray_bg">Description</th>
                                    <th class="tm_width_1 tm_semi_bold tm_primary_color tm_gray_bg">Qty</th>
                                    <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg">Price</th>
                                    <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg">Offer Price</th>
                                    <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg tm_text_right">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->order_item as $items)
                                    <tr class="tm_table_baseline">
                                        <td class="tm_width_2 tm_primary_color">{{ $items->order_item_name }}</td>
                                        <td class="tm_width_3">{{ $items->order_item_description ?? '-' }}</td>
                                        <td class="tm_width_1">{{ $items->order_item_quantity }}</td>
                                        <td class="tm_width_2">$ {{ $items->order_item_price }}</td>
                                        <td class="tm_width_2">$ {{ $items->order_item_offer_price }}</td>
                                        <td class="tm_width_2 tm_text_right">$ {{ $items->order_item_offer_price > 0.00 ? $items->order_item_offer_price : $items->order_item_price }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tm_invoice_footer tm_border_left tm_border_left_none_md">
                        <div class="tm_left_footer tm_padd_left_15_md">
                            <p>Order No: <b class="tm_primary_color">{{ $order->order_number }}</b></p>
                            <p class="tm_mb2"><b class="tm_primary_color">Payment note:</b></p>
                            <p class="tm_m0">Refer to details below.</p>
                        </div>
                        <div class="tm_right_footer">
                            <table>
                                <tbody>
                                <tr class="tm_gray_bg tm_border_top tm_border_left tm_border_right">
                                    <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Subtotal</td>
                                    @php
                                        $subTotal = 0;
                                    @endphp

                                    @foreach($order->order_item as $item)
                                        @php
                                            $subTotal += $item->order_item_offer_price > 0.00 ? $item->order_item_offer_price : $item->order_item_price;
                                        @endphp
                                    @endforeach

                                    <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">$ {{ $subTotal }}</td>
                                </tr>
                                <tr class="tm_gray_bg tm_border_left tm_border_right">
                                    <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Discount</td>
                                    <td class="tm_width_3 tm_text_right tm_border_none tm_pt0 tm_danger_color">-$ {{ $order->discount_amount ?? '0.00' }}</td>
                                </tr>
                                <tr class="tm_border_top tm_gray_bg tm_border_left tm_border_right">
                                    <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_primary_color">Grand Total	</td>
                                    <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_primary_color tm_text_right">$ {{ $order->order_total_price }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr class="tm_mb20">
                <div class="tm_mb20">
                    <p class="tm_mb5"><b class="tm_primary_color">Payment Info:</b></p>
                    <div class="tm_mb10">
                        <p class="tm_m0"><b>Online Transfer : </b><br>
                            Bank: Maybank <br>Account No: 1234 5678 9012 <br> Account Name: Current Tech Industries</p>
                    </div>
                    <div class="tm_mb10">
                        <p class="tm_m0">
                            For <b><u>USDT</u></b> please remit to: <br>
                            <span><u>USDT TRC20 Network</u></span> <br>
                            Wallet Address: TFC2agUu3Du5ig8cHJSdnQ2ZZvhctPEa6J <br>
                            <i>*The total amount to be sent in USDT should be equal to USD 29,400.00.</i>
                        </p>
                    </div>
                    <div class="tm_mb10">
                        <p class="tm_m0">
                            For <b><u>USDT</u></b> please remit to: <br>
                            <span><u>USDT ERC20 Network</u></span> <br>
                            Wallet Address: Ox2600d60347635828b59c97f3fdObCebE210c8cE2 <br>
                            <i>*The total amount to be sent in USDT should be equal to USD 29,400.00.</i>
                        </p>
                    </div>
                    <div class="tm_mb10">
                        <p class="tm_m0">
                            For <b><u>Bitcoin</u></b> please remit to: <br>
                            <span><u>USDT BTC Network</u></span> <br>
                            Wallet Address: 3BvTjbqWfJkfVNTjy6mRBcdz7HZvYmVtip <br>
                            <i>*The total amount to be sent in USDT should be equal to USD 29,400.00.</i>
                        </p>
                    </div>
                </div><!-- payment info -->
                <div class="tm_text_center tm_mb20" id="terms_conditions">
                    <p class="tm_mb5"><b class="tm_primary_color">Terms & Conditions:</b></p>
                    <ol class="tm_m0">
                        <li>Services provided: The quotation covers the services agreed upon between the client and the web developer, including but not limited to website design, development, and testing.</li>
                        <li>Deliverables: The deliverables shall be as specified in the quotation and may include website files, content management systems, and other software applications. The website will be delivered to the client once the full payment has been received.</li>
                        <li>Payment terms: The quotation is valid for a period of [number of days] and the full payment must be received within this period. A deposit of [percentage] of the total cost is required before work begins. The remaining balance shall be paid upon completion of the website.</li>
                        <li>Revisions: The quotation includes [number of revisions] rounds of revisions to the website design. Additional revisions may be provided at an additional cost.</li>
                        <li>Timeframe: The time required to complete the website will be specified in the quotation. The web developer will use reasonable efforts to complete the website within this timeframe, but shall not be liable for any delays caused by the client or any third party.</li>
                        <li>Intellectual property: The client will retain all intellectual property rights to the content, graphics, and other materials provided to the web developer for use in the website. The web developer retains all intellectual property rights to the website code and other materials developed by them.</li>
                        <li>Termination: Either party may terminate the agreement at any time by giving written notice to the other party. In the event of termination, the client shall pay the web developer for all services performed up to the date of termination.</li>
                        <li>Liability: The web developer shall not be liable for any damages, including but not limited to indirect or consequential damages, arising out of or in connection with the website or the services provided under this agreement.</li>
                        <li>Governing law: This agreement shall be governed by the laws of [state/province/country] and any dispute arising out of or in connection with this agreement shall be resolved in accordance with these laws.</li>
                        <li>Entire agreement: This quotation constitutes the entire agreement between the client and the web developer and supersedes all prior agreements and understandings, whether written or oral, relating to the subject matter of this agreement.</li>
                    </ol>
                </div><!-- .tm_note -->
            </div>
        </div>
        <div class="tm_invoice_btns tm_hide_print">
            <a href="javascript:window.print()" class="tm_invoice_btn tm_color1"><span class="tm_btn_icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><circle cx="392" cy="184" r="24" fill='currentColor'/></svg></span>
                <span class="tm_btn_text" style="width: 135px">Print / Save PDF</span>
            </a>
            {{--            <button id="tm_download_btn" class="tm_invoice_btn tm_color2"><span class="tm_btn_icon">--}}
            {{--            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg></span>--}}
            {{--                <span class="tm_btn_text">Download</span>--}}
            {{--            </button>--}}
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/jspdf.min.js') }}"></script>
<script src="{{ asset('assets/js/html2canvas.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
