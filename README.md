# CIUDADELA

CIUDADELA es un CMS institucional con un sitio público para avisos y publicaciones, y un panel autenticado para que el personal gestione ese contenido.

## Alcance actual

- Sitio público con inicio, publicaciones, páginas informativas y contacto.
- Panel de gestión protegido por autenticación, con resumen y publicaciones recientes.
- Roles de administrador y editor: los administradores gestionan usuarios y todas las publicaciones; los editores solo gestionan sus propias publicaciones.
- Administración de cuentas: búsqueda, creación, edición, activación/desactivación y restablecimiento de contraseñas.
- Creación, edición, publicación y eliminación de publicaciones con permisos por rol.
- Los borradores no se muestran en las rutas públicas.
- El contenido se valida en el servidor y se presenta escapado como texto.

Esta versión **no** incluye expedientes de víctimas, datos de beneficiarios, cifrado de extremo a extremo, MFA ni modo fantasma. No almacenes información sensible de personas en las publicaciones. El módulo protegido requiere un diseño de seguridad y gestión de claves antes de implementarse.

## Primer acceso de administración

Después de ejecutar las migraciones, crea la primera cuenta administradora con:

```sh
php artisan cms:create-admin
```

El comando solicita nombre, correo y contraseña de forma interactiva; no guarda credenciales en el repositorio. Al migrar una instalación existente, las cuentas que ya estaban creadas se conservan como administradoras y las cuentas nuevas se crean como editoras por defecto. No es posible desactivar ni degradar al último administrador activo.

## Requisitos

- PHP 8.2 o superior y Composer.
- Node.js y npm compatibles con Vite 7.
- Una base de datos configurada en `.env` (SQLite es la configuración local habitual).

## Instalación local

```sh
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
npm ci
npm run build
php artisan serve
```

En Windows PowerShell, si `copy` no encuentra `.env.example`, comprueba que exista en el proyecto y usa `Copy-Item .env.example .env`.

Para desarrollar con el servidor de Vite en caliente, ejecuta `npm run dev` en otra terminal.

## Pruebas

```sh
php artisan test
```

La migración `2026_10_31_000000_add_is_published_to_posts_table` agrega el estado de publicación. Ejecuta `php artisan migrate` al actualizar una base de datos existente.
Ejecuta `php artisan migrate` para agregar los roles y estados de cuenta en instalaciones existentes.
