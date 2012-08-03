#!/usr/bin

mysql -uroot -pqwe123 -v -e 'DROP SCHEMA IF EXISTS uartest; CREATE SCHEMA uartest'

rm -rf ../var/cache/ ../var/session/ ../var/locks/ ../var/report ../app/etc/local.xml

export XDEBUG_CONFIG="idekey=netbeans-xdebug"

chmod 0777 -R ../var ../media ../app/etc

php -f ../install.php -- --license_agreement_accepted 'yes' --locale 'en_US' --timezone 'America/Los_Angeles' --default_currency 'USD' --db_host 'localhost' --db_name 'uartest' --db_user 'root' --db_pass 'qwe123' --url 'http://uartest.lc/' --use_rewrites 'yes' --use_secure 'no' --secure_base_url '' --use_secure_admin 'no' --admin_firstname 'Uartest' --admin_lastname 'Magento' --admin_email 'admin@uartest.com' --admin_username 'admin' --admin_password 'qwe123qwe'

mysql -uroot -pqwe123 -v -e 'USE buy4give; UPDATE core_cache_option SET value=0; SELECT * FROM core_cache_option'

php -f ../shell/indexer.php reindexall

rm -rf ../var/cache/ ../var/session/ ../var/locks/ ../var/report/

echo 'http://uartest.lc/'
echo 'http://uartest.lc/admin'
