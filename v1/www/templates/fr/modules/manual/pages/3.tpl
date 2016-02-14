<h2>Unités</h2>
<p>
Il existe deux types d’unités dans Zordania : les unités civiles et les unités militaires ... <br/>
Le maximum d'unités qu'il est possible de former, civiles et militaires confondues, est de {GAME_MAX_UNT_TOTAL}.
</p>
<dl>
<dt>Les unités civiles</dt>
<dd>
Elles permettent de gérer, construire et développer le village. 
Certaines de ces unités peuvent êtres assignées à des bâtiments et y travailler. Elles ne peuvent plus faire autre chose, 
et la destruction du bâtiment détruit aussi les unités qui y étaient assignés. 
<br />Toutes les unités peuvent être pendues, donc tuées, sauf celles travaillant dans un bâtiment. 
Le fait de pendre une unité rapporte la moitié de son coût d'origine.
</dd>
<dt>Les unités militaires</dt>
<dd>
Ce sont vos soldats. Ils sont affectés dans des légions que vous pouvez gérer et nommer, 
et qui servent à attaquer d'autres villages. 
<br />
<if cond="|{man_race}| != 3">
La levée d'une armée se fait grâce aux recrues. 
Elles sont nécessaires pour créer des unités militaires. Généralement, les machines de guerre demandent 
même plusieurs recrues pour être construites.
</if>
<else>
Il y a plusieurs niveaux d'unités militaires. Les plus basiques, qui nécessitent un 
entrainement peu pointu, sont formées à la caserne. Elles nécessite donc d'abord la création d'une recrue.
<br>Les unités plus expérimentées sont formées à l'école militaire. Suivant la qualité de la formation, un vétéran ou un héros 
sera nécessaire à la création de l'unité militaire désirée.
</else>
</dd>
</dl>

<h3>La production</h3>
<p>
<if cond="|{man_race}| != 2">
Les unités civiles sont produites à raison d'une unité par tour, sauf si vous possédez une 
forteresse, une cité noire ou une citadelle. En effet, dans ce cas, la production passe à deux par tour.
</if>
<else>
Les unités civiles sont produites à raison de deux unités par tour, sauf si vous possédez un 
fortin. En effet, dans ce cas, la production passe à trois par tour.
</else>
<br />
Le nombre d'unités militaires que vous pouvez former simultanément dépend du nombre de bâtiments adéquats que vous possédez. Par exemple, 
si vous possédez deux casernes, vous pourrez créer deux unités de l'onglet "caserne" par tour.
</p>

<h3>La nourriture <img src="img/{man_race}/res/{GAME_RES_BOUF}.png" alt="{res[{man_race}][alt][{GAME_RES_BOUF}]}" title="{res[{man_race}][alt][{GAME_RES_BOUF}]}" /></h3>
<p>
Chaque unité mange une unité de nourriture par tour.
<br />Si vous tombez à court de nourriture, vos unités mourront de faim. 
Les unités civiles affectées dans des bâtiments ne peuvent cependant pas mourir de faim, 
mais vos légions risquent vite d'être décimées si vous ne faites rien pour stopper la famine qui sévit.
</p>
