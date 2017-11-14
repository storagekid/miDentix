<div class="col-xs-12" style="margin-top: 20px" id="users-graphs">
	<div class="panel panel-default">
		<div class="panel-heading text-center">
			<h3 class="panel-title">Uso de la Plataforma</h3>
		</div>
		<div class="panel-body">
			@include('layouts.components.filters')
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<canvas id="users-graph-pie" height="100"></canvas>
				</div>
				<div class="col-xs-12 col-sm-6">
					<canvas id="users-graph-line" height="100"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>