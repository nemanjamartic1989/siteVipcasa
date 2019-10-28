<?php if(basename(__file__) == 'config.php') exit; ?>
<?xml version="1.0" encoding="utf-8"?>
<xml>
    <Addresses>
        <!-- put your email here -->
        <address>office@vipcasa.rs</address>
        <address on="subject" value="VIPCASA INVEST - Web Kontakt"></address>
        <address on="subject" value="VIPCASA INVEST - Web Kontakt"></address>
    </Addresses>
    <Config>
        <smtp>
        <!-- smtp gmail config -->
            <use>no</use>
            <auth>yes</auth>
            <secure>tls</secure>
            <host>smtp.gmail.com</host>
            <username>email</username>
            <password>lozinka</password>
            <port>587</port>
        </smtp>
        <charset>iso-8859-1</charset>
    </Config>
</xml>
