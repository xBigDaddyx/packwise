<template>
    <section id="cta-section" class="cta-section py-16 bg-gradient-to-r from-[#60E8B7] to-[#48C4A1] text-white">
        <div class="container mx-auto px-4 text-center">
            <!-- Heading -->
            <h2 class="cta-title text-4xl font-bold mb-6">Ready to Simplify Your Hotel Management?</h2>
            <p class="cta-subtitle text-lg mb-8">
                Experience seamless property management with Suitify. Sign up today and transform the way you manage
                your business. 🏨✨
            </p>
            <!-- Buttons -->
            <div class="flex justify-center space-x-4">
                <button
                    class="cta-button bg-white text-[#48C4A1] py-3 px-6 rounded-lg text-lg font-semibold shadow-lg hover:shadow-xl transition-transform duration-300">
                    Get Started Now 🚀
                </button>
                <button
                    class="cta-button bg-[#48C4A1] py-3 px-6 rounded-lg text-lg font-semibold shadow-lg hover:bg-white hover:text-[#48C4A1] transition-transform duration-300">
                    Learn More 📘
                </button>
            </div>
        </div>
    </section>
</template>

<script>
import { onMounted } from "vue";
import { gsap } from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

export default {
    name: "CTASection",
    setup() {
        const animateCTA = () => {
            gsap.registerPlugin(ScrollTrigger);

            // Animate the heading
            gsap.fromTo(
                ".cta-title",
                { y: 50, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 1.2,
                    ease: "power4.out",
                    scrollTrigger: {
                        trigger: ".cta-title",
                        start: "top 80%", // Start animation when 80% of the section is in view
                    },
                }
            );

            // Animate the subtitle
            gsap.fromTo(
                ".cta-subtitle",
                { y: 50, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 1.2,
                    ease: "power4.out",
                    scrollTrigger: {
                        trigger: ".cta-subtitle",
                        start: "top 80%",
                    },
                }
            );

            // Animate the buttons
            gsap.fromTo(
                ".cta-button",
                { scale: 0.9, opacity: 0 },
                {
                    scale: 1,
                    opacity: 1,
                    duration: 1,
                    ease: "elastic.out(1, 0.5)",
                    stagger: 0.2,
                    scrollTrigger: {
                        trigger: ".cta-button",
                        start: "top 90%",
                    },
                }
            );
        };

        onMounted(() => {
            animateCTA();
        });
    },
};
</script>

<style scoped>
.cta-section {
    background: linear-gradient(to right, #60e8b7, #48c4a1);
    color: white;
    text-align: center;
}

.cta-button {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.cta-button:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}
</style>
