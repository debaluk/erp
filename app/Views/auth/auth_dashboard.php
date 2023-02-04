<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
    
</head>

<body class="hold-transition">
    <div class="">
        
        <?= $this->renderSection('pilihmodul'); ?>
    </div>
    <!-- /.login-box -->
    <!-- jQuery -->
    <script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Toastr -->
    <script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
    <script src="<?= base_url('js/script.js') ?>"></script>
    <script src="<?= base_url('js/auth.js') ?>"></script>
    <?= $this->renderSection('js'); ?>
</body>

</html>