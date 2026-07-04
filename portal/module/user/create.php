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
              <div class="position-relative">
                <input required type="password" name="password" class="form-control" minlength="6" placeholder="minimal 6 karakter" style="padding-right: 45px;">
                <button type="button" class="btn-toggle-password position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent text-secondary" style="padding: 10px; cursor: pointer; outline: none; z-index: 10;">
                  <i class="fa fa-eye-slash" style="font-size: 1rem;"></i>
                </button>
              </div>
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