<div class="content">
	<!-- general form elements -->
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Input Data Lahan Pertanian</h3>
		</div>
		<!-- /.card-header -->
		<!-- form start -->
		<div class="card-body">
			<div class="row">
				<div class="col-sm-7">
					<!-- peta -->
					<div id="map" style="width: 100%; height: 600px;"></div>
					<!-- end peta -->
				</div>

				<div class="col-sm-5">
					<?php
					//notifikasi pesan validasi
					echo validation_errors('<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-ban"></i> ', '</div>');

					//notifikasi gagal upload
					if (isset($error_upload)) {
						echo '<div class="alert alert-warning alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-exclamation-triangle"></i> ' . $error_upload . '</div>';
					}

					//notifikasi sukses simpan data
					if ($this->session->flashdata('sukses')) {
						echo '<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-check"></i> ';
						echo $this->session->flashdata('sukses');
						echo '</div>';
					}

					echo form_open_multipart('lahan/add'); ?>

					<div class="form-group">
						<label>Nama Lahan</label>
						<input type="text" name="nama_lahan" class="form-control" placeholder="Nama Lahan">
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Luas Lahan</label>
								<input type="text" name="luas_lahan" class="form-control" placeholder="Luas Lahan">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label>Isi Lahan</label>
								<select name="isi_lahan" class="form-control">
									<option value="Talas">Talas</option>
									<option value="Jagung">Jagung</option>
									<option value="Singkong">Singkong</option>
									<option value="Terong">Terong</option>
									<option value="Pepaya">Pepaya</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Pemilik Lahan</label>
						<input type="text" name="pemilik_lahan" class="form-control" placeholder="Pemilik Lahan">
					</div>

					<div class="form-group">
						<label>Alamat Pemilik</label>
						<input type="text" name="alamat_pemilik" class="form-control" placeholder="Alamat Pemilik">
					</div>

					<div class="form-group">
						<label>Denah GeoJSON</label>
						<textarea name="denah_geojson" rows="4" class="form-control"></textarea>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Warna Denah</label>
								<div class="input-group my-colorpicker2">
									<input type="text" name="warna" class="form-control">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fas fa-square"></i></span>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label>Gambar</label>
								<input type="file" name="gambar" class="form-control">
							</div>
						</div>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary">Simpan</button>
						<button type="reset" class="btn btn-warning">Reset</button>
					</div>

					<?php echo form_close(); ?>

				</div>
			</div>

		</div>
	</div>
</div>


<script>
	var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11'
	});


	var peta2 = L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
		attribution: 'google'
	});

	var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	});

	var map = L.map('map', {
		center: [-6.604286819372687, 106.85792245349015],
		zoom: 15,
		layers: [peta2]
	});

	var baseLayers = {
		"Grayscale": peta1,
		"Satelite": peta2,
		"Streets": peta3
	};

	var overlays = {

	};

	L.control.layers(baseLayers).addTo(map);


	// FeatureGroup is to store editable layers
	var drawnItems = new L.FeatureGroup();
	map.addLayer(drawnItems);
	var drawControl = new L.Control.Draw({
		draw: {
			polygon: true,
			marker: false,
			circle: false,
			circlemarker: false,
			rectangle: false,
			polyline: false,
		},
		edit: {
			featureGroup: drawnItems
		}
	});
	map.addControl(drawControl);

	//membuat draw
	map.on('draw:created', function(event) {
		var layer = event.layer;
		var feature = layer.feature = layer.feature || {};
		feature.type = feature.type || "Feature";
		var props = feature.properties = feature.properties || {};
		drawnItems.addLayer(layer);
		$("[name=denah_geojson]").html(JSON.stringify(drawnItems.toGeoJSON()));
	});

	//edit draw
	map.on('draw:edited', function(e) {
		$("[name=denah_geojson]").html(JSON.stringify(drawnItems.toGeoJSON()));
	});

	//delete draw
	map.on('draw:deleted', function(e) {
		$("[name=denah_geojson]").html(JSON.stringify(drawnItems.toGeoJSON()));
	});
</script>



<script>
	$(function() {


		//color picker with addon
		$('.my-colorpicker2').colorpicker()

		$('.my-colorpicker2').on('colorpickerChange', function(event) {
			$('.my-colorpicker2 .fa-square').css('color', event.color.toString());
		});

	})
</script>
