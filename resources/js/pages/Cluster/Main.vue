<script setup>
import { onMounted, ref } from 'vue';
import TableCluster from '@/components/TableCluster.vue'

const dataCluster = ref([])
const dataAwal = ref([])
const lastCluster = ref([])
const lastCentroid = ref([])
const kesimpulanCLuster = ref([])

const pageView = ref('data_awal')

const fetchData = async () => {
    try{
        const { data } = await axios.get('clustering/get-by-nama');

        dataCluster.value = data.data_cluster
        dataAwal.value = data.data_awal
        lastCluster.value = data.last_cluster
        lastCentroid.value = data.last_centroid
        kesimpulanCLuster.value = data.jumlah_cluster
    }catch(e) {
        console.log(e)
    }
}

onMounted(() => {
    fetchData()
})
</script>


<template>
    <div class="box-border w-full">
        <div class="w-full box-border my-8 flex">
            <div class="flex items-center justify-center">
                <button
                    @click.prevent="pageView = 'data_awal'"
                    class="flex items-center justify-center border border-[#7939FC] border-r-transparent p-2 box-border text-sm font-semibold text-gray-400 hover:text-white hover:bg-[#7939FC]"
                    :class="pageView == 'data_awal' ? 'bg-[#7939FC] text-white' : 'bg-[#342855]'"
                >
                    <div>Data Awal</div>
                </button>
                <button
                    @click.prevent="pageView = 'data_iterasi'"
                    class="flex items-center justify-center border border-[#7939FC] border-r-transparent p-2 box-border text-sm font-semibold text-gray-400 hover:text-white hover:bg-[#7939FC]"
                    :class="pageView == 'data_iterasi' ? 'bg-[#7939FC] text-white' : 'bg-[#342855]'"
                >
                    <div>Data Iterasi</div>
                </button>

                <button
                    @click.prevent="pageView = 'data_hasil'"
                    class="flex items-center justify-center border border-[#7939FC] border-r-transparent p-2 box-border text-sm font-semibold text-gray-400 hover:text-white hover:bg-[#7939FC]"
                    :class="pageView == 'data_hasil' ? 'bg-[#7939FC] text-white' : 'bg-[#342855]'"
                >
                    <div>Data Hasil</div>
                </button>

                <button
                    @click.prevent="pageView = 'kesimpulan'"
                    class="flex items-center justify-center border border-[#7939FC] p-2 box-border text-sm font-semibold text-gray-400 hover:text-white hover:bg-[#7939FC]"
                    :class="pageView == 'kesimpulan' ? 'bg-[#7939FC] text-white' : 'bg-[#342855]'"
                >
                    <div>Kesimpulan</div>
                </button>
            </div>
        </div>
        <div class="w-full mb-5">
            <table v-if="pageView == 'data_awal'" class="w-full text-sm text-left bg-[#2F2B43]">
                <thead class="text-xs text-gray-400 bg-[#3B3955] uppercase border-b border-[#3A3650]">
                    <tr>
                        <th scope="col" class="px-4 py-3 w-[10px]">No</th>
                        <th scope="col" class="px-4 py-3">Nama</th>
                        <th scope="col" class="px-4 py-3">Jenis Umur</th>
                        <th scope="col" class="px-4 py-3 w-[20]">Jenis Penyakit</th>
                        <th scope="col" class="px-4 py-3">Jenis Pelayanan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, i) in dataAwal" :key="i" class="text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                        <td class="px-4 py-3 whitespace-nowrap">{{ i + 1 }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ item.nama }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ item.umur }} th ({{ item.jenis_umur }})</td>
                        <td class="px-4 py-3 whitespace-nowrap capitalize">{{ item.nama_penyakit }} ({{ item.jenis_penyakit }})</td>
                        <td class="px-4 py-3 whitespace-nowrap capitalize">{{ item.nama_pelayanan.replace('_', ' ') }} ({{ item.jenis_pelayanan }})</td>
                    </tr>
                </tbody>
            </table>

            <div v-if="pageView == 'data_iterasi'">
                <TableCluster v-for="(cls, i) in dataCluster" :key="i" :data="cls" />
            </div>

            <div v-if="pageView == 'data_hasil'">
                <table class="w-full text-sm text-left bg-[#2F2B43] border border-[#3A3650] mb-3">
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
                        <tr v-for="(item, i) in lastCluster" :key="i" class="text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
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

                <div class="mb-3">Centroid</div>
                <table class="w-full text-sm text-left bg-[#2F2B43]">
                    <thead class="text-xs text-gray-400 bg-[#3B3955] uppercase border-b border-[#3A3650]">
                        <tr>
                            <th scope="col" class="px-4 py-3">Nama</th>
                            <th scope="col" class="px-4 py-3">C1</th>
                            <th scope="col" class="px-4 py-3">C2</th>
                            <th scope="col" class="px-4 py-3">C3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                            <td class="px-4 py-3 whitespace-nowrap">Jenis Umur</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ lastCentroid.umur.k1.toFixed(2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ lastCentroid.umur.k2.toFixed(2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ lastCentroid.umur.k3.toFixed(2) }}</td>
                        </tr>

                        <tr class="text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                            <td class="px-4 py-3 whitespace-nowrap">Jenis Penyakit</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ lastCentroid.penyakit.k1.toFixed(2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ lastCentroid.penyakit.k2.toFixed(2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ lastCentroid.penyakit.k3.toFixed(2) }}</td>
                        </tr>

                        <tr class="text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                            <td class="px-4 py-3 whitespace-nowrap">Jenis Pelayanan</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ lastCentroid.pelayanan.k1.toFixed(2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ lastCentroid.pelayanan.k2.toFixed(2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ lastCentroid.pelayanan.k3.toFixed(2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="pageView == 'kesimpulan'">
                <table class="w-full text-sm text-left bg-[#2F2B43] border border-[#3A3650]">
                    <thead class="text-xs text-gray-400 bg-[#3B3955] uppercase border-b border-[#3A3650]">
                        <tr>
                            <th scope="col" class="px-4 py-3">#</th>
                            <th scope="col" class="px-4 py-3">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                            <td class="px-4 py-3 whitespace-nowrap">Claster 1</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ kesimpulanCLuster.c1 }}</td>
                        </tr>
                        <tr class="text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                            <td class="px-4 py-3 whitespace-nowrap">Claster 2</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ kesimpulanCLuster.c2 }}</td>
                        </tr>
                        <tr class="text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                            <td class="px-4 py-3 whitespace-nowrap">Claster 3</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ kesimpulanCLuster.c3 }}</td>
                        </tr>
                        <tr class="text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]">
                            <td class="px-4 py-3 whitespace-nowrap">Jumlah Data</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ kesimpulanCLuster.total_data }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>