<div class="col-xs-12" style="margin-top: 20px" id="requests-graphs">
	<div class="panel panel-default">
		<div class="panel-heading text-center">
			<h3 class="panel-title">Evolución Solicitudes</h3>
		</div>
		<div class="panel-body">
			@include('layouts.components.filters')
			<div class="row">
				<div class="col-xs-12 col-sm-4">
					<canvas id="graph-line" height="150"></canvas>
				</div>
				<div class="col-xs-12 col-sm-4">
					<canvas id="graph-pie" height="150"></canvas>
				</div>
				<div class="col-xs-12 col-sm-4">
					<canvas id="graph-bar" height="150"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>