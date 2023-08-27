<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, } from '@headlessui/vue'
import { ChevronRightIcon } from '@heroicons/vue/20/solid'
const props = defineProps(['data']);
</script>

<template>
    <div class="w-full box-border box-border overflow-hidden border border-[#3A3650] mb-5">
    <Disclosure v-slot="{ open }">
        <DisclosureButton class="w-full box-border px-4 py-2 flex items-center justify-between capitalize">
            <div>{{ data.nama }}</div>
            <ChevronRightIcon class="w-5 h-5" :class="open && 'rotate-90 transform'" />
        </DisclosureButton>
        <DisclosurePanel>
            <div class="w-full">
                <div class="w-full box-border">
                    <table class="w-full text-sm text-left bg-[#2F2B43] border border-[#3A3650]">
                        <thead class="text-xs text-gray-400 bg-[#3B3955] uppercase border-b border-[#3A3650]">
                            <tr>
                                <th scope="col" class="px-4 py-3 w-[10px]">No</th>
                                <th scope="col" class="px-4 py-3">Nama</th>
                                <th scope="col" class="px-4 py-3">Jenis Umur</th>
                                <th scope="col" class="px-4 py-3 w-[20]">Jenis Penyakit</th>
                                <th scope="col" class="px-4 py-3">Jenis Pelayanan</th>
                                <th scope="col" class="px-4 py-3">C1</th>
                                <th scope="col" class="px-4 py-3">C2</th>
                                <th scope="col" class="px-4 py-3">C3</th>
                                <th scope="col" class="px-4 py-3">Min</th>
                                <th scope="col" class="px-4 py-3">Class</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, i) in data.data_iterasi" :key="i" class="text-xs font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                                <td class="px-4 py-3 whitespace-nowrap">{{ item.no }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ item.nama }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ item.jenis_umur }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ item.jenis_penyakit }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ item.jenis_pelayanan }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ item.c1.toFixed(2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ item.c2.toFixed(2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ item.c3.toFixed(2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ item.min.toFixed(2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ item.cluster }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="w-full box-border">
                    <div class="w-full box-border px-4 py-2 capitalize border-l border-[#3A3650]">Centroid</div>
                    <table class="w-full text-xs text-left bg-[#2F2B43]">
                        <thead class="text-xs text-gray-400 bg-[#3B3955] uppercase border-b border-[#3A3650]">
                            <tr>
                                <th scope="col" class="px-4 py-3">Nama</th>
                                <th scope="col" class="px-4 py-3">C1</th>
                                <th scope="col" class="px-4 py-3">C2</th>
                                <th scope="col" class="px-4 py-3">C3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-xs font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                                <td class="px-4 py-3 whitespace-nowrap">Jenis Umur</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ data.centroid.umur.k1.toFixed(2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ data.centroid.umur.k2.toFixed(2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ data.centroid.umur.k3.toFixed(2) }}</td>
                            </tr>

                            <tr class="text-xs font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                                <td class="px-4 py-3 whitespace-nowrap">Jenis Penyakit</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ data.centroid.penyakit.k1.toFixed(2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ data.centroid.penyakit.k2.toFixed(2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ data.centroid.penyakit.k3.toFixed(2) }}</td>
                            </tr>

                            <tr class="text-xs font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                                <td class="px-4 py-3 whitespace-nowrap">Jenis Pelayanan</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ data.centroid.pelayanan.k1.toFixed(2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ data.centroid.pelayanan.k2.toFixed(2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ data.centroid.pelayanan.k3.toFixed(2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </DisclosurePanel>
    </Disclosure>        
        
    </div>
</template>