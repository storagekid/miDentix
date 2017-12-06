<div id="side-profile">
  <div class="col-xs-8 col-xs-offset-2 col-sm-10 col-sm-offset-1 profile-pic-round">
    <a href="/profile" class="thumbnail center-block">
      <img src="/img/profile.jpg" alt="...">
    </a>
  </div>
  <div class="col-xs-10 col-xs-offset-1 profile-info text-center">
    <p id="profile-name">{{auth()->user()->profile->name}}</p>
    @if(auth()->user()->role == 'user')
    	<p>Odontólog@</p>
    @else
		<p>Administrador</p>
    @endif
  </div>
</div>