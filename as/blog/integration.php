<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

//$news = api::send('news/list', array('id'=>$_GET['id']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
//$new = $news[0]

$content = "
			<div class=\"head-light\">
				<div class=\"container\" style=\"text-align: center;\">
					<h1 class=\"dark\" style=\"text-align: center;\">Heureuse année 2014 !</h1>
					<br />
					<div style=\"width: 305px; margin: 0 auto;\">
						<span style=\"color: #797979; font-size: 14px; display: block; float: left; padding-top: 7px;\">25 décembre 2013 par</span>
						<img style=\"display: block; float: left; margin-left: 10px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/1.png\" class=\"author\" />
						<a style=\"display: block; float: left; padding-top: 8px; margin-left: 10px;\" href=\"/about/team#Yann Autissier\">Yann Autissier</a>
						<div class=\"clear\"></div>
					</div>
				</div>
			</div>	
			<div class=\"content\" style=\"width: 850px;\">
<!-- DESCRIPTION -->
				<p style='color: #8e8e8e; text-align: justify;'>
					L'ensemble de l'équipe Another Service vous souhaite une heureuse année 2014 ! A cette occasion, nous avons mis à jour notre site Internet et notre panel afin de mieux répondre aux demandes 
					formulées par nos clients, notamment sur la gestion des applications et des environnements de développement.
				</p>
				<br />
				<img class='blogimage' src='/as/images/news/1/panel.png' />
				<span class='legend'>Le nouveau panel Another Service</span>
				<br />
				<p style='color: #8e8e8e; text-align: justify;'>
					Sur le plan de l'infrastructure et des fonctionnalités, nous avons également fait de nombreuses évolutions. La migration de <a href='http://www.cloudfoundry.org'>CloudFoundry</a> vers 
					<a href='http://www.docker.io'>Docker.io</a> s'est déroulée sans problème et de nombreux nouveaux services seront disponibles dans les prochaines semaines.
				</p>
<!-- END DESCRIPTION -->
				<br /><br />
<!-- ARTICLE -->
				<h2 class='dark'>Applications et branches</h2>
				<p style='text-align: justify;'>
					Dorénavant, chaque application possède des branches (développement, production, recette...)  et chaque branche a ses propres processus isolés. Vous pouvez visualiser en temps réel l'état des processus ainsi
					que leur consommation de CPU ou de mémoire. De même, vous pouvez entièrement gérer les conteneurs (lancement, arrêt, redémarrage, reconstruction...) de votre application, en fonction de la branche
					sur laquelle vous vous trouvez.
				</p>
				<br />
				<img class='blogimage' src='/as/images/news/1/instances.png' />
				<span class='legend'>Contrôle des instances d'une branche</span>
				<br />
				<p style='text-align: justify;'>
					Pour chaque branche, vous pouvez ajuster le nombre d'instances et la mémoire qui leur est allouée. Ainsi, en cas de forte charge, vous avez la possibilité d'augmenter temporairement les limites 
					de votre application pour assurer la fluidité de votre site.
				</p>
				<br />
				<img class='blogimage' style='width: 380px;' src='/as/images/news/1/adjust.png' />
				<span class='legend'>Ajustement des ressources d'une branche</span>
				<br />
				<h2 class='dark'>Migration vers Docker.io</h2>
				<p style='text-align: justify;'>
					Après une année passée sur CloudFoundry, nous avons décidé de migrer vers une solution plus flexible qui nous permet de créer des conteneurs préfabriqués pour les langages, les frameworks et les applications
					elles-mêmes. Les dockers sont en réalité des conteneurs LXC, dont l'image est éphémère. Les templates peuvent être mis à jour comme des dépôts Git (possibilité de rollback sur des versions antérieures, 
					commit des différences uniquement...).
				</p>
				<br />
				<img class='blogimage' style='width: 682px;' src='/as/images/news/1/docker.png' />
				<span class='legend'>Docker.io : <a href='http://www.docker.io'>http://www.docker.io</a></span>
				<br />
				<p style='text-align: justify;'>
					Nous reviendrons sur cette migration ainsi que sur les scripts que nous avons développés pour gérer les dockers dans une série d'articles sur ce blog. 
				</p>
				<br />
				<h2 class='dark'>Développement de notre réseau</h2>
				<p style='text-align: justify;'>
					Another Service est membre du RIPE depuis trois ans, nous avons récemment accéléré les procédures afin de renforcer notre indépendance vis-à-vis de nos fournisseurs actuels. Des sous-réseaux IPv4 et IPv6 
					nous ont été alloué, ainsi que le numéro d'AS 62260. Nous avons commencé à installer du matériel réseau supplémentaire dans les datacenters au sein desquels nous possédons des espaces.
				</p>
				<br />
				<img class='blogimage' style='width: 301px;' src='/as/images/news/1/server.png' />
				<span class='legend'>Quelques serveurs à Interxion Paris 2</span>
				<br />
				<h2 class='dark'>Les perspectives</h2>
				<p style='text-align: justify;'>
					Nous allons progressivement activer tous les <a href='/doc/languages'>langages</a> et tous les services <a href='/doc/services'>services</a> prévus. Nous améliorerons également les outils de suivis et de 
					statistiques (temps de réponse des applications, disponibilité...). Les investissements sur l'infrastructure seront poursuivis, afin de continuer à accroître la qualité de notre service et de garantir
					des disponibilités et des performances toujours meilleures.
				</p>
				<br />
				<p style='text-align: justify;'>
					Merci et bonne année 2014 !
				</p>
<!-- FIN ARTICLE -->
				<br />
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>