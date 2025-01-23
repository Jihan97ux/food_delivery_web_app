<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuccessComponent extends Component
{
    public $successTitle;
    public $successText;
    public $successTextButton;
    public $redirectRoute;

    public function __construct($successTitle, $successText, $successTextButton, $redirectRoute)
    {
        $this->successTitle = $successTitle;
        $this->successText = $successText;
        $this->successTextButton = $successTextButton;
        $this->redirectRoute = $redirectRoute;
    }

    public function render(): View|Closure|string
    {
        return view('components.success-component');
    }
}
