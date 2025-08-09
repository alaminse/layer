<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LawyerRegistration extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $fields = null;

        if (moduleStatusCheck('CustomField')) {
            $fields = getFieldByType('staff');
        }
        return view('components.lawyer-registration', compact('fields'));
    }
}
