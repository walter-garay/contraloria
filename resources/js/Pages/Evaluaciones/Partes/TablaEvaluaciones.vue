<template>
    <Table
        :columns="columnas"
        :dataSource="evaluaciones"
        rowKey="id"
        :pagination="{ pageSize: 10 }"
        :scroll="{ x: 800 }"
    >
        <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'resultado'">
                <Tag :color="obtenerColorResultado(record.resultado)">
                    {{ record.resultado }}
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

// Props: Recibe la lista de evaluaciones desde el back-end
const props = defineProps({
    evaluaciones: Array,
});

// Emitir eventos para editar y actualizar la tabla
const emitir = defineEmits(["editar", "actualizar-tabla"]);

// Definir las columnas de la tabla
const columnas = [
    { title: "ID", dataIndex: "id", key: "id", width: 50 },
    { title: "Denuncia", dataIndex: "denuncia_id", key: "denuncia_id", width: 100 },
    { title: "Evaluador", dataIndex: "user_id", key: "user_id", width: 100},
    {
        title: "Resultado",
        dataIndex: "resultado",
        key: "resultado",
        width: 200,
        filters: [
            { text: "Desestimado", value: "Desestimado" },
            { text: "Pasa a Control", value: "Pasa a Control" },
        ],
        onFilter: (value, record) => record.resultado === value, // Lógica de filtrado
        scopedSlots: { customRender: "resultado" },
    },
    { title: "Observaciones", dataIndex: "observaciones", key: "observaciones" },
    { title: "Fecha de Evaluación", dataIndex: "fecha_evaluacion", key: "fecha_evaluacion", width: 120 },
    { title: "Acciones", key: "acciones", fixed: "right", width: 100 },
];

// Función para obtener el color del tag basado en el resultado
function obtenerColorResultado(resultado) {
    switch (resultado) {
        case "Desestimado":
            return "red";
        case "Pasa a Control":
            return "green";
        default:
            return "gray";
    }
}

// Emitir evento para editar una evaluación
function editar(evaluacion) {
    emitir("editar", evaluacion);
}

// Confirmar la eliminación de una evaluación
const confirmarEliminacion = (evaluacion) => {
    Modal.confirm({
        title: "¿Estás seguro de eliminar esta evaluación?",
        content: `Evaluación ID: ${evaluacion.id}`,
        okText: "Confirmar",
        cancelText: "Cancelar",
        onOk() {
            router.delete(route("evaluaciones.destroy", evaluacion), {
                preserveScroll: true,
                onSuccess: () => {
                    message.success("Evaluación eliminada exitosamente");
                    emitir("actualizar-tabla");
                },
                onError: (error) => {
                    console.error("Error al eliminar la evaluación:", error);
                    message.error("Error al eliminar la evaluación");
                },
            });
        },
    });
};
</script>
