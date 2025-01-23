<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ErrorComponent extends Component
{
    public $errorTitle;
    public $errorText;
    public $errorTextButton;
    public $redirectRoute;

    public function __construct($errorTitle, $errorText, $errorTextButton, $redirectRoute)
    {
        $this->errorTitle = $errorTitle;
        $this->errorText = $errorText;
        $this->errorTextButton = $errorTextButton;
        $this->redirectRoute = $redirectRoute;
    }

    public function render()
    {
        return view('components.error-component');
    }
}