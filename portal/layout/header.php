<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
  <div class="container-fluid py-1 px-2 px-md-3">
    <nav aria-label="breadcrumb">
      <h6 class="font-weight-bolder mb-0">
        <?php
        foreach ($breadcrumb as $key => $bread) {
          $bc[] = '<a href="' . $bread['link'] . '" class="' . ($key == count($breadcrumb) - 1 ? 'text-primary' : 'text-secondary') . '">' . $bread['text'] . '</a>';
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
      <ul class="navbar-nav ms-auto d-flex align-items-center flex-row flex-md-row">
        <li class="nav-item d-none d-md-flex align-items-center pe-3">
          <a href="#" class="nav-link text-body font-weight-bold px-0" style="font-size:0.85rem;">
            <div class="d-flex align-items-center">
              <div style="width:32px;height:32px;border-radius:10px;background:var(--gradient-primary);display:flex;align-items:center;justify-content:center;margin-right:8px;">
                <i class="fa fa-user" style="color:#fff;font-size:0.75rem;"></i>
              </div>
              <span class="d-sm-inline d-none"><?php echo htmlspecialchars($_SESSION['nama'] ?? '') ?></span>
            </div>
          </a>
        </li>
        <li class="nav-item ms-auto ms-md-0 d-flex align-items-center">
          <a class="btn bg-gradient-primary btn-sm mb-0 me-0 me-md-3" onclick="logout()" style="border-radius:10px;">
            <i class="fa fa-sign-out-alt me-1"></i>Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>