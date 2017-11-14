import Chart from 'chart.js';
var colors = {
	main: '#753470',
	main10: '#f1eaf0',
	mainO10: 'rgba(117,52,112,.1)',
	mainO25: 'rgba(117,52,112,.25)',
	mainO35: 'rgba(117,52,112,.35)',
	mainO50: 'rgba(117,52,112,.5)',
	mainO65: 'rgba(117,52,112,.65)',
	mainO85: 'rgba(117,52,112,.85)'
};
var data = {
	labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
	datasets: [
		{
			data: [20, 50,122,90],
			label: "Nº de Solicitudes",
			backgroundColor: colors.mainO10,
			borderColor: colors.main,
		}
	],
};
var data2 = {
	labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
	datasets: [
		{
			data: [19, 30,100,80],
			label: "Resueltas: 229",
			backgroundColor: colors.mainO50,
			borderColor: colors.main,
		},
		{
			data: [1, 20,22,10],
			label: "Pendientes: 53",
			backgroundColor: colors.mainO85,
			borderColor: colors.main,
		}
	],
};
var data3 = {
	labels: ['Gestión C.: 150', 'Equipo M.: 176', 'Equipo G.: 13', 'Nóminas: 45', 'Laboratorio.: 56', ],
	datasets: [
		{
			data: [150, 176, 13, 45, 56],
			backgroundColor: [colors.mainO85, colors.mainO65, colors.mainO50, colors.mainO35, colors.mainO20],
			borderColor: colors.main,
			// hoverBackgroundColor: [
   //              "#FF6384",
   //              "#36A2EB",
   //          ]
		}
	],
};
var dataUsersLine = {
	labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
	datasets: [
		{
			data: [300, 150, 600, 70],
			label: "Usuarios que han usado la plataforma",
			backgroundColor: colors.mainO10,
			borderColor: colors.main,
		}
	],
};
var dataUsersPie = {
	labels: ['Activos: 850', 'Inactivos: 176'],
	datasets: [
		{
			data: [850, 176],
			backgroundColor: [colors.mainO85, colors.mainO50],
			borderColor: colors.main,
			// hoverBackgroundColor: [
   //              "#FF6384",
   //              "#36A2EB",
   //          ]
		}
	],
};

var options = [];
var contextLine = document.querySelector('#graph-line').getContext('2d');
var contextBar = document.querySelector('#graph-bar').getContext('2d');
var contextPie = document.querySelector('#graph-pie').getContext('2d');
var contextUsersLine = document.querySelector('#users-graph-line').getContext('2d');
var contextUsersPie = document.querySelector('#users-graph-pie').getContext('2d');
var myLineChart = new Chart(contextLine, {
    type: 'line',
    data: data,
    options: options
});
var myBarChart = new Chart(contextBar, {
    type: 'bar',
    data: data2,
    options: options
});
var myPieChart = new Chart(contextPie, {
    type: 'pie',
    data: data3,
    options: options
});
var myLineUsersChart = new Chart(contextUsersLine, {
    type: 'line',
    data: dataUsersLine,
    options: options
});
var myPieUsersChart = new Chart(contextUsersPie, {
    type: 'doughnut',
    data: dataUsersPie,
    options: options
});