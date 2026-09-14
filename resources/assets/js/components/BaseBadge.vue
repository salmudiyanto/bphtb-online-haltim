<template>
    <span :class="computedClasses">
        <slot />
    </span>
</template>

<script>
export default {
    name: 'BaseBadge',
    props: {
        variant: {
            type: String,
            default: 'neutral' // neutral, primary, success, warning, danger
        },
        rounded: {
            type: Boolean,
            default: true
        }
    },
    computed: {
        computedClasses() {
            let classes = ['inline-flex', 'items-center', 'px-2.5', 'py-0.5', 'text-xs', 'font-medium'];
            
            if (this.rounded) {
                classes.push('rounded-full');
            } else {
                classes.push('rounded');
            }

            switch (this.variant) {
                case 'primary':
                    classes.push('bg-blue-100', 'text-blue-800');
                    break;
                case 'success':
                    classes.push('bg-green-100', 'text-green-800');
                    break;
                case 'warning':
                    classes.push('bg-yellow-100', 'text-yellow-800');
                    break;
                case 'danger':
                    classes.push('bg-red-100', 'text-red-800');
                    break;
                case 'neutral':
                default:
                    classes.push('bg-gray-100', 'text-gray-800');
                    break;
            }

            return classes.join(' ');
        }
    }
}
</script>
