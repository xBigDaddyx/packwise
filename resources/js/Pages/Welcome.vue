<script setup>
import FeaturesSection from '@/Pages/Homepage/FeatureSection.vue'
import HeroSection from '@/Pages/Homepage/HeroSection.vue'
import TestimonialSection from '@/Pages/Homepage/TestimonialSection.vue'
import CTASection from '@/Pages/Homepage/CTASection.vue'
import FeaturedFeaturesSection from '@/Pages/Homepage/FeaturedFeaturesSection.vue'
import PricingCard from '@/Components/PricingCard.vue'

import Accordion from '@/Components/shadcn/ui/accordion/Accordion.vue'
import AccordionContent from '@/Components/shadcn/ui/accordion/AccordionContent.vue'
import AccordionItem from '@/Components/shadcn/ui/accordion/AccordionItem.vue'
import AccordionTrigger from '@/Components/shadcn/ui/accordion/AccordionTrigger.vue'
import Badge from '@/Components/shadcn/ui/badge/Badge.vue'
import Button from '@/Components/shadcn/ui/button/Button.vue'
import Terminal from '@/Components/Terminal.vue'
import WebLayout from '@/Layouts/WebLayout.vue'
import { Icon } from '@iconify/vue'
import { Head, Link } from '@inertiajs/vue3'


defineProps({
    isDark: {
        type: Boolean,
    },
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
})

const features = [
    {
        icon: '🚀',
        title: '10x Dev Experience',
        description: 'Ship faster with opinionated Laravel Pint, maximum PHPStan level, and Rector for enhanced code quality and developer productivity.',
    },
    {
        icon: '🐳',
        title: 'Production Docker Ready',
        description: 'Optimized Docker images with Laravel Octane and Sail for lightning-fast development and deployment.',
    },
    {
        icon: '🔑',
        title: 'Advanced Authentication',
        description: 'Complete authentication system with social login, and role-based access control.',
    },
    {
        icon: '💳',
        title: 'Payment Ready',
        description: 'Integrated Laravel Cashier for subscription billing and payment processing so you can focus on building your product.',
    },
    {
        icon: '🌐',
        title: 'API Ready',
        description: 'RESTful API endpoints with Laravel Sanctum authentication and comprehensive documentation.',
    },
    {
        icon: '🎨',
        title: 'Customizable UI',
        description: 'Built with shadcn/ui components, making UI customization a breeze. Easily modify themes, styles, and components to match your brand.',
    },
    {
        icon: '🧠',
        title: 'AI Integration Ready',
        description: 'Pre-configured LLM integrations for OpenAI, Anthropic, and more. Build AI-powered features into your app with minimal setup.',
    },
    {
        icon: '📊',
        title: 'FilamentPHP Admin',
        description: 'Beautiful admin panel powered by FilamentPHP with CRUD operations, charts, and detailed analytics.',
    },
    {
        icon: '✨',
        title: 'Evolving Features',
        description: 'This is just the beginning. Regular updates bring new features, integrations, and improvements to supercharge your development.',
    },
]

const pricingFeatures = [
    'Production-ready Docker setup',
    'Advanced authentication system',
    'AI Integrations',
    'Payment integration ready',
    'API endpoints with Sanctum',
    'Comprehensive documentation',
]
const sponsorLinks = {
    github: 'https://github.com/sponsors/pushpak1300',
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

const githubUrl = 'https://github.com/pushpak1300/larasonic'
</script>

<template>
    <WebLayout :can-login="canLogin" :can-register="canRegister">

        <Head title="Build Faster with Larasonic" />

        <!-- Hero Section -->
        <HeroSection data-aos="fade-up" />
        <!-- Features Grid -->
        <!-- <section id="features" class="container mx-auto px-4 py-16 sm:px-6 lg:px-8">
            <h2 class="text-center text-2xl font-bold tracking-tight sm:text-4xl">
                Features ✨
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-center text-muted-foreground">
                Everything you need to ship faste to production without any hassle.
            </p>

            <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <FeaturesCard v-for="feature in features" :key="feature.title" :icon="feature.icon"
                    :title="feature.title" :description="feature.description" />
            </div>
            <div class="mt-6 flex justify-center gap-2">
                <Button as="a" href="https://docs.larasonic.com" target="_blank" rel="noopener noreferrer">
                    <Icon icon="lucide:book-open" class="size-4" aria-hidden="true" />
                    Documentation
                </Button>
                <Button variant="secondary" as="a" :href="`${githubUrl}/discussions/categories/roadmap`" target="_blank"
                    rel="noopener noreferrer">
                    <Icon icon="lucide:construction" class="size-4" aria-hidden="true" />
                    Roadmap
                </Button>
            </div>
        </section> -->
        <FeaturesSection id="features" data-aos="fade-up" data-aos-offset="200" data-aos-duration="1000"
            data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
            data-aos-anchor-placement="top-center" data-aos-anchor=".hero-section" />
        <FeaturedFeaturesSection />
        <TestimonialSection />
        <!-- <section id="pricing" class="border-t">
            <div class="container mx-auto px-4 py-16 sm:px-6 lg:px-8">

                <div class="mx-auto max-w-3xl text-center">
                    <h2 class="text-center text-2xl font-bold tracking-tight sm:text-4xl">
                        Proudly Open Source 🤑
                    </h2>
                    <p class="mx-auto mt-4 max-w-2xl text-center text-muted-foreground">
                        Larasonic is and will always be open source. No hidden fees, no premium features.
                    </p>
                </div>


                <PricingCard class="mx-auto mt-16" :features="pricingFeatures" :price="0" plan="What's included ?"
                    billing-period="Free Forever">
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

<div class="mx-auto mt-16 text-center">
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
</section> -->
        <CTASection />
        <!-- CTA Section -->
        <!-- <section class="border-t">
            <div class="container mx-auto px-4 py-16 sm:px-6 lg:px-8">
                <div class="rounded-2xl px-6 py-12We sm:p-16">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-3xl font-bold tracking-tight sm:text-6xl">
                            Ready to ship faster?
                        </h2>
                        <p class="mx-auto mt-4 max-w-xl text-lg">
                            You're already blazing fast with Laravel.<br> Larasonic is about to make your shipping speed
                            supersonic. 🚀
                        </p>
                        <div class="mt-8 flex justify-center gap-4">
                            <Button :as="Link" :href="githubUrl" target="_blank" rel="noopener noreferrer">
                                View on GitHub
                            </Button>
                        </div>
                    </div>
                </div>
                <div class="mx-auto w-full sm:w-2/3 items-center justify-center">
                    <Terminal />
                </div>
            </div>
        </section> -->
    </WebLayout>
</template>
