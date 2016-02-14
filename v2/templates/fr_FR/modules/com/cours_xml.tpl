<?xml version="1.0" encoding="iso-8859-1"?>
<cours>
	<foreach cond="{com_cours} as {date} => {cours}">
	<jour>
		<date>{date}</date>
		<ressources>
			<foreach cond="{cours} as {res} => {prix}">
			<ressource>
				<type>{res}</type>
				<prix>{prix}</prix>
			</ressource>
			</foreach>
		</ressources>
	</jour>
	</foreach>
</cours>