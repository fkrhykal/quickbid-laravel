<script setup lang="ts">
import { computed, reactive, watch } from 'vue'
import ImageField from './ImageField.vue'

const props = withDefaults(
    defineProps<{
        label?: string
        min?: number
        max?: number
        imgFieldClass?: string
        imgListPlaceholderClass?: string
    }>(),
    {
        max: 3,
        min: 1,
    }
)

const model = defineModel<File[]>({ required: true })

const files = reactive<(File | null)[]>(model.value)

const filledFiles = computed<File[]>(() => {
    return files.filter((file) => file instanceof File)
})

const slot = computed<number>(() => {
    return Math.min(filledFiles.value.length + 1, props.max)
})

watch(
    filledFiles,
    (current, _) => {
        model.value = current
    },
    { deep: true, immediate: true }
)
</script>

<template>
    <div class="space-y-2">
        <span
            v-if="label"
            class="text-primary block text-sm font-semibold tracking-tight"
            >{{ label }}</span
        >
        <div
            :class="imgListPlaceholderClass"
            class="flex gap-x-4">
            <ImageField
                :class="imgFieldClass"
                v-for="i in slot"
                v-model="files[i - 1]" />
        </div>
    </div>
</template>
