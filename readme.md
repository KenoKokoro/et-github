# Github API

## Requirements
1. Unix OS (Not tested on Windows, but should be fine)
2. Available `80` port or any value that is set in the `.env.example` file as `NGINX_PORT` value
3. Docker engine `1.13.0+` version or above
4. Docker compose `1.21+` version or above
5. `make` command installed
6. `git` installed
7. Check the `DOCKER_HOST_UID` to be equal to your local user `echo $UID` inside `.env.example`
8. Check the `DOCKER_HOST_GID` to be equal to your local user `echo $GID` inside `.env.example`

## Installation
1. `git clone git@github.com:KenoKokoro/et-github`
2. Go to the `et-github` folder. Here in your `.env.example` file set you desired values. 
Make sure that the `API_KEY` value is set properly since it is required for executing requests on `/v1/*` endpoints.
3. Execute `make local-setup` to boot up the docker containers and execute the existing tests
4. Coverage of the unit tests can be found under `storage/framework/coverage` folder
5. That should be it
6. [![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/3c869c7416086eff3ce8)
7. [Documentation Link](https://documenter.getpostman.com/view/1567891/SVmpW1to?version=latest#034f3b95-b8ac-438f-9a3d-8e837ba80dd7)

## Useful stuff (maybe)
1. To boot up the docker containers use: `docker-compose -f docker-compose.yml -f dev.docker-compose.yml up -d --build`
2. `dev.docker-compose.yml` is used only to keep local cache of the composer files. 
It is not required for the application to boot successfully.
3. To run composer command `docker-compose exec --user=nginx composer`
4. To run artisan command `docker-compose exec --user=nginx php artisan`
5. To run unit tests `make v1-phpunit`
6. To run behat tests `make v1-behat`
7. `--user=nginx` and `DOCKER_HOST_GID` with `DOCKER_HOST_UID` are used to preserve the user permissions inside the docker container
and outside of it and avoid file permissions issue where the files gets owned by the container user and locks up for the host user
