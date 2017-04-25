FROM nginx:latest

#ENV VERSION=0.19 \
ENV VERSION=0.20.2 \
    SRC=hugo_${VERSION}_Linux-64bit \
    EXTENSION=tar.gz \
    BINARY=hugo_${VERSION}_linux_amd64/hugo_${VERSION}_linux_amd64

RUN DEBIAN_FRONTEND=noninteractive apt-get purge -y nginx && \
  DEBIAN_FRONTEND=noninteractive apt-get update && \
  DEBIAN_FRONTEND=noninteractive apt-get -y dist-upgrade && \
  DEBIAN_FRONTEND=noninteractive apt-get install --no-install-recommends -y liblua5.1-json nginx-extras libcurl4-gnutls-dev build-essential \
  python-pygments python git python-pip curl wget && \
  DEBIAN_FRONTEND=noninteractive apt-get purge -y build-essential wget && \
  git clone --recursive https://github.com/MrRaph/blog.git /src

WORKDIR /src

RUN sed -i 's/https:\/\/techan.fr/http:\/\/blog.Macbouc.local/' /src/config.toml

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
    DEBIAN_FRONTEND=noninteractive apt-get purge -y python-pygments python git python-pip && \
    rm -rf /var/lib/apt/lists/* && \
    rm -rf /tmp/hugo* /src

ADD sites-enabled/www.techan.fr.conf /etc/nginx/sites-enabled/www.techan.fr.conf

HEALTHCHECK CMD curl --fail http://localhost/ || exit 1

EXPOSE 80 443 8080
CMD ["nginx", "-g", "daemon off;"]
