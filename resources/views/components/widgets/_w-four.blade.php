{{--

/**
*
* Created a new component <x-rtl.widgets._w-four/>.
*
*/

--}}


<div class="widget-four">
    <div class="widget-heading">
        <h5 class="">{{$title}}</h5>
    </div>
    <div class="widget-content">
        <div class="vistorsBrowser">
            @foreach($topFavorites as $index => $top_favorite)
                @php
                    $percentage = ($top_favorite->count / $totalFavorites) * 100;
                    $classMapping = [
                        0 => 'bg-gradient-primary',
                        1 => 'bg-gradient-danger',
                        2 => 'bg-gradient-warning',
                    ];
                    $class = $classMapping[$index] ?? '';
                @endphp
                <div class="browser-list">
                    <div class="w-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    </div>
                    <div class="w-browser-details">
                        <div class="w-browser-info">
                            <h6>{{ $top_favorite->product->product_title }}</h6>
                            <p class="browser-count">{{ number_format($percentage, 2) }}%</p>
                        </div>
                        <div class="w-browser-stats">
                            <div class="progress">
                                <div class="progress-bar {{ $class }}" role="progressbar" style="width: {{ number_format($percentage, 2) }}%" aria-valuenow="{{ ($top_favorite->count / $totalFavorites) * 100 }}" aria-valuemin="0" aria-valuemax="{{ $totalFavorites }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
</div>
