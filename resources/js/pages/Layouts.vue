<script setup>
import { ref } from "vue"
import { RouterView } from "vue-router"
import Navbar from "@/components/Navbar.vue"
import Sidebar from "@/components/Sidebar.vue"
</script>


<template>
    <div class="w-full box-border overflow-hidden bg-[#2A263E] text-[#EFECFD]">
        <div class="w-full box-border overflow-hidden flex">
            <div class="fixed lg:relative bottom-0 block w-full lg:w-20 flex-none lg:h-screen z-10">
                <Sidebar />
            </div>

            <div class="w-full h-screen flex-1 box-border overflow-x-hidden overflow-y-auto">
                <div class="w-full box-border h-[64px]">
                    <Navbar />
                </div>
                <!-- <div class="w-full box-border overflow-x-hidden overflow-y-auto px-8" style="height: calc(100vh - 64px)"> -->
                <div class="w-full box-border overflow-x-hidden px-4 lg:px-8">
                    <RouterView />
                </div>
            </div>
        </div>
    </div>
</template>