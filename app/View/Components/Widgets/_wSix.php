<?php

namespace App\View\Components\Widgets;

use Illuminate\View\Component;

class _wSix extends Component
{

    /**
     * The title.
     *
     * @var string
     */
    public $title;

    /**
     * The total_visits.
     *
     * @var integer
     */
    public $visits;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $visits)
    {
        $this->title = $title;
        $this->visits = $visits;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.widgets._w-six');
    }
}
