<template>
    <div class="flex items-start mb-4">
        <div class="flex items-center h-5">
            <input
                :id="id"
                type="checkbox"
                :checked="value"
                :disabled="disabled"
                @change="$emit('input', $event.target.checked)"
                :class="[
                    'focus:ring-primary h-4 w-4 text-primary border-gray-300 rounded transition duration-150 ease-in-out',
                    disabled ? 'bg-gray-100 cursor-not-allowed' : 'cursor-pointer'
                ]"
            />
        </div>
        <div class="ml-3 text-sm">
            <label :for="id" :class="['font-medium text-gray-700', disabled ? 'text-gray-400 cursor-not-allowed' : 'cursor-pointer']">
                {{ label }}
            </label>
            <p v-if="helpText" class="text-gray-500">{{ helpText }}</p>
            <p v-if="error" class="text-red-600 mt-1">{{ error }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BaseCheckbox',
    props: {
        id: {
            type: String,
            default() {
                return `checkbox-${Math.random().toString(36).substr(2, 9)}`;
            }
        },
        value: {
            type: Boolean,
            default: false
        },
        label: {
            type: String,
            required: true
        },
        helpText: {
            type: String,
            default: ''
        },
        error: {
            type: String,
            default: ''
        },
        disabled: {
            type: Boolean,
            default: false
        }
    }
}
</script>
