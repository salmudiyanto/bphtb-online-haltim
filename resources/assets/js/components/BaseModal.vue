<template>
    <transition name="modal">
        <div v-if="value" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <!-- Background overlay -->
                <transition name="overlay">
                    <div v-if="value" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeOnBackdrop ? $emit('input', false) : null" aria-hidden="true"></div>
                </transition>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <transition name="panel">
                    <div v-if="value" :class="[
                        'inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle w-full',
                        sizeClass
                    ]">
                        <!-- Header -->
                        <div v-if="title" class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ title }}
                            </h3>
                            <button @click="$emit('input', false)" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Body -->
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <slot />
                        </div>

                        <!-- Footer -->
                        <div v-if="$slots.footer" class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <slot name="footer" />
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: 'BaseModal',
    props: {
        value: {
            type: Boolean,
            required: true
        },
        title: {
            type: String,
            default: ''
        },
        size: {
            type: String,
            default: 'md' // sm, md, lg, xl
        },
        closeOnBackdrop: {
            type: Boolean,
            default: true
        }
    },
    computed: {
        sizeClass() {
            switch (this.size) {
                case 'sm': return 'sm:max-w-sm';
                case 'md': return 'sm:max-w-lg';
                case 'lg': return 'sm:max-w-2xl';
                case 'xl': return 'sm:max-w-4xl';
                default: return 'sm:max-w-lg';
            }
        }
    },
    watch: {
        value(isOpen) {
            if (isOpen) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }
    },
    beforeDestroy() {
        document.body.style.overflow = '';
    }
}
</script>

<style scoped>
.modal-enter-active, .modal-leave-active {
    transition: opacity 0.3s ease;
}
.modal-enter, .modal-leave-to {
    opacity: 0;
}

.overlay-enter-active, .overlay-leave-active {
    transition: opacity 0.3s ease;
}
.overlay-enter, .overlay-leave-to {
    opacity: 0;
}

.panel-enter-active, .panel-leave-active {
    transition: all 0.3s ease-out;
}
.panel-enter {
    opacity: 0;
    transform: translateY(10px) scale(0.95);
}
.panel-leave-to {
    opacity: 0;
    transform: translateY(10px) scale(0.95);
}
</style>
