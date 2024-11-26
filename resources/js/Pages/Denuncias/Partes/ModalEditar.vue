<template>
    <Modal
        title="Editar Denuncia"
        :open="visible"
        @cancel="cerrarModal"
        centered
        :footer="null"
    >
        <Form layout="vertical" @finish="enviarFormulario" :model="denuncia">
            <!-- Entidad -->
            <FormItem
                label="Entidad"
                name="entidad"
                :rules="[{ required: true, message: 'Por favor ingrese la entidad' }]"
            >
                <Input
                    v-model:value="denuncia.entidad"
                    placeholder="Ingrese el nombre de la entidad"
                />
            </FormItem>

            <!-- Lugar -->
            <FormItem
                label="Lugar"
                name="lugar"
                :rules="[{ required: true, message: 'Por favor ingrese el lugar' }]"
            >
                <Input v-model:value="denuncia.lugar" placeholder="Ingrese el lugar" />
            </FormItem>

            <!-- Descripción -->
            <FormItem
                label="Descripción"
                name="descripcion"
                :rules="[{ required: true, message: 'Por favor ingrese la descripción' }]"
            >
                <Input.TextArea
                    v-model:value="denuncia.descripcion"
                    placeholder="Ingrese la descripción de la denuncia"
                    rows="4"
                />
            </FormItem>

            <!-- Fecha Probable -->
            <FormItem
                label="Fecha Probable"
                name="fecha_probable"
                :rules="[{ required: true, message: 'Por favor seleccione la fecha probable' }]"
            >
                <Input
                    v-model:value="denuncia.fecha_probable"
                    type="date"
                />
            </FormItem>

            <!-- Prioridad -->
            <FormItem label="Prioridad" name="prioridad">
                <Input
                    v-model:value="denuncia.prioridad"
                    type="number"
                    placeholder="Ingrese la prioridad (opcional)"
                />
            </FormItem>

            <!-- Estado -->
            <FormItem label="Estado" name="estado">
                <Input
                    v-model:value="denuncia.estado"
                    placeholder="Ingrese el estado de la denuncia"
                />
            </FormItem>

            <!-- Botones de Acción -->
            <FormItem class="flex justify-end mb-0">
                <Button style="margin-right: 8px" @click="cerrarModal">Cancelar</Button>
                <Button type="primary" htmlType="submit" :loading="cargando">Guardar</Button>
            </FormItem>
        </Form>
    </Modal>
</template>

<script setup>
import { ref, watch, defineProps, defineEmits } from "vue";
import { Modal, Form, FormItem, Input, Button, message } from "ant-design-vue";
import axios from "axios";

const props = defineProps({
    visible: Boolean,
    denuncia: {
        type: Object,
        default: () => ({
            id: null,
            entidad: "",
            lugar: "",
            descripcion: "",
            fecha_probable: "",
            prioridad: null,
            estado: "En proceso",
        }),
    },
});

const emitir = defineEmits(["update:visible", "actualizar-tabla"]);

const denuncia = ref({ ...props.denuncia });
const cargando = ref(false);

// Cierra el modal y emite el evento para cerrar en el componente padre
const cerrarModal = () => {
    emitir("update:visible", false);
};

// Envía el formulario de edición de la denuncia
const enviarFormulario = async () => {
    cargando.value = true;
    try {
        // Enviar la solicitud para actualizar la denuncia
        const response = await axios.put(
            route("denuncias.update", denuncia.value.id),
            denuncia.value
        );
        message.success("Denuncia actualizada exitosamente");
        cerrarModal();
        emitir("actualizar-tabla", response.data["denuncia"]);
    } catch (error) {
        message.error("Error al actualizar la denuncia");
        console.error("Error al guardar la denuncia:", error);
    } finally {
        cargando.value = false;
    }
};

// Verificar si el modal se abre y cargar los valores de la denuncia
watch(
    () => props.visible,
    (val) => {
        if (val) {
            denuncia.value = { ...props.denuncia };
        }
    }
);
</script>
