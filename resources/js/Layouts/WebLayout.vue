<script setup>
import Button from '@/Components/shadcn/ui/button/Button.vue'
import { cn } from '@/lib/utils'
import { Icon } from '@iconify/vue'
import { Link } from '@inertiajs/vue3'
import { useColorMode } from '@vueuse/core'
import { ref } from 'vue'

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
})

const mode = useColorMode({
  attribute: 'class',
  modes: {
    light: '',
    dark: 'dark',
  },
})

const navLinks = [
  { label: 'Features', href: '/#features', external: false },
  { label: 'Pricing', href: '/pricing', external: false },
  { label: 'Docs', href: 'https://docs.larasonic.com/introduction', external: true },
]

const githubUrl = 'https://github.com/pushpak1300/larasonic'
const twitterUrl = 'https://x.com/pushpak1300?ref=larasonic'

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
          <template v-for="link in navLinks" :key="link.href">
            <a
              v-if="link.external"
              :href="link.href"
              target="_blank"
              rel="noopener noreferrer"
              :class="cn('flex items-center text-sm font-medium transition-colors hover:text-foreground/80')"
            >
              {{ link.label }}
            </a>
            <Link
              v-else
              :href="link.href"
              :class="cn('flex items-center text-sm font-medium transition-colors hover:text-foreground/80')"
            >
              {{ link.label }}
            </Link>
          </template>
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
            Crafted by<a
              class="underline" :href="twitterUrl" target="_blank"
              rel="noopener noreferrer"
            >Pushpak.
            </a>
            <span class="hidden sm:inline">
              Hosted On <a
                class="underline" href="https://sevalla.com/?ref=larasonic" target="_blank"
                rel="noopener noreferrer"
              >
                Sevalla
              </a>
              ❤️
            </span>
          </p>
          <div class="flex gap-4">
            <Icon
              class="text-muted-foreground" :icon="mode === 'dark' ? 'lucide:sun' : 'lucide:moon'"
              @click="mode = mode === 'dark' ? 'light' : 'dark'"
            />

            <a
              :href="githubUrl" target="_blank" rel="noopener noreferrer"
              class="text-muted-foreground hover:text-foreground" aria-label="GitHub"
            >
              <Icon icon="mdi:github" class="h-5 w-5" aria-hidden="true" />
            </a>
            <a
              :href="twitterUrl" target="_blank" rel="noopener noreferrer"
              class="text-muted-foreground hover:text-foreground" aria-label="Twitter"
            >
              <Icon icon="ri:twitter-x-line" class="h-5 w-5" aria-hidden="true" />
            </a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>
