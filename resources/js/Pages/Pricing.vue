<script setup>
import Accordion from '@/Components/shadcn/ui/accordion/Accordion.vue'
import AccordionContent from '@/Components/shadcn/ui/accordion/AccordionContent.vue'
import AccordionItem from '@/Components/shadcn/ui/accordion/AccordionItem.vue'
import AccordionTrigger from '@/Components/shadcn/ui/accordion/AccordionTrigger.vue'
import Button from '@/Components/shadcn/ui/button/Button.vue'
import { Card, CardContent, CardFooter, CardHeader } from '@/Components/shadcn/ui/card'
import WebLayout from '@/Layouts/WebLayout.vue'
import { Icon } from '@iconify/vue'
import { Head } from '@inertiajs/vue3'

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
  'Maximum PHPStan level',
  'Laravel Pint configuration',
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
        <div class="mx-auto mt-16 max-w-4xl">
          <Card class="relative overflow-hidden ">
            <CardHeader class="space-y-2 p-8">
              <h2 class="text-3xl font-bold">
                What's included in Larasonic
              </h2>
            </CardHeader>
            <CardContent class="grid gap-8 p-8 pt-0 lg:grid-cols-[2fr,1fr]">
              <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <ul class="space-y-4">
                  <li
                    v-for="(feature, index) in features.slice(0, 5)" :key="index"
                    class="flex items-center gap-3 "
                  >
                    <Icon icon="lucide:check" class="size-5 text-primary" aria-hidden="true" />
                    {{ feature }}
                  </li>
                </ul>
                <ul class="space-y-4">
                  <li
                    v-for="(feature, index) in features.slice(5)" :key="index"
                    class="flex items-center gap-3 text-gray-300"
                  >
                    <Icon icon="lucide:check" class="size-5 text-primary" aria-hidden="true" />
                    {{ feature }}
                  </li>
                </ul>
              </div>
              <div
                class="flex flex-col items-center justify-center border-t lg:border-l lg:border-t-0 pt-8 lg:pl-8 lg:pt-0"
              >
                <div class="text-center">
                  <div class="text-7xl font-bold">
                    $0
                  </div>
                  <div class="mt-2">
                    Forever Free
                  </div>
                </div>
                <div class="mt-6 grid w-full gap-4">
                  <Button
                    size="lg" as="a" href="https://github.com/pushpak1300/larasonic"
                    target="_blank"
                  >
                    Get Started
                  </Button>
                </div>
              </div>
            </CardContent>
            <CardFooter class="border-t p-8">
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
            </CardFooter>
          </Card>
        </div>

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
