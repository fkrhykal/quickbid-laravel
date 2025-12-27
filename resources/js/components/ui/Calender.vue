<script lang="ts">
const today = new Date()

export type DateField = {
    day: number
    month: number
    year: number
}

const dateFlag = {
    START: 0,
    END: 1,
    RANGE: 2,
    ONE_DAY: 3,
    UNKNOWN: 4,
} as const

type DateFlag = (typeof dateFlag)[keyof typeof dateFlag]
</script>

<script setup lang="ts">
import { days, months } from '@/utils/const'
import { computed, reactive, ref } from 'vue'
import { ChevronLeftIcon, ChevronRightIcon } from '../icons'

const currentMonth = ref(today.getMonth())
const currentYear = ref(today.getFullYear())

defineProps<{}>()

const start = reactive({
    day: today.getDate(),
    month: today.getMonth(),
    year: today.getFullYear(),
})

const end = reactive({
    day: today.getDate(),
    month: today.getMonth(),
    year: today.getFullYear(),
})

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

const changeMonth = (step: number) => {
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

const getDateFlag = (date: DateField): DateFlag => {
    if (date.year >= start.year && date.year <= end.year) {
        if (date.month >= start.month && date.month <= end.month) {
            if (date.day == start.day && date.day === end.day) {
                return dateFlag.ONE_DAY
            }
            if (date.day == start.day) {
                return dateFlag.START
            }
            if (date.day == end.day) {
                return dateFlag.END
            }
            if (date.day > start.day && date.day < end.day) {
                return dateFlag.RANGE
            }
        }
    }
    return dateFlag.UNKNOWN
}

const isDateFlag = (date: DateField, flag: DateFlag): boolean => {
    return getDateFlag(date) === flag
}

const changeState = ref(0)

const select = (date: DateField) => {
    if (changeState.value === 0) {
        start.day = date.day
        start.month = date.month
        start.year = date.year
        changeState.value = 1
        return
    }
    end.day = date.day
    end.month = end.month
    end.year = end.year
    changeState.value = 0
}
</script>

<template>
    <div class="border-border max-w-[24rem] rounded-md border p-4">
        <div>
            <div class="flex w-full items-center justify-between">
                <button
                    class="border-border rounded-md border p-2"
                    type="button"
                    @click="changeMonth(-1)">
                    <ChevronLeftIcon class="size-4" />
                </button>
                <span>{{ months[currentMonth] }} {{ currentYear }}</span>
                <button
                    type="button"
                    class="border-border rounded-md border p-2"
                    @click="changeMonth(1)">
                    <ChevronRightIcon class="size-4" />
                </button>
            </div>
        </div>
        <div class="mt-4 grid grid-cols-7 gap-1">
            <span
                v-for="day in days"
                :key="day"
                class="text-center text-sm font-semibold tracking-tighter">
                {{ day }}
            </span>
        </div>
        <div class="mt-2 grid grid-cols-7 gap-0.5">
            <button
                v-for="n in firstDayOfMonth"
                :key="'prev-' + n"
                class="text-tertiary aspect-square items-center rounded-md p-2">
                {{ firstDayOfMonthDate(n) }}
            </button>

            <button
                type="button"
                :class="{
                    'bg-red-500': isDateFlag(
                        {
                            day,
                            month: currentMonth,
                            year: currentYear,
                        },
                        dateFlag.ONE_DAY,
                    ),
                    'bg-blue-500': isDateFlag(
                        {
                            day,
                            month: currentMonth,
                            year: currentYear,
                        },
                        dateFlag.START,
                    ),
                    'bg-green-500': isDateFlag(
                        {
                            day,
                            month: currentMonth,
                            year: currentYear,
                        },
                        dateFlag.END,
                    ),
                    'bg-yellow-500': isDateFlag(
                        {
                            day,
                            month: currentMonth,
                            year: currentYear,
                        },
                        dateFlag.RANGE,
                    ),
                }"
                @click="select({ day, month: currentMonth, year: currentYear })"
                class="aspect-square rounded-md p-2"
                v-for="day in daysInMonth"
                :key="day">
                {{ day }}
            </button>
        </div>
    </div>
</template>
