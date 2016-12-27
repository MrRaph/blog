FROM nginx:stable-alpine

ENV VERSION=0.18 \
    SRC=hugo_${VERSION}_Linux-64bit \
    EXTENSION=tar.gz \
    BINARY=hugo_${VERSION}_linux_amd64/hugo_${VERSION}_linux_amd64

RUN apk add --no-cache --update py-pygments python py-pip git

RUN git clone --recursive https://github.com/MrRaph/blog.git /src
WORKDIR /src

RUN sed -i 's/www.techan.fr/next.techan.fr/' /src/config.toml

ADD https://github.com/spf13/hugo/releases/download/v${VERSION}/hugo_${VERSION}_Linux-64bit.tar.gz /tmp/
RUN mkdir -p /tmp/hugo /var/www/blog && \
    tar xzf /tmp/hugo_${VERSION}_Linux-64bit.${EXTENSION} -C /tmp/hugo && \
    /tmp/hugo/hugo_${VERSION}_linux_amd64/hugo_${VERSION}_linux_amd64 -t hugo-future-imperfect-0.3 || exit 0

WORKDIR /var/www

RUN cp -rp /src/public/* /var/www/ && \
    rm /tmp/hugo_${VERSION}_Linux-64bit.${EXTENSION} && \
    rm -rf /src
#    rm -rf /tmp/hugo* /src

ADD sites-enabled/www.techan.fr.conf /etc/nginx/conf.d/www.techan.fr.conf

EXPOSE 80 443
CMD ["nginx", "-g", "daemon off;"]
