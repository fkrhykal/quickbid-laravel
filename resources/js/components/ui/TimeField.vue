<script setup lang="ts">
import { numPadStart } from '@/utils/format'
import { onClickOutside } from '@/utils/onClickOutside'
import { ref, useTemplateRef } from 'vue'
import { ColonIcon } from '../icons'
import Time from './Time.vue'

const open = ref(false)

const hour = defineModel<number>('hour', {
    default: 0,
})

const minute = defineModel<number>('minute', {
    default: 0,
})

const timePicker = useTemplateRef<HTMLDivElement>('time-picker')
const timePickerTrigger = useTemplateRef<HTMLDivElement>('time-picker-trigger')

onClickOutside(
    () => {
        open.value = false
    },
    timePicker,
    timePickerTrigger,
)
</script>

<template>
    <div class="relative">
        <div
            ref="time-picker-trigger"
            @click="open = true"
            class="bg-input border-border flex w-fit items-center rounded-md border">
            <div class="w-8 py-2 pl-2 text-center">
                {{ numPadStart(hour) }}
            </div>
            <div><ColonIcon class="size-4" /></div>
            <div class="w-8 py-2 pr-2 text-center">
                {{ numPadStart(minute) }}
            </div>
        </div>

        <div
            ref="time-picker"
            class="absolute mt-2 shadow"
            v-if="open">
            <Time
                class="w-full"
                v-model:hour="hour"
                v-model:minute="minute" />
        </div>
    </div>
</template>
