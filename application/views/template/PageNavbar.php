<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#4682B4">
  <div class="container">
    <a class="navbar-brand" href="<?php echo base_url(); ?>">Beranda</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      </ul>
      <?php $level = $this->session->userdata('st');
        if($level == 5){
      ?>
        <span class="navbar-text">
          <a class="nav-link" href="<?php echo base_url('mahasiswa'); ?>">Kelola Mahasiswa</a>
        </span>
      <?php } ?>
      <span class="navbar-text">
        <a class="nav-link" href="<?php echo base_url('login/logout'); ?>">Logout</a>
      </span>
    </div>
  </div>
</nav>