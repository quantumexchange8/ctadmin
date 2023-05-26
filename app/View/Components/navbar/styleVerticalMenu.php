<?php

namespace App\View\Components\navbar;

use App\Models\Order;
use App\Models\User;
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
        $new_users = User::query()
            ->where('user_status', User::STATUS_ACTIVE)
            ->where('user_role', User::USER_ROLE)
            ->where('is_deleted', 0)
            ->orderByDesc('user_created')
            ->limit(3)
            ->get();

        return view('components.navbar.style-vertical-menu', [
            'new_users' => $new_users
        ]);
    }
}
