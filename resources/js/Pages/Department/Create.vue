<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, onMounted } from 'vue';

const name = ref(null);

const focusInput = () => {
  if (name.value) {
    name.value.focus();
  }
};

onMounted(focusInput);

defineOptions({ layout: AuthenticatedLayout });

const form = useForm({
  name: null,
})

const onHandleSubmit = () => {
    form.post(route('department.store'), {
        onError: () => name.value.focus(),
    })
}

</script>

<template>
    <Head title="Create Department" />

    <div class="relative overflow-x-auto">
        <div class="mx-auto mt-4 max-w-7xl sm:px-6 lg:px-8">

<form @submit.prevent="onHandleSubmit()" novalidate>
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ข้อมูลแผนก</label>
            <input ref="name" v-model="form.name" type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            <p v-if="form.errors.name" class="mt-2 text-sm text-red-600 dark:text-red-500">{{ form.errors.name }}</p>
        </div>
    </div>
    <button :disabled="form.processing" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
</form>

        </div>
    </div>
</template>
