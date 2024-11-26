<template>
    <Table
        :columns="columnas"
        :dataSource="usuarios"
        rowKey="id"
        :pagination="{ pageSize: 10 }"
        :scroll="{ x: 800 }"
    >
        <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'rol'">
                <Tag :color="obtenerColorRol(record.rol)">
                    {{ record.rol }}
                </Tag>
            </template>
            <template v-else-if="column.key === 'acciones'">
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
import { Table, Modal, Tag, message } from "ant-design-vue";
import { router } from '@inertiajs/vue3';
import { FormOutlined, DeleteOutlined } from "@ant-design/icons-vue";

// Props: Recibe la lista de usuarios desde el back-end
const props = defineProps({
    usuarios: Array,
});

// Emitir eventos para editar y actualizar la tabla
const emitir = defineEmits(["editar", "actualizar-tabla"]);

// Definir las columnas de la tabla
const columnas = [
    { title: "ID", dataIndex: "id", key: "id", width: 60 },
    { title: "DNI", dataIndex: "dni", key: "dni", render: (dni) => dni || "No registrado" },
    { title: "Nombre", dataIndex: "name", key: "name", sorter: (a, b) => a.name.localeCompare(b.name) },
    { title: "Email", dataIndex: "email", key: "email" },
    {
        title: "Rol",
        dataIndex: "rol",
        key: "rol",
        filters: [
            { text: "Ciudadano", value: "Ciudadano" },
            { text: "Auditor", value: "Auditor" },
            { text: "Administrador", value: "Administrador" },
        ],
        onFilter: (value, record) => record.rol === value, // Lógica de filtrado
        scopedSlots: { customRender: "rol" },
    },
    { title: "Acciones", key: "acciones", fixed: "right", width: 100 },
];



// Función para obtener el color del tag basado en el rol
function obtenerColorRol(rol) {
    switch (rol) {
        case "Administrador":
            return "red";
        case "Auditor":
            return "blue";
        case "Ciudadano":
            return "green";
        default:
            return "gray";
    }
}

// Emitir evento para editar un usuario
function editar(usuario) {
    emitir("editar", usuario);
}

// Confirmar la eliminación de un usuario
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
