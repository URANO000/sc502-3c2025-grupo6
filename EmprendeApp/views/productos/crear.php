<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">📤 Publicar un Producto</h2>
    <a href="index.php?action=dashboard-emprendedor" class="btn btn-outline-primary">🏠 Home</a>
</div>


<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card p-5 shadow-sm">
            <form method="POST" action="index.php?action=crear-producto" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nombre del Producto</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio</label>
                    <div class="input-group">
                        <span class="input-group-text">₡</span>
                        <input type="number" name="precio" class="form-control" step="0.01" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen del Producto</label>
                    <input type="file" name="imagen" class="form-control" accept="image/*" onchange="vistaPrevia(event)" required>
                    <div class="mt-3 text-center">
                        <img id="preview" src="#" alt="Vista previa de imagen" class="img-fluid d-none" style="max-height: 200px; border-radius: 8px;">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select" required>
                        <option value="1">Alimentos</option>
                        <option value="2">Artesanías</option>
                        <option value="3">Servicios</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-acento w-100">📦 Publicar</button>
            </form>
        </div>
    </div>
</div>

<!-- JS: Vista previa de imagen -->
<script>
    function vistaPrevia(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    }
</script>

<?php
$contenido = ob_get_clean();
$titulo = "Publicar Producto";
include 'views/layout.php';
?>
