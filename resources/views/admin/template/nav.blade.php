<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      @if (Auth::user()) 
        <a class="navbar-brand" href="{{ route('home') }}">Inicio</span></a>
      @endif
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      @if (Auth::user())
          <ul class="nav navbar-nav">
            <li><a href="{{ route('guardia.index') }}" class="navbar-brand">Guardias</a></li>
            <li><a href="{{ route('solicitud.index') }}" class="navbar-brand">Solicitud</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle navbar-brand" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="{{ route('groups.index') }}">Grupos</a></li>
                <li><a href="{{ route('guardias.index') }}">Guardias</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown">
                 <a href="{{ route('users.index') }}">Empleados</a></li>
              </ul>
              <li>
                <ul class="dropdown-menu">
                  <li><a href="#">Page 1-1</a></li>
                  <li><a href="#">Page 1-2</a></li>
                  <li><a href="#">Page 1-3</a></li>
                </ul>
              </li>
            </li>
          </ul>
      @endif
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          @if (Auth::guest())
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Login<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('login') }}"><span class="icon icon-user glyphicon glyphicon-user"></span> Conectar</a></li>
            </ul>
          @else
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name . " " . Auth::user()->lastname }}<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('perfil.index') }}">Edita tu perfil</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="{{ route('logout') }}"><span class="icon icon-off glyphicon glyphicon-off"></span> Desconectar</a></li>
            </ul>
          @endif
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>