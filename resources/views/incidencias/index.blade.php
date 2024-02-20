<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        table {
            border: 1px solid black;
        }

        th {
            border: 1px solid black;
        }

        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1>Incidencias index</h1>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener el token CSRF del meta tag en el documento
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Hacer la solicitud Fetch al controlador incluyendo el token CSRF
            fetch("{{ route('incidencias.index') }}", {
                    method: "GET",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Agrega este console.log para verificar la respuesta

                    // Crear una tabla
                    const table = document.createElement("table");

                    // Crear la cabecera de la tabla
                    const headerRow = table.insertRow();
                    Object.keys(data[0]).forEach(key => {
                        const th = document.createElement("th");
                        th.textContent = key;
                        headerRow.appendChild(th);
                    });

                    // Crear las filas de datos
                    data.forEach(item => {
                        const row = table.insertRow();
                        Object.values(item).forEach(value => {
                            const cell = row.insertCell();
                            cell.textContent = value;
                        });
                    });

                    // Agregar la tabla al cuerpo del documento
                    document.body.appendChild(table);
                })
                .catch(error => console.error("Error en la solicitud Fetch:", error));
        });
    </script>

</body>

</html>
