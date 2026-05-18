<?php

function UploadProfile($fupload_name)
{

	$vdir_upload = "../../images/profile/";

	$vfile_upload = $vdir_upload . $fupload_name;

	move_uploaded_file($_FILES["images"]["tmp_name"], $vfile_upload);
}

function UploadProduk($fupload_name)
{

	$vdir_upload = "../../assets/images/produk/";

	$vfile_upload = $vdir_upload . $fupload_name;

	return move_uploaded_file($_FILES["img"]["tmp_name"], $vfile_upload);
}

function UploadDirectory($fupload_name, $directory)
{

	$vdir_upload = "../../assets/images/" . $directory . "/";

	$vfile_upload = $vdir_upload . $fupload_name;

	move_uploaded_file($_FILES["images"]["tmp_name"], $vfile_upload);
}

function dateIndonesian($date)
{

	$array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');

	$array_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

	$date  = strtotime($date);

	$hari  = $array_hari[date('N', $date)];

	$tanggal = date('j', $date);

	$bulan = $array_bulan[date('n', $date)];

	$tahun = date('Y', $date);

	$formatTanggal = $hari . ", " . $tanggal . " " . $bulan . " " . $tahun;

	return $formatTanggal;
}

function hari($value)

{

	$array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');

	return $array_hari[$value];
}

function bulan($bln)

{

	if ($bln == 1) {
		$string = "Januari";
	} elseif ($bln == 2) {
		$string = "Februari";
	} elseif ($bln == 3) {
		$string = "Maret";
	} elseif ($bln == 4) {
		$string = "April";
	} elseif ($bln == 5) {
		$string = "Mei";
	} elseif ($bln == 6) {
		$string = "Juni";
	} elseif ($bln == 7) {
		$string = "Juli";
	} elseif ($bln == 8) {
		$string = "Agustus";
	} elseif ($bln == 9) {
		$string = "September";
	} elseif ($bln == 10) {
		$string = "Oktober";
	} elseif ($bln == 11) {
		$string = "November";
	} elseif ($bln == 12) {
		$string = "Desember";
	}

	return $string;
}

function usernameInitial($text)

{

	$string = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '.', $text)));

	return $string;
}

function timeElapsed($time_ago)
{

	$time_ago = strtotime($time_ago);

	$cur_time   = time();

	$time_elapsed   = $cur_time - $time_ago;

	$seconds    = $time_elapsed;

	$minutes    = round($time_elapsed / 60);

	$hours      = round($time_elapsed / 3600);

	$days       = round($time_elapsed / 86400);

	$weeks      = round($time_elapsed / 604800);

	$months     = round($time_elapsed / 2600640);

	$years      = round($time_elapsed / 31207680);

	if ($seconds <= 60) {

		return "sesaat lalu";
	} else if ($minutes <= 60) {

		if ($minutes == 1) {

			return "satu menit lalu";
		} else {

			return "$minutes menit lalu";
		}
	} else if ($hours <= 24) {

		if ($hours == 1) {

			return "satu jam lalu";
		} else {

			return "$hours jam lalu";
		}
	} else if ($days <= 7) {

		if ($days == 1) {

			return "kemarin";
		} else {

			return "$days hari lalu";
		}
	} else if ($weeks <= 4.3) {

		if ($weeks == 1) {

			return "seminggu lalu";
		} else {

			return "$weeks minggu lalu";
		}
	} else if ($months <= 12) {

		if ($months == 1) {

			return "sebulan lalu";
		} else {

			return "$months bulan lalu";
		}
	} else {

		if ($years == 1) {

			return "setahun lalu";
		} else {

			return "$years tahun lalu";
		}
	}
}

function haversineLabel($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)

{

	// convert from degrees to radians

	$latFrom = deg2rad($latitudeFrom);

	$lonFrom = deg2rad($longitudeFrom);

	$latTo = deg2rad($latitudeTo);

	$lonTo = deg2rad($longitudeTo);



	$latDelta = $latTo - $latFrom;

	$lonDelta = $lonTo - $lonFrom;



	$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

	$string = "2 * arcsin(√(sin<sup>2</sup>((" . $latFrom . " - " . $latTo . ")/2) + cos(" . $latFrom . ") cos(" . $latTo . ") sin<sup>2</sup>((" . $lonFrom . " - " . $lonTo . ")/2)) * EarthRadius " . $earthRadius;

	return $string;
}

function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)

{

	// convert from degrees to radians

	$latFrom = deg2rad($latitudeFrom);

	$lonFrom = deg2rad($longitudeFrom);

	$latTo = deg2rad($latitudeTo);

	$lonTo = deg2rad($longitudeTo);



	$latDelta = $latTo - $latFrom;

	$lonDelta = $lonTo - $lonFrom;



	$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

	return $angle * $earthRadius;
}

function tf($value)

{

	return $value == 1 || $value === true ? 'Yes' : 'No';
}


//================================================================	LOGIKA	============================================================//

// Konversi petanyaan ke angka
function jawabanKeAngka(string $s): int
{
	$x = strtolower(trim($s));
	$x = str_replace(['_', '-'], ' ', $x);
	$x = preg_replace('/\s+/', ' ', $x);

	return match ($x) {
		'tidak pernah'     => 0,
		'jarang'           => 1,
		'kadang kadang', 'kadang-kadang' => 2,
		'sering'           => 3,
		'sangat sering'    => 4,
		'selalu'           => 5,
		default => throw new InvalidArgumentException("Nilai jawaban tidak valid: $s"),
	};
}

function jawabanKeAngkaFlexible(string $s): int
{
	$x = strtoupper(trim($s));
	if ($x === "TP") return 0;
	if ($x === "J")  return 1;
	if ($x === "KK") return 2;
	if ($x === "S")  return 3;
	if ($x === "SS") return 4;
	if ($x === "SL") return 5;

	// fallback ke versi teks panjang
	return jawabanKeAngka($s);
}

// Maping kategori ke pertanyaan
function kategoriMap(): array
{
	return [
		'k1'   => ['p1', 'p7', 'p15'],
		'k2' => ['p2', 'p6', 'p17'],
		'k3' => ['p3', 'p4', 'p8', 'p11', 'p12', 'p19'],
		'k4'     => ['p5', 'p9', 'p10'],
		'k5'  => ['p13', 'p16', 'p18'],
		'k6'  => ['p14', 'p20'],
	];
}

// Ambil data dari database berdasarkan Jenis
function fetchDatasetByJenis(mysqli $conn, string $jenis, string $table = "dataset", string $colJenis = "jenisData"): array
{
	$jenis = ($jenis === 'training') ? 'training' : 'testing';
	$sql = "SELECT * FROM {$table} WHERE {$colJenis}=? ORDER BY id ASC";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s", $jenis);
	$stmt->execute();
	$res = $stmt->get_result();
	$rows = [];
	while ($r = $res->fetch_assoc()) $rows[] = $r;
	$stmt->close();
	return $rows;
}

// === Save Centeroid ke DB ===
function saveCentroidsToDB(mysqli $conn, array $centroidVectors, array $sourceIds): void
{
	// reset isi centroid supaya sesuai C1..C4 terbaru
	mysqli_query($conn, "TRUNCATE TABLE centroid");

	$stmt = $conn->prepare("INSERT INTO centroid (id_centroid, source_id, data_centroid) VALUES (?, ?, ?)");

	foreach ($centroidVectors as $i => $vec) {
		$idCent = $i + 1;                  // 1..k
		$srcId  = (int)($sourceIds[$i] ?? 0);

		// simpan sebagai "a,b,c,d,e,f"
		$data = implode(',', array_map(fn($v) => (string)round((float)$v, 4), $vec));

		$stmt->bind_param("iis", $idCent, $srcId, $data);
		$stmt->execute();
	}

	$stmt->close();
}

// === Ambil Souce Centeroid ===
function getCentroidSources(mysqli $conn): array
{
	$map = []; // [id_centroid => source_id]
	$sql = "SELECT id_centroid, source_id FROM centroid ORDER BY id_centroid ASC";
	$res = $conn->query($sql);
	if (!$res) return $map;

	while ($r = $res->fetch_assoc()) {
		$map[(int)$r['id_centroid']] = (int)($r['source_id'] ?? 0);
	}
	return $map;
}

// Ambil Centeroid dari DB
function getInitialCentroidsFromDB(mysqli $conn): array
{
	$centroids = [];

	$sql = "SELECT data_centroid FROM centroid ORDER BY id_centroid ASC";
	$res = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($res)) {
		$vector = array_map(
			'floatval',
			explode(',', $row['data_centroid'])
		);
		$centroids[] = $vector;
	}

	return $centroids; // [[c1..c6], [c1..c6], ...]
}

function rowToVectorKategori(array $row): array
{
	$fitur = [];
	foreach (kategoriMap() as $kat => $listP) {
		$sum = 0;
		foreach ($listP as $p) {
			$sum += jawabanKeAngkaFlexible($row[$p] ?? 'TP');
		}
		$fitur[] = $sum; // ⚠️ urutan array penting
	}
	return $fitur;
}

function kategoriExcel(int $nilai): int
{
	if ($nilai <= 3)  return 0; // Sangat Rendah
	if ($nilai <= 7)  return 1; // Rendah
	if ($nilai <= 10) return 2; // Sedang
	if ($nilai <= 13) return 3; // Tinggi
	return 4;                   // Sangat Tinggi
}

function rowToVectorKategoriNB(array $row): array
{
	// ambil dulu angka mentah K1..K6 dari fungsi lama
	$raw = rowToVectorKategori($row);

	// lalu diskritisasi seperti Excel
	return array_map(fn($v) => kategoriExcel((int)$v), $raw);
}

function euclidSq(array $a, array $b): float
{
	$sum = 0.0;
	$n = count($a);
	for ($i = 0; $i < $n; $i++) {
		$d = $a[$i] - $b[$i];
		$sum += $d * $d;
	}
	return $sum;
}

function kmeansInitPlusPlus(array $X, int $k): array
{
	$n = count($X);
	$centroids = [];
	$centroids[] = $X[random_int(0, $n - 1)];

	while (count($centroids) < $k) {
		$dists = [];
		$sum = 0.0;
		foreach ($X as $x) {
			$best = INF;
			foreach ($centroids as $c) $best = min($best, euclidSq($x, $c));
			$dists[] = $best;
			$sum += $best;
		}
		if ($sum <= 0) {
			$centroids[] = $X[random_int(0, $n - 1)];
			continue;
		}
		$r = (mt_rand() / mt_getrandmax()) * $sum;
		$acc = 0.0;
		for ($i = 0; $i < $n; $i++) {
			$acc += $dists[$i];
			if ($acc >= $r) {
				$centroids[] = $X[$i];
				break;
			}
		}
	}
	return $centroids;
}

function kmeansFit(array $X, int $k = 3, int $maxIter = 50, ?array $initCentroids = null): array
{
	$n = count($X);
	if ($n === 0) return ['centroids' => [], 'labels' => [], 'iters' => 0];

	$dim = count($X[0]);

	// ✅ INI WAJIB ADA
	$labels = array_fill(0, $n, -1);

	// ✅ PAKAI CENTROID MANUAL JIKA ADA
	if (is_array($initCentroids) && count($initCentroids) > 0) {
		$k = count($initCentroids);
		$centroids = $initCentroids;
	} else {
		$centroids = kmeansInitPlusPlus($X, $k);
	}

	for ($iter = 0; $iter < $maxIter; $iter++) {
		$changed = false;

		// assign
		for ($i = 0; $i < $n; $i++) {
			$bestC = 0;
			$bestD = INF;
			for ($c = 0; $c < $k; $c++) {
				$d = euclidSq($X[$i], $centroids[$c]);
				if ($d < $bestD) {
					$bestD = $d;
					$bestC = $c;
				}
			}
			if ($labels[$i] !== $bestC) {
				$labels[$i] = $bestC;
				$changed = true;
			}
		}

		// update
		$sum = array_fill(0, $k, array_fill(0, $dim, 0.0));
		$cnt = array_fill(0, $k, 0);

		for ($i = 0; $i < $n; $i++) {
			$c = $labels[$i];
			$cnt[$c]++;
			for ($j = 0; $j < $dim; $j++) $sum[$c][$j] += $X[$i][$j];
		}

		for ($c = 0; $c < $k; $c++) {
			if ($cnt[$c] > 0) {
				for ($j = 0; $j < $dim; $j++) $centroids[$c][$j] = $sum[$c][$j] / $cnt[$c];
			}
		}

		if (!$changed) return ['centroids' => $centroids, 'labels' => $labels, 'iters' => $iter + 1];
	}

	return ['centroids' => $centroids, 'labels' => $labels, 'iters' => $maxIter];
}

// === Label Maping ===
function mapClusterNamesFixed(int $k): array
{
	$names = [
		0 => "Kecanduan Parah",
		1 => "Kecanduan Sedang",
		2 => "Kecanduan Ringan",
		3 => "Normal",
	];

	$map = [];
	for ($i = 0; $i < $k; $i++) {
		$map[$i] = $names[$i] ?? "Cluster C" . ($i + 1);
	}
	return $map;
}

function normalizeNbLabel(string $label): string
{
	return match ($label) {
		'Kecanduan Ringan' => 'Ringan',
		'Kecanduan Sedang' => 'Sedang',
		'Kecanduan Parah'  => 'Parah',
		default            => $label, // Normal tetap Normal
	};
}

// === Naive Bayes kategorikal (nilai 0..5), pakai Laplace smoothing ===
function nbTrainCategorical(array $X, array $y, int $valueCount = 6, float $alpha = 1.0): array
{
	$classes = array_values(array_unique($y));
	$classCount = [];
	$counts = []; // counts[class][featureIndex][value] = count

	foreach ($classes as $cls) {
		$classCount[$cls] = 0;
		$counts[$cls] = [];
	}

	$n = count($X);
	$dim = count($X[0]);

	for ($i = 0; $i < $n; $i++) {
		$cls = $y[$i];
		$classCount[$cls]++;

		for ($j = 0; $j < $dim; $j++) {
			$val = (int)$X[$i][$j];
			if (!isset($counts[$cls][$j])) $counts[$cls][$j] = array_fill(0, $valueCount, 0);
			if ($val < 0) $val = 0;
			if ($val >= $valueCount) $val = $valueCount - 1;
			$counts[$cls][$j][$val]++;
		}
	}

	// prior
	$priors = [];
	foreach ($classes as $cls) {
		$priors[$cls] = ($classCount[$cls] > 0) ? ($classCount[$cls] / $n) : 1e-12;
	}

	return [
		'classes' => $classes,
		'classCount' => $classCount,
		'counts' => $counts,
		'priors' => $priors,
		'valueCount' => $valueCount,
		'alpha' => $alpha,
		'dim' => $dim
	];
}

function nbPredictOne(array $model, array $x): array
{
	$bestClass = null;
	$bestLog = -INF;
	$scores = [];

	foreach ($model['classes'] as $cls) {
		$logp = log($model['priors'][$cls] ?? 1e-12);
		$den = ($model['classCount'][$cls] ?? 0) + $model['alpha'] * $model['valueCount'];

		for ($j = 0; $j < $model['dim']; $j++) {
			$val = (int)$x[$j];
			if ($val < 0) $val = 0;
			if ($val >= $model['valueCount']) $val = $model['valueCount'] - 1;

			$num = ($model['counts'][$cls][$j][$val] ?? 0) + $model['alpha'];
			$logp += log($num / $den);
		}

		$scores[$cls] = $logp;
		if ($logp > $bestLog) {
			$bestLog = $logp;
			$bestClass = $cls;
		}
	}

	return ['class' => $bestClass, 'log_scores' => $scores];
}

// === Hybrid pipeline: KMeans(training) -> NB training -> NB predict testing ===
function hybridTrainFromDb(mysqli $conn, int $k = 4, int $maxIter = 50, string $table = "dataset", string $colJenis = "jenisData", ?array $initCentroids = null): array
{
	$trainRows = fetchDatasetByJenis($conn, "training", $table, $colJenis);

	// X untuk KMeans (angka mentah K1..K6)
	$X_km = [];
	// X untuk Naive Bayes (kategori 0..4 sesuai Excel)
	$X_nb = [];

	foreach ($trainRows as $r) {
		$X_km[] = rowToVectorKategori($r);     // angka
		$X_nb[] = rowToVectorKategoriNB($r);   // kategori Excel
	}

	// KMeans tetap pakai angka
	$km = kmeansFit($X_km, $k, $maxIter, $initCentroids);

	$nameMap = mapClusterNamesFixed($k);

	// label kelas berasal dari hasil KMeans (seperti Excel: class hasil clustering)
	$y = [];
	foreach ($km['labels'] as $lbl) {
		$rawLabel = $nameMap[$lbl] ?? ("Cluster " . ($lbl + 1));
		$y[] = normalizeNbLabel($rawLabel);
	}

	// NB harus pakai kategori (5 kategori)
	$nb = nbTrainCategorical($X_nb, $y, 5, 1.0);

	return [
		'trainRows' => $trainRows,
		'X_train_km' => $X_km,
		'X_train_nb' => $X_nb,
		'kmeans' => $km,
		'clusterNameMap' => $nameMap,
		'y_train' => $y,
		'nb' => $nb
	];
}

function hybridPredictTesting(mysqli $conn, array $hybrid, string $table = "dataset", string $colJenis = "jenisData"): array
{
	$testRows = fetchDatasetByJenis($conn, "testing", $table, $colJenis);

	$preds = [];
	foreach ($testRows as $r) {

		// angka mentah K1..K6 (opsional buat ditampilkan)
		$x_raw = rowToVectorKategori($r);

		// kategori Excel 0..4 (inilah yang dipakai NB)
		$x_nb  = rowToVectorKategoriNB($r);

		$res = nbPredictOne($hybrid['nb'], $x_nb);

		$preds[] = [
			'row' => $r,
			'x_raw' => $x_raw,
			'x_nb' => $x_nb,
			'pred_class' => $res['class'],
			'log_scores' => $res['log_scores']
		];
	}
	return $preds;
}

function getVectorsByIds(mysqli $conn, array $ids, string $table = "dataset"): array
{
	$ids = array_map('intval', $ids);
	$in  = implode(",", $ids);
	$sql = "SELECT * FROM $table WHERE id IN ($in)";
	$res = $conn->query($sql);

	$map = [];
	while ($r = $res->fetch_assoc()) {
		$map[(int)$r['id']] = rowToVectorKategori($r);
	}

	// urutkan sesuai ids yang diminta
	$centroids = [];
	foreach ($ids as $id) {
		if (!isset($map[$id])) return []; // kalau id tidak ketemu
		$centroids[] = $map[$id];
	}
	return $centroids;
}

function buildDistanceTip($rowNo, $cNo, array $x, array $c, float $dist): string
{
	$parts = [];
	$dim = count($x);

	for ($d = 0; $d < $dim; $d++) {
		$xi = (float)$x[$d];
		$cj = (float)$c[$d];

		$xiStr = rtrim(rtrim(number_format($xi, 1, '.', ''), '0'), '.');
		$cjStr = rtrim(rtrim(number_format($cj, 1, '.', ''), '0'), '.');

		$parts[] = "({$xiStr} - {$cjStr})^2";
	}

	$distStr = rtrim(rtrim(number_format($dist, 2, '.', ''), '0'), '.');
	$label = "D" . ($rowNo + 1) . "C" . ($cNo + 1);

	return "<div class='math-tip-title'>{$label}</div>
            <div class='math-tip-eq'>{$label} = √(" . implode(" + ", $parts) . ") = <b>{$distStr}</b></div>";
}

// ===== KMeans dengan jejak iterasi (tanpa HTML) =====
function kmeansRunWithTrace(array $X, array $initCentroids, int $k = 4, int $maxIter = 50): array
{
	$n = count($X);
	if ($n === 0) {
		return [
			'iterations' => [],
			'final' => [
				'centroids' => $initCentroids,
				'labels' => [],
				'converged' => true,
				'iter' => 0
			]
		];
	}

	$dim = count($X[0]);
	$centroids = $initCentroids;

	$iterations = [];
	$converged = false;

	for ($iter = 1; $iter <= $maxIter; $iter++) {
		$labels = array_fill(0, $n, 0);
		$clusters = array_fill(0, $k, []);
		$distMatrix = array_fill(0, $n, array_fill(0, $k, 0.0));
		$minDist = array_fill(0, $n, 0.0);

		// hitung jarak + assign cluster
		for ($i = 0; $i < $n; $i++) {
			$bestC = 0;
			$bestD = null;

			for ($c = 0; $c < $k; $c++) {
				$sum = 0.0;
				for ($d = 0; $d < $dim; $d++) {
					$sum += pow(((float)$X[$i][$d] - (float)$centroids[$c][$d]), 2);
				}
				$dist = sqrt($sum);
				$distMatrix[$i][$c] = $dist;

				if ($bestD === null || $dist < $bestD) {
					$bestD = $dist;
					$bestC = $c;
				}
			}

			$labels[$i] = $bestC;
			$minDist[$i] = (float)$bestD;
			$clusters[$bestC][] = $i;
		}

		// update centroid
		$newCentroids = [];
		$changed = false;

		for ($c = 0; $c < $k; $c++) {
			if (empty($clusters[$c])) {
				$newCentroids[$c] = $centroids[$c];
				continue;
			}

			$sum = array_fill(0, $dim, 0.0);
			foreach ($clusters[$c] as $idx) {
				for ($d = 0; $d < $dim; $d++) $sum[$d] += (float)$X[$idx][$d];
			}

			$newCentroids[$c] = [];
			for ($d = 0; $d < $dim; $d++) {
				$val = round($sum[$d] / count($clusters[$c]), 1);
				$newCentroids[$c][$d] = $val;

				if (abs($val - (float)$centroids[$c][$d]) > 0.0001) $changed = true;
			}
		}

		$iterations[] = [
			'iter' => $iter,
			'centroids' => $centroids,       // centroid yang dipakai hitung jarak
			'dist' => $distMatrix,
			'minDist' => $minDist,
			'labels' => $labels,
			'clusters' => $clusters,
			'newCentroids' => $newCentroids, // centroid hasil update
			'changed' => $changed
		];

		$centroids = $newCentroids;

		if (!$changed) {
			$converged = true;
			break;
		}
	}

	$finalIter = count($iterations);
	$finalLabels = $finalIter ? $iterations[$finalIter - 1]['labels'] : [];

	return [
		'iterations' => $iterations,
		'final' => [
			'centroids' => $centroids,
			'labels' => $finalLabels,
			'converged' => $converged,
			'iter' => $finalIter
		]
	];
}

// =================================================== INPUT DATASET (20 pertanyaan) ========================================================

function allowedJawabanList(): array
{
	return ["Tidak Pernah", "Jarang", "Kadang-Kadang", "Sering", "Sangat Sering", "Selalu"];
}

function isValidJawaban(string $v): bool
{
	return normalize_jawaban($v) !== '';
}

function normalize_jawaban(string $v): string
{
	$v = trim($v);

	// lowercase semua
	$v = mb_strtolower($v, 'UTF-8');

	// samakan tanda strip & spasi
	$v = str_replace(['–', '—'], '-', $v); // strip aneh
	$v = preg_replace('/\s+/', ' ', $v);   // spasi ganda
	$v = str_replace(' ', '-', $v);
	$v = preg_replace('/-+/', '-', $v); // rapikan banyak strip jadi satu

	// mapping ke versi baku
	$map = [
		'tidak-pernah'     => 'Tidak Pernah',
		'jarang'           => 'Jarang',
		'kadang-kadang'    => 'Kadang-Kadang',
		'sering'           => 'Sering',
		'sangat-sering'    => 'Sangat Sering',
		'selalu'           => 'Selalu',
	];

	return $map[$v] ?? '';
}

function insertDataset(mysqli $conn, string $table, string $nama, string $jenis, array $jawaban20): bool
{
	$cols = ["nama", "jenisData"];
	for ($i = 1; $i <= 20; $i++) $cols[] = "p$i";

	$placeholders = rtrim(str_repeat("?,", count($cols)), ",");
	$sql = "INSERT INTO `$table` (" . implode(",", $cols) . ") VALUES ($placeholders)";

	$stmt = $conn->prepare($sql);
	if (!$stmt) throw new Exception("Prepare gagal: " . $conn->error);

	$types  = str_repeat("s", 22);
	$params = array_merge([$nama, $jenis], $jawaban20);

	$bind = [];
	$bind[] = $types;
	for ($i = 0; $i < count($params); $i++) $bind[] = &$params[$i];
	call_user_func_array([$stmt, "bind_param"], $bind);

	$ok = $stmt->execute();
	if (!$ok) throw new Exception("Execute gagal: " . $stmt->error);

	$stmt->close();
	return true;
}

/**
 * Handle submit form input data (training/testing) dan insert ke dataset.
 * Return: ['successMsg'=>string, 'errorMsg'=>string, 'old'=>array]
 */
function handleInsertDatasetFromPost(mysqli $conn, string $tableName = "dataset", string $colJenis = "jenisData", ?array $editCtx = null): array
{
	$successMsg = "";
	$errorMsg = "";

	$old = [
		'nama' => $_POST['nama'] ?? '',
		'jenisData' => $_POST['jenisData'] ?? '',
		'p' => []
	];

	if (!isset($_POST['submit'])) {
		return compact('successMsg', 'errorMsg', 'old');
	}

	try {
		$nama  = trim($_POST["nama"] ?? "");
		if ($nama === "") throw new Exception("Nama wajib diisi.");

		// kumpulkan p1..p20
		$jawaban = [];
		for ($i = 1; $i <= 20; $i++) {
			$key = "p$i";
			$val = $_POST[$key] ?? "";
			$old['p'][$i] = $val;

			if ($val === "") throw new Exception("Pertanyaan $i belum diisi.");
			if (!isValidJawaban($val)) throw new Exception("Jawaban pertanyaan $i tidak valid.");
			$jawaban[] = $val;
		}

		// ====== BLOK EDIT (UPDATE) ======
		if (is_array($editCtx) && ($editCtx['isEdit'] ?? false) === true) {

			$idEdit = (int)($editCtx['id'] ?? 0);
			$jenisEdit = $editCtx['jenis'] ?? '';

			if ($idEdit <= 0) throw new Exception("ID edit tidak valid.");
			if ($jenisEdit !== "training" && $jenisEdit !== "testing") throw new Exception("Jenis edit tidak valid.");

			$targetTable = ($jenisEdit === 'training')
				? 'dataset_training'
				: 'dataset_testing';

			// UPDATE: pastikan kamu sudah punya function updateDataset()
			updateDataset($conn, $targetTable, $idEdit, $nama, $jawaban);

			$successMsg = "Data berhasil diupdate.";
			return compact('successMsg', 'errorMsg', 'old');
		}

		// ====== BLOK INSERT (NORMAL) ======
		$jenis = $_POST["jenisData"] ?? "";
		if ($jenis !== "training" && $jenis !== "testing") throw new Exception("Jenis data tidak valid.");

		$targetTable = ($jenis === 'training')
			? 'dataset_training'
			: 'dataset_testing';

		insertDataset($conn, $targetTable, $nama, $jenis, $jawaban);

		$successMsg = "Data berhasil diinput ke <b>$jenis</b>.";
	} catch (Exception $e) {
		$errorMsg = $e->getMessage();
	}

	return compact('successMsg', 'errorMsg', 'old');
}


function updateDataset(mysqli $conn, string $table, int $id, string $nama, array $jawaban20): bool
{
	// update: nama, p1..p20
	$set = ["nama=?"];
	for ($i = 1; $i <= 20; $i++) $set[] = "p$i=?";

	$sql = "UPDATE `$table` SET " . implode(",", $set) . " WHERE id=?";
	$stmt = $conn->prepare($sql);
	if (!$stmt) throw new Exception("Prepare gagal: " . $conn->error);

	// bind: nama(1) + p1..p20(20) + id(1) => 22 param
	$types  = str_repeat("s", 21) . "i";
	$params = array_merge([$nama], $jawaban20, [$id]);

	$bind = [];
	$bind[] = $types;
	for ($i = 0; $i < count($params); $i++) $bind[] = &$params[$i];
	call_user_func_array([$stmt, "bind_param"], $bind);

	$ok = $stmt->execute();
	if (!$ok) throw new Exception("Execute gagal: " . $stmt->error);

	$stmt->close();
	return true;
}

function fetchRowForEdit(mysqli $conn, string $jenis, int $id): ?array
{
	$table = ($jenis === 'testing') ? 'dataset_testing' : 'dataset_training';

	$stmt = $conn->prepare("SELECT * FROM `$table` WHERE id=?");
	if (!$stmt) throw new Exception("Prepare gagal: " . $conn->error);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$row = $stmt->get_result()->fetch_assoc();
	$stmt->close();

	return $row ?: null;
}

function jawabanSingkat(string $v): string
{
	$x = strtolower(trim($v));
	$x = str_replace(['_', '-'], ' ', $x);
	$x = preg_replace('/\s+/', ' ', $x);

	return match ($x) {
		'tidak pernah'   => 'TP',
		'jarang'         => 'J',
		'kadang kadang', 'kadang-kadang' => 'KK',
		'sering'         => 'S',
		'sangat sering'  => 'SS',
		'selalu'         => 'SL',
		default => $v, // kalau ada nilai lain, tampilkan apa adanya
	};
}

// ========================================================= Login dan Register =============================================================
function set_flash($class, $label, $icon = 'fa fa-info', $extra = [])
{
	$_SESSION['flash']['class'] = $class;
	$_SESSION['flash']['label'] = $label;
	$_SESSION['flash']['icon']  = $icon;
	foreach ($extra as $k => $v) $_SESSION['flash'][$k] = $v;
}

function login_set_session(array $u)
{
	$_SESSION['id'] = $u['id'];
	$_SESSION['username'] = $u['username'];
	$_SESSION['nama'] = $u['nama'];
	$_SESSION['level'] = $u['level'] ?? 'user';
}


function handle_login_post($conn)
{
	$user = trim($_POST['username'] ?? '');
	$pass = $_POST['password'] ?? '';

	if ($user === '' || $pass === '') {
		set_flash('alert alert-danger', 'Username dan password wajib diisi', 'fa fa-times', ['username' => $user]);
		header('Location: index.php');
		exit;
	}

	$stmt = mysqli_prepare($conn, "SELECT id, username, password, nama, level FROM users WHERE username=? LIMIT 1");
	if (!$stmt) {
		set_flash('alert alert-danger', 'Prepare gagal: ' . mysqli_error($conn), 'fa fa-times');
		header('Location: index.php');
		exit;
	}

	mysqli_stmt_bind_param($stmt, "s", $user);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);

	$u = mysqli_fetch_assoc($res);
	mysqli_stmt_close($stmt);

	if (!$u) {
		set_flash('alert alert-danger', 'Username atau password salah', 'fa fa-times', ['username' => $user]);
		header('Location: index.php');
		exit;
	}

	if (!password_verify($pass, $u['password'])) {
		set_flash('alert alert-danger', 'Username atau password salah', 'fa fa-times', ['username' => $user]);
		header('Location: index.php');
		exit;
	}

	login_set_session($u);

	if (!empty($_POST['rememberMe'])) {
		remember_me_create_token($conn, (int)$u['id'], 30);
	} else {
		remember_me_clear_cookie();
	}

	header('Location: media.php');
	exit;
}

function handle_register_post($conn)
{
	$nama     = trim($_POST['nama'] ?? '');
	$username = trim($_POST['username'] ?? '');
	$password = $_POST['password'] ?? '';
	$pass2    = $_POST['password2'] ?? '';

	if ($nama === '' || $username === '' || $password === '' || $pass2 === '') {
		set_flash('alert alert-danger', 'Lengkapi semua field', 'fa fa-times', ['credidential' => $_POST]);
		header('Location: registration.php');
		exit;
	}

	if ($password !== $pass2) {
		set_flash('alert alert-danger', 'Konfirmasi password tidak cocok', 'fa fa-times', ['credidential' => $_POST]);
		header('Location: registration.php');
		exit;
	}

	// cek username sudah dipakai
	$stmt = mysqli_prepare($conn, "SELECT 1 FROM users WHERE username=? LIMIT 1");
	if (!$stmt) {
		set_flash('alert alert-danger', 'Prepare gagal: ' . mysqli_error($conn), 'fa fa-times', ['credidential' => $_POST]);
		header('Location: registration.php');
		exit;
	}
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
	$exists = (mysqli_fetch_row($res) !== null);
	mysqli_stmt_close($stmt);

	if ($exists) {
		set_flash('alert alert-danger', 'Username sudah digunakan', 'fa fa-times', ['credidential' => $_POST]);
		header('Location: registration.php');
		exit;
	}

	$passHash = password_hash($password, PASSWORD_DEFAULT);

	$stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, nama, level) VALUES (?, ?, ?, 'user')");
	if (!$stmt) {
		set_flash('alert alert-danger', 'Prepare gagal: ' . mysqli_error($conn), 'fa fa-times', ['credidential' => $_POST]);
		header('Location: registration.php');
		exit;
	}
	mysqli_stmt_bind_param($stmt, "sss", $username, $passHash, $nama);
	$ok = mysqli_stmt_execute($stmt);
	$err = mysqli_stmt_error($stmt);
	mysqli_stmt_close($stmt);

	if (!$ok) {
		set_flash('alert alert-danger', 'Registrasi gagal: ' . $err, 'fa fa-times', ['credidential' => $_POST]);
		header('Location: registration.php');
		exit;
	}

	set_flash('alert alert-success', 'Registrasi berhasil. Silakan login.', 'fa fa-check');
	header('Location: index.php');
	exit;
}

// ========================================================= Remember Me ====================================================================
function remember_me_set_cookie($token, $days = 30)
{
	$expire = time() + ($days * 24 * 60 * 60);

	// httponly = true supaya JS tidak bisa baca cookie
	// secure = true kalau situs pakai HTTPS
	// samesite = Lax cukup aman untuk kebanyakan kasus
	$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');

	setcookie('remember_me', $token, [
		'expires'  => $expire,
		'path'     => '/',
		'secure'   => $secure,
		'httponly' => true,
		'samesite' => 'Lax',
	]);
}

function remember_me_clear_cookie()
{
	// hapus versi secure=false
	setcookie('remember_me', '', [
		'expires'  => time() - 3600,
		'path'     => '/',
		'secure'   => false,
		'httponly' => true,
		'samesite' => 'Lax',
	]);

	// hapus versi secure=true
	setcookie('remember_me', '', [
		'expires'  => time() - 3600,
		'path'     => '/',
		'secure'   => true,
		'httponly' => true,
		'samesite' => 'Lax',
	]);
}


function remember_me_create_token($conn, $userId, $days = 30)
{
	$token = bin2hex(random_bytes(32)); // token asli (64 hex)
	$tokenHash = hash('sha256', $token); // yang disimpan di DB
	$expiresAt = date('Y-m-d H:i:s', time() + ($days * 24 * 60 * 60));

	// optional: bersihkan token lama user ini
	$stmtDel = mysqli_prepare($conn, "DELETE FROM user_remember_tokens WHERE user_id=?");
	if ($stmtDel) {
		mysqli_stmt_bind_param($stmtDel, "i", $userId);
		mysqli_stmt_execute($stmtDel);
		mysqli_stmt_close($stmtDel);
	}

	$stmt = mysqli_prepare($conn, "INSERT INTO user_remember_tokens (user_id, token_hash, expires_at) VALUES (?, ?, ?)");
	if (!$stmt) return null;

	mysqli_stmt_bind_param($stmt, "iss", $userId, $tokenHash, $expiresAt);
	$ok = mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	if (!$ok) return null;

	remember_me_set_cookie($token, $days);
	return $token;
}

function remember_me_try_login($conn)
{
	if (!empty($_SESSION['id'])) return; // sudah login

	$token = $_COOKIE['remember_me'] ?? '';
	if ($token === '') return;

	// validasi format token (harus 64 hex)
	if (!preg_match('/^[a-f0-9]{64}$/i', $token)) {
		remember_me_clear_cookie();
		return;
	}

	$tokenHash = hash('sha256', $token);
	$now = date('Y-m-d H:i:s');

	$sql = "SELECT u.id, u.username, u.nama, u.level
        FROM user_remember_tokens t
        JOIN users u ON u.id = t.user_id
        WHERE t.token_hash=? AND t.expires_at > ?
        LIMIT 1";

	$stmt = mysqli_prepare($conn, $sql);
	if (!$stmt) return;

	mysqli_stmt_bind_param($stmt, "ss", $tokenHash, $now);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
	$u = mysqli_fetch_assoc($res);
	mysqli_stmt_close($stmt);

	if (!$u) {
		// token tidak valid / expired
		remember_me_clear_cookie();
		return;
	}

	login_set_session($u);
}

function logout_user($conn)
{
	// Hapus token berdasarkan user_id (kalau session ada)
	if (!empty($_SESSION['id'])) {
		$uid = (int)$_SESSION['id'];
		$stmt = mysqli_prepare($conn, "DELETE FROM user_remember_tokens WHERE user_id=?");
		if ($stmt) {
			mysqli_stmt_bind_param($stmt, "i", $uid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}

	// TAMBAHAN: fallback hapus token berdasarkan cookie (kalau session kosong)
	if (empty($_SESSION['id']) && !empty($_COOKIE['remember_me'])) {
		$token = $_COOKIE['remember_me'];

		// validasi token harus 64 hex
		if (preg_match('/^[a-f0-9]{64}$/i', $token)) {
			$tokenHash = hash('sha256', $token);

			$stmt = mysqli_prepare($conn, "DELETE FROM user_remember_tokens WHERE token_hash=?");
			if ($stmt) {
				mysqli_stmt_bind_param($stmt, "s", $tokenHash);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
		}
	}

	remember_me_clear_cookie();
	session_unset();
	session_destroy();

	header('Location: index.php');
	exit;
}

function require_login()
{
	if (empty($_SESSION['id'])) {
		header('Location: index.php');
		exit;
	}
}

function require_admin()
{
	require_login();
	if (($_SESSION['level'] ?? 'user') !== 'admin') {
		// bisa redirect ke media.php atau tampilkan 403
		header('Location: media.php');
		exit;
	}
}


//==========================================================================================================================================
function flash_render_and_clear(): void
{
	if (!isset($_SESSION['flash'])) return;

	$f = $_SESSION['flash'];
	$class = $f['class'] ?? 'alert alert-info';
	$icon  = $f['icon'] ?? 'fa fa-info';
	$label = $f['label'] ?? '';

	echo '<div class="' . htmlspecialchars($class) . ' mt-3 mb-3 alert-dismissible fade show">';
	echo '  <span class="text-white">';
	echo '    <i class="' . htmlspecialchars($icon) . '"></i> ';
	echo      htmlspecialchars($label);
	echo '  </span>';
	echo '  <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
	echo '</div>';

	unset($_SESSION['flash']);
}
