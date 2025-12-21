<div
    x-data="{
        picker: null,
        init() {
            this.picker = flatpickr(this.$refs.input, {
                dateFormat: '{{ $this->dateFormat }}',
                enableTime: {{ $this->enableTime ? 'true' : 'false' }},
                time_24hr: {{ $this->time24hr ? 'true' : 'false' }},
                mode: '{{ $this->range ? 'range' : ($this->multiple ? 'multiple' : 'single') }}',
                allowInput: {{ $this->allowInput ? 'true' : 'false' }},
                weekNumbers: false,
                locale: {
                    firstDayOfWeek: {{ $this->weekStartsOn }}
                },
                @if($this->minDate)
                minDate: '{{ $this->minDate }}',
                @endif
                @if($this->maxDate)
                maxDate: '{{ $this->maxDate }}',
                @endif
                defaultDate: @js($this->value),
                onChange: (selectedDates, dateStr) => {
                    $wire.set('value', dateStr)
                }
            })
        },
        destroy() {
            if (this.picker) {
                this.picker.destroy()
            }
        },
        clear() {
            if (this.picker) {
                this.picker.clear()
                $wire.set('value', null)
            }
        }
    }"
    wire:ignore
    style="position: relative;"
>
    <div style="position: relative;">
        <input
            type="text"
            x-ref="input"
            placeholder="{{ $this->placeholder }}"
            @if($this->disabled) disabled @endif
            style="width: 100%; border-radius: 6px; border: 1px solid #d1d5db; padding: 8px 40px; font-size: 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
        >
        <div style="position: absolute; top: 0; bottom: 0; left: 0; display: flex; align-items: center; padding-left: 12px; pointer-events: none;">
            <svg style="height: 20px; width: 20px; color: #9ca3af;" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
        </div>
        <button
            type="button"
            x-show="$wire.value"
            @click="clear()"
            style="position: absolute; top: 0; bottom: 0; right: 0; display: flex; align-items: center; padding-right: 12px; color: #9ca3af; background: transparent; border: none; cursor: pointer;"
            onmouseover="this.style.color='#6b7280'"
            onmouseout="this.style.color='#9ca3af'"
        >
            <svg style="height: 20px; width: 20px;" viewBox="0 0 20 20" fill="currentColor">
                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
            </svg>
        </button>
    </div>
</div>

@assets
    <link rel="stylesheet" href="{{ config('sb-datepicker.flatpickr_css_url') }}">
    <script src="{{ config('sb-datepicker.flatpickr_js_url') }}"></script>
@endassets
