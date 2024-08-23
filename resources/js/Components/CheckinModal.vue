<script setup>
import { defineProps, defineEmits, ref } from "vue";
import Select from "@/Components/Select.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    visitorId: {
        type: Number,
        required: true,
    },
    checkinTypes: {
        type: Array,
        default: () => [],
    },
    purposeOfVisit: {
        type: Array,
        default: () => [],
    },
});

const checkinType = ref(
    props.checkinTypes.length > 0 ? props.checkinTypes[0].value : "walk_in"
);

const purposeOfVisit = ref(
    props.purposeOfVisit.length > 0 ? props.purposeOfVisit[0].value : "visitor"
);

const emit = defineEmits(["close", "submit"]);

const vehicleNumber = ref("");
const errorMessage = ref("");

const close = () => {
    emit("close");
};

const submit = () => {
    if (checkinType.value === "vehicle" && !vehicleNumber.value) {
        errorMessage.value = "Vehicle number is required.";
        return;
    }
    errorMessage.value = "";
    emit("submit", {
        visitorId: props.visitorId,
        type: checkinType.value,
        vehicle_number: vehicleNumber.value,
        purpose_of_visit: purposeOfVisit.value,
    });
};
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75"
    >
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-2xl mx-4">
            <h2 class="text-2xl mb-4">Visitor Check-In</h2>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <InputLabel for="checkin_type" value="Check-in Type" />
                    <Select v-model="checkinType" :options="checkinTypes" />
                </div>
                <div v-if="checkinType === 'vehicle'" class="mb-4">
                    <InputLabel for="vehicle_number" value="Vehicle Number" />

                    <TextInput
                        id="vehicle_number"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="vehicleNumber"
                        autocomplete="vehicle_number"
                    />
                    <InputError class="mt-2" :message="errorMessage" />
                </div>
                <div class="mb-4">
                    <InputLabel
                        for="purpose_of_visit"
                        value="Purpose Of Visit"
                    />

                    <Select
                        v-model="purposeOfVisit"
                        :options="props.purposeOfVisit"
                    />
                </div>
                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="close" class="mr-4">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton type="submit"> Check-in </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
<style scoped>
@media (min-width: 640px) {
    .modal-box {
        width: 100%;
        max-width: 480px;
    }
}

@media (min-width: 768px) {
    .modal-box {
        width: 100%;
        max-width: 640px;
    }
}

@media (min-width: 1024px) {
    .modal-box {
        width: 100%;
        max-width: 800px;
    }
}
</style>
