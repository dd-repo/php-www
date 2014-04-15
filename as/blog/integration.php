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
					<h1 class=\"dark\" style=\"text-align: center;\">Partenariat avec les Flash de la Courneuve</h1>
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
					Another Service vient de concrétiser son premier partenariat dans le domaine sportif et devient sponsor de l'équipe de football américain des <a href='http://www.flashfootball.org'>Flash de la Courneuve</a>. Après
					des discussions avec notre partenaire <a href='http://www.interxion.fr'>Interxion</a>, nous avons mis en place un programme permettant d'accompagner le club sur ses besoins croissants
					en terme de technologies et de réseau.
				</p>
				<br />
				<img class='blogimage' src='/as/images/news/2/flash.png' />
				<span class='legend'>Affiche du premier match des Flash de la saison 2014</span>
				<br />
				<p style='color: #8e8e8e; text-align: justify;'>
					Engagé sur le terrain de l'insertion et de la jeunesse en Seine-Saint-Denis, le club historique vient de fêter ses trente ans et désire développer son positionnement numérique notamment grâce à 
					la retransmission de ses matches en direct.
				</p>
<!-- END DESCRIPTION -->
				<br /><br />
<!-- ARTICLE -->
				<h2 class='dark'>Notre démarche</h2>
				<p style='text-align: justify;'>
					Another Service soutient déjà l'association <a href='https://www.olympe.in'>Olympe</a> ainsi que de nombreuses initiatives à but non lucratif. Nous avons à coeur de partager nos connaissances et notre savoir, de mettre à disposition
					nos compétences au profit de projets nécessitant un savoir-faire approfondi dans les domaines des technologies de l'information. L'approche des Flash de la Courneuve est à la fois orientée vers une action locale
					en faveur de l'insertion ainsi qu'axée autour de l'insertion des jeunes par le sport, c'est avant tout cet esprit que nous soutenons en mettant à disposition nos ressources et notre infrastructure.
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