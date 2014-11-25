FROM darh/php-essentials

MAINTAINER Fredrik Wallgren <fredrik.wallgren@gmail.com>

RUN apt-get install -y wget

# Install wsdl2phpgenerator
RUN wget https://github.com/wsdl2phpgenerator/wsdl2phpgenerator/releases/download/2.5.5/wsdl2phpgenerator-2.5.5.phar

RUN echo '#!/usr/bin/env bash\n php wsdl2phpgenerator-2.5.5.phar "$@"' > wsdl2phpgenerator
RUN chmod +x wsdl2phpgenerator

ENTRYPOINT ["./wsdl2phpgenerator"]
