<script setup>
import RadiantText from "@/Components/RadiantText.vue";
import ParticlesBg from "@/Components/ParticlesBg.vue";
import { Icon } from "@iconify/vue";
import { onMounted } from "vue";
import { gsap } from "gsap";

const animateHero = () => {
    gsap.fromTo(
        ".hero-title span",
        { y: 50, opacity: 0 },
        {
            y: 0,
            opacity: 1,
            duration: 1.5,
            ease: "power4.out",
            stagger: 0.3,
        }
    );

    gsap.fromTo(
        ".hero-subtitle",
        { y: 50, opacity: 0 },
        {
            y: 0,
            opacity: 1,
            duration: 1.5,
            ease: "power4.out",
            delay: 1.2,
        }
    );

    gsap.fromTo(
        ".trust-icons div",
        { scale: 0.8, opacity: 0 },
        {
            scale: 1,
            opacity: 1,
            duration: 1,
            ease: "elastic.out(1, 0.5)",
            stagger: 0.2,
            delay: 1.5,
        }
    );
};

onMounted(() => {
    animateHero();
});
</script>

<template>
    <section class="relative flex items-center justify-center h-screen bg-background text-center overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <ParticlesBg :quantity="150" :staticity="10" :ease="100" :color="isDark ? '#FFF' : '#000'" />
        </div>

        <div class="relative z-10 max-w-4xl px-6">
            <!-- Badge -->
            <div class="mb-8 inline-flex justify-center">
                <Badge variant="outline" class="rounded-full border bg-primary/10 px-4 py-1 text-xs sm:text-sm">
                    <RadiantText
                        class="inline-flex items-center justify-center px-4 py-1 transition ease-out hover:text-neutral-600 hover:duration-300 hover:dark:text-neutral-400"
                        :duration="5">
                        ✨ Discover Suitify Today
                    </RadiantText>
                </Badge>
            </div>

            <!-- Heading -->
            <div class="hero-title">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl lg:text-7xl"
                    :style="{ contain: 'layout paint' }">
                    <span class="block text-foreground">Effortless Hotel Management</span>
                    <span
                        class="mt-2 block bg-gradient-to-r from-red-500 via-purple-500 to-indigo-500 bg-clip-text text-transparent">
                        Powered by Suitify
                    </span>
                </h1>
            </div>

            <!-- Subtitle -->
            <p class="hero-subtitle mx-auto mt-6 max-w-2xl text-base text-muted-foreground sm:text-lg md:text-xl"
                :style="{ contain: 'layout paint' }">
                Simplify operations, increase efficiency, and elevate guest satisfaction
                with an intuitive, cloud-based platform designed for modern hotels.
            </p>

            <!-- Trust Icons -->
            <div class="mt-16 trust-icons">
                <p class="text-sm text-muted-foreground">Built with Reliability and Innovation</p>
                <div class="mt-4 flex flex-wrap items-center justify-center gap-6 sm:gap-8">
                    <div>
                        <Icon icon="logos:laravel"
                            class="size-8 opacity-75 grayscale transition-all hover:opacity-100 hover:grayscale-0" />
                    </div>
                    <div>
                        <Icon icon="logos:vue"
                            class="size-8 opacity-75 grayscale transition-all hover:opacity-100 hover:grayscale-0" />
                    </div>
                    <div>
                        <Icon icon="simple-icons:inertia"
                            class="size-8 opacity-75 grayscale transition-all hover:opacity-100 hover:grayscale-0 text-purple-500" />
                    </div>
                    <div>
                        <Icon icon="logos:tailwindcss-icon"
                            class="size-8 opacity-75 grayscale transition-all hover:opacity-100 hover:grayscale-0" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Background Effect -->
        <ParticlesBg class="absolute inset-0" :quantity="100" :ease="100" :color="isDark ? '#FFF' : '#000'"
            :staticity="10" refresh />
    </section>
</template>

<style scoped>
.hero-title span {
    display: inline-block;
    overflow: hidden;
}

.hero-subtitle {
    transform: translateY(50px);
    opacity: 0;
}

.trust-icons div {
    transform: scale(0.8);
    opacity: 0;
}
</style>
