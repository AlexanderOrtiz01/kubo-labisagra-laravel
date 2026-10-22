# Ferretería La Bisagra · Inventario (Laravel + MySQL)

Cliente 1 de **Kubo PaaS** (plan básico). CRUD completo de productos para las 4 sucursales de la ferretería.

| | |
|---|---|
| Stack | PHP 8.4 · Laravel 12 · Apache 2.4 · MySQL 8.4 (base administrada por Kubo) |
| URL pública | https://labisagra.kubo.dpdns.org |
| Despliegue | Kubo vigila la rama `main`: cada `git push` construye la imagen con este `Dockerfile` y la despliega |

## Variables de entorno

Ninguna credencial está en el código ni en el repositorio.

| Variable | Quién la define | Dónde |
|---|---|---|
| `APP_KEY`, `APP_NAME`, `APP_URL` | El cliente | Panel de Kubo → *Variables de entorno* |
| `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Kubo | Secret de la base administrada, inyectado en el pod |
| `KUBO_COMMIT`, `KUBO_POD` | Kubo | Commit desplegado y réplica que atiende (se ven al pie de la página) |

## Rutas

| Método | Ruta | Acción |
|---|---|---|
| GET | `/productos` | Listado con búsqueda y paginación |
| GET/POST | `/productos/create`, `/productos` | Crear |
| GET/PUT | `/productos/{id}/edit`, `/productos/{id}` | Editar |
| DELETE | `/productos/{id}` | Eliminar |
| GET | `/salud` | Estado y versiones (PHP, Laravel, Apache, MySQL) |

Al arrancar, el contenedor espera a MySQL, aplica las migraciones y carga el inventario inicial si la tabla está vacía.
La imagen corre sin root (UID 33) y Apache escucha en el puerto 8080.
