<div class="jumbotron">
	<div class="container">
		@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
		@endif
		<h1>Mi perfil</h1>
		<p>Todos tu datos actualiazados para poder atenderte como te mereces</p>
	</div>
</div>