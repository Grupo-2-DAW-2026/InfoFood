# 🍎 InfoFood - Trazabilidad Inteligente

¡Bienvenido a **InfoFood**! La plataforma definitiva para la gestión y consulta de trazabilidad alimentaria. Este proyecto nace para conectar a administradores, fabricantes y consumidores en un entorno seguro, visual y fácil de usar.

> **Beta v1.0 Finalizada**: Búsqueda global, historial de escaneo, gestión de alérgenos y línea de tiempo dinámica.

---

## 🚀 Funcionalidades Estrella
* **🔍 Escáner EAN Universal**: Lector de códigos de barras por cámara en tiempo real (vía QuaggaJS) o entrada manual.
* **📍 Línea de Trazabilidad**: Visualiza el camino de los alimentos con pasos reordenables y dinámicos.
* **🛡️ Panel de Control (Admin/User)**: Permisos inteligentes. El Admin supervisa todo, el usuario gestiona lo suyo.
* **🧪 Ficha Técnica Completa**: Información nutricional detallada (100g) y detección de alérgenos mediante iconos visuales.
* **👥 Modo Invitado**: Acceso público al escáner y fichas técnicas sin necesidad de registro.
* **🧪 Sincronización de Alérgenos**: Sistema inteligente de actualización masiva (Sync) para marcar trazas de forma rápida y visual.
* **📋 Historial de Escaneo**: Listado dinámico de los últimos productos consultados para un acceso rápido.
* **🔔 Notificaciones de Estado**: Sistema de alertas visuales (Success/Error/Info) que guía al usuario.

---

## 📂 Archivos Documentados y Comentados
Para facilitar el mantenimiento y la transparencia del proyecto, se ha realizado una labor de **documentación exhaustiva** en los siguientes archivos clave:

* **Controladores**: `ProductoController`, `ProfileController` y `TrazabilidadController` (Lógica de negocio comentada paso a paso).
* **Rutas**: `web.php` y `auth.php` (Organizadas por bloques lógicos y niveles de acceso corregidos).
* **Vistas de Autenticación**: `login.blade.php`, `register.blade.php` y `confirm-password.blade.php` (Explicación de componentes y directivas).
* **Vistas de Producto**: `show.blade.php`, `crear.blade.php` y `edit.blade.php` (Comentarios sobre la lógica de alérgenos y trazabilidad).
* **Layouts**: `app.blade.php` (Estructura maestra comentada).

---

## 🛠️ Guía de Instalación

Sigue estos pasos para poner la máquina en marcha en menos de 2 minutos:

1.  **Clonar el repositorio:**
    ```bash
    git clone [URL-DEL-REPOSITORIO]
    cd el-pozo-webapp
    ```

2.  **Instalar dependencias:**
    ```bash
    composer install
    ```

3.  **Configurar el entorno:**
    > ⚠️ **Nota de seguridad**: Hemos incluido el archivo `.env` configurado dentro del repositorio para agilizar la corrección. Al ser un entorno educativo, priorizamos la facilidad de despliegue.
    
    * Si el archivo no existiera, genera la clave de aplicación: `php artisan key:generate`.

4.  **Base de Datos (Vital):**
    * Crea una base de datos llamada `el_pozo_db`.
    * **Importa** el volcado SQL ubicado en: `/database/sql/el_pozo_db.sql`. ¡Ya incluye productos y usuarios de prueba!

5.  **¡Lanza la web!:**
    ```bash
    php artisan serve
    ```

---

## 🤖 Metodología de Desarrollo e IA
En **InfoFood**, hemos apostado por un flujo de trabajo optimizado:

* **Lógica de Negocio**: Todas las funciones de gestión de usuarios, relaciones de productos (hasOne/hasMany) y flujo de trazabilidad han sido **razonadas y diseñadas por el equipo**.
* **Asistencia de IA (Claude & Gemini)**: Al haber profundizado solo en conceptos básicos durante el curso, hemos utilizado modelos de IA como apoyo fundamental en:
    * **Bootstrap & UI**: Para lograr un diseño profesional y responsive, ya que los conocimientos de clase eran limitados.
    * **Lógica Compleja**: Implementación de la librería del escáner y depuración de funciones avanzadas de Laravel.
* **Optimización**: Se ha buscado reutilizar código, evitar consultas redundantes y mantener un código limpio y totalmente comentado.

---

## 📸 Tecnología del Escáner
Para la detección de productos, InfoFood integra una solución de visión artificial:
* **Librería**: `QuaggaJS`.
* **Capacidades**: Detección de códigos **EAN-13** mediante el acceso a la cámara o webcam.
* **Fallback**: Sistema de entrada manual integrado para máxima compatibilidad.

---

## 📜 Nota sobre la Autoría de Commits
Debido a que el repositorio se creó bajo un **usuario genérico de "Grupo-2-DAW-2026"**, es posible que en el historial de Git los commits aparezcan firmados tanto por el usuario del grupo como por el colaborador individual (contribuidor). 

Queremos aclarar que **la autoría real corresponde íntegramente al colaborador/contribuidor** que figura en cada commit. Esta duplicidad visual es un efecto técnico de la configuración del entorno compartido y no afecta a la realidad del trabajo realizado por cada integrante.

---

## 🔑 Credenciales de Prueba

| Rol | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@gmail.com` | `AdminDAW` |
| **Usuario** | `usuario@gmail.com` | `UsuarioDAW` |

---

**Desarrollado con ❤️ por el Grupo 2 de DAW en 2026 - Proyecto InfoFood.**
