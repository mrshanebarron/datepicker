# Datepicker

A date picker input component for Laravel applications. Features a dropdown calendar for easy date selection. Works with Livewire and Vue 3.

## Installation

```bash
composer require mrshanebarron/datepicker
```

## Livewire Usage

### Basic Usage

```blade
<livewire:sb-datepicker wire:model="date" />
```

### With Placeholder

```blade
<livewire:sb-datepicker
    wire:model="birthdate"
    placeholder="Select your birthday"
/>
```

### Date Format

```blade
<livewire:sb-datepicker
    wire:model="date"
    format="MM/DD/YYYY"
/>
```

### Min/Max Dates

```blade
<livewire:sb-datepicker
    wire:model="appointmentDate"
    :min-date="today()"
    :max-date="today()->addMonths(3)"
/>
```

### Livewire Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `wire:model` | string | - | Selected date |
| `placeholder` | string | `'Select date'` | Input placeholder |
| `format` | string | `'YYYY-MM-DD'` | Display format |
| `min-date` | string | `null` | Earliest selectable date |
| `max-date` | string | `null` | Latest selectable date |
| `disabled` | boolean | `false` | Disable input |

## Vue 3 Usage

### Setup

```javascript
import { SbDatepicker } from './vendor/sb-datepicker';
app.component('SbDatepicker', SbDatepicker);
```

### Basic Usage

```vue
<template>
  <SbDatepicker v-model="selectedDate" />
</template>

<script setup>
import { ref } from 'vue';
const selectedDate = ref(null);
</script>
```

### With Options

```vue
<template>
  <SbDatepicker
    v-model="date"
    placeholder="Choose a date"
    format="DD/MM/YYYY"
  />
</template>
```

### Date Range Constraints

```vue
<template>
  <SbDatepicker
    v-model="appointmentDate"
    :min-date="minDate"
    :max-date="maxDate"
    placeholder="Select appointment date"
  />
</template>

<script setup>
import { ref } from 'vue';

const appointmentDate = ref(null);
const minDate = new Date().toISOString().split('T')[0];
const maxDate = new Date(Date.now() + 90 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
</script>
```

### Form Example

```vue
<template>
  <form @submit.prevent="submit" class="space-y-4">
    <div>
      <label class="block text-sm font-medium mb-1">Start Date</label>
      <SbDatepicker v-model="form.startDate" />
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">End Date</label>
      <SbDatepicker
        v-model="form.endDate"
        :min-date="form.startDate"
      />
    </div>

    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
      Submit
    </button>
  </form>
</template>
```

### Vue Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `modelValue` | String | `null` | Selected date (YYYY-MM-DD) |
| `placeholder` | String | `'Select date'` | Placeholder text |
| `format` | String | `'YYYY-MM-DD'` | Display format |
| `minDate` | String | `null` | Minimum date |
| `maxDate` | String | `null` | Maximum date |
| `disabled` | Boolean | `false` | Disable input |

### Events

| Event | Payload | Description |
|-------|---------|-------------|
| `update:modelValue` | `string` | Date selected |

## Date Format

The component stores dates in `YYYY-MM-DD` format but can display in various formats:

| Format | Example |
|--------|---------|
| `YYYY-MM-DD` | 2024-01-15 |
| `DD/MM/YYYY` | 15/01/2024 |
| `MM/DD/YYYY` | 01/15/2024 |
| `MMM DD, YYYY` | Jan 15, 2024 |

## Features

- **Calendar Dropdown**: Visual date selection
- **Keyboard Navigation**: Arrow keys in calendar
- **Month Navigation**: Previous/next month
- **Date Constraints**: Min/max date limits
- **Click Outside**: Closes on outside click

## Styling

Uses Tailwind CSS:
- Standard input styling
- Calendar dropdown with shadow
- Highlighted today's date
- Blue selected date
- Disabled dates grayed out

## Requirements

- PHP 8.1+
- Laravel 10, 11, or 12
- Tailwind CSS 3.x

## License

MIT License
