<script setup>
const props = defineProps(['fields']);

</script>

<template>
    <table class="w-full text-sm text-left bg-[#2F2B43]">
        <thead class="text-xs text-gray-400 bg-[#3B3955] uppercase border-b border-[#3A3650]">
            <tr>
                <th v-for="(item, i) in props.fields" :key="i" scope="col" class="px-4 py-3" :class="i == 0 ? 'w-[10px]': ''">
                    <span class="bg-[#3A3650] text-[#3A3650] rounded">{{ item }}</span>
                </th>
                <th scope="col" class="px-4 py-3"><div class="sr-only">Aksi</div></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="i in 5" :key="i" class="text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                <td v-for="(item, i) in props.fields" :key="i" class="px-4 py-3 whitespace-nowrap">
                    <span class="bg-[#3A3650] text-[#3A3650] rounded">{{ item }}</span>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="w-full flex justify-end space-x-2">
                        <a href="#" class="block bg-[#3A3650] text-[#3A3650] hover:text-indigo-600 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </a>
                        <a href="#" class="block bg-[#3A3650] text-[#3A3650] hover:text-indigo-600 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </a>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>