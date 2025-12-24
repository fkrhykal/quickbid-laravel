<script setup lang="ts">
import { defaultAuctionItem, defaultAuctionItems } from '@/utils/factory'
import { reactive, watch } from 'vue'
import type { AuctionItem } from './AuctionItemForm.vue'
import AuctionItemForm from './AuctionItemForm.vue'
import { TrashIcon } from './icons'
import ListPlusIcon from './icons/ListPlusIcon.vue'
import Button from './ui/Button.vue'

const props = withDefaults(defineProps<{ min?: number; max?: number }>(), {
    max: 3,
    min: 1,
})

const model = defineModel<AuctionItem[]>({
    required: true,
})

const setDefaultItems = () => {
    return model.value.length < props.min
        ? defaultAuctionItems(props.min)
        : model.value
}

const items = reactive<AuctionItem[]>(setDefaultItems())

const add = () => {
    items.push(defaultAuctionItem())
}

const remove = (i: number) => {
    items.splice(i, 1)
}

watch(
    items,
    (current, _) => {
        model.value = current
    },
    { deep: true, immediate: true }
)
</script>

<template>
    <div class="space-y-4">
        <div class="space-y-4">
            <AuctionItemForm
                :key="i"
                :label="'Item ' + i"
                v-for="i in items.length"
                v-model="items[i - 1]">
                <div v-if="items.length > props.min">
                    <button
                        class="rounded-lg flex hover:bg-red-100 cursor-pointer p-1 gap-x-1 items-center bg-red-100/50 border border-red-200 text-red-800"
                        @click="remove(i - 1)"
                        type="button">
                        <TrashIcon class="size-4" />
                    </button>
                </div>
            </AuctionItemForm>
        </div>
        <Button
            v-if="items.length < props.max"
            @click="add"
            class="flex justify-center hover:bg-secondary/30 gap-x-2 items-center bg-secondary/20"
            type="button">
            <ListPlusIcon class="text-primary" />
            <span class="text-primary">Add item</span></Button
        >
    </div>
</template>
