<?php
requireAdmin();
?>

<div class="row">
  <div class="col-sm-12">
    <?php flashRenderAndClear(); ?>
  </div>

  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <h5>Tambah User</h5>
      </div>

      <div class="card-body">
        <form method="POST" action="<?php echo $aksi; ?>?module=<?php echo urlencode($_GET['module']); ?>&act=create" autocomplete="off">
          <div class="row">
            <div class="col-md-12 mb-3">
              <label>Username</label>
              <input required type="text" name="username" class="form-control" maxlength="100" placeholder="contoh: alex">
            </div>

            <div class="col-md-12 mb-3">
              <label>Password</label>
              <input required type="password" name="password" class="form-control" minlength="6" placeholder="minimal 6 karakter">
            </div>

            <div class="col-md-12 mb-3">
              <label>Nama</label>
              <input required type="text" name="nama" class="form-control" maxlength="100" placeholder="Nama lengkap">
            </div>

            <div class="col-md-12 mb-3">
              <label>Level</label>
              <select name="level" class="form-control" required>
                <option value="user" selected>User</option>
                <option value="admin">Admin</option>
              </select>
            </div>

            <div class="col-md-12">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="media.php?module=<?php echo urlencode($_GET['module']); ?>" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>