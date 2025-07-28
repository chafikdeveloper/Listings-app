<script setup>
import NavLink from '../components/NavLink.vue';
import { switchTheme } from '../theme';

</script>

<template>
    <header class="bg-slate-800 text-white">
        <nav class="p-6 mx-auto max-w-screen-lg flex items-center justify-between">
            <div>
                <NavLink routeName="home" componentName="Home">Home</NavLink>
                <!-- <NavLink routeName="home">About</NavLink> -->
            </div>

            <div class="flex items-center space-x-6">
                <NavLink routeName="register" componentName="Auth/Register">Register</NavLink>
                <button @click="switchTheme" class="hover:bg-slate-700 w-6 h-6 grid place-items-center rounded-full hover:outline-1 ou">
                    <i class="fa-solid fa-circle-half-stroke"></i>
                </button>
            </div>
        </nav>
    </header>

    <main class="p-6 mx-auto max-w-screen-lg">
        <slot />
    </main>
</template>