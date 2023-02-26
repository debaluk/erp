<?php $this->extend('layout/template'); ?>
<?php $this->section('content'); ?>

<div class="container-fluid">
    <button class="btn btn-primary mb-1 tambah"><i class="fas fa-plus"></i> Tambah</button>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-kategori" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIK</th>
                            <th>Nama Karyawan</th>
                            <th>No Hp</th>
                            <th>No WA</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
    <?= form_open_multipart('', ['csrf_id' => 'token']); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">NIK</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nik" id="nik" >
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Nama Karyawan</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama_pekerja" id="nama_pekerja" >
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
               
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">No. HP</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="no_hp" id="no_hp" >
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">No. WA</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="no_wa" id="no_wa" >
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
               
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="email" id="email" >
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Propinsi</label>
                    <div class="col-sm-8">
                    <select name="prov_id" id="prov_id" class="form-control">
                        <option value="">Pilih</option>
                            <?php foreach (esc($propinsi) as $data) : ?>
                                <option value="<?= esc($data->id) ?>"><?= esc($data->nama) ?></option>
                            <?php endforeach; ?>
                        </option>
                            </select>
                            <small class="invalid-feedback"></small>
                    </div>
                </div>
               
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Kabupaten</label>
                    <div class="col-sm-8">
                        <select id="kab_id" name='kab_id' class="form-control">
                         <option value="">Pilih</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Kecamatan</label>
                    <div class="col-sm-8">
                         <select id="kec_id" name='kec_id' class="form-control">
                            <option value="">Pilih</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Desa</label>
                    <div class="col-sm-8">
                        <select id="desa_id" name='desa_id' class="form-control">
                            <option value="">Pilih</option>
                        </select>
                    </div>
                    
                </div>
               
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Alamat</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="alamat" id="alamat"></textarea>
                       
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>               
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<!--handle kokies dengan jquery-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        
        const table = $("#table-kategori").DataTable({
            proseccing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: `${BASE_URL}/hrd/transaksi/karyawan/ajax`
            },
            //optional
            lengthMenu: [
                [10, 25,50,100],
                [10, 25,50,100]
            ],
            language: {
				"zeroRecords": 	"Data kosong",
				"lengthMenu" : 	"Tampilkan _MENU_ baris data",
				"search":		"Pencarian:",
				"paginate":		{
									"first": "<<",
									"lasst": ">>",
									"next": ">",
									"previous": "<"
				},
				"info":			"Menampilkan _START_ sampai _END_ dari _TOTAL_ baris data",
				"infoEmpty":	"Data 0",
				"infoFiltered":	""
			},

            columns: [
                {
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama_pekerja',
                    name: 'nama_pekerja'
                },
                {
                    data: 'no_wa',
                    name: 'no_wa'
                },
                {
                    data: 'no_hp',
                    name: 'no_hp'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: function(row) {
                           
                        let html = '<button class="btn btn-success btn-sm mr-1 ubah" data-id="' + row.id_pekerja + '" data-nik="' + row.nik + '" data-nama_pekerja="' + row.nama_pekerja + '"data-no_wa="' + row.no_wa + '" data-no_hp="' + row.no_hp + '"data-email="' + row.email + '"data-alamat="' + row.alamat + '"data-prov_id="' + row.prov_id + '"data-kab_id="' + row.kab_id + '"data-kec_id="' + row.kec_id + '"data-desa_id="' + row.desa_id + '"><i class="fas fa-edit"></i></button>'
                        html += '<button class="btn btn-danger btn-sm hapus" data-id="' + row.id_pekerja + '"><i class="fa fa-trash"></i></button>'
                        return html;
                    }
                }
            ],
            columnDefs: [{
                targets: 0,
                width: "5%",
                targets: 6,
                width: "10%",
            },
            { //no order
	            targets: [0,1,2,3,4,5,6,-1 ],
	            orderable: false, 
	        }]
            
        });

        $(".tambah").on("click", function() {
            $("#formModal").modal("show");
            $(".modal-title").text("Tambah Data");
            $("button[type=submit]").attr("id", "tambah");
        })
       
        $(".content").on("click", "#tambah", function(e) {
            e.preventDefault();
            let formData = new FormData($("form")[0]);
            $.ajax({
                type: "post",
                url: `${BASE_URL}/hrd/transaksi/karyawan/tambah`,
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                success: function(response) {
                    responValidasi(['tambah'], ['nik','nama_pekerja','no_wa','no_hp','email','prov_id','kab_id','kec_id','desa_id'], response);
                    if (response.sukses) {
                        $("#formModal").modal("hide");
                        table.ajax.reload();
                    }
                }
            });
        })
        $(".content").on("click", ".ubah", function() {
            $("#formModal").modal("show");
            $(".modal-title").text("Edit Data");
            $("button[type=submit]").attr("id", "ubah");
            $("#nik").val($(this).data("nik"));
            $("#nama_pekerja").val($(this).data("nama_pekerja"));     
            $("#no_wa").val($(this).data("no_wa"));    
            $("#no_hp").val($(this).data("no_hp"));       
            $("#email").val($(this).data("email")); 
            $("#alamat").val($(this).data("alamat")); 
            $("#prov_id").val($(this).data("prov_id")); 
            $("#kab_id").val($(this).data("kab_id")); 
            $("#kec_id").val($(this).data("kec_id")); 
            $("#desa_id").val($(this).data("desa_id"));    
            $(".modal-footer").append('<input type="hidden" name="id_pekerja" value="' + $(this).data("id") + '">');
        })

        $(".content").on("click", "#ubah", function(e) {
            e.preventDefault();
            let formData = new FormData($("form")[0]);
            $.ajax({
                type: "post",
                url: `${BASE_URL}/hrd/transaksi/karyawan/ubah`,
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                success: function(response) {
                    responValidasi(['ubah'], ['nik','nama_pekerja','no_wa','no_hp','email','prov_id','kab_id','kec_id','desa_id'], response);
                    if (response.sukses) {
                        $("#formModal").modal("hide");
                        table.ajax.reload();
                    }
                }
            });
        })
        $("#formModal").on("hide.bs.modal", function() {
            $("form")[0].reset();
            $("input[name=id]").remove();
            $("input").removeClass("is-invalid");
            $("select").removeClass("is-invalid");
           
        })

        $(".content").on("click", ".hapus", function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Konfirmasi!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${BASE_URL}/hrd/transaksi/karyawan/hapus`,
                        data: {
                            id: $(this).data("id")
                        },
                        success: function(response) {
                            table.ajax.reload()
                            if (response.status) {
                                toastr.success(response.pesan, 'Sukses')
                            } else {
                                toastr.error(response.pesan, 'Gagal')
                            }
                        }
                    });
                }
            })
        })

        $('#prov_id').change(function(){ 
            var id=$(this).val();
            
            $.ajax({
                url : "<?php echo site_url('hrd/master/kabupaten/getKabupaten');?>",
                method : "POST",
                //data : {id: id,csrf_test_name: $.cookie('csrf_cookie_name'),},
                data: {
                    id: id,
                    csrf_test_name: $.cookie('csrf_cookie_name') // ini fungsi dari jquery-cookie
                },
                async : true,
                dataType : 'json',
                success: function(data){
                        
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                    }
                    $('#kab_id').html(html);

                }
            });
            return false;
        }); 

        $('#kab_id').change(function(){ 
            var id=$(this).val();
            
            $.ajax({
                url : "<?php echo site_url('hrd/master/kecamatan/getKecamatan');?>",
                method : "POST",
                //data : {id: id,csrf_test_name: $.cookie('csrf_cookie_name'),},
                data: {
                    id: id,
                    csrf_test_name: $.cookie('csrf_cookie_name') // ini fungsi dari jquery-cookie
                },
                async : true,
                dataType : 'json',
                success: function(data){
                        
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                    }
                    $('#kec_id').html(html);

                }
            });
            return false;
        }); 

        $('#kec_id').change(function(){ 
            var id=$(this).val();
            
            $.ajax({
                url : "<?php echo site_url('hrd/master/desa/getDesaCombo');?>",
                method : "POST",
                //data : {id: id,csrf_test_name: $.cookie('csrf_cookie_name'),},
                data: {
                    id: id,
                    csrf_test_name: $.cookie('csrf_cookie_name') // ini fungsi dari jquery-cookie
                },
                async : true,
                dataType : 'json',
                success: function(data){
                        
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].iddesa+'>'+data[i].nama+'</option>';
                    }
                    $('#desa_id').html(html);

                }
            });
            return false;
        }); 
    });
</script>
<?php $this->endSection(); ?>