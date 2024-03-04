# Documentación del proyecto
## Índice

- [Documentación del proyecto](#documentación-del-proyecto)
  - [Índice](#índice)
  - [Introducción](#introducción)
  - [Base de datos](#base-de-datos)
    - [Eventos](#eventos)
    - [Triggers](#triggers)
  - [PHP](#php)
    - [Subsección 2.1](#subsección-21)
    - [Subsección 2.2](#subsección-22)
  - [JavaScript](#javascript)
    - [Subsección 2.1](#subsección-21-1)
    - [Subsección 2.2](#subsección-22-1)
  - [Bootstrap y CSS](#bootstrap-y-css)
    - [Paleta de colores](#paleta-de-colores)
    - [Diseño](#diseño)
    - [Uso de Bootstrap](#uso-de-bootstrap)
    - [Implementación de clases reutilizables](#implementación-de-clases-reutilizables)
  - [Despliegue de la aplicación](#despliegue-de-la-aplicación)
    - [Subsección 2.1](#subsección-21-2)
    - [Subsección 2.2](#subsección-22-2)
  - [Conclusión](#conclusión)

## Introducción

Este es el inicio de tu documento.

## Base de datos

Tendremos una base de datos llamada 'incidencias_tic' con cotejamiento 'utf8mb4_unicode_ci'.

Almacenará los datos necesarios para gestionar las incidencias TIC que pueden surgir en un instituto. Además de disponer de tablas de roles y permisos para las usuarios de la aplicación.

Todo lo relacionado con base de datos estará creado mediante migraciones para las tablas y factories y seeders para la inserción de datos. El diagrama de la base de datos de incidencias es el siguiente:

![](imagenes_documentacion/Diagrama_BD.png)

### Eventos

Activaremos los eventos en la base de datos para crear un trabajo que establecerá en estado 'cerrado' las incidencias que pasen más de un día en estado 'resuelto'. Este evento se ejecutará todos los días a las 23:59h llamando al procedimiento almacenado correspondiente.

```sql
SET GLOBAL event_scheduler = 1;

CREATE PROCEDURE IF NOT EXISTS cerrarIncidenciasResueltas()
BEGIN
    UPDATE incidencias
    SET estado = "cerrada", fecha_cierre = NOW()
    WHERE estado = "resuelta" AND fecha_cierre IS NOT NULL AND fecha_cierre < NOW() - INTERVAL 1 DAY;
END;

CREATE EVENT IF NOT EXISTS cerrarIncidenciasEvent
ON SCHEDULE EVERY 1 DAY
STARTS CURRENT_DATE + INTERVAL 23 HOUR + INTERVAL 59 MINUTE
ON COMPLETION PRESERVE
DO CALL cerrarIncidenciasResueltas();
```

### Triggers

Crearemos dos triggers en la base de datos.

El primero se ejecutará antes de la inserción de un registro en la tabla 'users' y consistirá en comprobar si el departamento que tiene, si es que tiene, existe en la tabla 'departamentos' para así recoger el id del departamento y grabarle junto al registro en la tabla 'users'.

```sql
CREATE TRIGGER before_insert_user
BEFORE INSERT ON users FOR EACH ROW
BEGIN
    -- Almacenar temporalmente el ID del departamento encontrado
    DECLARE departamento_id bigint(20);

    -- Verificar si el campo nombre_departamento no es NULL
    IF NEW.nombre_departamento IS NOT NULL THEN
        -- Buscar el departamento en la tabla departamentos
        SELECT id INTO departamento_id FROM departamentos WHERE nombre = NEW.nombre_departamento;

        -- Si se encuentra el departamento, actualizar id_departamento en users
        IF departamento_id IS NOT NULL THEN
            SET NEW.id_departamento = departamento_id;
        END IF;
    END IF;
END;
```

El segundo se ejecutará después de la inserción de un registro en la tabla 'users' y consistirá en establacer su rol. Si es el primer registro que se inserta en la tabla, su rol será 'administrador' de lo contrario será 'profesor'.

```sql
CREATE TRIGGER IF NOT EXISTS asignar_rol_after_insert_user
AFTER INSERT ON users FOR EACH ROW
BEGIN
    -- Variables
    DECLARE usuarios_totales INT; -- Cantidad de usuarios en la tabla users. Nos indicará si es el primer login o no.
    DECLARE administrador_role_id INT; -- ID del rol administrador en la tabla roles
    DECLARE usuario_role_id INT; -- ID del rol usuario en la tabla roles
    DECLARE user_model_type VARCHAR(255); -- Espacio de nombres que será el tipo del modelo en la tabla model_has_roles

    -- Guardar el namespace del modelo de usuario
    SET user_model_type = "App\\\\Models\\\\User";

    -- Obtener el número total de usuarios
    SELECT COUNT(*) INTO usuarios_totales FROM users;

    -- Obtener los IDs de los roles por su nombre
    SELECT id INTO administrador_role_id FROM roles WHERE name = "administrador";
    SELECT id INTO usuario_role_id FROM roles WHERE name = "profesor";

    -- Asignar el rol según si es el primer login o no
    IF usuarios_totales = 1 THEN
        INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES (administrador_role_id, user_model_type, NEW.id);
    ELSE
        INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES (usuario_role_id, user_model_type, NEW.id);
    END IF;
END;
```

## PHP

Contenido de la segunda sección.

### Subsección 2.1

Contenido de la subsección 2.1.

### Subsección 2.2

Contenido de la subsección 2.2.

## JavaScript

Contenido de la segunda sección.

### Subsección 2.1

Contenido de la subsección 2.1.

### Subsección 2.2

Contenido de la subsección 2.2.

## Bootstrap y CSS

Hemos usado Bootstrap un framework css, ademas de css tradicional

### Paleta de colores

Aquí tienes una tabla con los colores utilizados en la página.

| Nombre del Color | Código Hexadecimal | Muestra |
| ---------------- | ------------------ | ------- |
| Aquamarine 50    | #f0f8ff            | <div style="width: 20px; height: 20px; background-color: #f0f8ff;"></div> |
| Aquamarine 100   | #e0f0fe            | <div style="width: 20px; height: 20px; background-color: #e0f0fe;"></div> |
| Aquamarine 200   | #bae2fd            | <div style="width: 20px; height: 20px; background-color: #bae2fd;"></div> |
| Aquamarine 300   | #60bffb            | <div style="width: 20px; height: 20px; background-color: #60bffb;"></div> |
| Aquamarine 400   | #38b1f8            | <div style="width: 20px; height: 20px; background-color: #38b1f8;"></div> |
| Aquamarine 500   | #0e97e9            | <div style="width: 20px; height: 20px; background-color: #0e97e9;"></div> |
| Aquamarine 600   | #0277c7            | <div style="width: 20px; height: 20px; background-color: #0277c7;"></div> |
| Aquamarine 700   | #035fa1            | <div style="width: 20px; height: 20px; background-color: #035fa1;"></div> |
| Aquamarine 800   | #075185            | <div style="width: 20px; height: 20px; background-color: #075185;"></div> |
| Aquamarine 900   | #0c446e            | <div style="width: 20px; height: 20px; background-color: #0c446e;"></div> |
| Aquamarine 950   | #082b49            | <div style="width: 20px; height: 20px; background-color: #082b49;"></div> |
| Blanco 50        | #ffffff            | <div style="width: 20px; height: 20px; background-color: #ffffff;"></div> |
| Blanco 100       | #f8fafc            | <div style="width: 20px; height: 20px; background-color: #f8fafc;"></div> |
| Morado 50        | #b444f5            | <div style="width: 20px; height: 20px; background-color: #b444f5;"></div> |
| Negro 50         | #000000            | <div style="width: 20px; height: 20px; background-color: #000000;"></div> |

### Diseño

Para tener una estética limpia, se ha optado por un CRUD con el menú principal en la parte superior de la pantalla un pie de página con las mismas opciones de navegación.

### Uso de Bootstrap

Hemos usado Bootstap lo maximo posible, aplicando componentes predefinidos y plicando estilos para que que concuerde con el diseño que hemos hecho

Componenetes usados:
* Alerts (Alertas)
* Breadcrumb (Migas de pan)
* Buttons (Botones)
* Cards (Tarjetas)
* Close button (Botones de cerrado)
* Dropdowns (Botones desplegables)
* Modals (Modales)
* Navbar (Barra de navegación)
* Offcanvas (Barra lateral desplegable)
* Pagination (Pagianción)

Alerts (Alertas):
> Las alertas son usadas cuando hay errores o para informar al usuario de acciones que se han realizado.

Breadcrumb (Migas de pan)
> También llamadas migas de pan son usadas para informar al usuario en qué parte de la aplicación está situado, además puede usar lo puede usar para navegar por las distintas secciones.

Buttons (Botones) y Dropdowns (Botones desplegables)
> Son usados para realizar acciones y/o confirmar cambios, además los botones desplegables contienen diferentes acciones.

Cards (Tarjetas)
> Están presentes en toda la información de las incidencias, usuarios y el chat de comentarios.

Navbar (Barra de navegación)
> Usado en la cabecera de la página, contiene el logo con los distintos enlaces a las distintas páginas.

Modals (Modales)
> Proporciona información al usuario antes de realizar acciones críticas, como borrado y actualización de incidencias y usuarios.

Offcanvas (Barra lateral desplegable)
> Usados par contener los filtros de incidencias y usuarios, los informes, y el chat de comentarios de cada incidencia.

Close button (Botones de cerrado)
> Sirven para cerrar los modales o las barras laterales desplegables.

Pagination (Pagianción)
> Para navegar en la tabla de incidencias y usuarios.

### Implementación de clases reutilizables

Adoptando la idea y filosofía de Bootstrap y de frameworks como Tailwind, hemos implementado clases CSS genéricas que sirven para cambiar los colores de fondo de los elementos y botones, de esta manera la podemos crear componentes reutilizables fácilmente y que la estética de la aplicación sea homogénea.

## Despliegue de la aplicación

Contenido de la segunda sección.

### Subsección 2.1

Contenido de la subsección 2.1.

### Subsección 2.2

Contenido de la subsección 2.2.

## Conclusión

Aquí puedes poner tus reflexiones finales.
