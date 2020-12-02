<div class="content">
	<!-- general form elements -->
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Input Data Irigasi</h3>
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

					echo form_open_multipart('irigasi/edit/' . $irigasi->id_irigasi); ?>

					<div class="form-group">
						<label>Nama Irigasi</label>
						<input type="text" value="<?= $irigasi->nama_irigasi ?>" name="nama_irigasi" class="form-control" placeholder="Nama Irigasi">
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Panjang Jalur</label>
								<input type="text" value="<?= $irigasi->panjang_jalur ?>" name="panjang_jalur" class="form-control" placeholder="Panjang Jalur">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label>Lebar Jalur</label>
								<input type="text" name="lebar_jalur" value="<?= $irigasi->lebar_jalur ?>" class="form-control" placeholder="Lebar Jalur">
							</div>
						</div>
					</div>


					<div class="form-group">
						<label>Jalur GeoJSON</label>
						<textarea name="jalur_geojson" rows="4" class="form-control"><?= $irigasi->jalur_geojson ?></textarea>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Warna Jalur</label>
								<div class="input-group my-colorpicker2">
									<input type="text" value="<?= $irigasi->warna ?>" name="warna" class="form-control">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fas fa-square"></i></span>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label>Ketebalan</label>
								<select name="ketebalan" class="form-control">
									<option value="<?= $irigasi->ketebalan ?>"><?= $irigasi->ketebalan ?></option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Gambar</label>
						<input type="file" name="gambar" class="form-control">
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
		center: [-1.974050, 100.888755],
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
	var drawnItems = new L.geoJSON(<?= $irigasi->jalur_geojson ?>);
	map.addLayer(drawnItems);
	var drawControl = new L.Control.Draw({
		draw: {
			polygon: false,
			marker: false,
			circle: false,
			circlemarker: false,
			rectangle: false,
			polyline: true,
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
		$("[name=jalur_geojson]").html(JSON.stringify(drawnItems.toGeoJSON()));
	});

	//edit draw
	map.on('draw:edited', function(e) {
		$("[name=jalur_geojson]").html(JSON.stringify(drawnItems.toGeoJSON()));
	});

	//delete draw
	map.on('draw:deleted', function(e) {
		$("[name=jalur_geojson]").html(JSON.stringify(drawnItems.toGeoJSON()));
	});

	map.fitBounds(drawnItems.getBounds());
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
