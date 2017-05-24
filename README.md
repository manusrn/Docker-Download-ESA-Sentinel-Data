# Docker-Ubuntu-w-Anaconda-sentinelsat-and-sen2cor
Docker unbuntu-based able to run sentinelsat and sen2cor

DOcker container based on ubuntu, added full Anaconda2 to run ESA Sen2cor processing
Added Anaconda2 from docker anaconda : https://github.com/ContinuumIO/docker-images/tree/master/anaconda
Added sentinelsat from https://github.com/ibamacsr/sentinelsat to download data from sentinel data hub
Added Sen2cor processing from lvhengani : https://github.com/lvhengani/sen2cor_docker

#Build the Docker image:
-download repository
-go in the repo and launch docker

$docker build -t $IMAGE_NAME .

#using the docker container :

$docker run -t -i $IMAGE_NAME /bin/bash

geojson file in /media to test sentinelsat
