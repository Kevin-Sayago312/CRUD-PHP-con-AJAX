<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD con PHP, AJAX, PDO, DATATABLE.S</title>

  <!-- EMPIEZA EL LINK PARA AGREGAR NUESTRA HOJA DE ESTILOS -->
  <link rel="stylesheet" href="css/estilos.css">
  <!-- TERMINA EL LINK PARA AGREGAR NUESTRA HOJA DE ESTILOS -->

  <!-- EMPIEZA EL LINK DE CSS Y EL LINK DE JS DE BOOTSTRAP -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- TERMINA EL LINK DE CSS Y EL LINK DE JS DE BOOTSTRAP -->

  <!-- EMPIEZA EL LINK PARA AGREGAR LOS ICONOS DE BOOTSTRAP -->
  <link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
  <!-- TERMINA EL LINK PARA AGREGAR LOS ICONOS DE BOOTSRAP -->

  <!-- EMPIEZA EL LINK PARA AGREGAR JQUERY -->
  <script src="JavaScript/jquery.js"> </script>
  <!-- TERMINA EL LINK PARA AGREGAR JQUERY -->

  <!-- EMPIEZA EL LINK Y SCRIPT PARA DATA TABLES -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />
  <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
  <!-- TERMINA LINK Y SCRIPT PARA DATA TABLES -->

</head>

<body class="bg-dark">
  <div class="container fondo">
    <h1 class="text-center">CRUD con PHP, AJAX y DATATABLES.JS</h1>
    <div class="row">
      <div class="col-2 offset-10">
        <div class="text-center">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalUsuario" id="botonCrear">
            <i class="bi bi-plus-circle-fill"></i> Crear
          </button>
        </div>
      </div>

      <br />
      <br />

      <div class="table-responsive">
        <table id="datos_usuario" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Apellidos</th>
              <th>Teléfono</th>
              <th>Email</th>
              <th>Imagen</th>
              <th>Fecha de creación</th>
              <th>Editar</th>
              <th>Borrar</th>
            </tr>
          </thead>
        </table>
      </div>

      <!-- MODAL -->
      <div class="modal fade" id="modalUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar usuario</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" method="POST" id="formulario" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-body">
                  <label for="nombre">Ingresa un nombre</label>
                  <input type="text" name="nombre" id="nombre" class="form-control">
                  <br />

                  <label for="apellidos">Ingresa los apellidos</label>
                  <input type="text" name="apellidos" id="apellidos" class="form-control">
                  <br />

                  <label for="telefono">Ingresa el teléfono</label>
                  <input type="number" name="telefono" id="telefono" class="form-control">
                  <br />

                  <label for="email">Ingresa un email</label>
                  <input type="email" name="email" id="email" class="form-control">
                  <br />

                  <label for="imagen">Ingresa una imagen</label>
                  <input type="file" name="imagen_usuario" id="imagen_usuario" class="form-control">
                  <span id="imagen_subida"></span>
                  <br />
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="id_usuario" id="id_usuario">
                  <input type="hidden" name="operacion" id="operacion">
                  <input type="submit" name="action" id="action" class="btn btn-success" value="Crear">
                </div>
              </div>
            </form>


          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#botonCrear").click(function() {
        $("#formulario")[0].reset();
        $(".modal-title").text("Crear usuario");
        $("#action").val("Crear");
        $("#operacion").val("Crear");
        $("#imagen_subida").html("");

      })

      var dataTable = $('#datos_usuario').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
          url: "obtener_registros.php",
          type: "POST"
        },
        "columnsDefs": [{
          "targets": [0, 3, 4],
          "orderable": false
        }, ],
        "language": {
          "sProcessing": "Procesando...",
          "sLengthMenu": "Mostrar _MENU_ registros",
          "sZeroRecords": "No se encontraron resultados",
          "sEmptyTable": "Ningún dato disponible en esta tabla",
          "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix": "",
          "sSearch": "Buscar:",
          "sUrl": "",
          "sInfoThousands": ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
          },
          "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          },
          "buttons": {
            "copy": "Copiar",
            "colvis": "Visibilidad"
          }
        }
      });
      // AQUI VA EL CODIGO DE INSERTAR DATOS
      $(document).on('submit', '#formulario', function(event) {
        event.preventDefault();
        var nombres = $("#nombre").val();
        var apellidos = $("#apellidos").val();
        var telefono = $("#telefono").val();
        var email = $("#email").val();
        var extension = $("#imagen_usuario").val().split('.').pop().toLowerCase();

        if (extension != '') {
          if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpge']) == -1) {
            alert("Formato inválido");
            $('#imagen_usuario').val('');
            return false;
          }
        }

        if (nombres !== '' && apellidos !== '' && email !== '') {
          $.ajax({
            url: "crear.php",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(data) {
              alert(data);
              $('#formulario')[0].reset();
              $('#modalUsuario').modal('hide');
              dataTable.ajax.reload();
            }
          });
        } else {
          alert("Algunos campos son obligatorios");
        }
      });


      // FUNCIONALIDAD DE EDITAR
      $(document).on('click', '.editar', function() {
        var id_usuario = $(this).attr("id");
        $.ajax({
          url: "obtener_registro.php",
          method: "POST",
          data: {
            id_usuario: id_usuario
          },
          dataType: "json",
          success: function(data) {
            $('#modalUsuario').modal('show');
            $('#nombre').val(data.nombre);
            $('#apellidos').val(data.apellidos);
            $('#telefono').val(data.telefono);
            $('#email').val(data.email);
            $('.modal-title').text("Editar Usuario");
            $('#id_usuario').val(id_usuario);
            $('#imagen_subida').html(data.imagen_usuario);
            $('#action').val("Editar");
            $('#operacion').val("Editar");
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown)
          }
        })
      });

      // FUNCIONALIDAD DE BORRAR
      $(document).on('click', '.borrar', function() {
        var id_usuario = $(this).attr("id");
        if (confirm("Esta seguro de borrar este registro: " + id_usuario)) {
          $.ajax({
            url: "borrar.php",
            method: "POST",
            data: {
              id_usuario: id_usuario
            },
            success: function(data) {
              alert(data);
              dataTable.ajax.reload();
            }
          });
        } else {
          return false;
        }
      });

    });
  </script>


</body>

</html>