<template>
    <section id="testimonial-section" class="testimonial-section bg-background text-foreground py-16">
        <div class="container mx-auto px-4">
            <!-- Heading -->
            <h2 class="testimonial-title text-center text-4xl font-bold mb-8">
                <span>What Our Clients Say</span>
            </h2>
            <p class="testimonial-subtitle text-center text-lg text-foreground/80 mb-12">
                Hear from our satisfied hoteliers using <strong>Suitify</strong> to manage their properties seamlessly.
            </p>

            <!-- Marquee Testimonials -->
            <Vue3Marquee :pause-on-hover="true" :clone="true" speed="30">
                <div v-for="(testimonial, index) in testimonials" :key="index"
                    class="testimonial-card w-1/2 m-10 p-6 bg-white dark:bg-black shadow-lg rounded-lg transform hover:scale-105 transition-all duration-300">
                    <!-- Avatar and User Info -->
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="avatar w-16 h-16 rounded-full overflow-hidden">
                            <img :src="testimonial.avatar" :alt="testimonial.name" class="object-cover w-full h-full" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-xl">{{ testimonial.name }}</h3>
                            <p class="text-sm text-foreground/80">{{ testimonial.role }}</p>
                        </div>
                    </div>
                    <!-- Testimonial Message -->
                    <p class="text-foreground italic">
                        “{{ testimonial.message }}”
                    </p>
                </div>
            </Vue3Marquee>
        </div>
    </section>
</template>

<script>
import { onMounted } from "vue";
import { gsap } from "gsap";
import { Vue3Marquee } from "vue3-marquee";

export default {
    name: "TestimonialSection",
    components: {
        Vue3Marquee,
    },
    setup() {
        const animateTestimonial = () => {
            // Heading animation
            gsap.fromTo(
                ".testimonial-title span",
                { y: 50, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 1.5,
                    ease: "power4.out",
                    stagger: 0.3,
                }
            );

            // Subtitle animation
            gsap.fromTo(
                ".testimonial-subtitle",
                { y: 50, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 1.5,
                    ease: "power4.out",
                    delay: 0.5,
                }
            );

            // Testimonial card animations
            gsap.fromTo(
                ".testimonial-card",
                { y: 50, opacity: 0, scale: 0.9 },
                {
                    y: 0,
                    opacity: 1,
                    scale: 1,
                    duration: 1.2,
                    ease: "power4.out",
                    stagger: 0.2,
                    delay: 1.2,
                }
            );
        };

        onMounted(() => {
            animateTestimonial();
        });

        const testimonials = [
            {
                name: "John Doe",
                role: "Hotel Manager",
                message: "Suitify has transformed the way we manage bookings and daily operations. It's intuitive and reliable! 🌟",
                avatar: "https://i.pravatar.cc/150?img=1",
            },
            {
                name: "Jane Smith",
                role: "Property Owner",
                message: "The automated features in Suitify save me hours every day. Highly recommend it! 👏",
                avatar: "https://i.pravatar.cc/150?img=2",
            },
            {
                name: "Michael Lee",
                role: "General Manager",
                message: "Suitify's real-time updates and interface have made hotel management effortless. 💼✨",
                avatar: "https://i.pravatar.cc/150?img=3",
            },
        ];

        return {
            testimonials,
        };
    },
};
</script>

<style scoped>
/* Styles for Testimonial Section */
.testimonial-card {
    @apply border-2 border-foreground/10 shadow-md shadow-foreground/10;

    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.testimonial-card:hover {
    transform: scale(1.05);
    @apply border-2 border-primary/50 shadow-md shadow-primary/50;
}

.avatar img {
    border-radius: 50%;
    transition: transform 0.3s ease;
}

.avatar:hover img {
    transform: rotate(5deg) scale(1.1);
}

.emoji {
    font-size: 1.2rem;
    color: #60e8b7;
}

/* .testimonial-section {

} */
</style>
