<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Contraloría General del Perú" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div class="h-screen flex flex-col ">
            <!-- Barra de navegación -->
            <nav class="flex items-center justify-between px-6 py-4 shadow-md bg-white dark:bg-gray-800">
                <div class="flex items-center">
                    <img src="images/logo.png" alt="Logo" class="w-10 h-10 mr-2 rounded-lg" />
                    <span class="text-xl font-semibold sm:flex hidden">Contraloría General del Perú</span>
                </div>
                <div>
                    <template v-if="$page.props.auth.user">
                        <Link
                            href="#"
                            class="rounded-md px-4 py-2 text-white bg-red-600 hover:bg-red-700 focus:ring focus:ring-red-300"
                        >
                            Ingresar
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            href="login"
                            class="rounded-md px-4 py-2 text-black bg-gray-200 hover:bg-gray-300 focus:ring focus:ring-gray-300 dark:text-white dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-500"
                        >
                            Iniciar Sesión
                        </Link>
                        <Link
                            v-if="canRegister"
                            href="register"
                            class="ml-4 rounded-md px-4 py-2 text-white bg-red-600 hover:bg-red-700 focus:ring focus:ring-red-300"
                        >
                            Registrarse
                        </Link>
                    </template>
                </div>
            </nav>

            <!-- Sección principal -->
            <section class="h-full flex flex-col lg:flex-row items-center justify-center sm:justify-between px-6 lg:px-24 sm:gap-x-16">
                <!-- Texto -->
                <div class="lg:w-1/2 mb-12 lg:mb-0">
                    <p class="text-sm text-red-600 font-semibold mb-2">¡Un paso hacia la transparencia!</p>
                    <h1 class="text-4xl font-bold leading-tight mb-4">
                        Realiza tu denuncia de manera <span class="text-red-600">segura</span> y <span class="text-red-600">confidencial</span>.
                    </h1>
                    <p class="mb-6 text-lg">
                        Nuestro sistema garantiza que todas las denuncias sean tratadas con profesionalismo, seguridad y transparencia.
                    </p>
                    <Link
                        href="#"
                        class="rounded-md px-6 py-3 text-white bg-red-600 hover:bg-red-700 focus:ring focus:ring-red-300"
                    >
                        Realizar denuncia
                    </Link>
                </div>

                <!-- Imagen -->
                <div class="lg:w-1/2">
                    <img src="https://www.munijesusmaria.gob.pe/wp-content/uploads/2020/05/mdjm-controlario-2.jpeg" alt="Sistema Contraloría" class="w-full h-auto rounded-lg shadow-lg" />
                </div>
            </section>

        </div>

        <!-- Información adicional -->
        <section class="px-6 lg:px-24 py-12 bg-gray-50 dark:bg-gray-800">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">¿Por qué elegir nuestro sistema?</h2>
                <p class="text-lg">
                    Brindamos un servicio eficiente para garantizar la rendición de cuentas y la prevención de actos de corrupción.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-6 bg-white dark:bg-gray-900 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg mb-2">Confidencialidad</h3>
                    <p class="text-sm">
                        Todas las denuncias son tratadas con máxima seguridad para proteger tu identidad.
                    </p>
                </div>

                <div class="text-center p-6 bg-white dark:bg-gray-900 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg mb-2">Transparencia</h3>
                    <p class="text-sm">
                        Seguimiento y resolución garantizada en cada etapa del proceso de denuncia.
                    </p>
                </div>

                <div class="text-center p-6 bg-white dark:bg-gray-900 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg mb-2">Equipo Experto</h3>
                    <p class="text-sm">
                        Un equipo profesional revisará y evaluará cada caso con objetividad.
                    </p>
                </div>

                <div class="text-center p-6 bg-white dark:bg-gray-900 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg mb-2">Seguridad</h3>
                    <p class="text-sm">
                        Sistema desarrollado con las mejores prácticas de seguridad informática.
                    </p>
                </div>
            </div>
        </section>

        <!-- Testimonios -->
        <section class="px-6 lg:px-24 py-12">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Lo que dicen nuestros usuarios</h2>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-center gap-8">
                <div class="text-center max-w-xs">
                    <p class="italic">"El proceso fue rápido y sencillo. Gracias por su compromiso."</p>
                    <p class="font-bold mt-2">Ana López</p>
                </div>

                <div class="text-center max-w-xs">
                    <p class="italic">"Me siento seguro al utilizar este sistema para denunciar irregularidades."</p>
                    <p class="font-bold mt-2">Carlos Gómez</p>
                </div>
            </div>
        </section>

        <!-- Pie de página -->
        <footer class="bg-gray-200 dark:bg-gray-900 py-6">
            <div class="text-center text-sm">
                <p>&copy; 2024 Contraloría General del Perú. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>
</template>
