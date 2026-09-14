<template>
    <div class="bg-white overflow-hidden shadow sm:rounded-lg border border-gray-100">
        <!-- Header -->
        <div v-if="title || $slots.header" class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <slot name="header">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ title }}
                </h3>
                <p v-if="subtitle" class="mt-1 max-w-2xl text-sm text-gray-500">
                    {{ subtitle }}
                </p>
            </slot>
        </div>
        
        <!-- Body -->
        <div :class="['px-4 py-5 sm:p-6', bodyClass]">
            <slot />
        </div>

        <!-- Footer -->
        <div v-if="$slots.footer" class="px-4 py-4 sm:px-6 bg-gray-50 border-t border-gray-200">
            <slot name="footer" />
        </div>
    </div>
</template>

<script>
export default {
    name: 'BaseCard',
    props: {
        title: {
            type: String,
            default: ''
        },
        subtitle: {
            type: String,
            default: ''
        },
        bodyClass: {
            type: String,
            default: ''
        }
    }
}
</script>
