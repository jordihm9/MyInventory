<nav>
	<ul class="nav-links">
		<li class="nav-item"><a href="#" class="nav-link">Home</a></li>
		<li class="nav-item"><a href="#" class="nav-link">Inventory</a></li>
		<li class="nav-item"><a href="#" class="nav-link">Support</a></li>
	</ul>
	<div class="burger">
		<div id="line1" class="line"></div>
		<div id="line2" class="line"></div>
		<div id="line3" class="line"></div>
	</div>
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