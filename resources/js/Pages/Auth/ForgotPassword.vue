<script setup>
import { useForm } from '@inertiajs/vue3';
import Container from '../../components/Container.vue';
import InputField from '../../components/InputField.vue';
import PrimaryBtn from '../../components/PrimaryBtn.vue';
import SessionMessage from '../../components/SessionMessage.vue';
import ErrorMessage from '../../components/ErrorMessage.vue';

defineProps({
  status: String,
  email: String
})

const form = useForm({
  email: "",
});

const submit = () => {
  form.post(route('password.email'));
}

</script>

<template>
  <Head title="Reset Password" />
  <Container class="w-1/2">

    <p>Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one</p>

    <ErrorMessage :errors="form.errors" />
    <InputField label="Email" icon="at" v-model="form.email" />

    <SessionMessage :message="status" />

    <form @submit.prevent="submit">
      <PrimaryBtn :disabled="form.processing">Send Password Reset Link</PrimaryBtn>
    </form>

  </Container>
</template>