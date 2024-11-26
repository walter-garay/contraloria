<template>
    <Table
        :columns="columnas"
        :dataSource="denuncias"
        rowKey="id"
        :pagination="{ pageSize: 10 }"
        :scroll="{ x: 800 }"
    >
        <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'estado'">
                <Tag :color="obtenerColorEstado(record.estado)">
                    {{ record.estado }}
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

// Props: Recibe la lista de denuncias desde el back-end
const props = defineProps({
    denuncias: Array,
});

// Emitir eventos para editar y actualizar la tabla
const emitir = defineEmits(["editar", "actualizar-tabla"]);

// Definir las columnas de la tabla
const columnas = [
    { title: "ID", dataIndex: "id", key: "id", width: 50 },
    { title: "Entidad", dataIndex: "entidad", key: "entidad" },
    { title: "Lugar", dataIndex: "lugar", key: "lugar" },
    { title: "Prioridad", dataIndex: "prioridad", key: "prioridad", sorter: (a, b) => a.prioridad - b.prioridad },
    {
        title: "Estado",
        dataIndex: "estado",
        key: "estado",
        filters: [
            { text: "En proceso", value: "En proceso" },
            { text: "Admitido", value: "Admitido" },
            { text: "No admitido", value: "No admitido" },
            { text: "Derivado a OCI", value: "Derivado a OCI" },
        ],
        onFilter: (value, record) => record.estado === value, // Lógica de filtrado
        scopedSlots: { customRender: "estado" },
    },
    { title: "Acciones", key: "acciones", fixed: "right", width: 100 },
];

// Función para obtener el color del tag basado en el estado
function obtenerColorEstado(estado) {
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
}

// Emitir evento para editar una denuncia
function editar(denuncia) {
    emitir("editar", denuncia);
}

// Confirmar la eliminación de una denuncia
const confirmarEliminacion = (denuncia) => {
    Modal.confirm({
        title: "¿Estás seguro de eliminar esta denuncia?",
        content: `Entidad: ${denuncia.entidad}`,
        okText: "Confirmar",
        cancelText: "Cancelar",
        onOk() {
            router.delete(route("denuncias.destroy", denuncia), {
                preserveScroll: true,
                onSuccess: () => {
                    message.success("Denuncia eliminada exitosamente");
                    emitir("actualizar-tabla");
                },
                onError: (error) => {
                    console.error("Error al eliminar la denuncia:", error);
                    message.error("Error al eliminar la denuncia");
                },
            });
        },
    });
};
</script>
