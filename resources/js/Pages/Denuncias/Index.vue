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

                <div class="flex gap-4">
                    <Button
                        type="default"
                        @click="exportarCSV"
                        size="large"
                        class="font-medium"
                    >
                        Exportar CSV
                    </Button>

                    <Button
                        type="default"
                        @click="importarCSV"
                        size="large"
                        class="font-medium"
                    >
                        Importar CSV
                    </Button>

                    <Button
                        type="primary"
                        @click="abrirModalCrear"
                        size="large"
                        class="font-medium"
                    >
                        Agregar usuario
                    </Button>
                </div>
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
import { Button, InputSearch, Upload, message } from "ant-design-vue";
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

// Función para exportar los datos en CSV
const exportarCSV = async () => {
    try {
        const response = await axios.get(route("usuarios.export"), {
            responseType: "blob",
        });

        // Crear un enlace para descargar el archivo
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", "usuarios.csv");
        document.body.appendChild(link);
        link.click();
        link.remove();

        message.success("CSV exportado correctamente.");
    } catch (error) {
        message.error("Error al exportar el CSV.");
    }
};

// Función para importar datos desde un archivo CSV
const importarCSV = async () => {
    // Crear un elemento de entrada de tipo archivo
    const input = document.createElement("input");
    input.type = "file";
    input.accept = ".csv"; // Acepta solo archivos CSV
    input.click();

    // Escuchar el evento de cambio (cuando el usuario selecciona un archivo)
    input.addEventListener("change", async () => {
        const file = input.files[0];

        if (file) {
            // Validar que el archivo sea menor a un tamaño específico, por ejemplo, 2MB
            const maxFileSize = 2 * 1024 * 1024; // 2MB
            if (file.size > maxFileSize) {
                message.error("El archivo es demasiado grande. Tamaño máximo: 2MB.");
                return;
            }

            const formData = new FormData();
            formData.append("file", file);

            try {
                // Enviar el archivo al servidor mediante Axios
                const response = await axios.post(route("usuarios.import"), formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                });

                if (response.data.success) {
                    // Mensaje de éxito
                    message.success(response.data.message || "CSV importado correctamente.");
                    // Actualizar la tabla si es necesario
                    if (typeof actualizarTabla === "function") {
                        actualizarTabla();
                    }
                } else {
                    // Mostrar mensaje de error si el servidor responde con fallo
                    message.error(response.data.message || "Error al importar el archivo.");
                }
            } catch (error) {
                // Manejo de errores
                const errorMessage = error.response?.data?.message || "Error al importar el CSV.";
                message.error(errorMessage);
                console.error("Error al importar CSV:", error); // Para depuración
            }
        } else {
            message.warning("No se seleccionó ningún archivo.");
        }
    });
};

</script>
