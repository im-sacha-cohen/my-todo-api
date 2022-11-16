# Todo & Co : Collaboration

## Comment collaborer sur ce projet ?
### Le projet Todo & Co a été entièrement remit à neuf.
- Le projet a subit une grosse montée en version.
- À la reprise du projet, des anomalies ont été corrigées.
- Des nouvelles fonctionnalités ont été ajoutées.
- Des tests automatisés ont été mit en place.
- Une documentation a été créée.
- Des outils de test de qualité de code ont rendu des rapports.

### En collaborant sur ce projet, vous devez veiller à suivre le processus de qualité mit en place.
- Coder selon les conventions énoncées dans la section ci-dessous.
- Écrire des tests automatisés pour chaque ajout de fonctionnalité.
- Éxecuter les tests afin de ne pas régressser.
- Régulièrement faire un audit de qualité de code via Codacy.


## Conventions de code
- Chaque fichier à sa responsabilité. Ex : le controller sert à recevoir des requêtes puis les transmet au service dédié. Le service s'occupe de faire les traitements nécéssaires...
- Chaque nom de fichier et de classe doit suivre la convention : PascalCase.
- Chaque nom de fonction doit suivre la convention : camelCase.
- Chaque fonction doit être typée : à la fois par sa portée, ses paramètres ainsi que son type de retour.