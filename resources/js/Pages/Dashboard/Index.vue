<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total de Usuarios -->
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Usuarios Totales</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ totalUsuarios }}</p>
                </div>

                <!-- Usuarios Activos -->
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Usuarios Activos</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ usuariosActivos }}</p>
                </div>

                <!-- Usuarios Inactivos -->
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Usuarios Inactivos</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ usuariosInactivos }}</p>
                </div>

                <!-- Denuncias Totales -->
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Denuncias Totales</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ totalDenuncias }}</p>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Denuncias por Estado</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="estado in denunciasPorEstado" :key="estado.estado" class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
                        <h4 class="text-md font-semibold text-gray-700 dark:text-gray-200">{{ estado.estado }}</h4>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ estado.total }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Denuncias por Prioridad</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="prioridad in denunciasPorPrioridad" :key="prioridad.prioridad" class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
                        <h4 class="text-md font-semibold text-gray-700 dark:text-gray-200">Prioridad {{ prioridad.prioridad || 'Sin Prioridad' }}</h4>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ prioridad.total }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";

const { props } = usePage();
const totalUsuarios = ref(props.totalUsuarios);
const usuariosActivos = ref(props.usuariosActivos);
const usuariosInactivos = ref(props.usuariosInactivos);
const totalDenuncias = ref(props.totalDenuncias);
const denunciasPorEstado = ref(props.denunciasPorEstado);
const denunciasPorPrioridad = ref(props.denunciasPorPrioridad);
</script>
