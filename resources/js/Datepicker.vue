<template>
  <div class="relative">
    <input
      ref="inputRef"
      type="text"
      :value="displayValue"
      @focus="open = true"
      :placeholder="placeholder"
      :class="['w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500', inputClass]"
      readonly
    >
    <Teleport to="body">
      <div
        v-if="open"
        ref="pickerRef"
        class="fixed z-50 bg-white rounded-lg shadow-xl border border-gray-200 p-4"
        :style="pickerStyle"
      >
        <div class="flex items-center justify-between mb-4">
          <button @click="prevMonth" class="p-1 hover:bg-gray-100 rounded">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          </button>
          <span class="font-semibold">{{ monthYear }}</span>
          <button @click="nextMonth" class="p-1 hover:bg-gray-100 rounded">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </button>
        </div>
        <div class="grid grid-cols-7 gap-1 text-center text-xs text-gray-500 mb-2">
          <span v-for="day in weekDays" :key="day">{{ day }}</span>
        </div>
        <div class="grid grid-cols-7 gap-1">
          <button
            v-for="date in calendarDays"
            :key="date.key"
            @click="selectDate(date)"
            :disabled="!date.currentMonth"
            :class="[
              'w-8 h-8 rounded-full text-sm transition-colors',
              date.isSelected ? 'bg-blue-600 text-white' : '',
              date.isToday && !date.isSelected ? 'border border-blue-600 text-blue-600' : '',
              !date.currentMonth ? 'text-gray-300' : 'hover:bg-gray-100',
            ]"
          >
            {{ date.day }}
          </button>
        </div>
        <div v-if="showTime" class="mt-4 pt-4 border-t flex items-center justify-center gap-2">
          <input v-model="hours" type="number" min="0" max="23" class="w-14 px-2 py-1 border rounded text-center">
          <span>:</span>
          <input v-model="minutes" type="number" min="0" max="59" class="w-14 px-2 py-1 border rounded text-center">
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';

export default {
  name: 'LdDatepicker',
  props: {
    modelValue: { type: [String, Date], default: null },
    placeholder: { type: String, default: 'Select date' },
    format: { type: String, default: 'YYYY-MM-DD' },
    showTime: { type: Boolean, default: false },
    inputClass: { type: String, default: '' }
  },
  emits: ['update:modelValue'],
  setup(props, { emit }) {
    const inputRef = ref(null);
    const pickerRef = ref(null);
    const open = ref(false);
    const viewDate = ref(new Date());
    const hours = ref(0);
    const minutes = ref(0);
    const pickerStyle = ref({});
    const weekDays = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];

    const selectedDate = computed(() => props.modelValue ? new Date(props.modelValue) : null);

    const displayValue = computed(() => {
      if (!selectedDate.value) return '';
      const d = selectedDate.value;
      let result = props.format
        .replace('YYYY', d.getFullYear())
        .replace('MM', String(d.getMonth() + 1).padStart(2, '0'))
        .replace('DD', String(d.getDate()).padStart(2, '0'));
      if (props.showTime) {
        result += ` ${String(hours.value).padStart(2, '0')}:${String(minutes.value).padStart(2, '0')}`;
      }
      return result;
    });

    const monthYear = computed(() => {
      const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      return `${months[viewDate.value.getMonth()]} ${viewDate.value.getFullYear()}`;
    });

    const calendarDays = computed(() => {
      const days = [];
      const year = viewDate.value.getFullYear();
      const month = viewDate.value.getMonth();
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      const today = new Date();

      for (let i = 0; i < firstDay; i++) {
        const d = new Date(year, month, -firstDay + i + 1);
        days.push({ day: d.getDate(), date: d, currentMonth: false, key: `prev-${i}` });
      }
      for (let i = 1; i <= daysInMonth; i++) {
        const d = new Date(year, month, i);
        days.push({
          day: i,
          date: d,
          currentMonth: true,
          isToday: d.toDateString() === today.toDateString(),
          isSelected: selectedDate.value && d.toDateString() === selectedDate.value.toDateString(),
          key: `curr-${i}`
        });
      }
      return days;
    });

    const prevMonth = () => { viewDate.value = new Date(viewDate.value.getFullYear(), viewDate.value.getMonth() - 1, 1); };
    const nextMonth = () => { viewDate.value = new Date(viewDate.value.getFullYear(), viewDate.value.getMonth() + 1, 1); };

    const selectDate = (date) => {
      if (!date.currentMonth) return;
      const d = date.date;
      if (props.showTime) d.setHours(hours.value, minutes.value);
      emit('update:modelValue', d.toISOString());
      open.value = false;
    };

    const updatePickerPosition = () => {
      if (inputRef.value) {
        const rect = inputRef.value.getBoundingClientRect();
        pickerStyle.value = { top: `${rect.bottom + 8}px`, left: `${rect.left}px` };
      }
    };

    const handleClickOutside = (e) => {
      if (pickerRef.value && !pickerRef.value.contains(e.target) && !inputRef.value.contains(e.target)) {
        open.value = false;
      }
    };

    watch(open, (val) => { if (val) updatePickerPosition(); });
    onMounted(() => document.addEventListener('click', handleClickOutside));
    onUnmounted(() => document.removeEventListener('click', handleClickOutside));

    return { inputRef, pickerRef, open, viewDate, hours, minutes, pickerStyle, weekDays, displayValue, monthYear, calendarDays, prevMonth, nextMonth, selectDate };
  }
};
</script>
