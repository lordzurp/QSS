# ![](https://raw.githubusercontent.com/lordzurp/QSS/master/ressources/favicon.32.png) Quick Server Supervision

![](http://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)

Monitoring de services web pour serveurs dédiés




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


###License
#####The MIT License (MIT)

Copyright (c) 2015 lordzurp
http://www.zurp.me

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
