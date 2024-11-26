<template>
    <AppLayout title="Usuarios">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-0"
            >
                Usuarios
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 px-4">
            <div
                class="flex flex-col-reverse justify-end gap-y-4 mb-6 sm:flex-row sm:justify-between sm:items-center gap-x-4"
            >
                <InputSearch
                    v-model:value="valorBuscar"
                    placeholder="Buscar usuario por nombre o email"
                    class="w-full"
                    size="large"
                />

                <Button
                    type="primary"
                    @click="abrirModalCrear"
                    size="large"
                    class="font-medium"
                    >Agregar usuario</Button
                >
            </div>

            <!-- Tabla de usuarios -->
            <TablaUsuarios
                :usuarios="usuariosFiltrados"
                @editar="abrirModalEditar"
                @actualizar-tabla="actualizarTabla"
            />

            <!-- Modal para agregar usuario -->
            <ModalAgregar
                v-model:visible="mostrarModalCrear"
                @actualizar-tabla="actualizarTabla"
            />

            <!-- Modal para editar usuario -->
            <ModalEditar
                v-if="usuarioSeleccionado"
                v-model:visible="mostrarModalEditar"
                :usuario="usuarioSeleccionado"
                @actualizar-tabla="actualizarTabla"
            />
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Button, InputSearch } from "ant-design-vue";
import TablaUsuarios from "./Partes/TablaUsuarios.vue";
import ModalAgregar from "./Partes/ModalAgregar.vue";
import ModalEditar from "./Partes/ModalEditar.vue";

const { props } = usePage();
const usuarios = ref(props.usuarios || []); // Cambiar a usuarios
const mostrarModalCrear = ref(false);
const mostrarModalEditar = ref(false);
const usuarioSeleccionado = ref(null);
const valorBuscar = ref("");

// Filtrar usuarios por nombre o email
const usuariosFiltrados = computed(() =>
    !valorBuscar.value
        ? usuarios.value
        : usuarios.value.filter(
            (usuario) =>
                usuario.name
                    .toLowerCase()
                    .includes(valorBuscar.value.toLowerCase()) ||
                usuario.email
                    .toLowerCase()
                    .includes(valorBuscar.value.toLowerCase())
        )
);

// Actualizar la tabla (recargar datos)
const actualizarTabla = () => {
    router.visit(route("usuarios.index"), { preserveScroll: true });
};

// Abrir modal para agregar usuario
const abrirModalCrear = () => {
    mostrarModalCrear.value = true;
};

// Abrir modal para editar usuario
const abrirModalEditar = (usuario) => {
    mostrarModalEditar.value = true;
    usuarioSeleccionado.value = { ...usuario };
};
</script>
