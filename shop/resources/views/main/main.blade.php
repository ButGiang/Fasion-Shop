<!DOCTYPE html>
<html lang="en">
<head>
    @include('main.header')
</head>

<body>
	<!-- Header -->
	<header>
		@include('main.navbar')
	</header>

	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		@include('main.cart')
	</div>

    @yield('content')

    @include('main.footer')

</body>
</html>
