# tienda_online_zapatos

Sistema MVC en PHP para una tienda de zapatos.

## Estructura del proyecto

- `config.php` - configuración de la base de datos y funciones globales.
- `models/` - contiene las clases `Database`, `Producto` y `Usuario`.
- `controllers/` - lógica para autenticación y productos.
- `views/` - plantillas separadas para admin, cliente y layout.
- `assets/css/style.css` - estilos responsivos y tarjetas.
- `uploads/` - imágenes de productos subidas por el usuario.
- `database.sql` - script de creación de base de datos y datos de prueba.

## Instalación

1. Importa `database.sql` en tu servidor MySQL.
2. Asegúrate de que la base de datos `tienda_zapatos` exista.
3. Ajusta las credenciales en `config.php` si es necesario.
4. Coloca el proyecto en tu servidor local y abre `index.php`.

## Cuentas de ejemplo

- Admin: `admin@tienda.com` / `admin123`
- Cliente: `cliente@tienda.com` / `cliente123`

## Uso

- El admin puede crear, editar, eliminar y vender productos.
- El cliente puede registrarse, iniciar sesión y simular compras.

---

## Manual Técnico

### Instalación del sistema

1. Copia la carpeta `tienda_online_zapatos` dentro de tu servidor local (por ejemplo, `htdocs` de XAMPP).
2. Importa el archivo `database.sql` en MySQL para crear la base de datos y las tablas necesarias.
3. Asegúrate de que la carpeta `uploads/` exista y tenga permisos de escritura.
4. Abre el proyecto en tu navegador con la ruta del servidor local.

### Configuración del entorno

- PHP 7.4 o superior (recomendado PHP 8+).
- Servidor web Apache o similar.
- Base de datos MySQL/MariaDB.
- Modifica `config.php` si tus credenciales de base de datos son diferentes:
  - `DB_HOST`
  - `DB_NAME`
  - `DB_USER`
  - `DB_PASS`

### Dependencias

- PHP puro sin frameworks.
- Extensión `mysqli` habilitada.
- No hay dependencias externas de Composer.
- CSS puro en `assets/css/style.css`.

### Ejecución del proyecto

1. Inicia Apache e MySQL en XAMPP u otro servidor local.
2. Accede a `http://localhost/tu_ruta/tienda_online_zapatos/index.php`.
3. Usa el login de admin o cliente para entrar.

---

## Manual de Usuario

### Cómo ingresar al sistema

1. Abre el navegador en la ruta del proyecto.
2. Selecciona "Ingresar" para acceder con una cuenta existente.
3. Si no tienes cuenta, haz clic en "Registrarse" y completa los datos.
4. El sistema redirige según tu rol:
   - `admin` → panel de inventario.
   - `cliente` → catálogo de zapatos.

### Uso de cada módulo

#### Módulo ADMIN

- Al iniciar sesión como admin se muestra el inventario.
- Puedes agregar un nuevo zapato con nombre, precio, stock e imagen.
- Puedes editar productos existentes.
- Puedes eliminar productos.
- Puedes simular una venta con el botón "Vender", lo que reduce el stock.

#### Módulo CLIENTE

- Al iniciar sesión como cliente se muestra el catálogo en modo solo lectura.
- Puedes ver los productos en tarjetas con imagen, precio y stock.
- El botón "Comprar" simula una compra y disminuye el stock.
- El cliente no puede editar ni eliminar productos.

### Funcionalidades principales

- Registro y autenticación de usuarios con roles.
- Gestión completa de productos desde el panel admin.
- Subida de imágenes para cada zapato.
- Catálogo responsive de productos con tarjetas.
- Mensajes de éxito/error mediante sesión.
