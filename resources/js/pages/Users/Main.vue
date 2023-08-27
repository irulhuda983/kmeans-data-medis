<script setup>
import { ref } from 'vue';

import AddIcon from '@/components/icons/Add.vue';
import UploadsIcon from '@/components/icons/Uploads.vue';
import Modal from '@/components/Modal.vue';
import Pagination from "@/components/Pagination.vue";

const modalAdd = ref()

const pageInfo = ref({
		current_page: 1,
		from: null,
		last_page: 1,
		per_page: 10,
		to: null,
		total: 0
	})
</script>


<template>
    <div class="box-border w-full">
        <div class="w-full box-border my-8 flex justify-end">
            <div class="flex items-center justify-center">
                <button
                    @click.prevent="modalAdd.open = true"
                    class="text-xs flex items-center justify-center bg-[#342855] border border-[#7939FC] p-2 box-border font-semibold text-gray-400 hover:text-white hover:bg-[#7939FC]"
                >
                    <div class="w-4 h-4 mr-2"><AddIcon/></div>
                    <div>Tambah</div>
                </button>
            </div>
        </div>
        <!-- table -->
        <div class="w-full box-border rounded-lg box-border overflow-hidden border border-[#3A3650]">
            <table class="w-full text-sm text-left bg-[#2F2B43]">
                <thead class="text-xs text-gray-400 bg-[#3B3955] uppercase border-b border-[#3A3650]">
                    <tr>
                        <th scope="col" class="px-4 py-3 w-[10px]">No</th>
                        <th scope="col" class="px-4 py-3">Kode</th>
                        <th scope="col" class="px-4 py-3">Nama</th>
                        <th scope="col" class="px-4 py-3">L/P</th>
                        <th scope="col" class="px-4 py-3">Umur</th>
                        <th scope="col" class="px-4 py-3">Diagnosa</th>
                        <th scope="col" class="px-4 py-3">Perawatan</th>
                        <th scope="col" class="px-4 py-3"><div class="sr-only">Aksi</div></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                        <td class="px-4 py-3 whitespace-nowrap">No</td>
                        <td class="px-4 py-3 whitespace-nowrap">Kode</td>
                        <td class="px-4 py-3 whitespace-nowrap">Nama Pasien</td>
                        <td class="px-4 py-3 whitespace-nowrap">L/P</td>
                        <td class="px-4 py-3 whitespace-nowrap">Umur</td>
                        <td class="px-4 py-3 whitespace-nowrap">Diagnosa</td>
                        <td class="px-4 py-3 whitespace-nowrap">Perawatan</td>
                        <td class="px-4 py-3 text-right">
                            <div class="w-full flex justify-end space-x-2">
                                <a href="#" class="block text-gray-600 hover:text-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr class="w-full">
                        <td colspan="7">
                            <div class="w-full px-4 py-3 flex items-center justify-between">
                                <div class="flex items-center justify-center space-x-2 text-xs">
                                    <span>showing</span>
                                    <select class="text-xs px-1 py-1 rounded">
                                        <option :value="10">10</option>
                                        <option :value="50">50</option>
                                        <option :value="100">100</option>
                                    </select>
                                    <div>from {{ pageInfo.from }}</div>
                                    <div>to {{ pageInfo.to }}</div>
                                </div>
                                <div>
                                    <Pagination
                                        :total="pageInfo.total"
                                        :currentPage="pageInfo.current_page"
                                        :perPage="pageInfo.per_page"
                                    />
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal add -->
    <Modal ref="modalAdd">
        <template v-slot:modal-body>
            <h1>Modal</h1>
            <button @click.prevent="modalAdd.open = false">close</button>
        </template>
    </Modal>
</template>