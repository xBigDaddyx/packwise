<script setup>
import { Avatar, AvatarFallback } from '@/Components/shadcn/ui/avatar'
import AvatarImage from '@/Components/shadcn/ui/avatar/AvatarImage.vue'
import Breadcrumb from '@/Components/shadcn/ui/breadcrumb/Breadcrumb.vue'
import BreadcrumbItem from '@/Components/shadcn/ui/breadcrumb/BreadcrumbItem.vue'
import BreadcrumbLink from '@/Components/shadcn/ui/breadcrumb/BreadcrumbLink.vue'
import BreadcrumbList from '@/Components/shadcn/ui/breadcrumb/BreadcrumbList.vue'
import {
  Command,
  CommandGroup,
  CommandInput,
  CommandItem,
  CommandSeparator,
} from '@/Components/shadcn/ui/command'
import CommandEmpty from '@/Components/shadcn/ui/command/CommandEmpty.vue'
import CommandList from '@/Components/shadcn/ui/command/CommandList.vue'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/Components/shadcn/ui/dropdown-menu'
import DropdownMenuGroup from '@/Components/shadcn/ui/dropdown-menu/DropdownMenuGroup.vue'

import Separator from '@/Components/shadcn/ui/separator/Separator.vue'
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarInset } from '@/Components/shadcn/ui/sidebar'
import SidebarGroup from '@/Components/shadcn/ui/sidebar/SidebarGroup.vue'
import SidebarGroupLabel from '@/Components/shadcn/ui/sidebar/SidebarGroupLabel.vue'
import SidebarMenu from '@/Components/shadcn/ui/sidebar/SidebarMenu.vue'
import SidebarMenuButton from '@/Components/shadcn/ui/sidebar/SidebarMenuButton.vue'
import SidebarMenuItem from '@/Components/shadcn/ui/sidebar/SidebarMenuItem.vue'
import SidebarProvider from '@/Components/shadcn/ui/sidebar/SidebarProvider.vue'
import SidebarTrigger from '@/Components/shadcn/ui/sidebar/SidebarTrigger.vue'
import Sonner from '@/Components/shadcn/ui/sonner/Sonner.vue'
import { Icon } from '@iconify/vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { useColorMode } from '@vueuse/core'
import { inject, ref } from 'vue'

defineProps({
  title: String,
})
const route = inject('route')
const mode = useColorMode({
  attribute: 'class',
  modes: {
    light: '',
    dark: 'dark',
  },
})

const open = ref(false)

function switchToTeam(team) {
  router.put(route('current-team.update'), {
    team_id: team.id,
  }, {
    preserveState: false,
  })
}

function logout() {
  router.post(route('logout'))
}
</script>

<template>
  <div>
    <Head :title="title" />
    <Sonner position="top-center" />
    <SidebarProvider>
      <Sidebar collapsible="icon">
        <SidebarHeader>
          <SidebarMenu>
            <SidebarMenuItem>
              <DropdownMenu v-if="$page.props.jetstream.hasTeamFeatures" v-model:open="open">
                <DropdownMenuTrigger as-child>
                  <SidebarMenuButton
                    size="lg"
                    class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                  >
                    <div
                      class="flex aspect-square size-8 items-center justify-center rounded-lg bg-primary text-primary-foreground"
                    >
                      <Icon icon="lucide:rocket" />
                    </div>
                    <div class="grid flex-1 text-left text-sm leading-tight">
                      <span class="truncate font-semibold">{{
                        $page.props.auth.user.current_team.name }}</span>
                      <span class="truncate text-xs">Manage Team</span>
                    </div>
                    <Icon icon="lucide:chevrons-up-down" class="ml-auto size-4" />
                  </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                  class="w-[--radix-dropdown-menu-trigger-width] min-w-56 rounded-lg p-0"
                  align="start" side="bottom" :side-offset="4"
                >
                  <Command
                    :filter-function="(list, term) => list.filter(i => i?.name?.toLowerCase()?.includes(term))"
                  >
                    <CommandList>
                      <CommandInput placeholder="Search team..." />
                      <CommandEmpty>No team found.</CommandEmpty>
                      <CommandGroup heading="Switch Teams">
                        <CommandItem
                          v-for="team in $page.props.auth.user.all_teams"
                          :key="team.value" :value="team" @select="() => {
                            switchToTeam(team);
                            open = false;
                          }"
                        >
                          <Avatar class="mr-2 size-5">
                            <AvatarFallback>{{ team.name.charAt(0) }}</AvatarFallback>
                          </Avatar>
                          {{ team.name }}
                          <Icon
                            v-if="team.id === $page.props.auth.user.current_team_id"
                            icon="lucide:check" class="ml-auto size-4"
                          />
                        </CommandItem>
                      </CommandGroup>
                    </CommandList>
                    <CommandSeparator v-if="$page.props.auth.user.all_teams.length > 1" />
                    <CommandGroup heading="Manage Team">
                      <CommandItem value="team-settings">
                        <Link :href="route('teams.show', $page.props.auth.user.current_team)">
                          Team Settings
                        </Link>
                      </CommandItem>
                      <CommandItem
                        v-if="$page.props.jetstream.canCreateTeams"
                        value="create-new-team"
                      >
                        <Link :href="route('teams.create')">
                          Create New Team
                        </Link>
                      </CommandItem>
                    </CommandGroup>
                  </Command>
                </DropdownMenuContent>
              </DropdownMenu>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarHeader>
        <SidebarContent>
          <SidebarGroup>
            <SidebarGroupLabel>Platform</SidebarGroupLabel>
            <SidebarMenu>
              <SidebarMenuItem
                :class="{ 'font-semibold text-primary bg-secondary rounded': route().current('dashboard') }"
              >
                <SidebarMenuButton as-child>
                  <Link :href="route('dashboard')">
                    <Icon icon="lucide:layout-dashboard" />
                    Dashboard
                  </Link>
                </SidebarMenuButton>
              </SidebarMenuItem>

              <SidebarMenuItem
                :class="{ 'font-semibold text-primary bg-secondary rounded': route().current('profile.show') }"
              >
                <SidebarMenuButton as-child>
                  <Link :href="route('profile.show')">
                    <Icon icon="lucide:settings" />
                    Settings
                  </Link>
                </SidebarMenuButton>
              </SidebarMenuItem>

              <SidebarMenuItem
                :class="{ 'font-semibold text-primary bg-secondary rounded': route().current('chat.index') }"
              >
                <SidebarMenuButton as-child>
                  <Link :href="route('chat.index')">
                    <Icon icon="lucide:message-circle" />
                    Chat
                  </Link>
                </SidebarMenuButton>
              </SidebarMenuItem>
            </SidebarMenu>
          </SidebarGroup>
          <SidebarGroup class="mt-auto">
            <SidebarMenu>
              <SidebarMenuItem>
                <SidebarMenuButton @click="mode = mode === 'dark' ? 'light' : 'dark'">
                  <Icon :icon="mode === 'dark' ? 'lucide:moon' : 'lucide:sun'" />
                  {{ mode === 'dark' ? 'Dark' : 'Light' }} Mode
                </SidebarMenuButton>
              </SidebarMenuItem>
            </SidebarMenu>
          </SidebarGroup>
        </SidebarContent>
        <SidebarFooter>
          <SidebarMenu>
            <SidebarMenuItem>
              <DropdownMenu>
                <DropdownMenuTrigger as-child>
                  <SidebarMenuButton
                    size="lg"
                    class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                  >
                    <Avatar class="h-8 w-8 rounded-lg">
                      <AvatarImage
                        :src="$page.props.auth.user. profile_photo_path ?? ''"
                        :alt="$page.props.auth.user.name"
                      />
                      <AvatarFallback class="rounded-lg">
                        {{ $page.props.auth.user.name.charAt(0) }}
                      </AvatarFallback>
                    </Avatar>
                    <div class="grid flex-1 text-left text-sm leading-tight">
                      <span class="truncate font-semibold">{{ $page.props.auth.user.name }}</span>
                      <span class="truncate text-xs">{{ $page.props.auth.user.email }}</span>
                    </div>
                    <Icon icon="lucide:chevrons-up-down" class="ml-auto size-4" />
                  </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                  class="w-[--radix-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                  side="bottom" align="end" :side-offset="4"
                >
                  <DropdownMenuLabel class="p-0 font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                      <Avatar class="h-8 w-8 rounded-lg">
                        <AvatarImage
                          :src="$page.props.auth.user. profile_photo_path ?? ''"
                          :alt="$page.props.auth.user.name"
                        />
                        <AvatarFallback class="rounded-lg">
                          {{ $page.props.auth.user.name.charAt(0) }}
                        </AvatarFallback>
                      </Avatar>
                      <div class="grid flex-1 text-left text-sm leading-tight">
                        <span class="truncate font-semibold">{{ $page.props.auth.user.name
                        }}</span>
                        <span class="truncate text-xs">{{ $page.props.auth.user.email }}</span>
                      </div>
                    </div>
                  </DropdownMenuLabel>
                  <DropdownMenuSeparator />
                  <DropdownMenuGroup>
                    <DropdownMenuItem :as="Link" :href="route('profile.show')">
                      <Icon icon="lucide:settings" />
                      Settings
                    </DropdownMenuItem>
                    <DropdownMenuItem :as="Link" :href="route('api-tokens.index')">
                      <Icon icon="lucide:key" />
                      API Tokens
                    </DropdownMenuItem>
                    <DropdownMenuItem :as="Link" :href="route('subscriptions.create')">
                      <Icon icon="lucide:credit-card" />
                      Billing
                    </DropdownMenuItem>
                  </DropdownMenuGroup>
                  <DropdownMenuSeparator />
                  <DropdownMenuItem @click="logout">
                    <Icon icon="lucide:log-out" />
                    Log out
                  </DropdownMenuItem>
                </DropdownMenuContent>
              </DropdownMenu>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarFooter>
      </Sidebar>
      <SidebarInset>
        <header
          class="flex h-16 shrink-0 items-center gap-2 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12"
        >
          <div class="flex items-center gap-2 px-4">
            <SidebarTrigger class="-ml-1" />
            <Separator orientation="vertical" class="mr-2 h-4 hidden md:block" />
            <Breadcrumb>
              <BreadcrumbList>
                <BreadcrumbItem>
                  <BreadcrumbLink>
                    {{ title }}
                  </BreadcrumbLink>
                </BreadcrumbItem>
              </BreadcrumbList>
            </Breadcrumb>
          </div>
        </header>
        <main class="flex flex-1 flex-col gap-4 p-4 pt-0">
          <slot />
        </main>
      </SidebarInset>
    </SidebarProvider>
  </div>
</template>
