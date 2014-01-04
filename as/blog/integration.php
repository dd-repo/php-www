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
					<h1 class=\"dark\" style=\"text-align: center;\">Fin d'année et nouvelles perspectives !</h1>
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
					Avant toute chose, nous vous souhaitons de très joyeuses fêtes et une année 2014 bien remplie. Depuis quelques mois, nous préparons une nouvelle version du site, du <a href='/panel'>panel</a>, 
					de l'<a href='/service/infrastructure'>infrastructure</a>, à la fois afin d'adapter Olympe aux nouvelles pratiques de ses utilisateurs mais aussi pour permettre au réseau de s'étendre et 
					de poursuivre sa croissance sans incident.
				</p>
				<br />
				<img class='blogimage' src='/on/images/news/1/panel.png' />
				<span class='legend'>Le nouveau panel Olympe</span>
				<br />
				<p style='color: #8e8e8e; text-align: justify;'>
					Alors que ces fêtes de fin d'année ont été marquées par quelques problèmes sur l'infrastructure, nous avons profité de ces faiblesses pour 
					accélérer nos développements et avancer – de quelques semaines – la sortie de cette nouvelle version. 
				</p>
<!-- END DESCRIPTION -->
				<br /><br />
<!-- ARTICLE -->
				<h2 class='dark'>Introduction</h2>
				<p style='text-align: justify;'>
					Commençons peut-être par ce qui se voit le moins : l'organisation interne. Nous avons complètement revu nos procédures et les accès de chacun des membres de l'équipe, 
					les codes sources de nos <a href='/developers'>développements</a> ont été ouverts à la communauté (API, panel, bots, filtres FTP…), nous avons étoffé notre documentation et simplifié une partie de la gestion. 
					Actuellement nous travaillons sur notre panel d'administration, tout aussi important pour pouvoir répondre au mieux à vos demandes et vous aider efficacement à utiliser votre compte.
				</p>
				<br />
				<img class='blogimage' src='/on/images/news/1/admin.png' />
				<span class='legend'>L'ancien panel admin</span>
				<br />
				<p style='text-align: justify;'>
					D'un point de vue communication, cela devrait s'en ressentir, nous faisons de notre mieux depuis le début pour être réactifs sur les forums, cela se poursuivra bien évidemment, 
					avec un accent sur les <a href='http://twitter.com/Olympe_fr'>réseau sociaux</a> et la transmission des informations importantes 
					(<a href='https://projets.olympe.in/projects/infrastructure/issues'>maintenances</a> prévues etc…). Pour cela nous avons toujours besoin d'aide, si vous aimez 
					être payé avec de la reconnaissance et que vous désirez connaître les coulisses d'un hébergeur (de nuit de préférence) n'hésitez pas à nous <a href='/about/contact'>contacter</a> :)
				</p>
				<br />
				<h2 class='dark'>L'infrastructure</h2>
				<p style='text-align: justify;'>
					Nous avons lourdement investi dans l'<a href='/service/infrastructure'>infrastructure</a> de la version 7 d'Olympe, à la fois matériellement (nouveaux serveurs, équipements réseau, firewalls...), et 
					humainement (développement, design, déploiement, migration vers le nouveau réseau...). Aujourd'hui, Olympe c'est pratiquement 400Go de RAM unifiée entre les serveurs physiques, 22To de stockage sur notre Ceph 
					et quelques 40 CPU. Nous entrons dans une phase (à la fois pour le développement et l'architecture) où nous pouvons faire évoluer les ressources et les fonctionnalités sans pratiquement aucune limite, 
					si ce n'est nos propres moyens financiers.
				</p>
				<br />
				<img class='blogimage' src='/on/images/news/1/map.png' />
				<span class='legend'>Carte du réseau Olympe / Another Service</span>
				<br />
				<p style='text-align: justify;'>
					Mais pour cela, nous pouvons toujours compter sur nos <a href='/about/partners'>partenaires</a>, qui nous fournissent gracieusement une bonne partie du matériel et du transit réseau nécessaire 
					au bon fonctionnement de la plateforme. Alors, qu'en est-il des nouvelles fonctionnalités ?
				</p>
				<br />
				<img class='blogimage' style='width: 375px;' src='/on/images/news/1/server.png' />
				<span class='legend'>L'une de nos baies dans le NetCenter SFR à Marseille</span>
				<br />
				<p style='text-align: justify;'>
					Durant l'année 2013, nous avons tenté de recueillir les demandes les plus récurrentes : Webcron, PostgreSQL, MongoDB, accès SSH, PHP multi-versions etc... Concernant PHP, nous sommes passés en 
					<a href='http://phpinfo.olympe.in'>version 5.5</a> pour le plus grand bonheur de certains d'entre vous. Pour les autres, qui utilisent des outils non compatibles, nous avons mis en place une solution temporaire avant de concrétiser 
					la gestion de plusieurs versions de PHP en parallèle sur l'infrastructure.
				</p>
				<br />
				<img class='blogimage' src='/on/images/news/1/services.png' />
				<span class='legend'>Nouveaux services prévus</span>
				<br />
				<p style='text-align: justify;'>
					Pour l'instant, pas d'autre langage que PHP au programme (mais il n'est pas dit que cela reste ainsi) mais d'autres fonctionnalités que celles citées un peu plus hauts seront implémentées, 
					comme les dépôts de développement (Git, Subversion…), les services de type Redis ou Memcache etc... De même, l'ouverture du SMTP pour les comptes mails ainsi que l'augmentation des quotas sont 
					au programme ! Quoi qu'il en soit, n'hésitez pas à faire vos demandes de nouvelles fonctionnalités sur le <a href='https://community.olympe.in'>forum</a>.
				</p>
				<br />
				<h2 class='dark'>Les perspectives</h2>
				<p style='text-align: justify;'>
					L'année 2014 s'annonce riche pour Olympe et ses projets associés. De nombreux évènements sont prévus (salons et conférences principalement), nous dédirons des articles à nos 
					déplacements et participations. L'infrastructure va continuer d'évoluer, à la fois pour accroître les ressources en vue de la traduction du site Internet dans trois 
					nouvelles langues et pour mettre en place les nouveaux services. 
				</p>
				<br />
				<img class='blogimage' style='width: 500px;' src='/on/images/news/1/rmll.png' />
				<span class='legend'>Olympe aux RMLL 2012</span>
				<br />
				<p style='text-align: justify;'>				
					Sur le plan associatif, nous allons ouvrir une rubrique dédiée sur le site Internet, au sein de laquelle vous pourrez trouver nos statuts, notre règlement ainsi que le tout nouveau 
					budget 2014 (encore à l'étude). Nous reviendrons sur chacune de ces nouveautés sur ce blog que nous tiendrons dorénavant régulièrement à jour. Nous espérons que cette nouvelle version
					comblera les attentes de chacun(e) de nos utilisateur(rice)s !
				</p>
				<p style='text-align: justify;'>
					Merci à tous et très bon réveillon du bout de l'an !
				</p>
<!-- FIN ARTICLE -->
				<br />
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>