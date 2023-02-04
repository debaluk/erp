<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="javascript:void(0)" class="brand-link">
        <span class="brand-text font-weight-light">Inventori</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            
            <div class="info">
                <a href="javascript:void(0)" class="d-block"></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
       
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url('inv/dashboard') ?>" class="nav-link">
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
                            <a href="<?= base_url('master/kategoribarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori Barang</p>
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a href="<?= base_url('master/jenisbarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jenis Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/gudang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gudang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/barang') ?>" class="nav-link">
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
                            <a href="<?= base_url('transaksi/penerimaanbarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penerimaan Barang</p>
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a href="<?= base_url('transaks/pengeluaranbarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengeluaran Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('transaksi/transferbarang') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transfer Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('transaksi/stockopname') ?>" class="nav-link">
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
                            <a href="<?= base_url('report/stokupdate') ?>" class="nav-link">
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
    <!-- /.sidebar -->
   
</aside>