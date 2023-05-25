<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{{ $heading }}} {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/filepond/filepond.min.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">
            <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
            @vite(['resources/scss/light/plugins/filepond/custom-filepond.scss'])
            @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
            @vite(['resources/scss/light/assets/apps/invoice-add.scss'])
            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])

            @vite(['resources/scss/dark/plugins/filepond/custom-filepond.scss'])
            @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])
            @vite(['resources/scss/dark/assets/apps/invoice-add.scss'])
            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <div class="row invoice layout-top-spacing layout-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="doc-container">
                        <form action="{{ route('order_edit', $order->order_id) }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-xl-9">

                                    <div class="invoice-content">

                                        <div class="invoice-detail-body">

                                            <div class="invoice-detail-title">

                                                <div class="invoice-logo">
                                                    <div class="img-uploader-content d-flex justify-content-center">
                                                        <div class="d-flex">
                                                            <img class="company-logo" src="{{Vite::asset('resources/images/ct-logo2.png')}}" style="width: 100px; height: 100px" alt="company">
                                                            <h3 class="in-heading align-self-center">Current Tech Industries</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="invoice-detail-header">

                                                <div class="row">

                                                    <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4 align-self-center">
                                                        <h5 class="inv-to">Customer Details</h5>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 align-self-center order-sm-0 order-1 text-sm-end mt-sm-0 mt-5">
                                                        <h5 class=" inv-title"><span>Order : </span> <span class="inv-number">#{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}</span></h5>
                                                    </div>

                                                    <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4">
                                                        <p class="inv-customer-name">{{ $order->user->user_fullname }}</p>
                                                        <p class="inv-street-addr">{{ $order->user->user_address }}</p>
                                                        <p class="inv-email-address">{{ $order->user->user_email }}</p>
                                                        <p class="inv-email-address">{{ $order->user->user_phone }}</p>
                                                    </div>


                                                </div>

                                            </div>

                                            <div class="invoice-detail-items">

                                                <div class="table-responsive">
                                                    <table class="table item-table">
                                                        <thead>
                                                        <tr>
                                                            <th class=""></th>
                                                            <th>Description</th>
                                                            <th class="">Qty</th>
                                                            <th class="">Price</th>
                                                            <th class="">Offer</th>
                                                            <th class="text-right">Amount</th>
                                                        </tr>
                                                        <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                                                        </thead>
                                                        <tbody>

                                                        @foreach($order->order_item as $item)
                                                            <tr data-order-item-id="{{ $item->order_item_id }}">
                                                                <td class="delete-item-row">
                                                                    <ul class="table-controls">
                                                                        <li><a href="javascript:void(0);" class="remove-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a></li>
                                                                    </ul>
                                                                </td>
                                                                <td class="description"><input type="text" class="form-control form-control-sm" placeholder="Item Description" value="{{ $item->order_item_name ?? $item->product->product_title }}" name="order_item_name[]"> <textarea class="form-control" placeholder="Additional Details" name="order_item_description[]">{{ $item->order_item_description }}</textarea></td>
                                                                <td class="text-right qty"><input type="number" class="form-control form-control-sm" min="1" id="quantity" placeholder="Quantity" value="{{ $item->order_item_quantity }}"></td>
                                                                <td class="text-right rate"><input type="text" class="form-control form-control-sm" name="order_item_price[]" id='order_item_price' value="{{ $item->order_item_price ?? $item->product->product_price }}"></td>
                                                                <td class="text-right rate mt-2"><input type="text" class="form-control form-control-sm" name="order_item_offer_price[]" id='offer_price' value="{{ $item->order_item_offer_price ?? "0.00" }}"></td>
                                                                <td class="text-right rate mt-2"><input type="text" class="form-control form-control-sm subtotal" value="{{ $item->order_item_offer_price == 0.00 ? $item->order_item_price : $item->order_item_offer_price }}"></td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <a class="btn btn-dark add-item">Add Item</a>

                                            </div>

                                            <div class="invoice-detail-total">

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <div class="form-group row invoice-created-by">
                                                            <label for="payment-method-account" class="col-sm-3 col-form-label col-form-label-sm">Account #:</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-sm" id="payment-method-account" placeholder="Bank Account Number" value="1234567890">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row invoice-created-by">
                                                            <label for="payment-method-bank-name" class="col-sm-3 col-form-label col-form-label-sm">Bank Name:</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-sm" id="payment-method-bank-name" placeholder="Insert Bank Name" value="Bank of America">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="totals-row">
                                                            <div class="invoice-totals-row invoice-summary-subtotal">

                                                                <div class="invoice-summary-label">Subtotal</div>

                                                                <div class="invoice-summary-value">
                                                                    <div class="subtotal-amount">
                                                                        <span class="currency">RM </span><span class="subtotal-amount">{{ $order->getSubTotal() }}</span>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                            <div class="invoice-totals-row invoice-summary-total">

                                                                <div class="invoice-summary-label">Discount</div>

                                                                <div class="invoice-summary-value">
                                                                    <div class="total-amount">
                                                                        <span class="currency">RM </span><span id="discount_value">{{ $order->discount_amount ?? '0.00' }}</span>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="invoice-totals-row invoice-summary-balance-due">

                                                                <div class="invoice-summary-label">Total</div>

                                                                <div class="invoice-summary-value">
                                                                    <div class="balance-due-amount">
                                                                        <div>
                                                                            <input id="total-value" name="order_total_price" class="form-control form-control-sm" value="{{ $order->order_total_price }}" data-inputmask="'alias': 'numeric', 'digits' : '2', 'groupSeperator' : ',', 'autoGroup' : true, 'digitsOptional': false, 'removeMaskOnSubmit': true">
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

                                <div class="col-xl-3">

                                    <div class="invoice-actions">

                                        <div class="invoice-action-discount mt-0 pt-0">

                                            <h5>Discount</h5>

                                            <div class="invoice-action-discount-fields">

                                                <div class="row">

                                                    <div class="col-12">
                                                        <div class="form-group mb-0 discount-amount">
                                                            <label for="discount_amount">Amount</label>
                                                            <input id="discount_amount" name="discount_amount" class="form-control form-control-sm" value="{{ @$order->discount_amount }}" data-inputmask="'alias': 'numeric', 'digits' : '2', 'groupSeperator' : ',', 'autoGroup' : true, 'digitsOptional': false, 'removeMaskOnSubmit': true">
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="invoice-actions-btn">

                                        <div class="invoice-action-btn">
                                            <div class="row">
                                                <div class="col-xl-12 col-md-4 mb-4">
                                                    <button class="btn btn-success w-100" type="submit">Save</button>
                                                </div>
                                                <div class="col-xl-12 col-md-4">
                                                    <a href="{{ route('order_quotation', $order->order_id) }}" target="_blank" class="btn btn-secondary btn-preview">Preview</a>
                                                </div>
                                                <div class="col-xl-12 col-md-4">
                                                    <a href="{{ route('order_listing') }}" class="btn btn-dark btn-preview">Cancel</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>

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
                <script src="{{asset('plugins/input-mask/jquery.inputmask.bundle.min.js')}}"></script>
                <script src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
                <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
                @vite(['resources/assets/js/apps/invoice-add.js'])

                <script>
                    $(document).ready(function() {
                        updateTotal();
                        $("#total-value").inputmask();
                        $("#discount_amount").inputmask();

                        $(document).on('click', '.add-item', function() {
                            var tr = "<tr>" +
                                "<td class='delete-item-row'>" +
                                "<ul class='table-controls'>" +
                                "<li><a href='javascript:void(0);' id='remove' data-toggle='tooltip' data-placement='top' data-original-title='Delete'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-x-circle'><circle cx='12' cy='12' r='10'></circle><line x1='15' y1='9' x2='9' y2='15'></line><line x1='9' y1='9' x2='15' y2='15'></line></svg></a></li>" +
                                "</ul>" +
                                "</td>" +
                                "<td class='description'><input type='text' class='form-control form-control-sm' placeholder='Item Name' name='order_item_name[]'> <textarea class='form-control' placeholder='Additional Details' name='order_item_description[]'></textarea></td>" +
                                "<td class='text-right qty'><input type='number' class='form-control form-control-sm' min='1' id='quantity' placeholder='Quantity' value='1'></td>" +
                                "<td class='text-right rate'><input type='text' class='form-control form-control-sm' id='order_item_price' name='order_item_price[]'></td>" +
                                "<td class='text-right rate'><input type='text' class='form-control form-control-sm' id='offer_price' name='order_item_offer_price[]'></td>" +
                                "<td class='text-right rate'><input type='text' class='form-control form-control-sm subtotal'></td>" +
                                "</tr>";
                            $('tbody').append(tr);
                        });

                        $(document).on('click', '#remove', function() {
                            $(this).closest('tr').remove()
                            updateTotal();
                        });

                        $(document).on('click', '.remove-item', function(e) {
                            e.preventDefault();

                            var row = $(this).closest('tr');
                            var orderItemId = row.data('order-item-id');
                            var url = '/modern-dark-menu/order/order_item_delete/' + orderItemId;

                            $.ajax({
                                url: url,
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: {
                                    is_deleted: 1
                                },
                                success: function(response) {
                                    // Update the row to reflect that it has been deleted
                                    row.remove();
                                    Toastify({
                                        text: response.message,
                                        duration: 3000,
                                        gravity: "top",
                                        position: "right",
                                        close: true,
                                        backgroundColor: '#00ab55'
                                    }).showToast();
                                    // Call updateTotal() after the row has been removed
                                    updateTotal();
                                },
                                error: function(xhr, status, error) {
                                    console.log(xhr.responseText);
                                }
                            });
                        });

                        function updateTotal() {
                            var subtotal = 0;
                            $('.subtotal').each(function() {
                                var value = parseFloat($(this).val()) || 0;
                                subtotal += value;
                            });

                            $('.invoice-summary-value .subtotal-amount').text(subtotal.toFixed(2));

                            var discount = parseFloat($('#discount_amount').val()) || 0;
                            var total = subtotal - discount;

                            $('#total-value').val(total.toFixed(2));
                            $('#discount_value').text(discount.toFixed(2));
                        }

                        $(document).on('input', '.rate input, #quantity, #discount_amount', function() {
                            var price = parseFloat($(this).closest('tr').find('.rate input').val()) || 0;
                            var quantity = parseFloat($(this).closest('tr').find('#quantity').val()) || 0;
                            var offerPrice = parseFloat($(this).closest('tr').find('#offer_price').val()) || 0;
                            var subtotal = (offerPrice == 0) ? price * quantity : offerPrice * quantity;
                            $(this).closest('tr').find('.subtotal').val(subtotal.toFixed(2));
                            updateTotal();
                        });
                    });
                </script>

                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
