<?= $this->extend('auth/auth_template'); ?>
<?= $this->section('auth'); ?>

<div class="login-logo">
    <a href="javascript:void(0)"><b><?= esc($title); ?></b></a>
</div>
<div class=" wrapper">
<div class="col-md-12">
  
        <?php foreach (esc($aksesmodul) as $data) : ?>
            <?= esc($data->id_role) ?>
           
            <a href="<?= base_url($data->link_url) ?>">
            <div class="col-md-3">
                
                <div class="small-box bg-danger">
                    
                    <h3> <?= esc($data->keterangan) ?></h3>
                
                </div>
             </div>
            </a>
                
            <?php endforeach ?>
   
</div>
</div>
<?= $this->endSection(); ?>