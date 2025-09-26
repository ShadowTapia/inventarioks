# Copilot Instructions for inventarioks

## Arquitectura General

-   Proyecto basado en **Laravel** (PHP) con **MySQL** como base de datos.
-   Estructura estándar de Laravel: `app/` (lógica de negocio), `routes/` (rutas), `resources/views/` (vistas Blade), `config/` (configuración), `database/` (migraciones, seeders, factories).
-   Uso de **Livewire** para componentes interactivos en el frontend (`app/Livewire/`).
-   Integración con **Jetstream** y **Fortify** para autenticación y gestión de usuarios.
-   Panel de administración con **AdminLTE** (`config/adminlte.php`).

## Flujos de Desarrollo

-   **Compilar assets:** Usar Vite y Tailwind (`vite.config.js`, `tailwind.config.js`). Comando típico:
    ```bash
    npm run dev
    ```
-   **Migraciones y seeders:**
    ```bash
    php artisan migrate
    php artisan db:seed
    ```
-   **Ejecutar servidor local:**
    ```bash
    php artisan serve
    ```
-   **Pruebas:**
    ```bash
    php artisan test
    ```
    o
    ```bash
    vendor/bin/phpunit
    ```

## Convenciones y Patrones

-   **Controladores:** Ubicados en `app/Http/Controllers/`. Usar recursos RESTful.
-   **Livewire:** Componentes en `app/Livewire/` siguen el patrón de nombre por funcionalidad (`Companies.php`, `Devibyestado.php`).
-   **Vistas:** Blade templates en `resources/views/`. Usar layouts y secciones para reutilización.
-   **Configuración:** Centralizada en archivos de `config/`. Personalizaciones en `adminlte.php`, `fortify.php`, `jetstream.php`.
-   **Rutas:**
    -   Web: `routes/web.php`
    -   API: `routes/api.php`
    -   Consola: `routes/console.php`

## Integraciones y Dependencias

-   **AdminLTE** para UI administrativa.
-   **Livewire** para interactividad sin recargar página.
-   **Jetstream/Fortify** para auth y gestión de sesiones.
-   **PowerGrid** y **Wire Elements Modal** para tablas y modales avanzados.

## Ejemplos Clave

-   **Livewire:** `app/Livewire/Devibyestado.php` gestiona dispositivos por estado.
-   **Configuración personalizada:** `config/adminlte.php` para el panel.
-   **Migraciones:** `database/migrations/` define estructura de tablas.

## Recomendaciones para Agentes AI

-   Priorizar convenciones Laravel y Livewire.
-   Mantener la separación de lógica (controladores, modelos, vistas, componentes).
-   Consultar archivos de configuración para personalizaciones antes de modificar comportamientos globales.
-   Usar comandos artisan para tareas comunes.
-   Utiliza siempre la tabulación para formatear el código.
-   Prioriza siempre soluciones simples y directas.
-   Busca siempre código existente para iterar en lugar de crear nuevo código desde cero.
-   Evita la duplicación de código siempre que sea posible; esto implica revisar si ya existe una parte del código con lógica o funcionalidad simila
-   Escribe código que tenga en cuenta los diferentes entornos: desarrollo, pruebas y producción
-   Asegúrate de hacer solo los cambios solicitados o aquellos en los que tengas plena confianza de que están bien comprendidos y están relacionados con la solicitud.
-   Al corregir un error o bug, no introduzcas un nuevo patrón o tecnología sin antes haber agotado todas las opciones con la implementación actual. Y si finalmente decides hacerlo, asegúrate de eliminar la implementación anterior para evitar lógica duplicada.
-   Mantén la base de código limpia y bien organizado.
-   Evita escribir scripts directamente en archivos si es posible, especialmente si ese script solo se va a ejecutar una vez.

---

¿Falta algún flujo, integración o patrón relevante? Indica detalles específicos para mejorar estas instrucciones.
