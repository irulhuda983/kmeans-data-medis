<script setup>
import { ref, reactive, onMounted } from 'vue'
import ChartScatter from '@/components/chart/Scatter.vue';

const dataCluster = ref([])

const fetchCluster = async () => {
    try{
        const { data } = await axios.get('clustering/get-by-nama');

        dataCluster.value = data.data_cluster
    }catch(e){
        console.log('error')
    }
}

const getDataChart = (data) => {
    let c1 = [];
    let c2 = [];
    let c3 = [];

    data.forEach(el => {
        if(el.cluster == 1) {
            // toFixed(2)
            c1.push([el.c1.toFixed(2), el.c2.toFixed(2), el.c3.toFixed(2)])
        }else if(el.cluster == 2){
            c2.push([el.c2.toFixed(2), el.c3.toFixed(2), el.c1.toFixed(2)])
        }else if(el.cluster == 3){
            c3.push([el.c3.toFixed(2), el.c1.toFixed(2), el.c2.toFixed(2)])
        }
    });

    const hasil = [
        {
            name: 'Claster 1',
            data: c1,
        },
        {
            name: 'Claster 2',
            data: c2,
        },
        {
            name: 'Claster 3',
            data: c3,
        },
    ];

    console.log(hasil)
    console.log(data)

    return hasil
}

onMounted(() => {
    fetchCluster()
})

</script>


<template>
    <div class="box-border w-full pb-10">
        <div class="w-full box-border my-8 flex items-center justify-between">
            <div class="w-full text-lg font-semibold">Grafik Tiap Iterasi</div>
        </div>

        <div class="w-full box-border grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div v-for="(item, i) in dataCluster" :key="i" class="w-full box-border bg-[#252237] p-10 rounded-3xl overflow-hidden relative h-72 lg:mr-5 mb-6 lg:h-auto mb-10 lg:mb-0">
                <!-- {{ getDataChart(item.data_iterasi) }} -->
                <div class="absolute bg-[#2F2B43] rounded-full px-4 py-3 text-xs top-2 left-2 font-semibold capitalize">{{ item.nama }}</div>
                <ChartScatter :height="400" :series="item.grafik" />
            </div>
        </div>
    </div>
</template>