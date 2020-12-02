<div class="content">
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">



			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title ">Login User</h3>
				</div>
				<div class="card-body">

					<?php

					//notifikasi pesan validasi
					echo validation_errors('<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-ban"></i> ', '</div>');


					//notifikasi pesan
					if ($this->session->flashdata('pesan')) {
						echo '<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-check"></i> ';
						echo $this->session->flashdata('pesan');
						echo '</div>';
					}


					echo form_open('auth/login'); ?>
					<div class="form-group">
						<label>Username</label>
						<input type="text" name="username" class="form-control" placeholder="Username">
					</div>

					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control" placeholder="Password">
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary">Login</button>
						<button type="reset" class="btn btn-warning">Reset</button>
					</div>
					<a href="" data-toggle="modal" data-target="#exampleModal">Lupa Password?</a>

					<?php echo form_close() ?>
				</div>
			</div>
		</div>
		<div class="col-sm-4"></div>
	</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?= form_open_multipart('Auth/forget_pass'); ?>
	      <div class="modal-body">
			<div class="form-group">
				<input type="text" name="user" placeholder="Username Lama" class="form-control">
			</div>
			<div class="form-group">
				<input type="text" name="newuser" placeholder="Username Baru (Optional)" class="form-control">
			</div>
			<div class="form-group">
				<input type="password" name="pass1" class="form-control" placeholder="Password Baru">
			</div>
			<div class="form-group">
				<input type="password" name="pass2" class="form-control" placeholder="Verifikasi Password">
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
			<?= form_close(); ?>
    </div>
  </div>
</div>