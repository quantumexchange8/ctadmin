{{--

/**
*
* Created a new component <x-rtl.widgets._w-three/>.
*
*/

--}}


<div class="widget widget-three">
    <div class="widget-heading">
        <h5 class="">{{$title}}</h5>

        <div class="task-action">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="summary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                </a>

                <div class="dropdown-menu left" aria-labelledby="summary" style="will-change: transform;">
                    <a class="dropdown-item" href="javascript:void(0);">View Report</a>
                    <a class="dropdown-item" href="javascript:void(0);">Edit Report</a>
                    <a class="dropdown-item" href="javascript:void(0);">Mark as Done</a>
                </div>
            </div>
        </div>

    </div>
    <div class="widget-content">

        <div class="order-summary">
            @php
                $statusMap = [
                    1 => ['name' => 'Processing', 'class' => 'bg-gradient-secondary'],
                    2 => ['name' => 'Pending', 'class' => 'bg-gradient-success'],
                    3 => ['name' => 'Awaiting Payment', 'class' => 'bg-gradient-warning'],
                ];

                 $iconMap = [
                    1 => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>',
                    2 => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
                    3 => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>',
                ];
            @endphp

            @foreach ($priceOfStatus as $statusPrice)
                <div class="summary-list">
                    <div class="w-icon">
                        {!! $iconMap[$statusPrice->order_status] !!}
                    </div>
                    <div class="w-summary-details">
                        <div class="w-summary-info">
                            <h6>{{ $statusMap[$statusPrice->order_status]['name'] }}</h6>
                            <p class="summary-count">${{ $statusPrice->total_price }}</p>
                        </div>
                        <div class="w-summary-stats">
                            <div class="progress">
                                <div class="progress-bar {{ $statusMap[$statusPrice->order_status]['class'] }}" role="progressbar" style="width: {{ ($statusPrice->total_price / $totalOrderPrice) * 100 }}%" aria-valuenow="{{ ($statusPrice->total_price / $totalOrderPrice) * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
</div>
