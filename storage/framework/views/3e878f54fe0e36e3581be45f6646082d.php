<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title ?? config('app.name')); ?></title>
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(asset('images/kopcv.jpg')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('images/kopcv.jpg')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('images/kopcv.jpg')); ?>">
    
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss']); ?>
    
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

  </head>
  <body class="">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <?php echo e($slot); ?>

            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

  </body>
  </html>
<?php /**PATH D:\Bengkel Proyek\resources\views/layouts/guest.blade.php ENDPATH**/ ?>