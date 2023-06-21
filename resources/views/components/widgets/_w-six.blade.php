{{--

/**
*
* Created a new component <x-rtl.widgets._w-six/>.
*
*/

--}}


<div class="widget widget-six">
    <div class="widget-heading">
        <h6 class="">{{$title}}</h6>
    </div>
    <div class="w-chart">
        <div class="w-chart-section">
            <div class="w-detail">
                <p class="w-title">@lang('public.total_visits')</p>
                <p class="w-stats">{{ $visits }}</p>
            </div>
            <div class="w-chart-render-one">
                <div id="total-users"></div>
            </div>
        </div>

        <div class="w-chart-section">
            <div class="w-detail">
                <p class="w-title">@lang('public.completed_orders')</p>
                <p class="w-stats">{{ $paids }}</p>
            </div>
            <div class="w-chart-render-one">
                <div id="paid-visits"></div>
            </div>
        </div>
    </div>
</div>
