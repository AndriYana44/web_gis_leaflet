
<style>
	#content-card {
		display: flex;
		flex
	}
	.card {
		background-color: #002144b8;
	}
	img.nagrak {
		margin-top: 35px;
		border-radius: 8px;
	}
	h4#jml {
		position: absolute;
		margin-top: 50px auto;
		font-size: 20px;
	}
	#row {
		position: relative;
		min-height: 200px;
	}
	.jam-digital {
		position: absolute;
		top: -35px;
		right: 0;
		display: flex;
		justify-content: center;
		align-items: center;
		background-color: #333;
		padding: 5px 15px;
		border-radius: 5px;
		width: 120px;
	}
	.jam-digital p {
		font-size: 20px;
	}
</style>

<title>Home</title>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-4 content text-secondary">
                <h3>Hi, Welcome to Mywebsite</h3>
                <span><i class="fa fa-circle text-success" id="on"></i> Has Logged in : <?= date("Y-m-d"); ?></span>
                <hr>
                <h6>Website Gis pemetaan lahan dan irigasi pertanian Desa Nagrak</h6>
                <div class="card mt-5 text-white" id="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8" id="content-card">
							<h4 id="jml">Data Lahan Saat ini : <span><?= $total; ?></span></h4>
							<img class="nagrak" height="180" width="200" src="<?= base_url('gambar/nagrak.jpg') ?>" alt="">
						</div>
                        <div class="col-sm-4" id="row">
                            <div class="jam-digital jam-digital-home mt-4 float-right">
                                <div class="kotak text-secondary">
                                    <strong><p class="text-white d-inline" id="jam"></p>
                                    <p class="text-white d-inline">:</p>
                                    <p class="text-white d-inline" id="menit"></p>
                                    <p class="text-white d-inline">:</p>
                                    <p class="text-white d-inline" id="detik"></p></strong>
                                </div>
                            </div>
                            <script>
                                window.setTimeout("waktu()", 1000);
                            
                                function waktu() {
                                    var waktu = new Date();
                                    setTimeout("waktu()", 1000);
                                    document.getElementById("jam").innerHTML = waktu.getHours();
                                    document.getElementById("menit").innerHTML = waktu.getMinutes();
                                    document.getElementById("detik").innerHTML = waktu.getSeconds();
                                }
                            </script>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-sm-8">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.3167952665767!2d106.84715731436428!3d-6.607500266428191!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c638ec9a0a2d%3A0x2814265093727fa6!2sKantor%20Desa%20Nagrak!5e0!3m2!1sid!2sid!4v1606127008923!5m2!1sid!2sid" width="750" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
    </div>

    <!-- Modal contact -->
    <div class="modal fade" id="contact" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Contact Me</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="content text-center">
                <h3>Desa Nagrak</h3>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Understood</button>
        </div>
        </div>
    </div>
    </div>
<div class="container mt-4">
	<div class="row">
		<div class="col">
			<div id="map" style="width: 100%; height: 600px;"></div>
		</div>
	</div>
</div>


<script>
	var gruplahan = L.layerGroup();
	var grupirigasi = L.layerGroup();
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
		layers: [peta2, gruplahan, grupirigasi]
	});

	var baseLayers = {
		"Grayscale": peta1,
		"Satelite": peta2,
		"Streets": peta3
	};

	var overlays = {
		"Lahan": gruplahan,
		"Irigasi": grupirigasi,
	};

	L.control.layers(baseLayers, overlays).addTo(map);

	<?php foreach ($lahan as $key => $value) { ?>
		var lahan = L.geoJSON(<?= $value->denah_geojson; ?>, {
			style: {
				color: 'white',
				dashArray: '3',
				lineCap: 'butt',
				lineJoin: 'miter',
				fillColor: '<?= $value->warna ?>',
				fillOpacity: 1.0,
			},
		}).addTo(gruplahan);
		lahan.eachLayer(function(layer) {
			layer.bindPopup("<p><img src='<?= base_url('gambar/' . $value->gambar) ?>' width='280px'><br><br>" +
				"Nama Lahan : <?= $value->nama_lahan ?></br>" +
				"Luas Lahan : <?= $value->luas_lahan ?></br>" +
				"Pemilik Lahan : <?= $value->luas_lahan ?></br>" +
				"Alamat Pemilik : <?= $value->alamat_pemilik ?></br>" +
				"Isi Lahan : <?= $value->isi_lahan ?></br></br>" +
				"<a href='<?= base_url('home/detail_lahan/' . $value->id_lahan) ?>' class='btn btn-sm btn-default btn-block'>Detail</a>" +
				"</p>");
		});
	<?php } ?>

	<?php foreach ($irigasi as $key => $value) { ?>
		var irigasi = L.geoJSON(<?= $value->jalur_geojson; ?>, {
			style: {
				color: "<?= $value->warna ?>",
				weight: <?= $value->ketebalan ?>,
			},
		}).addTo(grupirigasi);
		irigasi.eachLayer(function(layer) {
			layer.bindPopup("<p><img src='<?= base_url('gambar/' . $value->gambar) ?>' width='280px'><br><br>" +
				"Nama Irigasi : <?= $value->nama_irigasi ?></br>" +
				"Panjang Jalur : <?= $value->panjang_jalur ?></br>" +
				"Lebar Jalur : <?= $value->lebar_jalur ?></br>" +
				"<a href='<?= base_url('home/detail_irigasi/' . $value->id_irigasi) ?>' class='btn btn-sm btn-default btn-block'>Detail</a>" +
				"</p>");
		});
	<?php } ?>
</script>
