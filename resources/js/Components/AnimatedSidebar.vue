<script setup>
import { ref } from "vue";

const isCollapsed = ref(false);

const menuItems = [
    { name: "Dashboard", icon: "icon-home", route: "/dashboard" },
    { name: "Reservations", icon: "icon-calendar", route: "/reservations" },
    { name: "Rooms", icon: "icon-bed", route: "/rooms" },
    { name: "Guests", icon: "icon-user", route: "/guests" },
    { name: "Reports", icon: "icon-chart", route: "/reports" },
];

const logo = "https://dolphin-directory.com/storage/images/logo/dolphin_directory_logo_white.png";
const collapsedLogo = "https://dolphin-directory.com/storage/images/logo/small_logo.png";

function navigate(route) {
    // Replace with router.push(route) if using Vue Router
    console.log(`Navigating to ${route}`);
}

function isActive(route) {
    // Replace with current route logic if using Vue Router
    return false;
}
</script>
<template>
    <div class="flex">
        <!-- Sidebar -->
        <aside :class="[
            'h-screen w-64 bg-gray-900 text-white flex flex-col transition-all duration-300',
            { 'w-16': isCollapsed }
        ]">
            <!-- Logo -->
            <div class="p-4 flex items-center">
                <img :src="isCollapsed ? collapsedLogo : logo" alt="Suitify Logo" class="w-full h-8 object-contain" />
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto">
                <ul>
                    <li v-for="item in menuItems" :key="item.name" @click="navigate(item.route)" :class="[
                        'p-4 flex items-center space-x-4 cursor-pointer hover:bg-gray-800',
                        { 'bg-gray-800': isActive(item.route) }
                    ]">
                        <span>
                            <i :class="item.icon"></i>
                        </span>
                        <span v-if="!isCollapsed" class="truncate">{{ item.name }}</span>
                    </li>
                </ul>
            </nav>

            <!-- Footer -->
            <footer class="p-4 border-t border-gray-700">
                <div class="flex items-center space-x-4">
                    <i class="icon-settings"></i>
                    <span v-if="!isCollapsed">Settings</span>
                </div>
            </footer>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-100">
            <slot />
        </main>
    </div>
</template>
