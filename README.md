# Docker-Download-ESA-Sentinel-Data

This docker image allows you to download satellite images from ESA's sentinels. When launched, it display  webpage on the port of your choice, which allows you to search and download sentinel products, based on type, area and date.

Docker container based on ubuntu 16.04, added full Anaconda2 to run ESA Sen2cor processing

Added Anaconda2 from docker anaconda : https://github.com/ContinuumIO/docker-images/tree/master/anaconda

Added sentinelsat from https://github.com/ibamacsr/sentinelsat to download data from sentinel data hub

Added Sen2cor processing from lvhengani : https://github.com/lvhengani/sen2cor_docker

Added Apache2 and PHP7 from https://github.com/tagplus5/docker-php/tree/master/7-apache

## Install of Docker :

You can find tutorials about installation and use of Docker here : https://docs.docker.com/

## Build the Docker image:
-download repository

-go in the repo and launch docker

`docker build -t $IMAGE_NAME .`

*ex : `docker build -t download-ESA-Sentinel-Data .`*

## using the docker container :

`docker run -d -p $port_on_host:$port_on container $IMAGE_NAME`

*ex : `docker run -d -p 8888:80 download-ESA-Sentinel-Data`*

## To link  repository on the host to a repository inside the container (with good permissions):

If you want to link a host repository to the container, the host repository needs to have the correct permissions. Use the command (on Linux ) :

`chown www-data:www-data  /path/to/host/repository`

Add to the previous line : `-v /path/to/host/repository:/path_in_container` using `/var/www/html/downloads` as /path_in_container

*ex :  `docker run -p 8888:80 -v /c/Users/doc:/var/www/html/downloads  download-ESA-Sentinel-Data`*

Using a host repository will act as a data storage for all the download you will launch from the webpage. If you don't use a host repository, all the data you will have download will be deleted if you erase the container.



# Webpage

The webpage is build with PHP, all the process are executed from the PHP files. The comments in the php files explain how the webpage works.

## Access the webpage :

In your browser, enter the IP address or name of the host sytem ( where the container is launched ) , and the number of the port you have chosen :

If you have use the command `docker run -d -p 8888:80 download-ESA-Sentinel-Data` on a host with IP address : 192.168.99.100 , in your browser enter `192.168.99.100:8888` to access the webpage.

![webpage_home](https://github.com/manusrn/img/blob/master/webpage_home_v2.png) 

You have to create an account to ESA's Data plateform : https://scihub.copernicus.eu/dhus/#/home .

You can draw the area you need images for here :http://geojson.io/ .

Once you will have press the `Submit` button, you will access this page :

![webpage_search](https://github.com/manusrn/img/blob/master/webpage_search_v2.png)

Once the download and processing of the images is done, a folder with your username and the date will have been created, with the products you have downloaded inside. There is 3 format available :

- Folder format : the products are availables inside a folder named "date_username" in folder format.

- Mutiple zip format : the products are availables inside a folder named "date_username" , with every product in a zipe file.

- Single zip format : the products are availables inside a zip file named "date_username" , with every product in a folder.



### Improvements :

- Sen2cor uses only one core of the host to process the products. In the L2A_GIPP.xml file, in /conf_files at line 6, you can change the number of simultaneous processes. Set this to "AUTO" could be worth a try to improve the speed of sen2cor processing.
- Another way could be to use GNU-parallel as adviced here : http://forum.step.esa.int/t/sencor-2-3-0-parallel-processing-on-the-new-format-14-2/4602/8 , and here is the link to GNU-Parallel page : https://www.gnu.org/software/parallel/
- Look at `ENTRYPOINT` possibilities in Dockerfile, maybe to add the choice of which tool is launched when starting the container ( Apache, Jupyter, access the container hierachy )
