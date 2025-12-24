<script setup lang="ts">
import { ref, useTemplateRef } from 'vue'
import { ColonIcon } from '../icons'

const props = withDefaults(
    defineProps<{ itemSize?: number; height?: number }>(),
    {
        itemSize: 40,
        height: 200,
    }
)

const hours = Array(12)
    .fill(undefined)
    .map((_, i) => i)

const minutes = Array(60)
    .fill(undefined)
    .map((_, i) => i)

const px = (v: number) => {
    return `${v}px`
}

const size = { height: px(props.itemSize), width: px(props.itemSize) }
const spacer = { height: px(1000) }

const timeSelector = useTemplateRef<HTMLDivElement>('time-selector')
const hourButtons = useTemplateRef<HTMLButtonElement[]>('hour-buttons')
const minuteButtons = useTemplateRef<HTMLButtonElement[]>('minute-buttons')
const activeHour = ref()
const activeMinute = ref()

const hourScroll = () => {
    if (!hourButtons.value) {
        return
    }
    hourButtons.value.forEach((btn, i) => {
        if (!timeSelector.value) {
            return
        }
        const s = timeSelector.value.getBoundingClientRect().bottom - 5
        const h = btn.getBoundingClientRect().bottom
        if (s == h) {
            activeHour.value = hours[i]
        }
    })
}

const minuteScroll = () => {
    if (!minuteButtons.value) {
        return
    }
    minuteButtons.value.forEach((btn, i) => {
        if (!timeSelector.value) {
            return
        }
        const s = timeSelector.value.getBoundingClientRect().bottom - 5
        const m = btn.getBoundingClientRect().bottom
        if (s == m) {
            activeMinute.value = minutes[i]
        }
    })
}

const format = (v: number) => {
    return v.toString().padStart(2, '0')
}
</script>

<template>
    <div>
        <p>{{ activeHour }}</p>
        <p>{{ activeMinute }}</p>
    </div>
    <div
        class="flex relative border size-min rounded-md border-border space-x-1 overflow-hidden"
        :style="{ height: px(height) }">
        <div
            ref="time-selector"
            :style="{ height: px(itemSize + 10) }"
            class="absolute bg-tertiary/5 border-t-2 border-b-2 pointer-events-none border-tertiary/50 w-full top-[50%] -translate-y-[50%]"></div>
        <div
            @scroll="hourScroll"
            class="pl-4 overflow-y-scroll no-scrollbar space-y-2 snap-y snap-mandatory">
            <div :style="spacer"></div>
            <button
                ref="hour-buttons"
                :style="size"
                class="p-2 snap-center aspect-square border border-border font-semibold text-sm text-primary/60 rounded-md block w-full"
                v-for="hour in hours">
                {{ format(hour) }}
            </button>
            <div :style="spacer"></div>
        </div>

        <div class="self-center">
            <ColonIcon class="text-tertiary/80" />
        </div>
        <div
            @scroll="minuteScroll"
            class="pr-4 overflow-y-scroll no-scrollbar space-y-2 snap-y snap-mandatory">
            <div :style="spacer"></div>
            <button
                ref="minute-buttons"
                :style="size"
                class="p-2 snap-center aspect-square border border-border font-semibold text-sm text-primary/60 rounded-md block w-full"
                v-for="minute in minutes">
                {{ format(minute) }}
            </button>
            <div :style="spacer"></div>
        </div>
    </div>
</template>

<style>
@layer utilities {
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
}
</style>
