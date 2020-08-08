<div class="container">
    <div id="greeting" style="text-align: center;">
        <br/>
        <h2><b><?php echo $greeting ?></b></h2>
        <p class="lead" style="font-size:24px"><b>Selamat datang di web SKM Admin</b></p>
    </div>
    <hr class="my-4">
    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Daftar pengajuan baru
                </button>
            </h2>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <div id="daftarPengajuan"></div>
            </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Riwayat pengajuan
                </button>
            </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <div id="daftarRiwayat"></div>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form pengajuan</h5>
            <button id="close_btn" type="button" class="close" aria-label="Close" onclick="cancel()">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formulir">
                <div class="form-group">
                    <label for="inputTujuan">Tujuan pengajuan</label>
                    <textarea class="form-control" id="tujuan_i" rows="3"></textarea>
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
    moment.locale('id');
    var state = 0;
    $(document).ready( function () {
        $('#oke_btn').hide();
        getRequest();
        getHistory();
    });
    
    function getRequest(){
        $.getJSON("<?php echo base_url('api/pengajuan_api/fetchPengajuanBaru')?>" ,function(data,status){
            // console.log(data);
            if(data.status){
                $('#daftarPengajuan').html(
                    '<div style="overflow-x:scroll">'+
                        '<table id="reqOpr" class="table table-sm">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th>No</th>'+
                                    '<th>NIM</th>'+
                                    '<th>Nama</th>'+
                                    '<th>Tujuan</th>'+
                                    '<th>Tanggal</th>'+
                                    '<th>Aksi</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody id="bodyReq">'+
                            '</tbody>'+
                        '</table>'+
                    '</div>'
                );
                var nomor = 0;
                for(x in data.data){
                    nomor = nomor+1;
                    $('#bodyReq').append(
                        '<tr>'+
                            '<td>'+nomor+'</td>'+
                            '<td>'+data.data[x].username+'</td>'+
                            '<td>'+data.data[x].nama+'</td>'+
                            '<td>'+data.data[x].tujuan+'</td>'+
                            '<td>'+moment(data.data[x].tanggal).format('LLL')+'</td>'+
                            '<td><button id="agree_btn" type="button" class="btn btn-primary btn-sm" onclick="agree('+data.data[x].id+')">Setuju</button>'+
                            '<button id="disagree_btn" type="button" class="btn btn-danger btn-sm" onclick="disagree('+data.data[x].id+')">Tolak</button></td>'+
                        '</tr>'
                    );
                }
                $('#reqOpr').DataTable();
            } else {
                $('#daftarPengajuan').html(
                    '<p style="text-align:center">'+data.message+'</p>'
                );
            }
        });
    }

    function getHistory(){
        $.getJSON("<?php echo base_url('api/pengajuan_api/fetchAllPengajuan')?>" ,function(data,status){
            // console.log(data);
            if(data.status){
                $('#daftarRiwayat').html(
                    '<div style="overflow-x:scroll">'+
                        '<table class="table table-sm" id="hisOpr">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th>No</th>'+
                                    '<th>Tanggal</th>'+
                                    '<th>NIM</th>'+
                                    '<th>Tujuan</th>'+
                                    '<th>Status</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody id="bodyHist">'+
                            '</tbody>'+
                        '</table>'+
                    '</div>'
                );
                var nomor = 0;
                for(x in data.data){
                    nomor = nomor+1;
                    var status = '';
                    switch (parseInt(data.data[x].status)) {
                        case 2:
                            status = 'Menunggu finalisasi';
                            break;
                        case 3:
                            status = 'Ditolak operator';
                            break;
                        case 4:
                            status = 'No: '+data.data[x].no_surat;
                            break;
                        case 5:
                            status = 'Ditolak kepala BAAK';
                            break;
                        default:
                            break;
                    }
                    var row=`
                        <tr>
                            <td>
                                ${nomor}
                            </td>
                            <td>
                                ${moment(data.data[x].tanggal).format('Do MMMM YYYY HH:mm')}
                            </td>
                            <td>
                                ${data.data[x].username}
                            </td>
                            <td>
                                ${data.data[x].tujuan}
                            </td>
                            <td>
                                ${status}
                            </td>
                        </tr>
                    `;
                    $('#bodyHist').append(row);
                }
                $('#hisOpr').DataTable();
            } else {
                $('#daftarRiwayat').html(
                    '<p style="text-align:center">'+data.message+'</p>'
                );
            }
        });
    }

    function openModal(){
        state = 1;
        $('#exampleModal').modal({backdrop:'static', keyboard:false});
    }

    function cancel(){
        $('#tujuan_i').val('');
        $('#pesan').hide();
        $('#pesan').html('');
        $('#exampleModal').modal('hide');
    }

    function kirim(){
        // $('#login_btn').addClass('disabled loading');
        var tujuan = $('#tujuan_i').val();
        var data = {tujuan: tujuan};
        console.log(data);
        $.ajax({
            type : "post",
            url  : '<?php echo base_url('api/pengajuan_api/input') ;?>',
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
    
    function oke(){
        window.location.href = '<?php echo base_url('beranda')?>';
    }

    function agree(id){
        var data = {id: id, indeks: '2'};
        // console.log(data);
        $.ajax({
            type : "post",
            url  : '<?php echo base_url('api/pengajuan_api/update') ;?>',
            data : data,
            success : function(data) {
                if(data.status){
                    alert(data.message);
                    window.location.href = '<?php echo base_url('beranda')?>';
                } else {
                }
                
            }
        });
    }
    function disagree(id){
        var data = {id: id, indeks: '3'};
        // console.log(data);
        $.ajax({
            type : "post",
            url  : '<?php echo base_url('api/pengajuan_api/update') ;?>',
            data : data,
            success : function(data) {
                if(data.status){
                    alert(data.message);
                    window.location.href = '<?php echo base_url('beranda')?>';
                } else {
                }
                
            }
        });
    }
</script>