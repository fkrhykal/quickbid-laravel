<script lang="ts">
const today = new Date()

export type DateField = {
    day: number
    month: number
    year: number
}

const flag = {
    START: 0,
    END: 1,
    RANGE: 2,
    ONE_DAY: 3,
    UNKNOWN: 4,
} as const

const action = {
    PICK_START: 0,
    PICK_END: 1,
}

type DateFlag = (typeof flag)[keyof typeof flag]

type Action = (typeof action)[keyof typeof action]
</script>

<script setup lang="ts">
import { days, months } from '@/utils/const'
import { computed, reactive, ref } from 'vue'
import { ChevronLeftIcon, ChevronRightIcon } from '../icons'

const currentMonth = ref(today.getMonth())
const currentYear = ref(today.getFullYear())

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

const after = (a: DateField, b: DateField): boolean => {
    if (a.year > b.year) {
        return true
    }
    if (a.year < b.year) {
        return false
    }
    if (a.month < b.month) {
        return false
    }
    return a.day > b.day
}

const before = (a: DateField, b: DateField): boolean => {
    if (a.year < b.year) {
        return true
    }
    if (a.year > b.year) {
        return false
    }
    if (a.month > b.month) {
        return false
    }
    return a.day < b.day
}

const equal = (a: DateField, b: DateField): boolean => {
    return a.day === b.day && a.month === b.month && a.year === b.year
}

const selectAction = ref<Action>(action.PICK_START)

//TODO: refactor this later (is working now, but definitely need some touch up)
const select = (d: DateField) => {
    switch (selectAction.value) {
        case action.PICK_START:
            if (equal(start, end)) {
                if (after(d, start)) {
                    end.day = d.day
                    end.month = d.month
                    end.year = d.year
                }
                if (before(d, start)) {
                    end.day = start.day
                    end.month = start.month
                    end.year = start.year

                    start.day = d.day
                    start.month = d.month
                    start.year = d.year
                }
                selectAction.value = action.PICK_START
                return
            }

            start.day = d.day
            start.month = d.month
            start.year = d.year

            end.day = d.day
            end.month = d.month
            end.year = d.year

            selectAction.value = action.PICK_END
            return
        case action.PICK_END:
            if (before(d, start)) {
                end.day = start.day
                end.month = start.month
                end.year = start.year

                start.day = d.day
                start.month = d.month
                start.year = d.year

                selectAction.value = action.PICK_START
                return
            }
            end.day = d.day
            end.month = d.month
            end.year = d.year
            selectAction.value = action.PICK_START
            return
    }
}

const getDateFlag = (d: DateField): DateFlag => {
    if (equal(d, start) && equal(d, end)) {
        return flag.ONE_DAY
    }
    if (equal(d, start)) {
        return flag.START
    }
    if (equal(d, end)) {
        return flag.END
    }
    if (after(d, start) && before(d, end)) {
        return flag.RANGE
    }
    return flag.UNKNOWN
}

const isDateFlag = (d: DateField, f: DateFlag): boolean => {
    return getDateFlag(d) === f
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
        <div class="mt-2 grid grid-cols-7 space-y-0.5">
            <button
                v-for="n in firstDayOfMonth"
                :key="'prev-' + n"
                class="text-tertiary aspect-square items-center rounded-md p-2">
                {{ firstDayOfMonthDate(n) }}
            </button>

            <button
                type="button"
                :class="{
                    'bg-tertiary/20 rounded-full': isDateFlag(
                        {
                            day,
                            month: currentMonth,
                            year: currentYear,
                        },
                        flag.ONE_DAY,
                    ),
                    'bg-tertiary/20 rounded-l-full': isDateFlag(
                        {
                            day,
                            month: currentMonth,
                            year: currentYear,
                        },
                        flag.START,
                    ),
                    'bg-tertiary/20 rounded-r-full': isDateFlag(
                        {
                            day,
                            month: currentMonth,
                            year: currentYear,
                        },
                        flag.END,
                    ),
                    'bg-tertiary/20': isDateFlag(
                        {
                            day,
                            month: currentMonth,
                            year: currentYear,
                        },
                        flag.RANGE,
                    ),
                }"
                @click="select({ day, month: currentMonth, year: currentYear })"
                class="aspect-square p-2"
                v-for="day in daysInMonth"
                :key="day">
                {{ day }}
            </button>
        </div>
    </div>
</template>
