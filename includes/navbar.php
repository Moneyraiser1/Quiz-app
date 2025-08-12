<style>
  
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
  <div class="container-fluid">
    <!-- Logo Left -->
    <a class="navbar-brand fw-bold text-orange" href="<?= APPURL ?>/index" style="color: #f7941d;">
      Logo
    </a>

    <!-- Toggler for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="mynavbar">
      <!-- Centered Nav Links -->
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= APPURL ?>/index?home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= APPURL ?>/index?quiz">Quiz</a>
        </li>


      </ul>

      <!-- Right-side auth buttons -->
      <div class="d-flex">
        <?php if (!isset($_SESSION['username'])): ?>
          <a href="<?= APPURL ?>/auth/login" class="btn btn-outline-warning me-2">Sign in</a>
          <a href="<?= APPURL ?>/auth/register" class="btn btn-warning text-white">Sign up</a>
        <?php else: ?>
          <a href="<?= APPURL ?>/auth/logout" class="btn btn-danger">Logout</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
