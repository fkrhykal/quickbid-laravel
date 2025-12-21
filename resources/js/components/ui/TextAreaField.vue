<script setup lang="ts">
defineProps<{ id?: string; label?: string; placeholder?: string }>()

const model = defineModel({
    default: '',
    required: false,
})
</script>

<template>
    <div class="space-y-2">
        <label
            v-if="label"
            :for="id"
            class="text-primary block text-sm font-semibold tracking-tight"
            >{{ label }}</label
        >
        <textarea
            :id
            v-model="model"
            :placeholder
            class="focus:ring-ring bg-input border-border placeholder:text-tertiary w-full rounded-lg border p-2 placeholder:text-sm focus:ring-4 focus:outline-none"
            type="text"></textarea>
    </div>
</template>
