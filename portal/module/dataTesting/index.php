<div class="row">
    <div class="col-sm-12">
        <?php
        require_admin();
        include_once __DIR__ . '/../../config/aksi.php';

        $query = mysqli_query($conn, "SELECT * FROM dataset_testing WHERE jenisData='testing'");
        ?>
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-3">
            <h4 class="mb-2 mb-md-0">Data Testing</h4><br>
            <form method="post" action="" class="form-hapus-semua">
                <input type="hidden" name="hapus_berdasarkan_jenis" value="1">
                <input type="hidden" name="jenisData" value="testing">
                <button type="submit" class="btn btn-danger btn-sm">Hapus Semua Testing</button>
            </form>
        </div>

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive p-0">
                        <table class="table" id="datatablesDataset">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" align="center">No</th>
                                    <th scope="col" align="center">Nama</th>
                                    <th scope="col" align="center">P1</th>
                                    <th scope="col" align="center">P2</th>
                                    <th scope="col" align="center">P3</th>
                                    <th scope="col" align="center">P4</th>
                                    <th scope="col" align="center">P5</th>
                                    <th scope="col" align="center">P6</th>
                                    <th scope="col" align="center">P7</th>
                                    <th scope="col" align="center">P8</th>
                                    <th scope="col" align="center">P9</th>
                                    <th scope="col" align="center">P10</th>
                                    <th scope="col" align="center">P11</th>
                                    <th scope="col" align="center">P12</th>
                                    <th scope="col" align="center">P13</th>
                                    <th scope="col" align="center">P14</th>
                                    <th scope="col" align="center">P15</th>
                                    <th scope="col" align="center">P16</th>
                                    <th scope="col" align="center">P17</th>
                                    <th scope="col" align="center">P18</th>
                                    <th scope="col" align="center">P19</th>
                                    <th scope="col" align="center">P20</th>
                                    <th scope="col" align="center" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($query) > 0): ?>
                                    <?php $no = 1; ?>
                                    <?php while ($data = mysqli_fetch_assoc($query)): ?>
                                        <tr>
                                            <td align="center"><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($data['nama'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>

                                            <?php for ($i = 1; $i <= 20; $i++):
                                                $col = "p{$i}";
                                            ?>
                                                <td align="center"><?= htmlspecialchars(jawabanSingkat($data[$col] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                                            <?php endfor; ?>
                                            <td align="center" style="white-space: nowrap;">
                                                <a class="btn btn-sm btn-warning"
                                                    href="media.php?module=inputData&edit=1&id=<?= (int)$data['id'] ?>&jenis=testing">
                                                    Edit
                                                </a>

                                                <form method="post" action="" style="display:inline;" class="d-inline form-hapus-item">
                                                    <input type="hidden" name="hapus_item" value="1">
                                                    <input type="hidden" name="id" value="<?= (int)$data['id'] ?>">
                                                    <input type="hidden" name="jenis" value="testing">
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
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