<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';

defineProps({
    terms: String,
});
</script>

<template>
    <Head title="Términos y Condiciones" />

    <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="pt-4 bg-gray-100 dark:bg-gray-900">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <AuthenticationCardLogo />
                </div>

                <div class="w-full sm:max-w-3xl mt-6 p-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                    <div class="bg-red-600 text-white p-4 rounded-t-lg flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-9 4a1 1 0 112 0v1a1 1 0 11-2 0v-1zm1-9a1 1 0 00-.894.553l-2 4A1 1 0 108.447 10h3.106l-1.053 2.105a1 1 0 101.788.894l2-4A1 1 0 0012 8H8.894L9.447 6.447A1 1 0 0010 6z" clip-rule="evenodd" />
                            </svg>
                            <h1 class="text-lg font-bold">TÉRMINOS Y CONDICIONES</h1>
                        </div>
                        <button @click="closeModal" class="text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6">
                        <h2 class="text-lg font-bold mb-4">Al denunciar, ten en cuenta lo siguiente:</h2>
                        <ul class="list-disc list-inside mb-6">
                            <li>Si no desea identificarse, puede presentar su denuncia de manera anónima...</li>
                            <li>La identidad del denunciante y el contenido de la denuncia...</li>
                            <li>El Servicio de Gestión de Denuncias es un servicio relacionado...</li>
                        </ul>

                        <h2 class="text-lg font-bold mb-4">Requisitos que debe cumplir la denuncia:</h2>
                        <ul class="list-disc list-inside">
                            <li>Describir los presuntos hechos irregulares de manera precisa y clara...</li>
                            <li>Los presuntos hechos irregulares que ocurran en las entidades...</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
function closeModal() {
    // Implementa lógica para cerrar el modal
    console.log("Cerrar modal");
}
</script>
