# Statistische Auswertung von Terminen
WS 2021 - Web Technologien <br />
Dies ist ein wissenschaftliches Projekt und soll ein Modul zur produktiv eingesetzten Software ergänzen.

##### Anforderungen

- [Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/)
- [Docker-Compose](https://docs.docker.com/compose/install/)
- Free ports on your host system for
    - Web: `80`
    - Adminer: `8080`

##### Getting started

1. Clone this repository
1. Build and start the docker containers: `$ docker-compose up -d`
1. Bootstrap: `$ docker-compose exec php composer bootstrap-project`


##### Usages

- SSH into container: `$ docker-compose exec php sh`
- Manage DB with Adminer: `localhost:8080`
    - System: MySQL
    - Server: db
    - Username: root
    - Password: root
    - Database: db