
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="javascript:void(0)" class="brand-link">
        <span class="brand-text font-weight-light">
       <div align="center">
       <?php 
       $uri = current_url(true); 
       $uri->getSegment(1);
        if ($uri->getSegment(1)=='inv')
        {
            $namamodul='INVENTORI';
        }
        if ($uri->getSegment(1)=='hrd')
        {
            $namamodul='HRD';
        }
        if ($uri->getSegment(1)=='proc')
        {
            $namamodul='PROCERUMENT';
        }
        if ($uri->getSegment(1)=='pro')
        {
            $namamodul='PRODUKSI';
        }
        if ($uri->getSegment(1)=='aset')
        {
            $namamodul='ASET MANAJEMEN';
        }
        if ($uri->getSegment(1)=='sale')
        {
            $namamodul='PENJUALAN';
        }
        echo $namamodul;
        ?>
        </div>
        </span>
    </a>

    <!-- Sidebar -->
    <?php if ($uri->getSegment(1)=='inv') { ?>
    <div class="sidebar">
       
        <!-- Sidebar Menu -->
       
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>

               
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p> Master <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('inv/master/satuan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Satuan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('inv/master/kategoribarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori Barang</p>
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a href="<?= base_url('inv/master/jenisbarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jenis Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('inv/master/gudang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gudang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('inv/master/barang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Barang</p>
                            </a>
                        </li>
                       
                    </ul>
                </li>
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p> Transaksi <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('inv/transaksi/penerimaanbarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penerimaan Barang</p>
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a href="<?= base_url('inv/transaks/pengeluaranbarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengeluaran Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('inv/transaksi/transferbarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transfer Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('inv/transaksi/stockopname') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock opname </p>
                            </a>
                        </li>
                       
                    </ul>
                </li>
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p> Report <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('inv/report/stokupdate') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock Update</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
               
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <?php } ?>
    <!-- /.sidebar -->
    <?php if ($uri->getSegment(1)=='proc') { ?>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                    <i class="nav-icon fas fa-table"></i>
                        <p> Master <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('proc/master/kategorivendor') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori  Vendor </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('proc/master/vendor') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Vendor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('proc/master/mapingbarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Barang Vendor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('proc/master/kategoriupah') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori Upah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('proc/master/jenisupah') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jenis Upah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('proc/master/upah') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Upah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('proc/master/overhead') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Overhead</p>
                            </a>
                        </li>
                       
                      
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p> Transaksi <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('proc/penjualan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penjualan</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php } ?>
    <?php if ($uri->getSegment(1)=='hrd') { ?>
    <div class="sidebar">
    <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>

               
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p> Master <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item menu-is-opening menu-open">
                            <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>Wilayah
                            <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: block;">
                           
                                <li class="nav-item">
                                <a href="<?= base_url('hrd/master/propinsi') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Propinsi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('hrd/master/kabupaten') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kabupaten</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('hrd/master/kecamatan') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kecamatan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('hrd/master/desa') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Desa</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                       
                    </ul>
                </li>
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p> Transaksi <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                       
                        <li class="nav-item">
                            <a href="<?= base_url('hrd/transaksi/karyawan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pekerja</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('hrd/user') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Akun</p>
                            </a>
                        </li>
                       
                    </ul>
                </li>
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p> Report <i class="right fas fa-angle-left"></i></p>
                    </a>
                    
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
               
            </ul>
        </nav>
    <?php } ?>
    <?php if ($uri->getSegment(1)=='pro') { ?>
    <div class="sidebar">
       
        <!-- Sidebar Menu -->
       
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>

               
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p> Master <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('pro/master/bentuk') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Bentuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('pro/master/bahan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Bahan</p>
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a href="<?= base_url('pro/master/diamond') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Diamond</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('pro/master/permata') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permata</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('pro/master/barang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Barang Jadi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('pro/master/kategorijasa') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori Jasa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('pro/master/jasa') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jasa</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p> Transaksi <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('pro/transaksi/penerimaanbarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penerimaan Barang</p>
                            </a>
                        </li>
                       
                    </ul>
                </li>
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p> Report <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('pro/report/stokupdate') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock Update</p>
                            </a>
                        </li>
                    </ul>
                    
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
               
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <?php } ?>

    <?php if ($uri->getSegment(1)=='aset') { ?>
    <div class="sidebar">
       
        <!-- Sidebar Menu -->
       
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>

               
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p> Master <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('aset/master/kategoriaset') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori Aset</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('aset/master/jenisaset') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jenis Aset</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('aset/master/aset') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Aset</p>
                            </a>
                        </li>
                       
                        
                    </ul>
                </li>
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p> Transaksi <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('pro/transaksi/penerimaanbarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penerimaan Barang</p>
                            </a>
                        </li>
                       
                    </ul>
                </li>
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p> Report <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('pro/report/stokupdate') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock Update</p>
                            </a>
                        </li>
                    </ul>
                    
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
               
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <?php } ?>
    <?php if ($uri->getSegment(1)=='sale') { ?>
    <div class="sidebar">
       
        <!-- Sidebar Menu -->
       
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>

               
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p> Master <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('pro/master/bentuk') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Bentuk</p>
                            </a>
                        </li>
                       
                        
                    </ul>
                </li>
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p> Transaksi <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('pro/transaksi/penerimaanbarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penerimaan Barang</p>
                            </a>
                        </li>
                       
                    </ul>
                </li>
                <li class="nav-item active">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p> Report <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('pro/report/stokupdate') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock Update</p>
                            </a>
                        </li>
                    </ul>
                    
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
               
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <?php } ?>
</aside>