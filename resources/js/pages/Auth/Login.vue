<script setup>
import { reactive, ref } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";
import { useNotification } from "@kyvg/vue3-notification";
import LoadingBar from "@/components/LoadingBar.vue";
import EyeIcon from '@/components/icons/Eye.vue';
import EyeOffIcon from '@/components/icons/EyeOff.vue';

const authStore = useAuthStore();
const router = useRouter();
const { notify } = useNotification();

const loading = ref(false)
const eyeVisible = ref(true)
const passwordType = ref('password')

const payload = reactive({
    username: '',
    password: '',
});

const errors = reactive({
    username: null,
    password: null
});

const onLoginHandler = async () => {
    loading.value = true
    try {
        const data = await authStore.login(payload);

        location.reload()
    } catch (error) {
        loading.value = false
        if (error.status === 403) {
            notify({
                text: "Username atau password salah",
                type: 'error',
                duration: 2000
            })
        }else if(error.status == 422){
            let err = error.data.errors
            console.log(error.data)

            errors.username = err.username ? err.username[0] : null
            errors.password = err.password ? err.password[0] : null
        }else{
            notify({
                text: "Internal server error",
                type: 'error',
                duration: 2000
            })
        }
        loading.value = false
    }
}

const togglePasswordInputVisibility = () => {
    eyeVisible.value ? (passwordType.value = 'text') : (passwordType.value = 'password');

    eyeVisible.value = !eyeVisible.value;
}

</script>


<template>
    <div class="w-full h-screen box-border flex items-center justify-center p-3">
        <div class="box-border px-5 lg:px-10 py-10 lg:py-20 rounded-2xl text-white flex items-center justify-center bg-white/5 relative overflow-hidden">
            <LoadingBar v-if="loading" />
            <div class="w-full">
                <div class="font-thin text-sm mb-3">K MEANS DATA MEDIS</div>
                <div class="font-semibold text-3xl mb-4">Login Ke Akun Anda</div>
                <div class="text-sm text-gray-400">Masukkan Username dan password anda untuk melanjutkan</div>

                <form @submit.prevent="onLoginHandler()" class="mt-10">
                    <div class="mb-5">
                        <label for="username" class="text-sm text-gray-400">Username</label>
                        <div class="w-full box-border">
                            <input id="username" type="text" v-model="payload.username" @focus="errors.username = null" class="w-full rounded-lg outline-none px-4 py-3 text-sm border" :class="errors.username ? 'bg-red-600/10 border-red-500' : 'bg-gray-600 border-gray-600'" autocomplete="off">
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.username }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="password" class="text-sm text-gray-400">Password</label>
                        <div class="w-full relative">
                            <input id="password" @focus="errors.password = null" :type="passwordType" v-model="payload.password" class="w-full rounded-lg outline-none px-4 py-3 text-sm border" :class="errors.password ? 'bg-red-600/10 border-red-500' : 'bg-gray-600 border-gray-600'" autocomplete="off">
                            <button
                                type="button"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 z-5"
                                @click.prevent="togglePasswordInputVisibility()"
                            >
                                <EyeIcon v-show="eyeVisible" class="h-5 w-5" :class="errors.password ? 'text-red-500':'text-gray-400'" />
                                <EyeOffIcon v-show="!eyeVisible" class="h-5 w-5" :class="errors.password ? 'text-red-500':'text-gray-400'" />
                            </button>
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.password }}</div>
                    </div>

                    <div>
                        <button type="submit" class="w-full py-3 bg-[#7939FC] hover:bg-[#7939FC]/50 rounded-lg font-semibold">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>