<script setup>
    import { Head } from '@inertiajs/vue3';
    import SiteLayout from '@/Layouts/SiteLayout.vue';
    defineOptions({ layout: SiteLayout});

    defineProps({
        message: String,
        postcode: Number
    });
</script>

<template>
  <section>
    <h1>About Us</h1>
    <p>{{ message }}</p>
    <p>{{ postcode }}</p>
  </section>
</template>


