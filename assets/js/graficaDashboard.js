var options = {
    chart: {
        type: 'area',
        height: 350
    },
    stroke: {
        curve: 'smooth',
    },
    series: [{
        name: 'Pagos',
        data: [180, 150, 154, 183, 190] // datos de ejemplo
    }],
    xaxis: {
        categories: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie'],
    },
    colors: ['#fdd10d'],
};

var chart = new ApexCharts(document.querySelector("#graficaPagos"), options);
chart.render();