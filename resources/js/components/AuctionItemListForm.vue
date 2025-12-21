<script setup lang="ts">
import { reactive, watch } from 'vue'
import type { AuctionItem } from './AuctionItemForm.vue'
import AuctionItemForm from './AuctionItemForm.vue'
import Button from './ui/Button.vue'

const props = withDefaults(defineProps<{ min?: number; max?: number }>(), {
    max: 3,
    min: 1,
})

const model = defineModel<AuctionItem[]>({
    required: true,
})

const defaultItem = () => ({
    description: '',
    name: '',
    pictures: [],
    price: 0,
})

const setDefaultItems = () => {
    return model.value.length < props.min
        ? Array(props.min).fill(defaultItem())
        : model.value
}

const items = reactive<AuctionItem[]>(setDefaultItems())

const add = () => {
    items.push(defaultItem())
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
                v-for="i in items.length"
                v-model="items[i - 1]" />
        </div>
        <Button
            v-if="items.length < props.max"
            @click="add"
            type="button"
            >Add Item</Button
        >
    </div>
</template>
