<template>
  <div
    v-if="show"
    :class="containerClasses"
    role="status"
    :aria-label="label"
  >
    <div :class="spinnerClasses">
      <svg
        v-if="variant === 'svg'"
        class="w-full h-full"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          :stroke-width="thickness"
        ></circle>
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
      </svg>
    </div>
    <span v-if="text" class="ml-3 text-gray-700">{{ text }}</span>
  </div>
</template>

<script setup lang="ts">
interface Props {
  show?: boolean
  size?: 'sm' | 'md' | 'lg' | 'xl'
  color?: 'blue' | 'gray' | 'green' | 'red' | 'yellow'
  variant?: 'border' | 'svg'
  thickness?: number
  overlay?: boolean
  opacity?: number
  text?: string
  label?: string
}

import { computed } from 'vue'

const sizeMap = {
  sm: '8',
  md: '12',
  lg: '16',
  xl: '24'
}

const props = withDefaults(defineProps<Props>(), {
  show: true,
  size: 'lg',
  color: 'blue',
  variant: 'border',
  thickness: 4,
  overlay: true,
  opacity: 50,
  label: 'Načítava sa...'
})

const containerClasses = computed(() => [
  props.overlay ? 'fixed inset-0 flex items-center justify-center z-50' : 'inline-flex',
  props.overlay ? `bg-gray-900 bg-opacity-${props.opacity}` : ''
])

const spinnerClasses = computed(() => [
  'animate-spin rounded-full',
  `h-${sizeMap[props.size]} w-${sizeMap[props.size]}`,
  props.variant === 'border' ? `border-${props.thickness} border-gray-200` : '',
  props.variant === 'border' ? `border-t-${props.thickness} border-${props.color}-600` : `text-${props.color}-600`
])
</script>
