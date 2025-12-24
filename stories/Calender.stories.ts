import type { Meta, StoryObj } from '@storybook/vue3-vite'
import Calender from '../resources/js/components/ui/Calender.vue'

const meta = {
    component: Calender,
    tags: ['autodocs'],
} satisfies Meta<typeof Calender>

export default meta

type Story = StoryObj<typeof meta>

export const Default: Story = {}
