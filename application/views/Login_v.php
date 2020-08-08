<html>

<head>
    <title>Web SKM</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <style>
        body {
            display: flex;
            flex-direction: column;
            /* background-image: url('<?php // echo base_url('assets/images/pencaker_bg.jpg') ?>'); */
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
        .header{
            text-align:center;
            font-family: 'Sniglet', cursive;
            color: #4682B4;
        }
        @media screen and (max-width: 300px) {
            .class {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h2 class="header" style="margin-top:15vh">Web SKM</h2>
    <h4 class="header">Politeknik Statistika STIS</h4>
    
    <div class="card" style="margin:20px auto;min-width:300px">
        <div class="card-body">
        <form method="post">
            <div class="form-group">
                <label for="username_i">Username / NIM</label>
                <input type="text" class="form-control" id="username_i" placeholder="Masukkan username / NIM">
            </div>
            <div class="form-group">
                <label for="password_i">Password</label>
                <input type="password" class="form-control" id="password_i" placeholder="Password">
            </div>
            <button id="login_button" type="button" class="btn btn-primary" onclick="login()">Login</button>
        </form>
        <div id="pesan"></div>
        </div>
    </div>
</body>
<script>
    function login(){
        // $('#login_btn').addClass('disabled loading');
        var uname = $('#username_i').val();
        var pass = $('#password_i').val();
        var data = {username: uname, password: pass};
        // console.log(data);
        $.ajax({
            type : "post",
            url  : '<?php echo base_url('api/login_api/verify') ;?>',
            data : data,
            success : function(data) {
                if(data.status){
                    $('#pesan').hide();
                    $('#pesan').html('');
                    window.location.href = '<?php echo base_url('beranda')?>';
                } else {
                    $('#pesan').show();
                    $('#pesan').html('');
                    $('#pesan').append('<p style="color:red">'+data.message+'</p>');
                }
                
            },
            error: function(data){
                // $('#login_btn').removeClass('disabled loading');
                
            }
        });
    }
</script>
</html>