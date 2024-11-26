<script setup>
import { Input, InputPassword, Checkbox, Button } from 'ant-design-vue'; // Importamos los componentes necesarios
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Iniciar sesión" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <!-- Título -->
        <div class="text-center mb-4">
            <h1 class="block text-2xl font-bold text-udh_3 dark:text-gray-100">Iniciar sesión</h1>
            <p class="mt-3 text-gray-600 dark:text-gray-400">
                ¿Aún no tienes una cuenta?
                <Link class="text-udh_1 hover:underline decoration-2 font-semibold" :href="route('register')">
                    Regístrate aquí
                </Link>
            </p>
        </div>

        <!-- Google Login -->
        <a href="{{ route('google') }}"
           class="w-full py-2 px-3 inline-flex justify-center items-center gap-2 rounded-sm border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:ring-0 transition-all">
            <img src="/images/google.webp" class="w-4 h-4 mr-1" alt="google-icon">
            Continuar con Google
        </a>

        <!-- Separador -->
        <div class="w-full flex justify-between items-center my-4">
            <hr class="h-px border-0 bg-gray-400 flex-1">
            <div class="text-gray-600 dark:text-gray-400 text-xs leading-[18px] px-2.5">O</div>
            <hr class="h-px border-0 bg-gray-400 flex-1">
        </div>

        <!-- Formulario -->
        <form @submit.prevent="submit">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Correo Electrónico</label>
                <Input
                    id="email"
                    v-model:value="form.email"
                    type="email"
                    class="mt-1 block w-full dark:bg-gray-800 dark:text-gray-100"
                    placeholder="Ingrese su correo electrónico"
                    required
                    autofocus
                />
                <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">
                    {{ form.errors.email }}
                </p>
            </div>

            <!-- Contraseña -->
            <div class="mt-4">
                <div class="flex justify-between items-center">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Contraseña</label>
                    <Link :href="route('password.request')" class="text-sm text-udh_1 font-semibold decoration-2 hover:underline">
                        ¿Olvidaste tu contraseña?
                    </Link>
                </div>
                <InputPassword
                    id="password"
                    v-model:value="form.password"
                    placeholder="Ingrese su contraseña"
                    required
                />
                <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">
                    {{ form.errors.password }}
                </p>
            </div>

            <!-- Recordar sesión -->
            <div class="block my-4">
                <Checkbox v-model:checked="form.remember" class="text-gray-600 dark:text-gray-400 dark:checked:bg-gray-700">
                    Mantener sesión activa
                </Checkbox>
            </div>

            <!-- Botón -->
            <Button
                type="primary"
                html-type="submit"
                size="large"
                class="w-full"
                :disabled="form.processing"
                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
            >
                Iniciar sesión
            </Button>
        </form>
    </AuthenticationCard>
</template>
