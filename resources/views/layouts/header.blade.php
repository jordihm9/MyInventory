<nav>
	<ul class="nav-links">
		<li class="nav-item">
			<a href="{{ route('home') }}" class="nav-link @if(Route::currentRouteNamed('home')) active @endif">
				Home
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('inventory') }}" class="nav-link @if(Route::currentRouteNamed('inventory')) active @endif">
				Inventory
			</a>
		</li>
		@auth
		<li class="nav-item">
			<a href="{{ route('product.create.view') }}" class="nav-link @if(Route::currentRouteNamed('product.create.view')) active @endif">
				Add product
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('reports') }}" class="nav-link @if(Route::currentRouteNamed('reports')) active @endif">
				Reports
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('account.manage') }}" class="nav-link @if(Route::currentRouteNamed('account.manage')) active @endif">
				Account
			</a>
		</li>
		@endauth
		<li class="nav-item">
			<a href="#" class="nav-link @if(Route::currentRouteNamed('#')) active @endif">
				Support
			</a>
		</li>
	</ul>
	<div class="wrapper">
		@if (Auth::check())
		<form action="{{ route('logout') }}" method="post">
			@csrf
			<input type="submit" value="Log out" class="btn light">
		</form>
		@else
		<a href="{{ route('register.view') }}"><div class="btn light">Register</div></a>
		<a href="{{ route('login.view') }}"><div class="btn primary">Log in</div></a>
		@endif
	</div>
</nav>
<div class="burger">
	<div class="line"></div>
	<div class="line"></div>
	<div class="line"></div>
</div>