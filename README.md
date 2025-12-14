# Laravel Design Datepicker

Date and time picker component using Flatpickr for Laravel. Supports Livewire, Blade, and Vue 3.

## Installation

```bash
composer require mrshanebarron/datepicker
```

For Vue components:
```bash
npm install @laraveldesign/datepicker
```

Include Flatpickr CSS and JS:

```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
```

## Usage

### Livewire Component

```blade
<livewire:ld-datepicker wire:model="date" />

{{-- With time --}}
<livewire:ld-datepicker
    wire:model="datetime"
    :enable-time="true"
    :time-24hr="true"
    date-format="Y-m-d H:i"
/>

{{-- Date range --}}
<livewire:ld-datepicker
    wire:model="dateRange"
    :range="true"
    placeholder="Select date range"
/>

{{-- Multiple dates --}}
<livewire:ld-datepicker
    wire:model="dates"
    :multiple="true"
/>

{{-- With min/max dates --}}
<livewire:ld-datepicker
    wire:model="appointmentDate"
    :min-date="now()->format('Y-m-d')"
    :max-date="now()->addMonths(3)->format('Y-m-d')"
/>
```

### Blade Component

```blade
<x-ld-datepicker name="birth_date" placeholder="Select your birthday" />

{{-- With initial value --}}
<x-ld-datepicker name="event_date" :value="$event->date" />

{{-- DateTime picker --}}
<x-ld-datepicker
    name="meeting_time"
    :enable-time="true"
    date-format="Y-m-d H:i:s"
/>

{{-- Week starts on Monday --}}
<x-ld-datepicker
    name="start_date"
    :week-starts-on="1"
/>
```

### Vue 3 Component

```vue
<script setup>
import { ref } from 'vue'
import { LdDatepicker } from '@laraveldesign/datepicker'

const selectedDate = ref(null)
const dateRange = ref(null)
</script>

<template>
  <LdDatepicker
    v-model="selectedDate"
    placeholder="Pick a date"
  />

  <LdDatepicker
    v-model="dateRange"
    :range="true"
    placeholder="Select range"
    @change="handleChange"
  />
</template>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string | `null` | Selected date |
| `placeholder` | string | `'Select date'` | Placeholder text |
| `dateFormat` | string | `'Y-m-d'` | Date format (Flatpickr format) |
| `enableTime` | boolean | `false` | Enable time selection |
| `time24hr` | boolean | `false` | Use 24-hour time format |
| `range` | boolean | `false` | Enable date range selection |
| `multiple` | boolean | `false` | Allow multiple dates |
| `minDate` | string | `null` | Minimum selectable date |
| `maxDate` | string | `null` | Maximum selectable date |
| `disabled` | boolean | `false` | Disable the picker |
| `allowInput` | boolean | `true` | Allow manual input |
| `weekStartsOn` | number | `0` | First day of week (0=Sunday, 1=Monday) |

## Date Formats

Common Flatpickr format tokens:

| Token | Description | Example |
|-------|-------------|---------|
| `Y` | 4-digit year | 2024 |
| `m` | Month (01-12) | 03 |
| `d` | Day (01-31) | 15 |
| `H` | Hours (00-23) | 14 |
| `i` | Minutes (00-59) | 30 |
| `s` | Seconds (00-59) | 45 |
| `F` | Full month name | March |
| `l` | Full weekday | Friday |

## Events

### Livewire Events

```javascript
Livewire.on('datepicker-changed', ({ value }) => {
    console.log('Selected date:', value);
});
```

### Vue Events

```vue
<LdDatepicker
  v-model="date"
  @change="handleChange"
  @open="handleOpen"
  @close="handleClose"
/>
```

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=ld-datepicker-config
```

### Configuration Options

```php
// config/ld-datepicker.php
return [
    'placeholder' => 'Select date',
    'dateFormat' => 'Y-m-d',
    'enableTime' => false,
    'time_24hr' => false,
    'allowInput' => true,
    'weekStartsOn' => 0,
    'locale' => 'en',
];
```

## Customization

### Publishing Views

```bash
php artisan vendor:publish --tag=ld-datepicker-views
```

### Flatpickr Themes

Use Flatpickr themes:

```html
<!-- Dark theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">

<!-- Material theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
```

### Localization

Load Flatpickr locales for non-English:

```html
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
```

## License

MIT
