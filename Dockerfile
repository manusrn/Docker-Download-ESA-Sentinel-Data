#Modified Ubuntu docker image, adding some dependencies

#Starting image
FROM ubuntu

#Install of Anaconda2-4.2.0 (from docker anaconda : https://github.com/ContinuumIO/docker-images/tree/master/anaconda)

RUN apt-get update --fix-missing && apt-get install -y wget bzip2 ca-certificates \
    libglib2.0-0 libxext6 libsm6 libxrender1 \
    git mercurial subversion

RUN echo 'export PATH=/opt/conda/bin:$PATH' > /etc/profile.d/conda.sh && \
    wget --quiet https://repo.continuum.io/archive/Anaconda2-4.2.0-Linux-x86_64.sh -O ~/anaconda.sh && \
    /bin/bash ~/anaconda.sh -b -p /opt/conda && \
    rm ~/anaconda.sh

RUN apt-get install -y curl grep sed dpkg && \
    TINI_VERSION=`curl https://github.com/krallin/tini/releases/latest | grep -o "/v.*\"" | sed 's:^..\(.*\).$:\1:'` && \
    curl -L "https://github.com/krallin/tini/releases/download/v${TINI_VERSION}/tini_${TINI_VERSION}.deb" > tini.deb && \
    dpkg -i tini.deb && \
    rm tini.deb && \
    apt-get clean

ENV PATH /opt/conda/bin:$PATH

RUN conda update conda -y

RUN apt-get install -y zip

#Sentinelsat  install (https://github.com/ibamacsr/sentinelsat)
RUN pip install sentinelsat

#Sen2cor install (from lvhengani : https://github.com/lvhengani/sen2cor_docker)
ENV SEN2COR_VERSION='2.3.1'
RUN wget http://step.esa.int/thirdparties/sen2cor/${SEN2COR_VERSION}/sen2cor-${SEN2COR_VERSION}.tar.gz && \
    tar -xvzf sen2cor-${SEN2COR_VERSION}.tar.gz && \
    cd sen2cor-${SEN2COR_VERSION} && \
    /bin/echo -e "y\ny\ny\n" | python setup.py install

RUN	rm sen2cor-${SEN2COR_VERSION}.tar.gz && rm -r /sen2cor-${SEN2COR_VERSION}

#Path environment variables for sen2cor
ENV SEN2COR_HOME=/root/sen2cor
ENV SEN2COR_BIN=/opt/conda/lib/python2.7/site-packages/sen2cor-${SEN2COR_VERSION}-py2.7.egg/sen2cor
ENV GDAL_DATA=/opt/conda/lib/python2.7/site-packages/sen2cor-${SEN2COR_VERSION}-py2.7.egg/sen2cor/cfg/gdal_data

RUN DEBIAN_FRONTEND=noninteractive && \
    apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y --no-install-recommends iproute2 apache2 php7.0 libapache2-mod-php7.0 \
        php7.0-mysql php7.0-sqlite php7.0-bcmath php7.0-curl ca-certificates && \
    apt-get autoremove -y && \
    rm -rf /var/lib/apt/lists/* && \
    echo "ServerName $(ip route get 8.8.8.8 | awk '{print $NF; exit}')" >> /etc/apache2/apache2.conf && \
    a2enmod php7.0 && \
    a2enmod rewrite && \
    sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.0/apache2/php.ini

RUN ln -sf /dev/stdout /var/log/apache2/access.log \
	&& ln -sf /dev/stderr /var/log/apache2/error.log

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

CMD /usr/sbin/apache2ctl -D FOREGROUND
