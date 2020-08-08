<div class="container">
    <div id="greeting" style="text-align: center;">
        <br/>
        <p class="lead" style="font-size:24px"><b>Kelola Mahasiswa</b></p>
    </div>
    <hr class="my-4">
    <div style="text-align:center">
        <button id="tambah_btn" type="button" class="btn btn-primary" onclick="openModal()">Tambah mahasiswa</button>
    </div>
    <br>
    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Daftar mahasiswa
                </button>
            </h2>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <div id="daftarMahasiswa"></div>
            </div>
            </div>
        </div>
    </div>
    <br>
</div>

<!-- Modal -->
<div class="modal fade" id="tambahMdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form registrasi</h5>
            <button id="close_btn" type="button" class="close" aria-label="Close" onclick="cancel()">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formulir">
                <div class="form-group">
                    <label for="nim_i">NIM</label>
                    <input type="text" class="form-control" id="nim_i" placeholder="Masukkan NIM">
                </div>
                <div class="form-group">
                    <label for="nama_i">Nama</label>
                    <input type="text" class="form-control" id="nama_i" placeholder="Masukkan nama lengkap">
                </div>
                <div class="form-group">
                    <label for="alamat_i">Alamat</label>
                    <input type="text" class="form-control" id="alamat_i" placeholder="Masukkan alamat">
                </div>
            </form>
            <div id="pesan"></div>
        </div>
        <div class="modal-footer">
            <button id="batal_btn" type="button" class="btn btn-secondary" onclick="cancel()">Batal</button>
            <button id="kirim_btn" type="button" class="btn btn-primary" onclick="kirim()">Kirim</button>
            <button id="oke_btn" type="button" class="btn btn-primary" onclick="oke()">Oke</button>
        </div>
        </div>
    </div>
</div>

<script>
    $(document).ready( function () {
        $('#oke_btn').hide();
        getMhs();
    });

    function openModal(){
        $('#tambahMdl').modal({backdrop:'static', keyboard:false});
    }

    function cancel(){
        $('#nim_i').val('');
        $('#nama_i').val('');
        $('#alamat_i').val('');
        $('#pesan').hide();
        $('#pesan').html('');
        $('#tambahMdl').modal('hide');
    }

    function oke(){
        window.location.href = '<?php echo base_url('mahasiswa')?>';
    }

    function getMhs(){
        $.getJSON("<?php echo base_url('api/mahasiswa_api/fetchAllMahasiswa')?>" ,function(data,status){
            console.log(data);
            if(data.status){
                $('#daftarMahasiswa').html(
                    '<div style="overflow-x:scroll">'+
                        '<table id="listMhs" class="table">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th>No</th>'+
                                    '<th>NIM</th>'+
                                    '<th>Nama</th>'+
                                    '<th>Alamat</th>'+
                                    // '<th>Aksi</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody id="bodyList">'+
                            '</tbody>'+
                        '</table>'+
                    '</div>'
                );
                var nomor = 0;
                for(x in data.data){
                    nomor = nomor+1;
                    $('#bodyList').append(
                        '<tr>'+
                            '<td>'+nomor+'</td>'+
                            '<td>'+data.data[x].username+'</td>'+
                            '<td>'+data.data[x].nama+'</td>'+
                            '<td>'+data.data[x].alamat+'</td>'+
                            // '<td><button id="batalkan_btn" type="button" class="btn btn-danger" onclick="batalkan('+data.data[0].id+')">Batalkan</button></td>'+
                        '</tr>'
                    );
                }
                $('#listMhs').DataTable();
            } else {
                $('#daftarMahasiswa').html(
                    '<p style="text-align:center">'+data.message+'</p>'
                );
            }
        });
    }

    function kirim(){
        var nim = $('#nim_i').val();
        var nama = $('#nama_i').val();
        var alamat = $('#alamat_i').val();
        var data = {nim: nim, nama: nama, alamat: alamat};
        // console.log(data);
        $.ajax({
            type : "post",
            url  : '<?php echo base_url('api/mahasiswa_api/input') ;?>',
            data : data,
            success : function(data) {
                // alert(data.message);
                if(data.status){
                    $('#formulir').hide();
                    $('#close_btn').hide();
                    $('#batal_btn').hide();
                    $('#kirim_btn').hide();
                    $('#oke_btn').show();
                    $('#pesan').show();
                    $('#pesan').html('');
                    $('#pesan').append('<h4 style="color:green">'+data.message+'</h4>');
                } else {
                    $('#pesan').show();
                    $('#pesan').html('');
                    $('#pesan').append('<h4 style="color:red">'+data.message+'</h4>');
                }
            }
        });
    }
</script>