window.onload = function () {
    Chart.defaults.global.elements.rectangle.borderColor = '#000';
    Chart.defaults.global.elements.rectangle.borderWidth = 1;
    var url = $(".url").data("url");
    $.ajax({
        type: 'get',
        url: url,
        success: function(data) {
            var orders = JSON.parse(data);
            var barChart = document.getElementById('bar-chart');
            new Chart(barChart, {
                type: 'bar',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [
                        {
                            label: 'pending',
                            data: orders[0]['pending'],
                            backgroundColor: 'rgb(0, 0, 255)'
                        },
                        {
                            label: 'approved',
                            data: orders[0]['approved'],
                            backgroundColor: 'rgb(124, 252, 0)'
                        },
                        {
                            label: 'rejected',
                            data: orders[0]['rejected'],
                            backgroundColor: 'rgb(255, 0, 0)'
                        },
                        {
                            label: 'canceled',
                            data: orders[0]['canceled'],
                            backgroundColor: 'rgb(128, 128, 128)'
                        }
                    ]
                },
                options: {
                    scales: {
                        xAxes: [{
                            stacked: false
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }]
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                },
            });
        }
    });
};
