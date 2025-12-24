import type { Meta, StoryObj } from '@storybook/vue3-vite'
import Time from '../resources/js/components/ui/Time.vue'

const meta = {
    component: Time,
    tags: ['autodocs'],
} satisfies Meta<typeof Time>

export default meta

type Story = StoryObj<typeof meta>

export const Default: Story = {}
