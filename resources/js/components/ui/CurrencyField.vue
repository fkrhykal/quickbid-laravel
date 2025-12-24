<script setup lang="ts">
import { ref } from 'vue'

defineProps<{
    label?: string
    id?: string
    required?: boolean
    placeholder?: string
}>()

const model = defineModel<number>({
    default: 0,
    set(v) {
        return typeof v === 'number' ? v : Number(v)
    },
})

const focus = ref(false)
</script>

<template>
    <div class="space-y-2">
        <label
            v-if="label"
            :for="id"
            class="text-primary block text-sm font-semibold tracking-tight"
            >{{ label }}</label
        >
        <div
            :class="{ 'ring-ring ring-4 outline-none': focus }"
            class="flex items-center bg-input border-border placeholder:text-tertiary w-full rounded-lg border placeholder:text-sm">
            <span
                class="bg-tertiary/20 text-xs font-semibold h-full rounded-l-md p-3"
                >Rp</span
            >
            <input
                :required
                :id
                @focus="focus = true"
                @blur="focus = false"
                v-model="model"
                :placeholder
                class="rounded-r-md bg-transparent p-2 focus:outline-none size-full"
                type="number" />
        </div>
    </div>
</template>
