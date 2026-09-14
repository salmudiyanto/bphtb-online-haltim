<template>
    <aside 
        class="fixed hidden lg:flex flex-col top-0 left-0 w-64 bg-white h-full border-r border-gray-200 pt-16 transition-transform duration-200"
        :class="{'translate-x-0': isOpen, '-translate-x-full': !isOpen, 'lg:translate-x-0': true}"
    >
        <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
            <ul class="flex flex-col py-4 space-y-1">
                <li class="px-5">
                    <div class="flex flex-row items-center h-8">
                        <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Menu Utama</div>
                    </div>
                </li>
                <li v-for="(item, index) in menuItems" :key="index">
                    <router-link 
                        :to="item.route" 
                        class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-primary pr-6"
                        active-class="bg-blue-50 text-primary border-primary font-medium"
                    >
                        <span class="inline-flex justify-center items-center ml-4">
                            <!-- Placeholder icon fallback -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path v-if="item.icon === 'home'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                <path v-else-if="item.icon === 'document'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">{{ item.label }}</span>
                    </router-link>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script>
export default {
    name: 'AppSidebar',
    props: {
        isOpen: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            menuItems: [
                { label: 'Dashboard', route: '/dashboard', icon: 'home' },
                { label: 'Pendaftaran BPHTB', route: '/input-pendaftaran', icon: 'document' },
                { label: 'Upload Persyaratan', route: '/upload-persyaratan', icon: 'document' },
                { label: 'Input SSPD', route: '/input-sspd', icon: 'document' }
            ]
        }
    }
}
</script>
