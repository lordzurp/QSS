# ![](https://raw.githubusercontent.com/lordzurp/QSS/master/ressources/favicon.32.png) Quick Server Supervision



[![GitHub release](http://img.shields.io/github/release/lordzurp/QSS.svg?style=flat-square)][release]
[![MIT License](http://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)][license] 

[release]: https://github.com/lordzurp/QSS/releases
[license]: https://raw.githubusercontent.com/lordzurp/QSS/master/LICENSE

Monitoring de services web pour serveurs dédiés

![ScreenShot](https://raw.githubusercontent.com/lordzurp/QSS/master/demo.png)



####config
La config est stocké dans le fichier config.json

#####Servers
On trouve 4 paramètres :
- name : le nom affiché de la machine
- address : son adresse (nom de domaine ou IP)
- timeout : la limite de réponse du ping. utile pour les serveurs à l'étranger : un serveur canadien aura du mal à réondre en moins de 10ms
- services : les services à surveiller sur cette machine, tiré de la liste des services dispo

#####Services
Chaque service est à déclarer ici :
- name : le nom affiché du service
- port : le port à tester



### Historique
####v1.0 - 09/2015
#####Initial release
#####New :
#####Bugfix :
######Misc :

