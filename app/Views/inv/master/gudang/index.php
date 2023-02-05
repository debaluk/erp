<?php $this->extend('layout/template'); ?>
<?php $this->section('content'); ?>

<div class="container-fluid">
    <button class="btn btn-primary mb-1 tambah"><i class="fas fa-plus"></i> Tambah Gudang</button>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-kategori" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama Gudang</th>
                            <th>Keterangan</th>
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
                    <label for="kategori" class="col-sm-3 col-form-label">Kode</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="gudang_kode" id="gudang_kode">
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-3 col-form-label">Nama Gudang</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="gudang_nama" id="gudang_nama">
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="keterangan" id="keterangan">
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
<script>
    $(document).ready(function() {
        const table = $("#table-kategori").DataTable({
            proseccing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: `${BASE_URL}/inv/master/gudang/ajax`
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
                    data: 'namagudang',
                    name: 'namagudang'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: function(row) {
                           
                        let html = '<button class="btn btn-success btn-sm mr-1 ubah" data-id="' + row.gudang_id + '" data-kode="' + row.kode + '" data-namagudang="' + row.namagudang + '" data-keterangan="' + row.keterangan + '"><i class="fas fa-edit"></i></button>'
                        html += '<button class="btn btn-danger btn-sm hapus" data-id="' + row.gudang_id + '"><i class="fa fa-trash"></i></button>'
                        return html;
                    }
                }
            ],
            columnDefs: [{
                targets: 0,
                width: "5%",
                targets: 4,
                width: "10%",
            },
            { //no order
	            targets: [ 0,1,2,3,-1 ],
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
                url: `${BASE_URL}/inv/master/gudang/tambah`,
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                success: function(response) {
                    responValidasi(['tambah'], ['gudang_kode', 'gudang_nama'], response);
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
            // isi tiap kolom
            $("#gudang_kode").val($(this).data("kode"));
            $("#gudang_nama").val($(this).data("namagudang"));
            $("#keterangan").val($(this).data("keterangan"));
            $(".modal-footer").append('<input type="hidden" name="gudang_id" value="' + $(this).data("id") + '">');
        })

        $(".content").on("click", "#ubah", function(e) {
            e.preventDefault();
            let formData = new FormData($("form")[0]);
            $.ajax({
                type: "post",
                url: `${BASE_URL}/inv/master/gudang/ubah`,
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                success: function(response) {
                    responValidasi(['ubah'], ['gudang_kode', 'gudang_nama'], response);
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
                        url: `${BASE_URL}/inv/master/gudang/hapus`,
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