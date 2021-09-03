# DDNetPP-web
The website related to the teeworlds DDNet++ mod


## setup

### dependencies

    sudo apt install php apache2 php-sqlite3 composer
    composer install

### database

You can generate a database using github.com/DDNetPP/DDNetPP
to get the official database do

    adduser chiller
    su chiller
    mkdir -p ~/git && cd ~/git
    git clone git@github.com:ChillerDragon/TeeworldsData.git

### config

    cp env.example .env
