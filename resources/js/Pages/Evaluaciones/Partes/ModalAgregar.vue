<template>
    <Modal
        title="Agregar Evaluación"
        :open="visible"
        @cancel="cerrarModal"
        centered
        :footer="null"
    >
        <Form layout="vertical" @finish="enviarFormulario" :model="evaluacion">
            <!-- Denuncia ID -->
            <FormItem label="ID de Denuncia" name="denuncia_id" :rules="[{ required: true, message: 'Por favor ingrese el ID de denuncia' }]">
                <Input v-model:value="evaluacion.denuncia_id" placeholder="Ingrese el ID de denuncia" autofocus />
            </FormItem>

            <!-- Usuario Evaluador -->
            <FormItem label="Evaluador (Usuario ID)" name="user_id" :rules="[{ required: true, message: 'Por favor ingrese el ID del usuario evaluador' }]">
                <Input v-model:value="evaluacion.user_id" placeholder="Ingrese el ID del usuario evaluador" />
            </FormItem>

            <!-- Observaciones -->
            <FormItem label="Observaciones" name="observaciones" :rules="[{ required: true, message: 'Por favor ingrese las observaciones' }]">
                <Input.TextArea v-model:value="evaluacion.observaciones" placeholder="Ingrese las observaciones" rows="4" />
            </FormItem>

            <!-- Resultado -->
            <FormItem label="Resultado" name="resultado" :rules="[{ required: true, message: 'Por favor seleccione un resultado' }]">
                <Select v-model:value="evaluacion.resultado" placeholder="Seleccione un resultado">
                    <Select.Option value="Desestimado">Desestimado</Select.Option>
                    <Select.Option value="Pasa a Control">Pasa a Control</Select.Option>
                </Select>
            </FormItem>

            <!-- Fecha de Evaluación -->
            <FormItem label="Fecha de Evaluación" name="fecha_evaluacion" :rules="[{ required: true, message: 'Por favor seleccione la fecha de evaluación' }]">
                <Input v-model:value="evaluacion.fecha_evaluacion" placeholder="Ingrese la fecha de evaluación (YYYY-MM-DD)" />
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
import { ref, watch, defineProps, defineEmits } from 'vue';
import { Modal, Form, FormItem, Input, Button, Select, message } from 'ant-design-vue';
import axios from 'axios';

const props = defineProps({
    visible: Boolean,
});

const emitir = defineEmits(['update:visible', 'actualizar-tabla']);

const evaluacion = ref({
    denuncia_id: '', // ID de denuncia
    user_id: '', // ID del usuario evaluador
    observaciones: '', // Observaciones
    resultado: '', // Resultado
    fecha_evaluacion: '', // Fecha de evaluación
});

const cargando = ref(false);

// Cierra el modal y emite el evento para cerrar en el componente padre
const cerrarModal = () => {
    emitir('update:visible', false);
};

// Envía el formulario de creación de la evaluación
const enviarFormulario = async () => {
    cargando.value = true;
    try {
        // Enviar la solicitud para crear la evaluación
        const response = await axios.post(route('evaluaciones.store'), evaluacion.value);
        message.success('Evaluación agregada exitosamente');
        cerrarModal();
        emitir('actualizar-tabla', response.data["evaluacion"]);
    } catch (error) {
        message.error('Error al agregar la evaluación');
        console.error('Error al guardar la evaluación:', error);
    } finally {
        cargando.value = false;
    }
};

// Resetear datos del formulario cuando el modal se abre
watch(() => props.visible, (val) => {
    if (val) {
        evaluacion.value = {
            denuncia_id: '', // Resetear ID de denuncia
            user_id: '', // Resetear ID del usuario evaluador
            observaciones: '', // Resetear observaciones
            resultado: '', // Resetear resultado
            fecha_evaluacion: '', // Resetear fecha de evaluación
        };
    }
});
</script>
