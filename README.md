# Player Notes

Aplicación desarrollada en Laravel y Livewire para gestionar notas internas asociadas a jugadores.

La idea principal es que un agente de soporte pueda seleccionar un jugador, revisar el historial de observaciones que se han registrado anteriormente y, si cuenta con el permiso correspondiente, agregar nuevas notas sin tener que recargar la página.

El proyecto fue desarrollado como parte de una prueba técnica, intentando mantener una estructura simple, separando las responsabilidades principales y aprovechando las herramientas que entrega Laravel.

## Tecnologías utilizadas

- PHP 8.4
- Laravel 13
- Livewire 4
- Laravel Fortify
- Flux UI
- Tailwind CSS
- SQLite
- Pest
- Vite

## Funcionalidades

Actualmente la aplicación permite:

- Iniciar y cerrar sesión.
- Visualizar un listado de jugadores.
- Acceder al detalle de cada jugador.
- Consultar su historial de notas.
- Mostrar fecha, autor y contenido de cada nota.
- Crear nuevas notas utilizando Livewire.
- Actualizar el historial automáticamente después de crear una nota.
- Validar que la nota sea obligatoria y no supere los 1000 caracteres.
- Controlar mediante permisos qué usuarios pueden crear notas.
- Mantener el historial disponible para usuarios que solamente tienen acceso de consulta.

El registro público de usuarios se encuentra deshabilitado, ya que para efectos de la prueba se incluyen usuarios previamente configurados mediante seeders.

## Estructura utilizada

Para las operaciones relacionadas con las notas utilicé Repository Pattern.

El componente Livewire no realiza directamente las consultas a Eloquent, sino que depende de un contrato:

```text
Livewire
    ↓
PlayerNoteRepositoryInterface
    ↓
EloquentPlayerNoteRepository
    ↓
Eloquent / Base de datos
```

El contrato se encuentra en:

```text
app/Repositories/Contracts/PlayerNoteRepositoryInterface.php
```

Y su implementación en:

```text
app/Repositories/Eloquent/EloquentPlayerNoteRepository.php
```

La relación entre ambos se registra mediante el Service Container de Laravel en `RepositoryServiceProvider`.

Con esto busqué que el componente encargado de la interfaz no tenga que conocer la forma específica en que las notas son almacenadas o consultadas.

## Modelos principales

### Player

Representa al jugador sobre el cual se registran las observaciones.

Un jugador puede tener muchas notas.

### PlayerNote

Representa una nota interna asociada a un jugador.

Cada nota pertenece a:

- un jugador;
- un usuario que actúa como autor.

### User

Representa al agente que utiliza la aplicación.

Los usuarios poseen el atributo:

```text
can_create_player_notes
```

Este valor determina si pueden crear nuevas notas.

## Permisos

Para la autorización utilicé las Policies nativas de Laravel.

La creación de notas se controla mediante `PlayerNotePolicy`.

La validación se realiza tanto en la interfaz como al momento de ejecutar la acción, de forma que ocultar el formulario no sea la única medida de seguridad.

Existen dos usuarios de ejemplo para probar ambos comportamientos:

### Agente con permiso de escritura

```text
Email: soporte@example.com
Contraseña: password
```

Este usuario puede consultar el historial y agregar nuevas notas.

### Usuario de consulta

```text
Email: consulta@example.com
Contraseña: password
```

Este usuario puede revisar las notas, pero no puede crear nuevas.

## Base de datos

El proyecto utiliza SQLite para facilitar su instalación y ejecución.

Las tablas principales agregadas para esta funcionalidad son:

```text
players
player_notes
```

`player_notes` mantiene las referencias al jugador y al autor de la nota.

En caso de eliminar un jugador, sus notas asociadas también son eliminadas.

En cambio, la eliminación de un usuario que tenga notas asociadas se restringe para evitar perder la referencia del autor del historial.

## Instalación

Clonar el repositorio:

```bash
git clone https://github.com/marcellolopez/player-notes.git
cd player-notes
```

Instalar las dependencias de PHP:

```bash
composer install
```

Instalar las dependencias de frontend:

```bash
npm install
```

Crear el archivo de configuración:

### Windows

```powershell
copy .env.example .env
```

### Linux / macOS

```bash
cp .env.example .env
```

Generar la clave de Laravel:

```bash
php artisan key:generate
```

El proyecto está preparado para utilizar SQLite.

Crear el archivo de base de datos si todavía no existe:

```text
database/database.sqlite
```

Luego ejecutar las migraciones y seeders:

```bash
php artisan migrate --seed
```

También se puede reconstruir completamente la base de datos con:

```bash
php artisan migrate:fresh --seed
```

## Ejecutar el proyecto

Para levantar Laravel:

```bash
php artisan serve
```

Y para trabajar con los recursos del frontend:

```bash
npm run dev
```

También se puede utilizar:

```bash
composer run dev
```

Al ingresar a:

```text
http://127.0.0.1:8000
```

la aplicación dirige inicialmente al login.

Después de iniciar sesión se accede directamente al listado de jugadores.

## Flujo principal

El flujo de uso es sencillo:

```text
Login
  ↓
Listado de jugadores
  ↓
Seleccionar jugador
  ↓
Historial de notas
  ↓
Agregar nota (si el usuario tiene permiso)
```

Al crear una nota, Livewire dispara un evento que permite actualizar el componente del historial sin recargar completamente la página.

## Validaciones

Para crear una nota se valida:

```text
required
string
max:1000
```

Además de la validación del contenido, antes de guardar se verifica mediante la Policy que el usuario tenga autorización para realizar la acción.

## Tests

Se agregaron pruebas para verificar específicamente la funcionalidad de creación de notas.

Entre los escenarios cubiertos están:

- un usuario autorizado puede crear una nota;
- la nota queda asociada al jugador correcto;
- la nota queda asociada al autor correcto;
- un usuario sin permiso no puede crear notas;
- el contenido es obligatorio;
- el contenido no puede superar los 1000 caracteres.

También se mantienen los tests relacionados con autenticación y configuración incluidos en la aplicación.

Los tests se pueden ejecutar con:

```bash
php artisan test
```

Al finalizar el desarrollo el resultado es:

```text
26 passed
1 skipped
63 assertions
```

El test omitido corresponde a autenticación de dos factores, funcionalidad que no está habilitada en este proyecto.

## Formato del código

Para revisar el formato del código PHP utilicé Laravel Pint:

```bash
vendor/bin/pint
```

Para comprobar que los recursos de producción compilan correctamente:

```bash
npm run build
```

## Algunas decisiones que tomé

Preferí utilizar las herramientas nativas de Laravel siempre que era posible.

Para los permisos utilicé Policies en vez de agregar una dependencia externa, ya que el requerimiento era relativamente pequeño y no necesitaba un sistema completo de roles y permisos.

También decidí utilizar SQLite para que el proyecto pueda levantarse rápidamente sin necesidad de configurar un servidor de base de datos adicional.

Para las notas separé el acceso a datos mediante un repositorio. De esta forma los componentes Livewire se concentran principalmente en manejar la interacción del usuario, validación y actualización de la interfaz.

Finalmente, agregué un listado de jugadores y navegación básica para que la funcionalidad pueda probarse completa desde la interfaz sin necesidad de conocer previamente las rutas del proyecto.