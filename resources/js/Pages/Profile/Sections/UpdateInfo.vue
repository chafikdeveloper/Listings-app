<script setup>
import Container from "../../../components/Container.vue";
import Title from "../../../components/Title.vue";
import InputField from "../../../components/InputField.vue";
import PrimaryBtn from "../../../components/PrimaryBtn.vue";
import SessionMessage from "../../../components/SessionMessage.vue";
import ErrorMessage from "../../../components/ErrorMessage.vue";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
    status: String,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
});

const submit = () => {
    form.patch(route("profile.info"));
};

const sendEmail = (e) => {
    router.post(
        route("verification.send"),
        {},
        {
            onStart: () => (e.target.disabled = true),
            onFinish: () => (e.target.disabled = false),
        }
    );
};
</script>

<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Information</Title>
            <p>Update your account's profile information and email address.</p>
        </div>

        <ErrorMessage :errors="form.errors" />

        <form @submit.prevent="submit" class="space-y-6">
            <InputField
                label="Name"
                icon="id-badge"
                class="w-1/2"
                v-model="form.name"
            />

            <InputField
                label="Email"
                icon="at"
                class="w-1/2"
                v-model="form.email"
            />

            <SessionMessage :message="status" />
            <div v-if="!user.email_verified_at" class="flex items-center gap-2">
                <p class="text-red-500">Your email address is unverified.</p>
                <button
                    @click="sendEmail"
                    class="text-indigo-500 font-medium underline dark:text-indigo-400 disabled:text-slate-400 disabled:cursor-wait"
                >
                    Click here to re-send an email to verify your email
                </button>
            </div>

            <p v-if="form.recentlySuccessful" class="text-md text-green-600">
                Your information saved successfully
            </p>
            <PrimaryBtn :disabled="form.processing">Save</PrimaryBtn>
        </form>
    </Container>
</template>
