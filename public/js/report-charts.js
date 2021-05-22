'use strict';

$(document).ready(function () {
	fetchData();
});

/**
 * Request to the server data from the report to create the charts
 */
function fetchData() {
	$.ajax({
		type: "POST",
		url: "/report/chart-data",
		data: {
			'report': getUrlParam('report')
		},
		success: function (data, statusText, jqXHR) {
			if (jqXHR.status === 200) {
				categoriesChart(data.categories);
				conditionsChart(data.conditions);
				statesChart(data.states);
			}
		},
		error: function (jqXHR, statusText, errorThrown) {
			//
		}
	});
}

function getLabelsAndData(stats) {
	let labels = [];
	let data = [];
	
	for (const stat of stats) {
		labels.push(stat.name);
		data.push(stat.stat.value);
	}

	return {
		'labels': labels,
		'data': data
	};
}

function categoriesChart(categories) {
	let info = getLabelsAndData(categories);
	createChart( $('#category-chart'), '', info.labels, info.data);
}

function conditionsChart(conditions) {
	let info = getLabelsAndData(conditions);
	createChart($('#condition-chart'), '', info.labels, info.data);
}

function statesChart(states) {
	let info = getLabelsAndData(states);
	createChart($('#state-chart'), '', info.labels, info.data);
}

/**
 * Create a chart using the Chart.js library
 * @param {object} container container that would have the chart inside
 * @param {string} chartLabel title of the chart
 * @param {array} labels list of labels
 * @param {array} data list of values
 * @param {array} colors list of colors used for the chart bars
 * @param {array} borderColors list of colors used for the border of the chart bars
 */
function createChart(container, chartLabel, labels, data, colors = ['#091220']) {
	let ctx = container.find('.chart');

	let chart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: labels,
			datasets: [{
				label: undefined,
				data: data,
				backgroundColor: colors,
			}]
		},
		options: {
			plugins: {
				legend: {
					display: false
				}
			},
			scales: {
				y: {
					beginAtZero: true,
				}
			}
		}
	});
}

function getUrlParam(parameter) {
	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}

	if (window.location.href.indexOf(parameter) > -1) {
		return getUrlVars()[parameter];
	}
}