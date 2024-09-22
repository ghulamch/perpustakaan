<?php
require '../db_connection.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
  // Jika sesi belum ada atau peran pengguna tidak sesuai, arahkan ke halaman login
  header("Location: ../auth-login.php");
  exit();
}

// Pastikan ID ada di parameter URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = $_GET['id'];

  // Validasi ID untuk memastikan bahwa itu adalah angka
  if (!filter_var($id, FILTER_VALIDATE_INT)) {
    die("ID tidak valid.");
  }

  // Persiapkan statement SQL
  $stmt = $conn->prepare("SELECT id, judul, penerbit, isbn, edisi, penulis, link_cover, link_buku, link_unduh FROM daftarbuku WHERE id = ?");
  $stmt->bind_param("i", $id);

  // Eksekusi statement
  $stmt->execute();

  // Ambil hasil
  $result = $stmt->get_result();
  $book = $result->fetch_assoc();

  if (!$book) {
    die("Buku tidak ditemukan.");
  }

  // Tutup statement dan koneksi
  $stmt->close();
  $conn->close();
} else {
  die("ID tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="assets/sneat/assets/"
  data-template="vertical-menu-template-free">
<meta charset="utf-8" />
<meta
  name="viewport"
  content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

<title><?php echo htmlspecialchars($book['judul']); ?> | Perpustakaan Digital</title>

<meta name="description" content="" />

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="../assets/sneat/assets/img/favicon/favicon.ico" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
  rel="stylesheet" />

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="../assets/sneat/assets/vendor/fonts/boxicons.css" />

<!-- Core CSS -->
<link rel="stylesheet" href="../assets/sneat/assets/vendor/css/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="../assets/sneat/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="../assets/sneat/assets/css/demo.css" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="../assets/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

<link rel="stylesheet" href="../assets/sneat/assets/vendor/libs/apex-charts/apex-charts.css" />

<!-- Page CSS -->

<!-- Helpers -->
<script src="../assets/sneat/assets/vendor/js/helpers.js"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="../assets/sneat/assets/js/config.js"></script>


<style>
  .img-max-size {
    max-width: 25%;
    /* Adjust to fit within container */
    height: auto;
    /* Maintain aspect ratio */
    object-fit: cover;
    /* Ensure image covers the area without distortion */
  }

  .pdf-container {
    position: relative;
    padding-top: 56.25%;
    /* 16:9 Aspect Ratio */
    height: 0;
    overflow: hidden;
  }

  .pdf-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }
</style>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="index.php" class="app-brand-link">
            <span class="app-brand-logo demo">
              <svg
                width="25"
                viewBox="0 0 25 42"
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                  <path
                    d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                    id="path-1"></path>
                  <path
                    d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                    id="path-3"></path>
                  <path
                    d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                    id="path-4"></path>
                  <path
                    d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                    id="path-5"></path>
                </defs>
                <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                    <g id="Icon" transform="translate(27.000000, 15.000000)">
                      <g id="Mask" transform="translate(0.000000, 8.000000)">
                        <mask id="mask-2" fill="white">
                          <use xlink:href="#path-1"></use>
                        </mask>
                        <use fill="#696cff" xlink:href="#path-1"></use>
                        <g id="Path-3" mask="url(#mask-2)">
                          <use fill="#696cff" xlink:href="#path-3"></use>
                          <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                        </g>
                        <g id="Path-4" mask="url(#mask-2)">
                          <use fill="#696cff" xlink:href="#path-4"></use>
                          <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                        </g>
                      </g>
                      <g
                        id="Triangle"
                        transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                        <use fill="#696cff" xlink:href="#path-5"></use>
                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                      </g>
                    </g>
                  </g>
                </g>
              </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">PusDig</span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
          <!-- Dashboard -->
          <li class="menu-item ">
            <a href="index.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-circle"></i>
              <div data-i18n="Analytics">Dashboard</div>
            </a>
          </li>
          <!-- Perpustakaan -->
          <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Perpustakaan</span>
          </li>
          <li class="menu-item active">
            <a
              href="daftarbuku.php"
              class="menu-link">
              <i class="menu-icon tf-icons bx bx-book"></i>
              <div data-i18n="Support">Daftar Buku</div>
            </a>
          </li>
          <!-- Akun -->
          <li class="menu-header small text-uppercase"><span class="menu-header-text">Akun</span></li>
          <li class="menu-item ">
            <a href="akun.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-user"></i>
              <div data-i18n="Support">Akun</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="logout.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-power-off"></i>
              <div data-i18n="Support">Keluar</div>
            </a>
          </li>
        </ul>
        </li>
        </ul>
      </aside>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm"></i>
            </a>
          </div>
          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto">
            </ul>
          </div>
        </nav>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Content -->
            <div class="col-md-12 col-lg-12 mb-3">
              <div class="card h-100">
                <div class="card-body">
                  <h4 class="card-title"><?php echo htmlspecialchars($book['judul']); ?></h4>
                  <img src="<?php echo htmlspecialchars($book['link_cover']); ?>" class="card-img-top img-max-size mb-3" alt="Cover Buku">
                  <p class="card-text"><strong>Penerbit:</strong> <?php echo htmlspecialchars($book['penerbit']); ?></p>
                  <p class="card-text"><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>
                  <p class="card-text"><strong>Edisi:</strong> <?php echo htmlspecialchars($book['edisi']); ?></p>
                  <p class="card-text"><strong>Penulis:</strong> <?php echo htmlspecialchars($book['penulis']); ?></p>
                  <a href="<?php echo htmlspecialchars($book['link_unduh']); ?>" class="btn btn-outline-primary">Unduh PDF</a>
                  <a type="button" class="btn btn-primary" href="<?php echo htmlspecialchars($book['link_buku']); ?>">
                    Baca Online
                  </a>
                </div>
              </div>
            </div>

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  © XII - 1
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://instagram.com/_ghulamc_" target="_blank" class="footer-link fw-bolder">Ghulamin Chalim Alwi</a>
                </div>

              </div>
          </div>
          </footer>
          <!-- / Footer -->
        </div>
      </div>
      <!-- / Content wrapper -->
    </div>
    <!-- / Layout container -->
  </div>
  </div>

  <script src="../assets/sneat/assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/sneat/assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/sneat/assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="../assets/sneat/assets/vendor/js/menu.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var modalImg = document.getElementById('modal-cover-img');

      document.querySelectorAll('.cover-img').forEach(function(img) {
        img.addEventListener('click', function() {
          modalImg.src = img.src;
          var myModal = new bootstrap.Modal(document.getElementById('coverModal'));
          myModal.show();
        });
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var detailModal = new bootstrap.Modal(document.getElementById('detailModal'));

      document.querySelectorAll('.detail-btn').forEach(function(button) {
        button.addEventListener('click', function() {
          var row = button.closest('tr');
          document.getElementById('modal-judul').textContent = row.querySelector('.judul').textContent;
          document.getElementById('modal-penerbit').textContent = row.querySelector('.penerbit').textContent;
          document.getElementById('modal-isbn').textContent = row.querySelector('.isbn').textContent;
          document.getElementById('modal-edisi').textContent = row.querySelector('.edisi').textContent;
          document.getElementById('modal-penulis').textContent = row.querySelector('.penulis').textContent;

          detailModal.show();
        });
      });
    });
  </script>


  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="../assets/sneat/assets/vendor/libs/apex-charts/apexcharts.js"></script>

  <!-- Main JS -->
  <script src="../assets/sneat/assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="../assets/sneat/assets/js/dashboards-analytics.js"></script>

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>