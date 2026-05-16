<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Toast extends Component
{
    /**
     * Create a new component instance.
     */
    public $type;
    public $message;

    public function __construct($type = 'success', $message = '')
    {
        $this->type = $type;
        $this->message = $message;
    }

    public function render()
    {
        return view('components.toast');
    }
}
