<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IntercambioDeLibros.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-image: url('imagen7.jpg'); /* Cambia 'imagen.png' por la ruta de tu imagen */
            background-size: cover; /* Ajusta el tamaño de la imagen para cubrir todo el fondo */
            background-position: center; /* Centra la imagen en el fondo */
            background-repeat: no-repeat; /* Evita que la imagen se repita */
            color: #333; /* Cambia el color de texto a negro */
            display: flex;
            justify-content: flex-start; /* Alinea todo a la izquierda */
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        /* Estilos de la tarjeta */
        .card {
            background-color: rgba(255, 255, 255, 0.7); /* Mantenemos el fondo de la tarjeta con un color blanco semitransparente */
            border: none; /* Eliminamos el borde de la tarjeta */
            margin: auto;
        }
        /* Estilos para el texto Intercambio de libros */
        .title {
            font-style: normal; /* Aplicamos el estilo de fuente oblicuo */
            font-size: 300%; /* Aumentamos el tamaño de la fuente al 120% */
            font-family: Georgia, serif; /* Cambiamos el tipo de fuente */
            margin-bottom: 0; /* Eliminamos el margen inferior */
            text-align: center; /* Centramos el texto */
            color: white !important; /* Cambiamos el color del texto a blanco */
        }
        /* Agregamos un poco de margen en la parte superior del formulario */
        .form-container {
            margin-top: 5px;
        }
        .cursive-text {
            font-style: italic;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-start"> <!-- Alineamos todo a la izquierda -->
            <div class="col-lg-6">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-body">
                        <div class="form-container"> <!-- Nuevo contenedor del formulario -->
                            <form id="loginForm" method="POST" action="valLogin.php">
                                <div class="form-group">
                                    <label class="small mb-1" for="nombre">Nombre de usuario</label>
                                    <input class="form-control py-4" id="nombre" name="nombre" type="text" placeholder="Ingresa tu nombre de usuario" required />
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="contraseña">Contraseña</label>
                                    <input class="form-control py-4" id="contraseña" name="contraseña" type="password" placeholder="Ingresa tu contraseña" required />
                                </div>
                                <div class="form-group mt-4 mb-0">
                                    <button class="btn btn-primary btn-block" type="submit">Iniciar sesión</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <form method="POST" action="funciones/registrar.php">
                        <button type="submit" class="btn btn-info">Regístrate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault();
                var nombre = $('#nombre').val(); // Obtener el valor del campo nombre
                if (nombre === 'admin') { // Verificar si el nombre es 'admin'
                    window.location.href = 'Admin/usuarios_lista.php';
                } else {
                    var formData = $(this).serialize();
                    $.post('valLogin.php', formData, function(response) {
                        if (response.trim() === "success") {
                            window.location.href = 'funciones/pagPrincipal.php?nombre=' + nombre;
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error de inicio de sesión',
                                text: response,
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
