    <div class="row">
        <div class="col-sm-12">
            <?php
            require_admin();
            include_once 'aksi.php';
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <h4>Dataset</h4><br>
                        <div class="form-group">
                            <label for="formFile">Masukkan Dokumen</label>
                            <input type="file" class="form-control" id="formFile" name="filexls">
                        </div>
                        <div class="form-group">
                            <label for="JenisData">Jenis Data</label>
                            <select class="form-control" id="JenisData" name="jenisData">
                                <option value="training">Data Training</option>
                                <option value="testing">Data Testing</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-success" value="Upload File">
                            <!-- <input type="submit" name="display" class="btn btn-danger" value="Display"> -->
                        </div>
                    </form>
                </div>
            </div>