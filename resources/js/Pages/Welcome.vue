<script setup>
import Button from '@/Components/shadcn/ui/button/Button.vue'
import { Head, Link } from '@inertiajs/vue3'
import {
  CodeIcon,
  ContainerIcon,
  CreditCardIcon,
  GithubIcon,
  KeyIcon,
  LayoutDashboardIcon,
  MessageSquareIcon,
  RocketIcon,
  TwitterIcon,
} from 'lucide-vue-next'

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
  <Head title="Welcome" />
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
            <div class="inline-block bg-primary/10 rounded-lg px-3 py-1 text-sm">
              Using PHP 8.3+, Laravel 11, Inertia 2.0 and Tailwind CSS 4
            </div>
            <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl">
              The Ultimate Laravel <span>Starter Kit</span> for Modern SASS
            </h1>
            <p class="mt-4 text-xl">
              Build production-ready applications 10x faster with our opinionated stack powered by
              Laravel Jetstream, Inertia V2, and Shadcn/ui.
            </p>
            <div class="mt-8 flex">
              <Button>
                <Link
                  href="https://github.com/pushpak1300/larasonic" target="_blank"
                  rel="noopener"
                  class="flex items-center gap-2"
                >
                  <GithubIcon class="size-4" />Star Repo
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
        <!-- Development Experience -->
        <div class="rounded-lg border bg-card p-6 shadow-sm">
          <RocketIcon class="h-12 w-12 text-primary" />
          <h3 class="mt-4 text-xl font-semibold">
            10x Dev Experience
          </h3>
          <p class="mt-2 text-muted-foreground">
            Ships with opinionated Pint rules and maximum PHPStan support for enhanced code quality and
            developer productivity.
          </p>
        </div>

        <!-- Docker Ready -->
        <div class="rounded-lg border bg-card p-6 shadow-sm">
          <ContainerIcon class="h-12 w-12 text-primary" />
          <h3 class="mt-4 text-xl font-semibold">
            Production Docker Ready
          </h3>
          <p class="mt-2 text-muted-foreground">
            Optimized Docker images with Laravel Octane and Sail for lightning-fast development and
            deployment.
          </p>
        </div>

        <!-- Authentication -->
        <div class="rounded-lg border bg-card p-6 shadow-sm">
          <KeyIcon class="h-12 w-12 text-primary" />
          <h3 class="mt-4 text-xl font-semibold">
            Advanced Authentication
          </h3>
          <p class="mt-2 text-muted-foreground">
            Complete authentication system with social login, magic links, and role-based access
            control.
          </p>
        </div>

        <!-- Admin Panel -->
        <div class="rounded-lg border bg-card p-6 shadow-sm">
          <LayoutDashboardIcon class="h-12 w-12 text-primary" />
          <h3 class="mt-4 text-xl font-semibold">
            FilamentPHP Admin
          </h3>
          <p class="mt-2 text-muted-foreground">
            Beautiful admin panel powered by FilamentPHP with CRUD operations, charts, and detailed
            analytics.
          </p>
        </div>

        <!-- Payment Integration -->
        <div class="rounded-lg border bg-card p-6 shadow-sm">
          <CreditCardIcon class="h-12 w-12 text-primary" />
          <h3 class="mt-4 text-xl font-semibold">
            Payment Ready
          </h3>
          <p class="mt-2 text-muted-foreground">
            Integrated payment processing with Stripe and Paddle for subscriptions and one-time
            payments.
          </p>
        </div>

        <!-- API Ready -->
        <div class="rounded-lg border bg-card p-6 shadow-sm">
          <CodeIcon class="h-12 w-12 text-primary" />
          <h3 class="mt-4 text-xl font-semibold">
            API Ready
          </h3>
          <p class="mt-2 text-muted-foreground">
            RESTful API endpoints with Laravel Sanctum authentication and comprehensive documentation.
          </p>
        </div>
      </div>
    </section>
    <!-- CTA Section -->
    <section class="border-t">
      <div class="container mx-auto px-4 py-16 sm:px-6 lg:px-8">
        <div class="rounded-2xl px-6 py-16 sm:p-16">
          <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">
              Ready to build faster?
            </h2>
            <p class="mx-auto mt-4 max-w-xl text-lg ">
              Start building your next project with our production-ready starter kit.
            </p>
            <div class="mt-8 flex justify-center gap-4">
              <a
                href="/docs"
                class="inline-flex items-center justify-center rounded-md bg-background px-6 py-3 text-sm font-medium text-foreground shadow transition-colors hover:bg-accent"
              >
                Get Started
              </a>
              <Link
                as="button" href="https://github.com/pushpak1300/larasonic" target="_blank"
                rel="noopener"
                class="inline-flex items-center justify-center rounded-md border border-primary-foreground/20 bg-transparent px-6 py-3 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary-foreground/10"
              >
                View on GitHub
              </Link>
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
            © 2024 Laravel Starter Kit. Open source under MIT license.
          </p>
          <div class="flex gap-4">
            <a
              href="https://github.com" target="_blank" rel="noopener"
              class="text-muted-foreground hover:text-foreground"
            >
              <GithubIcon class="h-5 w-5" />
            </a>
            <a
              href="https://twitter.com" target="_blank" rel="noopener"
              class="text-muted-foreground hover:text-foreground"
            >
              <TwitterIcon class="h-5 w-5" />
            </a>
            <a
              href="https://discord.com" target="_blank" rel="noopener"
              class="text-muted-foreground hover:text-foreground"
            >
              <MessageSquareIcon class="h-5 w-5" />
            </a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>
