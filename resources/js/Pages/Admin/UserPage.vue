<script setup>
import Title from "../../components/Title.vue";
import PaginationLinks from "../../components/PaginationLinks.vue";
import InputField from "../../components/InputField.vue";
import SessionMessage from "../../components/SessionMessage.vue";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
    listings: Object,
    status: String,
});

const params = route().params;

const form = useForm({
    search: params.search,
});

const search = () => {
    router.get(
        route("user.show", {
            user: props.user.id,
            search: form.search,
            disapproved: params.disapproved,
        })
    );
};

const showDisapproved = (e) => {
  if (e.target.checked) {
    router.get(route('user.show', {
      user: props.user.id,
      search: params.search,
      disapproved: true,
    }));
  } else {
    router.get(route('user.show', {
      user: props.user.id,
      search: params.search,
      disapproved: null,
    }));
  }
}

const toggleApprove = (listing) => {
  let msg = listing.approved ? 'Disapprove this listing' : 'Approve this listing';

  if (confirm(msg)) {
    router.put(route('admin.approve', listing.id));
  }
}
</script>

<template>
    <Head :title="`${user.name} Listings`" />

    <SessionMessage :message="status" />

    <!-- Heading -->
    <div class="mb-6">
        <Title>{{ user.name }} latest listings</Title>
        <div class="flex items-end justify-between">
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
                            user: user.id,
                        })
                    "
                    class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2"
                >
                    {{ params.search }}
                    <i class="fa-solid fa-xmark"></i>
                </Link>
            </div>
            <!-- Toggle Approve Listing Button -->
            <div
                class="flex items-center gap-1 text-xs hover:bg-slate-300 dark:hover:bg-slate-800 px-2 py-1 rounded-md"
            >
                <input
                    @input="showDisapproved"
                    :checked="params.disapproved"
                    type="checkbox"
                    id="toggleRole"
                    class="rounded-md border-1 outline-0 text-indigo-500 ring-indigo-500 border-slate-700 cursor-pointer"
                />

                <label
                    for="toggleRole"
                    class="block text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer"
                    >Show Disapproved Listings</label
                >
            </div>
        </div>
    </div>

    <!-- Table -->
    <table
        class="bg-white dark:bg-slate-800 w-full rounded-lg overflow-hidden ring-1 ring-slate-300"
    >
        <thead>
            <tr class="bg-slate-600 text-slate-300 uppercase text-xs text-left">
                <th class="w-4/6 p-3">Title</th>
                <th class="w-2/6 p-3 text-center">Approved</th>
                <th class="w-1/6 p-3 text-right">View</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-300 divide-dashed">
            <tr v-for="listing in listings.data" :key="listing.id">
                <td class="py-5 px-3">{{ listing.title }}</td>

                <td class="py-5 px-3 text-2xl text-center">
                    <button @click.prevent="toggleApprove(listing)">
                        <i
                            :class="`fa-solid fa-${
                                listing.approved
                                    ? 'circle-check text-green-500'
                                    : 'xmark text-red-500'
                            }`"
                        ></i>
                    </button>
                </td>

                <td class="w-1/6 py-5 px-3 text-right">
                    <Link
                        :href="route('listing.show', listing.id)"
                        class="fa-solid fa-up-right-from-square px-3 text-indigo-400"
                    ></Link>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="mt-6">
        <PaginationLinks :paginator="listings" />
    </div>
</template>
