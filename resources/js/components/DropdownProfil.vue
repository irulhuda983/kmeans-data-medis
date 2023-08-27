<template>
  <div class="relative inline-flex">
    <button
      ref="trigger"
      class="inline-flex justify-center items-center group"
      aria-haspopup="true"
      @click.prevent="dropdownOpen = !dropdownOpen"
      :aria-expanded="dropdownOpen"
    >
      <!-- <div class="flex items-center truncate">
        <span class="truncate ml-2 text-sm font-medium group-hover:text-gray-800">Ahmad Deri.</span>
        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400" viewBox="0 0 12 12">
          <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
        </svg>
      </div> -->
      <img class="w-10 h-10 rounded-full" :src="ImgUser" alt="User" />
    </button>
    <transition
      enter-active-class="transition ease-out duration-200 transform"
      enter-from-class="opacity-0 -translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-out duration-200"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-show="dropdownOpen" class="bg-[#2A263E] origin-top-right z-10 absolute top-full w-24 shadow-lg border border-gray-700 py-1.5 rounded shadow-lg overflow-hidden mt-1" :class="align === 'right' ? 'right-0' : 'left-0'">
        <ul
          ref="dropdown"
          @focusin="dropdownOpen = true"
          @focusout="dropdownOpen = false"
        >
          <li @click="navigateProfil()">
            <a class="font-medium text-sm text-gray-400 hover:text-gray-200 flex items-center py-1 px-3" href="#"  @click.prevent="navigateProfil()">Profil</a>
          </li>
          <li @click.prevent="logout()">
            <a class="font-medium text-sm text-gray-400 hover:text-gray-200 flex items-center py-1 px-3" href="#" @click.prevent="logout()">Sign Out</a>
          </li>
        </ul>
      </div> 
    </transition>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from "@/stores/auth"
import ImgUser from "@/assets/user.png"

export default {
  name: 'DropdownProfile',
  props: ['align'],
  setup() {

    const dropdownOpen = ref(false)
    const trigger = ref(null)
    const dropdown = ref(null)

    const router = useRouter()
    const authStore = useAuthStore()

    // close on click outside
    const clickHandler = ({ target }) => {
      if (!dropdownOpen.value || dropdown.value.contains(target) || trigger.value.contains(target)) return
      dropdownOpen.value = false
    }

    // close if the esc key is pressed
    const keyHandler = ({ keyCode }) => {
      if (!dropdownOpen.value || keyCode !== 27) return
      dropdownOpen.value = false
    }

    onMounted(() => {
      document.addEventListener('click', clickHandler)
      document.addEventListener('keydown', keyHandler)
    })

    onUnmounted(() => {
      console.log(user)
      document.removeEventListener('click', clickHandler)
      document.removeEventListener('keydown', keyHandler)
    })

    const navigateProfil = () => {
      dropdownOpen.value = false
      router.push({ name: 'profil' })
    }

    const logout = async () => {
      await authStore.logout()
    }

    return {
      router,
      dropdownOpen,
      navigateProfil,
      trigger,
      dropdown,
      logout,
      ImgUser,
    }
  }
}
</script>