<script>
import { ref, onMounted } from "vue";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { useAnimate } from '@oku-ui/motion'
export default {
    name: "FeatureSection",
    setup() {
        const features = ref([
            {
                title: "Reservation Management",
                description: "Streamline bookings with real-time availability and integrations.",
                icon: "ti-calendar-event",
            },
            {
                title: "Housekeeping Automation",
                description: "Automate and monitor housekeeping tasks effortlessly.",
                icon: "ti-ironing-1",
            },
            {
                title: "Guest Communication",
                description: "Enhance guest experiences with personalized communication.",
                icon: "ti-messages",
            },
            {
                title: "Revenue Insights",
                description: "Optimize your hotel’s pricing strategies with data-driven insights.",
                icon: "ti-report-analytics",
            },
        ]);

        const featureCards = ref([]);
        const { animate, scope } = useAnimate()
        onMounted(() => {
            gsap.registerPlugin(ScrollTrigger);
            // animate('.feature-card', {
            //     initial: { scale: 0, opacity: 0 },
            //     animate: { scale: 1, opacity: 1 },
            //     transition(index) {
            //         return {
            //             delay: index * 0.5,
            //         }
            //     },
            // })
            // Stagger animations for cards
            gsap.fromTo(
                ".feature-card",
                { opacity: 0, y: 50, scale: 0.9 },
                {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 1,
                    stagger: 0.2,
                    ease: "power4.out",
                    scrollTrigger: {
                        trigger: ".features-grid",
                        start: "top 80%",
                        toggleActions: "play none none reverse",
                    },
                }
            );

            // Add 3D tilt on hover
            featureCards.value.forEach((card) => {
                card.addEventListener("mousemove", (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    gsap.to(card, {
                        rotationY: ((x / rect.width) - 0.5) * 15,
                        rotationX: ((y / rect.height) - 0.5) * -15,
                        transformPerspective: 1000,
                        ease: "power3.out",
                    });
                });

                card.addEventListener("mouseleave", () => {
                    gsap.to(card, {
                        rotationY: 0,
                        rotationX: 0,
                        ease: "power3.out",
                    });
                });
            });
        });

        return { features, featureCards };
    },
};
</script>


<template>
    <section id="features" class="feature-section h-screen mx-auto flex items-center justify-center">
        <div class="container">
            <h2 class="section-title">Unleash the Power of Suitify</h2>
            <p class="section-subtitle">
                Our advanced modules streamline hotel operations like never before. Experience
                seamless management at your fingertips.
            </p>

            <div class="features-grid">
                <div v-for="(feature, index) in features" :key="index" class="feature-card" ref="featureCards">

                    <!-- Icon -->
                    <div class="icon-wrapper">
                        <i :class="'feature-icon ti ' + feature.icon"></i>
                    </div>

                    <!-- Feature Title -->
                    <h3 class="feature-title">{{ feature.title }}</h3>

                    <!-- Feature Description -->
                    <p class="feature-description">{{ feature.description }}</p>

                    <!-- Learn More Button -->
                    <div class="learn-more">Learn More →</div>

                    <!-- Background Glow Effect -->
                    <div class="background-effect"></div>

                </div>
            </div>
        </div>
    </section>
</template>




<style scoped>
/* Feature Section Styles */
.feature-section {
    padding: 100px 20px;
    background: linear-gradient(180deg, hsl(var(--background)), hsl(var(--primary)/10%), hsl(var(--primary)/30%), hsl(var(--primary)/60%));
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    text-align: center;
}

.section-title {
    font-size: 3rem;
    font-weight: bold;
    @apply text-foreground;
    margin-bottom: 10px;
}



.section-subtitle {
    font-size: 1.25rem;
    @apply text-foreground/80;
    margin-bottom: 75px;
}

/* Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 75px;


}

/* Feature Card */
.feature-card {
    position: relative;
    @apply bg-background/50;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-top: 30px;
    transform-style: preserve-3d;
    transform: perspective(1000px);
    transition: transform 0.5s ease, box-shadow 0.3s ease;
    opacity: 0;
    /* Initial opacity for scroll animation */
}

.feature-card:hover {
    transform: scale(1.05);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

/* Icon Wrapper */
.icon-wrapper {
    position: absolute;
    top: -40px;
    left: 38%;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 80px;
    height: 80px;
    margin: 0 auto 15px;
    border-radius: 50%;
    background: linear-gradient(135deg, #BA88F9, #7C3AED);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
}

.feature-icon {
    font-size: 32px;
    color: #fff;
    transition: color 0.3s ease, transform 0.3s ease;
}

.icon-wrapper:hover {
    transform: scale(1.2) rotate(15deg);
}

/* Card Title and Description */
.feature-title {
    font-size: 1.5rem;
    font-weight: bold;
    @apply text-foreground;
    margin-top: 25px;
    margin-bottom: 15px;
}

.feature-description {
    font-size: 1rem;
    @apply text-foreground/80;
    margin-bottom: 20px;
}

/* Learn More */
.learn-more {
    font-size: 1rem;
    font-weight: bold;
    color: #A269F4;
    cursor: pointer;
    transition: color 0.3s ease;
}

.learn-more:hover {
    color: hsl(var(--primary));
}

/* Glow Effect */
.background-effect {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;

    transition: opacity 0.3s ease;
    z-index: -1;
}

.feature-card:hover .background-effect {
    opacity: 1;
}
</style>
