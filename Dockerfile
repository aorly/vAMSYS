FROM ubuntu:14.10
MAINTAINER Paul Williams <paul@skenmy.com>

# Update Ubuntu
RUN apt-get update
RUN apt-get -y upgrade

# Keep upstart from complaining
RUN dpkg-divert --local --rename --add /sbin/initctl
RUN ln -sf /bin/true /sbin/initctl

# Apt Repositories
RUN apt-get install -y software-properties-common python-software-properties python-setuptools curl unzip supervisor
RUN apt-get install -y wget nano
RUN apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0x5a16e7281be7a449
RUN add-apt-repository -y 'deb http://dl.hhvm.com/ubuntu utopic main'
RUN add-apt-repository -y ppa:nginx/stable
RUN apt-get update

# Install nginx & hhvm
RUN apt-get install -y nginx && chown -R www-data:www-data /var/lib/nginx
RUN echo "daemon off;" >> /etc/nginx/nginx.conf
RUN apt-get install -y hhvm
RUN ["/usr/share/hhvm/install_fastcgi.sh"]

# Add source code
ADD . /var/www

# Add config files
ADD ./docker/nginx.conf /etc/nginx/sites-enabled/default
ADD ./docker/supervisord.conf /etc/supervisord.conf

# Add init script
ADD ./docker/start.sh /start.sh
RUN chmod 755 /start.sh

# Expose Ports
EXPOSE 80

# Away we go!
CMD ["/bin/bash", "/start.sh"]
