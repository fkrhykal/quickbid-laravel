<script setup lang="ts">
import { computed, ref, Teleport, useTemplateRef } from 'vue'
import { onClickOutside } from '../../utils/onClickOutside'
import { ImagePlusIcon } from '../icons'

const model = defineModel<File | null>({ required: true })

const image = computed(() => {
    if (model.value) {
        return URL.createObjectURL(model.value)
    }
    return null
})

const handleInput = (event: Event) => {
    if (event.target instanceof HTMLInputElement) {
        const file = event.target.files ? event.target.files[0] : null
        if (file) {
            model.value = file
        }
    }
}

const isOpen = ref(false)

const open = () => {
    isOpen.value = true
}

const close = () => {
    isOpen.value = false
}

const deleteImage = () => {
    model.value = null
    close()
}

const handleChange = (event: Event) => {
    handleInput(event)
    close()
}

const imagePreview = useTemplateRef('image-preview')
const imagePreviewTriger = useTemplateRef('image-preview-trigger')

onClickOutside(close, imagePreview, imagePreviewTriger)
</script>

<template>
    <div
        class="relative size-full aspect-square border border-border rounded-md bg-input shadow">
        <div
            ref="image-preview-trigger"
            @click="open"
            :class="[image === null ? 'pointer-events-none' : 'z-10']"
            class="size-full relative p-1">
            <img
                v-if="image"
                :src="image"
                class="size-full rounded-md object-cover" />
            <div
                v-else
                class="size-full absolute top-0 left-0 bottom-0 flex justify-center items-center text-tertiary">
                <ImagePlusIcon />
            </div>
            <Teleport
                v-if="isOpen"
                to="body">
                <div
                    class="size-full grid place-items-center bg-surface/10 backdrop-blur-md fixed z-99 top-0 left-0">
                    <div class="grid place-items-center max-w-[50%] gap-4">
                        <div
                            ref="image-preview"
                            class="border border-border rounded-md p-1 shadow"
                            v-if="image">
                            <img
                                :src="image"
                                class="size-full rounded-md object-cover" />
                        </div>
                    </div>
                </div>
            </Teleport>
        </div>
        <input
            class="size-full absolute top-0 left-0 opacity-0 cursor-pointer"
            type="file"
            @change="handleInput" />
    </div>
</template>
