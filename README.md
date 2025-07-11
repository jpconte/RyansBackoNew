# Ryan's Travels - Panel de Administración

## Instalación

1. **Subir archivos al servidor**
   - Sube todos los archivos a la carpeta `/admin/` en tu servidor
   - La estructura debe quedar: `ryanstravel.com.ar/admin/`

2. **Configurar permisos**
   - Asegúrate de que los archivos PHP tengan permisos de lectura (644)
   - Las carpetas deben tener permisos 755

3. **Verificar base de datos**
   - Los datos de conexión están en `config/database.php`
   - Usuario: c2831151_U3v
   - Contraseña: fena88RUnu
   - Base de datos: c2831151_turismoryan
   - Servidor: localhost

4. **Crear usuario de prueba** (opcional)
   Ejecuta este SQL en tu base de datos para crear un usuario de prueba:

   ```sql
   INSERT INTO usuario (nombre, email, pass, tipo_usuario_id, role) 
   VALUES ('Administrador', 'admin@ryanstravel.com.ar', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 'admin');
   ```

   Contraseña: `password`

5. **Acceder al sistema**
   - URL: `http://ryanstravel.com.ar/admin/`
   - Se redirigirá automáticamente al login

## Estructura del proyecto

```
admin/
├── config/
│   ├── database.php      # Configuración de base de datos
│   └── config.php        # Configuraciones generales
├── controllers/
│   ├── AuthController.php    # Controlador de autenticación
│   └── DashboardController.php # Controlador del dashboard
├── models/
│   └── User.php          # Modelo de usuario
├── views/
│   ├── auth/
│   │   └── login.php     # Vista de login
│   └── dashboard/
│       └── index.php     # Vista del dashboard
├── assets/
│   ├── css/              # Archivos CSS personalizados
│   └── js/               # Archivos JavaScript personalizados
├── helpers/              # Funciones auxiliares
├── login.php             # Punto de entrada para login
├── dashboard.php         # Punto de entrada para dashboard
├── index.php             # Redirección automática
└── .htaccess             # Configuraciones del servidor
```

## Características implementadas

### Sistema de Login
- ✅ Autenticación con email y contraseña
- ✅ Verificación de contraseñas hasheadas
- ✅ Opción "Recordarme"
- ✅ Manejo de sesiones seguras
- ✅ Redirección automática después del login
- ✅ Mensajes de error y éxito

### Dashboard
- ✅ Interfaz responsive con Bootstrap 5
- ✅ Menú lateral con navegación
- ✅ Gráficos interactivos con Chart.js
- ✅ Estadísticas en tiempo real
- ✅ Actividad reciente
- ✅ Diseño moderno y profesional

### Seguridad
- ✅ Verificación de sesiones en todas las páginas
- ✅ Protección contra acceso no autorizado
- ✅ Configuraciones de seguridad en .htaccess
- ✅ Sanitización de datos de entrada

## Próximos pasos

1. **Gestión de Contenido Web**
   - CRUD para Video Home
   - CRUD para Productos destacados
   - CRUD para Eventos
   - CRUD para sección Nosotros
   - CRUD para Nuestro equipo
   - CRUD para Oficinas
   - CRUD para Contacto
   - CRUD para Redes sociales

2. **Gestión de Productos Turísticos**
3. **Gestión de Agencias**
4. **Gestión de Tarifas y Tarifarios**
5. **Configuraciones Generales**

## Tecnologías utilizadas

- **Backend**: PHP 7.4+
- **Base de datos**: MySQL
- **Frontend**: Bootstrap 5.3.3
- **Gráficos**: Chart.js
- **Iconos**: Bootstrap Icons
- **Arquitectura**: MVC (Model-View-Controller)

## Soporte

Para cualquier consulta o problema, contacta al desarrollador.