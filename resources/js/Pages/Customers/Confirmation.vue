<script setup>
import ConfirmationModal from '../../Components/ConfirmationModal.vue';
import DangerButton from '../../Components/DangerButton.vue';
import SecondaryButton from '../../Components/SecondaryButton.vue';
</script>

<template>
<ConfirmationModal>
<template #title>
    Verwijder klant
</template>

<template #content>
    Weet u zeker dat je deze klant wil verwijderen, de gegevens zullen permanent verwijderd worden
</template>

<template #footer>
    <SecondaryButton>
        Annuleren
    </SecondaryButton>

    <DangerButton class="ml-2"  :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Verwijder klant
    </DangerButton>
</template>
</ConfirmationModal>
</template>
