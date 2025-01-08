<template>
    <div>
        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased "
            style="background-color: rgb(245 247 249);">
            <div class="w-full h-10  flex items-center justify-center border-b-2 border-gray-500">
                <p class="text-2xl font-semibold text-center">
                    DES-PRMS: Personnel and Records School-Based Management System
                </p>
            </div>
            <div class="flex justify-between items-center bg-gray-200">
                <div class="flex">
                    <router-link to="/dashboard/main"
                        class="px-4 py-1 flex hover:bg-gray-300 hover:text-gray-900 text-black cursor-pointer blur-none tracking-wide antialiased font-roboto text-base ">
                        Main
                    </router-link>
                    <router-link v-if="isAdminVisible" to="/dashboard/personnelAdmin"
                        class="px-4 py-1 flex hover:bg-gray-300 hover:text-gray-900 text-black cursor-pointer blur-none tracking-wide antialiased font-roboto text-base ">
                        Personnel
                    </router-link>
                    <router-link v-if="isPersonnelVisible" to="/dashboard/personnel"
                        class="px-4 py-1 flex hover:bg-gray-300 hover:text-gray-900 text-black cursor-pointer blur-none tracking-wide antialiased font-roboto text-base ">
                        Personnel
                    </router-link>
                    <router-link to="/records"
                        class="px-4 py-1 flex hover:bg-gray-300 hover:text-gray-900 text-black cursor-pointer blur-none tracking-wide antialiased font-roboto text-base ">
                        Records
                    </router-link>
                    <router-link to="/generatereport"
                        class="px-4 py-1 flex hover:bg-gray-300 hover:text-gray-900 text-black cursor-pointer blur-none tracking-wide antialiased font-roboto text-base ">
                        Generate Report
                    </router-link>
                </div>
                <div>
                    <a @click="logout()" href="#"
                        class="flex items-center mr-4 text-black hover:text-gray-400 hidden lg:block">
                        <div class="flex">
                            <div>
                                <svg class="w-7 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                Logout
                            </div>
                        </div>
                    </a>

                </div>
            </div>
            <div class="p-5">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>

import { defineComponent, reactive, computed } from 'vue';
import { mapActions } from 'vuex';

export default defineComponent({
    data() {
        return {
            isPersonnelVisible: false,
            isAdminVisible: false,
        }
    },
    watch: {
    },
    methods: {
        ...mapActions(['logout']),
    },
    created() {
        const thiss = this;
        if (localStorage.getItem('userRole') == 1) {
            thiss.isAdminVisible = true;
        }
        if (localStorage.getItem('userRole') == 2) {
            thiss.isPersonnelVisible = true;
        }
    }
})
</script>

<style scoped>
.router-link-exact-active {
    background-color: rgb(107, 114, 128);
}
</style>
