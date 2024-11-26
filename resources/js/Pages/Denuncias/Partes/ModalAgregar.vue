<template>
    <Modal
        title="Agregar Denuncia"
        :open="visible"
        @cancel="cerrarModal"
        centered
        :footer="null"
    >
        <Form layout="vertical" @finish="enviarFormulario" :model="denuncia">
            <!-- Entidad -->
            <FormItem label="Entidad" name="entidad" :rules="[{ required: true, message: 'Por favor ingrese la entidad' }]">
                <Input v-model:value="denuncia.entidad" placeholder="Ingrese la entidad relacionada con la denuncia" autofocus />
            </FormItem>

            <!-- Lugar -->
            <FormItem label="Lugar" name="lugar" :rules="[{ required: true, message: 'Por favor ingrese el lugar' }]">
                <Input v-model:value="denuncia.lugar" placeholder="Ingrese el lugar de la denuncia" />
            </FormItem>

            <!-- Descripción -->
            <FormItem label="Descripción" name="descripcion" :rules="[{ required: true, message: 'Por favor ingrese una descripción' }]">
                <Input.TextArea v-model:value="denuncia.descripcion" placeholder="Ingrese la descripción de los hechos" />
            </FormItem>

            <!-- Fecha Probable -->
            <FormItem label="Fecha Probable" name="fecha_probable" :rules="[{ required: true, message: 'Por favor ingrese la fecha probable' }]">
                <DatePicker v-model:value="denuncia.fecha_probable" placeholder="Seleccione la fecha probable" style="width: 100%" />
            </FormItem>

            <!-- Prioridad -->
            <FormItem label="Prioridad" name="prioridad">
                <InputNumber v-model:value="denuncia.prioridad" min="1" max="5" placeholder="Seleccione la prioridad (1 a 5)" style="width: 100%" />
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
                <InputNumber v-model:value="denuncia.monto_economico" min="0" step="0.01" placeholder="Ingrese el monto económico" style="width: 100%" />
            </FormItem>

            <!-- Otros Colaboradores -->
            <FormItem label="Otros Colaboradores" name="otros_colaboradores">
                <Input.TextArea v-model:value="denuncia.otros_colaboradores" placeholder="Ingrese otros colaboradores si los hay" />
            </FormItem>

            <!-- Sigue Ocurriendo -->
            <FormItem label="¿Sigue Ocurriendo?" name="sigue_ocurriendo">
                <Switch v-model:value="denuncia.sigue_ocurriendo" />
            </FormItem>

            <!-- Estado -->
            <FormItem label="Estado" name="estado" :rules="[{ required: true, message: 'Por favor seleccione el estado de la denuncia' }]">
                <Select v-model:value="denuncia.estado" placeholder="Seleccione el estado de la denuncia">
                    <Select.Option value="En proceso">En proceso</Select.Option>
                    <Select.Option value="Admitido">Admitido</Select.Option>
                    <Select.Option value="No admitido">No admitido</Select.Option>
                    <Select.Option value="Derivado a OCI">Derivado a OCI</Select.Option>
                </Select>
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
import { Modal, Form, FormItem, Input, InputNumber, DatePicker, Button, Switch, Select, message } from 'ant-design-vue';
import axios from 'axios';

const props = defineProps({
    visible: Boolean,
});

const emitir = defineEmits(['update:visible', 'actualizar-tabla']);

const denuncia = ref({
    entidad: '',
    lugar: '',
    descripcion: '',
    fecha_probable: null,
    prioridad: null,
    tipo_de_hecho: '',
    monto_economico: null,
    otros_colaboradores: '',
    sigue_ocurriendo: false,
    estado: '',
});


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

const cargando = ref(false);

// Cierra el modal y emite el evento para cerrar en el componente padre
const cerrarModal = () => {
    emitir('update:visible', false);
};

// Envía el formulario de creación de denuncia
const enviarFormulario = async () => {
    cargando.value = true;
    try {
        // Enviar la solicitud para crear la denuncia
        const response = await axios.post(route('denuncias.store'), denuncia.value);
        message.success('Denuncia agregada exitosamente');
        cerrarModal();
        emitir('actualizar-tabla', response.data["denuncia"]);
    } catch (error) {
        message.error('Error al agregar la denuncia');
        console.error('Error al guardar la denuncia:', error);
    } finally {
        cargando.value = false;
    }
};

// Resetear datos del formulario cuando el modal se abre
watch(() => props.visible, (val) => {
    if (val) {
        denuncia.value = {
            entidad: '',
            lugar: '',
            descripcion: '',
            fecha_probable: null,
            prioridad: null,
            tipo_de_hecho: '',
            monto_economico: null,
            otros_colaboradores: '',
            sigue_ocurriendo: false,
            estado: '',
        };
    }
});

// Array con los tipos de hechos cargados desde la imagen
const tiposDeHechos = [
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
</script>
