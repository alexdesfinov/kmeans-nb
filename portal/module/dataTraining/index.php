<div class="row">
    <div class="col-sm-12">
        <?php
        requireAdmin();
        include_once __DIR__ . '/../../config/aksi.php';

        $query = mysqli_query($conn, "SELECT * FROM dataset_training WHERE jenisData='training'");
        $totalRows = mysqli_num_rows($query);
        ?>

        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-4">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="icon icon-shape icon-gradient-success shadow text-center border-radius-md d-inline-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 16 16">
                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m.5 10v-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5m-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="mb-0" style="font-weight:700;">Data Training</h5>
                    <p class="mb-0" style="font-size:0.78rem;color:#627594;">
                        <span class="badge" style="background:rgba(130,214,22,0.12);color:#2d8a0e;font-size:0.7rem;"><?= $totalRows ?> data</span>
                    </p>
                </div>
            </div>
            <form method="post" action="" class="form-hapus-semua">
                <input type="hidden" name="hapus_berdasarkan_jenis" value="1">
                <input type="hidden" name="jenisData" value="training">
                <button type="submit" class="btn btn-danger btn-sm" style="border-radius:10px;">
                    <i class="fa fa-trash me-1"></i>Hapus Semua
                </button>
            </form>
        </div>

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive p-0">
                        <table class="table table-hover align-middle" id="datatablesDataset">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="text-center" style="width:50px;">No</th>
                                    <th scope="col">Nama</th>
                                    <?php for ($i = 1; $i <= 20; $i++): ?>
                                        <th scope="col" class="text-center">P<?= $i ?></th>
                                    <?php endfor; ?>
                                    <th scope="col" class="text-center" style="width:130px;" data-orderable="false">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($totalRows > 0): ?>
                                    <?php $no = 1; ?>
                                    <?php while ($data = mysqli_fetch_assoc($query)): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td style="font-weight:500;"><?= htmlspecialchars($data['nama'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>

                                            <?php for ($i = 1; $i <= 20; $i++):
                                                $col = "p{$i}";
                                            ?>
                                                <td class="text-center" style="font-size:0.8rem;"><?= htmlspecialchars(jawabanSingkat($data[$col] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-center" style="white-space: nowrap;">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <a class="btn btn-sm btn-warning" style="border-radius:8px;font-size:0.75rem;margin:0;"
                                                        href="media.php?module=inputData&edit=1&id=<?= (int)$data['id'] ?>&jenis=training">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <form method="post" action="" style="display:inline-flex;margin:0;" class="d-inline-flex align-items-center form-hapus-item">
                                                        <input type="hidden" name="hapus_item" value="1">
                                                        <input type="hidden" name="id" value="<?= (int)$data['id'] ?>">
                                                        <input type="hidden" name="jenis" value="training">
                                                        <button type="submit" class="btn btn-sm btn-danger" style="border-radius:8px;font-size:0.75rem;margin:0;">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>