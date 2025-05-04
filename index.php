<?php
session_start();
?>

<?php include_once('template/header.php') ?>

<main class="full-bg d-flex align-items-center justify-content-center">
  <div class="text-center">
    <h1 class="welcome-text">Welcome!</h1>
    <p class="tagline-text">“Safety Isn't Optional, Because Your Journey Deserves Protection – It's Standard with GoTranspo”</p>

    <div class="mt-4 d-flex justify-content-center gap-3">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signupModal">
        <i class="bi bi-person-plus-fill me-2"></i> Sign Up
      </button>

      <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#signinModal">
        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
      </button>
    </div>
  </div>
</main>

<!-- Sign In Modal -->
<div class="modal fade" id="signinModal" tabindex="-1" aria-labelledby="signinModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-0">
        <h5 class="modal-title mx-auto" id="signinModalLabel">
          <i class="bi bi-person-circle fs-2 me-2"></i> Sign In
        </h5>
        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3 mt-3" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="function/login.php" method="post">
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" id="email" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" required />
          </div>
          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>

        <div class="text-center my-2">
          <span class="text-secondary">or sign in with</span>
        </div>

        <div class="d-flex justify-content-center gap-3 mb-3">
          <a href="#" class="btn btn-light text-dark"><i class="bi bi-google me-1"></i> Google</a>
          <a href="#" class="btn btn-primary"><i class="bi bi-facebook me-1"></i> Facebook</a>
        </div>

        <div class="text-center">
          <small class="text-secondary">Don't have an account?</small>
          <a href="signup.php" class="text-white text-decoration-underline ms-1">Sign Up</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Sign Up Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-0">
        <h5 class="modal-title">
          <i class="bi bi-person-plus-fill fs-2 me-2"></i> Sign Up
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="function/insert.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="agree" name="agree" required>
            <label class="form-check-label" for="agree">I agree to the Terms and Conditions</label>
          </div>

          <div class="d-grid mb-3">
            <button class="btn btn-primary" type="submit">Create Account</button>
          </div>
        </form>

        <div class="text-center my-2">
          <span class="text-secondary">or sign up with</span>
        </div>

        <div class="d-flex justify-content-center gap-3 mb-3">
          <a href="#" class="btn btn-light text-dark"><i class="bi bi-google me-1"></i> Google</a>
          <a href="#" class="btn btn-primary"><i class="bi bi-facebook me-1"></i> Facebook</a>
        </div>

        <div class="text-center">
          <small class="text-secondary">Already have an account?</small>
          <a href="#" data-bs-toggle="modal" data-bs-target="#signinModal" class="text-white text-decoration-underline ms-1">Sign In</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('template/footer.php') ?>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
if (isset($_SESSION['login_success'])) {
  echo "<script>
    Swal.fire({
      icon: 'success',
      title: 'Login Successful!',
      text: 'Welcome back!',
      timer: 2000,
      showConfirmButton: false
    });
  </script>";
  unset($_SESSION['login_success']);
}

if (isset($_SESSION['login_failed'])) {
  echo "<script>
    Swal.fire({
      icon: 'error',
      title: 'Login Failed',
      text: 'Invalid email or password.'
    }).then(() => {
      var loginModal = new bootstrap.Modal(document.getElementById('signinModal'));
      loginModal.show();
    });
  </script>";
  unset($_SESSION['login_failed']);
}

if (isset($_SESSION['signup_success'])) {
  echo "<script>
    Swal.fire({
      icon: 'success',
      title: 'Account Created!',
      text: 'You can now log in.',
      timer: 2000,
      showConfirmButton: false
    });
  </script>";
  unset($_SESSION['signup_success']);
}

if (isset($_SESSION['signup_failed'])) {
  echo "<script>
    Swal.fire({
      icon: 'error',
      title: 'Signup Failed',
      text: 'Something went wrong. Try again.'
    }).then(() => {
      var signupModal = new bootstrap.Modal(document.getElementById('signupModal'));
      signupModal.show();
    });
  </script>";
  unset($_SESSION['signup_failed']);
}
?>
