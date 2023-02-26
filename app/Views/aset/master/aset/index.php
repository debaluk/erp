<?php $this->extend('layout/template'); ?>
<?php $this->section('content'); ?>

<div class="container-fluid">
    <button class="btn btn-primary mb-1 tambah"><i class="fas fa-plus"></i> Tambah Aset</button>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-kategori" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Kategori Aset</th>
                            <th>Jenis Aset</th>
                            <th>Nama Aset</th>
                            <th>Satuan</th>
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
                    <label for="kategori" class="col-sm-4 col-form-label">Kategori Aset</label>
                    <div class="col-sm-8">
                        <select name="kategori_aset_id" id="kategori_aset_id" class="form-control">
                            <option value="">Pilih Kategori</option>
                            <?php foreach (esc($kategori) as $data) : ?>
                                <option value="<?= esc($data->kategori_aset_id) ?>"><?= esc($data->kategori)  ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Jenis Aset</label>
                    <div class="col-sm-8">
                        <select name="jenis_aset_id" id="jenis_aset_id" class="form-control">
                            <option value="">Pilih Jenis</option>
                            <?php foreach (esc($jenis) as $data) : ?>
                                <option value="<?= esc($data->jenis_aset_id) ?>"><?= esc($data->jenis_aset)  ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Kode</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="kode" id="kode" >
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Nama Aset</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="aset_nama" id="aset_nama">
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Satuan</label>
                    <div class="col-sm-8">
                        <select name="satuan_id" id="satuan_id" class="form-control">
                            <option value="">Pilih Satuan</option>
                            <?php foreach (esc($satuan) as $data) : ?>
                                <option value="<?= esc($data->satuan_id) ?>"><?= esc($data->satuan)  ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Deskripsi</label>
                    <div class="col-sm-8">
                        <textarea  class="form-control" name="diskripsi" id="diskripsi"></textarea>
                       
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="gambar" name="gambar">
                        <label class="custom-file-label" for="gambar">Upload gambar</label>
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                <div class="form-group d-none">
                        <img class="img-thumbnail" id="img-preview">
                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="gambarLama" id="gambarLama">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>               
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script>
    $(document).ready(function() {
        const table = $("#table-kategori").DataTable({
            proseccing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: `${BASE_URL}/aset/master/aset/ajax`
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
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'kategori',
                    name: 'kategori'
                },
                {
                    data: 'jenis',
                    name: 'jenis'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'satuan',
                    name: 'satuan'
                },

                {
                    data: function(row) {
                           
                        let html = '<button class="btn btn-success btn-sm mr-1 ubah" data-id="' + row.aset_id + '" data-kode="' + row.kode + '" data-kategori="' + row.kategori_id + '"data-jenis="' + row.jenis_id + '" data-satuan="' + row.satuan_id + '"data-nama="' + row.nama + '"data-diskripsi="' + row.diskripsi + '"data-gambar="' + row.gambar + '"><i class="fas fa-edit"></i></button>'
                        html += '<button class="btn btn-danger btn-sm hapus" data-id="' + row.aset_id + '"><i class="fa fa-trash"></i></button>'
                        return html;
                    }
                }
            ],
            columnDefs: [{
                targets: 0,
                width: "5%",
                targets: 5,
                width: "10%",
            },
            { //no order
	            targets: [ 0,1,2,3,4,5,-1 ],
	            orderable: false, 
	        }]
            
        });

        $(".tambah").on("click", function() {
            $("#formModal").modal("show");
            $(".modal-title").text("Tambah Data");
            $("button[type=submit]").attr("id", "tambah");
        })
        $("#gambar").on("change", function() {
            let src = URL.createObjectURL(event.target.files[0]);
            $("#img-preview").prop("src", src).parent().removeClass("d-none")
        })
        $(".content").on("click", "#tambah", function(e) {
            e.preventDefault();
            let formData = new FormData($("form")[0]);
            $.ajax({
                type: "post",
                url: `${BASE_URL}/aset/master/aset/tambah`,
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                success: function(response) {
                    responValidasi(['tambah'], ['kategori_aset_id', 'jenis_aset_id','kode','aset_nama','satuan_id'], response);
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
           
            $("#kategori_aset_id").val($(this).data("kategori"));
            $("#jenis_aset_id").val($(this).data("jenis"));
            $("#kode").val($(this).data("kode"));
            $("#aset_nama").val($(this).data("nama"));
            $("#satuan_id").val($(this).data("satuan"));
            $("#diskripsi").val($(this).data("diskripsi"));            
            $("#img-preview").prop("src", `${BASE_URL}/uploads/aset/` + $(this).data('gambar')).parent().removeClass("d-none");
            $("#gambarLama").val($(this).data('gambar'));
            $(".modal-footer").append('<input type="hidden" name="aset_id" value="' + $(this).data("id") + '">');
        })

        $(".content").on("click", "#ubah", function(e) {
            e.preventDefault();
            let formData = new FormData($("form")[0]);
            $.ajax({
                type: "post",
                url: `${BASE_URL}/aset/master/aset/ubah`,
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                success: function(response) {
                    responValidasi(['ubah'], ['kategori_aset_id', 'jenis_aset_id','kode','aset_nama','satuan_id'], response);
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
            $("#img-preview").parent().addClass("d-none");
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
                        url: `${BASE_URL}/aset/master/aset/hapus`,
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
    });
</script>
<?php $this->endSection(); ?>