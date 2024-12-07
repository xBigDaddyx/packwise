<script setup>
import PricingCard from '@/Components/PricingCard.vue'
import Accordion from '@/Components/shadcn/ui/accordion/Accordion.vue'
import AccordionContent from '@/Components/shadcn/ui/accordion/AccordionContent.vue'
import AccordionItem from '@/Components/shadcn/ui/accordion/AccordionItem.vue'
import AccordionTrigger from '@/Components/shadcn/ui/accordion/AccordionTrigger.vue'
import Button from '@/Components/shadcn/ui/button/Button.vue'
import WebLayout from '@/Layouts/WebLayout.vue'
import { Icon } from '@iconify/vue'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
})

const features = [
  'Production-ready Docker setup',
  'Advanced authentication system',
  'AI Integrations',
  'Payment integration ready',
  'API endpoints with Sanctum',
  'Comprehensive documentation',
  'Regular updates & improvements',
  'Best In Class IDE support',
]

const sponsorLinks = {
  github: 'https://github.com/pushpak1300',
  x: 'https://x.com/pushpak1300',
}

const faqItems = [
  {
    value: 'item-1',
    title: 'Is Larasonic really free?',
    content: 'Yes! Larasonic is completely free and open source under the MIT license. You can use it for personal or commercial projects without any restrictions. Feel free to star the repo for showing your intrest.',
  },
  {
    value: 'item-2',
    title: 'How can I contribute?',
    content: 'You can contribute by submitting pull requests, reporting bugs, suggesting features, or helping with documentation. Every contribution is valuable!',
  },
  {
    value: 'item-3',
    title: 'Why should I sponsor?',
    content: 'Sponsoring helps ensure the project\'s long-term sustainability. Your support enables continued maintenance, new features, and improvements that benefit the entire community.',
  },
]
</script>

<template>
  <WebLayout :can-login="props.canLogin" :can-register="props.canRegister">
    <Head title="Pricing" />
    <div class="relative min-h-screen">
      <div class="container mx-auto px-4 py-16 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mx-auto max-w-3xl text-center">
          <h1 class="text-5xl font-bold tracking-tight sm:text-6xl md:text-7xl">
            Proudly Open Source
          </h1>
          <p class="mt-4 text-xl text-gray-400">
            Larasonic is and will always be open source. No hidden fees, no premium features.
          </p>
        </div>

        <!-- Pricing Card -->
        <PricingCard class="mx-auto max-w-4xl mt-16" :features="features" :price="0" plan="What's included ?" billing-period="Free Forever">
          <template #action>
            <Button :as="Link" :href="route('dashboard')">
              Get Started
            </Button>
          </template>
          <template #footer>
            <div class="flex w-full flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
              <p class="text-sm">
                Want to support the development?
              </p>
              <div class="flex gap-4">
                <Button variant="outline" as="a" :href="sponsorLinks.github" target="_blank">
                  <Icon icon="mdi:github" class="mr-2 size-4" aria-hidden="true" />
                  Sponsor
                </Button>
                <Button variant="outline" as="a" :href="sponsorLinks.x" target="_blank">
                  <Icon icon="ri:twitter-x-line" class="mr-2 size-4" aria-hidden="true" />
                  Follow Me
                </Button>
              </div>
            </div>
          </template>
        </PricingCard>
        <!-- FAQ Section -->
        <div class="mx-auto mt-16 max-w-4xl text-center">
          <h2 class="text-2xl font-bold">
            Frequently Asked Questions
          </h2>
          <Accordion type="single" class="mt-8 w-full text-left" collapsible default-value="item-1">
            <AccordionItem v-for="item in faqItems" :key="item.value" :value="item.value">
              <AccordionTrigger class="text-lg">
                {{ item.title }}
              </AccordionTrigger>
              <AccordionContent>
                {{ item.content }}
              </AccordionContent>
            </AccordionItem>
          </Accordion>
        </div>
      </div>
    </div>
  </WebLayout>
</template>
