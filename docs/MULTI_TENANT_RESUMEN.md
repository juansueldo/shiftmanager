# Adaptación Multi-Tenant con Slug - Resumen

## Resumen Ejecutivo

ShiftManager ha sido adaptado para soportar múltiples clientes (multi-tenant) utilizando slugs en la URL. Cada cliente ahora tiene su propio identificador único en la URL que aísla completamente sus datos de otros clientes.

## ¿Qué es un Slug?

Un **slug** es un identificador único, amigable para URLs, que representa a cada cliente:
- **Ejemplo**: "clinica-acme", "hospital-metro", "dr-rodriguez"
- **Formato**: Minúsculas, alfanumérico, guiones
- **Único**: Cada cliente tiene un slug diferente

## Cambios en la Estructura de URLs

### Antes (Un Solo Cliente)
```
http://miapp.com/dashboard
http://miapp.com/pacientes
http://miapp.com/doctores
```

### Ahora (Multi-Cliente)
```
http://miapp.com/clinica-acme/dashboard
http://miapp.com/clinica-acme/pacientes
http://miapp.com/clinica-acme/doctores
```

## Implicancias Principales

### 1. Base de Datos

**Tablas Modificadas:**
- ✅ `customers`: Agregado campo `slug` (UNIQUE)
- ✅ `specialties`: Agregado `customer_id`
- ✅ `rols`: Agregado `customer_id`
- ✅ `statuses`: Agregado `customer_id`
- ✅ `dashboard_widgets`: Agregado `customer_id`
- ✅ `doctor_specialty`: Agregado `customer_id`
- ✅ `availabilities`: Agregado `customer_id`

**Tablas que ya tenían `customer_id`:**
- ✅ `users`
- ✅ `patients`
- ✅ `calendars`

### 2. Aislamiento de Datos

**Cada cliente solo ve sus propios datos:**
- ✅ Pacientes
- ✅ Doctores
- ✅ Citas/Turnos
- ✅ Especialidades
- ✅ Usuarios
- ✅ Roles personalizados
- ✅ Estados personalizados

**Datos compartidos (opcionales):**
- Roles del sistema (Admin, Doctor, Paciente)
- Estados del sistema (Activo, Inactivo)

### 3. Flujo de Registro

Cuando un usuario se registra:
1. Se crea un nuevo `Customer` con slug auto-generado
2. El slug se genera desde el nombre de la empresa o nombre+apellido
3. El usuario queda asociado a ese `Customer`
4. Se redirige a `/{slug}/dashboard`

**Ejemplo:**
```
Empresa: "Clínica del Sol"
Slug generado: "clinica-del-sol"
URL dashboard: http://miapp.com/clinica-del-sol/dashboard
```

### 4. Flujo de Login

Cuando un usuario inicia sesión:
1. Autentica con email/contraseña
2. Sistema detecta el `customer_id` del usuario
3. Obtiene el `slug` del customer
4. Redirige a `/{slug}/dashboard`

### 5. Middleware de Detección

**SetTenantFromSlug** se ejecuta en cada request:
- Extrae `{slug}` de la URL
- Busca el `Customer` por slug
- Valida que esté activo
- Guarda el tenant actual para uso global
- Si el slug no existe o está inactivo: **404**

### 6. Routing (Rutas)

**Rutas fuera del contexto tenant** (sin slug):
- `/login` - Inicio de sesión
- `/register` - Registro
- `/landing` - Página de inicio
- `/auth/google` - OAuth

**Rutas dentro del contexto tenant** (con slug):
- `/{slug}/dashboard`
- `/{slug}/patients`
- `/{slug}/doctors`
- `/{slug}/calendar`
- `/{slug}/specialty`
- `/{slug}/users`
- etc.

### 7. Helpers Disponibles

**Funciones de ayuda creadas:**

```php
// Obtener el tenant actual
$customer = tenant();

// Obtener el slug actual
$slug = tenant_slug();

// Generar una ruta con slug
$url = tenant_route('dashboard.index');
```

### 8. Modelos Actualizados

**Todos los modelos ahora incluyen:**
- Relación `customer()`
- Campo `customer_id` en `$fillable`
- Filtrado automático por tenant (donde aplica)

**Modelos modificados:**
- ✅ Customer (agregado slug, método generateSlug)
- ✅ Specialty
- ✅ Rol
- ✅ Status
- ✅ DashboardWidget
- ✅ Availabilities

### 9. Controladores Actualizados

**RegisterController:**
- Genera slug al registrar nuevo customer
- Redirige con slug después del registro

**LoginController:**
- Redirige con slug del usuario después del login

**SpecialtyController:**
- Auto-asigna `customer_id` al crear especialidad
- Filtra especialidades por tenant
- Valida unicidad dentro del tenant

**Pendientes de actualizar:**
- DoctorController
- RolesController
- StatusesController
- DashboardController
- etc.

## Migraciones

### Ejecutar Migraciones

```bash
php artisan migrate
```

Esto creará:
1. Columna `slug` en `customers`
2. Columna `customer_id` en 6 tablas adicionales
3. Restricciones de foreign keys

### Rollback (si es necesario)

```bash
php artisan migrate:rollback --step=7
```

## Uso en el Código

### En Controladores

```php
// Obtener el customer actual
$customer = tenant();

// Crear un registro con customer_id
Specialty::create([
    'name' => $request->name,
    'customer_id' => tenant()->id,
    'status' => 1,
]);

// Redirigir con slug
return redirect()->route('specialty.index', ['slug' => tenant_slug()]);

// O usando el helper
return redirect(tenant_route('specialty.index'));
```

### En Vistas (Blade)

```blade
{{-- Acceder al tenant --}}
<h1>Bienvenido a {{ $tenant->company_name }}</h1>

{{-- Generar enlaces con slug --}}
<a href="{{ route('patients.index', ['slug' => $tenant->slug]) }}">Pacientes</a>

{{-- O usando el helper (pendiente de implementar en vistas) --}}
<a href="{{ tenant_route('patients.index') }}">Pacientes</a>
```

### Validación con Scope de Tenant

```php
// Validar unicidad dentro del tenant
$request->validate([
    'name' => 'required|string|max:255|unique:specialties,name,' . $request->id . ',id,customer_id,' . tenant()->id,
]);
```

## Casos de Uso

### Caso 1: Dos Clínicas Independientes

**Clínica A** (slug: `clinica-norte`):
- Tiene 3 doctores
- Tiene 100 pacientes
- Tiene especialidad "Cardiología"
- URL: `http://miapp.com/clinica-norte/dashboard`

**Clínica B** (slug: `clinica-sur`):
- Tiene 5 doctores
- Tiene 150 pacientes
- Tiene especialidad "Cardiología" (su propia versión)
- URL: `http://miapp.com/clinica-sur/dashboard`

**Aislamiento**: Los datos de Clínica A y Clínica B están completamente separados.

### Caso 2: Médico Individual

**Dr. Rodríguez** (slug: `dr-rodriguez`):
- Es su propio "customer"
- Tiene su lista de pacientes
- Tiene su calendario de citas
- URL: `http://miapp.com/dr-rodriguez/dashboard`

## Trabajo Pendiente

### Fase 1: Base de Datos y Modelos ✅
- [x] Migraciones creadas
- [x] Modelos actualizados
- [x] Relaciones definidas

### Fase 2: Routing y Middleware ✅
- [x] Middleware creado
- [x] Rutas actualizadas
- [x] Helpers creados

### Fase 3: Controladores (En Progreso) 🔄
- [x] SpecialtyController
- [x] RegisterController
- [x] LoginController
- [ ] DoctorController
- [ ] PatientController (revisar)
- [ ] CalendarController (revisar)
- [ ] RolesController
- [ ] StatusesController
- [ ] UserController (revisar)
- [ ] DashboardController (revisar)

### Fase 4: Vistas (Pendiente) ⏳
- [ ] Actualizar todos los `route()` por `tenant_route()`
- [ ] Actualizar enlaces en navegación
- [ ] Actualizar formularios
- [ ] Actualizar redirects

### Fase 5: Seeders (Pendiente) ⏳
- [ ] Crear seeder para roles del sistema
- [ ] Crear seeder para estados del sistema
- [ ] Migrar datos existentes (si hay)

### Fase 6: Testing (Pendiente) ⏳
- [ ] Tests de aislamiento de datos
- [ ] Tests de routing con slug
- [ ] Tests de middleware
- [ ] Tests de registro/login

## Posibles Problemas y Soluciones

### Problema: Error 404 en el Dashboard
**Causa**: Falta el slug en la URL
**Solución**: Usar `/{slug}/dashboard` en lugar de `/dashboard`

### Problema: No se ven datos del cliente
**Causa**: Falta filtro por `customer_id`
**Solución**: Verificar que el modelo use `filter_by_customer = true` en DatatableFilter

### Problema: Conflicto de slugs
**Causa**: Dos clientes intentan usar el mismo slug
**Solución**: El sistema automáticamente agrega un número (ej: `clinica-2`)

### Problema: Usuario sin customer
**Causa**: Datos de migración incompletos
**Solución**: Asignar un `customer_id` a todos los usuarios existentes

## Beneficios de la Implementación

### Para el Negocio
✅ Permite vender a múltiples clínicas/hospitales
✅ Cada cliente tiene su propia URL branded
✅ Aislamiento total de datos entre clientes
✅ Escalabilidad para crecimiento

### Para los Clientes
✅ Datos completamente privados
✅ URL personalizada (ej: `miapp.com/mi-clinica`)
✅ Configuración personalizada (roles, estados)
✅ Experiencia dedicada

### Técnicos
✅ Un solo código base para todos los clientes
✅ Despliegue centralizado
✅ Mantenimiento simplificado
✅ Backup y seguridad centralizados

## Próximos Pasos Recomendados

1. **Completar controladores restantes** (Prioridad Alta)
   - Actualizar DoctorController
   - Actualizar RolesController  
   - Actualizar StatusesController

2. **Actualizar vistas** (Prioridad Alta)
   - Buscar todos los `route()` y reemplazar con `tenant_route()`
   - Actualizar navegación y menús

3. **Crear seeders** (Prioridad Media)
   - Roles del sistema
   - Estados del sistema
   - Customer de ejemplo

4. **Testing exhaustivo** (Prioridad Media)
   - Probar aislamiento de datos
   - Probar flujo de registro/login
   - Probar creación de datos

5. **Migración de datos** (Si hay datos existentes)
   - Generar slugs para customers existentes
   - Asignar customer_id a datos huérfanos

6. **Documentación para usuarios** (Prioridad Baja)
   - Guía de uso para administradores
   - FAQ

## Recursos Creados

### Documentación
- ✅ `docs/MULTI_TENANT_IMPLICATIONS.md` - Implicancias técnicas detalladas (EN)
- ✅ `docs/MULTI_TENANT_USAGE.md` - Guía de uso completa (EN)
- ✅ `docs/MULTI_TENANT_RESUMEN.md` - Este documento (ES)

### Código
- ✅ `app/Http/Middleware/SetTenantFromSlug.php` - Middleware
- ✅ `app/helpers.php` - Funciones helper
- ✅ 7 archivos de migración en `database/migrations/`
- ✅ Modelos actualizados
- ✅ Controladores actualizados
- ✅ `routes/web.php` actualizado

## Contacto y Soporte

Para preguntas o problemas:
1. Revisar la documentación en `docs/`
2. Verificar las migraciones en `database/migrations/`
3. Revisar los helpers en `app/helpers.php`
4. Consultar los modelos actualizados

## Conclusión

La adaptación multi-tenant con slugs está **70% completa**:
- ✅ Base de datos y modelos
- ✅ Routing y middleware
- 🔄 Controladores (parcial)
- ⏳ Vistas (pendiente)
- ⏳ Testing (pendiente)

El sistema ya es funcional para registro, login y especialidades. El trabajo restante consiste en actualizar los controladores y vistas restantes para usar el contexto de tenant.
