#!/bin/bash

# Códigos de escape ANSI para colores
rojo='\033[0;31m'
verde='\033[0;32m'
azul='\033[0;34m'
reset='\033[0m'

# Imprimir por pantalla el menú
mostrar_menu() {
    echo "Selecciona una opción:"
    echo "1 - Configuración y despliegue inicial"
    echo "2 - Actualizar la aplicación"
    echo "3 - Ejecutar migraciones y seeders"
    echo "4 - Salir"
}

# Función para ejecutar migraciones y seeders
ejecutar_migraciones_y_seeders() {
    carpeta_aplicacion="$1"

    # Comprobar si se pasó por parámetro una carpeta de aplicación
    if [ -z "$carpeta_aplicacion" ]; then
        # Solicitar la carpeta de la aplicación
        read -p "Introduce la carpeta de la aplicación: " carpeta_aplicacion

        # Comprobar si la carpeta existe
        if [ ! -d "$carpeta_aplicacion" ]; then
            echo "${rojo}La carpeta de la aplicación no existe. Por favor, introduce una carpeta válida.${reset}"
            return
        fi

        # Cambiar a la carpeta de la aplicación
        echo -e "${azul}Cambiando ubicación a $carpeta_aplicacion...${reset}"
        cd "$carpeta_aplicacion" || exit
    fi

    # Ejecución de migraciones
    read -p "¿Deseas ejecutar las migraciones de la base de datos? (S/n): " ejecutar_migraciones
    if [[ $ejecutar_migraciones == "S" || $ejecutar_migraciones == "s" || $ejecutar_migraciones == "" ]]; then
        php artisan migrate:fresh

        # Preguntar si desea ejecutar los seeders
        read -p "¿Deseas ejecutar los seeders de la base de datos? (S/n): " ejecutar_seeders
        if [[ $ejecutar_seeders == "S" || $ejecutar_seeders == "s" || $ejecutar_seeders == "" ]]; then
            php artisan db:seed
        else
            echo -e "${azul}No se ejecutarán los seeders.${reset}"
        fi
    else
        echo -e "${azul}No se ejecutarán las migraciones ni los seeders.${reset}"
    fi
}

# Función para ejecutar el despliegue y configuración inicial
ejecutar_despliegue_inicial() {
    # Solicitar la carpeta de destino
    read -p "Introduce la carpeta de destino donde se clonará el repositorio: " carpeta_destino

    # Verificar si la carpeta no existe y crearla
    if [ ! -d "$carpeta_destino" ]; then
        echo -e "${azul}La carpeta de destino no existe. Creando la carpeta...${reset}"
        mkdir -p "$carpeta_destino"
    fi

    # Solicitar la URL del repositorio
    read -p "Introduce la URL del repositorio Git: " repo_url

    # Clonar el repositorio en la carpeta de destino
    echo -e "${azul}Clonar repositorio...${reset}"
    git clone "$repo_url" "$carpeta_destino"

    # Cambiar de ubicación a la carpeta de destino configurada
    echo -e "${azul}Cambiando ubicación a $carpeta_destino...${reset}"
    cd "$carpeta_destino" || exit

    # Instalación de las dependencias de PHP con Composer
    echo -e "${azul}Instalar dependencias de PHP con Composer...${reset}"
    composer install

    # Instalación de las dependencias de JS con NPM
    echo -e "${azul}Instalar dependencias de JavaScript con npm...${reset}"
    npm install

    # Copiar .env.example a .env
    echo -e "${azul}Copiar .env.example a .env...${reset}"
    cp .env.example .env

    # Paramos la ejecución hasta configurar el archivo .env correctamente
    read -p "Crea tu BD y configura el archivo .env. Luego presiona Enter para continuar."

    # Generamos la clave de la app en el .env
    echo -e "${azul}Generar la clave de la aplicación...OK!${reset}"
    php artisan key:generate

    # Ejecución de migraciones y seeders
    ejecutar_migraciones_y_seeders "$carpeta_destino"

    # Compilar assets con NPM build
    echo -e "${azul}Compilar assets con npm...${reset}"
    npm run build

    # Aplicar permisos necesarios a la carpeta de destino
    echo -e "${azul}Aplicar permisos a la carpeta del sitio...${reset}"
    chown -R www-data:www-data "$carpeta_destino"
    chmod -R 755 "$carpeta_destino"
    # Error: The stream or file "/var/www/****/storage/logs/laravel.log" could not be opened in append mode: Failed to open stream: Permission denied
    chown -R www-data:www-data "$carpeta_destino/storage"
    chmod -R 775 "$carpeta_destino/storage"

    # Fin script
    echo -e "${verde}¡Instalación y configuración completadas!${reset}"
}

# Función para ejecutar la actualización sobre el repositorio clonado
ejecutar_actualizacion() {
    # Solicitar la carpeta de la aplicación
    read -p "Introduce la carpeta de la aplicación a actualizar: " carpeta_actualizacion

    # Comprobar si la carpeta existe
    if [ ! -d "$carpeta_actualizacion" ]; then
        echo -e "${rojo}La carpeta de la aplicación no existe. Por favor, introduce una carpeta válida.${reset}"
        return
    fi

    # Cambiar a la carpeta de la aplicación
    echo -e "${azul}Cambiando ubicación a $carpeta_actualizacion...${reset}"
    cd "$carpeta_actualizacion" || exit

    echo -e "${azul}Actualizar la aplicación en la carpeta $carpeta_actualizacion...${reset}"
    git fetch origin
    git reset --hard origin/main
    echo -e "${verde}¡Actualización completada!${reset}"

    # Ejecutar migraciones y seeders
    ejecutar_migraciones_y_seeders "$carpeta_actualizacion"
}

# Menú principal
while true; do
    mostrar_menu

    read -p "Introduce el número de la opción: " opcion

    case $opcion in
        1)
            ejecutar_despliegue_inicial
            ;;
        2)
            ejecutar_actualizacion
            ;;
        3)
            ejecutar_migraciones_y_seeders
            ;;
        4)
            echo -e "${verde}Saliendo del script. ¡Hasta luego!${reset}"
            exit 0
            ;;
        *)
            echo -e "${rojo}Opción inválida. Por favor, elija una opción válida.${reset}"
            ;;
    esac
done