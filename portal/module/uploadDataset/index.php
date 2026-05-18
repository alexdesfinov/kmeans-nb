    <div class="row">
        <div class="col-sm-12">
            <?php
            requireAdmin();
            include_once 'aksi.php';
            ?>
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
                                    <label for="formFile" class="form-label" style="font-weight:600;font-size:0.82rem;">File Dataset</label>
                                    <div class="upload-zone" onclick="document.getElementById('formFile').click();">
                                        <div class="upload-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                                            </svg>
                                        </div>
                                        <p><strong>Klik untuk pilih file</strong><br><span style="font-size:0.78rem;">Format: CSV / Excel</span></p>
                                        <input type="file" class="d-none" id="formFile" name="filexls" accept=".xls, .xlsx, .csv" onchange="document.getElementById('fileName').textContent = this.files[0]?.name || ''">
                                    </div>
                                    <small id="fileName" style="font-weight:600;color:var(--fadel-primary,#1e293b);"></small>
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