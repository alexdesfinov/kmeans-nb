<?php

foreach ($js as $key => $value) { ?>
  <script src="<?= $value ?>"></script>
<?php
}
?>
<script>
  $(document).ready(function() {

    $('#datatables').DataTable({ "order": [[1, "asc"]] });
    $('#datatables2').DataTable({ "order": [[1, "asc"]] });
    $('#datatablesDataset').DataTable({ "order": [[1, "asc"]] });
    $('#datatablesHasilNB').DataTable({ "order": [[1, "asc"]] });
    $('[data-toggle="tooltip"]').tooltip()

    $('.owl-carousel').owlCarousel();
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