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
					<h1 class=\"dark\" style=\"text-align: center;\">Ceph RBD : la solution aux problématiques de stockage ?</h1>
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
					L'un des points clés d'une plateforme cloud est certainement le stockage des données persistantes. Les baies de disques, au-delà de leur coût prohobitif surtout lorsqu'il s'agit de full SSD, représentent une solution
					assez lointaine de l'idée que nous nous faisons d'un service haute disponibilité et résistant aux pannes. La recherche d'une solution de stockage fiable et extensible (anticiper sur la croissance 
					du volume des données) est donc pour nous déterminante, d'autant que la production de contenu s'accélère chaque jour un peu plus.
				</p>
				<br />
				<img class='blogimage' src='/as/images/news/3/intro.png' />
				<span class='legend'>Ceph, le futur du stockage</span>
				<br />
				<p style='color: #8e8e8e; text-align: justify;'>
					La démocratisation des réseaux 10Gbs et l'amélioration globale des performances du matériel permet aujourd'hui d'envisager de nouvelles alternatives tout aussi efficaces que les coûteuses baies de disques et répondant aux exigences
					d'un système de stockage sécurisé et performant. Depuis 3 ans, nous avons eu l'occasion de tester de nombreux systèmes, de <a href='http://www.gluster.org'>GlusterFS</a> en passant par <a href='http://www.moosefs.org'>MooseFS</a>
					et <a href='http://www.lustre.org'>Lustre</a>, pour finalement s'arrêter sur <a href='http://www.ceph.com'>Ceph</a>, un écosystème aux multiples avantages.
				</p>
<!-- END DESCRIPTION -->
				<br /><br />
<!-- ARTICLE -->
				<h2 class='dark'>Introduction à Ceph</h2>
				<p style='text-align: justify;'>
					Ceph est une suite d'outils permettant la création d'un cluster de machines agrégeant les disques au niveau logiciel pour offrir un espace unifié de stockage orienté objet. Il a la capacité à distribuer et répliquer
					la donnée sur de multiples noeuds et d'assurer l'intégrité des métadonnées. Depuis la <a href='http://linuxfr.org/news/nouvelle-version-2634-du-noyau-linux#ceph'>version 2.6.34</a> du noyau Linux, les module RBD et Ceph 
					sont pleinement intégrés au système d'exploitation. De nombreux drivers pour la virtualisation et notamment l'interaction avec KVM, <a href='http://www.openstack.org'>OpenStack</a>, <a href='http://cloudstack.apache.org'>CloudStack</a>,
					<a href='http://www.proxmox.com'>Proxmox</a> etc... ont été implémentés au fil des années.
				</p>
				<p style='text-align: justify;'>
					Ceph stocke l'ensemble des données sur un système unifié, et propose trois orientations : applicative, système et généraliste. La première via la fourniture d'APIs variées de compatibilité (Amazon S3, OpenStack Swift....), 
					la deuxième par le concept de Rados Block Device permettant de stocker des partitions (pour des machines virtuelles ou physiques) et la troisième à travers un driver kernel exportant l'un des pools Ceph vers une 
					partition compatible <a href='http://fr.wikipedia.org/wiki/POSIX'>POSIX</a> pouvant être utilisée depuis plusieurs clients différents (un NFS distribué-répliqué multi-points d'entrées globalement).				
				</p>
				<br />
				<img class='blogimage' src='/as/images/news/3/stack.png' />
				<span class='legend'>La stack Ceph</span>
				<br />
				<p style='text-align: justify;'>
					Le systme stocke les données sur des partitions <a href='http://www.xfs.org'>XFS</a> ou <a href='https://btrfs.wiki.kernel.org'>BTRFS</a> et les présente sous forme d'objets uniques. Les métadonnées
					sont traitées par un processus séparé, tandis que les données binaires sont stockées par un autre processus.				
				</p>
				<br />
				<img class='blogimage' src='/as/images/news/3/expose.png' />
				<span class='legend'>Schéma simplifié de stockage des données</span>
				<br />
				<img class='blogimage' src='/as/images/news/3/metadata.png' />
				<span class='legend'>Structure des objets stockés</span>
				<br />
				<h2 class='dark'>Résistant à la panne</h2>
				<p style='text-align: justify;'>
					 Sur notre infrastructure, nous utilisons notre cluster Ceph à deux fins : la première, stocker les images des machines virtuelles afin de permettre la live migration, les snapshots..., la seconde, stocker les fichiers 
					 persistants de nos clients et de nos utilisateurs. Le principal intérêt de Ceph (et des autres systèmes de stockage que nous avons cités) est sa capacité à distribuer et répliquer la donnée sur de multiples noeuds,
					 et à offrir un espace extensible et sécurisé. L'un des premiers clusters de notre infrastructure comprenait 8 noeuds :
				</p>
				<pre><code># ceph osd tree
# id    weight  type name       up/down reweight
-1      18.2    root default
-2      1.82            host as-001
0       1.82                    osd.0   up      1
-3      1.82            host as-002
1       1.82                    osd.1   up      1
-4      1.82            host as-003
2       1.82                    osd.2   up      1
-5      1.82            host as-004
3       1.82                    osd.3   up      1
-6      2.73            host as-005
4       2.73                    osd.4   up      1
-7      2.73            host on-001
5       2.73                    osd.5   up      1
-8      2.73            host on-002
6       2.73                    osd.6   up      1
-11     2.73            host on-003
7       2.73                    osd.7   up      1</pre></code>
				<br />
				<p style='text-align: justify;'>
					En fonction du 'pool' (espace de nommage), nous pouvons choisir un niveau de réplication et le nombre de copies (3 réplicas sur notre infrastructure). L'écriture des données s'effectuent ensuite récursivement.
				</p>
				<pre><code># rbd create {PARTITION_NAME} --size {PARTITION_SIZE} --pool {POOL}
# ceph osd pool set {POOL} size 3
# ceph osd dump | grep 'rep size'
pool 0 'data' rep size 3 min_size 1 crush_ruleset 0 object_hash rjenkins pg_num 64 pgp_num 64 last_change 1 owner 0 crash_replay_interval 45
pool 1 'metadata' rep size 3 min_size 1 crush_ruleset 1 object_hash rjenkins pg_num 64 pgp_num 64 last_change 1 owner 0
pool 2 'rbd' rep size 3 min_size 1 crush_ruleset 2 object_hash rjenkins pg_num 333 pgp_num 333 last_change 40 owner 0
pool 3 {POOL} rep size 3 min_size 1 crush_ruleset 0 object_hash rjenkins pg_num 333 pgp_num 333 last_change 177345 owner 0</code></pre>
				<br />
				<img class='blogimage' src='/as/images/news/3/write.png' />
				<span class='legend'>Ecriture d'une donnée répliquée</span>
				<br />
				<h2 class='dark'>Extensible</h2>
				<p style='text-align: justify;'>
					Une fois le bloc device créé et formaté (nous utilisons XFS pour son support efficace des partitions supérieures à 20To et des quotas hards), il est possible de continuer à faire croître le cluster
					en ajoutant de nouveaux noeuds et en augmentant la taille du bloc puis celle de la partition.
				</p>			
				<pre><code># rbd map --pool {POOL} {PARTITION_NAME} --id admin --keyring /etc/ceph/ceph.client.admin.keyring
# mkfs -t xfs /dev/rbd/{POOL}/{PARTITION_NAME}
# rbd resize --pool {POOL} --image {PARTITION_NAME} --size {NEW_SIZE}
# xfs_growfs /dev/rbd/{POOL}/{PARTITION_NAME}</code></pre>
				<br />
				<img class='blogimage' src='/as/images/news/3/rebalance.png' />
				<span class='legend'>Opération d'équilibrage après l'ajout d'un nouveau noeud</span>
				<br />
				<h2 class='dark'>Performances et supervision</h2>
				<p style='text-align: justify;'>
					Lors de nos premiers tests avec GlusterFS et MooseFS, nous êtions satisfaits des fonctionnalités mais les performances étaient largement en dessous de nos exigences, malgré un réseau et du matériel performant. 
					Les tests effectués lors du déploiement de Ceph sur notre architecture étaient en revanche prommetteurs. Ils correspondent aujourd'hui, sur un coeur de réseau 10Gbs, aux performances attendues.
				</p>
				<pre><code># dd bs=1M count=512 if=/dev/zero of=testperf conv=fdatasync
512+0 records in
512+0 records out
536870912 bytes (537 MB) copied, 3.257 s, 167 MB/s</code></pre>
				<pre><code># hdparm -t /dev/md1
  /dev/md1:
    Timing buffered disk reads: 308 MB in  1.46 seconds =  219.18 MB/sec</code></pre>
				<br />
				<p style='text-align: justify;'>
					La supervision du cluster Ceph est importante pour déceler les anomalies éventuelles et assurer le fonctionnement fluide du stockage. Ceph propose pour cela une ligne de commande efficace mais également une API REST
					aux fonctionnalités similaires.
				</p>
				<pre><code># ceph -s
    cluster 2f341af3-1005-4f41-97f1-e1c4a7fba30d
     health HEALTH_OK
     monmap e1: 7 mons at {as-001=172.16.1.1:6789/0,as-002=172.16.1.2:6789/0,as-003=172.16.1.3:6789/0,as-004=172.16.1.4:6789/0,as-005=172.16.1.5:6789/0,on-001=172.16.2.1:6789/0,on-002=172.16.2.2:6789/0}, election epoch 4318, quorum 0,1,2,3,4,5,6 as-001,as-002,as-003,as-004,as-005,on-001,on-002
     mdsmap e171681: 1/1/1 up {0=as-002=up:active}, 3 up:standby
     osdmap e177399: 8 osds: 8 up, 8 in
      pgmap v8026415: 1127 pgs, 5 pools, 2460 GB data, 648 kobjects
            4614 GB used, 13998 GB / 18613 GB avail
                1127 active+clean</code></pre>
				<br />
				<p style='text-align: justify;'>
					Le fonctionnement de l'API est tout aussi simple :
				</p>
				<pre><code># curl localhost:5000/api/v0.1/health
HEALTH_OK
# curl localhost:5000/api/v0.1/osd/tree
# id    weight  type name   up/down reweight
-1  2   root default
-4  2       datacenter dc
-5  2           room laroom
-6  2               row larow
-3  2                   rack lerack
-2  2                       host ceph
0   1                           osd.0   up  1
1   1                           osd.1   up  1</pre></code>
				<br /><br />
				<h2 class='dark'>CephFS, oui mais ?</h2>
				<p style='text-align: justify;'>
					Une fois le bloc monté sur l'une des machines de l'infrastructure, reste à assurer la pérénité du point d'entrée car si les données sont parfaitement sécurisés, RBD ne suppose pas les accès concurrents et devient donc un SPOF
					de l'infrastructure. Nous avons évalué l'implémentation de CephFS, un système de fichiers multi-points (intégrité des écriture simultanées) permettant de monter à distance un pool Ceph de manière compatiable POSIX. 
					Cependant, CephFS souffre encore de lacunes dans la gestion de très nombreux petits fichiers (plusieurs centaines de millions) mais semble, à l'instar de GlusterFS, mieux adapté pour stocker des données volumineuses comme 
					des images de disques virtuels dans le cas d'une architecture cloud.
				</p>
				<br />
				<img class='blogimage' src='/as/images/news/3/cephfs.png' />
				<span class='legend'>Schéma simplifié de la stack CephFS</span>
				<br />				
				<p style='text-align: justify;'>
					L'objectif à terme est de placer les données sur CephFS, le système étant en cours de refonte par les équipes de Ceph. En attendant, il nous a fallu trouver une solution transitoire performante et surtout résistante à la panne.
				</p>
				<br />
				<h2 class='dark'>La solution RBD + Ucarp</h2>
				<p style='text-align: justify;'>
					Pour assurer la redondance entre plusieurs points d'entrées potentiels, nous utilisons des IP virtuelles pour exporter nos partitions. La configuration <a href='http://fr.wikipedia.org/wiki/Ucarp'>CARP</a> permet de monter 
					le RBD uniquement sur le master courant et d'éviter ainsi les accès concurrents catastrophiques dans le cas d'un bloc RBD. Ainsi une configuration basique de type :
				</p>
				<pre><code>auto eth1
iface eth1 inet static
	address 1.1.1.2
	netmask 255.255.255.0
	
	ucarp-vid 1
	ucarp-vip 1.1.1.1
	ucarp-password secret
	ucarp-advskew 1
	ucarp-advbase 1
	ucarp-master yes
	ucarp-upscript /usr/local/bin/vip-up.sh
	ucarp-downscript /usr/local/bin/vip-down.sh
	
iface eth1:ucarp inet static
	address 1.1.1.1
	netmask 255.255.255.0</code></pre>
				<br />
				<p style='text-align: justify;'>
					Les scripts <i>/usr/local/bin/vip-up.sh</i> et <i>/usr/local/bin/vip-down.sh</i> doivent assurer les étapes :
					<ol>
						<li>Démarrer/Arrêter le NFS Kernel Serveur ou le GlusterFS Serveur</li>
						<li>Monter/Démonter la partition</li>
						<li>Associer/Retirer le bloc RBD du serveur</li>
					</ol>
				</p>
				<br />
				<h2 class='dark'>Sauvegardes et snapshots</h2>
				<p style='text-align: justify;'>
					La puissance de Ceph se manifeste également par les possibilités offertes dans un système de stockage orienté objets. Ainsi il comprend un processus intégré de snapshot et de duplication de données. 
					Un snapshot est une copie en lecture seule de l'état d'une partition à un instant T donné. Il est donc possible de retenir l'historique de l'état d'une image et de pouvoir revenir au point donné en quelques secondes.
					Ceph supporte également les snapshots de type COW (Copy-on-Write), ce qui permet ainsi de cloner des machines virtuelles ou des images sans pour autant en interrompre le fonctionnement.
				</p>
				<pre><code>rbd --pool {POOL} snap create --snap {SNAPSHOT_NAME} {PARTITION_NAME}
rbd --pool {POOL} snap ls {PARTITION_NAME}</pre></code>
				<br />
				<p style='text-align: justify;'>
					Exemple pour effectuer un rollback sur un snapshot :
				</p>
				<pre><code>rbd --pool {POOL} snap rollback --snap {SNAPSHOT_NAME} {PARTITION_NAME}</pre></code>
				<br />
				<img class='blogimage' src='/as/images/news/3/snapshot-ro.png' />
				<span class='legend'>Le snapshot en lecture seule</span>		
				<br />
				<img class='blogimage' src='/as/images/news/3/snapshot-rw.png' />
				<span class='legend'>Le snapshot en lecture écriture</span>		
				<br />
				<h2 class='dark'>Conclusion</h2>
				<p style='text-align: justify;'>
					Grâche aux performances des réseaux et du matériel, l'intérêt de ces systmes de fichiers distribués-répliqués pour faire face aux besoins en matière de stockage de données ne cesse de croître. Ceph offre une suite d'outils
					et de technologies certes complexes à implémenter dans un premier temps mais efficace et économique pour le remplacement de systèmes de stockage traditionnels. 
				</p>
				<p style='text-align: justify;'>
					Pour en savoir plus sur Ceph, n'hésitez pas à consulter la <a href='http://ceph.com/docs/master'>documentation</a> et l'excellent blog de <a href='http://www.sebastien-han.fr/blog'>Sébastien Han</a>.
				</p>
<!-- FIN ARTICLE -->
				<br />
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>