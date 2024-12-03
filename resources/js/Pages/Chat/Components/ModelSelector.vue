<script setup>
import Label from '@/Components/shadcn/ui/label/Label.vue'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/Components/shadcn/ui/select'
import { ref } from 'vue'

const props = defineProps({
  models: {
    type: Array,
    required: false,
    default: () => ['Model 1', 'Model 2', 'Model 3'],
  },
})

const selectedModel = ref()
</script>

<template>
  <Label for="model">Model</Label>
  <Select id="model" v-model="selectedModel">
    <SelectTrigger class="w-[180px]">
      <SelectValue :placeholder="props.models[0] || 'Select a model'" />
    </SelectTrigger>
    <SelectContent>
      <SelectGroup>
        <SelectItem
          v-for="model in props.models"
          :key="model"
          :value="model"
        >
          <span class="text-sm">{{ model }}</span>
        </SelectItem>
      </SelectGroup>
    </SelectContent>
  </Select>
</template>
