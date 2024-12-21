<template>
    <AppLayout title="Carton Boxes Validation">
        <FormLayout>
            <div>
                <h1>Validate Carton Box</h1>

                <div v-if="cartonBox">
                    <h3>Carton Box Details</h3>
                    <p>Barcode: {{ cartonBox.barcode }}</p>
                    <p>Status: {{ cartonBox.is_verified ? 'Verified' : 'Not Verified' }}</p>

                    <div v-if="!cartonBox.is_verified">
                        <button @click="validateCartonBox">Validate</button>
                    </div>

                    <div v-if="cartonBox.is_verified">
                        <p>{{ message }}</p>
                    </div>
                </div>
            </div>
        </FormLayout>


    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import FormLayout from './FormLayout.vue';
import { ref } from "vue";
import { usePage } from '@inertiajs/vue3';


export default {
    setup() {
        const barcode = ref("");
        const status = ref(null);
        const message = ref("");

        const findCartonBox = async () => {
            try {
                // Send POST request to the backend
                const response = await axios.post(route("carton-boxes.search"), {
                    barcode: barcode.value,
                });

                status.value = "success";
                message.value = response.data.message;

                // Redirect to validation page if found
                if (response.data.status === "found") {
                    const cartonBoxId = response.data.data.carton_box.id;
                    Inertia.visit(`/carton-boxes/validate/${cartonBoxId}`);
                }
            } catch (error) {
                status.value = "error";
                message.value =
                    error.response?.data?.message || "Error occurred while searching.";
            }
        };

        return { barcode, status, message, findCartonBox };
    },
};

</script>

<style></style>
