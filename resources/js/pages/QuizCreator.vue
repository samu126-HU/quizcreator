<script setup lang="ts">



import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Kvízkészítő',
        href: '/quizcreator',
    },
];


</script>

<template>

    <Head title="Kvízek" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

        </div>
    </AppLayout>

</template>