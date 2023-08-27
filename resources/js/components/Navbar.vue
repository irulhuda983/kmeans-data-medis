<script setup>
import { useRoute } from 'vue-router';
import DropdownProfil from "@/components/DropdownProfil.vue";

const route = useRoute();

</script>

<template>
    <div class="w-full h-full flex items-center justify-between box-border px-4 lg:px-8">
        <div class="text-2xl font-semibold">{{ route.meta.title }}</div>
        <div>
            <div class="box-border flex items-center justify-between">
                <DropdownProfil align="right" />
                <!-- <div class="w-[50px] h-[50px] rounded-full box-border overflow-hidden flex items-center justify-center">
                    
                </div> -->
            </div>
        </div>
    </div>
</template>