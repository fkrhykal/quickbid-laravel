<script lang="ts">
export type AuctionItem = {
    name: string
    pictures: File[]
    description: string
    price: number
}
</script>

<script setup lang="ts">
import { computed, ref } from 'vue'
import ChevronDownIcon from './icons/ChevronDownIcon.vue'
import ChevronUpIcon from './icons/ChevronUpIcon.vue'
import { ImageListField, TextAreaField, TextField } from './ui'

const props = withDefaults(defineProps<{ label?: string }>(), {
    label: 'Item',
})

const open = ref(true)

const model = defineModel<AuctionItem>({
    required: true,
})

const reactiveLabel = computed(() => {
    return model.value.name.trim().length > 0 ? model.value?.name : props.label
})
</script>

<template>
    <div class="border border-border rounded-md bg-raised">
        <div
            @click="open = !open"
            :class="[
                open ? 'border-b border-border rounded-t-md' : 'rounded-md',
            ]"
            class="flex bg-elevated p-4 items-center justify-between">
            <span
                class="text-primary text-sm block font-semibold tracking-tight"
                >{{ reactiveLabel }}</span
            >
            <div>
                <ChevronUpIcon
                    class="size-4"
                    v-if="open" />
                <ChevronDownIcon
                    class="size-4"
                    v-else />
            </div>
        </div>
        <div
            class="space-y-6 p-4"
            v-if="open">
            <div>
                <TextField
                    v-model="model.name"
                    label="Name*" />
            </div>

            <div>
                <ImageListField
                    v-model="model.pictures"
                    img-field-class="max-w-[30%]"
                    label="Pictures*" />
            </div>
            <div>
                <TextAreaField
                    v-model="model.description"
                    label="Description" />
            </div>
        </div>
    </div>
</template>
