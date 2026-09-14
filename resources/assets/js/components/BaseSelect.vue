<template>
    <div class="mb-4">
        <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1" :for="id">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        
        <div class="relative rounded-md shadow-sm">
            <select
                :id="id"
                :value="value"
                :disabled="disabled"
                :required="required"
                @change="$emit('input', $event.target.value)"
                @blur="$emit('blur', $event)"
                @focus="$emit('focus', $event)"
                :class="[
                    'form-control block w-full rounded-md sm:text-sm transition-colors duration-200 bg-white',
                    error ? 'border-red-500 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-primary focus:border-primary',
                    disabled ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : ''
                ]"
            >
                <option v-if="placeholder" value="" disabled selected>{{ placeholder }}</option>
                <option v-for="(option, index) in options" :key="index" :value="option.value || option">
                    {{ option.label || option }}
                </option>
            </select>
        </div>

        <p v-if="error" class="mt-1 text-sm text-red-600">
            {{ error }}
        </p>
        <p v-else-if="helpText" class="mt-1 text-sm text-gray-500">
            {{ helpText }}
        </p>
    </div>
</template>

<script>
export default {
    name: 'BaseSelect',
    props: {
        id: {
            type: String,
            default() {
                return `select-${Math.random().toString(36).substr(2, 9)}`;
            }
        },
        value: {
            type: [String, Number],
            default: ''
        },
        label: {
            type: String,
            default: ''
        },
        options: {
            type: Array,
            default: () => [] // Array of strings or objects { value: '...', label: '...' }
        },
        placeholder: {
            type: String,
            default: 'Pilih salah satu...'
        },
        error: {
            type: String,
            default: ''
        },
        helpText: {
            type: String,
            default: ''
        },
        disabled: {
            type: Boolean,
            default: false
        },
        required: {
            type: Boolean,
            default: false
        }
    }
}
</script>
