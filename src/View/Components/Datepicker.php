<?php

namespace MrShaneBarron\Datepicker\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Datepicker extends Component
{
    public string $inputId;

    public function __construct(
        public string $name = 'date',
        public ?string $value = null,
        public ?string $placeholder = null,
        public ?string $dateFormat = null,
        public bool $enableTime = false,
        public bool $time24hr = false,
        public bool $range = false,
        public bool $multiple = false,
        public ?string $minDate = null,
        public ?string $maxDate = null,
        public bool $disabled = false,
        public ?bool $allowInput = null,
        public ?int $weekStartsOn = null,
        ?string $id = null
    ) {
        $this->placeholder = $placeholder ?? config('sb-datepicker.placeholder', 'Select date');
        $this->dateFormat = $dateFormat ?? config('sb-datepicker.dateFormat', 'Y-m-d');
        $this->allowInput = $allowInput ?? config('sb-datepicker.allowInput', true);
        $this->weekStartsOn = $weekStartsOn ?? config('sb-datepicker.weekStartsOn', 0);
        $this->inputId = $id ?? 'datepicker-' . uniqid();
    }

    public function render(): View
    {
        return view('sb-datepicker::components.datepicker');
    }
}
