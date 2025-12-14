<script setup lang="ts">
import { ref, onMounted, onUnmounted, watch } from 'vue'
import flatpickr from 'flatpickr'
import 'flatpickr/dist/flatpickr.min.css'

interface Props {
  modelValue?: string | Date | null
  placeholder?: string
  dateFormat?: string
  enableTime?: boolean
  time24hr?: boolean
  mode?: 'single' | 'range' | 'multiple'
  minDate?: string | Date | null
  maxDate?: string | Date | null
  disabled?: boolean
  allowInput?: boolean
  weekStartsOn?: number
  inline?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: null,
  placeholder: 'Select date',
  dateFormat: 'Y-m-d',
  enableTime: false,
  time24hr: false,
  mode: 'single',
  minDate: null,
  maxDate: null,
  disabled: false,
  allowInput: true,
  weekStartsOn: 0,
  inline: false,
})

const emit = defineEmits<{
  'update:modelValue': [value: string | null]
  'change': [dates: Date[], dateStr: string]
  'open': []
  'close': []
  'ready': [instance: flatpickr.Instance]
}>()

const inputRef = ref<HTMLInputElement | null>(null)
let pickerInstance: flatpickr.Instance | null = null

function initPicker() {
  if (!inputRef.value) return

  pickerInstance = flatpickr(inputRef.value, {
    dateFormat: props.dateFormat,
    enableTime: props.enableTime,
    time_24hr: props.time24hr,
    mode: props.mode,
    allowInput: props.allowInput,
    inline: props.inline,
    locale: {
      firstDayOfWeek: props.weekStartsOn,
    },
    minDate: props.minDate || undefined,
    maxDate: props.maxDate || undefined,
    defaultDate: props.modelValue || undefined,
    onChange: (selectedDates, dateStr) => {
      emit('update:modelValue', dateStr || null)
      emit('change', selectedDates, dateStr)
    },
    onOpen: () => emit('open'),
    onClose: () => emit('close'),
    onReady: (_, __, instance) => emit('ready', instance),
  })
}

function destroyPicker() {
  if (pickerInstance) {
    pickerInstance.destroy()
    pickerInstance = null
  }
}

function clear() {
  if (pickerInstance) {
    pickerInstance.clear()
    emit('update:modelValue', null)
  }
}

function open() {
  pickerInstance?.open()
}

function close() {
  pickerInstance?.close()
}

function setDate(date: string | Date | Date[]) {
  pickerInstance?.setDate(date)
}

onMounted(() => {
  initPicker()
})

onUnmounted(() => {
  destroyPicker()
})

watch(() => props.modelValue, (newValue) => {
  if (pickerInstance && newValue !== pickerInstance.input.value) {
    pickerInstance.setDate(newValue || [], false)
  }
})

watch(() => props.minDate, (newValue) => {
  if (pickerInstance) {
    pickerInstance.set('minDate', newValue || undefined)
  }
})

watch(() => props.maxDate, (newValue) => {
  if (pickerInstance) {
    pickerInstance.set('maxDate', newValue || undefined)
  }
})

watch(() => props.disabled, (disabled) => {
  if (inputRef.value) {
    inputRef.value.disabled = disabled
  }
})

defineExpose({
  picker: () => pickerInstance,
  clear,
  open,
  close,
  setDate,
})
</script>

<template>
  <div class="ld-datepicker relative">
    <div class="relative">
      <input
        ref="inputRef"
        type="text"
        :placeholder="placeholder"
        :disabled="disabled"
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pl-10 pr-10"
      >
      <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
        </svg>
      </div>
      <button
        v-if="modelValue"
        type="button"
        @click="clear"
        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-500"
      >
        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
        </svg>
      </button>
    </div>
  </div>
</template>
