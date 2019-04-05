1) configure you bdd in .env (DATABASE_URL)
2) configure you smtp serveur in config/packages/swiftmailler.yaml
Exemple 
swiftmailer:

    transport: smtp
    
    auth_mode: login
    
    port: 587
    
    host: ssl0.ovh.net
    
    username: YOUUSERNAME
    
    password: YOUPASSWORD
    
    spool: { type: 'memory' }

3)open you console.

4)type : composer install

5) type : php bin/console doctrine:schema:update --force

6) type: php bin/console doctrine:fixtures:load

7) launch you app : php bin/console s:run

sensiolabs analyse (it's bugued im have critical error and this not show)

[![SymfonyInsight](https://insight.symfony.com/projects/ebdb652c-0ffb-4e01-9c53-e78a392c74dd/big.svg)](https://insight.symfony.com/projects/ebdb652c-0ffb-4e01-9c53-e78a392c74dd)