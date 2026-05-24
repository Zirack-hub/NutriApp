# NutriApp

Aplicación web de gestión nutricional para entornos educativos desarrollada con Laravel 13.

## Características

- Catálogo de alimentos con datos nutricionales completos (macros, vitaminas, minerales)
- Creación y gestión de dietas con objetivo calórico personalizado
- Cálculo automático de kcal y macronutrientes (proteínas, grasas, hidratos de carbono)
- Organización de comidas por tipo: desayuno, almuerzo, comida, merienda, cena y suplementos
- Sistema de comentarios del profesor sobre las dietas del alumno
- Notificaciones de mensajes no leídos en tiempo real
- Búsqueda y gestión de alimentos por usuario
- Autenticación completa con cambio de contraseña obligatorio en el primer acceso
- Sistema de roles: administrador, profesor y alumno
- Solo el autor o un rol superior puede editar o borrar su contenido
- Diseño responsivo con CSS personalizado

## Instalación

```bash
# 1. Clonar el repositorio
git clone <url-del-repo>
cd NutriApp/ProyectoFinal/Nutriapp

# 2. Instalar dependencias PHP y JS
composer install
npm install

# 3. Configurar el entorno
cp .env.example .env
php artisan key:generate

# 4. Configurar la base de datos en .env
# DB_DATABASE=nutriapp
# DB_USERNAME=tu_usuario
# DB_PASSWORD=tu_contraseña

# 5. Aplicar migraciones
php artisan migrate

# 6. Compilar los assets
npm run build

# 7. Arrancar el servidor
php artisan serve
```

Accede en: http://localhost:8000

## URL en producción

https://nutriapp.42web.io/

## Autores

- Emilio Rabadán
- Martín Portela
- Samuel Merino

## Tecnologías

- PHP 8.3
- Laravel 13
- Blade
- JavaScript 
- MySQL (desarrollo y producción)
- Vite (bundler)
- 42web.io (despliegue)
- Composer
- GitHub
