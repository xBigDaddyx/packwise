<script setup>
import Button from '@/Components/shadcn/ui/button/Button.vue'
import { cn } from '@/lib/utils'
import { Icon } from '@iconify/vue'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
})

const navLinks = [
  { label: 'Features', href: '/#features' },
  { label: 'Pricing', href: '/pricing' },
]

const githubUrl = 'https://github.com/pushpak1300/larasonic'

const isMenuOpen = ref(false)

function toggleMenu() {
  isMenuOpen.value = !isMenuOpen.value
}
</script>

<template>
  <div class="min-h-screen">
    <header class="sticky top-0 z-50 w-full border-b backdrop-blur">
      <div class="container flex h-16 items-center justify-between">
        <div class="flex items-center">
          <a class="flex items-center space-x-2" href="/" aria-label="Larasonic">
            <Icon icon="lucide:rocket" class="size-6" aria-hidden="true" />
            <span class="hidden font-bold sm:inline-block">Larasonic</span>
          </a>
        </div>
        <nav class="hidden md:flex gap-6">
          <Link
            v-for="link in navLinks" :key="link.href" :href="link.href"
            :class="cn('flex items-center text-sm font-medium transition-colors hover:text-foreground/80')"
          >
            {{ link.label }}
          </Link>
        </nav>
        <div class="flex items-center space-x-4">
          <template v-if="!$page.props.auth.user">
            <Button
              v-if="canLogin" variant="secondary" :as="Link" href="/login"
              class="hidden sm:inline-flex"
            >
              Login
            </Button>
            <Button
              v-if="canRegister" variant="secondary" :as="Link" href="/register"
              class="hidden sm:inline-flex"
            >
              Register
            </Button>
          </template>
          <Button v-else variant="secondary" :as="Link" href="/dashboard" class="hidden sm:inline-flex">
            Dashboard
          </Button>
          <Button class="md:hidden" variant="ghost" size="icon" aria-label="Toggle menu" @click="toggleMenu">
            <Icon v-if="!isMenuOpen" icon="lucide:menu" class="size-6" aria-hidden="true" />
            <Icon v-else icon="lucide:x" class="size-6" aria-hidden="true" />
          </Button>
        </div>
      </div>
      <!-- Mobile menu -->
      <div v-show="isMenuOpen" class="md:hidden">
        <nav class="flex flex-col p-4 space-y-4 border-t">
          <Link
            v-for="link in navLinks" :key="link.href" :href="link.href" class="text-sm font-medium"
            @click="toggleMenu"
          >
            {{ link.label }}
          </Link>
          <template v-if="!$page.props.auth.user">
            <Button
              v-if="canLogin" variant="secondary" :as="Link" href="/login" class="w-full"
              @click="toggleMenu"
            >
              Login
            </Button>
            <Button
              v-if="canRegister" variant="secondary" :as="Link" href="/register" class="w-full"
              @click="toggleMenu"
            >
              Register
            </Button>
          </template>
          <Button v-else variant="secondary" :as="Link" href="/dashboard" class="w-full" @click="toggleMenu">
            Dashboard
          </Button>
        </nav>
      </div>
    </header>

    <slot />

    <!-- Footer -->
    <footer class="border-t">
      <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
          <p class="text-sm flex items-center gap-2 text-center sm:text-left">
            <Icon icon="lucide:rocket" class="size-6" aria-hidden="true" />
            Crafted with ❤️ by <a
              class="underline" href="https://x.com/pushpak1300?ref=larasonic"
              target="_blank" rel="noopener noreferrer"
            >
              Pushpak.
            </a>
            <span class="hidden sm:inline">
              The source code is available on
              <a
                class="underline" href="https://github.com/pushpak1300/larasonic" target="_blank"
                rel="noopener noreferrer"
              >
                GitHub.
              </a>
            </span>
          </p>
          <div class="flex gap-4">
            <a
              :href="githubUrl" target="_blank" rel="noopener noreferrer"
              class="text-muted-foreground hover:text-foreground" aria-label="GitHub"
            >
              <Icon icon="lucide:github" class="h-5 w-5" aria-hidden="true" />
            </a>
            <a
              href="https://twitter.com/pushpak1300" target="_blank" rel="noopener noreferrer"
              class="text-muted-foreground hover:text-foreground" aria-label="Twitter"
            >
              <Icon icon="lucide:twitter" class="h-5 w-5" aria-hidden="true" />
            </a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>
