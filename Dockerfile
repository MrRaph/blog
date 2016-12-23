FROM nginx:stable-alpine

RUN apk add --no-cache --update py-pygments python py-pip git


ADD /home/travis/gopath/src/github.com/MrRaph/blog/public /var/www/blog

WORKDIR /var/www/blog

ADD sites-enabled/www.techan.fr.conf /etc/nginx/conf.d/www.techan.fr.conf

EXPOSE 80 443
CMD ["nginx", "-g", "daemon off;"]
