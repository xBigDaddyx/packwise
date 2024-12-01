<script setup>
import { Icon } from '@iconify/vue'

defineProps({
  icon: {
    type: String,
    required: true,
  },
  title: {
    type: String,
    required: true,
  },
  description: {
    type: String,
    required: true,
  },
})
</script>

<template>
  <div class="rounded-lg border bg-card p-6 shadow-sm">
    <Icon :icon="icon" class="h-12 w-12 text-primary" />
    <h3 class="mt-4 text-xl font-semibold">
      {{ title }}
    </h3>
    <p class="mt-2 text-muted-foreground">
      {{ description }}
    </p>
  </div>
</template>
