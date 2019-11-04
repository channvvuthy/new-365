<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{URL::to('/')}}">365daymarket <p class="line"></p> </a>
        </div>
        <ul class="nav navbar-nav">
        </ul>
        @if(Auth::check())
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{URL::to('profile')}}"><span class="glyphicon glyphicon-user"></span>{{Auth::user()->name}}</a></li>
                <li><a href="{{URL::to('logout')}}"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                <li><a href="{{URL::to('post')}}"><span class="glyphicon glyphicon-send"></span> Post Product</a></li>
            </ul>
        @else
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" class="myModalRegister"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                <li><a href="#" class="myModalLogin"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                <li><a href="#" class="myModalLogin"><span class="glyphicon glyphicon-send"></span> Post Product</a></li>
            </ul>
        @endif
    </div>
</nav>