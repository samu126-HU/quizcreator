<script setup lang="ts">



import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from '@/components/ui/drawer'

import { Button } from "@/components/ui/button";

</script>

<template>

    <Head title="Kvízek" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Drawer>
                <DrawerTrigger>szia</DrawerTrigger>
                    <DrawerContent>
                        <DrawerHeader>
                            <div class="flex items-center flex-col">
                            <DrawerTitle>Kvízválasztó választómenü</DrawerTitle>
                            <DrawerDescription>Biztosan ezt választod??</DrawerDescription>
                            </div>
                        </DrawerHeader>
                        <DrawerFooter>
                            <div class="flex justify-center gap-5">
                            <DrawerClose class="w-20">Nem</DrawerClose>
                            <Button class="w-20">Igen!!</Button>
                            </div>
                        </DrawerFooter>
                    </DrawerContent>
            </Drawer>
        </div>
    </AppLayout>

</template>