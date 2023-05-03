<?php

namespace App\View\Components\navbar;

use App\Models\Order;
use Illuminate\View\Component;

class styleVerticalMenu extends Component
{

    /**
     * The title.
     *
     * @var string
     */
    public $classes;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($classes)
    {
        $this->classes = $classes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        $order = Order::where('is_deleted', 0)->where('order_status', Order::STATUS_PENDING)->orderByDesc('order_created')->first();

        return view('components.navbar.style-vertical-menu', [
            'order' => $order,
        ]);
    }
}
