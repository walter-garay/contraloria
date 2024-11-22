Aquí tienes el archivo `README.md` con **todos los pasos detallados**, desde clonar el proyecto hasta ejecutarlo:

```markdown
# Sistema Web - Contraloría General de la República del Perú

Este es un proyecto web diseñado para la **Contraloría General de la República del Perú**. El sistema permite gestionar procesos administrativos, reportes y colaboraciones dentro de la institución.

## Tecnologías utilizadas

- **PHP 8.x**: Lenguaje de backend.
- **Laravel 11**: Framework para el desarrollo backend.
- **Jetstream con Inertia.js**: Manejo de autenticación y funcionalidades avanzadas.
- **Vue.js 3**: Framework de frontend.
- **Vite**: Herramienta para desarrollo y bundling del frontend.
- **Node.js**: Entorno para ejecutar scripts frontend.
- **Composer**: Gestor de dependencias para PHP.
- **MySQL**: Base de datos relacional.
- **TailwindCSS**: Framework CSS para estilos.
- **Sanctum**: Middleware para autenticación basada en tokens.

---

## Pasos para clonar e inicializar el proyecto

Sigue los pasos a continuación para configurar el proyecto localmente.

### **1. Clonar el repositorio**
Abre tu terminal y ejecuta el siguiente comando:
```bash
git clone https://github.com/walter-garay/contraloria.git
```

### **2. Entrar al directorio del proyecto**
Navega al directorio del proyecto:
```bash
cd contraloria
```

### **3. Inicializar un repositorio Git (si no está inicializado)**
Si Git no está inicializado en tu copia local, inicialízalo:
```bash
git init
```

### **4. Instalar las dependencias de PHP**
Ejecuta el siguiente comando para instalar las dependencias del backend:
```bash
composer install
```

### **5. Instalar las dependencias de Node.js**
Instala las dependencias del frontend:
```bash
npm install
```

### **6. Configurar las variables de entorno**
1. Copia el archivo `.env.example` y renómbralo a `.env`:
   ```bash
   cp .env.example .env
   ```

2. Abre el archivo `.env` y configura los detalles de la base de datos:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=contraloria
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

### **7. Generar la clave de la aplicación**
Genera una clave única para la aplicación:
```bash
php artisan key:generate
```

### **8. Crear la base de datos**
Crea manualmente una base de datos llamada `contraloria` en tu servidor MySQL utilizando herramientas como phpMyAdmin o MySQL Workbench.

### **9. Ejecutar las migraciones**
Crea las tablas necesarias en la base de datos ejecutando:
```bash
php artisan migrate
```

### **10. Iniciar el servidor de desarrollo**
Ejecuta el siguiente comando para compilar los assets y levantar el servidor:
```bash
composer run dev
```

Este comando ejecutará:
- El servidor de Laravel en `http://127.0.0.1:8000`.
- El listener de colas.
- El servidor de desarrollo de Vite.

---

## Solución a problemas comunes

### **1. Error: "Unknown database 'contraloria'"**
Si aparece este error, asegúrate de haber creado manualmente la base de datos `contraloria` y que las credenciales en el archivo `.env` sean correctas.

### **2. Advertencia sobre Node.js/npm**
Si npm muestra advertencias de incompatibilidad con Node.js:
1. Actualiza Node.js a una versión compatible (>= 18.17.0).
2. Limpia la caché de npm si es necesario:
   ```bash
   npm cache clean --force
   ```

### **3. Conflictos con Git**
Si al hacer `git push` ves un error como `rejected (fetch first)`:
1. Ejecuta:
   ```bash
   git pull origin main --rebase
   ```
2. Luego intenta de nuevo:
   ```bash
   git push origin main
   ```

---

## ¿Cómo contribuir?

Si deseas contribuir al proyecto:
1. Haz un fork del repositorio.
2. Crea una nueva rama para tu funcionalidad:
   ```bash
   git checkout -b mi-nueva-funcionalidad
   ```
3. Realiza tus cambios, agrega y sube los commits:
   ```bash
   git add .
   git commit -m "Descripción de los cambios"
   git push origin mi-nueva-funcionalidad
   ```
4. Envía un pull request al repositorio principal.

---

## Licencia

Este proyecto es de uso exclusivo de la **Contraloría General de la República del Perú**.

---

## Contacto

Si tienes dudas o encuentras problemas, puedes contactarte con el administrador del repositorio.
```

### **Detalles del archivo**
- Incluye **todos los pasos necesarios** para configurar y ejecutar el proyecto localmente.
- Explica cómo manejar problemas comunes.
- Proporciona instrucciones claras para contribuciones al proyecto.

¡Este archivo README.md está listo para ser usado! 😊
