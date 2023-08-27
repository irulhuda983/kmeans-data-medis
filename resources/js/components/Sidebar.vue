<script setup>
import Logo from "@/assets/logo.png"
import AppsIcon from "@/components/icons/Apps.vue"
import MedisIcon from "@/components/icons/Medis.vue"
import ClusterIcon from "@/components/icons/Cluster.vue"
import UsersIcon from "@/components/icons/Users.vue"

import { useRouter, useRoute } from 'vue-router'

const route = useRoute()

</script>

<template>
    <div class="w-full box-boder h-full flex flex-row lg:flex-col items-center justify-between relative">
        <!-- logo -->
        <div class="absolute lg:relative left-3 lg:left-0 lg:w-full h-[72px] flex-none text-white flex items-center justify-center">
            <div class="rounded-full w-12 h-12 to-orange-200 flex items-center justify-center text-4xl text-indigo-500 font-bold">
                <img :src="Logo" alt="" class="h-8">
            </div>
        </div>
        <!-- end logo -->

        <div class="w-full h-full lg:flex-1 flex items-center justify-center flex-row lg:flex-col">
            <div class="w-full lg:w-auto lg:rounded-full bg-[#342855] box-border px-2 py-2 lg:py-4 lg:px-3 flex items-center justify-center flex-row lg:flex-col space-x-4 lg:space-x-0">
                <router-link
                    :to="{ name: 'dashboard' }"
                    class="flex items-center justify-center rounded-lg lg:rounded-full p-2 box-border lg:mb-3"
                    :class="route.meta.menu == 'dashboard' ? 'text-white bg-[#7939FC]' : 'text-gray-400 hover:text-white' "
                >
                    <div class="w-5 h-5">
                        <AppsIcon/>
                    </div>
                </router-link>

                <!-- bg-[#7939FC] -->
                <router-link
                    :to="{ name: 'datamedis' }"
                    class="flex items-center justify-center rounded-lg lg:rounded-full p-2 box-border lg:mb-3"
                    :class="route.meta.menu == 'datamedis' ? 'text-white bg-[#7939FC]' : 'text-gray-400 hover:text-white' "
                >
                    <div class="w-5 h-5">
                        <MedisIcon/>
                    </div>
                </router-link>

                <router-link
                    :to="{ name: 'cluster' }"
                    class="flex items-center justify-center rounded-lg lg:rounded-full p-2 box-border lg:mb-3"
                    :class="route.meta.menu == 'cluster' ? 'text-white bg-[#7939FC]' : 'text-gray-400 hover:text-white' "
                >
                    <div class="w-5 h-5">
                        <ClusterIcon/>
                    </div>
                </router-link>

                <router-link
                    :to="{ name: 'users' }"
                    class="flex items-center justify-center rounded-lg lg:rounded-full p-2 box-border lg:mb-3"
                    :class="route.meta.menu == 'users' ? 'text-white bg-[#7939FC]' : 'text-gray-400 hover:text-white' "
                >
                    <div class="w-5 h-5">
                        <UsersIcon/>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>