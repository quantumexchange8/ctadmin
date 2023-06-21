{{--

/**
*
* Created a new component <x-rtl.widgets._w-card-four/>.
*
*/

--}}


<div class="widget widget-card-four">
    <div class="widget-content">
        <div class="w-header">
            <div class="w-info">
                <h6 class="value">{{$title}}</h6>
            </div>
        </div>

        <div class="w-content">

            <div class="w-info">
                <p class="value">$ {{ $amount }} <span>@lang('public.this_week')</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg></p>
            </div>

        </div>
        @php
            $percentage = ($amount / $total) * 100
        @endphp
        <div class="w-progress-stats">
            <div class="progress">

                <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: {{ ($amount / $total) * 100 }}%" aria-valuenow="{{ number_format($percentage, 2) }}%" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <div class="">
                <div class="w-icon">
                    <p>{{ number_format($percentage, 2) }}%</p>
                </div>
            </div>

        </div>
    </div>
</div>
