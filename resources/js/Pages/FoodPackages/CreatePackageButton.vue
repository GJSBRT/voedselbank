<script setup>
import { reactive, ref } from 'vue';
import DialogModal from '@/Components/DialogModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    virtualserver: Object,
    ips: Object,
    plans: Object,
});

const form = reactive({
    error: '',
    processing: false,
});

const createPackage = ref(false);

const openModal = () => {
    createPackage.value = true;
}

const closeModal = () => {
    upgradeServer.value = false;
    form.error = '';
};

const handleCreate = () => {

}
</script>

<template>
    <PrimaryButton @click="openModal">
        Nieuw Pakket
    </PrimaryButton>
    
    <DialogModal :show="createPackage" @close="closeModal">
        <template #title>
            Nieuw Pakket
        </template>

        <template #content>
            Maak snel een pakket aan hier.
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                Annuleren
            </SecondaryButton>

            <PrimaryButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="handleCreate"
            >
                Aanmaken
            </PrimaryButton>
        </template>
    </DialogModal>
</template>