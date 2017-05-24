#Modified Ubuntu docker image, adding some dependencies

#Starting image
FROM ubuntu

#Install of Anaconda2-4.3.1 (from docker anaconda)

RUN apt-get update --fix-missing && apt-get install -y wget bzip2 ca-certificates \
    libglib2.0-0 libxext6 libsm6 libxrender1 \
    git mercurial subversion

RUN echo 'export PATH=/opt/conda/bin:$PATH' > /etc/profile.d/conda.sh && \
    wget --quiet https://repo.continuum.io/archive/Anaconda2-4.3.1-Linux-x86_64.sh -O ~/anaconda.sh && \
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

#Sentinelsat  install
RUN pip install sentinelsat

#Sen2cor install
ENV SEN2COR_VERSION='2.3.1'
RUN wget http://step.esa.int/thirdparties/sen2cor/${SEN2COR_VERSION}/sen2cor-${SEN2COR_VERSION}.tar.gz && \
    tar -xvzf sen2cor-${SEN2COR_VERSION}.tar.gz && \
    cd sen2cor-${SEN2COR_VERSION} && \
    /bin/echo -e "y\ny\ny\n" | python setup.py install
	
RUN	rm sen2cor-2.3.1.tar.gz && rm -r /sen2cor-2.3.1
	
ADD Aarhus.geojson /media/



