import type { Meta, StoryObj } from '@storybook/vue3-vite'
import TimeField from '../resources/js/components/ui/TimeField.vue'

const meta = {
    component: TimeField,
    tags: ['autodocs'],
} satisfies Meta<typeof TimeField>

export default meta

type Story = StoryObj<typeof meta>

export const Default: Story = {}
