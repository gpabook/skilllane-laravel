<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import {useToast} from 'vue-toast-notification';
import { onMounted } from 'vue';
//
defineProps({
        //users: Object
        departments: Array
    });

const page = usePage();
const toast = useToast();

onMounted(() => {
    if (page.props.flash.message) {
        toast.success(page.props.flash.message);
    }
})

const onHandleDelete = (id) => {
    if(confirm('แน่ใจว่าต้องการลบข้อมูลนี้')) {
        router.delete('/dashboard/department/destroy', {
            data: {id: id},
            onSuccess: (page) => {
                toast.success(page.props.flash.message);
            }
        });
    }
}

</script>

<template>
    <Head title="Department" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Department Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{  page.props.auth.user.name }} :: You're logged in Department!
                    </div>



    <Head title="ข้อมูลผู้ใช้" />

    <div class="relative overflow-x-auto">
    <div class="mx-auto mt-4 max-w-7xl sm:px-6 lg:px-8">

<Link :href="route('department.create')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-4 mb-4 mt-4 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">เพิ่มข้อมูล</Link>

        <table class="w-full mt-5 text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Created At
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>

            <tr v-for="item in departments" :key="item.id" class="border-b border-gray-200 odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ item.id }}
                </th>
                <td class="px-6 py-4">
                    {{ item.name }}
                </td>
                <td class="px-6 py-4">
                    {{ new Date(item.created_at).toLocaleDateString('th-TH') }}
                </td>
                <td class="px-6 py-4">
                    <a :href="route('department.edit', {id: item.id})" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                   |
                    <a @click="onHandleDelete(item.id)" href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                </td>
            </tr>

        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
    </AuthenticatedLayout>
</template>
