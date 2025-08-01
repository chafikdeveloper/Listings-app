<script setup>
import { useForm } from '@inertiajs/vue3';
import Container from '../../components/Container.vue';
import PrimaryBtn from '../../components/PrimaryBtn.vue';
import SessionMessage from '../../components/SessionMessage.vue';

defineProps({
  message: String
})

const form = useForm({});
const submit = () => {
  form.post(route('verification.send'));
}
</script>

<template>
  <Head title="Email Verification" />

  <Container class="w-1/2">
    <div class="mb-8">
      <p>
        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't recieve the email, we will gladly send you another.
      </p>
    </div>

    <SessionMessage :message="message" />

    <form @submit.prevent="submit">
      <PrimaryBtn class="block w-full" :disabled="form.processing">Resent Verification Email</PrimaryBtn>
    </form>
  </Container>
</template>