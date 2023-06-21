{{--

/**
*
* Created a new component <x-rtl.widgets._w-activity-five/>.
*
*/

--}}


<div class="widget widget-activity-five">

    <div class="widget-heading">
        <h5 class="">{{$title}}</h5>

        <div class="task-action">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="activitylog" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                </a>

                <div class="dropdown-menu left" aria-labelledby="activitylog" style="will-change: transform;">
                    <a class="dropdown-item" href="{{ route('activity_log_listing') }}">View All</a>
                </div>
            </div>
        </div>
    </div>

    <div class="widget-content">

        <div class="w-shadow-top"></div>

        <div class="mt-container mx-auto">
            <div class="timeline-line">
                @php
                    $classMapping = [
                        'user' => 't-dot-primary',
                        'category' => 't-dot-warning',
                        'product' => 't-dot-secondary',
                        'order' => 't-dot-success',
                    ];
                @endphp

                @if(!empty($activityLogs))
                    @foreach($activityLogs as $activityLog)
                        <div class="item-timeline">
                            <p class="t-time">{{ date_format($activityLog->created_at, 'H:i') }}</p>
                            <div class="t-dot {{ $classMapping[$activityLog->log_name] }}"></div>
                            <div class="t-text">
                                <p>{{ $activityLog->description }}</p>
                                <p class="t-meta-time">{{ $activityLog->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    No records.
                @endif

            </div>
        </div>

        <div class="w-shadow-bottom"></div>
    </div>
</div>
