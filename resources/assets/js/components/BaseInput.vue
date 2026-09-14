<template>
    <div class="mb-4">
        <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1" :for="id">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        
        <div class="relative rounded-md shadow-sm">
            <input
                :id="id"
                :type="type"
                :placeholder="placeholder"
                :value="value"
                :disabled="disabled"
                :required="required"
                @input="$emit('input', $event.target.value)"
                @blur="$emit('blur', $event)"
                @focus="$emit('focus', $event)"
                :class="[
                    'form-control block w-full rounded-md sm:text-sm transition-colors duration-200',
                    error ? 'border-red-500 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-primary focus:border-primary',
                    disabled ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : ''
                ]"
            />
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
    name: 'BaseInput',
    props: {
        id: {
            type: String,
            default() {
                return `input-${Math.random().toString(36).substr(2, 9)}`;
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
        type: {
            type: String,
            default: 'text'
        },
        placeholder: {
            type: String,
            default: ''
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
