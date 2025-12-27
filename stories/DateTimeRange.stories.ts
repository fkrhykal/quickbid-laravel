import DateTimeRange from '@/components/ui/DateTimeRange.vue'
import type { Meta, StoryObj } from '@storybook/vue3-vite'

const meta = {
    component: DateTimeRange,
    tags: ['autodocs'],
} satisfies Meta<typeof DateTimeRange>

export default meta

type Story = StoryObj<typeof meta>

export const Default: Story = {}
