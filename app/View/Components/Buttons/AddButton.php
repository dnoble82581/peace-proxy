<?php

namespace App\View\Components\Buttons;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddButton extends Component
{
    // Define properties if needed to pass dynamic data
    public string $onClick;

    public function __construct(string $onClick = 'addRequest')
    {
        // Add constructor logic (if required for future expansions)
        $this->onClick = $onClick;
    }

    public function render(): View
    {
        return view('components.buttons.add-button');
    }
}
