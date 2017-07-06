# Docker-Download-ESA-Sentinel-Data

This docker image allows you to download satellite images from ESA's sentinels. When launced, it display  webpage on the port of your choice, that allows you to search and download sentinel products, based on type, area and date.

Docker container based on ubuntu 16.04, added full Anaconda2 to run ESA Sen2cor processing

Added Anaconda2 from docker anaconda : https://github.com/ContinuumIO/docker-images/tree/master/anaconda

Added sentinelsat from https://github.com/ibamacsr/sentinelsat to download data from sentinel data hub

Added Sen2cor processing from lvhengani : https://github.com/lvhengani/sen2cor_docker

Added Apache2 and PHP7 from https://github.com/tagplus5/docker-php/tree/master/7-apache

## Build the Docker image:
-download repository

-go in the repo and launch docker

`$docker build -t $IMAGE_NAME .`

## using the docker container :

`$docker run -d -p $port_on_host:$port_on container $IMAGE_NAME`

*ex : docker run -d -p 8888:80 ubuntu-w-Anaconda-sentinelsat-and-sen2cor*

## To link  repository on the host to a repository inside the container (with good permissions):

Add to the previous line : `-v /path_on_host:/path_in_container` 

*ex :  docker run -p 8888:80 -v /c/Users/doc:/media/products  ubuntu-w-Anaconda-sentinelsat-and-sen2cor*

If one of the repostories doesn't exist, it will be created. Otherwise, everything inside host repository will be accessible in container repository, and vice-versa.

If you want to link a host repository to the container, the host repository needs to have the correct permissions. Use the command (on Linux ) :

`chown www-data:www-data  /path/to/host/repository`

# Webpage

The webpage is build with PHP, all the process are execute from the PHP files. The comments in the php files explain how the webpage works.

## Access the webpage :

In your browser, enter the IP address or name of the host sytem ( where the container is launched ) , and the number of the port you have chosen :

If you have use the command `docker run -d -p 8888:80 ubuntu-w-Anaconda-sentinelsat-and-sen2cor` on a host with IP address : 192.168.99.100 , in your browser enter `192.168.99.100:8888` to access the webpage.

![webpage_home](https://github.com/manusrn/img/blob/master/webpage_home.png)

Once you will have press the `Submit` button, you will access this page :

![webpage_search](https://github.com/manusrn/img/blob/master/webpage_search.png)

