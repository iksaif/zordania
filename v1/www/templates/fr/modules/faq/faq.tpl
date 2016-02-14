Avant toute chose, beaucoup de chose que vous pouvez vous posez sont expliqué dans le <a href="index.php?file=manual&amp;page=1" title="manuel de zordania">manuel</a>, je vous invite donc à allez le voir ;).<br/>
<ul>
<li><a href="faq.html#relog">Je suis obligé de me reconnecter à chaque fois que je viens sur le site</a></li>
<li><a href="faq.html#vacs">Je pars en vacances, est-ce possible de mettre mon compte en veille?</a></li>
<li><a href="faq.html#commerce">Dès que je veux acheter quelque chose au marché, j'obtiens un message d'erreur, pourquoi?</a></li>
<li><a href="faq.html#travail">J'ai créer plusieurs travailleurs pour accélérer, et pourtant, lors d'une construction, tout mes villageois sont disponibles sauf un, pourquoi?</a></li>
<li><a href="faq.html#prevoir">Est-ce que je peux prévoir des constructions à l'avance?</a></li>
<li><a href="faq.html#recherches">J'ai lancé plusieurs recherches et je possède plusieurs chercheurs, mais malgré ça il n'y en a qu'une qui avance; pourquoi?</a></li>
<li><a href="faq.html#foret">J'ai plusieurs forêts/carrières/etc disponibles, et seulement une carrière/forêt/etc disponible, pourquoi?</a></li>
<li><a href="faq.html#cookies">Sur le site est affiché:"Il faut activer les cookies pour pouvoir profiter du site !" mais je ne sais pas comment faire.</a></li>
<li><a href="faq.html#points">Comment sont calculés les points?</a></li>
<li><a href="faq.html#distance">Comment je calcule le temps que je met suivent X distance?</a></li>
<li><a href="faq.html#exp">A quoi sert l'expérience?</a></li>
<li><a href="faq.html#tuer">J'ai créé trop d'unités, comment je fais pour les tuer?</a></li>
<li><a href="faq.html#0%">Je viens de débuter la construction d'un batiment, mais celui-ci reste lamentablement bloqué à 0% (ou bloqué à un pourcentage quelconque).</a></li>
<li><a href="faq.html#impossible">J'ai toutes les ressources voulues, tous les hommes nécessaires de formés et toutes les recherches nécessaires effectuées, mais impossible de construire le bâtiment souhaité...<a><br />
<li><a href="faq.html#simultaneite">Puis-je réaliser plusieurs bâtiments/unités/recherches en même temps?</a></li>
<li><a href="faq.html#annule">Que se passe-t-il si j'annule une construction/formation/recherche? Est-ce qu'une partie des ressources investies m'est reversée?</a></li>
<li><a href="faq.html#vendre">J'aimerais commercer, mais impossible de trouver où vendre/acheter...</a></li>
<li><a href="faq.html#marche">J'ai construis mon marché, mais impossible de vendre quoi que ce soit!</a></li>
</ul>
<dl>

  <dt id="relog">Je suis obligé de me reconnecter à chaque fois que je viens sur le site</dt>
  
    <dd>C'est sans doute que les cookies ne sont pas acceptés par votre navigateur, voir <a href="faq.html#cookies">ici</a></dd>
	
  <dt id="vacs">Je pars en vacances, est-ce possible de mettre mon compte en veille?</dt>
  
    <dd>Oui, un bouton "mise en veille" est prévu pour cela, il permet ainsi de ne pas se faire attaquer mais aussi de ne pas amasser de ressources.
	    La mise en veille marche pour une durée minimale de <strong>6 jours </strong></dd>

  <dt id="commerce">Dès que je veux acheter quelque chose au marché, j'obtiens un message d'erreur, pourquoi?</dt>
  
    <dd>C'est sans doute que votre niveau de recherche de commerce n'est pas suffisant</dd>
	
  <dt id="travail">J'ai créer plusieurs travailleurs pour accélérer, et pourtant, lors d'une construction, tout mes villageois sont disponibles sauf un, pourquoi?</dt>
  
    <dd>Même si vos travailleurs apparaissent disponibles, ils accélèrent la vitesse de construction, a raison de: nombre de tours réels = nombre de tours annoncés /nombre de travailleurs</dd>

  <dt id="prevoir">Est-ce que je peux prévoir des constructions à l'avance?</dt>
  
    <dd>Non, c'est impossible</dd>
	
  <dt id="recherches">J'ai lancé plusieurs recherches et je possède plusieurs chercheurs, mais malgré ça il n'y en a qu'une qui avance; pourquoi?</dt>
  
    <dd>Il est possible de lancer plusieurs recherches en même temps, mais elles s'éxécutent l'une après l'autre, et les chercheurs ne servent qu'à accélérer celle éxécutée</dd>
	
  <dt id="foret">J'ai plusieurs forêts/carrières/etc disponibles, et seulement une carrière/forêt/etc disponible, pourquoi?</dt>
  
    <dd>Les ressources telle que les forêts, les carrières, les mines, etc... apparaissent disponibles au hasard, donc il faut avoir un peu de chance :p</dd>
	
  <dt id="cookies">Sur le site est affiché:"Il faut activer les cookies pour pouvoir profiter du site !" mais je ne sais pas comment faire</dt>
  
    <dd>
    Il faut accepter tout les cookies provenant de www.zordania.com<br />
	    <dl>
	    <dt>Pour IE:</dt>
	        <dd>Outils/options Internet/"onglet" confidentialité<br />
			    il faut que le niveau ne soit ni "haute", ni "bloquer tout les cookies"</dd>
		<dt>Pour Mozilla Firefox:</dt>
		    <dd>Outils/options /vie privée<br />
	           Il faut que la case:"Autoriser les sites à créer des cookies" soit cocher et que "conserver les cookies ne soit pas sur:"jusqu'à la fermeture de firefox"<br />
			    Si nécessaire il faut enlever le sites zordania.cliranet.com de la liste "exceptions" si il est sur "bloquer"</dd>
   	   </dl>
   </dd>

  <dt id="points">Comment sont calculés les points?</dt>

    <dd>les points se calculent ainsi: 
    <code>
    Somme de la vie de tout les Bâtiments*{MODIF_PTS_BTC} / 3 
    + Nombre de Civils * 25
    + Nombre de Militaires * 50
    + Nombre de Recherches x 100
    + Experience de vos Legions x 20
    </code>
    </dd>

  <dt id="distance">Comment je calcule le temps que je met suivent X distance?</dt>
  
    <dd>la nombre de tours totals est égal à la distance divisé par la vitesse. Pour ceux qui veulent calculer, la vitesse de l'armée se base sur une moyenne pondérée. Le nombre de tour pour atteindre l'ennemi vaut la distance qui vous sépare de lui divisé par la vitesse moyenne de votre légion (cette valeur est donnée automatiquement une fois l'attaque lancée).</dd>

  <dt id="exp">A quoi sert l'expérience?</dt>
  
    <dd>l'expérience sert à augmenter ses <a href="faq.html#points">points</a>, et à apparaitre au top 50 :#), elle donne aussi un bonus (d'attaque et de défense) de 1% tout les 100 pts d'xp.</dd>
	
  <dt id="tuer">J'ai créé trop d'unités, comment je fais pour les tuer?</dt>
  
    <dd>Pour tuer des unités, il faut aller dans "population", puis cliquer sur l'icone de l'unité en surplus, indiquer le nombre à tuer et enfin cliquer sur "Pendez-les!"</dd>

  <dt id="0%">Je viens de débuter la construction d'un batiment, mais celui-ci reste lamentablement bloqué à 0% (ou bloqué à un pourcentage quelconque).</dt>
  
    <dd>vous avez sans doute supprimé, à un moment ou à un autre, l'ensemble de vos ouvriers. Formez-en un nouveau, ca devrait fonctionner. N'oubliez pas de controler votre production de nourriture...</dd>
	
  <dt id="impossible">J'ai toutes les ressources voulues, tous les hommes nécessaires de formés et toutes les recherches nécessaires effectuées, mais impossible de construire le bâtiment souhaité...</dt>
  
    <dd>verifiez que tous les bâtiments nécessaires à la construction du votre ont bien été construits. Pour cela,vérifier l'arbre de construction de votre race dans le manuel. Tout ce qui se trouve en-deça de votre bâtiment dans l'arbre doit être construit avant de pouvoir débuter...</dd>
	
  <dt id="simultaneite">Puis-je réaliser plusieurs bâtiments/unités/recherches en même temps?</dt>
  
    <dd>vous pouvez lancer simultanément des recherches, des formations et des constructions. Vous ne pouvez pas lancer plusieurs constructions en même temps. Par contre, vous pouvez lancer plusieurs recherches/formations en même temps, mais seulement la première d'entre elles avancera. Les autres se metteront dans une file d'attente, et commenceront quand la précédente formation/recherche sera terminée.</dd>
	
  <dt id="annule">Que se passe-t-il si j'annule une construction/formation/recherche? Est-ce qu'une partie des ressources investies m'est reversée?</dt>
  
    <dd>si vous annulez une formation/construction/recherche, celle-ci s'arrête et vous laisse le champ libre pour une autre. Vous récupérez alors 50% des ressources investies.</dd>
	
  <dt id="vendre">J'aimerais commercer, mais impossible de trouver où vendre/acheter...</dt>
  
    <dd>avant de pouvoir vendre/acheter, il faut posséder un commerce. Pour réaliser cette construction, il faut un minimum au préalable. Toutes les conditions sont détaillées dans <a href="http://www.zordania.com/manual.html?race=1&type=btc">le manuel</a></dd>
	
  <dt id="marche">J'ai construis mon marché, mais impossible de vendre quoi que ce soit!</dt>
  
    <dd>avoir construit un marché ne suffit malheureusement pas pour pouvoir commercer. Il vous faut aussi effectuer la recherche "marché niveau 1" pour pouvoir vendre/acheter jusqu'à 50 unités de matériels divers.</dd>
 
</dl>