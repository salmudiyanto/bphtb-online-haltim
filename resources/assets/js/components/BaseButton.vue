<template>
    <button
        :type="type"
        :class="computedClasses"
        :disabled="disabled"
        @click="$emit('click', $event)"
    >
        <span v-if="loading" class="mr-2">
            <!-- Spinner Icon -->
            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </span>
        <slot />
    </button>
</template>

<script>
export default {
    name: 'BaseButton',
    props: {
        type: {
            type: String,
            default: 'button'
        },
        variant: {
            type: String,
            default: 'primary' // primary, secondary, outline, danger
        },
        size: {
            type: String,
            default: 'md' // sm, md, lg
        },
        disabled: {
            type: Boolean,
            default: false
        },
        loading: {
            type: Boolean,
            default: false
        },
        block: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        computedClasses() {
            let classes = ['btn', 'flex', 'items-center', 'justify-center', 'transition-colors', 'duration-200', 'focus:outline-none', 'rounded'];
            
            // Variants
            if (this.variant === 'primary') {
                classes.push('bg-primary', 'text-white', 'hover:bg-blue-700', 'border', 'border-transparent');
            } else if (this.variant === 'secondary') {
                classes.push('bg-secondary', 'text-white', 'hover:bg-purple-700', 'border', 'border-transparent');
            } else if (this.variant === 'outline') {
                classes.push('bg-transparent', 'text-primary', 'border', 'border-primary', 'hover:bg-blue-50');
            } else if (this.variant === 'danger') {
                classes.push('bg-red-600', 'text-white', 'hover:bg-red-700', 'border', 'border-transparent');
            }

            // Sizes
            if (this.size === 'sm') {
                classes.push('px-3', 'py-1', 'text-sm');
            } else if (this.size === 'md') {
                classes.push('px-4', 'py-2', 'text-base');
            } else if (this.size === 'lg') {
                classes.push('px-6', 'py-3', 'text-lg');
            }

            // Block
            if (this.block) {
                classes.push('w-full');
            }

            // Disabled/Loading
            if (this.disabled || this.loading) {
                classes.push('opacity-50', 'cursor-not-allowed');
            }

            return classes.join(' ');
        }
    }
}
</script>

<style scoped>
/* Optional specific overrides if Bootstrap messes it up too much */
</style>
