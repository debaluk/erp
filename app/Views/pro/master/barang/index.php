<?php $this->extend('layout/template'); ?>
<?php $this->section('content'); ?>

<div class="container-fluid">
    <button class="btn btn-primary mb-1 tambah"><i class="fas fa-plus"></i> Tambah Barang</button>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-kategori" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama Barang Jadi</th>
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
                    <label for="kategori" class="col-sm-4 col-form-label">Bentuk</label>
                    <div class="col-sm-8">
                        <select name="id_bentuk" id="id_bentuk" class="form-control">
                            <option value="">Pilih Bentuk</option>
                            <?php foreach (esc($bentuk) as $data) : ?>
                                <option value="<?= esc($data->id_bentuk) ?>"><?= esc($data->kode)  ?>|<?= esc($data->nama_bentuk)  ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Bahan</label>
                    <div class="col-sm-8">
                        <select name="id_bahan" id="id_bahan" class="form-control">
                            <option value="">Pilih Bahan</option>
                            <?php foreach (esc($bahan) as $data) : ?>
                                <option value="<?= esc($data->id_bahan) ?>"><?= esc($data->kode)  ?>|<?= esc($data->nama_bahan)  ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
               
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Diamond</label>
                    <div class="col-sm-8">
                        <select name="id_diamond" id="id_diamond" class="form-control">
                            <option value="">Pilih Diamond</option>
                            <?php foreach (esc($diamond) as $data) : ?>
                                <option value="<?= esc($data->id_diamond) ?>"><?= esc($data->kode)  ?>|<?= esc($data->nama_diamond)  ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="invalid-feedback"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Permata</label>
                    <div class="col-sm-8">
                        <select name="id_permata" id="id_permata" class="form-control">
                            <option value="">Pilih Permatan</option>
                            <?php foreach (esc($permata) as $data) : ?>
                                <option value="<?= esc($data->id_permata) ?>"><?= esc($data->kode)  ?>|<?= esc($data->nama_permata)  ?></option>
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
                    <label for="kategori" class="col-sm-4 col-form-label">Nama Barang</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="barang_nama" id="barang_nama">
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
                url: `${BASE_URL}/pro/master/barang/ajax`
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
                    data: 'barang_nama',
                    name: 'barang_nama'
                },
                {
                    data: 'satuan',
                    name: 'satuan'
                },

                {
                    data: function(row) {
                           
                        let html = '<button class="btn btn-success btn-sm mr-1 ubah" data-id="' + row.barang_id + '" data-id_bentuk="' + row.id_bentuk + '" data-id_bahan="' + row.id_bahan + '"data-id_diamond="' + row.id_diamond + '" data-id_permata="' + row.id_permata + '"data-kode="' + row.kode + '"data-barang_nama="' + row.barang_nama + '"data-satuan_id="' + row.satuan_id + '"data-diskripsi="' + row.diskripsi + '"data-gambar="' + row.gambar + '"><i class="fas fa-edit"></i></button>'
                        html += '<button class="btn btn-danger btn-sm hapus" data-id="' + row.barang_id + '"><i class="fa fa-trash"></i></button>'
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
	            targets: [ 0,1,2,-1 ],
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
                url: `${BASE_URL}/pro/master/barang/tambah`,
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                success: function(response) {
                    responValidasi(['tambah'], ['id_bentuk', 'id_bahan','id_diamond','id_permata','kode','nama_barang','satuan_id'], response);
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
            $("#id_bentuk").val($(this).data("id_bentuk"));
            $("#id_bahan").val($(this).data("id_bahan"));
            $("#id_diamond").val($(this).data("id_diamond"));
            $("#id_permata").val($(this).data("id_permata"));
            $("#kode").val($(this).data("kode"));
            $("#barang_nama").val($(this).data("barang_nama"));
            $("#satuan_id").val($(this).data("satuan_id"));
            $("#diskripsi").val($(this).data("diskripsi"));            
            $("#img-preview").prop("src", `${BASE_URL}/uploads/produk_jadi/` + $(this).data('gambar')).parent().removeClass("d-none");
            $("#gambarLama").val($(this).data('gambar'));
            $(".modal-footer").append('<input type="hidden" name="barang_id" value="' + $(this).data("id") + '">');
        })

        $(".content").on("click", "#ubah", function(e) {
            e.preventDefault();
            let formData = new FormData($("form")[0]);
            $.ajax({
                type: "post",
                url: `${BASE_URL}/pro/master/barang/ubah`,
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                success: function(response) {
                    responValidasi(['ubah'], ['id_bentuk', 'id_bahan','id_diamond','id_permata','kode','nama_barang','satuan_id'], response);
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
                        url: `${BASE_URL}/pro/master/barang/hapus`,
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