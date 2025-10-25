<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Calendar extends Component
{
    public $disabledDates;
    public $defaultDate;
    public $id;

    public function __construct($disabledDates = [], $defaultDate = null, $id = null)
    {
        $this->disabledDates = $disabledDates;
        $this->defaultDate = $defaultDate;
        $this->id = $id ?? 'calendar_' . uniqid();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.calendar');
    }
}
