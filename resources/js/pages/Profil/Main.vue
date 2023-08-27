<script setup>
import { useAuthStore } from '@/stores/auth'
const user = localStorage.getItem('USER') ? JSON.parse(localStorage.getItem('USER')) : null

console.log(user)
</script>


<template>
    <div class="box-border w-full flex flex-col lg:flex-row py-10">
        <div class="w-full lg:w-1/2 box-border bg-[#3B3955] rounded box-border p-6 lg:mr-5 mb-5 lg:mb-0 flex flex-col lg:flex-row">
            <div class="w-full lg:w-auto flex-none flex items-start justify-center mb-2 mr-5">
                <div class="w-56 h-56 mb-5 lg:mb-0 bg-gray-300 rounded-lg box-border overflow-hidden">
                    <img :src="user.foto" alt="" class="w-full">
                </div>
            </div>

            <div class="w-full flex-1">
                <div class="w-full flex items-center text-sm mb-2">
                    <div class="w-32">Nama</div>
                    <div class="w-4">:</div>
                    <div>{{ user.nama }}</div>
                </div>

                <div class="w-full flex items-center text-sm mb-2">
                    <div class="w-32">Username</div>
                    <div class="w-4">:</div>
                    <div>{{ user.username }}</div>
                </div>

                <div class="w-full flex items-center text-sm mb-2">
                    <div class="w-32">Email</div>
                    <div class="w-4">:</div>
                    <div>{{ user.email }}</div>
                </div>

                <div class="w-full flex items-center text-sm mb-2">
                    <div class="w-32">Bergabung</div>
                    <div class="w-4">:</div>
                    <div class="text-xs">{{ user.created_at.split('T')[0] }}</div>
                </div>

                <div>
                    <button>edit</button>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 box-border bg-[#3B3955] rounded box-border p-4 mb-10 lg:mb-0">
            ubah password
        </div>
    </div>
</template>