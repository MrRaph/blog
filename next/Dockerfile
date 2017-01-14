# FROM nginx:stable-alpine
FROM nginx:latest

ENV VERSION=0.18.1 \
    SRC=hugo_${VERSION}_Linux-64bit \
    EXTENSION=tar.gz \
    BINARY=hugo_${VERSION}_linux_amd64/hugo_${VERSION}_linux_amd64

# RUN apk add --no-cache --update py-pygments python py-pip git lua5.2-cjson
RUN DEBIAN_FRONTEND=noninteractive apt-get purge -y nginx && \
  DEBIAN_FRONTEND=noninteractive apt-get install -y liblua5.1-json nginx-extras \
  python-pygments python git python-pip && \
  rm -rf /var/lib/apt/lists/* && \
  git clone https://github.com/shoonoise/lua-nginx-statistics.git /lua-nginx-statistics && \
  mkdir -p /usr/share/nginx/ && cp /lua-nginx-statistics/*.lua /usr/share/nginx/ && \
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
    chown -R nginx:nginx /var/www
#    rm -rf /tmp/hugo* /src

ADD sites-enabled/www.techan.fr.conf /etc/nginx/conf.d/www.techan.fr.conf
ADD sites-enabled/stats.conf /etc/nginx/conf.d/stats.conf
ADD conf.d/stats.conf /etc/nginx/conf.d/stats.conf

EXPOSE 80 443
CMD ["nginx", "-g", "daemon off;"]
