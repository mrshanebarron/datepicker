<div
    x-data="{
        picker: null,
        init() {
            this.picker = flatpickr(this.$refs.input, {
                dateFormat: '{{ $dateFormat }}',
                enableTime: {{ $enableTime ? 'true' : 'false' }},
                time_24hr: {{ $time24hr ? 'true' : 'false' }},
                mode: '{{ $range ? 'range' : ($multiple ? 'multiple' : 'single') }}',
                allowInput: {{ $allowInput ? 'true' : 'false' }},
                weekNumbers: false,
                locale: {
                    firstDayOfWeek: {{ $weekStartsOn }}
                },
                @if($minDate)
                minDate: '{{ $minDate }}',
                @endif
                @if($maxDate)
                maxDate: '{{ $maxDate }}',
                @endif
                defaultDate: @js($value),
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
    class="ld-datepicker relative"
>
    <div class="relative">
        <input
            type="text"
            x-ref="input"
            placeholder="{{ $placeholder }}"
            @if($disabled) disabled @endif
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pl-10 pr-10"
        >
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
        </div>
        <button
            type="button"
            x-show="$wire.value"
            @click="clear()"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-500"
        >
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
            </svg>
        </button>
    </div>
</div>

@assets
    <link rel="stylesheet" href="{{ config('ld-datepicker.flatpickr_css_url') }}">
    <script src="{{ config('ld-datepicker.flatpickr_js_url') }}"></script>
@endassets
