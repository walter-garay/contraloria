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
            <FormItem label="Entidad" name="entidad" :rules="[{ required: true, message: 'Por favor ingrese la entidad' }]">
                <Input v-model:value="denuncia.entidad" placeholder="Ingrese la entidad relacionada" />
            </FormItem>

            <!-- Lugar -->
            <FormItem label="Lugar" name="lugar" :rules="[{ required: true, message: 'Por favor ingrese el lugar' }]">
                <Input v-model:value="denuncia.lugar" placeholder="Ingrese el lugar donde ocurrió" />
            </FormItem>

            <!-- Descripción -->
            <FormItem label="Descripción" name="descripcion" :rules="[{ required: true, message: 'Por favor ingrese una descripción' }]">
                <Input.TextArea v-model:value="denuncia.descripcion" placeholder="Ingrese una descripción detallada" rows="4" />
            </FormItem>

            <!-- Fecha Probable -->
            <FormItem label="Fecha Probable" name="fecha_probable" :rules="[{ required: true, message: 'Por favor seleccione una fecha' }]">
                <Input v-model:value="denuncia.fecha_probable" type="date" />
            </FormItem>

            <!-- Prioridad -->
            <FormItem label="Prioridad" name="prioridad">
                <Input v-model:value="denuncia.prioridad" type="number" placeholder="Ingrese la prioridad (opcional)" />
            </FormItem>

            <!-- Tipo de Hecho -->
            <FormItem label="Tipo de Hecho" name="tipo_de_hecho" :rules="[{ required: true, message: 'Por favor seleccione un tipo de hecho' }]">
                <Select v-model:value="denuncia.tipo_de_hecho" placeholder="Seleccione un tipo de hecho">
                    <Option v-for="opcion in opcionesTipoHecho" :key="opcion" :value="opcion">
                        {{ opcion }}
                    </Option>
                </Select>
            </FormItem>

            <!-- Monto Económico -->
            <FormItem label="Monto Económico" name="monto_economico">
                <Input v-model:value="denuncia.monto_economico" type="number" placeholder="Ingrese el monto económico (opcional)" />
            </FormItem>

            <!-- Otros Colaboradores -->
            <FormItem label="Otros Colaboradores" name="otros_colaboradores">
                <Input.TextArea v-model:value="denuncia.otros_colaboradores" placeholder="Ingrese los nombres de otros colaboradores (opcional)" rows="2" />
            </FormItem>

            <!-- Sigue Ocurriendo -->
            <FormItem label="¿Sigue Ocurriendo?" name="sigue_ocurriendo">
                <Input v-model:value="denuncia.sigue_ocurriendo" type="checkbox" />
            </FormItem>

            <!-- Estado -->
            <FormItem label="Estado" name="estado" :rules="[{ required: true, message: 'Por favor seleccione un estado' }]">
                <Input v-model:value="denuncia.estado" placeholder="Ingrese el estado de la denuncia" />
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
import { Modal, Form, FormItem, Input, Button, Select, Option, message } from 'ant-design-vue';
import axios from 'axios';

const props = defineProps({
    visible: Boolean,
    denuncia: {
        type: Object,
        default: () => ({
            id: null,
            entidad: '',
            lugar: '',
            descripcion: '',
            fecha_probable: '',
            prioridad: null,
            tipo_de_hecho: '',
            monto_economico: null,
            otros_colaboradores: '',
            sigue_ocurriendo: null,
            estado: '',
        }),
    },
});

const emitir = defineEmits(['update:visible', 'actualizar-tabla']);

const denuncia = ref({ ...props.denuncia });
const cargando = ref(false);

// Opciones para el campo "Tipo de Hecho"
const opcionesTipoHecho = [
    "Sistema Nacional de Presupuesto",
    "Sistema Nacional de Tesorería",
    "Sistema Nacional de Endeudamiento Público",
    "Sistema Nacional de Contabilidad",
    "Sistema Nacional de Inversión Pública",
    "Sistema Nacional de Planeamiento Estratégico",
    "Sistema Nacional de Defensa Jurídica del Estado",
    "Sistema Nacional de Control",
    "Modernización de la Gestión del Estado",
    "Sistema Nacional de Bienes Estatales",
    "Sistema Nacional de Abastecimiento (Contratación de obras públicas, bienes, servicios y suministros)",
    "Sistema de Gestión de Recursos Humanos",
];

// Cierra el modal y emite el evento para cerrar en el componente padre
const cerrarModal = () => {
    emitir('update:visible', false);
};

// Envía el formulario de edición de la denuncia
const enviarFormulario = async () => {
    cargando.value = true;
    try {
        const response = await axios.put(route('denuncias.update', denuncia.value.id), denuncia.value);
        message.success('Denuncia actualizada exitosamente');
        cerrarModal();
        emitir('actualizar-tabla', response.data["denuncia"]);
    } catch (error) {
        message.error('Error al actualizar la denuncia');
        console.error('Error al guardar la denuncia:', error);
    } finally {
        cargando.value = false;
    }
};

// Verificar si el modal se abre y cargar los valores de la denuncia
watch(() => props.visible, (val) => {
    if (val) {
        denuncia.value = { ...props.denuncia };
    }
});
</script>
