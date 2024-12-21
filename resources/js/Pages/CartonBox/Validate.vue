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
export default {
    props: {
        cartonBox: Object,
        packingList: Object,
        message: String,
    },
    methods: {
        validateCartonBox() {
            this.$inertia.post(`/carton-boxes/${this.cartonBox.id}/validate`, {}, {
                onSuccess: () => {
                    this.$inertia.visit(`/carton-boxes/${this.cartonBox.id}/verified`);
                },
                onError: (errors) => {
                    console.error(errors);
                },
            });
        },
    },
};
</script>

<style></style>
