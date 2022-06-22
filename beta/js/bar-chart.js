var DEFAULT_DATASET_SIZE = 7,
			addedCount = 0,
		    color = Chart.helpers.color;

	var months = ["Monday", "Teusday", "Wednesday", "Thursday", "Friday", "Saturday"];

	var chartColors = {
		red: 'rgb(255, 99, 132)',
		orange: 'rgb(255, 159, 64)',
		yellow: 'rgb(255, 205, 86)',
		green: 'rgb(75, 192, 192)',
		blue: 'rgb(54, 162, 235)',
		purple: 'rgb(153, 102, 255)',
		grey: 'rgb(231,233,237)'
	};

function randomScalingFactor() {
		return Math.round(Math.random() * 100);
	}

var barData = {
			labels: ["Monday", "Teusday", "Wednesday", "Thursday", "Friday", "Saturday"],
			datasets: [{
				label: 'On Time ',
				backgroundColor: color(chartColors.green).alpha(0.5).rgbString(),
				borderColor: chartColors.green,
				borderWidth: 1,
				data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
				]
			}, {
				label: 'Late',
				backgroundColor: color(chartColors.yellow).alpha(0.5).rgbString(),
				borderColor: chartColors.yellow,
				borderWidth: 1,
				data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
				]
			}, {
				label: 'No Data',
				backgroundColor: color(chartColors.red).alpha(0.5).rgbString(),
				borderColor: chartColors.red,
				borderWidth: 1,
				data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
				]
			}]

		};
var index = 11;
var ctx = document.getElementById("barChart").getContext("2d");
		var	myNewChartB = new Chart(ctx, {
				type: 'bar',
				data: barData,
				options: {
					responsive: true,
          maintainAspectRation: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Bar Chart'
					}
				}
			});
