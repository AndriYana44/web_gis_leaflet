const jagung_input = document.querySelector('.jagung-input');
const singkong_input = document.querySelector('singkong-input');
const talas_input = document.querySelector('talas-input');

var ctx = document.getElementById("PieChart").getContext('2d');
var mychart = new Charte(ctx, {
    type: 'doughnut',
    data: {
        labels: ['jagung', 'singkong', 'talas'],
        datasets: [{
            label: '# of Votes',
            data: [10, 10, 10],
            backgroundColor: ['#4572E', '#17BEBB', '#FFC914'],
            borderWidth: 1
        }]
    }
});

const updateChartValue = (input, dataOrder) => {
    input.addEventListener('change', e => {
        mychart.data.datasets[0].data[dataOrder] = e.target.value;
        mychart.update();
    });

};

updateChartValue(jagung_input, 0);
updateChartValue(singkong_input, 1);
updateChartValue(talas_input, 2);