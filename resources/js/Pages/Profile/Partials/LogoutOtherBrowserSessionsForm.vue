<script setup>
import ActionMessage from '@/Components/ActionMessage.vue'
import ActionSection from '@/Components/ActionSection.vue'
import ConfirmsPassword from '@/Components/ConfirmsPassword.vue'
import Button from '@/Components/shadcn/ui/button/Button.vue'
import { Icon } from '@iconify/vue'
import { useForm } from '@inertiajs/vue3'
import { inject } from 'vue'

defineProps({
  sessions: Array,
})

const route = inject('route')
const form = useForm({
  password: '',
})

function logoutOtherBrowserSessions(password) {
  form.transform(data => ({
    ...data,
    password,
  })).delete(route('other-browser-sessions.destroy'), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onFinish: () => form.reset(),
  })
}
</script>

<template>
  <ActionSection>
    <template #title>
      Browser Sessions
    </template>

    <template #description>
      Manage and log out your active sessions on other browsers and devices.
    </template>

    <template #content>
      <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
        If necessary, you may log out of all of your other browser sessions across all of your devices. Some of
        your recent sessions are listed below; however, this list may not be exhaustive. If you feel your
        account has been compromised, you should also update your password.
      </div>

      <!-- Other Browser Sessions -->
      <div v-if="sessions.length > 0" class="mt-5 space-y-6">
        <div v-for="(session, i) in sessions" :key="i" class="flex items-center">
          <div>
            <Icon
              v-if="session.agent.is_desktop"
              icon="heroicons:computer-desktop"
              class="size-8 text-gray-500"
            />
            <Icon
              v-else
              icon="heroicons:device-phone-mobile"
              class="size-8 text-gray-500"
            />
          </div>

          <div class="ms-3">
            <div class="text-sm">
              {{ session.agent.platform ? session.agent.platform : 'Unknown' }} - {{ session.agent.browser
                ? session.agent.browser : 'Unknown' }}
            </div>

            <div>
              <div class="text-xs">
                {{ session.ip_address }},

                <span v-if="session.is_current_device" class="font-semibold text-green-400">This
                  device</span>
                <span v-else>Last active {{ session.last_active }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-5 flex items-center">
        <ConfirmsPassword
          title="Log Out Other Browser Sessions"
          content="Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices."
          button="Log Out Other Browser Sessions"
          @confirmed="logoutOtherBrowserSessions"
        >
          <Button>
            Log Out Other Browser Sessions
          </Button>
        </ConfirmsPassword>

        <ActionMessage :on="form.recentlySuccessful" class="ms-3">
          Done.
        </ActionMessage>
      </div>
    </template>
  </ActionSection>
</template>
