<?= $this->extend('auth/auth_dashboard'); ?>
<?= $this->section('pilihmodul'); ?>

<div class="login-logo">
    <a href="javascript:void(0)"><b><?= esc($title); ?></b></a>
</div>
<div class="col-md-1"></div>
<div class="col-md-10">
    <div class="row">

        <?php foreach (esc($aksesmodul) as $data) : ?>
        
        <div class="col-lg-3 col-6">
        <a href="<?= base_url($data->link_url) ?>">
            <div class="small-box bg-info">
                <div class="inner">
            
                        <h3> <?= esc($data->keterangan) ?></h3>
                    
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                
            </div> </a>
        </div>
        <?php endforeach ?>
    
    </div>
</div>
<div class="col-md-1"></div>

<?= $this->endSection(); ?>




