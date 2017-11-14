<div class="jumbotron">
	<div class="container">
		@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
		@endif
		<h1>Bienvenid@, {{auth()->user()->name}}</h1>
		<p>Desde aquí puedes ver el estado de tus solicitudes y acceder...</p>
	</div>
</div>