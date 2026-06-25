<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 mt-3 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
  <div class="container-fluid py-1 px-2 px-md-3">
    <nav aria-label="breadcrumb">
      <h6 class="font-weight-bolder mb-0">
        <?php
        foreach ($breadcrumb as $key => $bread) {
          $bc[] = '<a href="' . $bread['link'] . '" class="' . ($key == count($breadcrumb) - 1 ? 'text-dark' : 'text-secondary') . '" style="font-weight:700;">' . $bread['text'] . '</a>';
        }
        echo implode(" <span class='breadcrumb-separator' style='padding:0 8px;opacity:0.4;'>›</span> ", $bc);
        ?>
      </h6>
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        <div class="input-group" hidden>
          <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
          <input type="text" class="form-control" placeholder="Type here...">
        </div>
      </div>
      <ul class="navbar-nav ms-auto d-flex align-items-center flex-row gap-2 justify-content-end w-100 w-md-auto">
        <li class="nav-item d-none d-md-flex align-items-center pe-3">
          <a href="#" class="nav-link text-body font-weight-bold px-0" style="font-size:0.85rem; cursor: default;">
            <span class="d-sm-inline d-none"><?php echo htmlspecialchars($_SESSION['nama'] ?? '') ?></span>
          </a>
        </li>
        <li class="nav-item d-none d-md-flex align-items-center">
          <a href="../index.php" class="btn btn-sm mb-0" style="border-radius:10px; border: 1.5px solid #627594; color: #627594; display:inline-flex; align-items:center; gap:6px; padding:5px 14px; font-weight:600; font-size:0.75rem; background:transparent;">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="#627594" class="bi bi-house-door-fill" viewBox="0 0 16 16" style="vertical-align: middle;">
              <path d="M6.5 14.5v-3.507c0-.235.19-.425.424-.425h2.152c.234 0 .424.19.424.425v3.507c0 .234-.19.425-.424.425H6.924a.425.425 0 0 1-.424-.425z"/>
              <path d="M1.123 7.81a.5.5 0 0 1 .151-.708l6-4a.5.5 0 0 1 .593 0l6 4a.5.5 0 0 1-.555.83l-.382-.254V13.5A1.5 1.5 0 0 1 11.5 15h-7A1.5 1.5 0 0 1 3 13.5V7.686l-.38.254a.5.5 0 0 1-.708-.13z"/>
            </svg>
            <span>Home Page</span>
          </a>
        </li>
        <li class="nav-item d-flex align-items-center">
          <a class="btn btn-sm mb-0" onclick="logout()" style="border-radius:10px;background:var(--gradient-primary,linear-gradient(135deg,#0f172a,#334155));color:#fff;border:none;display:inline-flex;align-items:center;gap:6px;padding:6px 14px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" viewBox="0 0 16 16" style="vertical-align: middle;">
              <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
              <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
            </svg>
            <span>Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>