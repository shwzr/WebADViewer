<h1 align="center">WebADViewer 🗃</h1>

> 🗃 WebADViewer lets employees verify credentials and view colleagues' services via LDAP.


## What is LDAP Authentication? 🔐

LDAP (Lightweight Directory Access Protocol) is an open and cross-platform protocol used for directory services authentication. LDAP authentication allows users to log in using the same credentials they use on their corporate network, simplifying user management and enhancing security by centralizing authentication.

## Packages 📦

To set up a Debian12 Web Server with LDAP authentication, you will need :

- **`apache2`** - Package used to set up the web server.
- **`php`** - Package to run PHP scripts on the web server.
- **`libapache2-mod-php`** - Module to integrate PHP with Apache.

## Preparation 🛠

This example details setting up a web server on Debian 12 using Active Directory authentication via LDAP. The network includes a Windows Server 2022 with an IP address of **192.168.1.100** serving as the Active Directory server. The web server, running Apache2, is configured on a Debian machine at the IP address **192.168.1.10**.

<img src="https://raw.githubusercontent.com/shwzr/WebADViewer/main/assets/img/contexte.png" width="900" title="context">

### <u>💡 Installation of Packages on Web Server</u>

* Install the packages :
`
apt update && apt install git apache2 php libapache2-mod-php libapache2-mod-ldap-userdir ldap-utils -y
`


 <u>**⚙ Configuration**</u><u> </u>​<u>**of LDAP Authentication on Web Server**</u>

* Enable LDAP modules LDAP : 
`
a2enmod ldap && a2enmod authnz_ldap && systemctl restart apache2
`

* Restart to apply changes : 
`
systemctl restart apache2
`

 <u>**⚙ Configuration**</u><u> </u>​<u>**of LDAP Rules on Windows Server**</u>

* Create two new LDAP rules (ports 389 and 636) on PowerShell :

  `New-NetFirewallRule -DisplayName "LDAP Inbound" -Direction Inbound -Protocol TCP -LocalPort 389 -Action Allow`

  `New-NetFirewallRule -DisplayName "LDAPs Inbound" -Direction Inbound -Protocol TCP -LocalPort 636 -Action Allow`

* Use **LDP.exe** for a test connection by running **LDP.exe** from the **Start Menu**. In the **Connection menu**, click **Connect**. Enter the server address (Example: **192.168.1.100**), specify port **389** for **LDAP**, and click **OK** to test the secure connection.

<img src="https://raw.githubusercontent.com/shwzr/WebADViewer/main/assets/img/ldp.png" width="650" title="ldp">

 <u>**🌐 Website Deployment**</u>

* Clone the repository : `git clone https://github.com/shwzr/WebADViewer.git `

* Move the repository content to the web directory : `rm /var/www/html/index.html && mv WebADViewer/* /var/www/html/`

* Modify the config.php file to match your LDAP configuration : `nano /var/www/html/config.php`
```bash
<?php
// LDAP Configuration
$ldap_host = '192.168.1.100';      // IP address of the LDAP server
$ldap_port = '389';                // Port of the LDAP server
$ldap_domain = 'shyno.tech';       // LDAP domain
$dc_string = 'dc=shyno,dc=tech';   // DC string for the LDAP query
?>
```

Ensure that your LDAP server settings and IP addresses are correctly configured in the actual environment.


 <u>**📜 Configure the SSL Certificate**</u>

* Install OpenSSL : `apt install openssl`
* Create the SSL Certificate : 
  `openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/apache-selfsigned.key -out /etc/ssl/certs/apache-selfsigned.crt`

  During generation, OpenSSL will ask you to fill out some information, such as the country, state, organization, etc. For local use, these can be fictitious.
  
  1 - **Country Name (2 letter code)** : Specify ​**​`Ile-de-France​​`** as the state or province.<br>
  2 - **State or Province Name (full name)** : Indiquez **​`Ile-de-France`​** comme état ou province.<br>
  3 - **Locality Name (eg, city)** : Write **​`Paris​`** for the city.<br>
  4 - **Organization Name (eg, company)** : Leave this field **​`empty​`**.<br>
  5 - **Organizational Unit Name (eg, section)** : Leave this field **​`empty​`**.<br>
  6 - **Common Name (e.g. server FQDN or YOUR name)** : The full domain name, here it would be **​`www.shyno.tech​`**<br>
  7 - **Email Address**: Leave this field **​`empty​`**.<br>
 
     
* Create an SSL configuration snippet for Apache : `nano /etc/apache2/conf-available/ssl-params.conf`
  ```ssl-params.conf
  SSLCipherSuite HIGH:!aNULL:!MD5
  SSLProtocol All -SSLv2 -SSLv3
  SSLHonorCipherOrder On
  Header always set X-Frame-Options DENY
  Header always set X-Content-Type-Options nosniff
  SSLCompression off
  SSLUseStapling on
  SSLStaplingCache "shmcb:logs/stapling-cache(150000)"
  ```
  
* Enable the new configuration file : `a2enconf ssl-params && a2enmod headers`
* Edit the default site configuration file to include SSL : `nano /etc/apache2/sites-available/default-ssl.conf`
  ```default-ssl.conf
  SSLEngine on
  SSLCertificateFile      /etc/ssl/certs/apache-selfsigned.crt
  SSLCertificateKeyFile /etc/ssl/private/apache-selfsigned.key
  ```
  
* Enable the SSL Module and SSL Site : `a2enmod ssl && a2ensite default-ssl && systemctl restart apache2`


<img src="https://raw.githubusercontent.com/shwzr/WebADViewer/main/assets/img/WebADViewer.png" width="900" title="WebADViewer">

 ## 👤 Author

**Showzur**

* SRV Discord: [Shynonime](https://shynonime.glitch.me) 
* Twitter: [@Showzur](https://twitter.com/Showzur)
* Github: [@shwzr](https://github.com/shwzr)

## Show your support

Give a ⭐️ if this project helped you!

***

## 📝 License

Copyright © 2024 [Showzur](https://github.com/shwzr).<br />

***
