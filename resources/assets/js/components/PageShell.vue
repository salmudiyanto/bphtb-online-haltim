<template>
    <div class="flex h-screen bg-gray-50 overflow-hidden font-sans">
        <!-- Navbar -->
        <AppNavbar @toggle-sidebar="sidebarOpen = !sidebarOpen" :user-name="userName" />

        <!-- Main Wrapper -->
        <div class="flex overflow-hidden pt-16 w-full">
            
            <!-- Sidebar -->
            <AppSidebar :is-open="sidebarOpen" />
            
            <!-- Mobile sidebar backdrop -->
            <div v-if="sidebarOpen" @click="sidebarOpen = false" class="bg-gray-900 bg-opacity-50 fixed inset-0 z-10 lg:hidden"></div>

            <!-- Content Area -->
            <div class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64 flex flex-col">
                <main class="flex-grow p-4 lg:p-6">
                    <slot />
                </main>
                
                <AppFooter />
            </div>
        </div>
    </div>
</template>

<script>
import AppNavbar from './AppNavbar.vue';
import AppSidebar from './AppSidebar.vue';
import AppFooter from './AppFooter.vue';

export default {
    name: 'PageShell',
    components: {
        AppNavbar,
        AppSidebar,
        AppFooter
    },
    data() {
        return {
            sidebarOpen: false,
            userName: 'Admin BPHTB'
        }
    },
    watch: {
        $route() {
            // Close sidebar on route change in mobile
            this.sidebarOpen = false;
        }
    }
}
</script>
