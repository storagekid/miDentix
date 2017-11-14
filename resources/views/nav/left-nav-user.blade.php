<ul class="nav navbar-nav">
    <li class="active">
        <a href="/home">
            <span class="glyphicon glyphicon-dashboard"></span> 
            <span class="hidden-sm">Panel de Control</span>
        </a>
    </li>
    <li>
        <a href="/profile">
            <span class="glyphicon glyphicon-user"></span> 
            <span class="hidden-sm">Perfil</span>
        </a>
    </li>
    <li>
        <a href="/requests">
            <span class="glyphicon glyphicon-bullhorn"></span> 
            <span class="hidden-sm">Necesidades</span>
        </a>
    </li>
    <li>
        <a href="/schedule/{{auth()->id()}}">
            <span class="glyphicon glyphicon-time"></span> 
            <span class="hidden-sm">Jornada</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span class="glyphicon glyphicon-education"></span> 
            <span class="hidden-sm">Cursos</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span class="glyphicon glyphicon-file"></span> 
            <span class="hidden-sm">Protocolos</span>
        </a>
    </li>
    <li id="surveys">
        <a href="#">
            <span class="glyphicon glyphicon-list-alt"></span> 
            <span class="hidden-sm">Encuestas</span>
        </a>
    </li>
</ul>