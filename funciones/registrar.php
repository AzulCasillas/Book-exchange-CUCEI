<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('imagen2.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.7);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #2133f3;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .Iniciar-Sesion {
            position: absolute; 
            top: 10px; 
            left: 10px;
            padding: 10px;
        }
        .Iniciar-Sesion button {
            border: none;
            border-radius: 4px;
            background-color: #2133f3;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            padding: 10px;
        }
        #mensajeCorreoExistente,
        #mensajeCodigoExistente {
            background-color: #dc3545;
            color: #fff;
            padding: 6px;
            margin-bottom: 6px;
            border-radius: 3px;
            font-size: 14px;
            display: none;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center;">Registro para nuevos usuarios</h2>
        <form id="registroForm" method="post" action="usuarios_salva.php" enctype="multipart/form-data">
            <input type="text" id="codigo" name="codigo" placeholder="Código de UDG" required><br>
            <input type="text" name="nombre" placeholder="Nombre de usuario" required><br>
            <input type="password" name="pass" placeholder="Contraseña" required><br>
            <input type="text" name="carrera" placeholder="Carrera" required><br>
            <input type="email" id="correo" name="correo" placeholder="Correo electrónico" pattern=".+@alumnos.udg.mx" value="@alumnos.udg.mx" title="Por favor, introduce una dirección de correo electrónico institucional." required><br>
            <input type="text" name="fecha_in" placeholder="Fecha de ingreso"><br>

            <h7>Agrega tu foto de perfil:</h7>
            <input type="file" id="archivo_fotoP" name="archivo_fotoP"><br><br>
            <h7>Agrega una foto de tu credencial UDG:</h7>
            <input type="file" id="archivo_fotoC" name="archivo_fotoC"><br><br>

            <div id="mensajeCorreoExistente"></div>
            <div id="mensajeCodigoExistente"></div>

            <input type="submit" value="Guardar" />
        </form>
    </div>

    <script>
        var correoExistente = false;
        var codigoExistente = false;

        $(document).ready(function() {
            $('#correo').on('blur', function() {
                var correo = $(this).val();
                $.ajax({
                    url: 'validar_correo.php',
                    method: 'POST',
                    data: {correo: correo},
                    success: function(response) {
                        if (response === 'si') {
                            correoExistente = true;
                            $('#mensajeCorreoExistente').html('El correo ' + correo + ' ya existe, registre un correo nuevo válido.').show();
                            setTimeout(function() {
                                $('#mensajeCorreoExistente').hide();
                            }, 5000);
                        } else {
                            correoExistente = false;
                            $('#mensajeCorreoExistente').hide();
                        }
                    }
                });
            });

            $('#codigo').on('blur', function() {
                var codigo = $(this).val();
                $.ajax({
                    url: 'validar_codigo.php',
                    method: 'POST',
                    data: {codigo: codigo},
                    success: function(response) {
                        if (response === 'si') {
                            codigoExistente = true;
                            $('#mensajeCodigoExistente').html('El código ' + codigo + ' ya existe, registre un código nuevo válido.').show();
                            setTimeout(function() {
                                $('#mensajeCodigoExistente').hide();
                            }, 5000);
                        } else {
                            codigoExistente = false;
                            $('#mensajeCodigoExistente').hide();
                        }
                    }
                });
            });

            $('#registroForm').on('submit', function(event) {
                if (correoExistente || codigoExistente) {
                    event.preventDefault();
                    if (correoExistente) {
                        $('#mensajeCorreoExistente').html('Por favor, use un correo diferente.').show();
                    }
                    if (codigoExistente) {
                        $('#mensajeCodigoExistente').html('Por favor, use un código diferente.').show();
                    }
                }
            });
        });
    </script>
</body>
</html>
