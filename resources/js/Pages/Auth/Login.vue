<script setup>
import InputError from '@/Components/InputError.vue'
import AuthenticationCardLogo from '@/Components/LogoRedirect.vue'
import Button from '@/Components/shadcn/ui/button/Button.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/shadcn/ui/card'
import Checkbox from '@/Components/shadcn/ui/checkbox/Checkbox.vue'
import Input from '@/Components/shadcn/ui/input/Input.vue'
import Label from '@/Components/shadcn/ui/label/Label.vue'
import Sonner from '@/Components/shadcn/ui/sonner/Sonner.vue'
import oauthProviders from '@/lib/oauthProvider'
import { cn } from '@/lib/utils'
import { Icon } from '@iconify/vue'
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import { useChangeCase } from '@vueuse/integrations/useChangeCase'
import { computed, inject, onMounted } from 'vue'
import { toast } from 'vue-sonner'

const props = defineProps({
  canResetPassword: Boolean,
  status: String,
  availableOauthProviders: Array,
})

const page = usePage()
const route = inject('route')

const filteredOauthProviders = computed(() =>
  oauthProviders.filter(provider => props.availableOauthProviders.includes(provider.provider)),
)

const form = useForm({
  email: '',
  password: '',
  remember: false,
})
function handleSubmit() {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onSuccess: () => toast.success(page.props.flash.success),
    onError: () => toast.error(page.props.flash.error),
    onFinish: () => form.reset('password'),
  })
}

onMounted(() => {
  if (page.props.flash.success) {
    toast.success(page.props.flash.success)
  }
  if (page.props.flash.error) {
    toast.error(page.props.flash.error)
  }
})
</script>

<template>
  <Head title="Log in" />
  <Sonner position="top-center" />
  <div class="flex min-h-screen flex-col items-center justify-center">
    <Card class="mx-auto max-w-lg" :class="cn('w-[380px]')">
      <!-- Header -->
      <CardHeader>
        <CardTitle class="flex justify-center">
          <AuthenticationCardLogo />
        </CardTitle>
        <CardDescription class="text-center text-2xl">
          Log In
        </CardDescription>
      </CardHeader>

      <CardContent>
        <!-- Status Message -->
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
          {{ status }}
        </div>

        <!-- Login Form -->
        <form @submit.prevent="handleSubmit">
          <div class="grid gap-4">
            <!-- Email Field -->
            <div class="grid gap-2">
              <Label for="email">Email</Label>
              <Input
                id="email" v-model="form.email" type="email" placeholder="m@example.com" required
                autofocus autocomplete="username"
              />
              <InputError :message="form.errors.email" />
            </div>

            <!-- Password Field -->
            <div class="grid gap-2">
              <div class="flex items-center justify-between">
                <Label for="password">Password</Label>
                <Link
                  v-if="canResetPassword" :href="route('password.request')"
                  class="text-sm text-muted-foreground underline hover:text-primary"
                >
                  Forgot your password?
                </Link>
              </div>
              <Input
                id="password" v-model="form.password" type="password" required
                autocomplete="current-password"
              />
              <InputError :message="form.errors.password" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center space-x-2">
              <Checkbox id="remember" v-model:checked="form.remember" name="remember" />
              <label for="remember" class="text-sm text-muted-foreground">
                Remember me
              </label>
            </div>

            <!-- Submit Button -->
            <Button
              type="submit" class="w-full" :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Log in
            </Button>

            <!-- OAuth Divider -->
            <div class="relative">
              <div class="absolute inset-0 flex items-center">
                <span class="w-full border-t" />
              </div>
              <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-background px-2 text-muted-foreground">
                  Or continue with
                </span>
              </div>
            </div>

            <!-- OAuth Providers -->
            <Button
              v-for="provider in filteredOauthProviders" :key="provider.provider"
              :disabled="form.processing"
              class="bg-background text-foreground hover:bg-secondary disabled:opacity-50 hover:dark:bg-primary/80 dark:bg-primary dark:text-primary-foreground"
              as="a" :href="route('oauth.redirect', { provider: provider.provider })"
            >
              <Icon :icon="provider.icon" class="mr-2 h-4 w-4" />
              Sign In With {{ useChangeCase(provider.provider, 'sentenceCase') }}
            </Button>

            <!-- Register Link -->
            <div class="text-center text-sm text-muted-foreground">
              Don't have an account?
              <Link :href="route('register')" class="underline hover:text-primary">
                Sign up
              </Link>
            </div>
          </div>
        </form>
      </CardContent>
    </Card>
  </div>
</template>
