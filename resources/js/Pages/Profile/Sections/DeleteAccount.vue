<script setup>
import Container from "../../../components/Container.vue";
import Title from "../../../components/Title.vue";
import InputField from "../../../components/InputField.vue";
import PrimaryBtn from "../../../components/PrimaryBtn.vue";
import SessionMessage from "../../../components/SessionMessage.vue";
import ErrorMessage from "../../../components/ErrorMessage.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const showConfirmPassword = ref(false);

const form = useForm({
    password: "",
});

const submit = () => {
    form.delete(route("profile.destroy"), {
      preserveScroll: true,
      onError: () => form.reset()
    });
};
</script>

<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Delete Account</Title>
            <p>
                Once your account is deleted, all of the its resources data will
                be permanently deleted. This action cannot be undone.
            </p>
        </div>

        <div v-if="showConfirmPassword">
            <ErrorMessage :errors="form.errors" />

            <form @submit.prevent="submit" class="space-y-6">
                <InputField
                    label="Confirm Password"
                    icon="key"
                    type="password"
                    class="w-1/2"
                    v-model="form.password"
                />

                <div class="flex gap-2">
                    <PrimaryBtn :disabled="form.processing">Confirm</PrimaryBtn>
                    <button
                        @click="showConfirmPassword = false"
                        class="px-2 py-2 rounded-lg bg-gray-400 text-white font-medium"
                    >
                        <i class="fa-solid fa-x"></i>
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <button
            @click="showConfirmPassword = true"
            v-if="!showConfirmPassword"
            class="px-6 py-2 rounded-lg bg-red-500 text-white font-medium"
        >
            <i class="fa-solid fa-triangle-exclamation"></i>
            Delete Account
        </button>
    </Container>
</template>
