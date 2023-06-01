{{--

/**
*
* Created a new component <x-rtl.widgets._w-table-two/>.
*
*/

--}}


<div class="widget widget-table-two">

    <div class="widget-heading">
        <h5 class="">{{$title}}</h5>
    </div>

    <div class="widget-content">
{{--        @if() @endif--}}
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><div class="th-content">Customer</div></th>
                        <th><div class="th-content">Order No</div></th>
                        <th><div class="th-content th-heading">Price</div></th>
                        <th><div class="th-content text-center">Status</div></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentOrders as $order)
                        <tr>
                            <td>
                                <div class="td-content customer-name">
                                    @if($order->user->hasMedia('user_profile_photo'))
                                        <img src="{{ $order->user->getFirstMediaUrl('user_profile_photo') }}" alt="avatar">
                                    @else
                                        <img src="{{ Vite::asset('resources/images/profile-5.jpeg') }}" alt="avatar">
                                    @endif
                                    <span>{{ $order->user->user_fullname }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="td-content product-invoice">{{ $order->order_number }}</div>
                            </td>
                            <td>
                                <div class="td-content pricing">
                                    ${{ $order->order_total_price }}
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusLabels = [
                                        \App\Models\Order::STATUS_PROCESSING => ['Processing', 'badge-primary'],
                                        \App\Models\Order::STATUS_PENDING => ['Pending', 'badge-secondary'],
                                        \App\Models\Order::STATUS_AWAITING => ['Awaiting Payment', 'badge-info'],
                                        \App\Models\Order::STATUS_COMPLETED => ['Completed', 'badge-success'],
                                        \App\Models\Order::STATUS_CANCELLED => ['Cancelled', 'badge-danger']
                                    ];
                                @endphp

                                @if (isset($statusLabels[$order->order_status]))
                                    @php
                                        $status = $statusLabels[$order->order_status];
                                    @endphp
                                    <div class="td-content">
                                        <span class="badge {{ $status[1] }}">{{ $status[0] }}</span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
