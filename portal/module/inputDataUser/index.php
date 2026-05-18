<?php
// =====================
// KONFIGURASI DASAR
// =====================
$questions = [
    1  => "Seberapa sering anak Anda melanggar batas waktu yang Anda tetapkan dalam menggunakan gadget?",
    2  => "Seberapa sering anak Anda mengabaikan pekerjaan rumah tangga (misalnya merapikan mainan) untuk menghabiskan lebih banyak waktu dengan gadget?",
    3  => "Seberapa sering anak Anda memilih untuk menghabiskan waktu dengan gadget daripada dengan anggota keluarga lainnya?",
    4  => "Seberapa sering anak Anda membentuk hubungan baru dengan pengguna game online lainnya?",
    5  => "Seberapa sering Anda mengeluhkan durasi waktu yang dihabiskan anak Anda di internet / menggunakan gadget?",
    6  => "Seberapa sering nilai anak Anda menurun karena jumlah waktu yang dia habiskan di internet / menggunakan gadget?",
    7  => "Seberapa sering anak Anda memeriksa perangkatnya sebelum melakukan hal lain?",
    8  => "Seberapa sering anak Anda tampak menjauh dari orang lain sejak gadget itu ada?",
    9  => "Seberapa sering anak Anda membela diri atau diam ketika ditanya apa yang dia lakukan saat menggunakan internet / gadget?",
    10 => "Seberapa sering Anda melihat anak Anda mengintip untuk berselancar di internet/menggunakan gadget tanpa seizin Anda?",
    11 => "Seberapa sering anak Anda menghabiskan waktu sendiri di kamarnya bermain dengan gadget?",
    12 => "Seberapa sering anak Anda menerima panggilan telepon dari orang asing dari teman-teman online baru mereka?",
    13 => "Seberapa sering anak Anda marah/berulah jika dia terganggu saat menggunakan gadget?",
    14 => "Seberapa sering anak Anda terlihat lebih lelah daripada sebelumnya setelah menggunakan gadget?",
    15 => "Seberapa sering anak Anda ingin menggunakan gadget segera setelah dia tidak menggunakan gadget?",
    16 => "Seberapa sering anak Anda mengamuk ketika Anda campur tangan tentang seberapa banyak waktu yang dihabiskannya menggunakan gadget?",
    17 => "Seberapa sering anak Anda memilih untuk menghabiskan waktu menggunakan gadget daripada melakukan hobi atau aktivitas lain di luar rumah?",
    18 => "Seberapa sering anak Anda marah atau berargumen ketika Anda membatasi seberapa banyak waktu yang diizinkan untuk menggunakan gadgetnya?",
    19 => "Seberapa sering anak Anda memilih untuk menghabiskan lebih banyak waktu menggunakan gadget daripada pergi keluar bersama teman-teman (misalnya bersepeda, bermain di taman)?",
    20 => "Seberapa sering anak Anda merasa tertekan, memiliki perubahan suasana hati, atau cemas saat tidak menggunakan gadget, dan ingin segera menggunakan gadget mereka?"
];

$opts = allowedJawabanList();

// =====================
// STATE DEFAULT
// =====================
$old = [
    'nama' => '',
    'p'    => array_fill(1, 20, '')
];

$successMsg = '';
$errorMsg   = '';

// =====================
// HANDLE SUBMIT (USER)
// =====================
if (isset($_POST['submit'])) {

    // PAKSA jenis data (aman, user tidak bisa manipulasi)
    $_POST['jenisData'] = 'testing';

    $state = handleInsertDatasetFromPost(
        $conn,
        "dataset",
        "jenisData",
        null // tidak ada edit context
    );

    if (!empty($state['successMsg'])) {
        $successMsg = "Terima kasih atas partisipasinya";
        // Reset state on successful submit so the form is ready for a new respondent
        $old = [
            'nama' => '',
            'p'    => array_fill(1, 20, '')
        ];
    } else {
        $errorMsg   = $state['errorMsg'] ?? '';
        $old        = $state['old'] ?? $old;
    }
}
?>

<!-- Alerts -->
<?php if ($successMsg): ?>
    <div class="alert alert-success border-0 text-white font-weight-bold" style="background:#10b981; border-radius:12px; font-size:0.85rem; padding:12px 18px; margin-bottom:20px;">
        <i class="fa fa-check-circle me-2"></i><?= htmlspecialchars($successMsg) ?>
    </div>
<?php endif; ?>

<?php if ($errorMsg): ?>
    <div class="alert alert-danger border-0 text-white font-weight-bold" style="background:#f43f5e; border-radius:12px; font-size:0.85rem; padding:12px 18px; margin-bottom:20px;">
        <i class="fa fa-exclamation-circle me-2"></i><?= htmlspecialchars($errorMsg) ?>
    </div>
<?php endif; ?>

<!-- Header Brand Info -->
<div class="d-flex align-items-center mb-4">
    <div class="icon icon-shape icon-gradient-dark shadow text-center border-radius-md d-inline-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-file-text-fill" viewBox="0 0 16 16">
            <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1"/>
        </svg>
    </div>
    <div>
        <h5 class="mb-0" style="font-weight:700;">Isi Kuesioner Deteksi</h5>
        <p class="mb-0" style="font-size:0.78rem;color:#627594;">Ukur tingkat kecanduan internet anak Anda secara real-time</p>
    </div>
</div>

<form method="post" id="wizardForm">
    <!-- hidden: jenis data selalu testing -->
    <input type="hidden" name="jenisData" id="inputJenisData" value="testing">

    <!-- Identitas Responden Card -->
    <div class="identitas-card-modern">
        <div class="identitas-title-section">
            <i class="fa fa-user"></i>
            <div>
                <h5 class="mb-0" style="font-weight:750; color:#1e293b; font-size:1.05rem;">Identitas Responden</h5>
                <p class="mb-0" style="font-size:0.75rem; color:#64748b;">Lengkapi data dasar responden terlebih dahulu</p>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-12">
                <label style="font-weight:650; font-size:0.8rem; color:#475569; display:block; margin-bottom:8px;">Nama Lengkap Anak</label>
                <div style="position:relative;">
                    <input type="text" class="form-control" name="nama" id="inputNama"
                        value="<?= htmlspecialchars($old['nama'] ?? '') ?>"
                        placeholder="Masukkan nama lengkap anak Anda" 
                        style="border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.85rem; padding:11px 16px; width:100%;" required>
                </div>
            </div>
        </div>
    </div>

    <!-- Stepper Navigation Panel -->
    <div class="identitas-card-modern" style="padding: 20px 24px !important;">
        <div class="wizard-steps-container">
            <div class="wizard-steps-line">
                <div class="wizard-steps-line-fill" id="stepLineFill"></div>
            </div>
            <div class="wizard-step-node active" data-step="1">1</div>
            <div class="wizard-step-node" data-step="2">2</div>
            <div class="wizard-step-node" data-step="3">3</div>
            <div class="wizard-step-node" data-step="4">4</div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <span id="progressText" style="font-size:0.8rem; font-weight:700; color:#475569;">0 dari 20 Pertanyaan Terjawab (0%)</span>
            <span id="stepTitleText" style="font-size:0.8rem; font-weight:700; color:var(--fadel-primary); text-transform:uppercase; letter-spacing:0.5px;">Langkah 1: Soal 1-5</span>
        </div>

        <div class="wizard-progress-bar-container">
            <div class="wizard-progress-bar-fill" id="progressBarFill"></div>
        </div>

        <!-- Step Panes -->
        <div class="wizard-panes-container">
            
            <!-- STEP 1: Q1 - Q5 -->
            <div class="wizard-step-pane active-pane" data-pane="1">
                <?php for ($i = 1; $i <= 5; $i++): 
                    $answeredClass = (($old['p'][$i] ?? '') !== '') ? 'answered' : '';
                    $statusText = (($old['p'][$i] ?? '') !== '') ? '<i class="fa fa-check-circle"></i> Selesai' : '<i class="fa fa-circle-thin"></i> Belum Diisi';
                ?>
                    <div class="question-card-modern <?= $answeredClass ?>">
                        <div class="question-meta-row">
                            <span class="question-num-tag">Pertanyaan <?= $i ?></span>
                            <span class="question-status-badge"><?= $statusText ?></span>
                        </div>
                        <p class="question-text-modern"><?= htmlspecialchars($questions[$i]) ?></p>
                        <div class="dropdown-wrapper-modern">
                            <select class="question-dropdown-modern" name="p<?= $i ?>" required>
                                <option value="">-- Pilih Jawaban Anda --</option>
                                <?php foreach ($opts as $opt): ?>
                                    <option value="<?= htmlspecialchars($opt) ?>" <?= (($old['p'][$i] ?? '') === $opt) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($opt) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            <!-- STEP 2: Q6 - Q10 -->
            <div class="wizard-step-pane" data-pane="2">
                <?php for ($i = 6; $i <= 10; $i++): 
                    $answeredClass = (($old['p'][$i] ?? '') !== '') ? 'answered' : '';
                    $statusText = (($old['p'][$i] ?? '') !== '') ? '<i class="fa fa-check-circle"></i> Selesai' : '<i class="fa fa-circle-thin"></i> Belum Diisi';
                ?>
                    <div class="question-card-modern <?= $answeredClass ?>">
                        <div class="question-meta-row">
                            <span class="question-num-tag">Pertanyaan <?= $i ?></span>
                            <span class="question-status-badge"><?= $statusText ?></span>
                        </div>
                        <p class="question-text-modern"><?= htmlspecialchars($questions[$i]) ?></p>
                        <div class="dropdown-wrapper-modern">
                            <select class="question-dropdown-modern" name="p<?= $i ?>" required>
                                <option value="">-- Pilih Jawaban Anda --</option>
                                <?php foreach ($opts as $opt): ?>
                                    <option value="<?= htmlspecialchars($opt) ?>" <?= (($old['p'][$i] ?? '') === $opt) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($opt) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            <!-- STEP 3: Q11 - Q15 -->
            <div class="wizard-step-pane" data-pane="3">
                <?php for ($i = 11; $i <= 15; $i++): 
                    $answeredClass = (($old['p'][$i] ?? '') !== '') ? 'answered' : '';
                    $statusText = (($old['p'][$i] ?? '') !== '') ? '<i class="fa fa-check-circle"></i> Selesai' : '<i class="fa fa-circle-thin"></i> Belum Diisi';
                ?>
                    <div class="question-card-modern <?= $answeredClass ?>">
                        <div class="question-meta-row">
                            <span class="question-num-tag">Pertanyaan <?= $i ?></span>
                            <span class="question-status-badge"><?= $statusText ?></span>
                        </div>
                        <p class="question-text-modern"><?= htmlspecialchars($questions[$i]) ?></p>
                        <div class="dropdown-wrapper-modern">
                            <select class="question-dropdown-modern" name="p<?= $i ?>" required>
                                <option value="">-- Pilih Jawaban Anda --</option>
                                <?php foreach ($opts as $opt): ?>
                                    <option value="<?= htmlspecialchars($opt) ?>" <?= (($old['p'][$i] ?? '') === $opt) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($opt) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            <!-- STEP 4: Q16 - Q20 -->
            <div class="wizard-step-pane" data-pane="4">
                <?php for ($i = 16; $i <= 20; $i++): 
                    $answeredClass = (($old['p'][$i] ?? '') !== '') ? 'answered' : '';
                    $statusText = (($old['p'][$i] ?? '') !== '') ? '<i class="fa fa-check-circle"></i> Selesai' : '<i class="fa fa-circle-thin"></i> Belum Diisi';
                ?>
                    <div class="question-card-modern <?= $answeredClass ?>">
                        <div class="question-meta-row">
                            <span class="question-num-tag">Pertanyaan <?= $i ?></span>
                            <span class="question-status-badge"><?= $statusText ?></span>
                        </div>
                        <p class="question-text-modern"><?= htmlspecialchars($questions[$i]) ?></p>
                        <div class="dropdown-wrapper-modern">
                            <select class="question-dropdown-modern" name="p<?= $i ?>" required>
                                <option value="">-- Pilih Jawaban Anda --</option>
                                <?php foreach ($opts as $opt): ?>
                                    <option value="<?= htmlspecialchars($opt) ?>" <?= (($old['p'][$i] ?? '') === $opt) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($opt) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

        </div>

        <!-- Navigation Buttons -->
        <div class="wizard-nav-wrapper">
            <button type="button" class="btn btn-wizard-nav btn-wizard-prev" id="btnPrev" style="display: none !important;">
                <i class="fa fa-arrow-left"></i> Sebelumnya
            </button>
            <div class="wizard-nav-right">
                <button type="button" class="btn btn-wizard-nav btn-wizard-next" id="btnNext" style="display: inline-flex !important;">
                    Selanjutnya <i class="fa fa-arrow-right"></i>
                </button>
                <button type="submit" name="submit" class="btn btn-wizard-nav btn-wizard-submit" id="btnSubmit" style="display: none !important;">
                    <i class="fa fa-save"></i> Kirim Jawaban
                </button>
            </div>
        </div>

    </div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let currentStep = 1;
    const totalSteps = 4;
    
    // Step Pane elements
    const panes = document.querySelectorAll(".wizard-step-pane");
    const stepNodes = document.querySelectorAll(".wizard-step-node");
    const stepLineFill = document.getElementById("stepLineFill");
    const progressBarFill = document.getElementById("progressBarFill");
    const progressText = document.getElementById("progressText");
    const stepTitleText = document.getElementById("stepTitleText");
    
    // Nav Button elements
    const btnPrev = document.getElementById("btnPrev");
    const btnNext = document.getElementById("btnNext");
    const btnSubmit = document.getElementById("btnSubmit");
    
    // Dropdowns
    const dropdowns = document.querySelectorAll(".question-dropdown-modern");
    
    const stepTitles = {
        1: "Langkah 1: Soal 1-5",
        2: "Langkah 2: Soal 6-10",
        3: "Langkah 3: Soal 11-15",
        4: "Langkah 4: Soal 16-20"
    };

    // Calculate & update progress bar
    function updateProgress() {
        let answered = 0;
        dropdowns.forEach(dropdown => {
            if (dropdown.value !== "") {
                answered++;
            }
        });
        const percent = Math.round((answered / 20) * 100);
        progressBarFill.style.width = percent + "%";
        progressText.innerHTML = `<i class="fa fa-check-square-o me-1"></i> <strong>${answered} dari 20</strong> Pertanyaan Terjawab (${percent}%)`;
        
        // Update completed states on step nodes
        updateStepNodesCompletedStates();
    }

    function updateStepNodesCompletedStates() {
        // Step 1: Q1-Q5
        let step1Ok = true;
        for(let i = 1; i <= 5; i++) {
            const dropdown = document.querySelector(`select[name="p${i}"]`);
            if(!dropdown || dropdown.value === "") { step1Ok = false; break; }
        }
        setStepNodeCompleted(1, step1Ok);

        // Step 2: Q6-Q10
        let step2Ok = true;
        for(let i = 6; i <= 10; i++) {
            const dropdown = document.querySelector(`select[name="p${i}"]`);
            if(!dropdown || dropdown.value === "") { step2Ok = false; break; }
        }
        setStepNodeCompleted(2, step2Ok);

        // Step 3: Q11-Q15
        let step3Ok = true;
        for(let i = 11; i <= 15; i++) {
            const dropdown = document.querySelector(`select[name="p${i}"]`);
            if(!dropdown || dropdown.value === "") { step3Ok = false; break; }
        }
        setStepNodeCompleted(3, step3Ok);

        // Step 4: Q16-Q20
        let step4Ok = true;
        for(let i = 16; i <= 20; i++) {
            const dropdown = document.querySelector(`select[name="p${i}"]`);
            if(!dropdown || dropdown.value === "") { step4Ok = false; break; }
        }
        setStepNodeCompleted(4, step4Ok);
    }

    function setStepNodeCompleted(stepNum, isCompleted) {
        const node = document.querySelector(`.wizard-step-node[data-step="${stepNum}"]`);
        if (node) {
            if (isCompleted) {
                node.classList.add("completed");
                node.innerHTML = '<i class="fa fa-check"></i>';
            } else {
                node.classList.remove("completed");
                node.innerHTML = stepNum;
            }
        }
    }

    // Toggle active pane display
    function goToStep(stepNum) {
        if (stepNum < 1 || stepNum > totalSteps) return;
        
        // Remove active class from active pane
        const activePane = document.querySelector(".wizard-step-pane.active-pane");
        if (activePane) {
            activePane.classList.remove("active-pane");
        }
        
        // Add active class to target pane
        const targetPane = document.querySelector(`.wizard-step-pane[data-pane="${stepNum}"]`);
        if (targetPane) {
            targetPane.classList.add("active-pane");
        }
        
        // Update nodes states
        stepNodes.forEach(node => {
            const nodeStep = parseInt(node.getAttribute("data-step"));
            if (nodeStep === stepNum) {
                node.classList.add("active");
            } else {
                node.classList.remove("active");
            }
        });
        
        // Update fill line between nodes
        const lineFillPercent = ((stepNum - 1) / (totalSteps - 1)) * 100;
        stepLineFill.style.width = lineFillPercent + "%";
        
        // Update title text
        stepTitleText.textContent = stepTitles[stepNum];
        
        // Update current step pointer
        currentStep = stepNum;
        
        // Update buttons visibility
        if (currentStep === 1) {
            btnPrev.style.setProperty("display", "none", "important");
        } else {
            btnPrev.style.setProperty("display", "inline-flex", "important");
        }
        
        if (currentStep === totalSteps) {
            btnNext.style.setProperty("display", "none", "important");
            btnSubmit.style.setProperty("display", "inline-flex", "important");
        } else {
            btnNext.style.setProperty("display", "inline-flex", "important");
            btnSubmit.style.setProperty("display", "none", "important");
        }

        // Smooth scroll to top of wizard to keep focus perfect
        const wizardForm = document.getElementById("wizardForm");
        wizardForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Step change listeners on dropdowns
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener("change", function() {
            const card = this.closest(".question-card-modern");
            if (this.value !== "") {
                card.classList.add("answered");
                card.querySelector(".question-status-badge").innerHTML = '<i class="fa fa-check-circle"></i> Selesai';
            } else {
                card.classList.remove("answered");
                card.querySelector(".question-status-badge").innerHTML = '<i class="fa fa-circle-thin"></i> Belum Diisi';
            }
            updateProgress();
        });
    });

    // Validate identity data
    function validateIdentitas() {
        const namaInput = document.getElementById("inputNama");
        
        if (!namaInput.value.trim()) {
            Swal.fire({
                title: 'Data Belum Lengkap',
                text: 'Silakan isi Nama Lengkap Anak terlebih dahulu.',
                icon: 'warning',
                confirmButtonColor: '#1e293b'
            });
            namaInput.focus();
            return false;
        }
        
        return true;
    }

    // Validate current pane questions
    function validateCurrentPane() {
        if (!validateIdentitas()) return false;
        
        const activePane = document.querySelector(`.wizard-step-pane[data-pane="${currentStep}"]`);
        const activeSelects = activePane.querySelectorAll(".question-dropdown-modern");
        
        let allAnswered = true;
        let firstUnanswered = null;
        
        activeSelects.forEach(select => {
            if (select.value === "") {
                allAnswered = false;
                if (!firstUnanswered) firstUnanswered = select;
            }
        });
        
        if (!allAnswered) {
            Swal.fire({
                title: 'Pertanyaan Belum Terjawab',
                text: 'Mohon isi semua pertanyaan di langkah ini sebelum melanjutkan.',
                icon: 'warning',
                confirmButtonColor: '#1e293b'
            });
            if (firstUnanswered) {
                firstUnanswered.closest(".question-card-modern").scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstUnanswered.focus();
            }
            return false;
        }
        
        return true;
    }

    // Nav Button Clicks
    btnNext.addEventListener("click", function() {
        if (validateCurrentPane()) {
            goToStep(currentStep + 1);
        }
    });

    btnPrev.addEventListener("click", function() {
        goToStep(currentStep - 1);
    });

    // Node clicks (allow navigation directly if valid)
    stepNodes.forEach(node => {
        node.addEventListener("click", function() {
            const targetStep = parseInt(this.getAttribute("data-step"));
            if (targetStep === currentStep) return;
            
            // Allow going backward freely
            if (targetStep < currentStep) {
                goToStep(targetStep);
            } else {
                // To go forward, we must validate current step
                if (validateCurrentPane()) {
                    goToStep(targetStep);
                }
            }
        });
    });

    // Full form submit verification
    const form = document.getElementById("wizardForm");
    form.addEventListener("submit", function(e) {
        if (!validateIdentitas()) {
            e.preventDefault();
            return false;
        }
        
        // Final sanity check for all 20 questions
        let unansweredCount = 0;
        let firstUnanswered = null;
        let unansweredStepNum = 1;
        
        for (let s = 1; s <= totalSteps; s++) {
            const pane = document.querySelector(`.wizard-step-pane[data-pane="${s}"]`);
            const paneSelects = pane.querySelectorAll(".question-dropdown-modern");
            
            paneSelects.forEach(select => {
                if (select.value === "") {
                    unansweredCount++;
                    if (!firstUnanswered) {
                        firstUnanswered = select;
                        unansweredStepNum = s;
                    }
                }
            });
        }
        
        if (unansweredCount > 0) {
            e.preventDefault();
            Swal.fire({
                title: 'Data Belum Lengkap',
                text: `Terdapat ${unansweredCount} pertanyaan yang belum Anda jawab. Silakan lengkapi terlebih dahulu.`,
                icon: 'warning',
                confirmButtonColor: '#1e293b'
            }).then(() => {
                goToStep(unansweredStepNum);
                setTimeout(() => {
                    if (firstUnanswered) {
                        firstUnanswered.closest(".question-card-modern").scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstUnanswered.focus();
                    }
                }, 400);
            });
            return false;
        }
    });

    // Initialize progress bar state on load
    updateProgress();
});
</script>