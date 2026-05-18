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
      <div class="card-header d-flex justify-content-between align-items-center" style="border-bottom:1px solid rgba(0,0,0,0.05);">
        <div class="d-flex align-items-center">
          <div class="icon icon-shape icon-gradient-primary shadow text-center border-radius-md d-inline-flex align-items-center justify-content-center me-3" style="width:42px;height:42px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
              <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
            </svg>
          </div>
          <div>
            <h6 class="mb-0" style="font-weight:700;">Master User</h6>
            <p class="mb-0" style="font-size:0.75rem;color:#627594;">Kelola akun pengguna sistem</p>
          </div>
        </div>
        <a class="btn btn-primary btn-sm" href="media.php?module=<?php echo urlencode($_GET['module']); ?>&act=create" style="border-radius:10px;">
          <i class="fa fa-plus me-1"></i>Tambah User
        </a>
      </div>

      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table table-hover align-middle" id="datatables">
            <thead>
              <tr>
                <th style="width:50px;">No</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Level</th>
                <th class="text-end" style="width:120px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              $q = mysqli_query($conn, "SELECT id, username, nama, level FROM users ORDER BY id DESC");
              while ($row = mysqli_fetch_assoc($q)) {
                $no++;
                $levelColor = $row['level'] === 'admin' ? 'background:rgba(203,12,159,0.1);color:#cb0c9f;' : 'background:rgba(23,193,232,0.1);color:#17c1e8;';
              ?>
                <tr>
                  <td><?php echo $no; ?></td>
                  <td style="font-weight:500;"><?php echo htmlspecialchars($row['username']); ?></td>
                  <td><?php echo htmlspecialchars($row['nama']); ?></td>
                  <td>
                    <span class="badge" style="<?= $levelColor ?>font-weight:600;font-size:0.72rem;border-radius:8px;padding:4px 12px;">
                      <?php echo htmlspecialchars(ucfirst($row['level'])); ?>
                    </span>
                  </td>
                  <td class="text-end">
                    <a class="btn btn-sm btn-warning" style="border-radius:8px;font-size:0.75rem;"
                      href="media.php?module=<?php echo urlencode($_GET['module']); ?>&act=edit&id=<?php echo (int)$row['id']; ?>"
                      title="Edit">
                      <i class="fa fa-pencil"></i>
                    </a>

                    <?php if ((int)$row['id'] !== (int)($_SESSION['id'] ?? 0)): ?>
                      <form method="POST"
                        action="<?php echo $aksi; ?>?module=<?php echo urlencode($_GET['module']); ?>&act=delete"
                        class="d-inline form-hapus-item">
                        <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus" style="border-radius:8px;font-size:0.75rem;">
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