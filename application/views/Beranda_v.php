<div class="container">
    <div id="greeting" style="text-align: center;">
        <br/>
        <h2><b><?php echo $greeting ?></b></h2>
        <p class="lead" style="font-size:24px"><b>Selamat datang di web SKM</b></p>
    </div>
    <hr class="my-4">
    <div style="text-align:center">
        <button id="tambah_btn" type="button" class="btn btn-primary" onclick="openModal()">Buat pengajuan</button>
    </div>
    <br>
    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Kelola Pengajuan
                </button>
            </h2>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <div id="pengajuanUser"></div>
            </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Riwayat Pengajuan
                </button>
            </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <div id="riwayatUser"></div>
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
    $(document).ready( function () {
        $('#oke_btn').hide();
        getRequest();
        getHistory();
    });
    
    function getRequest(){
        $.getJSON("<?php echo base_url('api/pengajuan_api/fetchPengajuanUser')?>" ,function(data,status){
            // console.log(data);
            if(data.status){
                $('#pengajuanUser').html(
                    '<div style="overflow-x:scroll">'+
                        '<table id="reqUser" class="table">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th>No</th>'+
                                    '<th>Tanggal</th>'+
                                    '<th>Tujuan</th>'+
                                    '<th>Status</th>'+
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
                    if(data.data[x].status == 1){
                        $('#bodyReq').append(
                            '<tr>'+
                                '<td>'+nomor+'</td>'+
                                '<td>'+data.data[x].tanggal+'</td>'+
                                '<td>'+data.data[x].tujuan+'</td>'+
                                '<td>Sedang diperiksa</td>'+
                                '<td><button id="batalkan_btn" type="button" class="btn btn-danger" onclick="batalkan('+data.data[0].id+')">Batalkan</button></td>'+
                            '</tr>'
                        );
                    };
                }
                $('#reqUser').DataTable();
            } else {
                $('#pengajuanUser').html(
                    '<p style="text-align:center">'+data.message+'</p>'
                );
            }
        });
    }

    function getHistory(){
        $.getJSON("<?php echo base_url('api/pengajuan_api/fetchAllPengajuanUser')?>" ,function(data,status){
            // console.log(data);
            if(data.status){
                $('#riwayatUser').html(
                    '<div style="overflow-x:scroll">'+
                        '<table id="hisUser" class="table">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th>No</th>'+
                                    '<th>Tanggal</th>'+
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
                                ${data.data[x].tujuan}
                            </td>
                            <td>
                                ${status}
                            </td>
                        </tr>
                    `;
                    $('#bodyHist').append(row);
                }
                $('#hisUser').DataTable();
            } else {
                $('#riwayatUser').html(
                    '<p style="text-align:center">'+data.message+'</p>'
                );
            }
        });
    }

    function openModal(){
        $('#exampleModal').modal({backdrop:'static', keyboard:false});
    }

    function cancel(){
        $('#tujuan_i').val('');
        $('#pesan').hide();
        $('#pesan').html('');
        $('#exampleModal').modal('hide');
    }

    function oke(){
        window.location.href = '<?php echo base_url('beranda')?>';
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
    
    function batalkan(id){
        var data = {id: id, indeks: '0'};
        // console.log(data);
        $.ajax({
            type : "post",
            url  : '<?php echo base_url('api/pengajuan_api/update') ;?>',
            data : data,
            success : function(data) {
                if(data.status){
                    $('#exampleModal').modal({backdrop:'static', keyboard:false});
                    $('#formulir').hide();
                    $('#close_btn').hide();
                    $('#batal_btn').hide();
                    $('#kirim_btn').hide();
                    $('#oke_btn').show();
                    $('#pesan').show();
                    $('#pesan').html('');
                    $('#pesan').append('<h4 style="color:green">'+data.message+'</h4>');
                } else {
                }
                
            }
        });
    }
</script>