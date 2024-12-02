<script setup>
import InputError from '@/Components/InputError.vue'
import AuthenticationCardLogo from '@/Components/LogoRedirect.vue'
import Button from '@/Components/shadcn/ui/button/Button.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/shadcn/ui/card'
import Checkbox from '@/Components/shadcn/ui/checkbox/Checkbox.vue'
import Input from '@/Components/shadcn/ui/input/Input.vue'
import Label from '@/Components/shadcn/ui/label/Label.vue'
import { cn } from '@/lib/utils'
import { Icon } from '@iconify/vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { inject } from 'vue'

defineProps({
  canResetPassword: Boolean,
  status: String,
})
const route = inject('route')
const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function submit() {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <Head title="Log in" />

  <div class="flex min-h-screen flex-col items-center justify-center">
    <Card class="mx-auto max-w-lg" :class="cn('w-[380px]')">
      <CardHeader>
        <CardTitle class="flex justify-center">
          <AuthenticationCardLogo />
        </CardTitle>
        <CardDescription class="text-center text-2xl">
          Welcome back
        </CardDescription>
      </CardHeader>

      <CardContent>
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
          {{ status }}
        </div>

        <form @submit.prevent="submit">
          <div class="grid gap-4">
            <div class="grid gap-2">
              <Label for="email">Email</Label>
              <Input
                id="email" v-model="form.email" type="email" placeholder="m@example.com" required
                autofocus autocomplete="username"
              />
              <InputError :message="form.errors.email" />
            </div>

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

            <div class="flex items-center space-x-2">
              <Checkbox id="remember" v-model:checked="form.remember" name="remember" />
              <label for="remember" class="text-sm text-muted-foreground">
                Remember me
              </label>
            </div>

            <Button
              type="submit" class="w-full" :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Log in
            </Button>
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
            <Button variant="outline" as="a" :disabled="isLoading" :href="route('oauth.redirect', { provider: 'github' })">
              <Icon v-if="isLoading" icon="lucide:loader2" class="mr-2 h-4 w-4 animate-spin" />
              <Icon v-else icon="lucide:github" class="mr-2 h-4 w-4" />
              Sign In With GitHub
            </Button>

            <Button variant="outline" type="button" :disabled="isLoading">
              <Icon v-if="isLoading" icon="lucide:loader2" class="mr-2 h-4 w-4 animate-spin" />
              <Icon v-else icon="devicon:google" class="mr-2 h-4 w-4" />
              Sign In With Google
            </Button>

            <Button variant="outline" type="button" :disabled="isLoading">
              <Icon v-if="isLoading" icon="lucide:loader2" class="mr-2 h-4 w-4 animate-spin" />
              <Icon v-else icon="lucide:mail" class="mr-2 h-4 w-4" />
              Sign In With Magic Link
            </Button>

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
