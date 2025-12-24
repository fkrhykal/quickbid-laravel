<script setup lang="ts">
import { days, months } from '@/utils/const'
import { computed, ref } from 'vue'
import { ChevronLeftIcon, ChevronRightIcon } from '../icons'

const today = new Date()
const currentMonth = ref(today.getMonth())
const currentYear = ref(today.getFullYear())

const daysInMonth = computed(() => {
    return new Date(currentYear.value, currentMonth.value + 1, 0).getDate()
})

const firstDayOfMonth = computed(() => {
    return new Date(currentYear.value, currentMonth.value, 1).getDay()
})

const firstDayOfMonthDate = (day: number) => {
    const date =
        new Date(currentYear.value, currentMonth.value, 0).getDate() -
        (firstDayOfMonth.value - day)
    return date
}

function changeMonth(step: number) {
    const v = currentMonth.value + step
    if (v < 0) {
        currentMonth.value = 11
        currentYear.value = currentYear.value - Math.abs(v % 11)
        return
    }
    if (v > 11) {
        currentMonth.value = 0
        currentYear.value = currentYear.value + (v % 11)
        return
    }
    currentMonth.value = v
}
</script>

<template>
    <div class="border-border border p-4 rounded-md max-w-[24rem]">
        <div class="border-border border p-4 rounded-md">
            <div>
                <div class="w-full flex items-center justify-between">
                    <button
                        class="border p-2 rounded-md border-border"
                        type="button"
                        @click="changeMonth(-1)">
                        <ChevronLeftIcon class="size-4" />
                    </button>
                    <span>{{ months[currentMonth] }} {{ currentYear }}</span>
                    <button
                        type="button"
                        class="border p-2 rounded-md border-border"
                        @click="changeMonth(1)">
                        <ChevronRightIcon class="size-4" />
                    </button>
                </div>
            </div>
            <div class="grid mt-4 grid-cols-7 gap-1">
                <span
                    v-for="day in days"
                    :key="day"
                    class="text-sm tracking-tighter font-semibold text-center">
                    {{ day }}
                </span>
            </div>
            <div class="grid grid-cols-7 gap-0.5 mt-2">
                <button
                    v-for="n in firstDayOfMonth"
                    :key="'prev-' + n"
                    class="aspect-square border items-center border-border p-2 hover:bg-tertiary/20 rounded-md">
                    {{ firstDayOfMonthDate(n) }}
                </button>

                <button
                    type="button"
                    class="aspect-square border border-border p-2 hover:bg-tertiary/20 rounded-md"
                    v-for="day in daysInMonth"
                    :key="day">
                    {{ day }}
                </button>
            </div>
        </div>
    </div>
</template>
