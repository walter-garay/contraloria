<template>
    <Table
        :columns="columnas"
        :dataSource="usuarios"
        rowKey="id"
        :pagination="false"
        :scroll="{ x: 800 }"
    >
        <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'acciones'">
                <FormOutlined @click="editar(record)" class="text-blue-600" />
                <DeleteOutlined
                    @click="confirmarEliminacion(record)"
                    class="text-red-600 ml-2"
                />
            </template>
        </template>
    </Table>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";
import { Table, Modal, message } from "ant-design-vue";
import { router } from '@inertiajs/vue3';
import { FormOutlined, DeleteOutlined } from "@ant-design/icons-vue";

const props = defineProps({
    usuarios: Array, // Lista de usuarios desde el backend
});

const emitir = defineEmits(["editar", "actualizar-tabla"]);

// Definir las columnas de la tabla de usuarios
const columnas = [
    { title: "ID", dataIndex: "id", key: "id", width: 50 },
    { title: "Nombre", dataIndex: "name", key: "name", sorter: (a, b) => a.name.localeCompare(b.name) },
    { title: "Email", dataIndex: "email", key: "email" },
    {
        title: "Foto de Perfil",
        dataIndex: "profile_photo_path",
        key: "profile_photo_path",
        scopedSlots: { customRender: "foto" },
    },
    {
        title: "Última Actualización",
        dataIndex: "updated_at",
        key: "updated_at",
        width: 180,
        sorter: (a, b) => new Date(a.updated_at) - new Date(b.updated_at),
    },
    { title: "Acciones", key: "acciones", fixed: "right", width: 100 },
];

// Emitir eventos para editar y eliminar usuarios
function editar(usuario) {
    emitir("editar", usuario);
}

const confirmarEliminacion = (usuario) => {
    Modal.confirm({
        title: "¿Estás seguro de eliminar este usuario?",
        content: `Usuario: ${usuario.name}`,
        okText: "Confirmar",
        cancelText: "Cancelar",
        onOk() {
            router.delete(route("usuarios.destroy", usuario), {
                preserveScroll: true,
                onSuccess: () => {
                    message.success("Usuario eliminado exitosamente");
                    emitir("actualizar-tabla");
                },
                onError: (error) => {
                    console.error("Error al eliminar el usuario:", error);
                    message.error("Error al eliminar el usuario");
                },
            });
        },
    });
};
</script>
