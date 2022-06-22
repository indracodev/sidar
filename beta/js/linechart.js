var ctx = document.getElementById('myChart').getContext("2d");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Agt", "Spt", "Oct", "Nov", "Des"],
        datasets: [{
            label: "Ontime",
            borderColor: "rgb(41, 204, 151)",
            pointBorderColor: "rgb(41, 204, 151)",
            pointBackgroundColor: "rgb(41, 204, 151)",
            pointHoverBackgroundColor: "white",
            pointHoverBorderColor: "rgba(76, 132, 255,1)",
            pointBorderWidth: 4,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 1,
            pointRadius: 3,
            fill: false,
            borderWidth: 4,
            data: [100, 120, 150, 170, 180, 170, 160, 120, 98, 156, 125, 70]
        },{
            label: "Late1",
            borderColor: "rgb(255, 255, 0)",
            pointBorderColor: "rgb(255, 255, 0)",
            pointBackgroundColor: "rgb(255, 255, 0)",
            pointHoverBackgroundColor: "white",
            pointHoverBorderColor: "rgba(254, 196, 0,1)",
            pointBorderWidth: 4,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 1,
            pointRadius: 3,
            fill: false,
            borderWidth: 4,
            data: [90, 105, 132, 122, 110, 130, 140, 95, 108, 148, 60, 90]
        },{
            label: "Late2",
            borderColor: "rgb(254, 196, 0)",
            pointBorderColor: "rgb(254, 196, 0)",
            pointBackgroundColor: "rgb(254, 196, 0)",
            pointHoverBackgroundColor: "white",
            pointHoverBorderColor: "rgb(254, 196, 0)",
            pointBorderWidth: 4,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 1,
            pointRadius: 3,
            fill: false,
            borderWidth: 4,
            data: [50, 40, 75, 80, 45, 70, 80, 78, 25, 45, 14, 0]
        },{
            label: "Over",
            borderColor: "rgb(204, 0 , 0 )",
            pointBorderColor: "rgb(204, 0 , 0 )",
            pointBackgroundColor: "rgb(204, 0 , 0 )",
            pointHoverBackgroundColor: "white",
            pointHoverBorderColor: "rgba(41, 204, 151,1)",
            pointBorderWidth: 4,
            pointHoverRadius: 5 ,
            pointHoverBorderWidth: 1,
            pointRadius: 3,
            fill: false,
            borderWidth: 4,
            data: [35, 20, 45, 50, 60, 50, 60, 50, 40, 30, 20, 10]
        }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        display: false
      },
        scales: {
            yAxes: [{
                ticks: {
                    fontColor: "#8a909d",
                    fontFamily: "Roboto, sans-serif",
                    beginAtZero: true,
                    maxTicksLimit: 5,
                    padding: 20
                },
                gridLines: {
                    drawTicks: false,
                    display: true
                }

            }],
            xAxes: [{
                gridLines: {
                    zeroLineColor: "#e5e5e5"
                },
                ticks: {
                    padding: 20,
                    fontColor: "#8a909d",
                    fontFamily: "Roboto, sans-serif"
                }
            }]
        },
    }
});

