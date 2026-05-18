    <div class="row">
        <div class="col-sm-12">
            <?php
            requireAdmin();
            include_once 'aksi.php';
            flashRenderAndClear();

            if (isset($_SESSION['import_errors'])) {
                $errors = $_SESSION['import_errors'];
                $title = $_SESSION['import_error_title'] ?? "Terjadi kesalahan saat import data.";
                unset($_SESSION['import_errors']);
                unset($_SESSION['import_error_title']);

                echo '<div class="alert alert-danger border-0 text-white font-weight-bold" style="background:#f43f5e; border-radius:12px; font-size:0.85rem; padding:12px 18px; margin-bottom:20px; animation: fadeInDown 0.3s ease-out;">';
                echo '<i class="fa fa-exclamation-circle me-2"></i><b>' . htmlspecialchars($title) . '</b>';
                echo '<ul class="mb-0 mt-2" style="padding-left:20px; font-weight: 500;">';
                foreach ($errors as $e) {
                    echo '<li>' . $e . '</li>';
                }
                echo '</ul>';
                echo '</div>';
            }
            ?>
            <style>
                .upload-zone-modern {
                    border: 2px dashed #cbd5e1;
                    border-radius: 16px;
                    background: #f8fafc;
                    padding: 35px 20px;
                    text-align: center;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    cursor: pointer;
                    position: relative;
                    overflow: hidden;
                }
                .upload-zone-modern:hover {
                    border-color: #64748b;
                    background: #f1f5f9;
                }
                .upload-zone-modern.drag-over {
                    border-color: #10b981;
                    background: #ecfdf5;
                    color: #047857;
                }
                .upload-zone-modern.drag-over .upload-icon-svg {
                    color: #10b981;
                    transform: translateY(-5px) scale(1.1);
                }
                .upload-zone-modern.file-selected {
                    border-color: #10b981;
                    border-style: solid;
                    background: #ecfdf5;
                    color: #065f46;
                }
                .upload-zone-modern.file-selected .upload-icon-svg {
                    color: #10b981;
                    animation: rubberBand 0.8s ease;
                }
                .upload-icon-svg {
                    color: #64748b;
                    transition: all 0.3s ease;
                    margin-bottom: 12px;
                }
                .upload-text {
                    font-size: 0.88rem;
                    font-weight: 600;
                    color: #334155;
                    margin-bottom: 4px;
                    display: block;
                    transition: color 0.3s;
                }
                .upload-subtext {
                    font-size: 0.75rem;
                    color: #64748b;
                    display: block;
                    transition: color 0.3s;
                }
                .upload-zone-modern.file-selected .upload-text {
                    color: #047857;
                }
                .upload-zone-modern.file-selected .upload-subtext {
                    color: #065f46;
                    font-weight: 600;
                }
                @keyframes rubberBand {
                    0% { transform: scale(1); }
                    30% { transform: scaleX(1.25) scaleY(0.75); }
                    40% { transform: scaleX(0.75) scaleY(1.25); }
                    50% { transform: scaleX(1.15) scaleY(0.85); }
                    65% { transform: scaleX(0.95) scaleY(1.05); }
                    75% { transform: scaleX(1.05) scaleY(0.95); }
                    100% { transform: scale(1); }
                }
            </style>
            <div class="row">
                <div class="col-lg-6 col-md-8">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon icon-shape icon-gradient-info shadow text-center border-radius-md d-inline-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 16 16">
                                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="mb-0" style="font-weight:700;">Upload Dataset</h5>
                                    <p class="mb-0" style="font-size:0.8rem;color:var(--fadel-secondary,#627594);">Upload file CSV berisi data responden</p>
                                </div>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label" style="font-weight:600;font-size:0.82rem;">File Dataset</label>
                                    <div class="upload-zone-modern" id="dropZone" onclick="document.getElementById('formFile').click();">
                                        <div class="upload-icon-svg" id="uploadIcon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                                            </svg>
                                        </div>
                                        <p class="mb-0">
                                            <strong class="upload-text" id="uploadText">Klik atau seret file ke sini</strong>
                                            <span class="upload-subtext" id="uploadSubtext">Format: CSV / Excel (.xls, .xlsx)</span>
                                        </p>
                                        <input type="file" class="d-none" id="formFile" name="filexls" accept=".xls, .xlsx, .csv">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="JenisData" class="form-label" style="font-weight:600;font-size:0.82rem;">Jenis Data</label>
                                    <select class="form-control" id="JenisData" name="jenisData" style="border-radius:12px;border:1.5px solid #e0e3e8;padding:10px 14px;">
                                        <option value="training">Data Training</option>
                                        <option value="testing">Data Testing</option>
                                    </select>
                                </div>
                                <input type="submit" name="submit" class="btn btn-primary w-100" value="Upload File" style="border-radius:12px;padding:12px;">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const dropZone = document.getElementById('dropZone');
                    const fileInput = document.getElementById('formFile');
                    const uploadText = document.getElementById('uploadText');
                    const uploadSubtext = document.getElementById('uploadSubtext');
                    const uploadIcon = document.getElementById('uploadIcon');

                    if (!dropZone || !fileInput) return;

                    // Prevent default drag behaviors
                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                        dropZone.addEventListener(eventName, preventDefaults, false);
                        document.body.addEventListener(eventName, preventDefaults, false);
                    });

                    // Highlight drop zone when item is dragged over it
                    ['dragenter', 'dragover'].forEach(eventName => {
                        dropZone.addEventListener(eventName, () => {
                            dropZone.classList.add('drag-over');
                        }, false);
                    });

                    ['dragleave', 'drop'].forEach(eventName => {
                        dropZone.addEventListener(eventName, () => {
                            dropZone.classList.remove('drag-over');
                        }, false);
                    });

                    // Handle dropped files
                    dropZone.addEventListener('drop', handleDrop, false);

                    // Handle selected files via click
                    fileInput.addEventListener('change', handleFileSelect, false);

                    function preventDefaults(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }

                    function handleDrop(e) {
                        const dt = e.dataTransfer;
                        const files = dt.files;

                        if (files.length > 0) {
                            fileInput.files = files;
                            updateUIWithFile(files[0]);
                        }
                    }

                    function handleFileSelect(e) {
                        const files = e.target.files;
                        if (files.length > 0) {
                            updateUIWithFile(files[0]);
                        }
                    }

                    function updateUIWithFile(file) {
                        dropZone.classList.add('file-selected');
                        
                        // Set dynamic selected icon (solid checkmark circle)
                        uploadIcon.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#10b981" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                        `;

                        uploadText.textContent = file.name;
                        
                        // Format size beautifully
                        const sizeInKb = (file.size / 1024).toFixed(1);
                        uploadSubtext.textContent = `File siap diunggah (${sizeInKb} KB) — Klik untuk mengganti`;
                    }
                });
            </script>