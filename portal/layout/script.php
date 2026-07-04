<?php

foreach ($js as $key => $value) { ?>
  <script src="<?= $value ?>"></script>
<?php
}
?>
<script>
  $(document).ready(function() {

    $('#datatables').DataTable({ "order": [[0, "asc"]] });
    $('#datatables2').DataTable({ "order": [[0, "asc"]] });
    $('#datatablesDataset').DataTable({ "order": [[0, "asc"]] });
    $('#datatablesHasilNB').DataTable({ "order": [[0, "asc"]] });
    $('[data-toggle="tooltip"]').tooltip()
  });
</script>

<script type="text/javascript">
  function logout() {
    Swal.fire({
      title: 'Yakin untuk logout',
      text: "Anda akan diarahkan ke laman login",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#1e293b',
      cancelButtonColor: '#ccc',
      confirmButtonText: 'Logout',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?logout'
      }
    })
  }
</script>

<script>
  document.addEventListener("submit", function(e) {
    const form = e.target;

    // hanya intercept form hapus item
    if (!form.classList.contains("form-hapus-item")) return;

    e.preventDefault();

    Swal.fire({
      title: 'Yakin untuk Hapus?',
      text: 'Data akan dihapus permanen.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Hapus',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#1e293b',
      cancelButtonColor: '#ccc'
    }).then((result) => {
      if (result.isConfirmed) form.submit();
    });
  });
</script>

<script>
  document.addEventListener("submit", function(e) {
    const form = e.target;

    if (!form.classList.contains("form-hapus-semua")) return;

    e.preventDefault();

    Swal.fire({
      title: 'Yakin untuk Hapus Semua?',
      text: 'Semua data akan dihapus permanen.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Hapus Semua',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#1e293b',
      cancelButtonColor: '#ccc'
    }).then((result) => {
      if (result.isConfirmed) form.submit();
    });
  });
</script>

<script>
  // Global password visibility toggle
  document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".btn-toggle-password").forEach(function(btn) {
      btn.addEventListener("click", function() {
        const container = btn.closest(".position-relative");
        if (!container) return;
        const input = container.querySelector("input[type='password'], input[type='text']");
        const icon = btn.querySelector("i");
        if (!input || !icon) return;

        const isPassword = input.getAttribute("type") === "password";
        input.setAttribute("type", isPassword ? "text" : "password");
        if (isPassword) {
          icon.classList.remove("fa-eye-slash");
          icon.classList.add("fa-eye");
        } else {
          icon.classList.remove("fa-eye");
          icon.classList.add("fa-eye-slash");
        }
      });
    });
  });
</script>