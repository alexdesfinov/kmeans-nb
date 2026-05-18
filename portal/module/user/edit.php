<?php
requireAdmin();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
  setFlash('alert alert-danger', 'ID user tidak valid', 'fa fa-times');
  header('Location: media.php?module=' . urlencode($_GET['module']));
  exit;
}

$stmt = mysqli_prepare($conn, "SELECT id, username, nama, level FROM users WHERE id=? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res  = mysqli_stmt_get_result($stmt);
$u    = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if (!$u) {
  setFlash('alert alert-danger', 'User tidak ditemukan', 'fa fa-times');
  header('Location: media.php?module=' . urlencode($_GET['module']));
  exit;
}
?>

<div class="row">
  <div class="col-sm-12">
    <?php flashRenderAndClear(); ?>
  </div>

  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <h5>Edit User</h5>
      </div>

      <div class="card-body">
        <form method="POST" action="<?php echo $aksi; ?>?module=<?php echo urlencode($_GET['module']); ?>&act=edit" autocomplete="off">
          <input type="hidden" name="id" value="<?php echo (int)$u['id']; ?>">

          <div class="row">
            <div class="col-md-12 mb-3">
              <label>Username</label>
              <input type="text" class="form-control" value="<?php echo htmlspecialchars($u['username']); ?>" readonly>
              <small class="text-muted">Username dibuat read-only (menghindari bentrok unique).</small>
            </div>

            <div class="col-md-12 mb-3">
              <label>Password (opsional)</label>
              <input type="password" name="password" class="form-control" minlength="6" placeholder="Kosongkan jika tidak diganti">
            </div>

            <div class="col-md-12 mb-3">
              <label>Nama</label>
              <input required type="text" name="nama" class="form-control" maxlength="100" value="<?php echo htmlspecialchars($u['nama']); ?>">
            </div>

            <div class="col-md-12 mb-3">
              <label>Level</label>
              <select name="level" class="form-control" required>
                <option value="user" <?php echo ($u['level'] === 'user') ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo ($u['level'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
              </select>
            </div>

            <div class="col-md-12">
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
              <a href="media.php?module=<?php echo urlencode($_GET['module']); ?>" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>