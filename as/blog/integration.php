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
					<h1 class=\"dark\" style=\"text-align: center;\">Salt et Gearman pour opérer un cloud privé</h1>
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
					Lors des dernières évolutions de notre infrastructure, nous nous sommes notamment penchés sur les besoins croissants de notre <a href='https://api.anotherservice.com'>API</a> en matière d'interaction avec notre infrastructure,
					notamment pour le lancement des commandes, la supervision des processus et l'ensemble des tâches de maintenance et de vérification de la plateforme (quotas, mises à jour, reconstruction des dockers...).
				</p>
				<br />
				<img class='blogimage' src='/as/images/news/2/flash.png' />
				<span class='legend'>Affiche du premier match des Flash de la saison 2014</span>
				<br />
				<p style='color: #8e8e8e; text-align: justify;'>
					Nous avons d'abord cherché des solutions proposant des API REST ou, à minima, une ligne de commande assez robuste et avons finalement opté pour une solution alternative, permettant une interactivité et une fiabilité 
					intéressante pour la gestion d'un cloud privé à grande échelle, avec Salt et Gearman. <a href='http://www.saltstack.com'>Salt</a> est un gestionnaire de configuration unifiée permettant de créer des gabarits de 
					configuration et d'actions afin de faciliter les déploiements de masse, tandis que Gearman est un middleware permettant de gérer des listes de tâches synchrones ou asynchrones pouvant être réalisées par plusieurs workers en parallèle.
				</p>
<!-- END DESCRIPTION -->
				<br /><br />
<!-- ARTICLE -->
				<h2 class='dark'>Implémentation</h2>
				<p style='text-align: justify;'>					
					L'implémentation de base est assez simple, prenons un exemple sur la distribution Ubuntu :
					<pre>
					<code>sudo apt-get update
sudo apt-get -f install python-software-properties gearman-job-server
sudo add-apt-repository ppa:saltstack/salt
sudo apt-get -f install salt-master salt-minion
</code>
					</pre>
									</p>
				<br />
				<img class='blogimage' src='/as/images/news/2/30.png' />
				<span class='legend'>Les 30 ans du Flash</span>
				<br />
				<h2 class='dark'>Implantation dans le nouveau datacenter</h2>
				<p style='text-align: justify;'>
					Nous apportons notre savoir-faire à la fois pour les besoins quotidiens du club mais également pour la mise en oeuvre de leurs nouveaux moyens de retransmission vidéo. Another Service s'implante donc dans 
					le nouveau datacentre Interxion de La Courneuve (Paris 7) afin de couvrir les besoins des Flash. Nous avons terminé l'installation d'une nouvelle baie, d'une connexion multi-homée 100Mbs ainsi 
					que d'une liaison dédiée fibre noire vers Paris 2. 
				</p>
				<br />
				<img class='blogimage' src='/as/images/news/2/paris7.png' />
				<span class='legend'>Hall du datacenter Interxion Paris 7</span>
				<br />
				<p style='text-align: justify;'>
					Ce nouveau positionnement nous permet également d'améliorer la résilience de notre réseau parisien et est l'occasion pour nous d'investir dans de nouveaux équipements de routage et de sécurité.
				</p>
				<br />
				<h2 class='dark'>Déploiement des antennes</h2>
				<p style='text-align: justify;'>
					Lors de nos premières interventions, nous avons évalué la faisabilité de plusieurs scenarii concernant la liaison entre le stade Géo André de la Courneuve et le centre de données situé à quelques centaines de mètres.
					Les travaux pour tirer une fibre ont été écarté et une solution d'antenne longue portée a été retenue. Nous avons donc procéder au déploiement d'antennes 10Gbs ayant une portée de plusieurs kilomètres en faisceau 
					direct.
				</p>
				<br />
				<img class='blogimage' style='width: 301px;' src='/as/images/news/2/antenne.png' />
				<span class='legend'>L'antenne du côté du stade</span>
				<br />
				<p style='text-align: justify;'>
					Une fois la liaison en place et les équipements déployés, les caméras du stade ont été reliées au réseau global de notre infrastructure afin d'assurer la retransmission du flux vidéo.
				</p>
				<br />
				<h2 class='dark'>Premier match diffusé</h2>
				<p style='text-align: justify;'>
					Le championnat de football américain élite, malgré la faible médiatisation de ce sport, est tout de même suivi par de nombreux aficionados. La diffusion du premier match a eu lieu le 15 mars dernier, 
					plus de 15 000 personnes ont pu regarder les Flash donner une <a href='http://www.footballamericain.com/fffa/2014-j3-la-courneuve-flash-vs-pessac-kangourous/30-ans-cela-se-fete.html'>leçon aux Kangs de Nice</a> (36-0).
				</p>
				<br />
				<img class='blogimage' src='/as/images/news/2/match.png' />
				<span class='legend'>Photo du match du 15 mars</span>
				<br />
				<p style='text-align: justify;'>
					Nous souhaitons beaucoup de réussite à cette équipe et envisageons d'autres collaborations par la suite car les besoins ne cessent d'évoluer.
				</p>				
<!-- FIN ARTICLE -->
				<br />
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>