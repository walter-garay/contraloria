<template>
    <Modal
        title="Editar Usuario"
        :open="visible"
        @cancel="cerrarModal"
        centered
        :footer="null"
    >
        <Form layout="vertical" @finish="enviarFormulario" :model="usuario">
            <!-- Nombre -->
            <FormItem label="Nombre" name="name" :rules="[{ required: true, message: 'Por favor ingrese el nombre' }]">
                <Input v-model:value="usuario.name" placeholder="Ingrese el nombre completo" />
            </FormItem>

            <!-- Email -->
            <FormItem label="Correo Electrónico" name="email" :rules="[{ type: 'email', message: 'Por favor ingrese un correo válido' }]">
                <Input v-model:value="usuario.email" placeholder="Ingrese el correo electrónico" />
            </FormItem>

            <!-- Contraseña -->
            <FormItem label="Contraseña" name="password">
                <Input.Password v-model:value="usuario.password" placeholder="Ingrese una nueva contraseña (opcional)" />
            </FormItem>

            <!-- Rol -->
            <FormItem label="Rol" name="rol" :rules="[{ required: true, message: 'Por favor seleccione un rol' }]">
                <Select v-model:value="usuario.rol" placeholder="Seleccione un rol">
                    <Select.Option value="Ciudadano">Ciudadano</Select.Option>
                    <Select.Option value="Auditor">Auditor</Select.Option>
                    <Select.Option value="Administrador">Administrador</Select.Option>
                </Select>
            </FormItem>

            <!-- Estado (Activo/Inactivo) -->
            <FormItem label="Estado" name="is_active">
                <Switch v-model:value="usuario.is_active" checked-children="Activo" unchecked-children="Inactivo" />
            </FormItem>

            <!-- Celular -->
            <FormItem label="Celular" name="celular">
                <Input v-model:value="usuario.celular" placeholder="Ingrese el número de celular" />
            </FormItem>

            <!-- DNI -->
            <FormItem label="DNI" name="dni">
                <Input v-model:value="usuario.dni" placeholder="Ingrese el DNI" />
            </FormItem>

            <!-- Cargo -->
            <FormItem label="Cargo" name="cargo">
                <Input v-model:value="usuario.cargo" placeholder="Ingrese el cargo" />
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
import { Modal, Form, FormItem, Input, Button, Select, Switch, message } from 'ant-design-vue';
import axios from 'axios';

// Propiedades recibidas del componente padre
const props = defineProps({
    visible: Boolean,
    usuario: {
        type: Object,
        default: () => ({
            id: null,
            name: '',
            email: '',
            password: '',
            rol: '',
            is_active: true,
            celular: '',
            dni: '',
            cargo: '',
        }),
    },
});

// Emitir eventos al componente padre
const emitir = defineEmits(['update:visible', 'actualizar-tabla']);

// Usuario en edición
const usuario = ref({ ...props.usuario });
const cargando = ref(false);

// Cierra el modal y emite el evento para cerrar en el componente padre
const cerrarModal = () => {
    emitir('update:visible', false);
};

// Envía el formulario de edición del usuario
const enviarFormulario = async () => {
    cargando.value = true;
    try {
        // Enviar la solicitud para actualizar el usuario
        const response = await axios.put(route('usuarios.update', usuario.value.id), usuario.value);
        message.success('Usuario actualizado exitosamente');
        cerrarModal();
        emitir('actualizar-tabla', response.data["usuario"]);
    } catch (error) {
        message.error('Error al actualizar el usuario');
        console.error('Error al guardar el usuario:', error);
    } finally {
        cargando.value = false;
    }
};

// Verificar si el modal se abre y cargar los valores del usuario
watch(() => props.visible, (val) => {
    if (val) {
        usuario.value = { ...props.usuario }; // Recargar datos del usuario
    }
});
</script>
