<!DOCTYPE HTML>
<html>
	<head>
		<title>CRM | SOLTECNOLOGICA</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="{{asset('assets/css/main.css')}}" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header" class="alt">
						<span class="logo"><img src="{{asset('assets/images/logo.png')}}" alt="" /></span>
						<p>CRM para gestión de equipos de trabajo<br/>
						Descarga la app </p><p>
							<a href="https://apps.apple.com/us/app/crm-soltecnologica/id1477497228?l=es&ls=1"><img src="{{asset('images/appstore.png')}}"/></a>  
							<a href="https://html5up.net"><img src="{{asset('images/google.png')}}"/></a>.
						</p>
						<a href="{{route('login')}}" class="button">Iniciar sesión</a>
					</header>

				<!-- Nav -->
					{{-- <nav id="nav">
						<ul>
							<li><a href="#intro" class="active">Conoce más</a></li>
							<li><a href="#first">Crea/busca un viaje</a></li>
							<li><a href="#second">Second Section</a></li>
							<li><a href="#cta">Get Started</a></li>
						</ul>
					</nav> --}}

				<!-- Main -->
					<div id="main">

						<!-- Introduction -->
							<section id="intro" class="main">
								<div class="spotlight">
									<div class="content">
										<header class="major">
											<h2>Gestiona como tu equipo se comunica con tus clientes</h2>
										</header>
										<p>No pierdas nada de lo que tu equipo de trabaja realiza. Siempre ten toda la información de las visitas, reuniones con tus clientes, asi impides que al cambiar de vendedores se pierdan las relaciones con los clientes.</p>
										<ul class="actions">
											<li><a href="{{route('login')}}" class="button">Prueba como funciona</a></li>
										</ul>
									</div>
									<span class="image"><img src="{{asset('images/logo.png')}}" alt="" /></span>
								</div>
							</section>

						<!-- First Section -->
							<section id="first" class="main special">
								<header class="major">
									<h2>Funcionalidades principales</h2>
								</header>
								<ul class="features">
									<li>
										<span class="icon style1 f-34" style="font-size:30pt">
											<i class="far fa-calendar-alt"></i>
										</span>										
										<h3>Gestiona las visitas con un calendario único</h3>
									</li>
									<li>
										<span class="icon style3" style="font-size:30pt">
											<i class="fas fa-edit"></i>
										</span>
										<h3>Formularios de visitas personalizados</h3>										
									</li>
									<li>
										<span class="icon style5" style="font-size:30pt">
											<i class="fas fa-tasks"></i>
										</span>
										<h3>Gestión de las tareas de los vendedores </h3>										
									</li>
								</ul>
								<footer class="major">
									<ul class="actions special">
										<li><a href="{{route('login')}}" class="button">Prueba como funciona</a></li>
									</ul>
								</footer>
							</section>

						<!-- Second Section -->
							{{-- <section id="second" class="main special">
								<header class="major">
									<h2>Ipsum consequat</h2>
									<p>Donec imperdiet consequat consequat. Suspendisse feugiat congue<br />
									posuere. Nulla massa urna, fermentum eget quam aliquet.</p>
								</header>
								<ul class="statistics">
									<li class="style1">
										<span class="icon fa-code-fork"></span>
										<strong>5,120</strong> Etiam
									</li>
									<li class="style2">
										<span class="icon fa-folder-open-o"></span>
										<strong>8,192</strong> Magna
									</li>
									<li class="style3">
										<span class="icon fa-signal"></span>
										<strong>2,048</strong> Tempus
									</li>
									<li class="style4">
										<span class="icon fa-laptop"></span>
										<strong>4,096</strong> Aliquam
									</li>
									<li class="style5">
										<span class="icon fa-diamond"></span>
										<strong>1,024</strong> Nullam
									</li>
								</ul>
								<p class="content">Nam elementum nisl et mi a commodo porttitor. Morbi sit amet nisl eu arcu faucibus hendrerit vel a risus. Nam a orci mi, elementum ac arcu sit amet, fermentum pellentesque et purus. Integer maximus varius lorem, sed convallis diam accumsan sed. Etiam porttitor placerat sapien, sed eleifend a enim pulvinar faucibus semper quis ut arcu. Ut non nisl a mollis est efficitur vestibulum. Integer eget purus nec nulla mattis et accumsan ut magna libero. Morbi auctor iaculis porttitor. Sed ut magna ac risus et hendrerit scelerisque. Praesent eleifend lacus in lectus aliquam porta. Cras eu ornare dui curabitur lacinia.</p>
								<footer class="major">
									<ul class="actions special">
										<li><a href="generic.html" class="button">Learn More</a></li>
									</ul>
								</footer>
							</section> --}}

						<!-- Get Started -->
							{{-- <section id="cta" class="main special">
								<header class="major">
									<h2>Congue imperdiet</h2>
									<p>Donec imperdiet consequat consequat. Suspendisse feugiat congue<br />
									posuere. Nulla massa urna, fermentum eget quam aliquet.</p>
								</header>
								<footer class="major">
									<ul class="actions special">
										<li><a href="generic.html" class="button primary">Get Started</a></li>
										<li><a href="generic.html" class="button">Learn More</a></li>
									</ul>
								</footer>
							</section> --}}

					</div>

				<!-- Footer -->
					<footer id="footer">
						<section>
							<h2>SOLTECNOLOGICA</h2>
							<p>Somos una compañia con mucha experiencia en la gestión de equipos de trabajo, y hemos creado el CRM que necesitas para la gestión de tus equipos de trabja, ofreciendo facilidad, flexibilidad y sobre todo gestionando todo en un solo lugar.</p>
							
						</section>
						<section>
							<h2>Contactanos</h2>
							<dl class="alt">
								<dt>Teléfono</dt>
								<dd>(+593) 099 737 4900</dd>
								<dt>Email</dt>
								<dd><a href="#">info@soltecnologica.com</a></dd>
							</dl>
							{{-- <ul class="icons">
								<li><a href="#" class="icon fa-twitter alt"><span class="label">Twitter</span></a></li>
								<li><a href="#" class="icon fa-facebook alt"><span class="label">Facebook</span></a></li>
								<li><a href="#" class="icon fa-instagram alt"><span class="label">Instagram</span></a></li>
								<li><a href="#" class="icon fa-github alt"><span class="label">GitHub</span></a></li>
								<li><a href="#" class="icon fa-dribbble alt"><span class="label">Dribbble</span></a></li>
							</ul> --}}
						</section>
						<p class="copyright">&copy; Soltecnologica 2019.</p>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="{{asset('assets/js/web/jquery.min.js')}}"></script>
			<script src="{{asset('assets/js/web/jquery.scrollex.min.js')}}"></script>
			<script src="{{asset('assets/js/web/jquery.scrolly.min.js')}}"></script>
			<script src="{{asset('assets/js/web/browser.min.js')}}"></script>
			<script src="{{asset('assets/js/web/breakpoints.min.js')}}"></script>
			<script src="{{asset('assets/js/web/util.js')}}"></script>
			<script src="{{asset('assets/js/web/main.js')}}"></script>

	</body>
</html>