<script setup>
import { CheckIcon } from 'lucide-vue-next'
import { Button } from './shadcn/ui/button'
import { Card, CardFooter } from './shadcn/ui/card'

defineProps({
  features: {
    type: Array,
    required: true,
  },
  price: {
    type: Number,
    default: 19,
  },
  plan: {
    type: String,
    default: 'PRO',
  },
  description: {
    type: String,
    default: 'Perfect for growing businesses',
  },
  billingPeriod: {
    type: String,
    default: 'Billed Monthly',
  },
  buttonText: {
    type: String,
    default: 'Get Started',
  },
  buttonVariant: {
    type: String,
    default: 'default',
  },
  buttonHref: {
    type: String,
    default: '/login',
  },
  className: {
    type: String,
    default: '',
  }
})
</script>

<template>
  <Card class="w-full" :class="className">
    <div class="grid items-start gap-10 rounded-lg p-10 md:grid-cols-[1fr_200px]">
      <div class="grid gap-6">
        <slot name="header">
          <h3 class="text-xl font-bold sm:text-2xl">{{ plan }}</h3>
          <p class="text-sm text-muted-foreground">{{ description }}</p>
        </slot>
        <slot name="features">
          <ul class="grid gap-3 text-sm text-muted-foreground sm:grid-cols-2">
            <li v-for="feature in features" :key="feature" class="flex items-center">
              <CheckIcon class="mr-2 h-4 w-4" />
              {{ feature }}
            </li>
          </ul>
        </slot>
      </div>
      <div class="flex flex-col gap-4 text-center justify-around max-w-full h-full">
        <slot name="pricing">
          <div>
            <h4 class="text-7xl font-bold">${{ price }}</h4>
            <p class="text-sm font-medium text-muted-foreground">
              {{ billingPeriod }}
            </p>
          </div>
        </slot>
        <slot name="action">
          <Button :variant="buttonVariant" :href="buttonHref">
            {{ buttonText }}
          </Button>
        </slot>
      </div>
    </div>

    <CardFooter v-if="$slots.footer">
      <slot name="footer" />
    </CardFooter>
  </Card>
</template>
