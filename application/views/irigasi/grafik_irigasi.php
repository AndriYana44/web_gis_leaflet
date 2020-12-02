<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <canvas id="myChart">lkdjflkdsj</canvas>
        </div>
    </div>
</div>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',
        data: {
            labels: [<?php 
                        foreach($irigasi as $value) {
                            echo "'".$value->nama_irigasi."',";    
                        }
                    ?>],
            datasets: [{
                label: 'My First dataset',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [<?php 
                        foreach($irigasi as $value) {
                            $data = explode(' ', $value->panjang_jalur);
                            $data = array_shift($data);
                            echo $data.",";
                        }
                        ?>]
            }]
        },

        // Configuration options go here
        options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
    });
</script>