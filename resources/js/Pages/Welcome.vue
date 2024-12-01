<script setup>
import FeaturesCard from '@/Components/FeaturesCard.vue'
import Badge from '@/Components/shadcn/ui/badge/Badge.vue'
import Button from '@/Components/shadcn/ui/button/Button.vue'
import { Icon } from '@iconify/vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
})
</script>

<template>
  <Head title="Build Faster with Larasonic" />
  <div class="min-h-screen">
    <header class="sticky top-0 z-50 w-full border-b backdrop-blur">
      <div class="container flex h-16 items-center">
        <div class="mr-4 flex">
          <a class="mr-6 flex items-center space-x-2" href="/">
            <span class="hidden font-bold sm:inline-block">
              🚀 Larasonic
            </span>
          </a>
          <nav class="flex items-center space-x-6 text-sm font-medium">
            <a class="transition-colors" href="#features">Github</a>
          </nav>
        </div>
        <div class="flex flex-1 items-center justify-end space-x-4">
          <nav class="flex items-center space-x-4">
            <Link v-if="canLogin" href="/login" class="text-sm font-medium">
              Login
            </Link>
            <Link v-if="canRegister" href="/register" class="text-sm font-medium">
              Register
            </Link>
          </nav>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden border-b">
      <div class="container mx-auto px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-2 lg:gap-16">
          <div class="flex flex-col justify-center">
            <Badge variant="outline" class="inline-block bg-primary/10 rounded-lg px-3 py-1 text-sm">
              Using PHP 8.3+, Laravel 11, Inertia 2.0 and Tailwind CSS 3.4+
            </Badge>
            <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl">
              The Ultimate Laravel <span>Starter Kit</span> for Modern SASS
            </h1>
            <p class="mt-4 text-xl">
              Build production-ready applications 10x faster with free opinionated starter kit powered by
              Laravel Jetstream, Inertia V2, and Shadcn/ui.
            </p>
            <div class="mt-8 flex">
              <Button>
                <Link
                  href="https://github.com/pushpak1300/larasonic" target="_blank" rel="noopener"
                  class="flex items-center gap-2"
                >
                  <Icon icon="lucide:github" class="size-4" />Star Repo
                </Link>
              </Button>
            </div>
          </div>
          <div class="relative">
            <div class="relative rounded-lg border bg-card p-2 shadow-2xl">
              <img src="/images/dashboard.png" alt="Dashboard Preview" class="rounded-md">
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Grid -->
    <section class="container mx-auto px-4 py-16 sm:px-6 lg:px-8">
      <h2 class="text-center text-3xl font-bold tracking-tight sm:text-4xl">
        Everything you need to ship faster 🚀
      </h2>
      <p class="mx-auto mt-4 max-w-2xl text-center text-muted-foreground">
        Production-ready features that help you focus on what matters - building your product.
      </p>

      <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        <FeaturesCard
          icon="lucide:rocket" title="10x Dev Experience"
          description="Ship faster with opinionated Laravel Pint, maximum PHPStan level, and Rector for enhanced code quality and developer productivity."
        />

        <FeaturesCard
          icon="lucide:container" title="Production Docker Ready"
          description="Optimized Docker images with Laravel Octane and Sail for lightning-fast development and deployment."
        />

        <FeaturesCard
          icon="lucide:key" title="Advanced Authentication"
          description="Complete authentication system with social login, magic links, and role-based access control."
        />

        <FeaturesCard
          icon="lucide:layout-dashboard" title="FilamentPHP Admin"
          description="Beautiful admin panel powered by FilamentPHP with CRUD operations, charts, and detailed analytics."
        />

        <FeaturesCard
          icon="lucide:credit-card" title="Payment Ready"
          description="Integrated Laravel Cashier for subscription billing and payment processing so you can focus on building your product."
        />

        <FeaturesCard
          icon="lucide:code" title="API Ready"
          description="RESTful API endpoints with Laravel Sanctum authentication and comprehensive documentation."
        />

        <FeaturesCard
          icon="lucide:palette" title="Customizable UI"
          description="Built with shadcn/ui components, making UI customization a breeze. Easily modify themes, styles, and components to match your brand."
        />

        <FeaturesCard
          icon="lucide:brain" title="AI Integration Ready"
          description="Pre-configured LLM integrations for OpenAI, Anthropic, and more. Build AI-powered features into your app with minimal setup."
        />

        <FeaturesCard
          icon="lucide:sparkles" title="Evolving Features"
          description="This is just the beginning. Regular updates bring new features, integrations, and improvements to supercharge your development."
        />
      </div>
    </section>
    <!-- CTA Section -->
    <section class="border-t">
      <div class="container mx-auto px-4 py-16 sm:px-6 lg:px-8">
        <div class="rounded-2xl px-6 py-16 sm:p-16">
          <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">
              Ready to ship faster?
            </h2>
            <p class="mx-auto mt-4 max-w-xl text-lg ">
              You're already blazing fast with Laravel.<br> Larasonic is about to make your shipping speed
              supersonic. 🚀
            </p>
            <div class="mt-8 flex justify-center gap-4">
              <Button
                :as="Link" href="https://github.com/pushpak1300/larasonic" target="_blank"
                rel="noopener"
              >
                View on GitHub
              </Button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="border-t">
      <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
          <p class="text-sm text-muted-foreground">
            © 2024 Larasonic. Crafted with ❤️ by <a
              class="underline"
              href="https://pushpak1300.me?ref=larasonic"
            > Pushpak.</a>
          </p>
          <div class="flex gap-4">
            <a
              href="https://github.com/pushpak1300/larasonic" target="_blank" rel="noopener"
              class="text-muted-foreground hover:text-foreground"
            >
              <Icon icon="lucide:github" class="h-5 w-5" />
            </a>
            <a
              href="https://twitter.com/pushpak1300" target="_blank" rel="noopener"
              class="text-muted-foreground hover:text-foreground"
            >
              <Icon icon="lucide:twitter" class="h-5 w-5" />
            </a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>
