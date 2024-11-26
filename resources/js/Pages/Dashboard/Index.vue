<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-0"
            >
                Dashboard
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 px-4">
            <!-- Contadores -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <Card hoverable class="bg-blue-100">
                    <div class="flex items-center">
                        <UserOutlined class="text-4xl text-blue-500 mr-4" />
                        <div>
                            <p class="text-lg font-semibold text-gray-700">Usuarios Totales</p>
                            <p class="text-2xl font-bold text-gray-900">{{ totalUsuarios }}</p>
                        </div>
                    </div>
                </Card>

                <Card hoverable class="bg-green-100">
                    <div class="flex items-center">
                        <CheckCircleOutlined class="text-4xl text-green-500 mr-4" />
                        <div>
                            <p class="text-lg font-semibold text-gray-700">Usuarios Activos</p>
                            <p class="text-2xl font-bold text-gray-900">{{ usuariosActivos }}</p>
                        </div>
                    </div>
                </Card>

                <Card hoverable class="bg-red-100">
                    <div class="flex items-center">
                        <CloseCircleOutlined class="text-4xl text-red-500 mr-4" />
                        <div>
                            <p class="text-lg font-semibold text-gray-700">Usuarios Inactivos</p>
                            <p class="text-2xl font-bold text-gray-900">{{ usuariosInactivos }}</p>
                        </div>
                    </div>
                </Card>

                <Card hoverable class="bg-yellow-100">
                    <div class="flex items-center">
                        <FileTextOutlined class="text-4xl text-yellow-500 mr-4" />
                        <div>
                            <p class="text-lg font-semibold text-gray-700">Denuncias Totales</p>
                            <p class="text-2xl font-bold text-gray-900">{{ totalDenuncias }}</p>
                        </div>
                    </div>
                </Card>
            </div>

            <!-- Denuncias por Estado -->
            <div class="mt-10">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Denuncias por Estado</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <Card
                        v-for="estado in denunciasPorEstado"
                        :key="estado.estado"
                        hoverable
                        class="bg-white dark:bg-gray-800"
                    >
                        <div class="flex flex-col items-center">
                            <Tag :color="colorEstado(estado.estado)" class="mb-2">
                                {{ estado.estado }}
                            </Tag>
                            <p class="text-2xl font-bold text-gray-900">{{ estado.total }}</p>
                        </div>
                    </Card>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ChatBot from "@/Components/ChatBot.vue";

import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { Card, Tag } from "ant-design-vue";
import {
    UserOutlined,
    CheckCircleOutlined,
    CloseCircleOutlined,
    FileTextOutlined,
} from "@ant-design/icons-vue";

// Datos desde el servidor
const { props } = usePage();
const totalUsuarios = ref(props.totalUsuarios);
const usuariosActivos = ref(props.usuariosActivos);
const usuariosInactivos = ref(props.usuariosInactivos);
const totalDenuncias = ref(props.totalDenuncias);
const denunciasPorEstado = ref(props.denunciasPorEstado);

// Obtener colores para los estados
const colorEstado = (estado) => {
    switch (estado) {
        case "En proceso":
            return "blue";
        case "Admitido":
            return "green";
        case "No admitido":
            return "red";
        case "Derivado a OCI":
            return "orange";
        default:
            return "gray";
    }
};
</script>

<style>
/* Estilo adicional opcional */
</style>
