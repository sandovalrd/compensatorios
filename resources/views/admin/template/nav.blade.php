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
      <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      @if (Auth::user())
          <ul class="nav navbar-nav">
            <li><a href="#">Solicitud<span class="sr-only">(current)</span></a></li>
            <li><a href="#"></span>Guardias</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="{{ route('groups.index') }}">Grupos</a></li>
                <li><a href="#">Guardias</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Empleados</a></li>
              </ul>
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
              <li><a href="{{ route('logout') }}"><span class="icon icon-off glyphicon glyphicon-off"></span> Desconectar</a></li>
            </ul>
          @endif
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>