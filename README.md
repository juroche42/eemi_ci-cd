# Todolist

## Liens utiles

- [Installation locale](https://github.com/cbrichau/todolist-symfony6/wiki/Installation-locale)
- [Wiki](https://github.com/cbrichau/todolist-symfony6/wiki)
- Exposition de l'API: http://localhost:8080/api/docs (login = email@email.com ; mdp = password)
- Exposition de la BDD: http://localhost:8081/

## Cahier des charges

- [x] **Création de 3 entités : Todolist, Task et Tag.**
- [x] **Création de 6 endpoints pour :**
   - [x] Lire une Todolist avec ses Tasks et leurs Tags.
   - [x] Créer une Todolist (sans ses associations car celles-ci seront gérées à la création d'une Task).
   - [x] Créer une Task et ses Tags.
   - [x] Modifier une Task et ses Tags.
   - [x] Lire toutes les Tasks associées à un Tag donné (ou plusieurs).
   - [x] Lire toutes les Tasks expirées.
- [x] **Protection de l'API avec l'authentification HTTP Basic.**
- [x] **Garantie de la qualité du code et d'une maintenance aisée :**
   - [x] Utilisation de docker-compose pour disposer d'un environnement local bien défini (containers = NGINX, PHP, MySQL, phpMyAdmin).
   - [x] Utilisation d'un framework ([Symfony](https://symfony.com/doc/6.0/index.html)) et d'un bundle REST API ([API Platform](https://api-platform.com/)) pour bénéficier d'une base robuste, réduire le temps de développement, et simplifier le travail collaboratif.
   - [x] Utilisation des dernières versions stables des principaux composants (PHP 8, MySQL 8, Symfony 6, API Platform 2.7) pour bénéficier des dernières optimisations.
   - [x] Implémentation d'une batterie de tests (Unit & Application) avec [PHPUnit](https://symfony.com/doc/current/testing.html) (au moins 2 tests -1 valide et 1 invalide- par entité et par endpoint).
   - [x] Implémentation des DataFixtures pour auto-générer les données de test (avec [FakerPHP](https://fakerphp.github.io/) et une Command custom pour que la régénération des données reparte toujours de l'ID n°1).
   - [x] Création d'un script permettant d'effectuer la "Static Analysis" du code (avec [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) et [PHPStan](https://github.com/phpstan/phpstan), configurés pour le standard [PSR-12](https://www.php-fig.org/psr/psr-12/) et le [style Allman](https://fr.wikipedia.org/wiki/Style_d%27indentation#Style_Allman)).
   - [x] Rédaction d'un [Wiki](https://github.com/cbrichau/todolist-symfony6/wiki) pour une prise en main plus aisée.