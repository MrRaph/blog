FROM nginx:stable-alpine

ENV VERSION=0.18 \
    SRC=hugo_${VERSION}_Linux-64bit \
    EXTENSION=tar.gz \
    BINARY=hugo_${VERSION}_linux_amd64/hugo_${VERSION}_linux_amd64

RUN apk add --no-cache --update py-pygments python py-pip git

RUN git clone --recursive https://github.com/MrRaph/blog.git /src
WORKDIR /src
RUN git submodule update --init --recursive

ADD https://github.com/spf13/hugo/releases/download/v${VERSION}/hugo_${VERSION}_Linux-64bit.tar.gz /tmp/
RUN mkdir -p /tmp/hugo /var/www/blog && \
    tar xzf /tmp/hugo_${VERSION}_Linux-64bit.${EXTENSION} -C /tmp/hugo && \
    /tmp/hugo/hugo_${VERSION}_linux_amd64/hugo_${VERSION}_linux_amd64 && \
    cp -rp /src/public/* /var/www/blog/ && \
    rm /tmp/hugo_${VERSION}_Linux-64bit.${EXTENSION}
#    rm -rf /tmp/hugo* /src

ADD sites-enabled/www.techan.fr.conf /etc/nginx/conf.d/www.techan.fr.conf

EXPOSE 80 443
CMD ["nginx", "-g", "daemon off;"]
