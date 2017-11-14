<div class="jumbotron">
	<div class="container">
		@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
		@endif
		<h1>Mi Horario</h1>
		<p>Organiza tu agenda y solicita ampliar con nosotros</p>
	</div>
</div>