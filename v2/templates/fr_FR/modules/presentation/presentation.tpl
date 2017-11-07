
<style>

/* Swipe 2 required styles */

.swipe {
  overflow: hidden;
  visibility: hidden;
  position: relative;
}
.swipe-wrap {
  overflow: hidden;
  position: relative;
}
.swipe-wrap > div {
  float:left;
  width:100%;
  position: relative;
}
/* END required styles */
.swipe-wrap > div > img {
  margin-left:auto;
  margin-right:auto;
  display:block;
}
.swipe-wrap > div > p {
  font-size: 9px;
}
.swipe-wrap > div {
    background-repeat: no-repeat;
	background-position: center;
	height: 400px;
}
.swipe-wrap > div > * {
   opacity: 0.7;
   background-color: wheat;
   margin: 0px;
}
.swipe-wrap > div > h3 {
   padding-left: 20px;
}
.swipe-wrap > div:nth-child(1) {
    background-image: url("img/portail/village400.png");
}
.swipe-wrap > div:nth-child(2) {
    background-image: url("img/portail/recherche400.png");
}
.swipe-wrap > div:nth-child(3) {
    background-image: url("img/portail/unite400.png");
}
.swipe-wrap > div:nth-child(4) {
    background-image: url("img/portail/arbre400.png");
}
.swipe-wrap > div:nth-child(5) {
    background-image: url("img/portail/carte400.png");
}

</style>

<div id='mySwipe' style='max-width:500px;margin:0 auto' class='swipe'>
  <div class='swipe-wrap'>
  
	<div>
		<!-- img src="img/portail/village400.png" alt="image1"/ -->
		<h3>Êtes-vous prêt à rejoindre Zordania ?</h3>
		<p>Entrez dans le monde fantastique de Zordania, gérez votre cité et affrontez des ennemis 
		toujours plus puissants pour mener vos soldats à la victoire ?<br/>
		Zordania est un jeu tour par tour de stratégie médiévale fantastique gratuit où vous incarnez un seigneur, 
		chef d'une cité que vous devrez gérer au niveau économique et surtout au niveau militaire. Choisissez votre race pour devenir un être sanguinaire, ou sauver la veuve et l'orphelin. Mais soyez toujours prêt, car tous vos voisins ne vous laisseront pas prospérer en paix.</p>
	</div>
	<div>
		<!-- img src="img/portail/recherche400.png" alt="image2"/ -->
		<h3>Un jeu de gestion :</h3>
		<p>Vous débutez à la tête d'un petit village. C'est à vous de le faire grandir en formant de nouvelles 
		unités et en construisant de nouveaux bâtiments. Produisez et gérez vos ressources au mieux pour nourrir 
		votre peuple, fabriquer des armes et construire votre cité pierre par pierre. Achetez ce dont vous manquez ou vendez vos surplus à d'autres seigneurs pour vous enrichir. Faites évoluer votre village en une cité riche et puissante en améliorant votre technologie.</p>
	</div>
	<div>
		<!-- img src="img/portail/unite400.png" alt="image1"/ -->
		<h3>Un jeu militaire :</h3>
		<p>Surveillez les environs, les autres seigneurs ne se priveront pas pour vous rendre une visite peu 
		courtoise, et les quelques unités militaires de base dont vous disposez à votre prise de pouvoir seront
		rapidement dépassées. Formez une armée en fonction de vos préférences. Attaquez les légions adverses,
		les bâtiments de vos ennemis, ou défendez votre cité becs et ongles. Érigez des tours et votre 
		forteresse pour vous protéger.</p>
	</div>
	<div>
		<!-- img src="img/portail/arbre400.png" alt="image1"/ -->
		<h3>Un jeu multi-joueurs :</h3>
		<p>Lorsque vous aurez fait vos preuves, vous pourrez entrer dans une alliance puissante, ou créer la votre.
		Recrutez vos alliés parmi les autres joueurs, partagez vos richesses, établissez vos stratégies à l'abri 
		des regards et faites en sorte que votre alliance fasse partie de l'histoire de Zordania.</p>
	</div>
	<div>
		<!-- img src="img/portail/carte400.png" alt="image1"/ -->
		<h3>Une communauté présente :</h3>
		<p>Que vous souhaitiez discuter de Zordania ou d'autre chose, demander de l'aide à d'autres joueurs,
		affirmer la diplomatie de votre alliance ou la votre, ou faire état de vos victoires et de vos défaites
		militaires, le forum est fait pour vous !
		Dans une bonne ambiance, c'est là que la communauté se forme et que les joueurs apprennent à se 
		connaître et à jouer ensemble. </p>
	</div>

  </div>
</div>

<script src='js/swipe.js'></script>
<script>

// with jQuery
window.mySwipe = $('#mySwipe').Swipe().data('Swipe');

</script>

