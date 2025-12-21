<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { AuctionItemListForm, Navbar } from '../../components'
import type { AuctionItem } from '../../components/AuctionItemForm.vue'
import {
    Button,
    SelectField,
    TextAreaField,
    TextField,
} from '../../components/ui'
import { Category } from '../../types'

type AuctionForm = {
    title: string
    categoryId: number | null
    description: string
    items: AuctionItem[]
}

defineProps<{ categories: Category[]; savedPictures?: string[] }>()

const form = useForm<AuctionForm>({
    title: '',
    categoryId: null,
    description: '',
    items: [],
})
</script>

<template>
    <Navbar />
    <main class="container mx-auto px-4 lg:px-0">
        <h1 class="font-semibold tracking-tighter text-lg mt-2 text-primary">
            Place Auction
        </h1>
        <form class="grid lg:grid-cols-2 gap-4">
            <section
                class="p-4 border border-border rounded-md mt-2 bg-surface h-fit">
                <h2 class="font-semibold tracking-tight">
                    Auction Information
                </h2>
                <div class="mt-6 space-y-4">
                    <div>
                        <TextField
                            v-model="form.title"
                            label="Title*"
                            id="auction-title" />
                    </div>
                    <div>
                        <SelectField
                            v-model="form.categoryId"
                            :options="categories"
                            option-label-key="name"
                            option-value-key="id"
                            id="auction-category"
                            label="Category*"
                            placeholder="Select Category" />
                    </div>
                    <div>
                        <TextAreaField
                            v-model="form.description"
                            label="Description"
                            id="auction-description" />
                    </div>
                </div>
            </section>
            <section
                class="p-4 bg-border/20 border border-border rounded-md mt-2 h-fit">
                <h2 class="font-semibold tracking-tight">Item Information</h2>
                <AuctionItemListForm v-model="form.items" />
            </section>
        </form>
        <div class="flex justify-end mt-4 mb-12">
            <Button
                type="submit"
                class="whitespace-nowrap">
                Place Auction
            </Button>
        </div>
    </main>
</template>
