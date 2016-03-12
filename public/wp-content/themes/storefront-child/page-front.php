<?php
/**
 * Template Name: Static Front Page
 */
get_header(); ?>

	<style>
	body {
		width: 100%;
		height: 1500px;
	}

	.bg {
		width: 100%;
		height: 2000px;
		background-color: #000;
		position: fixed;
		top: 0;
		left: 0;
		z-index: 5;
	}

	.menu-icon, .main-menu, .site-content .header, .site-content.head-row-2, .site-content .header-link-row, .site-content.cart-contents, footer {
		display: none;
	}

	.logo {
		width: 1000px;
		height: 300px;
		position: absolute;
		top: 100px;
		z-index: 10;
		left: 0; right: 0; margin-left: auto; margin-right: auto;
	}

	.logo img {
		width: 100%;
		height: auto;
		position: absolute;
		top: 0;
		left: 0; right: 0; margin-left: auto; margin-right: auto;
	}

	.logo	h4 {
		color: #007c96;
		position: absolute;
		right: 32px;
		bottom: 45px;
		font-size: 30px;
	}

	.comingsoon {
		position: absolute;
		width: 245px;
		top: 380px;
		z-index: 10;
		left: 0; right: 0; margin-left: auto; margin-right: auto;
		text-align: center;
	}

	.comingsoon h4 {
		color: #FFF;
		font-size: 22px;
		font-weight: 900;
	}

	.comingsoon a {
		color: #4fd5ca;
		font-size: 20px;
		font-weight: 700;
		text-transform: uppercase;
		transition: all .5s ease-out;
	}

	.comingsoon a:hover {
		color: #FFF;
	}

	.more-info {
		position: absolute;
		width: 960px;
		height: 500px;
		top: 680px;
		left: 0; right: 0; margin-left: auto; margin-right: auto;
		padding: 20px;
		z-index: 5;
	}

	.body-text {
		margin: 50px 0;
		padding: 0 0 20px 0;
	}

	.first-letter {
		font-family: $robotCon;
	  font-size: 110px;
	  line-height: 0.87;
	  font-weight: 700;
	  float: left;
	  margin: -6px 5px 0 0;
	  color: #FFF;
	  padding: 0 15px 90px;
	}

	p.paragraph {
		width: 880px;
		height: auto;
		margin: 0 0 0 10px;
	}

	.more-info h2 {
		color: #007c96;
		margin: 10px 0;
	}
	.more-info p {
		color: #FFF;
		font-size: 16px;
		font-weight: 300;
		line-height: 1.5;
		margin: 25 0 25px 0;
	}

	@media screen and (max-width: 1000px) {
		body {
			height: 1500px;
		}

		.logo {
			width: 600px;
			height: 200px;
			top: 100px;
		}

		.logo	h4 {
			color: #007c96;
			position: absolute;
			right: 17px;
			bottom: 45px;
			font-size: 30px;
		}

		.comingsoon {
			width: 320px;
			top: 380px;
		}

		.more-info {
			width: 600px;
			height: 500px;
			top: 680px;
			padding: 20px;
		}

		.body-text {
			margin: 50px 0;
		}

		.first-letter {
			font-family: $robotCon;
		  font-size: 110px;
		  line-height: 0.87;
		  font-weight: 700;
		  float: left;
		  margin: -6px 5px 0 0;
		  color: #FFF;
		  padding: 0 15px 140px;
		}

		p.paragraph {
			width: 560px;
		}

		.more-info h2 {
			font-size: 30px;
		}

		.more-info p {
			font-size: 15px;
			margin: 25 0 25px 0;
		}

	}

	@media screen and (max-width: 768px) {
		body {
			height: 2200px;
		}

		.logo {
			width: 600px;
			height: 200px;
			top: 100px;
		}

		.logo	h4 {
			color: #007c96;
			position: absolute;
			right: 17px;
			bottom: 45px;
			font-size: 30px;
		}

		.comingsoon {
			width: 320px;
			top: 380px;
		}

		.more-info {
			width: 600px;
			height: 500px;
			top: 680px;
			padding: 20px;
		}

		.body-text {
			margin: 50px 0;
		}

		p.paragraph {
			width: 560px;
		}

		.more-info h2 {
			font-size: 30px;
		}

		.more-info p {
			font-size: 15px;
			margin: 25 0 25px 0;
		}

	}

@media screen and (max-width: 600px) {
		body {
			height: 2200px;
		}

		.logo {
			width: 400px;
			height: 155px;
			top: 100px;
		}

		.logo	h4 {
			color: #007c96;
			position: absolute;
			right: 12px;
			bottom: 45px;
			font-size: 20px;
		}

		.comingsoon {
			width: 320px;
			top: 320px;
		}

		.more-info {
			width: 500px;
			height: 500px;
			top: 680px;
			padding: 20px;
		}

		.body-text {
			margin: 50px 0;
		}

		p.paragraph {
			width: 460px;
		}

		.more-info h2 {
			font-size: 20px;
		}

		.more-info p {
			font-size: 14px;
			margin: 25 0 25px 0;
		}

	}

	@media screen and (max-width: 480px) {
		body {
			height: 2500px;
		}

		.logo {
			width: 400px;
			height: 155px;
			top: 100px;
		}

		.logo	h4 {
			color: #007c96;
			position: absolute;
			right: 12px;
			bottom: 45px;
			font-size: 20px;
		}

		.comingsoon {
			width: 320px;
			top: 320px;
		}

		.comingsoon h4 {
			font-size: 18px;
		}

		.more-info {
			width: 400px;
			height: 500px;
			top: 680px;
			padding: 20px;
		}

		.body-text {
			margin: 50px 0;
		}

		p.paragraph {
			width: 360px;
		}

		.more-info h2 {
			font-size: 20px;
		}

		.more-info p {
			font-size: 13px;
			margin: 25 0 25px 0;
		}

	}

	@media screen and (max-width: 375px) {
		body {
			height: 2200px;
		}

		.logo {
			width: 300px;
			height: 135px;
			top: 100px;
		}

		.logo	h4 {
			color: #007c96;
			position: absolute;
			right: 7px;
			bottom: 45px;
			font-size: 20px;
		}

		.comingsoon {
			width: 320px;
			top: 260px;
		}

		.more-info {
			width: 300px;
			height: 500px;
			top: 500px;
			padding: 20px;
		}

		.body-text {
			margin: 50px 0;
		}

		p.paragraph {
			width: 260px;
		}

		.more-info h2 {
			font-size: 20px;
		}

		.more-info p {
			font-size: 13px;
			margin: 25 0 25px 0;
		}

	}

	</style>

	<div class="bg"></div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="logo">
				<img src="<?php echo get_stylesheet_directory_uri() . '/img/sinuslogo_large.png'; ?>" alt="Sinus Headphones company logo" />
				<h4>HEADPHONES & AUDIO</h4>
			</div>

			<div class="comingsoon">
				<h4>Butikken er nu åben!<br><br></h4>
				<h4>Studiestræde 24,</h4>
				<h4>kld. th.</h4>
				<h4>1455 København K<br><br></h4>
				<h4>Vores webshop åbner snart på <br>sinus-store.dk</h4>
			</div>

			<div class="more-info">
				<h2>Sinus er Danmarks mest specialiserede forretning indenfor hovedtelefoner og transportabel lyd.</h2>
					<div class="body-text">
					<div class="first-letter">V</div>
					<p class="paragraph">i har i takt med den teknologiske udvikling nået et punkt hvor hovedparten af den musik vi hører i løbet af en dag, lyttes til igennem vores hovedtelefoner. Og vi mener at musikken i dit liv fortjener god lyd.<br>
					Men hovedtelefoner er ikke bare den gode lyd til dit livs soundtrack. Hovedtelefoner er mode, hovedtelefoner er frihed fra omverdenens støj, hovedtelefoner er in-ear, on-ear, over-ear, med eller uden bluetooth og vigtigst af alt hovedtelefoner skal matche dig og dine behov – og det kan og vil vi hjælpe med.</p>
					</div>
					<div class="body-text">
					<div class="first-letter">S</div>
					<p class="paragraph">inus har sin butik i København og webshoppen som har åbent 24/7. Sinus er den eneste butik i Danmark som tilbyder at du kan prøve dine in-ear hovedtelefoner før du køber dem, da det er vigtigt for os at du får det rigtige produkt med hjem første gang. Men det er mere end bare hovedtelefonerne som gør lyden, og derfor sælger vi i Sinus naturligvis også digitale audio-convertere eller DAC’s som drastisk forbedrer lyden fra din telefon.</p>
					</div>
					<div class="body-text">
					<div class="first-letter">V</div>
					<p class="paragraph">i har i Sinus sammenlagt over 40 års erfaring indenfor hovedtelefoner og lyd, både til professionel brug og til fritidsbrug, så uanset om du skal bruge dine hovedtelefoner til gaming, til løb, til musikindspilninger i studiet, til flyrejser, til at cykle med, i et call-center eller til din telefon som de fleste, så har vi både en enorm ekspertise, et uovertruffent service niveau og de rigtige produkter der vil matche dine behov. Sinus er ikke en stor virksomhed, men en virksomhed med et stort hjerte som går det ekstra stykke vej for alle sine kunder.</p>
				</div>
			</div>

		</main>
	</div>

<?php get_footer(); ?>
