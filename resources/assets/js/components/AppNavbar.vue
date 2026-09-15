<template>
    <nav class="bg-white border-b border-gray-200 fixed z-30 w-full">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <!-- Left side -->
                <div class="flex items-center justify-start">
                    <button @click="$emit('toggle-sidebar')" class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <a href="#" class="text-xl font-bold flex items-center lg:ml-2.5">
                        <span class="self-center whitespace-nowrap text-primary">BPHTB Online</span>
                    </a>
                </div>
                
                <!-- Right side -->
                <div class="flex items-center">
                    <div class="hidden sm:flex items-center mr-3 text-sm text-gray-600">
                        <span class="font-medium mr-1">Selamat datang,</span>
                        <span>{{ userName }}</span>
                    </div>
                    
                    <div class="relative ml-3">
                        <div>
                            <button @click="dropdownOpen = !dropdownOpen" type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                                <span class="sr-only">Open user menu</span>
                                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                                    {{ userName.charAt(0).toUpperCase() }}
                                </div>
                            </button>
                        </div>
                        
                        <!-- Dropdown -->
                        <div v-if="dropdownOpen" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                            <a href="#" @click.prevent="logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Keluar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'AppNavbar',
    props: {
        userName: {
            type: String,
            default: 'User'
        }
    },
    data() {
        return {
            dropdownOpen: false
        }
    },
    methods: {
        logout() {
            const refreshToken = localStorage.getItem('refresh_token');
            axios.post('/api/v1/logout', { refresh_token: refreshToken })
                .finally(() => {
                    localStorage.removeItem('jwt_token');
                    localStorage.removeItem('refresh_token');
                    localStorage.removeItem('user_info');
                    this.$router.push({ name: 'login' }).catch(() => {});
                    this.$emit('logout');
                });
        }
    }
}
</script>
