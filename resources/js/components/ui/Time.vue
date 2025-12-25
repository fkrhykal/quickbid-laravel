<script setup lang="ts">
import { hours, minutes } from '@/utils/const'
import { numPadStart, px } from '@/utils/format'
import { onMounted, onUnmounted, Ref, ref, useTemplateRef, watch } from 'vue'
import { ColonIcon } from '../icons'

const props = withDefaults(
    defineProps<{ itemSize?: number; height?: number }>(),
    {
        itemSize: 40,
        height: 200,
    }
)

const hour = defineModel('hour', { default: 0 })
const minute = defineModel('minute', { default: 0 })

const size = { height: px(props.itemSize), width: px(props.itemSize) }
const spacer = { height: px(1000) }
const selector = { height: px(props.itemSize + 10) }

const timePlaceholder = useTemplateRef<HTMLDivElement>('time-placeholder')
const hourButtons = useTemplateRef<HTMLButtonElement[]>('hour-buttons')
const minuteButtons = useTemplateRef<HTMLButtonElement[]>('minute-buttons')

const activeHour = ref<number>(0)
const activeMinute = ref<number>(0)

const hourObserver = ref<IntersectionObserver>()
const minuteObserver = ref<IntersectionObserver>()

watch(activeHour, (h) => {
    hour.value = h
})

watch(activeMinute, (m) => {
    minute.value = m
})

onMounted(async () => {
    const defineObserver = (
        buttons: HTMLButtonElement[] | null,
        active: Ref<number>
    ) => {
        const obs = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const time =
                            entry.target.attributes.getNamedItem('data-value')
                        if (time !== null) {
                            active.value = parseInt(time.value)
                        }
                    }
                })
            },
            {
                root: timePlaceholder.value,
                rootMargin: '-45% 0px',
            }
        )

        buttons?.forEach((e) => {
            obs.observe(e)
        })

        return obs
    }

    hourObserver.value = defineObserver(hourButtons.value, activeHour)
    minuteObserver.value = defineObserver(minuteButtons.value, activeMinute)
})

onUnmounted(() => {
    hourObserver.value?.disconnect()
    minuteObserver.value?.disconnect()
})
</script>

<template>
    <div
        ref="time-placeholder"
        class="flex relative border size-min rounded-md border-border space-x-1 overflow-hidden"
        :style="{ height: px(height) }">
        <div
            ref="time-selector"
            :style="selector"
            class="absolute bg-tertiary/5 border-t-2 border-b-2 pointer-events-none border-tertiary/50 w-full top-[50%] -translate-y-[50%]"></div>
        <div
            ref="hour-wheel"
            class="pl-4 overflow-y-scroll no-scrollbar space-y-2 snap-y snap-mandatory">
            <div :style="spacer"></div>
            <button
                :class="[
                    activeHour === hour
                        ? 'text-xl text-primary/90'
                        : 'text-sm text-primary/60 ',
                ]"
                ref="hour-buttons"
                :data-value="hour"
                :style="size"
                class="p-2 snap-center transition-all aspect-square font-semibold rounded-md block w-full"
                v-for="hour in hours">
                {{ numPadStart(hour) }}
            </button>
            <div :style="spacer"></div>
        </div>

        <div
            class="self-center absolute top-[50%] -translate-y-[40%] left-[50%] -translate-x-[45%]">
            <ColonIcon class="text-primary/90" />
        </div>
        <div
            class="pr-4 overflow-y-scroll no-scrollbar space-y-2 snap-y snap-mandatory">
            <div :style="spacer"></div>
            <button
                :data-value="minute"
                ref="minute-buttons"
                :style="size"
                :class="[
                    activeMinute === minute
                        ? 'text-xl text-primary/90'
                        : 'text-sm text-primary/60 ',
                ]"
                class="p-2 snap-center transition-all aspect-square font-semibold rounded-md block w-full"
                v-for="minute in minutes">
                {{ numPadStart(minute) }}
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
