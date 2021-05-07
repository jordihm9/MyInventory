<nav>
	<ul class="nav-links">
		<li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
		<li class="nav-item"><a href="{{ route('inventory') }}" class="nav-link">Inventory</a></li>
		@auth
		<li class="nav-item"><a href="{{ route('product.create.view') }}" class="nav-link">Add product</a></li>
		@endauth
		<li class="nav-item"><a href="#" class="nav-link">Support</a></li>
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