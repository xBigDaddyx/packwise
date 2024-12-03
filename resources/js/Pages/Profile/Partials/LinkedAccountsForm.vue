<script setup>
import ActionSection from '@/Components/ActionSection.vue'
import Label from '@/Components/shadcn/ui/label/Label.vue'
import Switch from '@/Components/shadcn/ui/switch/Switch.vue'
import oauthProviders from '@/lib/oauthProvider'
import { Icon } from '@iconify/vue'
import { router, usePage } from '@inertiajs/vue3'
import { useChangeCase } from '@vueuse/integrations/useChangeCase'
import { inject } from 'vue'
import { toast } from 'vue-sonner'

const props = defineProps({
  availableProviders: {
    type: Array,
    default: () => [],
  },
  activeProviders: {
    type: Array,
    default: () => [],
  },
})

const filteredOauthProviders = oauthProviders.filter(provider => props.availableProviders.includes(provider.provider))

const route = inject('route')

const page = usePage()

function toggleLink(provider) {
  if (!props.activeProviders.includes(provider)) {
    window.location.href = route('oauth.redirect', { provider })
    return
  }

  router.delete(route('oauth.destroy', { provider }), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success(page.props.flash.success)
    },
    onError: () => {
      toast.error(page.props.flash.message)
    },
  })
}
</script>

<template>
  <ActionSection v-if="filteredOauthProviders.length > 0">
    <template #title>
      Linked Accounts
    </template>

    <template #description>
      Manage your linked social accounts for easier login access.
    </template>

    <template #content>
      <div class="max-w-xl text-sm">
        Link your accounts to enable single sign-on and manage your connected social profiles.
      </div>

      <div>
        <div
          v-for="provider in filteredOauthProviders" :key="provider.provider"
          class="flex items-center space-x-4 rounded-md border p-4 mt-4"
        >
          <Icon :icon="provider.icon" class="size-8" />
          <div class="flex-1 space-y-1">
            <Label>
              {{ useChangeCase(provider.provider, 'sentenceCase') }}
            </Label>
          </div>
          <Switch
            :checked="activeProviders.includes(provider.provider)"
            @update:checked="toggleLink(provider.provider)"
            @update:unchecked="toggleLink(provider.provider)"
          />
        </div>
      </div>
    </template>
  </ActionSection>
</template>
