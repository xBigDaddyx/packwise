<template>
    <AppLayout title="Carton Boxes Validation">
        <FormLayout>
            <FormSection @submitted="submitSearch">
                <template #title>
                    Update Password
                </template>

                <template #description>
                    Ensure your account is using a long, random password to stay secure.
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <Label for="password">Barcode</Label>
                        <Input id="barcode" ref="barcodeInput" v-model="form.barcode" type="barcode"
                            class="mt-1 block w-full" autocomplete="new-barcode" />
                        <InputError v-if="form.errors" :message="form.errors.barcode" class="mt-2" />
                    </div>

                </template>

                <template #actions>
                    <Button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </Button>
                </template>
            </FormSection>

        </FormLayout>


    </AppLayout>
</template>

<script setup>



import FormSection from '@/Components/FormSection.vue'
import InputError from '@/Components/InputError.vue'
import Button from '@/Components/shadcn/ui/button/Button.vue'
import Input from '@/Components/shadcn/ui/input/Input.vue'
import Label from '@/Components/shadcn/ui/label/Label.vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import FormLayout from '@/Pages/CartonBox/FormLayout.vue';
import { toast } from 'vue-sonner'
import { reactive, ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';

const barcodeInput = ref(null)

const form = reactive({
    barcode: '',
    cartonBox: null,
    errors: null,
})

function submitSearch() {

    router.get(route('carton-boxes.search'), { barcode: form.barcode }, {
        errorBag: 'submitSearch',
        preserveScroll: true,
        onSuccess: (page) => {
            console.log('success')
            form.cartonBox = page.props.cartonBox;
            toast.success('Password updated')
            form.errors = null;
            form.barcode = '';
            return barcodeInput.value.focus()
        },
        onError: (page) => {
            console.log(page)
            form.errors = page['error'] || 'An error occurred while searching for the carton box.';
            toast.error(form.errors)
            form.barcode = '';
            return barcodeInput.value.focus()
        },
    });
}

const validateCartonBox = async () => {
    form.post(`/carton-boxes/${form.cartonBox.id}/validate`, {}, {
        onSuccess: () => {
            router.visit(`/carton-boxes/${form.cartonBox.id}/verified`);
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
}

</script>

<style></style>
