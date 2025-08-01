<script setup>
import Container from "../../components/Container.vue";
import Title from "../../components/Title.vue";
import TextLink from "../../components/TextLink.vue";
import InputField from "../../components/InputField.vue";
import PrimaryBtn from "../../components/PrimaryBtn.vue";
import ErrorMessage from "../../components/ErrorMessage.vue";
import SessionMessage from "../../components/SessionMessage.vue";
import CheckBox from '../../components/CheckBox.vue';
import { useForm } from "@inertiajs/vue3";

defineProps({
    status: String,
})

const form = useForm({
    email: "",
    password: "",
    remember: null,
});

const submit = () => {
    form.post(route("login"), {
        onError: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Login" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Login to your account</Title>
        </div>

        <!-- Errors messages -->
         <SessionMessage :message="status" />
        <ErrorMessage :errors="form.errors" />

        <form @submit.prevent="submit" class="space-y-6">
            <InputField label="Email" icon="at" v-model="form.email" />

            <InputField
                label="Password"
                type="password"
                icon="key"
                v-model="form.password"
            />

            <div class="flex items-center justify-between">
                <CheckBox name="remember" v-model="form.remember">
                    Remember me
                </CheckBox>

                <TextLink routeName="password.request" label="Forgot Password?" />
            </div>

            <PrimaryBtn class="block w-full" :disabled="form.processing">Login</PrimaryBtn>            
            <p class="text-center text-md mt-4">Need an account? <TextLink routeName="register" label="Register" /> </p>
        </form>
    </Container>
</template>