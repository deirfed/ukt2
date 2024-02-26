// Morris Days
var day_data = [
	{"period": "2016-10-01", "licensed": 3213, "Ombak": 887},
	{"period": "2016-09-30", "licensed": 3321, "Ombak": 776},
	{"period": "2016-09-29", "licensed": 3671, "Ombak": 884},
	{"period": "2016-09-20", "licensed": 3176, "Ombak": 448},
	{"period": "2016-09-19", "licensed": 3376, "Ombak": 565},
	{"period": "2016-09-18", "licensed": 3976, "Ombak": 627},
	{"period": "2016-09-17", "licensed": 2239, "Ombak": 660},
	{"period": "2016-09-16", "licensed": 3871, "Ombak": 676},
	{"period": "2016-09-15", "licensed": 3659, "Ombak": 656},
	{"period": "2016-09-10", "licensed": 3380, "Ombak": 663}
];
Morris.Line({
	element: 'dayData',
	data: day_data,
	xkey: 'period',
	ykeys: ['licensed', 'Ombak'],
	labels: ['Licensed', 'Ombak'],
	resize: true,
	hideHover: "auto",
	gridLineColor: "#e1e5f1",
	pointFillColors:['#ffffff'],
	pointStrokeColors: ['#cc2626'],
	lineColors:['#1a8e5f', '#262b31', '#434950', '#63686f', '#868a90'],
});
