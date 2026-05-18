<?php
// pastikan hanya admin
require_admin();
?>

<div class="row">
  <div class="col-sm-12">
    <?php flash_render_and_clear(); ?>
  </div>

  <div class="col-sm-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <a class="btn btn-primary" href="media.php?module=<?php echo urlencode($_GET['module']); ?>&act=create">
          Tambah User
        </a>
      </div>

      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table display" id="datatables">
            <thead>
              <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Level</th>
                <th class="text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              $q = mysqli_query($conn, "SELECT id, username, nama, level FROM users ORDER BY id DESC");
              while ($row = mysqli_fetch_assoc($q)) {
                $no++;
              ?>
                <tr>
                  <td><?php echo $no; ?></td>
                  <td><?php echo htmlspecialchars($row['username']); ?></td>
                  <td><?php echo htmlspecialchars($row['nama']); ?></td>
                  <td><?php echo htmlspecialchars(ucfirst($row['level'])); ?></td>
                  <td class="text-end">
                    <a class="btn btn-primary btn-xs"
                      href="media.php?module=<?php echo urlencode($_GET['module']); ?>&act=edit&id=<?php echo (int)$row['id']; ?>"
                      title="Edit">
                      <i class="fa fa-pencil"></i>
                    </a>

                    <?php if ((int)$row['id'] !== (int)($_SESSION['id'] ?? 0)): ?>
                      <form method="POST"
                        action="<?php echo $aksi; ?>?module=<?php echo urlencode($_GET['module']); ?>&act=delete"
                        class="d-inline form-hapus-item">
                        <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-xs" title="Hapus">
                          <i class="fa fa-trash"></i>
                        </button>
                      </form>
                    <?php endif; ?>

                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div>