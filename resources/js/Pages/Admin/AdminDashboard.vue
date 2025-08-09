<script setup>
import PaginationLinks from "../../components/PaginationLinks.vue";
import RoleSelect from "../../components/RoleSelect.vue";
import SessionMessage from "../../components/SessionMessage.vue";
import InputField from "../../components/InputField.vue";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps({
    users: Object,
    status: String,
});

const params = route().params;

const form = useForm({
    search: params.search,
});

const search = () => {
    router.get(
        route("admin.index", {
            search: form.search,
        })
    );
};

const toggleRole = (e) => {
    if (e.target.checked) {
        router.get(
            route("admin.index", {
                search: form.search,
                user_role: 'suspended',
            })
        );
    } else {
      router.get(
            route("admin.index", {
                search: form.search,
                user_role: null,
            })
        );
    }
};
</script>

<template>
    <Head title="Admin" />

    <SessionMessage :message="status" />
    <!-- Heading -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <!-- Search Form -->
            <form @submit.prevent="search">
                <InputField
                    label=""
                    icon="search"
                    placeholder="Search..."
                    type="search"
                    v-model="form.search"
                />
            </form>

            <Link
                v-if="params.search"
                :href="
                    route('admin.index', {
                        ...params,
                        search: null,
                        pages: null,
                    })
                "
                class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2"
            >
                {{ params.search }}
                <i class="fa-solid fa-xmark"></i>
            </Link>
        </div>
        <!-- Toggle Role Button -->
        <div
            class="flex items-center gap-1 text-xs hover:bg-slate-300 dark:hover:bg-slate-800 px-2 py-1 rounded-md"
        >
            <input
                type="checkbox"
                :checked="params.user_role"
                id="toggleRole"
                @input="toggleRole"
                class="rounded-md border-1 outline-0 text-indigo-500 ring-indigo-500 border-slate-700 cursor-pointer"
            />

            <label
                for="toggleRole"
                class="block text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer"
                >Show suspended users</label
            >
        </div>
    </div>

    <!-- Table -->
    <table
        class="bg-white dark:bg-slate-800 w-full rounded-lg overflow-hidden ring-1 ring-slate-300"
    >
        <thead>
            <tr class="bg-slate-600 text-slate-300 uppercase text-xs text-left">
                <th class="w-3/6 p-3">Name</th>
                <th class="w-2/6 p-3">Role</th>
                <th class="w-1/6 p-3">Listings</th>
                <th class="w-1/6 p-3 text-right">View</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-300 divide-dashed">
            <tr v-for="user in users.data" :key="user.id">
                <td class="w-3/6 py-5 px-3">
                    <p class="font-bold mb-1">{{ user.name }}</p>
                    <p class="font-light text-xs">{{ user.email }}</p>
                </td>
                <td class="w-2/6 py-5 px-3">
                    <RoleSelect :user="user" />
                </td>
                <td class="w-1/6 py-5 px-3">
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-1">
                            <p>
                                {{
                                    user.listings.filter((l) => l.approved)
                                        .length
                                }}
                            </p>
                            <i
                                class="fa-solid fa-circle-check text-green-500"
                            ></i>
                        </div>
                        <div class="flex items-center gap-1">
                            <p>
                                {{
                                    user.listings.filter((l) => !l.approved)
                                        .length
                                }}
                            </p>
                            <i
                                class="fa-solid fa-circle-xmark text-red-500"
                            ></i>
                        </div>
                    </div>
                </td>
                <td class="w-1/6 py-5 px-3 text-right">
                  <Link :href="route('user.show', user.id)" class="fa-solid fa-up-right-from-square px-3 text-indigo-400"></Link>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="mt-6">
        <PaginationLinks :paginator="users" />
    </div>
</template>
