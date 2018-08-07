<div class="main-tabs">
            <nav class="nav">
                <a class="nav-link {{isActiveRoute('dashboard')}}" href="{{ url('/dashboard') }}"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a>
                <a class="nav-link {{isActiveRoute('images')}}" href="{{ url('/images') }}"><i class="fa fa-picture-o" aria-hidden="true"></i>Images</a>
                <a class="nav-link {{isActiveRoute('tags')}}" href="{{ url('/tags') }}"><i class="fa fa-tags" aria-hidden="true"></i>Tags</a>
                @if(Auth::user()->role=='admin' || Auth::user()->role=='root')
                    <a class="nav-link {{isActiveRoute('userslist')}}"  href="{{ url('/userslist') }}"><i class="fa fa-users" aria-hidden="true"></i>User List</a>
                @endif
            </nav>
        </div>