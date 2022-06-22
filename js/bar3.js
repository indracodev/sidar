/*======== 27. ACQUISITION3 ========*/
var acquisition3 = document.getElementById("bar3");
if (acquisition3 !== null) {
  var acChart3 = new Chart(acquisition3, {
    // The type of chart we want to create
    type: "bar",

    // The data for our dataset
    data: {
      labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
      datasets: [
        {
          label: "Ontime",
          backgroundColor: "rgb(76, 132, 255)",
          borderColor: "rgba(76, 132, 255,0)",
          data: [78, 90, 70, 75, 45, 52, 22],
          pointBackgroundColor: "rgba(76, 132, 255,0)",
          pointHoverBackgroundColor: "rgba(76, 132, 255,1)",
          pointHoverRadius: 3,
          pointHitRadius: 30
        },
        {
          label: "Late 1",
          backgroundColor: "rgb(254, 196, 0)",
          borderColor: "rgba(254, 196, 0,0)",
          data: [88, 115, 80, 96, 65, 77, 38],
          pointBackgroundColor: "rgba(254, 196, 0,0)",
          pointHoverBackgroundColor: "rgba(254, 196, 0,1)",
          pointHoverRadius: 3,
          pointHitRadius: 30
        },
        {
          label: "Late 2",
          backgroundColor: "rgb(41, 204, 151)",
          borderColor: "rgba(41, 204, 151,0)",
          data: [103, 135, 102, 116, 83, 97, 55],
          pointBackgroundColor: "rgba(41, 204, 151,0)",
          pointHoverBackgroundColor: "rgba(41, 204, 151,1)",
          pointHoverRadius: 3,
          pointHitRadius: 30
        },
        {
          label: "Over",
          backgroundColor: "rgb(41, 204, 151)",
          borderColor: "rgba(41, 204, 151,0)",
          data: [103, 135, 102, 116, 83, 97, 55],
          pointBackgroundColor: "rgba(41, 204, 151,0)",
          pointHoverBackgroundColor: "rgba(41, 204, 151,1)",
          pointHoverRadius: 3,
          pointHitRadius: 30
        }
      ]
    },

    // Configuration options go here
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        display: false
      },
      scales: {
        xAxes: [
          {
            gridLines: {
              display: false
            }
          }
        ],
        yAxes: [
          {
            gridLines: {
              display: true
            },
            ticks: {
              beginAtZero: true,
              stepSize: 50,
              fontColor: "#8a909d",
              fontFamily: "Roboto, sans-serif",
              max: 200
            }
          }
        ]
      },
      tooltips: {}
    }
  });
  document.getElementById("customLegend").innerHTML = acChart3.generateLegend();
}