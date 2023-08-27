<script setup>
import { reactive } from 'vue';
import { VuePagination } from 'vue3-tailwind-pagination';

const props = defineProps(['total', 'currentPage', 'perPage']);
const emit = defineEmits(['changePage']);

const classes = reactive({
  wrapper: 'flex text-gray-500 text-center bg-dark mx-auto shadow-sm text-xs',
  element: 'w-6 h-6 border border-[#3A3650] table-cell hover:border-[#7939FC]',
  activeElement: 'w-6 h-6 border border-[#7939FC] table-cell hover:border-[#7939FC]',
  disabledElement: 'w-6 h-6 border border-[#3A3650] table-cell cursor-not-allowed',
  activeButton:
    'bg-blue-500 w-full h-full text-white hover:bg-blue-600 transition duration-100 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50',
  disabledButton:
    'opacity-70 w-full h-full pointer-events-none transition duration-100 ease-in-out',
  button:
    'hover:bg-blue-100 w-full h-full transition duration-100 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50',
});

const changePage = (page) => {
  emit('changePage', page);
};
</script>

<template>
  <VuePagination
    :total="props.total"
    v-model:value="props.currentPage"
    :perPage="parseInt(props.perPage)"
    @set="changePage"
    :classes="classes"
  />
</template>
