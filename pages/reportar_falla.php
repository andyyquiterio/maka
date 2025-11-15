<?php
require_once __DIR__ . '/../config/conexion.php';
// Verificación de sesión
if (!isset($_SESSION['logged_in'])) {
    header('Location: ?page=login');
    exit;
}
// helper de escape
function esc($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

// Simular eventos para el select (sin BD)
$eventos = [
    ['id' => 1, 'name' => 'Boda Andrea & Marco - 15/12/2025'],
    ['id' => 2, 'name' => 'Evento Corporativo Flores - 20/11/2025'],
    ['id' => 3, 'name' => 'Fiesta Familiar - 05/01/2026']
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reportar Falla - Maka Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Header -->
  <div class="report-header">
    <div class="d-flex align-items-center">
      <a href="?page=configuraciones" class="btn btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
      </a>
      <div class="text-center flex-grow-1">
        <h5 class="mb-0 fw-bold text-success">Reportar Falla</h5>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container-fluid p-3">

    <!-- Icon Section -->
    <div class="icon-section">
      <i class="bi bi-exclamation-triangle report-icon"></i>
      <h4 class="mt-3">Reporta una Incidencia</h4>
      <p class="text-muted">Ayúdanos a mejorar reportando cualquier problema</p>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Form -->
    <form id="reportForm">

      <!-- Tipo de Incidencia -->
      <div class="report-card">
        <div class="form-group">
          <label for="incidentType" class="form-label">Tipo de Incidencia *</label>
          <select class="form-select" id="incidentType" name="incidentType" required>
            <option value="">Seleccionar tipo...</option>
            <option value="Daño">Daño</option>
            <option value="Pérdida">Pérdida</option>
            <option value="Robo">Robo</option>
            <option value="Retraso">Retraso</option>
            <option value="Otro">Otro</option>
          </select>
        </div>

        <div class="form-group" id="otherTypeGroup" style="display: none;">
          <label for="otherType" class="form-label">Especificar tipo</label>
          <input type="text" class="form-control" id="otherType" name="otherType" placeholder="Describe el tipo de incidencia">
        </div>
      </div>

      <!-- Severidad -->
      <div class="report-card">
        <div class="form-group">
          <label class="form-label">Severidad *</label>
          <div class="radio-group">
            <label class="radio-option" data-value="Baja">
              <input type="radio" name="severity" value="Baja" required>
              <span class="checkmark"></span>
              Baja
            </label>
            <label class="radio-option" data-value="Media">
              <input type="radio" name="severity" value="Media">
              <span class="checkmark"></span>
              Media
            </label>
            <label class="radio-option" data-value="Alta">
              <input type="radio" name="severity" value="Alta">
              <span class="checkmark"></span>
              Alta
            </label>
            <label class="radio-option" data-value="Crítica">
              <input type="radio" name="severity" value="Crítica">
              <span class="checkmark"></span>
              Crítica
            </label>
          </div>
        </div>
      </div>

      <!-- Descripción -->
      <div class="report-card">
        <div class="form-group">
          <label for="description" class="form-label">Descripción *</label>
          <textarea class="form-textarea" id="description" name="description" maxlength="1000" placeholder="Describe detalladamente la incidencia..." required></textarea>
          <div class="char-counter"><span id="charCount">0</span>/1000 caracteres</div>
        </div>
      </div>

      <!-- Evento Asociado -->
      <div class="report-card">
        <div class="form-group">
          <label for="eventId" class="form-label">Evento Asociado (opcional)</label>
          <select class="form-select" id="eventId" name="eventId">
            <option value="">Seleccionar evento...</option>
            <?php foreach($eventos as $evento): ?>
            <option value="<?php echo $evento['id']; ?>"><?php echo esc($evento['name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <!-- Fecha y Hora -->
      <div class="report-card">
        <div class="form-group">
          <label for="occurredAt" class="form-label">Fecha y Hora de Ocurrencia *</label>
          <input type="datetime-local" class="form-control" id="occurredAt" name="occurredAt" required>
        </div>
      </div>

      <!-- Ubicación -->
      <div class="report-card">
        <div class="form-group">
          <label for="location" class="form-label">Ubicación</label>
          <div class="input-group">
            <input type="text" class="form-control" id="location" name="location" placeholder="Dirección o descripción de la ubicación">
            <span class="input-icon"><i class="bi bi-geo-alt"></i></span>
          </div>
          <button type="button" class="btn btn-outline-secondary mt-2" id="getLocationBtn">
            <i class="bi bi-crosshair me-1"></i>Usar ubicación actual
          </button>
        </div>
      </div>

      <!-- Adjuntar Evidencias -->
      <div class="report-card">
        <div class="form-group">
          <label class="form-label">Adjuntar Evidencias</label>
          <div class="file-upload-area" id="fileUploadArea">
            <i class="bi bi-cloud-upload" style="font-size: 2rem; color: var(--accent);"></i>
            <p class="mt-2 mb-1">Arrastra archivos aquí o haz clic para seleccionar</p>
            <p class="text-muted small">Máximo 6 archivos, cada uno hasta 8MB (fotos, videos)</p>
            <input type="file" id="fileInput" class="file-input" multiple accept="image/*,video/*">
          </div>
          <div class="file-thumbs" id="fileThumbs"></div>
        </div>
      </div>

      <!-- Contacto Responsable -->
      <div class="report-card">
        <h6 class="mb-3">Contacto Responsable</h6>
        <div class="form-group">
          <label for="reporterName" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="reporterName" name="reporterName" value="Andrea Rossi" readonly>
        </div>
        <div class="form-group">
          <label for="reporterPhone" class="form-label">Teléfono</label>
          <input type="tel" class="form-control" id="reporterPhone" name="reporterPhone" value="+52 123 456 7890" readonly>
        </div>
      </div>

      <!-- Tips Section -->
      <div class="tips-section">
        <h6><i class="bi bi-lightbulb me-2"></i>Tips para un buen reporte</h6>
        <ul>
          <li>Adjunta evidencia clara: fotos antes/después del problema</li>
          <li>Describe exactamente qué sucedió y cuándo</li>
          <li>Incluye detalles específicos que ayuden a resolver el problema</li>
          <li>Si es posible, indica el impacto del problema</li>
        </ul>
      </div>

      <!-- Action Buttons -->
      <div class="d-grid gap-3 mt-4">
        <button type="button" class="btn btn-outline-pill" id="saveDraftBtn">
          <i class="bi bi-save me-1"></i>Guardar Borrador
        </button>
        <button type="button" class="btn btn-pill" id="submitBtn">
          <i class="bi bi-send me-1"></i>Enviar Reporte
        </button>
      </div>

    </form>

  </div>

  <!-- Modal de Confirmación -->
  <div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmar Envío</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de enviar este reporte? Se notificará al equipo correspondiente.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="confirmSubmitBtn">Enviar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Variables globales
    let selectedFiles = [];
    const maxFiles = 6;
    const maxFileSize = 8 * 1024 * 1024; // 8MB

    // Inicialización
    function init() {
      loadDraft();
      setupEventListeners();
      setDefaultDateTime();
    }

    // Cargar borrador desde localStorage
    function loadDraft() {
      const draft = localStorage.getItem('reportDraft');
      if (draft) {
        const data = JSON.parse(draft);
        // Restaurar campos del formulario
        Object.keys(data).forEach(key => {
          const element = document.getElementById(key) || document.querySelector(`[name="${key}"]`);
          if (element) {
            if (element.type === 'radio') {
              document.querySelector(`[name="${key}"][value="${data[key]}"]`).checked = true;
              updateRadioSelection(key, data[key]);
            } else if (element.type === 'checkbox') {
              element.checked = data[key];
            } else {
              element.value = data[key];
            }
          }
        });

        // Mostrar notificación de borrador recuperado
        showAlert('Borrador recuperado exitosamente', 'success');
      }
    }

    // Guardar borrador en localStorage
    function saveDraft() {
      const formData = new FormData(document.getElementById('reportForm'));
      const data = {};
      for (let [key, value] of formData.entries()) {
        data[key] = value;
      }
      localStorage.setItem('reportDraft', JSON.stringify(data));
      showAlert('Borrador guardado', 'success');
    }

    // Limpiar borrador
    function clearDraft() {
      localStorage.removeItem('reportDraft');
    }

    // Configurar event listeners
    function setupEventListeners() {
      // Tipo de incidencia
      document.getElementById('incidentType').addEventListener('change', function() {
        const otherGroup = document.getElementById('otherTypeGroup');
        otherGroup.style.display = this.value === 'Otro' ? 'block' : 'none';
      });

      // Radio buttons de severidad
      document.querySelectorAll('.radio-option').forEach(option => {
        option.addEventListener('click', function() {
          const radio = this.querySelector('input[type="radio"]');
          radio.checked = true;
          updateRadioSelection(radio.name, radio.value);
        });
      });

      // Contador de caracteres
      document.getElementById('description').addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length;
      });

      // Upload de archivos
      const fileInput = document.getElementById('fileInput');
      const uploadArea = document.getElementById('fileUploadArea');

      uploadArea.addEventListener('click', () => fileInput.click());
      uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
      });
      uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('dragover'));
      uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        handleFileSelect(e.dataTransfer.files);
      });

      fileInput.addEventListener('change', (e) => handleFileSelect(e.target.files));

      // Ubicación actual
      document.getElementById('getLocationBtn').addEventListener('click', getCurrentLocation);

      // Botones de acción
      document.getElementById('saveDraftBtn').addEventListener('click', saveDraft);
      document.getElementById('submitBtn').addEventListener('click', () => {
        if (validateForm()) {
          new bootstrap.Modal(document.getElementById('confirmModal')).show();
        }
      });

      document.getElementById('confirmSubmitBtn').addEventListener('click', handleSubmit);
    }

    // Actualizar selección de radio
    function updateRadioSelection(name, value) {
      document.querySelectorAll(`[name="${name}"]`).forEach(radio => {
        const option = radio.closest('.radio-option');
        if (radio.value === value) {
          option.classList.add('selected');
        } else {
          option.classList.remove('selected');
        }
      });
    }

    // Manejar selección de archivos
    function handleFileSelect(files) {
      Array.from(files).forEach(file => {
        if (selectedFiles.length >= maxFiles) {
          showAlert(`Máximo ${maxFiles} archivos permitidos`, 'warning');
          return;
        }

        if (file.size > maxFileSize) {
          showAlert(`Archivo ${file.name} es demasiado grande (máx. 8MB)`, 'error');
          return;
        }

        selectedFiles.push(file);
        displayFileThumb(file);
      });
    }

    // Mostrar thumbnail del archivo
    function displayFileThumb(file) {
      const thumbsContainer = document.getElementById('fileThumbs');
      const thumbDiv = document.createElement('div');
      thumbDiv.className = 'file-thumb';

      const removeBtn = document.createElement('button');
      removeBtn.className = 'remove-btn';
      removeBtn.innerHTML = '×';
      removeBtn.onclick = () => {
        selectedFiles = selectedFiles.filter(f => f !== file);
        thumbDiv.remove();
      };

      if (file.type.startsWith('image/')) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        thumbDiv.appendChild(img);
      } else if (file.type.startsWith('video/')) {
        const video = document.createElement('video');
        video.src = URL.createObjectURL(file);
        video.muted = true;
        thumbDiv.appendChild(video);
      }

      thumbDiv.appendChild(removeBtn);
      thumbsContainer.appendChild(thumbDiv);
    }

    // Obtener ubicación actual
    function getCurrentLocation() {
      if (!navigator.geolocation) {
        showAlert('Geolocalización no soportada por este navegador', 'error');
        return;
      }

      const btn = document.getElementById('getLocationBtn');
      btn.disabled = true;
      btn.innerHTML = '<i class="bi bi-arrow-repeat me-1"></i>Obteniendo...';

      navigator.geolocation.getCurrentPosition(
        (position) => {
          const { latitude, longitude } = position.coords;
          document.getElementById('location').value = `${latitude.toFixed(6)}, ${longitude.toFixed(6)}`;
          btn.disabled = false;
          btn.innerHTML = '<i class="bi bi-crosshair me-1"></i>Usar ubicación actual';
          showAlert('Ubicación obtenida correctamente', 'success');
        },
        (error) => {
          showAlert('Error al obtener ubicación: ' + error.message, 'error');
          btn.disabled = false;
          btn.innerHTML = '<i class="bi bi-crosshair me-1"></i>Usar ubicación actual';
        }
      );
    }

    // Validar formulario
    function validateForm() {
      const requiredFields = ['incidentType', 'severity', 'description', 'occurredAt'];
      let isValid = true;

      requiredFields.forEach(field => {
        const element = document.getElementById(field);
        if (!element.value.trim()) {
          element.style.borderColor = 'var(--danger)';
          isValid = false;
        } else {
          element.style.borderColor = 'var(--border-color)';
        }
      });

      const description = document.getElementById('description');
      if (description.value.length < 10) {
        showAlert('La descripción debe tener al menos 10 caracteres', 'error');
        isValid = false;
      }

      if (!isValid) {
        showAlert('Por favor completa todos los campos requeridos', 'error');
      }

      return isValid;
    }

    // Subir archivos (simulado)
    async function uploadFiles(files) {
      const uploadedUrls = [];
      const progressBar = document.createElement('div');
      progressBar.className = 'progress-bar';
      progressBar.innerHTML = '<div class="progress-fill" id="uploadProgress"></div>';

      document.getElementById('alertContainer').appendChild(progressBar);

      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        try {
          // Simular subida (en producción: fetch POST /api/uploads)
          await new Promise(resolve => setTimeout(resolve, 1000)); // Simular delay
          const url = `https://api.maka.com/uploads/${Date.now()}_${file.name}`;
          uploadedUrls.push(url);

          // Actualizar progreso
          const progress = ((i + 1) / files.length) * 100;
          document.getElementById('uploadProgress').style.width = progress + '%';

        } catch (error) {
          console.error('Error subiendo archivo:', error);
          showAlert(`Error subiendo ${file.name}`, 'error');
        }
      }

      progressBar.remove();
      return uploadedUrls;
    }

    // Manejar envío del formulario
    async function handleSubmit() {
      const submitBtn = document.getElementById('confirmSubmitBtn');
      const originalText = submitBtn.textContent;
      submitBtn.disabled = true;
      submitBtn.textContent = 'Enviando...';

      try {
        // Subir archivos primero
        let attachmentUrls = [];
        if (selectedFiles.length > 0) {
          attachmentUrls = await uploadFiles(selectedFiles);
        }

        // Preparar payload
        const formData = new FormData(document.getElementById('reportForm'));
        const payload = {
          type: formData.get('incidentType') === 'Otro' ? formData.get('otherType') : formData.get('incidentType'),
          severity: formData.get('severity'),
          description: formData.get('description'),
          event_id: formData.get('eventId') || null,
          occurred_at: formData.get('occurredAt'),
          location: {
            address: formData.get('location'),
            // En producción: agregar lat/lng si se obtuvo geolocalización
          },
          attachments: attachmentUrls,
          reporter_id: 1 // Simulado
        };

        // Enviar reporte (simulado)
        console.log('Enviando payload:', payload);
        await new Promise(resolve => setTimeout(resolve, 2000)); // Simular API call

        // Éxito
        clearDraft();
        showAlert('Reporte enviado exitosamente', 'success');

        // Redirigir después de un delay
        setTimeout(() => {
          window.location.href = '?page=configuraciones';
        }, 2000);

      } catch (error) {
        console.error('Error enviando reporte:', error);
        showAlert('Error al enviar el reporte. Inténtalo de nuevo.', 'error');
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();
      }
    }

    // Mostrar alertas
    function showAlert(message, type = 'info') {
      const alertContainer = document.getElementById('alertContainer');
      const alertClass = type === 'success' ? 'alert-success' :
                        type === 'error' ? 'alert-danger' :
                        type === 'warning' ? 'alert-warning' : 'alert-info';

      const alert = document.createElement('div');
      alert.className = `alert ${alertClass} alert-dismissible fade show`;
      alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      `;

      alertContainer.appendChild(alert);

      // Auto-remover después de 5 segundos
      setTimeout(() => {
        if (alert.parentNode) {
          alert.remove();
        }
      }, 5000);
    }

    // Establecer fecha/hora por defecto
    function setDefaultDateTime() {
      const now = new Date();
      now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
      document.getElementById('occurredAt').value = now.toISOString().slice(0, 16);
    }

    // Inicializar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', init);
  </script>

</body>
</html>