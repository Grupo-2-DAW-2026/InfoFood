# 🍎 InfoFood - Trazabilidad Inteligente

¡Bienvenido a **InfoFood**! La plataforma definitiva para la gestión y consulta de trazabilidad alimentaria. Este proyecto nace para conectar a administradores, fabricantes y consumidores en un entorno seguro, visual y fácil de usar.

> **Beta v1.0 Finalizada**: Búsqueda global, historial de escaneo, gestión de alérgenos y línea de tiempo dinámica.

---

## 🚀 Funcionalidades Estrella
* **🔍 Escáner EAN Universal**: Lector de códigos de barras por cámara en tiempo real o entrada manual.
* **📍 Línea de Trazabilidad**: Visualiza el camino de los alimentos con pasos reordenables y dinámicos.
* **🛡️ Panel de Control (Admin/User)**: Permisos inteligentes. El Admin supervisa todo; el usuario gestiona lo suyo.
* **🧪 Ficha Técnica Completa**: Información nutricional detallada (100g) y detección de alérgenos mediante iconos visuales.
* **👥 Modo Invitado**: Acceso público al escáner y fichas técnicas sin necesidad de registro.
* **⚡ Sincronización de Alérgenos**: Sistema inteligente de actualización masiva (Sync) para marcar trazas de forma rápida y visual.
* **📋 Historial de Escaneo**: Listado dinámico de los últimos productos consultados para un acceso rápido y sin re-escaneo.
* **🔔 Notificaciones de Estado**: Sistema de alertas visuales (Success/Error/Info) que guía al usuario tras cada acción en la plataforma.

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
    > ⚠️ **Nota de seguridad**: Hemos incluido el archivo `.env` configurado dentro del repositorio para agilizar la corrección. Somos conscientes de que no es una práctica recomendada en entornos de producción, pero al ser un repositorio privado para fines educativos, hemos priorizado la comodidad.
    
    * Si el archivo no existiera, genera la clave de aplicación: `php artisan key:generate`.

4.  **Base de Datos (Vital):**
    * Crea una base de datos llamada `el_pozo_db`.
    * **Importa** el volcado SQL ubicado en: `/database/sql/el_pozo_db.sql`. ¡Ya incluye productos y usuarios de prueba!

5.  **¡Lanza la web!:**
    ```bash
    php artisan serve
    ```

---

## 🔑 Credenciales de Prueba

Para testear los diferentes niveles de acceso, usa estas cuentas:

| Rol | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@gmail.com` | `AdminDAW` |
| **Usuario** | `usuario@gmail.com` | `UsuarioDAW` |

---

## 💻 Stack Tecnológico & Librerías

* **Backend**: **Laravel 12** + PHP 8.2 (Estructura robusta y escalable).
* **Autenticación**: **Laravel Breeze** (Seguridad profesional con roles y recuperación de contraseñas).
* **Escáner de Cámara**: **QuaggaJS** (Visión computacional para detección de EAN-13 en tiempo real).
* **Frontend**: Blade Templating + **Bootstrap 5** (Diseño *responsive* adaptado a móviles).
* **Iconografía**: **Bootstrap Icons** (Interfaz visual e intuitiva).
* **Base de Datos**: MySQL (Relaciones complejas y almacenamiento de trazabilidad).

---

**Desarrollado con ❤️ por el Grupo 2 DAW - Proyecto InfoFood.**
