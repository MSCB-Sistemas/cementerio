<!-- Modal para agregar nuevo deudo -->
<div class="modal fade" id="modalDeudo" tabindex="-1" aria-labelledby="modalDeudoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeudoLabel">Agregar Nuevo Deudo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formDeudo">
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="guardarDeudo">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar nueva parcela -->
<div class="modal fade" id="modalParcela" tabindex="-1" aria-labelledby="modalParcelaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalParcelaLabel">Agregar Nueva Parcela</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formParcela">
                    <div class="mb-3">
                        <label for="tipo_parcela" class="form-label">Tipo de Parcela</label>
                        <select class="form-select" id="tipo_parcela" name="tipo_parcela" required>
                            <option value="">Seleccione...</option>
                            <option value="1">Nicho</option>
                            <option value="2">Tierra</option>
                            <option value="3">Mausoleo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="numero_ubicacion" class="form-label">Número/Ubicación</label>
                        <input type="text" class="form-control" id="numero_ubicacion" name="numero_ubicacion" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="hilera" class="form-label">Hilera</label>
                            <input type="text" class="form-control" id="hilera" name="hilera">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="seccion" class="form-label">Sección</label>
                            <input type="text" class="form-control" id="seccion" name="seccion">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fraccion" class="form-label">Fracción</label>
                            <input type="text" class="form-control" id="fraccion" name="fraccion">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nivel" class="form-label">Nivel</label>
                            <input type="text" class="form-control" id="nivel" name="nivel">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="guardarParcela">Guardar</button>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Cargar datos iniciales via AJAX
        cargarDeudos();
        cargarParcelas();

        // Cuando se selecciona un deudo, cargar sus deudas
        $('#deudo').change(function() {
            const idDeudo = $(this).val();
            if (idDeudo) {
                cargarResumenDeudas(idDeudo);
            } else {
                $('#resumenDeudas').html('<p class="text-center">Seleccione un deudo para ver el resumen de deudas</p>');
            }
        });

        // Cuando selecciono un difunto -> traer historial/ubicación
        $('#difunto').change(function () {
            const idDifunto = $(this).val();
            if (idDifunto) {
                $.get('ajax/info_difunto.php', { id_difunto: idDifunto }, function (response) {
                    $('#infoDifunto').html(response.html);
                }).fail(function () {
                    $('#infoDifunto').html('<p class="text-danger">Error al cargar la información del difunto.</p>');
                });
            } else {
                $('#infoDifunto').empty();
            }
        });

        // Cuando selecciono una parcela -> verificar disponibilidad/pagos
        $('#parcela').change(function () {
            const idParcela = $(this).val();
            if (idParcela) {
                $.get('ajax/info_parcela.php', { id_parcela: idParcela }, function (response) {
                    $('#infoParcela').html(response.html);
                }).fail(function () {
                    $('#infoParcela').html('<p class="text-danger">Error al cargar la información de la parcela.</p>');
                });
            } else {
                $('#infoParcela').empty();
            }
        });

        // Cuando se cambia el tipo de pago, actualizar detalles
        $('#tipo_pago').change(function() {
            actualizarDetallesPago();
        });

        // Cuando se cambia el monto, actualizar detalles
        $('#monto').on('input', function() {
            actualizarDetallesPago();
        });

        // Guardar nuevo deudo via AJAX
        $('#guardarDeudo').click(function() {
            const formData = $('#formDeudo').serialize();
            
            $.ajax({
                url: 'ajax/guardar_deudo.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Cerrar modal y recargar deudos
                        $('#modalDeudo').modal('hide');
                        cargarDeudos();
                        // Seleccionar el nuevo deudo
                        $('#deudo').val(response.id);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error al guardar el deudo');
                }
            });
        });

        // Guardar nueva parcela via AJAX
        $('#guardarParcela').click(function() {
            const formData = $('#formParcela').serialize();
            
            $.ajax({
                url: 'ajax/guardar_parcela.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Cerrar modal y recargar parcelas
                        $('#modalParcela').modal('hide');
                        cargarParcelas();
                        // Seleccionar la nueva parcela
                        $('#parcela').val(response.id);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error al guardar la parcela');
                }
            });
        });

        // Enviar formulario de pago via AJAX
        $('#pagoForm').submit(function(e) {
            e.preventDefault();
            
            const formData = $(this).serialize();
            
            $.ajax({
                url: 'ajax/registrar_pago.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert('Pago registrado correctamente');
                        $('#pagoForm')[0].reset();
                        $('#resumenDeudas').html('<p class="text-center">Seleccione un deudo para ver el resumen de deudas</p>');
                    } else {
                        mostrarErrores(response.errors);
                    }
                },
                error: function() {
                    alert('Error al registrar el pago');
                }
            });
        });

        // Función para cargar deudos via AJAX
        function cargarDeudos() {
            $.ajax({
                url: 'ajax/cargar_deudos.php',
                type: 'GET',
                success: function(response) {
                    $('#deudo').html('<option value="">Seleccione un deudo...</option>');
                    response.forEach(function(deudo) {
                        $('#deudo').append(
                            '<option value="' + deudo.id_deudo + '">' + 
                            deudo.dni + ' - ' + deudo.nombre + ' ' + deudo.apellido + 
                            '</option>'
                        );
                    });
                },
                error: function() {
                    alert('Error al cargar los deudos');
                }
            });
        }

        // Función para cargar parcelas via AJAX
        function cargarParcelas() {
            $.ajax({
                url: 'ajax/cargar_parcelas.php',
                type: 'GET',
                success: function(response) {
                    $('#parcela').html('<option value="">Seleccione una parcela...</option>');
                    response.forEach(function(parcela) {
                        $('#parcela').append(
                            '<option value="' + parcela.id_parcela + '">' + 
                            parcela.id_parcela + ' - ' + parcela.tipo + ' - ' + 
                            parcela.numero_ubicacion + ' - ' + 
                            (parcela.hilera ? parcela.hilera + '/' : '') +
                            (parcela.seccion ? parcela.seccion + '/' : '') +
                            (parcela.fraccion ? parcela.fraccion + '/' : '') +
                            (parcela.nivel || '') +
                            '</option>'
                        );
                    });
                },
                error: function() {
                    alert('Error al cargar las parcelas');
                }
            });
        }

        // Función para cargar resumen de deudas
        function cargarResumenDeudas(idDeudo) {
            $.ajax({
                url: 'ajax/cargar_resumen_deudas.php',
                type: 'GET',
                data: { id_deudo: idDeudo },
                success: function(response) {
                    let html = '<div class="table-responsive"><table class="table table-sm table-hover">';
                    html += '<thead><tr><th>Concepto</th><th>Vencimiento</th><th>Monto</th><th>Estado</th></tr></thead>';
                    html += '<tbody>';
                    
                    response.forEach(function(deuda) {
                        html += '<tr>';
                        html += '<td>' + deuda.concepto + '</td>';
                        html += '<td>' + deuda.vencimiento + '</td>';
                        html += '<td>$' + deuda.monto + '</td>';
                        html += '<td><span class="badge bg-' + (deuda.pagado ? 'success">Pagado' : 'danger">Pendiente') + '</span></td>';
                        html += '</tr>';
                    });
                    
                    html += '</tbody></table></div>';
                    $('#resumenDeudas').html(html);
                },
                error: function() {
                    $('#resumenDeudas').html('<p class="text-center text-danger">Error al cargar el resumen de deudas</p>');
                }
            });
        }

        // Función para actualizar detalles del pago
        function actualizarDetallesPago() {
            // Esta función podría calcular impuestos, comisiones, etc.
            const tipoPago = $('#tipo_pago').val();
            const monto = $('#monto').val() || 0;
            
            // Aquí podrías agregar lógica específica según el tipo de pago
        }

        // Función para mostrar errores
        function mostrarErrores(errors) {
            const errorList = $('#errorList');
            errorList.empty();
            
            errors.forEach(function(error) {
                errorList.append('<li>' + error + '</li>');
            });
            
            $('#errorContainer').removeClass('d-none');
        }
    });
</script>