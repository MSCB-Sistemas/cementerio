<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0"><?= $datos['title'] ?></h2>
        </div>
        
        <div class="card-body">
            <?php if (!empty($datos['errores'])): ?>
                <div class="alert alert-danger">
                    <h5 class="alert-heading">¡Error!</h5>
                    <ul class="mb-0">
                        <?php foreach ($datos['errores'] as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form action="<?= $datos['action'] ?>" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="id" value="<?= $values['id_deudo'] ?? '' ?>">
                
                <div class="row g-3">
                    <!-- Primera columna -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="dni" class="form-label fw-bold">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" 
                                   value="<?= htmlspecialchars($datos['values']['dni'] ?? '') ?>" required>
                            <div class="invalid-feedback">
                                Por favor ingrese el DNI
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                   value="<?= htmlspecialchars($datos['values']['nombre'] ?? '') ?>" required>
                            <div class="invalid-feedback">
                                Por favor ingrese el nombre
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="apellido" class="form-label fw-bold">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" 
                                   value="<?= htmlspecialchars($datos['values']['apellido'] ?? '') ?>" required>
                            <div class="invalid-feedback">
                                Por favor ingrese el apellido
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telefono" class="form-label fw-bold">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" 
                                   value="<?= htmlspecialchars($datos['values']['telefono'] ?? '') ?>" required>
                            <div class="invalid-feedback">
                                Por favor ingrese el teléfono
                            </div>
                        </div>
                    </div>
                    
                    <!-- Segunda columna -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= htmlspecialchars($datos['values']['email'] ?? '') ?>" required>
                            <div class="invalid-feedback">
                                Por favor ingrese un email válido
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="domicilio" class="form-label fw-bold">Domicilio</label>
                            <input type="text" class="form-control" id="domicilio" name="domicilio" 
                                   value="<?= htmlspecialchars($datos['values']['domicilio'] ?? '') ?>" required>
                            <div class="invalid-feedback">
                                Por favor ingrese el domicilio
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="localidad" class="form-label fw-bold">Localidad</label>
                            <input type="text" class="form-control" id="localidad" name="localidad" 
                                   value="<?= htmlspecialchars($datos['values']['localidad'] ?? '') ?>" required>
                            <div class="invalid-feedback">
                                Por favor ingrese la localidad
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="codigo_postal" class="form-label fw-bold">Código Postal</label>
                            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" 
                                   value="<?= htmlspecialchars($datos['values']['codigo_postal'] ?? '') ?>" required>
                            <div class="invalid-feedback">
                                Por favor ingrese el código postal
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="<?= URL ?>deudo" class="btn btn-outline-secondary me-md-2">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script para validación -->
<script>
// Ejemplo de validación de Bootstrap
(function () {
  'use strict'

  // Selecciona todos los formularios a los que queremos aplicar estilos de validación de Bootstrap
  var forms = document.querySelectorAll('.needs-validation')

  // Bucle sobre ellos y evitar el envío
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
</script>