<?=$this->extend('layout/template');?>
<?=$this->section('content');?>

<div class="container-fluid">
    <div id="pesan" data-pesan="<?=session()->getFlashdata('pesan')?>"></div>
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-gradient-blue">
                <div class="inner">
                    <h3><?=esc($produk)?></h3>
                    <p>Barang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cube"></i>
                </div>
                <a href="<?=base_url('master/barang')?>" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
       
    </div>
</div><!-- /.container-fluid -->
<?=$this->endSection();?>

<?=$this->section('js');?>
<script src="<?=base_url('plugins/chart.js/Chart.min.js')?>"></script>
<script src="<?=base_url('js/dashboard.js')?>"></script>
<?=$this->endSection();?>