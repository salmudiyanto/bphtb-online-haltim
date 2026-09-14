<template>
    <footer class="bg-white p-4 text-center text-sm text-gray-500 border-t border-gray-200 w-full mt-auto">
        &copy; {{ currentYear }} BPHTB Online. Seluruh Hak Cipta Dilindungi.
    </footer>
</template>

<script>
export default {
    name: 'AppFooter',
    computed: {
        currentYear() {
            return new Date().getFullYear();
        }
    }
}
</script>
