<?php // this file is included by index.php and expects $token from CSRF::start() ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Patient Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="card shadow-sm">
    <div class="card-body">
      <h4 class="card-title mb-3">Patient Registration</h4>
      <form id="regForm" novalidate>
        <input type="hidden" name="csrf_token" id="csrf_token" value="<?= htmlspecialchars($token) ?>">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Patient ID *</label>
            <input class="form-control" name="id" id="id" required>
            <div class="invalid-feedback">Please provide patient ID.</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Family name *</label>
            <input class="form-control" name="family_name" id="family_name" required>
            <div class="invalid-feedback">Family name required.</div>
          </div>

          <div class="col-md-6">
            <label class="form-label">Given name *</label>
            <input class="form-control" name="given_name" id="given_name" required>
            <div class="invalid-feedback">Given name required.</div>
          </div>

          <div class="col-md-6">
            <label class="form-label">Gender *</label>
            <select class="form-select" name="gender" id="gender" required>
              <option value="">Choose...</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
            <div class="invalid-feedback">Select gender.</div>
          </div>

          <div class="col-md-4">
            <label class="form-label">Birth date</label>
            <input type="date" class="form-control" name="birth_date" id="birth_date">
          </div>

          <div class="col-md-4">
            <label class="form-label">Phone</label>
            <input class="form-control" name="phone" id="phone">
            <div class="invalid-feedback">Enter a valid phone.</div>
          </div>

          <div class="col-md-4">
            <label class="form-label">Nationality</label>
            <input class="form-control" name="nationality" id="nationality" value="RW">
          </div>

          <div class="col-12">
            <label class="form-label">Religion</label>
            <input class="form-control" name="religion" id="religion">
          </div>

          <div class="col-12 text-end mt-2">
            <button class="btn btn-primary" id="submitBtn" type="submit">Register</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../js/register.js"></script>

</body>
</html>
