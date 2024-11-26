<script setup>
import { ref } from 'vue';

// Fecha dinámica
const currentDate = new Date().toLocaleDateString('es-PE', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
});
</script>

<template>
  <div class="bg-gray-50 min-h-screen font-sans">
    <!-- Encabezado -->
    <header class="bg-blue-600 text-white">
      <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <h1 class="text-2xl font-bold">Tu Plataforma de Aprendizaje</h1>
        <nav>
          <ul class="flex space-x-4">
            <li><a href="#" class="hover:underline">Inicio</a></li>
            <li><a href="#" class="hover:underline">Categorías</a></li>
            <li><a href="#" class="hover:underline">Blog</a></li>
            <li><a href="#" class="hover:underline">Contáctanos</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <!-- Hero principal -->
    <section class="bg-gradient-to-r from-blue-500 to-blue-300 text-white py-16">
      <div class="container mx-auto flex items-center px-6">
        <div class="w-1/2">
          <h2 class="text-4xl font-extrabold mb-4">Invierte en tu conocimiento y futuro</h2>
          <p class="text-lg mb-6">
            Únete a miles de estudiantes que confían en nuestra plataforma para avanzar en sus carreras.
          </p>
          <div class="space-x-4">
            <a href="#" class="bg-blue-700 py-2 px-4 rounded hover:bg-blue-800">
              Empieza Ahora
            </a>
            <a href="#" class="bg-white text-blue-600 py-2 px-4 rounded hover:bg-gray-200">
              Mira el Video
            </a>
          </div>
        </div>
        <div class="w-1/2">
          <img src="/images/hero-image.png" alt="Estudiante feliz" class="rounded-lg shadow-lg">
        </div>
      </div>
    </section>

    <!-- Categorías -->
    <section class="py-16 bg-white">
      <div class="container mx-auto px-6 text-center">
        <h3 class="text-3xl font-bold text-gray-800 mb-8">Categorías Populares</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div class="p-6 border rounded shadow hover:shadow-lg transition">
            <h4 class="text-xl font-semibold mb-4">Diseño</h4>
            <p>Aprende a crear diseños profesionales para web y medios digitales.</p>
          </div>
          <div class="p-6 border rounded shadow hover:shadow-lg transition">
            <h4 class="text-xl font-semibold mb-4">Desarrollo</h4>
            <p>Conviértete en un desarrollador experto en tecnologías modernas.</p>
          </div>
          <div class="p-6 border rounded shadow hover:shadow-lg transition">
            <h4 class="text-xl font-semibold mb-4">Marketing</h4>
            <p>Descubre estrategias de marketing digital y crecimiento de marcas.</p>
          </div>
          <div class="p-6 border rounded shadow hover:shadow-lg transition">
            <h4 class="text-xl font-semibold mb-4">Tecnología</h4>
            <p>Domina habilidades técnicas en IT y software empresarial.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonios -->
    <section class="py-16 bg-gray-100">
      <div class="container mx-auto px-6 text-center">
        <h3 class="text-3xl font-bold text-gray-800 mb-8">Lo que nuestros estudiantes dicen</h3>
        <div class="flex items-center justify-center">
          <blockquote class="bg-white p-6 rounded shadow-md w-2/3">
            <p class="text-lg text-gray-700 italic">
              "Gracias a esta plataforma, logré mejorar mis habilidades en diseño gráfico. ¡Altamente recomendada!"
            </p>
            <cite class="text-gray-500 mt-4 block">- Estudiante Satisfecho</cite>
          </blockquote>
        </div>
      </div>
    </section>

    <!-- Llamado a la acción -->
    <section class="bg-blue-600 text-white py-12">
      <div class="container mx-auto text-center">
        <h4 class="text-2xl font-semibold mb-4">¿Listo para iniciar tu curso?</h4>
        <a href="#" class="bg-blue-800 py-3 px-6 rounded hover:bg-blue-900">
          Inscríbete Ahora
        </a>
      </div>
    </section>

    <!-- Pie de página -->
    <footer class="bg-gray-800 text-gray-300 py-6">
      <div class="container mx-auto text-center">
        <p>&copy; 2024 Tu Plataforma de Aprendizaje. Todos los derechos reservados.</p>
        <p class="text-sm">Desarrollado para inspirar el aprendizaje continuo.</p>
      </div>
    </footer>
  </div>
</template>