<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Projet- mapet's</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/wp-content/themes/Projet-CollierPourChien/assets/css/style.css">
	<script src="https://kit.fontawesome.com/cfa8de8fe8.js" crossorigin="anonymous"></script>
</head>
<header>
	<!-- Haut de page -->
	<nav class="header">
		<img  class="logo" src="/wp-content/themes/Projet-CollierPourChien/image/logo.png">
		<?php connexion_utilisateur(); ?>
	</nav>

	<script type="text/javascript">
		const navSlide = () => {
			const burger = document.querySelector('.burger');
			const nav = document.querySelector('.nav-links');
			const navLinks = document.querySelectorAll('.nav-links li')
			
			burger.addEventListener('click',()=>{

				nav.classList.toggle('nav-active');

			navLinks.forEach((link, index) => {
				if(link.style.animation) {
					link.style.animation = '';
				} else {
					link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 +0.5}s`;
				}
			});
		});
	}
		navSlide();
	</script>
</header>
<body>
<script src="/wp-content/themes/Projet-CollierPourChien/assets/js/main.js"></script>

