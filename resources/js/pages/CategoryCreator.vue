<script setup lang="ts">

//IMPORT
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useForm } from 'vee-validate'
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import axios from 'axios';
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { ref } from 'vue';

import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage
} from '@/components/ui/form'

import {
    ContextMenu,
    ContextMenuContent,
    ContextMenuItem,
    ContextMenuTrigger,
} from '@/components/ui/context-menu';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Kategóriakészítő',
        href: '/categorycreator',
    },
];

import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog"


//FORM
const formSchema = toTypedSchema(z.object({
    categoryName: z.string()
        .min(3, "A kategóriának legalább 3 karakter hosszúságú lehet!")
        .max(50, "A kategóriának maximum 50 karakter hosszúságú lehet!")
        .refine(input => !input.includes(" "), "Ajajbajaj!")
}))

const form = useForm({
    validationSchema: formSchema,
})

//API
const handleDelete = async (id: number) => {
    try {
        axios.delete("/api/categories/destroy/" + id)
    } catch (error) {
        console.error(error)
    } finally {
        toggleDialog("delete");
        fetchCats();
    }
}

const onSubmit = form.handleSubmit((values) => {
    axios.post("/api/categories/add", { "name": values.categoryName })
        .then(response => {
            console.log(response.data);
            fetchCats();
        }).catch(error => {
            console.error('There was an error adding the category:', error);
        });
})

const onSubmitEdit = form.handleSubmit((values) => {
    axios.post("/api/categories/update/" + editDialogData[0], { "name": values.categoryName })
        .then(response => {
            console.log(response.data);
            toggleDialog("edit")
            fetchCats();
        }).catch(error => {
            console.error('There was an error adding the category:', error);
        });
})


const fetchCats = async () => {
    try {
        const response = await axios.get("/api/categories/list")
        categories.value = response.data;
    } catch (error) {
        console.error(error)
    }
}

const toggleDialog = (type: string, id?: number, name?: string) => {
    switch (type) {
        case "delete":
            switch (confirmationDialogOpen.value) {
                case false && confirmationDialogId != undefined:
                    // @ts-expect-error We are making sure it is not undefined
                    confirmationDialogId = id;
                    confirmationDialogOpen.value = true;
                    break;
                default:
                    confirmationDialogId = -1;
                    confirmationDialogOpen.value = false;
                    break;
            }
            break;
        case "edit":
            switch (editDialogOpen.value) {
                case false:
                    //@ts-expect-error No error because correct handling done beforehand
                    editDialogData = [id, name];
                    editDialogOpen.value = true;
                    break;
                default:
                    editDialogData = [-1, ""];
                    editDialogOpen.value = false;
                    break;
            }
            break;
    }

}

const categories = ref([]);

const confirmationDialogOpen = ref(false);
const editDialogOpen = ref(false);
let confirmationDialogId = -1;
let editDialogData = [-1, ""]

fetchCats();

</script>

<template>

    <Head title="Kategóriakészítő" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex flex-col justify-center items-center">
            <div class="w-1/2 p-6 rounded-xl shadow-lg">
                <form @submit="onSubmit">
                    <FormField v-slot="{ componentField }" name="categoryName">
                        <FormItem>
                            <FormLabel class="my-2 text-center dark:text-white text-black">Kategória neve</FormLabel>
                            <FormControl>
                                <Input type="text" class="my-2 w-full" placeholder="Kategória"
                                    v-bind="componentField" />
                            </FormControl>
                            <FormMessage class="text-red-500" />
                        </FormItem>
                    </FormField>
                    <Button type="submit" class="my-2 w-full">
                        Hozzáadás
                    </Button>
                </form>
            </div>
        </div>


        <div class="grid grid-cols-2 gap-0 p-4 pb-0 rounded">
            <div class="border-b p-4">ID</div>
            <div class="border-b p-4">Kategória</div>
        </div>

        <!-- @vue-skip -->
        <div v-for="cat in categories" :key="cat.id" class="grid grid-cols-2 gap-0 p-4 pb-0 py-0 rounded">

            <ContextMenu>
                <ContextMenuTrigger>
                    <div class="border-b p-4">{{ cat.id }}</div>
                </ContextMenuTrigger>
                <ContextMenuContent>
                    <ContextMenuItem @click="toggleDialog('delete', cat.id)">
                        [{{ cat.id }}] {{ cat.name }} törlése
                    </ContextMenuItem>
                    <ContextMenuItem @click="toggleDialog('edit', cat.id, cat.name)">[{{ cat.id }}] {{ cat.name }}
                        szerkesztése
                    </ContextMenuItem>
                </ContextMenuContent>
            </ContextMenu>

            <ContextMenu>
                <ContextMenuTrigger>
                    <div class="border-b p-4">{{ cat.name }}</div>
                </ContextMenuTrigger>
                <ContextMenuContent>
                    <ContextMenuItem @click="toggleDialog('delete', cat.id)">
                        [{{ cat.id }}] {{ cat.name }} törlése
                    </ContextMenuItem>
                    <ContextMenuItem @click="toggleDialog('edit', cat.id, cat.name)">[{{ cat.id }}] {{ cat.name }}
                        szerkesztése
                    </ContextMenuItem>
                </ContextMenuContent>
            </ContextMenu>
        </div>

    </AppLayout>

    <Dialog v-model:open="confirmationDialogOpen">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Biztosan törölni szeretnéd ezt a kategóriát?</DialogTitle>

            </DialogHeader>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <Button class="w-full" @click="handleDelete(confirmationDialogId)">Igen</Button>
                </div>
                <div>
                    <Button class="w-full" @click="toggleDialog('delete')">Nem</Button>
                </div>
            </div>
        </DialogContent>
    </Dialog>

    <Dialog v-model:open="editDialogOpen">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Szerkesztés</DialogTitle>

            </DialogHeader>
            <DialogDescription>
                <form @submit="onSubmitEdit">
                    <FormField name="categoryName" v-slot="{ componentField }">
                        <FormLabel class = "my-2 dark:text-white text-black">Név</FormLabel>
                        <FormControl>
                            <Input type="text" placeholder="Új név" v-bind="componentField" />
                        </FormControl>
                        <FormMessage class="text-red-500" />
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            <div>
                                <Button type="submit" class="w-full">Mentés</Button>
                            </div>
                            <div>
                                <Button type="button" class="w-full" @click="toggleDialog('edit')">Mégsem</Button>
                            </div>
                        </div>
                    </FormField>
                </form>
            </DialogDescription>

        </DialogContent>
    </Dialog>
</template>