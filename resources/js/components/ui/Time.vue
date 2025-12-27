<script setup lang="ts">
import { hours, minutes } from '@/utils/const'
import { px } from '@/utils/format'
import {
    HTMLAttributes,
    onMounted,
    onUnmounted,
    Ref,
    ref,
    useTemplateRef,
    watch,
} from 'vue'
import { ColonIcon } from '../icons'

const props = withDefaults(defineProps<{ itemSize?: number }>(), {
    itemSize: 40,
})

const height = props.itemSize * 5

const hour = defineModel('hour', {
    default: 0,
    set(v) {
        if (v < 0) {
            return 0
        }
        if (v > 23) {
            return 23
        }
        return v
    },
    get(v) {
        if (v < 0) {
            return 0
        }
        if (v > 23) {
            return 23
        }
        return v
    },
})
const minute = defineModel('minute', {
    default: 0,
    set(v) {
        if (v < 0) {
            return 0
        }
        if (v > 59) {
            return 59
        }
        return v
    },
    get(v) {
        if (v < 0) {
            return 0
        }
        if (v > 59) {
            return 59
        }
        return v
    },
})

const itemStyle: HTMLAttributes['style'] = {
    height: px(props.itemSize),
    width: px(props.itemSize),
}
const spacerStyle: HTMLAttributes['style'] = {
    height: px(height / 2 - props.itemSize / 2),
}
const selectorStyle: HTMLAttributes['style'] = {
    height: px(props.itemSize + 12),
}

const timePlaceholder = useTemplateRef<HTMLDivElement>('time-placeholder')
const hourButtons = useTemplateRef<HTMLButtonElement[]>('hour-buttons')
const minuteButtons = useTemplateRef<HTMLButtonElement[]>('minute-buttons')
const hourWheel = useTemplateRef<HTMLDivElement>('hour-wheel')
const minuteWheel = useTemplateRef<HTMLDivElement>('minute-wheel')

const activeHour = ref<number>(hour.value)
const activeMinute = ref<number>(minute.value)

const hourObserver = ref<IntersectionObserver>()
const minuteObserver = ref<IntersectionObserver>()

const scrollPosititon = (active: number) => {
    return active * (props.itemSize + 8)
}

const hourClick = (h: number) => {
    hourWheel.value?.scrollTo({
        top: scrollPosititon(h),
        behavior: 'smooth',
    })
}

const minuteClick = (m: number) => {
    minuteWheel.value?.scrollTo({
        top: scrollPosititon(m),
        behavior: 'smooth',
    })
}

watch(activeHour, (h) => {
    hour.value = h
})

watch(activeMinute, (m) => {
    minute.value = m
})

onMounted(() => {
    hourWheel.value?.scrollTo({
        top: scrollPosititon(activeHour.value),
        behavior: 'instant',
    })
    minuteWheel.value?.scrollTo({
        top: scrollPosititon(activeMinute.value),
        behavior: 'instant',
    })

    const defineObserver = (
        buttons: HTMLButtonElement[] | null,
        active: Ref<number>,
    ) => {
        const obs = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const time =
                            entry.target.attributes.getNamedItem('data-value')
                        active.value = Number(time?.value)
                        console.log({ s: hourWheel.value?.scrollTop })
                    }
                })
            },
            {
                root: timePlaceholder.value,
                rootMargin: '-50% 0px',
            },
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
        class="bg-input border-border relative flex size-min space-x-1 overflow-hidden rounded-md border"
        :style="{ height: px(height) }">
        <div
            ref="time-selector"
            :style="selectorStyle"
            class="bg-tertiary/5 border-tertiary/50 pointer-events-none absolute top-[50%] w-full -translate-y-[50%] border-t-2 border-b-2"></div>
        <div
            ref="hour-wheel"
            class="no-scrollbar snap-y snap-mandatory space-y-2 overflow-y-scroll pl-4">
            <div :style="spacerStyle"></div>
            <button
                @click="hourClick(h.value)"
                :class="[
                    activeHour === h.value
                        ? 'text-primary/90 text-xl'
                        : 'text-primary/60 hover:bg-tertiary/10 cursor-pointer text-sm',
                ]"
                ref="hour-buttons"
                :data-value="h.value"
                :style="itemStyle"
                class="block aspect-square w-full snap-center rounded-md p-2 font-semibold transition-all"
                v-for="h in hours">
                {{ h.label }}
            </button>
            <div :style="spacerStyle"></div>
        </div>

        <div
            class="absolute top-[50%] left-[50%] -translate-x-[45%] -translate-y-[40%] self-center">
            <ColonIcon class="text-primary/90" />
        </div>
        <div
            ref="minute-wheel"
            class="no-scrollbar snap-y snap-mandatory space-y-2 overflow-y-scroll pr-4">
            <div :style="spacerStyle"></div>
            <button
                @click="minuteClick(m.value)"
                :data-value="m.value"
                ref="minute-buttons"
                :style="itemStyle"
                :class="[
                    activeMinute === m.value
                        ? 'text-primary/90 text-xl'
                        : 'text-primary/60 hover:bg-tertiary/10 cursor-pointer text-sm',
                ]"
                class="block aspect-square w-full snap-center rounded-md p-2 font-semibold transition-all"
                v-for="m in minutes">
                {{ m.label }}
            </button>
            <div :style="spacerStyle"></div>
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
