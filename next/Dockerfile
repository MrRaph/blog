# FROM nginx:stable-alpine
FROM nginx:latest

ENV VERSION=0.18.1 \
    SRC=hugo_${VERSION}_Linux-64bit \
    EXTENSION=tar.gz \
    BINARY=hugo_${VERSION}_linux_amd64/hugo_${VERSION}_linux_amd64

# RUN apk add --no-cache --update py-pygments python py-pip git lua5.2-cjson
RUN DEBIAN_FRONTEND=noninteractive apt-get purge -y nginx && \
  DEBIAN_FRONTEND=noninteractive apt-get update && \
  DEBIAN_FRONTEND=noninteractive apt-get -y dist-upgrade && \
  DEBIAN_FRONTEND=noninteractive apt-get install --no-install-recommends -y liblua5.1-json nginx-extras libcurl4-gnutls-dev build-essential \
  python-pygments python git python-pip curl wget && \
  cd /tmp && wget https://collectd.org/files/collectd-5.7.1.tar.bz2 && tar -jxf collectd-5.7.1.tar.bz2 && cd collectd-5.7.1 && \
  ./configure && make all install && \
  wget -O /etc/init.d/collectd https://raw.githubusercontent.com/martin-magakian/collectd-script/master/collectd.init && \
  chmod 744 /etc/init.d/collectd && \
  DEBIAN_FRONTEND=noninteractive apt-get purge -y build-essential wget && \
#  git clone https://github.com/shoonoise/lua-nginx-statistics.git /lua-nginx-statistics && \
#  mkdir -p /usr/share/nginx/ && cp /lua-nginx-statistics/*.lua /usr/share/nginx/ && \
#  cp -rp /lua-nginx-statistics/static /usr/share/nginx/ && \
#  rm -rf /lua-nginx-statistics && \
  git clone --recursive https://github.com/MrRaph/blog.git /src

WORKDIR /src

RUN git checkout origin/next && \
    sed -i 's/techan.fr/next.techan.fr/' /src/config.toml

ADD https://github.com/spf13/hugo/releases/download/v${VERSION}/hugo_${VERSION}_Linux-64bit.tar.gz /tmp/
RUN mkdir -p /tmp/hugo /var/www/blog && \
    tar xzf /tmp/hugo_${VERSION}_Linux-64bit.${EXTENSION} -C /tmp/hugo && \
    /tmp/hugo/hugo_${VERSION}_linux_amd64/hugo_${VERSION}_linux_amd64 -t hugo-future-imperfect-0.3 || exit 0

WORKDIR /var/www

RUN cp -rp /src/public/* /var/www/ && \
    rm /tmp/hugo_${VERSION}_Linux-64bit.${EXTENSION} && \
    rm -rf /src && \
    chown -R nginx:nginx /var/www && \
    rm /etc/nginx/sites-enabled/default && \
    DEBIAN_FRONTEND=noninteractive apt-get purge -y python-pygments python git python-pip curl && \
    rm -rf /var/lib/apt/lists/* && \
    rm /opt/collectd/etc/collectd.conf && \
    rm -rf /tmp/hugo* /src

ADD sites-enabled/www.techan.fr.conf /etc/nginx/sites-enabled/www.techan.fr.conf
ADD sites-enabled/stats.conf /etc/nginx/sites-enabled/stats.conf
ADD collectd/collectd.conf /opt/collectd/etc/collectd.conf
#ADD conf.d/stats.conf /etc/nginx/conf.d/stats.conf


HEALTHCHECK CMD curl --fail http://localhost/ || exit 1

EXPOSE 80 443 8080
#CMD ["nginx", "-g", "daemon off;"]
CMD sh -c '/etc/init.d/collectd start ; nginx -g "daemon off;"'
