<script
    setup
    lang="ts"
    generic="TOption extends Record<TKeyValue, TValue> & Record<TKeyLabel, TLabel>, TKeyValue extends string, TKeyLabel extends string, TValue, TLabel">
import { computed, ref } from "vue";
import { ChevronDownIcon, ChevronUpIcon } from "../icons";

const props = defineProps<{
    options: TOption[];
    optionValueKey: TKeyValue;
    optionLabelKey: TKeyLabel;
    placeholder: string;
    label?: string;
    id?: string;
}>();

const open = ref(false);

const selected = ref<TOption | null>(null);

const model = defineModel<TValue>();

const select = (option: TOption) => {
    selected.value = option;
    open.value = false;
    model.value = option[props.optionValueKey];
};

const selectedLabel = computed<TLabel>(() => {
    return selected.value
        ? selected.value[props.optionLabelKey]
        : props.placeholder;
});

const isSelectedValue = (option: TOption) => {
    return selected.value
        ? selected.value[props.optionValueKey] === option[props.optionValueKey]
        : false;
};
</script>

<template>
    <div>
        <span v-if="label" class="font-semibold text-sm tracking-tight">{{
            label
        }}</span>
        <div
            :id
            @click="open = !open"
            class="border flex justify-between items-center bg-input mt-2 border-border p-2 rounded-md">
            <div>
                <p v-if="selected">
                    {{ selectedLabel }}
                </p>
                <p v-else>Select category</p>
            </div>
            <div>
                <ChevronUpIcon class="size-4" v-if="open" />
                <ChevronDownIcon v-else class="size-4" />
            </div>
        </div>
        <Transition>
            <div
                v-if="open"
                class="border border-border mt-2 rounded-md p-2 space-y-0.5">
                <div
                    :class="[isSelectedValue(option) ? 'bg-gray-100' : '']"
                    @click="select(option)"
                    class="p-2 hover:bg-gray-100 rounded-md"
                    v-for="option in options">
                    {{ option[optionLabelKey] }}
                </div>
            </div>
        </Transition>
    </div>
</template>
