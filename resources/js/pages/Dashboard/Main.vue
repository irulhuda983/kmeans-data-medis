<script setup>
import { ref, reactive, onMounted } from 'vue'
import ChartScatter from '@/components/chart/Scatter.vue'

const series = ref([3, 3, 3])
const seriesCluster = ref([])
const dataJumlah = ref({})

const options = reactive({
    chart: {
      type: 'donut'
    },
    plotOptions: {
      pie: {
        donut: {
            size: '1%',
            background: 'transparent',
        }
      }
    },
    colors: ['#EE6F85', '#F38F81', '#9A93BA'],
    labels: ['Apple', 'Mango', 'Orange'],
    dataLabels: {
        enabled: true,
        style: {
            fontSize: "10px",
            fontFamily: "Helvetica, Arial, sans-serif",
            fontWeight: "200",
            colors: ["#e5e5e5"],
        },
    },
    legend: {
        show: true,
        position: 'bottom',
        fontSize: '14px',
        fontWeight: 400,
        labels: {
            colors: 'white',
            useSeriesColors: false
        },
    }
})

const fetchCluster = async () => {
    try{
        const { data } = await axios.get('clustering/get-by-nama');

        seriesCluster.value = data.data_chart
        dataJumlah.value = data.jumlah_cluster
        series.value = [data.jumlah_cluster.c1, data.jumlah_cluster.c2, data.jumlah_cluster.c3]
    }catch(e){
        console.log('error')
    }
}

onMounted(() => {
    fetchCluster()
})

</script>

<template>
    <div class="box-border w-full py-10">
        <!-- <div class="w-full box-border mb-8 flex justify-end">
            <div class="w-full lg:w-auto flex items-center justify-center flex-col lg:flex-row">
                <label for="periode" class="hidden lg:block lg:mr-5 w-full lg:w-auto">Periode </label>
                <input id="periode" type="text" placeholder="Select Range" class="text-sm rounded-lg px-4 py-2 bg-[#3B3955] outline-none w-full lg:w-96">
            </div>
        </div> -->
        <div class="w-full mb-5">
            <!-- <div class="mb-8 w-full text-gray-200">
                <div class="text-xl lg:text-2xl font-bold">Total Data</div>
            </div> -->
            <div class="w-full box-border grid grid-cols-1 lg:grid-cols-4 gap-4">
                <div class="w-full h-32 bg-[#3B3955] rounded-[20px] box-border p-4 flex items-center">
                    <div class="w-20 h-20 rounded-[20px] flex-none bg-[#8b5cf6]/20 box-border flex items-center justify-center mr-8">
                        <div class="text-[#a855f7]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10">
                                <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 000 1.5H3v10.5a3 3 0 003 3h1.21l-1.172 3.513a.75.75 0 001.424.474l.329-.987h8.418l.33.987a.75.75 0 001.422-.474l-1.17-3.513H18a3 3 0 003-3V3.75h.75a.75.75 0 000-1.5H2.25zm6.54 15h6.42l.5 1.5H8.29l.5-1.5zm8.085-8.995a.75.75 0 10-.75-1.299 12.81 12.81 0 00-3.558 3.05L11.03 8.47a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l2.47-2.47 1.617 1.618a.75.75 0 001.146-.102 11.312 11.312 0 013.612-3.321z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="w-full flex-1">
                        <div class="mb-3 text-sm font-semibold text-gray-400">Jumlah Cluster 1</div>
                        <div class="font-semibold text-3xl">{{ dataJumlah.c1 }} <span class="text-sm text-gray-400 font-normal">Data</span></div>
                    </div>
                </div>

                <div class="w-full h-32 bg-[#3B3955] rounded-[20px] box-border p-4 flex items-center">
                    <div class="w-20 h-20 rounded-[20px] flex-none bg-[#8b5cf6]/20 box-border flex items-center justify-center mr-8">
                        <div class="text-[#a855f7]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10">
                                <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 000 1.5H3v10.5a3 3 0 003 3h1.21l-1.172 3.513a.75.75 0 001.424.474l.329-.987h8.418l.33.987a.75.75 0 001.422-.474l-1.17-3.513H18a3 3 0 003-3V3.75h.75a.75.75 0 000-1.5H2.25zm6.54 15h6.42l.5 1.5H8.29l.5-1.5zm8.085-8.995a.75.75 0 10-.75-1.299 12.81 12.81 0 00-3.558 3.05L11.03 8.47a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l2.47-2.47 1.617 1.618a.75.75 0 001.146-.102 11.312 11.312 0 013.612-3.321z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="w-full flex-1">
                        <div class="mb-3 text-sm font-semibold text-gray-400">Jumlah Cluster 2</div>
                        <div class="font-semibold text-3xl">{{ dataJumlah.c2 }} <span class="text-sm text-gray-400 font-normal">Data</span></div>
                    </div>
                </div>

                <div class="w-full h-32 bg-[#3B3955] rounded-[20px] box-border p-4 flex items-center">
                    <div class="w-20 h-20 rounded-[20px] flex-none bg-[#8b5cf6]/20 box-border flex items-center justify-center mr-8">
                        <div class="text-[#a855f7]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10">
                                <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 000 1.5H3v10.5a3 3 0 003 3h1.21l-1.172 3.513a.75.75 0 001.424.474l.329-.987h8.418l.33.987a.75.75 0 001.422-.474l-1.17-3.513H18a3 3 0 003-3V3.75h.75a.75.75 0 000-1.5H2.25zm6.54 15h6.42l.5 1.5H8.29l.5-1.5zm8.085-8.995a.75.75 0 10-.75-1.299 12.81 12.81 0 00-3.558 3.05L11.03 8.47a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l2.47-2.47 1.617 1.618a.75.75 0 001.146-.102 11.312 11.312 0 013.612-3.321z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="w-full flex-1">
                        <div class="mb-3 text-sm font-semibold text-gray-400">Jumlah Cluster 3</div>
                        <div class="font-semibold text-3xl">{{ dataJumlah.c3 }} <span class="text-sm text-gray-400 font-normal">Data</span></div>
                    </div>
                </div>

                <div class="w-full h-32 bg-[#3B3955] rounded-[20px] box-border p-4 flex items-center">
                    <div class="w-20 h-20 rounded-[20px] flex-none bg-[#8b5cf6]/20 box-border flex items-center justify-center mr-8">
                        <div class="text-[#a855f7]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10">
                                <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 000 1.5H3v10.5a3 3 0 003 3h1.21l-1.172 3.513a.75.75 0 001.424.474l.329-.987h8.418l.33.987a.75.75 0 001.422-.474l-1.17-3.513H18a3 3 0 003-3V3.75h.75a.75.75 0 000-1.5H2.25zm6.54 15h6.42l.5 1.5H8.29l.5-1.5zm8.085-8.995a.75.75 0 10-.75-1.299 12.81 12.81 0 00-3.558 3.05L11.03 8.47a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l2.47-2.47 1.617 1.618a.75.75 0 001.146-.102 11.312 11.312 0 013.612-3.321z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="w-full flex-1">
                        <div class="mb-3 text-sm font-semibold text-gray-400">Jumlah Data Medis</div>
                        <div class="font-semibold text-3xl">{{ dataJumlah.total_data }} <span class="text-sm text-gray-400 font-normal">Data</span></div>
                    </div>
                </div>

            </div>
        </div>
        <div class="w-full flex flex-col lg:flex-row">
            <div class="w-full lg:w-1/2 box-border bg-[#252237] p-10 rounded-3xl overflow-hidden relative h-72 lg:mr-5 mb-6 lg:h-auto mb-10 lg:mb-0">
                <div class="absolute bg-[#2F2B43] rounded-full px-4 py-3 text-xs top-2 left-2 font-semibold">Sebaran Cluster</div>
                <ChartScatter :height="400" :series="seriesCluster" />
            </div>

            <div class="w-full lg:w-1/2 box-border bg-[#252237] p-10 rounded-3xl overflow-hidden relative h-72 lg:h-auto mb-10 lg:mb-0">
                <div class="absolute bg-[#2F2B43] rounded-full px-4 py-3 text-xs top-2 left-2 font-semibold">Total Cluster</div>
                <!-- 252237 -->
                <apexchart type="donut" :options="options" :series="series"></apexchart>
            </div>
        </div>
    </div>
</template>