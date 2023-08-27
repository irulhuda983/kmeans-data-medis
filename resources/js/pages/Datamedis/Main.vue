<script setup>
import { ref, reactive, onMounted } from 'vue';

import AddIcon from '@/components/icons/Add.vue';
import UploadsIcon from '@/components/icons/Uploads.vue';
import DownloadIcon from '@/components/icons/Download.vue';
import Modal from '@/components/Modal.vue';
import Pagination from "@/components/Pagination.vue";
import LoadingBar from "@/components/LoadingBar.vue";
import LoadingTable from "@/components/LoadingTable.vue";
import { useNotification } from "@kyvg/vue3-notification";

const dataset = ref([])
const optJenisPenyakit = ref([])
const { notify } = useNotification();

const formatter = ref({
  date: 'DD-MM-YYYY',
  month: 'MMM'
})

const modalAdd = ref()
const modalUpload = ref()
const modalUpdate = ref()
const modalDelete = ref()

const file = ref()
const errorFile = ref(null)
const loading = ref(false)
const loadingSave = ref(false)

const pageInfo = ref({
	current_page: 1,
	from: null,
	last_page: 1,
	per_page: 10,
	to: null,
	total: 0
})

const params = reactive({
    search: "",
    page: 1,
    limit: 10,
    order: "tanggal:desc",
})

const payload = reactive({
    id: '',
    kode: '',
    tanggal: '',
    nama: '',
    jenis_kelamin: '',
    umur: '',
    penyakit: '',
    pelayanan: '',
    file: null,
})

const errors = reactive({
    kode: null,
    tanggal: null,
    nama: null,
    jenis_kelamin: null,
    umur: null,
    penyakit: null,
    pelayanan: null,
})

const resetPayloadAndError = () => {
    payload.id = ''
    payload.kode = ''
    payload.tanggal = ''
    payload.nama = ''
    payload.jenis_kelamin = ''
    payload.umur = ''
    payload.penyakit = ''
    payload.pelayanan = ''
    payload.file = null

    errors.kode = null
    errors.tanggal = null
    errors.nama = null
    errors.jenis_kelamin = null
    errors.umur = null
    errors.penyakit = null
    errors.pelayanan = null
    errors.file = null
}

// modal
const closeModalAdd = () => {
    modalAdd.value.open = false
}

const closeModalUpload = () => {
    resetPayloadAndError()
    modalUpload.value.open = false
}

const openModalUpdate = async (id) => {
    loadingSave.value = true
    try{
        const { data } = await axios.get(`/rekam-medis/${id}/show`)
        const rekamMedis = data.data
        payload.id = rekamMedis.id
        payload.kode = rekamMedis.kode
        payload.tanggal = rekamMedis.tanggal
        payload.nama = rekamMedis.nama
        payload.jenis_kelamin = rekamMedis.jenis_kelamin
        payload.umur = rekamMedis.umur
        payload.penyakit = rekamMedis.penyakit
        payload.pelayanan = rekamMedis.pelayanan
        modalUpdate.value.open = true
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }finally{
        loadingSave.value = false
    }
}

const closeModalUpdate = () => {
    resetPayloadAndError()
    modalUpdate.value.open = false
}

const openModalDelete = (id) => {
    payload.id = id
    modalDelete.value.open = true
}

const closeModalDelete = () => {
    payload.id = ''
    modalDelete.value.open = false
}
// modal

// crud
const getOptJenisPenyakit = async () => {
    try{
        const { data } = await axios.get('/options/jenis-penyakit')
        optJenisPenyakit.value = data.data
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }
}

const fetchData = async () => {
    loading.value = true
    try{
        const { data } = await axios.get('/rekam-medis', { params })
        dataset.value = data.data
        pageInfo.value = data.meta
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }finally{
        loading.value = false
    }
}

const storeData = async () => {
    loadingSave.value = true
    try{
        const { data } = await axios.post('/rekam-medis', payload)
        fetchData()
        resetPayloadAndError()
        modalAdd.value.open = false
        notify({
            text: "Data Rekam Medis berhasil ditambahkan",
            type: 'success',
            duration: 2000
        })
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }else if(e.response.status == 422) {
            const err = e.response.data.errors
            errors.kode = err.kode ? err.kode[0] : null
            errors.tanggal = err.tanggal ? err.tanggal[0] : null
            errors.nama = err.nama ? err.nama[0] : null
            errors.jenis_kelamin = err.jenis_kelamin ? err.jenis_kelamin[0] : null
            errors.umur = err.umur ? err.umur[0] : null
            errors.penyakit = err.penyakit ? err.penyakit[0] : null
            errors.pelayanan = err.pelayanan ? err.pelayanan[0] : null
        }else{
            notify({
                text: "Server is Maintenent",
                type: 'error',
                duration: 2000
            })
        }
    }finally{
        loadingSave.value = false
    }
}

const uploadData = async () => {
    loadingSave.value = true
    try{
        let dataPayload = new FormData()
        if (file.value.files[0] !== undefined) {
            dataPayload.append("file", file.value.files[0]);
        }
        const { data } = await axios.post(`/rekam-medis/import`,  dataPayload, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        })

        fetchData()
        closeModalUpload()
        notify({
            text: "Data Rekam Medis berhasil diupload",
            type: 'success',
            duration: 2000
        })
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }else if(e.response.status == 422) {
            const err = e.response.data.errors
            errors.file = err.file ? err.file[0] : null
        }else{
            notify({
                text: "Server is Maintenent",
                type: 'error',
                duration: 2000
            })
        }
    }finally{
        loadingSave.value = false
    }
}

const exportData = () => {
    axios({
        url: '/rekam-medis/export',
        method: 'POST',
        responseType: 'blob', // important
    }).then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'rekam-medis.xlsx');
        document.body.appendChild(link);
        link.click();
    });
}

const updateData = async () => {
    loadingSave.value = true
    try{
        const { data } = await axios.post(`/rekam-medis/${payload.id}/update`, payload)
        fetchData()
        closeModalUpdate()
        notify({
            text: "Data Rekam Medis berhasil diupdate",
            type: 'success',
            duration: 2000
        })
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }else if(e.response.status == 422) {
            const err = e.response.data.errors
            errors.kode = err.kode ? err.kode[0] : null
            errors.tanggal = err.tanggal ? err.tanggal[0] : null
            errors.nama = err.nama ? err.nama[0] : null
            errors.jenis_kelamin = err.jenis_kelamin ? err.jenis_kelamin[0] : null
            errors.umur = err.umur ? err.umur[0] : null
            errors.penyakit = err.penyakit ? err.penyakit[0] : null
            errors.pelayanan = err.pelayanan ? err.pelayanan[0] : null
        }else{
            notify({
                text: "Server is Maintenent",
                type: 'error',
                duration: 2000
            })
        }
    }finally{
        loadingSave.value = false
    }
}

const deleteData = async () => {
    loadingSave.value = true
    try{
        const { data } = await axios.delete(`/rekam-medis/${payload.id}/delete`)
        fetchData()
        closeModalDelete()
        notify({
            text: "Data Rekam Medis berhasil dihapus",
            type: 'success',
            duration: 2000
        })
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }finally{
        loadingSave.value = false
    }
}
// end crud

const readFile = () => {
    errors.file = null
    const files = file.value.files[0]
    const sizeFile = files.size
    const tipeFile = files.type

    const arrType = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel']
    const maxFile = 5 * 1048576

    if(!arrType.includes(tipeFile)) {
        errors.file = 'Type File must be excel file'
        return
    }

    if(sizeFile > maxFile) {
        errors.file = 'file size cannot be larger than 5 mb'
        return
    }

    payload.file = URL.createObjectURL(files)
}

const downloadFile = () => {
    console.log('download')
}

const changePage = (page) => {
    params.page = page
    fetchData()
}

onMounted(() => {
    getOptJenisPenyakit()
    fetchData()
})

</script>


<template>
    <div class="box-border w-full">
        <div class="w-full box-border my-8 flex items-center justify-between">
            <div class="w-full lg:w-1/2">
            <!-- <form @submit.prevent="serachNrkb()"> -->
                <div class="w-full box-border relative flex items-center justify-center">
                    <div class="absolute left-4">
                        <div class="w-4 h-4 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 513.749 513.749" style="enable-background:new 0 0 513.749 513.749;" xml:space="preserve" class="w-full h-full fill-current">
                            <g>
                                <path d="M504.352,459.061l-99.435-99.477c74.402-99.427,54.115-240.344-45.312-314.746S119.261-9.277,44.859,90.15   S-9.256,330.494,90.171,404.896c79.868,59.766,189.565,59.766,269.434,0l99.477,99.477c12.501,12.501,32.769,12.501,45.269,0   c12.501-12.501,12.501-32.769,0-45.269L504.352,459.061z M225.717,385.696c-88.366,0-160-71.634-160-160s71.634-160,160-160   s160,71.634,160,160C385.623,314.022,314.044,385.602,225.717,385.696z"/>
                            </g>
                            </svg>
                        </div>
                    </div>
                    <input v-model="params.search" @change.prevent="fetchData()" type="search" id="search" class="pl-12 bg-[#3B3955] border-gray-600 w-full rounded-lg outline-none px-4 py-3 text-xs border" autocomplete="off" placeholder="Masukkan Nama Pasien lalu enter">
                </div>
            <!-- </form> -->
            </div>
            <div class="flex items-center justify-center">
                <button
                    @click.prevent="modalUpload.open = true"
                    class="flex items-center justify-center bg-[#342855] border border-[#7939FC] border-r-transparent p-2 box-border text-sm font-semibold text-gray-400 hover:text-white hover:bg-[#7939FC]"
                >
                    <div class="w-4 h-4 mr-2"><UploadsIcon/></div>
                    <div>Uploads</div>
                </button>
                <button
                    @click.prevent="exportData()"
                    class="flex items-center justify-center bg-[#342855] border border-[#7939FC] border-r-transparent p-2 box-border text-sm font-semibold text-gray-400 hover:text-white hover:bg-[#7939FC]"
                >
                    <div class="w-4 h-4 mr-2"><DownloadIcon/></div>
                    <div>Download</div>
                </button>
                <button
                    @click.prevent="modalAdd.open = true"
                    class="flex items-center justify-center bg-[#342855] border border-[#7939FC] p-2 box-border text-sm font-semibold text-gray-400 hover:text-white hover:bg-[#7939FC]"
                >
                    <div class="w-4 h-4 mr-2"><AddIcon/></div>
                    <div>Tambah</div>
                </button>
            </div>
        </div>
        <!-- table -->
        <div class="w-full box-border rounded-lg box-border overflow-hidden border border-[#3A3650]">
            <LoadingTable v-if="loading" :fields="['no', 'kode', 'tanggal', 'nama', 'L/P', 'umur', 'kategori_umur', 'penyakit', 'pelayanan']" />
            <table v-else class="w-full text-sm text-left bg-[#2F2B43]">
                <thead class="text-xs text-gray-400 bg-[#3B3955] uppercase border-b border-[#3A3650]">
                    <tr>
                        <th scope="col" class="px-4 py-3 w-[10px]">No</th>
                        <th scope="col" class="px-4 py-3">Kode</th>
                        <th scope="col" class="px-4 py-3">Tanggal</th>
                        <th scope="col" class="px-4 py-3">Nama</th>
                        <th scope="col" class="px-4 py-3">L/P</th>
                        <th scope="col" class="px-4 py-3">Umur</th>
                        <th scope="col" class="px-4 py-3">Kategori Umur</th>
                        <th scope="col" class="px-4 py-3">Penyakit</th>
                        <th scope="col" class="px-4 py-3">Pelayanan</th>
                        <th scope="col" class="px-4 py-3"><div class="sr-only">Aksi</div></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="dataset.length != 0">
                    <tr v-for="(item, i) in dataset" :key="i" class="text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                        <td class="px-4 py-3 whitespace-nowrap">{{ (pageInfo.current_page - 1) * pageInfo.per_page + 1 + i }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ item.kode }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ item.tanggal }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ item.nama }}</td>
                        <td class="px-4 py-3 whitespace-nowrap capitalize">{{ item.jenis_kelamin }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ item.umur }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ item.jenisUmur?.nama }}</td>
                        <td class="px-4 py-3 whitespace-nowrap capitalize">{{ item.jenis_penyakit?.nama }}</td>
                        <td class="px-4 py-3 whitespace-nowrap capitalize">{{ item.pelayanan.replace('_', ' ') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="w-full flex justify-end space-x-2">
                                <a href="#" @click.prevent="openModalUpdate(item.id)" class="block text-gray-600 hover:text-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>

                                <a href="#" @click.prevent="openModalDelete(item.id)" class="block text-red-400 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr class="w-full">
                        <td colspan="9">
                            <div class="w-full px-4 py-3 flex items-center justify-between">
                                <div class="flex items-center justify-center space-x-2 text-xs">
                                    <span>showing</span>
                                    <select @change.prevent="fetchData()" v-model="params.limit" class="text-xs px-1 py-1 rounded bg-white/10">
                                        <option class="bg-[#2F2B43]" :value="10">10</option>
                                        <option class="bg-[#2F2B43]" :value="50">50</option>
                                        <option class="bg-[#2F2B43]" :value="100">100</option>
                                    </select>
                                    <div>from {{ pageInfo.from }}</div>
                                    <div>to {{ pageInfo.to }}</div>
                                </div>
                                <div>
                                    <Pagination
                                        :total="pageInfo.total"
                                        :currentPage="pageInfo.current_page"
                                        :perPage="pageInfo.per_page"
                                        @changePage="changePage"
                                    />
                                </div>
                            </div>
                        </td>
                    </tr>
                    </template>
                    <template v-else>
                    <tr class="text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                        <td colspan="9" class="px-4 py-3 whitespace-nowrap text-center">Tidak Ada Data</td>
                    </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal add -->
    <Modal ref="modalAdd">
      <template v-slot:modal-body>
        <div class="w-full bg-[#2A263E] text-[#EFECFD] relative overflow-hidden">
            <LoadingBar v-if="loadingSave" />
            <div class="w-full">
                <div class="bg-gray-900 font-semibold text-xl box-border w-full p-4">Tambah Data</div>
                <div class="w-full box-border p-4">
                    <div class="mb-5">
                        <label for="kode" class="text-sm text-gray-400">Kode Medis</label>
                        <div class="w-full box-border">
                            <input id="kode" type="text" v-model="payload.kode" @focus="errors.kode = null" class="w-full rounded-lg outline-none px-4 py-2.5 text-sm border" :class="errors.kode ? 'bg-red-600/10 border-red-500' : 'bg-[#1f2937] border-gray-600'" autocomplete="off">
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.kode }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="tanggal" class="text-sm text-gray-400">Tanggal</label>
                        <div class="w-full box-border">
                            <vue-tailwind-datepicker as-single :formatter="formatter" v-model="payload.tanggal" />
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.tanggal }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="nama" class="text-sm text-gray-400">Nama Pasien</label>
                        <div class="w-full box-border">
                            <input id="nama" type="text" v-model="payload.nama" @focus="errors.nama = null" class="w-full rounded-lg outline-none px-4 py-2.5 text-sm border" :class="errors.nama ? 'bg-red-600/10 border-red-500' : 'bg-[#1f2937] border-gray-600'" autocomplete="off">
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.nama }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="jenis_kelamin" class="text-sm text-gray-400">Jenis Kelamin</label>
                        <div class="w-full box-border">
                            <select id="jenis_kelamin" type="text" v-model="payload.jenis_kelamin" @focus="errors.jenis_kelamin = null" class="w-full rounded-lg outline-none px-4 py-2.5 text-sm border" :class="errors.jenis_kelamin ? 'bg-red-600/10 border-red-500' : 'bg-[#1f2937] border-gray-600'" autocomplete="off">
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.jenis_kelamin }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="umur" class="text-sm text-gray-400">Umur</label>
                        <div class="w-full box-border">
                            <input id="umur" type="text" v-model="payload.umur" @focus="errors.umur = null" class="w-full rounded-lg outline-none px-4 py-2.5 text-sm border" :class="errors.umur ? 'bg-red-600/10 border-red-500' : 'bg-[#1f2937] border-gray-600'" autocomplete="off">
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.umur }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="penyakit" class="text-sm text-gray-400">Penyakit</label>
                        <div class="w-full box-border">
                            <select id="penyakit" type="text" v-model="payload.penyakit" @focus="errors.penyakit = null" class="capitalize w-full rounded-lg outline-none px-4 py-2.5 text-sm border" :class="errors.penyakit ? 'bg-red-600/10 border-red-500' : 'bg-[#1f2937] border-gray-600'">
                                <option value="">Pilih Jenis Penyakit</option>
                                <option v-for="(item, i) in optJenisPenyakit" :key="i" :value="item.id" class="capitalize">{{ item.text }}</option>
                            </select>
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.penyakit }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="pelayanan" class="text-sm text-gray-400">Pelayanan</label>
                        <div class="w-full box-border">
                            <select id="pelayanan" type="text" v-model="payload.pelayanan" @focus="errors.pelayanan = null" class="w-full rounded-lg outline-none px-4 py-2.5 text-sm border" :class="errors.pelayanan ? 'bg-red-600/10 border-red-500' : 'bg-[#1f2937] border-gray-600'" autocomplete="off">
                                <option value="rawat_inap">Rawat Inap</option>
                                <option value="rawat_jalan">Rawat Jalan</option>
                            </select>
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.pelayanan }}</div>
                    </div>
                </div>
                <div v-if="loadingSave == false" class="flex items-center justify-between py-4">
                    <div class="flex justify-end items-center space-x-3 box-border px-4 py-2">
                        <button
                            @click.prevent="storeData"
                            class="px-4 py-2 rounded bg-indigo-600 text-white text-xs font-semibold border border-indigo-600 hover:bg-transparent hover:text-indigo-600"
                        >
                            Simpan
                        </button>
                        <button
                            @click.prevent="closeModalAdd"
                            class="px-4 py-2 rounded bg-red-500 text-white text-xs font-semibold border border-red-500 hover:bg-transparent hover:text-red-500"
                        >
                        Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
      </template>
    </Modal>
    <!-- end modal add -->

    <!-- modal tambah -->
    <Modal ref="modalUpload">
      <template v-slot:modal-body>
        <div class="w-full bg-[#2A263E] text-[#EFECFD] relative overflow-hidden">
            <LoadingBar v-if="loadingSave" />
          <div class="w-full">
            <div class="font-semibold text-xl box-border w-full p-4">Upload Data Rekam Medis</div>
            <div class="w-full box-border p-4">
              <div class="flex items-center justify-center w-full">
                  <label for="media-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-lg cursor-pointer" :class="errorFile ? 'border-red-300':'border-[#EFECFD]'">
                      <div v-if="payload.file" class="flex flex-col items-center justify-center pt-5 pb-6 text-green-500">
                          <svg xmlns="http://www.w3.org/2000/svg" id="file" data-name="Layer 1" viewBox="0 0 24 24" class="w-40 fill-current">
                              <path xmlns="http://www.w3.org/2000/svg" d="M15.27,13.64l-1.97,2.36,1.97,2.36c.35,.42,.3,1.05-.13,1.41-.19,.16-.41,.23-.64,.23-.29,0-.57-.12-.77-.36l-1.73-2.08-1.73,2.08c-.2,.24-.48,.36-.77,.36-.23,0-.45-.08-.64-.23-.42-.35-.48-.98-.13-1.41l1.97-2.36-1.97-2.36c-.35-.42-.3-1.05,.13-1.41,.43-.35,1.05-.3,1.41,.13l1.73,2.08,1.73-2.08c.35-.42,.98-.48,1.41-.13,.42,.35,.48,.98,.13,1.41Zm6.73-3.15v8.51c0,2.76-2.24,5-5,5H7c-2.76,0-5-2.24-5-5V5C2,2.24,4.24,0,7,0h4.51c1.87,0,3.63,.73,4.95,2.05l3.48,3.49c1.32,1.32,2.05,3.08,2.05,4.95ZM15.05,3.46c-.32-.32-.67-.59-1.05-.81V7c0,.55,.45,1,1,1h4.34c-.22-.38-.49-.73-.81-1.05l-3.48-3.49Zm4.95,7.02c0-.16,0-.33-.02-.49h-4.98c-1.65,0-3-1.35-3-3V2.02c-.16-.02-.32-.02-.49-.02H7c-1.65,0-3,1.35-3,3v14c0,1.65,1.35,3,3,3h10c1.65,0,3-1.35,3-3V10.49Z"/>
                          </svg>
                          <!-- mediaFile.files[0].type == 'application/pdf' -->
                          <div class="mt-2 text-gray-500 font-semibold text-center">{{ file.files[0].name }}</div>
                      </div>

                      <div v-else class="flex flex-col items-center justify-center pt-5 pb-6">
                          <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                          </svg>
                          <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                          <p class="text-xs text-gray-500 dark:text-gray-400">Excel File (MAX. 5mb)</p>
                      </div>
                      <input id="media-file" ref="file" type="file" class="sr-only" @change="readFile" />
                  </label>
              </div> 
              <div v-if="errors.file" class="text-red-500 italic text-xs mt-1">{{ errors.file }}</div>

            </div>
            <div class="flex items-center justify-between">
              <a href="/contoh_upload_rekam_medis.xlsx" class="px-4 text-sm">Download contoh</a>
              <div class="flex justify-end items-center space-x-3 box-border px-4 py-2">
                <button
                  @click.prevent="uploadData"
                  class="px-4 py-2 rounded bg-indigo-600 text-white text-xs font-semibold border border-indigo-600 hover:bg-transparent hover:text-indigo-600"
                >
                  Simpan
                </button>
                <button
                  @click.prevent="closeModalUpload"
                  class="px-4 py-2 rounded bg-red-500 text-white text-xs font-semibold border border-red-500 hover:bg-transparent hover:text-red-500"
                >
                  Batal
                </button>
              </div>
            </div>
          </div>
        </div>
      </template>
    </Modal>
    <!-- end modal upload -->

    <!-- modal update -->
    <Modal ref="modalUpdate">
      <template v-slot:modal-body>
        <div class="w-full bg-[#2A263E] text-[#EFECFD] relative overflow-hidden">
            <LoadingBar v-if="loadingSave" />
            <div class="w-full">
                <div class="bg-gray-900 font-semibold text-xl box-border w-full p-4">Update Data</div>
                <div class="w-full box-border p-4">
                    <div class="mb-5">
                        <label for="kode" class="text-sm text-gray-400">Kode Medis</label>
                        <div class="w-full box-border">
                            <input id="kode" type="text" v-model="payload.kode" @focus="errors.kode = null" class="w-full rounded-lg outline-none px-4 py-2.5 text-sm border" :class="errors.kode ? 'bg-red-600/10 border-red-500' : 'bg-[#1f2937] border-gray-600'" autocomplete="off">
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.kode }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="tanggal" class="text-sm text-gray-400">Tanggal</label>
                        <div class="w-full box-border">
                            <vue-tailwind-datepicker as-single :formatter="formatter" v-model="payload.tanggal" />
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.tanggal }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="nama" class="text-sm text-gray-400">Nama Pasien</label>
                        <div class="w-full box-border">
                            <input id="nama" type="text" v-model="payload.nama" @focus="errors.nama = null" class="w-full rounded-lg outline-none px-4 py-2.5 text-sm border" :class="errors.nama ? 'bg-red-600/10 border-red-500' : 'bg-[#1f2937] border-gray-600'" autocomplete="off">
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.nama }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="jenis_kelamin" class="text-sm text-gray-400">Jenis Kelamin</label>
                        <div class="w-full box-border">
                            <select id="jenis_kelamin" type="text" v-model="payload.jenis_kelamin" @focus="errors.jenis_kelamin = null" class="w-full rounded-lg outline-none px-4 py-2.5 text-sm border" :class="errors.jenis_kelamin ? 'bg-red-600/10 border-red-500' : 'bg-[#1f2937] border-gray-600'" autocomplete="off">
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.jenis_kelamin }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="umur" class="text-sm text-gray-400">Umur</label>
                        <div class="w-full box-border">
                            <input id="umur" type="text" v-model="payload.umur" @focus="errors.umur = null" class="w-full rounded-lg outline-none px-4 py-2.5 text-sm border" :class="errors.umur ? 'bg-red-600/10 border-red-500' : 'bg-[#1f2937] border-gray-600'" autocomplete="off">
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.umur }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="penyakit" class="text-sm text-gray-400">Penyakit</label>
                        <div class="w-full box-border">
                            <select id="penyakit" type="text" v-model="payload.penyakit" @focus="errors.penyakit = null" class="capitalize w-full rounded-lg outline-none px-4 py-2.5 text-sm border" :class="errors.penyakit ? 'bg-red-600/10 border-red-500' : 'bg-[#1f2937] border-gray-600'">
                                <option value="">Pilih Jenis Penyakit</option>
                                <option v-for="(item, i) in optJenisPenyakit" :key="i" :value="item.id" class="capitalize">{{ item.text }}</option>
                            </select>
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.penyakit }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="pelayanan" class="text-sm text-gray-400">Pelayanan</label>
                        <div class="w-full box-border">
                            <select id="pelayanan" type="text" v-model="payload.pelayanan" @focus="errors.pelayanan = null" class="w-full rounded-lg outline-none px-4 py-2.5 text-sm border" :class="errors.pelayanan ? 'bg-red-600/10 border-red-500' : 'bg-[#1f2937] border-gray-600'" autocomplete="off">
                                <option value="rawat_inap">Rawat Inap</option>
                                <option value="rawat_jalan">Rawat Jalan</option>
                            </select>
                        </div>
                        <div class="text-red-500 font-normal text-[11px] italic">{{ errors.pelayanan }}</div>
                    </div>
                </div>
                <div v-if="loadingSave == false" class="flex items-center justify-between py-4">
                    <div class="flex justify-end items-center space-x-3 box-border px-4 py-2">
                        <button
                            @click.prevent="updateData"
                            class="px-4 py-2 rounded bg-indigo-600 text-white text-xs font-semibold border border-indigo-600 hover:bg-transparent hover:text-indigo-600"
                        >
                            Simpan
                        </button>
                        <button
                            @click.prevent="closeModalUpdate"
                            class="px-4 py-2 rounded bg-red-500 text-white text-xs font-semibold border border-red-500 hover:bg-transparent hover:text-red-500"
                        >
                        Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
      </template>
    </Modal>
    <!-- end modal update -->

    <!-- modal delete -->
    <Modal ref="modalDelete">
      <template v-slot:modal-body>
        <div class="w-full bg-gray-900 text-[#EFECFD] relative overflow-hidden">
            <LoadingBar v-if="loadingSave" />
            <div class="w-full">
                <div class="bg-gray-900 font-semibold text-xl box-border w-full p-4">Delete Data</div>
                <div class="w-full bg-transparent p-4">
                    <div class="w-full flex space-x-5">
                        <div
                            class="flex-none w-20 h-20 rounded bg-red-700 text-white flex items-center justify-center"
                        >
                            <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-16 w-16"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                            >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            />
                            </svg>
                        </div>

                        <div class="flex-1">
                            <div class="mb-3 text-base font-semibold">
                            Apakah Anda yakin ingin menghapus data rekam medis ?
                            </div>
                            <div class="mb-3 text-sm">
                                Data yang dihapus tidak bisa akan hilang secara permanen, apa anda
                                ingin melanjutkan ?
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="loadingSave == false" class="flex items-center justify-between py-4 bg-gray-900">
                    <div class="flex justify-end items-center space-x-3 box-border px-4 py-2">
                        <button
                            @click.prevent="deleteData"
                            class="px-4 py-2 rounded bg-indigo-600 text-white text-xs font-semibold border border-indigo-600 hover:bg-transparent hover:text-indigo-600"
                        >
                            Ya, Hapus
                        </button>
                        <button
                            @click.prevent="closeModalDelete"
                            class="px-4 py-2 rounded bg-red-500 text-white text-xs font-semibold border border-red-500 hover:bg-transparent hover:text-red-500"
                        >
                        Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
      </template>
    </Modal>
    <!-- end modal delete -->
</template>