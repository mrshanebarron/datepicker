<?php

namespace MrShaneBarron\Datepicker\Livewire;

use Livewire\Component;
use Livewire\Attributes\Modelable;

class Datepicker extends Component
{
    #[Modelable]
    public ?string $value = null;

    public string $placeholder = '';
    public string $dateFormat = 'Y-m-d';
    public bool $enableTime = false;
    public bool $time24hr = false;
    public bool $range = false;
    public bool $multiple = false;
    public ?string $minDate = null;
    public ?string $maxDate = null;
    public bool $disabled = false;
    public bool $allowInput = true;
    public int $weekStartsOn = 0;

    public function mount(
        ?string $value = null,
        ?string $placeholder = null,
        ?string $dateFormat = null,
        bool $enableTime = false,
        bool $time24hr = false,
        bool $range = false,
        bool $multiple = false,
        ?string $minDate = null,
        ?string $maxDate = null,
        bool $disabled = false,
        ?bool $allowInput = null,
        ?int $weekStartsOn = null
    ): void {
        $this->value = $value;
        $this->placeholder = $placeholder ?? config('ld-datepicker.placeholder', 'Select date');
        $this->dateFormat = $dateFormat ?? config('ld-datepicker.dateFormat', 'Y-m-d');
        $this->enableTime = $enableTime || config('ld-datepicker.enableTime', false);
        $this->time24hr = $time24hr || config('ld-datepicker.time_24hr', false);
        $this->range = $range;
        $this->multiple = $multiple;
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
        $this->disabled = $disabled;
        $this->allowInput = $allowInput ?? config('ld-datepicker.allowInput', true);
        $this->weekStartsOn = $weekStartsOn ?? config('ld-datepicker.weekStartsOn', 0);
    }

    public function updatedValue(): void
    {
        $this->dispatch('datepicker-changed', value: $this->value);
    }

    public function render()
    {
        return view('ld-datepicker::livewire.datepicker');
    }
}
