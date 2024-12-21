<template>
    <section id="featured-features"
        class="featured-features py-16 bg-gradient-to-b from-primary/60 to-background text-white">
        <div class="container mx-auto px-4 flex flex-col lg:flex-row items-center justify-between">
            <!-- Left Column: WhatsApp Integration Feature -->
            <div class="left-column lg:w-1/2 mb-10 lg:mb-0 text-center lg:text-left">
                <!-- Heading -->
                <h2 class="features-title text-4xl font-bold mb-8">WhatsApp Integration for Instant Notifications</h2>
                <p class="features-subtitle text-lg mb-12">
                    Stay updated with real-time booking notifications and alerts sent directly to your WhatsApp. 💬
                </p>

                <!-- WhatsApp Feature Description -->
                <div
                    class="feature-card p-6 bg-white text-[#48C4A1] rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 w-80 mx-auto lg:mx-0">
                    <h3 class="text-2xl font-semibold mb-4">Instant Booking & Alerts</h3>
                    <p class="text-md">Get notifications for bookings, cancellations, and updates, delivered straight to
                        your WhatsApp!</p>
                </div>

                <!-- WhatsApp Integration Button -->
                <div class="mt-10">
                    <p class="text-lg mb-4">Want to receive instant updates on WhatsApp?</p>
                    <a href="https://wa.me/11234567890?text=I%20want%20to%20receive%20notifications%20for%20my%20hotel%20bookings!"
                        target="_blank"
                        class="cta-button bg-white text-[#48C4A1] py-3 px-6 rounded-lg text-lg font-semibold shadow-lg hover:shadow-xl transition-transform duration-300">
                        Receive Notifications on WhatsApp 📲
                    </a>
                </div>
            </div>

            <!-- Right Column: WhatsApp Integration Image -->
            <div class="right-column lg:w-1/2 flex justify-center items-center">
                <img src="https://via.placeholder.com/500x300?text=WhatsApp+Integration" alt="WhatsApp Integration"
                    class="rounded-lg shadow-lg transform transition duration-500 hover:scale-105" />
            </div>
        </div>
    </section>
</template>

<script>
import { onMounted } from "vue";
import { gsap } from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

export default {
    name: "FeaturedFeaturesSection",
    setup() {
        const animateFeatures = () => {
            gsap.registerPlugin(ScrollTrigger);

            // Animate the heading
            gsap.fromTo(
                ".features-title",
                { y: 50, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 1.2,
                    ease: "power4.out",
                    scrollTrigger: {
                        trigger: ".features-title",
                        start: "top 80%",
                    },
                }
            );

            // Animate the feature card
            gsap.fromTo(
                ".feature-card",
                { opacity: 0, y: 50 },
                {
                    opacity: 1,
                    y: 0,
                    duration: 1.2,
                    ease: "power4.out",
                    stagger: 0.2,
                    scrollTrigger: {
                        trigger: ".feature-card",
                        start: "top 80%",
                    },
                }
            );

            // Animate the image
            gsap.fromTo(
                ".right-column img",
                { opacity: 0, y: 50 },
                {
                    opacity: 1,
                    y: 0,
                    duration: 1.2,
                    ease: "power4.out",
                    scrollTrigger: {
                        trigger: ".right-column",
                        start: "top 80%",
                    },
                }
            );
        };

        onMounted(() => {
            animateFeatures();
        });
    },
};
</script>

<style scoped>
.feature-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.cta-button {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.cta-button:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.right-column img {
    transition: transform 0.3s ease;
}

.right-column img:hover {
    transform: scale(1.05);
}
</style>
