<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import { Input, Checkbox, Button, Alert } from 'ant-design-vue'; // Importamos los componentes necesarios

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Registrarse" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="text-center mb-3">
            <h1 class="block text-2xl font-bold text-udh_3 dark:text-gray-100">Registrarse</h1>
            <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                ¿Ya tienes una cuenta?
                <Link class="text-udh_1 hover:underline decoration-2 font-semibold" :href="route('login')">
                    Inicia sesión aquí
                </Link>
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nombre</label>
                <Input
                    id="name"
                    v-model:value="form.name"
                    type="text"
                    class="block mt-1 w-full"
                    required
                    placeholder="Ingrese su nombre"
                    autofocus
                    autocomplete="name"
                />
                <Alert
                    v-if="form.errors.name"
                    class="mt-2"
                    type="error"
                    show-icon
                    :message="form.errors.name"
                />
            </div>

            <!-- Correo Electrónico -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Correo electrónico</label>
                <Input
                    id="email"
                    v-model:value="form.email"
                    type="email"
                    class="block mt-1 w-full"
                    required
                    placeholder="Ingrese su correo electrónico"
                    autocomplete="username"
                />
                <Alert
                    v-if="form.errors.email"
                    class="mt-2"
                    type="error"
                    show-icon
                    :message="form.errors.email"
                />
            </div>

            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Contraseña</label>
                <Input.Password
                    id="password"
                    v-model:value="form.password"
                    required
                    placeholder="Ingrese su contraseña"
                    autocomplete="new-password"
                />
                <Alert
                    v-if="form.errors.password"
                    class="mt-2"
                    type="error"
                    show-icon
                    :message="form.errors.password"
                />
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Confirmar contraseña</label>
                <Input.Password
                    id="password_confirmation"
                    v-model:value="form.password_confirmation"
                    required
                    placeholder="Confirme su contraseña"
                    autocomplete="new-password"
                />
                <Alert
                    v-if="form.errors.password_confirmation"
                    class="mt-2"
                    type="error"
                    show-icon
                    :message="form.errors.password_confirmation"
                />
            </div>

            <!-- Términos y Condiciones -->
            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <Checkbox v-model:checked="form.terms" required>
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        Al registrarte, aceptas nuestras
                        <Link target="_blank" :href="route('terms.show')" class="underline text-gray-600 hover:text-udh_1 dark:hover:text-gray-300 rounded-md">
                            Términos de Servicio
                        </Link>
                        y nuestra
                        <Link target="_blank" :href="route('policy.show')" class="underline text-gray-600 hover:text-udh_1 dark:hover:text-gray-300 rounded-md">
                            Política de Privacidad
                        </Link>.
                    </span>
                </Checkbox>
            </div>

            <!-- Botón de Registro -->
            <Button
                type="primary"
                html-type="submit"
                class="w-full font-medium"
                size="large"
                :disabled="form.processing"
                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
            >
                Registrarse
            </Button>
        </form>
    </AuthenticationCard>
</template>
