<?php

// ============================================================================================
// 1. UTILITY UMUM (UPLOAD, DATE, STRING)
// ============================================================================================

function uploadProfile(string $fuploadName): void
{
	$vdir_upload = "../../images/profile/";
	$vfile_upload = $vdir_upload . $fuploadName;
	move_uploaded_file($_FILES["images"]["tmp_name"], $vfile_upload);
}

function uploadProduk(string $fuploadName): bool
{
	$vdir_upload = "../../assets/images/produk/";
	$vfile_upload = $vdir_upload . $fuploadName;
	return move_uploaded_file($_FILES["img"]["tmp_name"], $vfile_upload);
}

function uploadDirectory(string $fuploadName, string $directory): void
{
	$vdir_upload = "../../assets/images/" . $directory . "/";
	$vfile_upload = $vdir_upload . $fuploadName;
	move_uploaded_file($_FILES["images"]["tmp_name"], $vfile_upload);
}

function dateIndonesian(string $date): string
{
	$array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
	$array_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

	$timestamp = strtotime($date);
	if ($timestamp === false) {
		return $date;
	}

	$hari  = $array_hari[date('N', $timestamp)];
	$tanggal = date('j', $timestamp);
	$bulan = $array_bulan[date('n', $timestamp)];
	$tahun = date('Y', $timestamp);

	return $hari . ", " . $tanggal . " " . $bulan . " " . $tahun;
}

function hari(int $value): string
{
	$array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
	return $array_hari[$value] ?? '';
}

function bulan(int $bln): string
{
	$array_bulan = array(
		1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April",
		5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus",
		9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember"
	);
	return $array_bulan[$bln] ?? '';
}

function usernameInitial(string $text): string
{
	return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '.', $text)));
}

function timeElapsed(string $timeAgo): string
{
	$timeAgoUnix = strtotime($timeAgo);
	if ($timeAgoUnix === false) {
		return $timeAgo;
	}

	$cur_time   = time();
	$time_elapsed   = $cur_time - $timeAgoUnix;
	$seconds    = $time_elapsed;
	$minutes    = (int)round($time_elapsed / 60);
	$hours      = (int)round($time_elapsed / 3600);
	$days       = (int)round($time_elapsed / 86400);
	$weeks      = (int)round($time_elapsed / 604800);
	$months     = (int)round($time_elapsed / 2600640);
	$years      = (int)round($time_elapsed / 31207680);

	if ($seconds <= 60) {
		return "sesaat lalu";
	} else if ($minutes <= 60) {
		return ($minutes == 1) ? "satu menit lalu" : "$minutes menit lalu";
	} else if ($hours <= 24) {
		return ($hours == 1) ? "satu jam lalu" : "$hours jam lalu";
	} else if ($days <= 7) {
		return ($days == 1) ? "kemarin" : "$days hari lalu";
	} else if ($weeks <= 4.3) {
		return ($weeks == 1) ? "seminggu lalu" : "$weeks minggu lalu";
	} else if ($months <= 12) {
		return ($months == 1) ? "sebulan lalu" : "$months bulan lalu";
	} else {
		return ($years == 1) ? "setahun lalu" : "$years tahun lalu";
	}
}

function haversineLabel(float $latitudeFrom, float $longitudeFrom, float $latitudeTo, float $longitudeTo, float $earthRadius = 6371.0): string
{
	$latFrom = deg2rad($latitudeFrom);
	$lonFrom = deg2rad($longitudeFrom);
	$latTo = deg2rad($latitudeTo);
	$lonTo = deg2rad($longitudeTo);

	return "2 * arcsin(&radic;(sin<sup>2</sup>((" . $latFrom . " - " . $latTo . ")/2) + cos(" . $latFrom . ") cos(" . $latTo . ") sin<sup>2</sup>((" . $lonFrom . " - " . $lonTo . ")/2)) * EarthRadius " . $earthRadius;
}

function haversineGreatCircleDistance(float $latitudeFrom, float $longitudeFrom, float $latitudeTo, float $longitudeTo, float $earthRadius = 6371.0): float
{
	$latFrom = deg2rad($latitudeFrom);
	$lonFrom = deg2rad($longitudeFrom);
	$latTo = deg2rad($latitudeTo);
	$lonTo = deg2rad($longitudeTo);

	$latDelta = $latTo - $latFrom;
	$lonDelta = $lonTo - $lonFrom;

	$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	return $angle * $earthRadius;
}

function tf(mixed $value): string
{
	return $value == 1 || $value === true ? 'Yes' : 'No';
}

// ============================================================================================
// 2. MAPPING & KONVERSI JAWABAN
// ============================================================================================

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

	return jawabanKeAngka($s);
}

function kategoriMap(): array
{
	return [
		'k1' => ['p7', 'p11', 'p17'],
		'k2' => ['p1', 'p5', 'p14'],
		'k3' => ['p15', 'p20'],
		'k4' => ['p2', 'p6'],
		'k5' => ['p9', 'p10', 'p13', 'p16', 'p18'],
		'k6' => ['p3', 'p4', 'p8', 'p12', 'p19'],
	];
}

function rowToVectorKategori(array $row): array
{
	$fitur = [];
	foreach (kategoriMap() as $kat => $listP) {
		$sum = 0;
		foreach ($listP as $p) {
			$sum += jawabanKeAngkaFlexible($row[$p] ?? 'TP');
		}
		$fitur[] = $sum;
	}
	return $fitur;
}

function kategoriExcel(int $nilai): int
{
	if ($nilai <= 2) return 0;
	if ($nilai <= 5) return 1;
	return 2;
}

function rowToVectorKategoriNB(array $row): array
{
	$raw = rowToVectorKategori($row);
	return array_map(fn($v) => kategoriExcel((int)$v), $raw);
}

// ============================================================================================
// 3. FETCH DATASET DARI DB
// ============================================================================================

function fetchDatasetByJenis(mysqli $conn, string $jenis, string $table = "dataset", string $colJenis = "jenisData"): array
{
	$jenis = ($jenis === 'training') ? 'training' : 'testing';
	$sql = "SELECT * FROM {$table} WHERE {$colJenis}=? ORDER BY id ASC";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s", $jenis);
	$stmt->execute();
	$res = $stmt->get_result();
	$rows = [];
	while ($r = $res->fetch_assoc()) {
		$rows[] = $r;
	}
	$stmt->close();
	return $rows;
}

// ============================================================================================
// 4. OPERASI CENTROID (SAVE, GET)
// ============================================================================================

function saveCentroidsToDB(mysqli $conn, array $centroidVectors, array $sourceIds): void
{
	mysqli_query($conn, "TRUNCATE TABLE centroid");

	$stmt = $conn->prepare("INSERT INTO centroid (id_centroid, source_id, data_centroid) VALUES (?, ?, ?)");

	foreach ($centroidVectors as $i => $vec) {
		$idCent = $i + 1;
		$srcId  = (int)($sourceIds[$i] ?? 0);
		$data = implode(',', array_map(fn($v) => (string)round((float)$v, 4), $vec));

		$stmt->bind_param("iis", $idCent, $srcId, $data);
		$stmt->execute();
	}

	$stmt->close();
}

function getCentroidSources(mysqli $conn): array
{
	$map = [];
	$sql = "SELECT id_centroid, source_id FROM centroid ORDER BY id_centroid ASC LIMIT 3";
	$res = $conn->query($sql);
	if (!$res) return $map;

	while ($r = $res->fetch_assoc()) {
		$map[(int)$r['id_centroid']] = (int)($r['source_id'] ?? 0);
	}
	return $map;
}

function getInitialCentroidsFromDB(mysqli $conn): array
{
	$centroids = [];
	$sql = "SELECT data_centroid FROM centroid ORDER BY id_centroid ASC LIMIT 3";
	$res = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($res)) {
		$vector = array_map(
			'floatval',
			explode(',', $row['data_centroid'])
		);
		$centroids[] = $vector;
	}

	return $centroids;
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

	$centroids = [];
	foreach ($ids as $id) {
		if (!isset($map[$id])) return [];
		$centroids[] = $map[$id];
	}
	return $centroids;
}

// ============================================================================================
// 5. ALGORITMA K-MEANS
// ============================================================================================

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
			foreach ($centroids as $c) {
				$best = min($best, euclidSq($x, $c));
			}
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
	$labels = array_fill(0, $n, -1);

	if (is_array($initCentroids) && count($initCentroids) > 0) {
		$k = count($initCentroids);
		$centroids = $initCentroids;
	} else {
		$centroids = kmeansInitPlusPlus($X, $k);
	}

	for ($iter = 0; $iter < $maxIter; $iter++) {
		$changed = false;

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

		$sum = array_fill(0, $k, array_fill(0, $dim, 0.0));
		$cnt = array_fill(0, $k, 0);

		for ($i = 0; $i < $n; $i++) {
			$c = $labels[$i];
			$cnt[$c]++;
			for ($j = 0; $j < $dim; $j++) {
				$sum[$c][$j] += $X[$i][$j];
			}
		}

		for ($c = 0; $c < $k; $c++) {
			if ($cnt[$c] > 0) {
				for ($j = 0; $j < $dim; $j++) {
					$centroids[$c][$j] = $sum[$c][$j] / $cnt[$c];
				}
			}
		}

		if (!$changed) {
			return ['centroids' => $centroids, 'labels' => $labels, 'iters' => $iter + 1];
		}
	}

	return ['centroids' => $centroids, 'labels' => $labels, 'iters' => $maxIter];
}

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

		$newCentroids = [];
		$changed = false;

		for ($c = 0; $c < $k; $c++) {
			if (empty($clusters[$c])) {
				$newCentroids[$c] = $centroids[$c];
				continue;
			}

			$sum = array_fill(0, $dim, 0.0);
			foreach ($clusters[$c] as $idx) {
				for ($d = 0; $d < $dim; $d++) {
					$sum[$d] += (float)$X[$idx][$d];
				}
			}

			$newCentroids[$c] = [];
			for ($d = 0; $d < $dim; $d++) {
				$val = round($sum[$d] / count($clusters[$c]), 1);
				$newCentroids[$c][$d] = $val;

				if (abs($val - (float)$centroids[$c][$d]) > 0.0001) {
					$changed = true;
				}
			}
		}

		$iterations[] = [
			'iter' => $iter,
			'centroids' => $centroids,
			'dist' => $distMatrix,
			'minDist' => $minDist,
			'labels' => $labels,
			'clusters' => $clusters,
			'newCentroids' => $newCentroids,
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

function mapClusterNamesFixed(int $k): array
{
	$names = [
		0 => "Kecanduan Sedang",
		1 => "Kecanduan Parah",
		2 => "Kecanduan Ringan",
	];

	$map = [];
	for ($i = 0; $i < $k; $i++) {
		$map[$i] = $names[$i] ?? "Cluster C" . ($i + 1);
	}
	return $map;
}

// ============================================================================================
// 6. ALGORITMA NAIVE BAYES
// ============================================================================================

function normalizeNbLabel(string $label): string
{
	return match ($label) {
		'Kecanduan Ringan' => 'Ringan',
		'Kecanduan Sedang' => 'Sedang',
		'Kecanduan Parah'  => 'Parah',
		default            => $label,
	};
}

function nbTrainCategorical(array $X, array $y, int $valueCount = 3, float $alpha = 0.0): array
{
	$classes = array_values(array_unique($y));
	$classCount = [];
	$counts = [];

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
			if (!isset($counts[$cls][$j])) {
				$counts[$cls][$j] = array_fill(0, $valueCount, 0);
			}
			if ($val < 0) {
				$val = 0;
			}
			if ($val >= $valueCount) {
				$val = $valueCount - 1;
			}
			$counts[$cls][$j][$val]++;
		}
	}

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
			if ($val < 0) {
				$val = 0;
			}
			if ($val >= $model['valueCount']) {
				$val = $model['valueCount'] - 1;
			}

			$num = ($model['counts'][$cls][$j][$val] ?? 0) + $model['alpha'];
			if ($den <= 0 || $num <= 0) {
				$logp = -INF;
				break;
			}
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

// ============================================================================================
// 7. PIPELINE HYBRID
// ============================================================================================

function hybridTrainFromDb(mysqli $conn, int $k = 3, int $maxIter = 50, string $table = "dataset", string $colJenis = "jenisData", ?array $initCentroids = null): array
{
	$trainRows = fetchDatasetByJenis($conn, "training", $table, $colJenis);

	$X_km = [];
	$X_nb = [];

	foreach ($trainRows as $r) {
		$X_km[] = rowToVectorKategori($r);
		$X_nb[] = rowToVectorKategoriNB($r);
	}

	$km = kmeansFit($X_km, $k, $maxIter, $initCentroids);
	$nameMap = mapClusterNamesFixed($k);

	$y = [];
	foreach ($km['labels'] as $lbl) {
		$rawLabel = $nameMap[$lbl] ?? ("Cluster " . ($lbl + 1));
		$y[] = normalizeNbLabel($rawLabel);
	}

	$nb = nbTrainCategorical($X_nb, $y, 3, 0.0);

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
		$x_raw = rowToVectorKategori($r);
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

// ============================================================================================
// 8. HELPER DISPLAY
// ============================================================================================

function buildDistanceTip(int $rowNo, int $cNo, array $x, array $c, float $dist): string
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
            <div class='math-tip-eq'>{$label} = &radic;(" . implode(" + ", $parts) . ") = <b>{$distStr}</b></div>";
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
		default => $v,
	};
}

// ============================================================================================
// 9. INPUT/OUTPUT DATASET
// ============================================================================================

function allowedJawabanList(): array
{
	return ["Tidak Pernah", "Jarang", "Kadang-Kadang", "Sering", "Sangat Sering", "Selalu"];
}

function isValidJawaban(string $v): bool
{
	return normalizeJawaban($v) !== '';
}

function normalizeJawaban(string $v): string
{
	$v = trim($v);
	$v = mb_strtolower($v, 'UTF-8');
	$v = str_replace(['_', "\xE2\x80\x93", "\xE2\x80\x94"], '-', $v);
	$v = preg_replace('/\s+/', ' ', $v);
	$v = str_replace(' ', '-', $v);
	$v = preg_replace('/-+/', '-', $v);

	$map = [
		'tp'               => 'Tidak Pernah',
		'j'                => 'Jarang',
		'jj'               => 'Jarang',
		'kk'               => 'Kadang-Kadang',
		's'                => 'Sering',
		'ss'               => 'Sangat Sering',
		'sl'               => 'Selalu',
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
	for ($i = 1; $i <= 20; $i++) {
		$cols[] = "p$i";
	}

	$placeholders = rtrim(str_repeat("?,", count($cols)), ",");
	$sql = "INSERT INTO `$table` (" . implode(",", $cols) . ") VALUES ($placeholders)";

	$stmt = $conn->prepare($sql);
	if (!$stmt) {
		throw new Exception("Prepare gagal: " . $conn->error);
	}

	$types  = str_repeat("s", 22);
	$params = array_merge([$nama, $jenis], $jawaban20);

	$bind = [];
	$bind[] = $types;
	for ($i = 0; $i < count($params); $i++) {
		$bind[] = &$params[$i];
	}
	call_user_func_array([$stmt, "bind_param"], $bind);

	$ok = $stmt->execute();
	if (!$ok) {
		throw new Exception("Execute gagal: " . $stmt->error);
	}

	$stmt->close();
	return true;
}

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
		$nama  = ucwords(strtolower(trim($_POST["nama"] ?? "")));
		if ($nama === "") {
			throw new Exception("Nama wajib diisi.");
		}
		if (!preg_match("/^[a-zA-Z\s.']+$/", $nama)) {
			throw new Exception("Nama hanya boleh mengandung huruf, spasi, tanda kutip, dan titik.");
		}

		$jawaban = [];
		for ($i = 1; $i <= 20; $i++) {
			$key = "p$i";
			$val = $_POST[$key] ?? "";
			$old['p'][$i] = $val;

			if ($val === "") {
				throw new Exception("Pertanyaan $i belum diisi.");
			}
			if (!isValidJawaban($val)) {
				throw new Exception("Jawaban pertanyaan $i tidak valid.");
			}
			$jawaban[] = $val;
		}

		if (is_array($editCtx) && ($editCtx['isEdit'] ?? false) === true) {
			$idEdit = (int)($editCtx['id'] ?? 0);
			$jenisEdit = $editCtx['jenis'] ?? '';

			if ($idEdit <= 0) {
				throw new Exception("ID edit tidak valid.");
			}
			if ($jenisEdit !== "training" && $jenisEdit !== "testing") {
				throw new Exception("Jenis edit tidak valid.");
			}

			$targetTable = ($jenisEdit === 'training') ? 'dataset_training' : 'dataset_testing';

			updateDataset($conn, $targetTable, $idEdit, $nama, $jawaban);

			setFlash('alert alert-success', 'Data berhasil diupdate.', 'fa fa-check');
			$module = $_GET['module'] ?? 'inputData';
			echo "<script>window.location.href = 'media.php?module=$module';</script>";
			exit;
		}

		$jenis = $_POST["jenisData"] ?? "";
		if ($jenis !== "training" && $jenis !== "testing") {
			throw new Exception("Jenis data tidak valid.");
		}

		$targetTable = ($jenis === 'training') ? 'dataset_training' : 'dataset_testing';

		insertDataset($conn, $targetTable, $nama, $jenis, $jawaban);

		setFlash('alert alert-success', "Data berhasil diinput ke <b>$jenis</b>.", 'fa fa-check');
		$module = $_GET['module'] ?? 'inputData';
		echo "<script>window.location.href = 'media.php?module=$module';</script>";
		exit;
	} catch (Exception $e) {
		$errorMsg = $e->getMessage();
	}

	return compact('successMsg', 'errorMsg', 'old');
}

function updateDataset(mysqli $conn, string $table, int $id, string $nama, array $jawaban20): bool
{
	$set = ["nama=?"];
	for ($i = 1; $i <= 20; $i++) {
		$set[] = "p$i=?";
	}

	$sql = "UPDATE `$table` SET " . implode(",", $set) . " WHERE id=?";
	$stmt = $conn->prepare($sql);
	if (!$stmt) {
		throw new Exception("Prepare gagal: " . $conn->error);
	}

	$types  = str_repeat("s", 21) . "i";
	$params = array_merge([$nama], $jawaban20, [$id]);

	$bind = [];
	$bind[] = $types;
	for ($i = 0; $i < count($params); $i++) {
		$bind[] = &$params[$i];
	}
	call_user_func_array([$stmt, "bind_param"], $bind);

	$ok = $stmt->execute();
	if (!$ok) {
		throw new Exception("Execute gagal: " . $stmt->error);
	}

	$stmt->close();
	return true;
}

function fetchRowForEdit(mysqli $conn, string $jenis, int $id): ?array
{
	$table = ($jenis === 'testing') ? 'dataset_testing' : 'dataset_training';

	$stmt = $conn->prepare("SELECT * FROM `$table` WHERE id=?");
	if (!$stmt) {
		throw new Exception("Prepare gagal: " . $conn->error);
	}
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$row = $stmt->get_result()->fetch_assoc();
	$stmt->close();

	return $row ?: null;
}

// ============================================================================================
// 10. AUTENTIKASI
// ============================================================================================

function setFlash(string $class, string $label, string $icon = 'fa fa-info', array $extra = []): void
{
	$_SESSION['flash']['class'] = $class;
	$_SESSION['flash']['label'] = $label;
	$_SESSION['flash']['icon']  = $icon;
	foreach ($extra as $k => $v) {
		$_SESSION['flash'][$k] = $v;
	}
}

function loginSetSession(array $u): void
{
	$_SESSION['id'] = $u['id'];
	$_SESSION['username'] = $u['username'];
	$_SESSION['nama'] = $u['nama'];
	$_SESSION['level'] = $u['level'] ?? 'user';
}

function handleLoginPost(mysqli $conn): void
{
	$user = trim($_POST['username'] ?? '');
	$pass = $_POST['password'] ?? '';

	if ($user === '' || $pass === '') {
		setFlash('alert alert-danger', 'Username dan password wajib diisi', 'fa fa-times', ['username' => $user]);
		header('Location: index.php');
		exit;
	}

	$stmt = mysqli_prepare($conn, "SELECT id, username, password, nama, level FROM users WHERE username=? LIMIT 1");
	if (!$stmt) {
		setFlash('alert alert-danger', 'Prepare gagal: ' . mysqli_error($conn), 'fa fa-times');
		header('Location: index.php');
		exit;
	}

	mysqli_stmt_bind_param($stmt, "s", $user);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);

	$u = mysqli_fetch_assoc($res);
	mysqli_stmt_close($stmt);

	if (!$u) {
		setFlash('alert alert-danger', 'Username atau password salah', 'fa fa-times', ['username' => $user]);
		header('Location: index.php');
		exit;
	}

	if (!password_verify($pass, $u['password'])) {
		setFlash('alert alert-danger', 'Username atau password salah', 'fa fa-times', ['username' => $user]);
		header('Location: index.php');
		exit;
	}

	loginSetSession($u);

	if (!empty($_POST['rememberMe'])) {
		rememberMeCreateToken($conn, (int)$u['id'], 30);
	} else {
		rememberMeClearCookie();
	}

	header('Location: media.php');
	exit;
}

function handleRegisterPost(mysqli $conn): void
{
	$nama     = ucwords(strtolower(trim($_POST['nama'] ?? '')));
	$username = trim($_POST['username'] ?? '');
	$password = $_POST['password'] ?? '';
	$pass2    = $_POST['password2'] ?? '';

	if ($nama === '' || $username === '' || $password === '' || $pass2 === '') {
		setFlash('alert alert-danger', 'Lengkapi semua field', 'fa fa-times', ['credidential' => $_POST]);
		header('Location: registration.php');
		exit;
	}

	if (!preg_match("/^[a-zA-Z\s.']+$/", $nama)) {
		setFlash('alert alert-danger', 'Nama hanya boleh mengandung huruf, spasi, tanda kutip, dan titik', 'fa fa-times', ['credidential' => $_POST]);
		header('Location: registration.php');
		exit;
	}

	if ($password !== $pass2) {
		setFlash('alert alert-danger', 'Konfirmasi password tidak cocok', 'fa fa-times', ['credidential' => $_POST]);
		header('Location: registration.php');
		exit;
	}

	$stmt = mysqli_prepare($conn, "SELECT 1 FROM users WHERE username=? LIMIT 1");
	if (!$stmt) {
		setFlash('alert alert-danger', 'Prepare gagal: ' . mysqli_error($conn), 'fa fa-times', ['credidential' => $_POST]);
		header('Location: registration.php');
		exit;
	}
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
	$exists = (mysqli_fetch_row($res) !== null);
	mysqli_stmt_close($stmt);

	if ($exists) {
		setFlash('alert alert-danger', 'Username sudah digunakan', 'fa fa-times', ['credidential' => $_POST]);
		header('Location: registration.php');
		exit;
	}

	$passHash = password_hash($password, PASSWORD_DEFAULT);

	$stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, nama, level) VALUES (?, ?, ?, 'user')");
	if (!$stmt) {
		setFlash('alert alert-danger', 'Prepare gagal: ' . mysqli_error($conn), 'fa fa-times', ['credidential' => $_POST]);
		header('Location: registration.php');
		exit;
	}
	mysqli_stmt_bind_param($stmt, "sss", $username, $passHash, $nama);
	$ok = mysqli_stmt_execute($stmt);
	$err = mysqli_stmt_error($stmt);
	mysqli_stmt_close($stmt);

	if (!$ok) {
		setFlash('alert alert-danger', 'Registrasi gagal: ' . $err, 'fa fa-times', ['credidential' => $_POST]);
		header('Location: registration.php');
		exit;
	}

	setFlash('alert alert-success', 'Registrasi berhasil. Silakan login.', 'fa fa-check');
	header('Location: index.php');
	exit;
}

function logoutUser(mysqli $conn): void
{
	if (!empty($_SESSION['id'])) {
		$uid = (int)$_SESSION['id'];
		$stmt = mysqli_prepare($conn, "DELETE FROM user_remember_tokens WHERE user_id=?");
		if ($stmt) {
			mysqli_stmt_bind_param($stmt, "i", $uid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}

	if (empty($_SESSION['id']) && !empty($_COOKIE['remember_me'])) {
		$token = $_COOKIE['remember_me'];

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

	rememberMeClearCookie();
	session_unset();
	session_destroy();

	header('Location: index.php');
	exit;
}

// ============================================================================================
// 11. REMEMBER ME
// ============================================================================================

function rememberMeSetCookie(string $token, int $days = 30): void
{
	$expire = time() + ($days * 24 * 60 * 60);
	$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');

	setcookie('remember_me', $token, [
		'expires'  => $expire,
		'path'     => '/',
		'secure'   => $secure,
		'httponly' => true,
		'samesite' => 'Lax',
	]);
}

function rememberMeClearCookie(): void
{
	setcookie('remember_me', '', [
		'expires'  => time() - 3600,
		'path'     => '/',
		'secure'   => false,
		'httponly' => true,
		'samesite' => 'Lax',
	]);

	setcookie('remember_me', '', [
		'expires'  => time() - 3600,
		'path'     => '/',
		'secure'   => true,
		'httponly' => true,
		'samesite' => 'Lax',
	]);
}

function rememberMeCreateToken(mysqli $conn, int $userId, int $days = 30): ?string
{
	$token = bin2hex(random_bytes(32));
	$tokenHash = hash('sha256', $token);
	$expiresAt = date('Y-m-d H:i:s', time() + ($days * 24 * 60 * 60));

	$stmtDel = mysqli_prepare($conn, "DELETE FROM user_remember_tokens WHERE user_id=?");
	if ($stmtDel) {
		mysqli_stmt_bind_param($stmtDel, "i", $userId);
		mysqli_stmt_execute($stmtDel);
		mysqli_stmt_close($stmtDel);
	}

	$stmt = mysqli_prepare($conn, "INSERT INTO user_remember_tokens (user_id, token_hash, expires_at) VALUES (?, ?, ?)");
	if (!$stmt) {
		return null;
	}

	mysqli_stmt_bind_param($stmt, "iss", $userId, $tokenHash, $expiresAt);
	$ok = mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	if (!$ok) {
		return null;
	}

	rememberMeSetCookie($token, $days);
	return $token;
}

function rememberMeTryLogin(mysqli $conn): void
{
	if (!empty($_SESSION['id'])) {
		return;
	}

	$token = $_COOKIE['remember_me'] ?? '';
	if ($token === '') {
		return;
	}

	if (!preg_match('/^[a-f0-9]{64}$/i', $token)) {
		rememberMeClearCookie();
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
	if (!$stmt) {
		return;
	}

	mysqli_stmt_bind_param($stmt, "ss", $tokenHash, $now);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
	$u = mysqli_fetch_assoc($res);
	mysqli_stmt_close($stmt);

	if (!$u) {
		rememberMeClearCookie();
		return;
	}

	loginSetSession($u);
}

function requireLogin(): void
{
	if (empty($_SESSION['id'])) {
		header('Location: index.php');
		exit;
	}
}

function requireAdmin(): void
{
	requireLogin();
	if (($_SESSION['level'] ?? 'user') !== 'admin') {
		header('Location: media.php');
		exit;
	}
}

// ============================================================================================
// 12. FLASH MESSAGE
// ============================================================================================

function flashRenderAndClear(): void
{
	if (!isset($_SESSION['flash'])) {
		return;
	}

	$f = $_SESSION['flash'];
	$class = $f['class'] ?? 'alert alert-info';
	$icon  = $f['icon'] ?? 'fa fa-info';
	$label = $f['label'] ?? '';

	// Premium unified alert styling
	$style = "border-radius: 12px; border: none; padding: 14px 20px; font-size: 0.88rem; font-weight: 600; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(0,0,0,0.02);";
	
	if (strpos($class, 'alert-success') !== false) {
		$style .= " background: #ecfdf5; color: #065f46; border-left: 4px solid #10b981;";
	} elseif (strpos($class, 'alert-danger') !== false || strpos($class, 'alert-error') !== false) {
		$style .= " background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444;";
	} elseif (strpos($class, 'alert-warning') !== false) {
		$style .= " background: #fffbeb; color: #92400e; border-left: 4px solid #f59e0b;";
	} else {
		$style .= " background: #f0f9ff; color: #075985; border-left: 4px solid #0ea5e9;";
	}

	echo '<div class="' . htmlspecialchars($class) . ' mt-3 mb-3 alert-dismissible fade show" style="' . $style . '">';
	echo '  <div style="display: flex; align-items: flex-start; gap: 12px; flex: 1;">';
	echo '    <i class="' . htmlspecialchars($icon) . '" style="font-size: 1.1rem; margin-top: 2px;"></i> ';
	echo '    <div style="font-size: 0.88rem; font-weight: 600; line-height: 1.4;">' . $label . '</div>';
	echo '  </div>';
	echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: static; padding: 0; margin-left: 15px; color: inherit; filter: grayscale(1) invert(0.5); opacity: 0.8;"></button>';
	echo '</div>';

	unset($_SESSION['flash']);
}
