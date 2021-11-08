---
layout: installation
title: "Eigenständige Installation"
---
# eigenständige Installation (für erfahrene User)
# Inhalt

* [Betriebssystem RASPBIAN LITE](#betriebssystem)
* [WiFi-Verbindung](#wifi-verbindung)
* [Softwarepakete](#softwarepakete)
    * [lighttpd](#lighttpd)
    * [PHP 7](#php-7)
    * [pip](#pip)
    * [git](#git)
    * [sqlite3](#sqlite3)
    * [Sht-Sensor](#sht-sensoren)
    * [DHT-Sensor](#dht-sensoren)
    * [Wiring Pi](#wiringpi)
    * [ZIP](#zip)
    * [webcam](#webcam)
    * [fswebcam](#fswebcam)
* [Programm Reifeschranksteuerung](#programm-reifeschranksteuerung)


------------------------------------------------------------------------------------------------------------


Diese Anleitung basiert auf Windows. Für andere Betriebssysteme muss evtl. eine andere Vorgehensweise gewählt werden (z.B. beschreiben der SD-Karte.

# Betriebssystem 

Das Pi-Ager System ist grundsätzlich auf der Basis des Betriebsystems Pi OS Lite und des Rasspberry Zero W  aufgebaut.

Für Pi zero: [Pi OS Lite](https://www.raspberrypi.org/software/operating-systems/) (auch für Pi 3/4 Versionen nutzbar)

Für Pi 4/3 kann man auch die Desktop Version nutzen: [Pi OS with desktop and recommended software](https://www.raspberrypi.org/software/operating-systems/)

-----------------------------------------

Dieses entpacken wir und müssen es auf die SD-Karte schreiben.

Dafür laden wir uns das Programm [Win 32 Disk Imager von Sourceforge](http://sourceforge.net/projects/win32diskimager/) herunter entpacken und installieren dieses. (auf einem Mac muss z.B. ein anderes Programm "Etcher" anstelle von win 32 Disk Imager)

Um später auf die Konsole des Raspberry Pi's zu gelangen benötigen wir noch ein weiteres Programm z.B. Putty. Dieses können wir hier herunterladen: [putty](https://putty.de.softonic.com/) (Im Falle von Mac brauchen wir die Konsole)

Auch dieses entpacken wir nach dem Download.

Jetzt legen wir mind. 8GB SD Karte in einen Kartenleser ein und warten bis Windows diese erkannt hat.

Danach starten wir den »Win32DiskImager.exe«, wählen das Image [_Image File_] und den Laufwerksbuchstaben [_Device_] der Speicherkarte aus

![Win32DiskManager GUI](https://a.fsdn.com/con/app/proj/win32diskimager/screenshots/Win32DiskImager-1.0.png/1)

und starten den Schreibvorgang mit einem Klick auf [_Write_] --> ACHTUNG nicht das falsche Laufwerk!

Wenn der Vorgang abgeschlossen ist und wir über Tastatur, Monitor und/oder USB-Ethernet Adapter verfügen, können wir die Speicherkarte in Windows auswerfen.


Für den Fall, dass wir nicht über Tastatur, Monitor und/oder USB-Ethernet Adapter verfügen oder wir direkt über putty zugreifen wollen, sind zwei Dateien im root Ordner auf der SD-Karte zu erstellen:

Eine leere Datei mit dem Namen ssh ohne jegliche Dateiendung und

eine Datei mit dem Namen wpa_supplicant.conf mit dem Inhalt (ESSID und die PASSPHRASE sind durch die Zuangsdaten für unser WLAN zu ersetzen):

{% highlight plaintext linenos %}
# Datei wpa_supplicant.conf in der Boot-Partition (Raspbian Stretch)
country=DE 
ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev 
update_config=1 
network={
     ssid="WLAN SSID"
     psk="WLAN PASSWORT"
}
{% endhighlight %}

Sofern dies geschehen ist können wir auch die Speicherkarte in Windows auswerfen.

Die Speicherkarte stecken wir in den Raspberry PI.

Sofern gewollt und verfügbar, schließen wir jetzt eine USB Tastatur, einen HDMI Monitor (Fernseher) und ein mind. 1A starkes Micro USB Netzteil an. Sofern der Raspberry PI einen Ethernetanschluss hat, schließen wir zudem ein Netzwerk-Kabel an. 

Danach wird das USB Netzteil an den Strom angeschlossen.

Der Raspberry Pi startet nun und auf dem Monitor sollte der Boot-Vorgang sichtbar sein.

Sofern die beiden Dateien im Root Verzeichnis angelegt wurden, können wir über Putty zugreifen. Siehe dazu in der Anleitung später.

Einloggen mit (Achtung! Tastatur noch falsch konfiguriert [z=y]):

{% highlight plaintext %}
Benutzername: pi
Passwort: raspberry
{% endhighlight %}

Danach führen wir den Assistenten aus

{% highlight shell linenos %}
sudo raspi-config
{% endhighlight %}

(Achtung! Tastatur noch falsch konfiguriert [-=ß])

und richten folgende Einstellungen ein (die einzelnen Punkt können ggf. unter anderen Nummern stehen):

{% highlight plaintext %}
2 Network Options (bei raspberry pi zero)
    N2 Wi-fi
8 Update (sofern wir keinen Ethernetanschluss und kein WLAN zur Verfügung haben, fällt dieser Punkt weg bzw. kann zu einem späteren Zeitpunkt nachgeholt werden)
7 Advanced Options
    A1 Expand Filesystem
    A3 Memory Split auf »8« damit mehr RAM für die Ausführung der Dienste zur Verfügung steht
1 Change User Password for User pi
2 Hostname ändern auf z.B. »rpi-Pi-Ager«
4 Internationalisation Options
    I1 Standard Locale »de_DE.UTF-8 UTF-8« hinzufügen und als Standard auswählen
    I2 Als Zeitzone »Europe / Berlin« auswählen
    I3 Als Tastatur "Generic 105-key (Intel) PC" bestätigen und als Sprache "other" / "German" auswählen, alle anderen Optionen auf Standardwerten belassen   
    I4 DE als WiFi auswählen 
5 Interface Options
    P2 SSH »enable«
    P6 Serial »disable« (Also 2mal auf NEIN klicken!!)
Finish
{% endhighlight %}

Danach sollten wir gefragt werden, ob wir neu starten wollen. Dies beantworten wir mit Ja.

Sollte die Frage nicht gestellt werden müssen wir den Raspberry manuell starten.

{% highlight shell linenos %}
sudo sync
sudo reboot
{% endhighlight %}


hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh

Sofern kein Ethernetanschluss gegeben ist, aber ein WLAN-Stick zur Verfügung steht sollte jetzt Punkt [WiFi-Verbindung](#wifi-verbindung) vorgezogen werden.

Ab jetzt ist es möglich auch mittels PC und Zusatzprogramm wie z.B. [Putty](http://www.putty.org/) auf den Raspberry PI zuzugreifen. Dafür müssen wir in unserem Router nachsehen, welche IP vergeben wurde. Mittels dieser können wir uns dann per Putty verbinden. Der Port ist 22

Sobald wir uns wieder eingeloggt haben, machen wir ein Update (Sofern kein LAN-Kabel angeschlossen ist, oder kann (Bsp. Rapberry PI Zero zuerst die Anleitung [WiFi-Verbindung](#wifi-verbindung) weiter unten befolgen!)

{% highlight shell linenos %}
sudo apt-get update && sudo apt-get upgrade -y && sudo apt-get dist-upgrade
{% endhighlight %}

Jetzt aktivieren wir den "root" User, indem wir für den Benutzer ein Passwort vergeben:

{% highlight shell linenos %}
sudo passwd
{% endhighlight %}

Und falls wir uns mittels SSH als root einloggen wollen, müssen wir die config noch anpassen:

{% highlight shell linenos %}
sudo nano /etc/ssh/sshd_config
{% endhighlight %}

Hier suchen wir nach folgender Zeile:

{% highlight plaintext linenos %}
#Authentication:
#LoginGraceTime 2m
#PermitRootLogin prohibit-password
#StrictModes yes
#MaxAuthTries 6
#MaxSessions 10
{% endhighlight %}

und ändert diese wie folgt ab

{% highlight plaintext linenos %}
#Authentication:
LoginGraceTime 2m
PermitRootLogin yes
StrictModes yes
MaxAuthTries 6
MaxSessions 10
{% endhighlight %}

Jetzt Speichern wir mit "_STRG+o_", "_RETURN_" und schließen mit "_STRG+x_"

Einmal noch neu starten

{% highlight shell linenos %}
sudo sync
sudo reboot
{% endhighlight %}

[nach oben](#inhalt)

# WiFi-Verbindung

(sofern nicht schon über raspi-config eingerichtet)

Den USB-WIFI-Stick nur anstecken, wenn der PI ausgeschaltet ist oder wir einen aktiven USB HUB verwenden --> sonst startet der Raspberry PI durch den Spannungseinbruch unschön von selbst...

Wenn der USB-WIFI-Stick angesteckt und der PI hochgefahren ist oder es sich um einen Raspberry PI Zero W handelt, geben wir folgendes ein um zu sehen, ob er als USB-Device  erkannt wurde:

{% highlight shell linenos %}
lsusb
{% endhighlight %}

Es sollte dann in etwa dieses angezeigt werden:

{% highlight plaintext linenos %}
Bus 001 Device 002: ID 0424:9512 Standard Microsystems Corp.
Bus 001 Device 001: ID 1d6b:0002 Linux Foundation 2.0 root hub
Bus 001 Device 003: ID 0424:ec00 Standard Microsystems Corp.
Bus 001 Device 004: ID 046a:0023 Cherry GmbH CyMotion Master Linux Keyboard
Bus 001 Device 005: ID 0bda:8176 Realtek Semiconductor Corp. RTL8188CUS 802.11n WLAN Adapter (o.ä.)
{% endhighlight %}

Danach testen wir ob der Stick auch als USB-WIFI-Stick erkannt wurde:

{% highlight shell linenos %}
iwconfig wlan0
{% endhighlight %}

Es sollte in etwa so aussehen:

{% highlight plaintext linenos %}
wlan0     unassociated  Nickname:"<WIFI@REALTEK>"
          Mode:Managed  Frequency=2.412 GHz  Access Point: Not-Associated
          Sensitivity:0/0
          Retry:off   RTS thr:off   Fragment thr:off
          Power Management:on
          Link Quality:0  Signal level:0  Noise level:0
          Rx invalid nwid:0  Rx invalid crypt:0  Rx invalid frag:0
          Tx excessive retries:0  Invalid misc:0   Missed beacon:0
{% endhighlight %}
          
Eine Anmerkung zum Power Management: Sofern dies auf on steht, sollte dies auf off gesetzt werden und danach kontrolliert werden:

{% highlight shell linenos %}
sudo iw wlan0 set power_save off
iw wlan0 get power_save
{% endhighlight %}

Mit folgendem Befehl können wir die verfügbaren Netzwerke auflisten:

{% highlight shell linenos %}
iwlist wlan0 scanning
{% endhighlight %}

Zum Schreiben des WLAN Keys sind höhere Rechte notwendig (root)

{% highlight shell linenos %}
sudo su -
{% endhighlight %}

Nun geben wir folgendes ein und passen die ESSID und die PASSPHRASE für unser WLAN an. Damit auch Leerzeichen in der ESSID oder Passwort erkannt werden, müssen diese mit " maskiert werden. ( Das Passwort und die ESSID muss in Gänsefüßchen gesetzt werden bsp. "MEINE ESSID MIT LEERZEICHEN" "MEINE PASSPHRASE MIT LEERZEICHEN")

{% highlight shell linenos %}
wpa_passphrase "ESSID" "PASSPHRASE" >> /etc/wpa_supplicant/wpa_supplicant.conf
{% endhighlight %}

mit [_STRG_] + [_D_] kehren wir wieder zum Benutzer PI zurück. Nun können wir uns ansehen, ob das WLan auch eingetragen wurde :

{% highlight shell linenos %}
sudo nano /etc/wpa_supplicant/wpa_supplicant.conf
{% endhighlight %}

Ergebnis in etwa so:

{% highlight plaintext linenos %}
ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev
update_config=1
network={
        ssid="DEIN_WLAN_NAME"
        #psk="BlaBla-Echter Key"
        psk=lksdfj09o4pokpofdgkpß0jppkspdfkpsß09i4popok
}
{% endhighlight %}

Sofern in der Datei Konfigurationen stehen, die sicher nicht benötigt werden, können wir diese herauslöschen und mittels "_STRG+o_", "_RETURN_" und schließen mit "_STRG+x_"

Nun aktivieren wir die WLAN-Konfiguration und sehen, ob es geklappt hat:

{% highlight shell linenos %}
sudo ifdown wlan0
sudo ifup wlan0
{% endhighlight %}

Evtl. kann auch ein reboot helfen:

{% highlight shell linenos %}
sudo reboot
{% endhighlight %}

Eingabe

{% highlight shell linenos %}
iwconfig wlan0
{% endhighlight %}

Ergebnis in etwa:

{% highlight shell linenos %}
wlan0     IEEE 802.11bgn  ESSID:"PK-NEW"  Nickname:"<WIFI@REALTEK>"
          Mode:Managed  Frequency:2.412 GHz  Access Point: DC:9F:DB:FD:E7:A0
          Bit Rate:150 Mb/s   Sensitivity:0/0
          Retry:off   RTS thr:off   Fragment thr:off
          Power Management: on
          Link Quality=83/100  Signal level=50/100  Noise level=0/100
          Rx invalid nwid:0  Rx invalid crypt:0  Rx invalid frag:0
          Tx excessive retries:0  Invalid misc:0   Missed beacon:0
{% endhighlight %}
          
Eingabe:

{% highlight shell linenos %}
ifconfig wlan0
{% endhighlight %}

Ergebnis in etwa:

{% highlight plaintext linenos %}
wlan0     Link encap:Ethernet  Hardware Adresse 64:70:02:23:ef:11
          inet Adresse:192.168.0.52  Bcast:192.168.200.255  Maske:255.255.255.0
          UP BROADCAST RUNNING MULTICAST  MTU:1500  Metrik:1
          RX packets:10 errors:0 dropped:17 overruns:0 frame:0
          TX packets:4 errors:0 dropped:0 overruns:0 carrier:0
          Kollisionen:0 SendewarteschlangenlÃ¤nge:1000
          RX bytes:2001 (1.9 KiB)  TX bytes:1036 (1.0 KiB)
{% endhighlight %}

Wenn wir eine IP aus eurem DHCP Bereich seht, haben wir es geschafft und können uns ab sofort auch über WLAN verbinden.

[nach oben](#inhalt)

# Softwarepakete

## lighttpd
Zuerst aktualisieren wir die Pakete:

{% highlight shell linenos %}
sudo apt-get update
sudo apt-get upgrade
{% endhighlight %}
    
Jetzt installieren wir den webserver lighttpd

{% highlight shell linenos %}
sudo apt-get install lighttpd
{% endhighlight %}

Die Frage ob wir das wirklich wollen, beantworten wir mit "Ja".

Nach der Installation wird der Dienst automatisch gestartet. Dies können wir überprüfen:

{% highlight shell linenos %}
sudo systemctl status lighttpd
{% endhighlight %}

Damit auch bei anderen Betriebsversionen die Funktionalität gegeben ist, müssen wir das DocumentRoot-Verzeichnis für den Webserver umstellen. Standardmäßig ist der neue Pfad /var/www/html/, dies ändern wir auf /var/www/ (Früher war das so). Dazu editieren wir die Konfigurationsdatei  000-default.conf in /etc/apache2/sites-available/

{% highlight shell linenos %}
sudo nano /etc/lighttpd/lighttpd.conf
{% endhighlight %}

und ändern den Parameter

{% highlight plaintext linenos %}
server.document-root = "/var/www/html"
{% endhighlight %}

nach 

{% highlight plaintext linenos %}
server.document-root = "/var/www"
{% endhighlight %}

und speichern dies mittels "_STRG+o_", "_RETURN_" und schließen mit "_STRG+x_"

Damit wir Dateien im Webserververzeichnis ablegen kann, müssen wir noch einige Rechte setzen.

{% highlight shell linenos %}
sudo groupadd www-data
sudo usermod -G www-data -a pi
sudo chown -R www-data:www-data /var/www
sudo chmod -R 775 /var/www
{% endhighlight %}

Zum Test erzeugen wir eine html-Seite im Webverzeichnis:

{% highlight shell linenos %}
sudo nano /var/www/test.html
{% endhighlight %}

mit dem Inhalt

{% highlight plaintext linenos %}
<html>
<head><title>Test-Seite</title></head>
<body>
<h1>Das ist eine Test-Seite.</h1>
</body>
</html>
{% endhighlight %}

speichern dies mittels "_STRG+o_", "_RETURN_" und schließen mit "_STRG+x_" und testen jetzt die Installation.

Evtl. kann auch ein reboot helfen:

{% highlight shell linenos %}
    sudo reboot
{% endhighlight %}

Dazu geben wir in unserem Browser die IP Adresse unseres Raspberry PI gefolgt vom /test.html (http://{IP-Adresse_des_Raspberry_Pi}/test.html) ein und sollten die Website sehen.

Nun müssen wir noch die Passwortauthentifizierung für die Settingsseite einrichten. Dazu aktivieren wir das nötige Modul

{% highlight shell linenos %}
sudo lighty-enable-mod auth
{% endhighlight %}

Dieses müssen wir noch konfigurieren und öffnen es dazu im Editor

{% highlight shell linenos %}
sudo nano /etc/lighttpd/conf-enabled/05-auth.conf
{% endhighlight %}

Folgende Zeilen werden unter server.modules += („mod_auth“) hinzugefügt:

{% highlight plaintext linenos %}
auth.backend                    = "htdigest"
auth.backend.htdigest.userfile     = "/var/.htcredentials"

auth.require                    = ( "/settings.php" =>
                                   (
                                    "method" => "digest",
                                    "realm" => "Pi-Ager",
                                    "require" => "user=pi-ager"
                                   ),
                                    "/admin.php" =>
                                   (
                                    "method"  => "digest",
                                    "realm"   => "Pi-Ager",
                                    "require" => "valid-user" 
                                    ),
                                    "/webcam.php" =>
                                   (
                                    "method"  => "digest",
                                    "realm"   => "Pi-Ager",
                                    "require" => "valid-user" 
                                    )
                                  )
{% endhighlight %}

speichern dies mittels "_STRG+o_", "_RETURN_" und schließen mit "_STRG+x_"
und starten den Webserver neu

{% highlight shell linenos %}
sudo service lighttpd force-reload
{% endhighlight %}

[nach oben](#inhalt)

## PHP 7

Jetzt installieren wir PHP7 unterstützung für lighttpd

{% highlight shell linenos %}
sudo apt-get update
sudo apt-get install php7.0-common php7.0-cgi php7.0 php7.0-sqlite3
{% endhighlight %}

Die Frage ob wir das wirklich wollen beantworten wir mit "Ja".

Nach der Installation von PHP7 müssen wir das FastCGI-Modul für PHP aktivieren und die ighttpd-Konfiguration neu laden.

{% highlight shell linenos %}
sudo lighty-enable-mod fastcgi
sudo lighty-enable-mod fastcgi-php
sudo service lighttpd force-reload
{% endhighlight %}

Jetzt erzeugen wir zum Test eine phpinfo.php im Webverzeichnis

{% highlight shell linenos %}
sudo nano /var/www/phpinfo.php
{% endhighlight %}

Inhalt:

{% highlight php %}
<?php phpinfo(); ?>
{% endhighlight %}

speichern dies mittels "_STRG+o_", "_RETURN_" und schließen mit "_STRG+x_" und testen jetzt die Installation.

Dazu geben wir in unserem Browser die IP Adresse unseres Raspberry PI gefolgt vom /test.html (http://{IP-Adresse_des_Raspberry_Pi}/phpinfo.php) ein und sollten eine Info-Website zu PHP sehen.

Jetzt beschleunigen wir das ganze System noch ein wenig, in dem wir das Caching aktivieren.

{% highlight shell linenos %}
sudo apt-get update
sudo apt-get install php7.0-apcu
{% endhighlight %}

Die Frage ob wir das wirklich wollen beantworten wir mit "Ja".

Dann müssen wir noch einige Einstellungen am APC Cache vornehmen. Dazu öffnet man die APC-Konfigurationsdatei

{% highlight shell linenos %}
sudo nano /etc/php/7.0/mods-available/apcu_bc.ini
{% endhighlight %}

und nehmen folgende Änderungen vor:

{% highlight lighttpd %}
extension=apc.so
apc.enabled=1
apc.file_update_protection=2
apc.optimization=0
apc.shm_size=32M
apc.include_once_override=0
apc.shm_segments=1
apc.gc_ttl=7200
apc.ttl=7200
apc.num_files_hint=1024
apc.enable_cli=0
{% endhighlight %}

speichern dies mittels "_STRG+o_", "_RETURN_" und schließen mit "_STRG+x_".

Des Weiteren berechtigen wir Dateien über die Website mittels x-send-file zu downloaden. Dazu editieren wir die fcgi-configuration:

{% highlight shell linenos %}
sudo nano /etc/lighttpd/conf-enabled/15-fastcgi-php.conf
{% endhighlight %}

und ergänzen am Ende der Zeile

{% highlight lighttpd %}
"broken-scriptfilename" => "enable"
{% endhighlight %}

ein "," und in einer neuen Zeile

{% highlight lighttpd %}
"allow-x-send-file" => "enable"
{% endhighlight %}


speichern dies mittels "_STRG+o_", "_RETURN_" und schließen mit "_STRG+x_" und testen jetzt die Installation.

Zur Übernahme der Änderungen müssen wir die Konfiguration des Webservers neu laden.

{% highlight shell linenos %}
sudo service lighttpd force-reload
{% endhighlight %}

[nach oben](#inhalt)

## pip

Danach folgt pip, mit dem Python-Module installiert werden können

{% highlight shell linenos %}
sudo apt-get install python3-pip
{% endhighlight %}

Die Frage ob wir das wirklich wollen, beantworten wir mit "Ja".

[nach oben](#inhalt)

## git

Wir benötigen GIT um auf das Repository zugreifen zu können.

{% highlight shell linenos %}
sudo apt-get install git
{% endhighlight %}

Die Frage ob wir das wirklich wollen, beantworten wir mit ja.

[nach oben](#inhalt)

## sqlite3

Jetzt installieren wir sqlite3 unterstützung

{% highlight shell linenos %}
sudo apt install sqlite3
{% endhighlight %}

[nach oben](#inhalt)

## sht-sensoren

Unterstützung für SHT-Sensor

{% highlight shell linenos %}
sudo pip3 install pi-sht1x
{% endhighlight %}

[nach oben](#inhalt)

## DHT-sensoren

Jetzt installieren wir noch die Unterstützung für die DHT-Sensoren

{% highlight shell linenos %}
git clone https://github.com/bob60/DHT-sensors-python3
sudo apt-get install build-essential python3-dev
cd DHT-sensors-python3
sudo python3 setup.py install
{% endhighlight %}

und wechseln zurück in das home-Verzeichnis

{% highlight shell linenos %}
cd
{% endhighlight %}

[nach oben](#inhalt)

## wiringpi

Nun installieren wir noch Wiring Pi. Dies ist ein nützliches Framework, um die GPIO Ein-und Ausgänge am Raspberry Pi zu schalten.

Dazu klonen wir wiringPi

{% highlight shell linenos %}
sudo git clone git://git.drogon.net/wiringPi
cd wiringPi
sudo ./build
cd
{% endhighlight %}

[nach oben](#inhalt)

## ZIP

Damit wir z.B. Logfiles zippen können, installieren wir jetzt die ZIP-Unterstützung

{% highlight shell linenos %}
sudo apt-get install zip
{% endhighlight %}

[nach oben](#inhalt)

## Webcam

nun installieren wir noch mjpegstreamer zum streamen des Webcambildes.

{% highlight shell linenos %}
sudo apt-get install subversion libjpeg8-dev imagemagick -y
sudo svn co https://svn.code.sf.net/p/mjpg-streamer/code/mjpg-streamer/ mjpg-streamer
cd mjpg-streamer
sudo make
{% endhighlight %}

verschieben das Programm nach /opt

{% highlight shell linenos %}
cd
sudo mv mjpg-streamer/ /opt/
{% endhighlight %}

erstellen ein Startscript
{% highlight shell linenos %}
sudo nano /opt/mjpg-streamer/webcam.sh
{% endhighlight %}

mit dem Inhalt (ohne Zeilenumbruch)

{% highlight plaintext linenos %}
#!/bin/bash
/opt/mjpg-streamer/mjpg_streamer -i "/opt/mjpg-streamer/input_uvc.so -d /dev/video0 -y -n -f 2" -o "/opt/mjpg-streamer/output_http.so -n -w /opt/mjpg-streamer/www" &
{% endhighlight %}

speichern dies mittels "_STRG+o_", "_RETURN_" und schließen mit "_STRG+x_"

Dann erlauben wir die Ausführung des Scripts

{% highlight shell linenos %}
sudo chmod +x /opt/mjpg-streamer/webcam.sh
{% endhighlight %}

[nach oben](#inhalt)

## fswebcam

Um ab und an auch mal ein Bild von der Webcam zu speichern installieren wir noch fswebcam

{% highlight shell linenos %}
sudo apt-get install fswebcam
{% endhighlight %}

Die Frage, ob wir das wirklich wollen, beantworten wir mit "Ja".

Damit sind unsere Installationsvorbereitungen abgeschlossen und wir können uns nun der Reifeschranksteuerung widmen

[nach oben](#inhalt)

# Programm Reifeschranksteuerung

Jetzt erstellen einen Ordner (pi-ager) im Verzeichniss /opt:

{% highlight shell linenos %}
sudo mkdir /opt/pi-ager
{% endhighlight %}

Wir laden nun die im GitHub zur Verfügung gestellten Dateien aus dem Branch master herunter und entpacken diese.

[Download](https://github.com/Tronje-the-Falconer/Pi-Ager/archive/master.zip)

Auf unserem PC installieren wir uns eine FTP Software (z.B. [FileZilla](https://filezilla-project.org/)), mit der wir eine Verbindung zu unserem Raspberry Pi aufbauen.

Wir verbinden uns mit sftp://IP-DES_RASPBERRY-PI und dem Benutzer root mit dem dazugehörigen Passwort

und kopieren dann die Dateien aus dem Download-Verzeichnis pi-ager in das gleichnamige Verzeichnis auf dem Raspberry Pi unter /opt/pi-ager.

danach kopieren wir aus dem Download-Verzeichnis var die Dateien sudowebscript.sh und .htcredentials in das gleichnamige Verzeichnis auf dem Raspberry Pi unter /var.

Wir starten nun putty und loggen uns mit dem User pi und dem vergebenen Passwort für pi ein.

Über putty müssen wir nun dieses Shellscript in /etc/sudoers eintragen, damit der www-data User (User der Website) dies ausführen darf. Da ich nano einfacher zum bearbeiten finde, setzen wir diesen zuerst als Standard-Editor

{% highlight shell linenos %}
export EDITOR=nano
{% endhighlight %}

öffnen dann etc/sudoers mit

{% highlight shell linenos %}
EDITOR=nano sudo -E visudo
{% endhighlight %}
    
und tragen dann in sudoers folgendes nach 

{% highlight plaintext linenos %}
...
#User privilege specification
root    ALL=(ALL:ALL) ALL
...
{% endhighlight %}

ein:

{% highlight plaintext linenos %}
www-data ALL=NOPASSWD:/var/sudowebscript.sh
{% endhighlight %}

Und speichern mittels _STRG+O_ und beenden mit _STRG+X_

Als nächstes kümmern wir uns um den Autostart des Schranks. Hiermit wird z.B. ermöglicht, das der Schrank nach einem Stromausfall automatisch wieder anläuft. Dazu legen wir eine Datei an:

{% highlight shell linenos %}
sudo nano /etc/init.d/pi-ager-main.sh
{% endhighlight %}

Hinweis: Der nachfolgende Inhalt kann hier kopiert und dann in putty eingefügt werden.

{% highlight plaintext linenos %}
#! /bin/sh
### BEGIN INIT INFO
# Provides: pi-ager-main.sh
# Required-Start: $syslog
# Required-Stop: $syslog
# Default-Start: 2 3 4 5
# Default-Stop: 0 1 6
# Short-Description: pi-ager main.py
# Description:
### END INIT INFO

case "$1" in
    start)
        echo "pi-ager main.py wird gestartet"
        # Starte Programm
        /usr/bin/python3 /opt/pi-ager/main.py > /dev/null 2>/dev/null &
        echo "startvorgang abgeschlossen"
        ;;
    stop)
        echo "pi-ager main.py wird beendet"
        # Beende Programm
        pkill -f main.py
        ;;
    *)
        echo "Benutzt: /etc/init.d/pi-ager-main.sh {start|stop}"
        exit 1
        ;;
esac

exit 0
{% endhighlight %}

speichern dies mittels "_STRG+o_", "_RETURN_" und schließen mit "_STRG+x_" und vergeben der Datei dann das Recht ausführbar zu sein

{% highlight shell linenos %}
sudo chmod 755 /etc/init.d/pi-ager-main.sh
{% endhighlight %}

das ganze testen wir auf Funktion indem wir folgenden Befehl auf der Konsole eingeben:

{% highlight shell linenos %}
sudo /etc/init.d/pi-ager-main.sh start
{% endhighlight %}

es sollte folgende ausgabe erscheinen:

{% highlight plaintext linenos %}
pi-ager main.py wird gestartet
startvorgang abgeschlossen
{% endhighlight %}

danach landen wir wieder im sogenannten Prompt und können einen weiteren Befehl absetzen, der den Dienst wieder stoppt:

{% highlight shell linenos %}
sudo /etc/init.d/pi-ager-main.sh stop
{% endhighlight %}

Wenn dies alles erfolgreich war tragen diese Datei als Startroutine ein

{% highlight shell linenos %}
sudo update-rc.d pi-ager-main.sh defaults
{% endhighlight %}

Nun benötigen wir noch eine .htcredentials Datei für die Settingsseite, die unseren User und sein Passwort enthält.

Dazu Benutzen wir das Online-Tool [https://websistent.com/tools/htdigest-generator-tool/](https://websistent.com/tools/htdigest-generator-tool/)

{% highlight plaintext %}
Username: pi-ager
REALM: Pi-Ager
Password: Euer Passwort
{% endhighlight %}

Achtung! Groß-/Kleinschreibung beachten!

Die Datei öffnen wir mit

{% highlight shell linenos %}
sudo nano /var/.htcredentials
{% endhighlight %}

und fügen den erzeugten String (am besten per kopieren/einfügen) in die Datei ein.

speichern dies mittels "_STRG+o_", "_RETURN_" und schließen mit "_STRG+x_"

Die Dateien aus dem Download-Verzeichnis www kopieren wir nach /var/www/

Jetzt müssen wir noch ein paar Schreibrechte über Putty oder über FileZilla auf bestimmten Dateien vergeben:

Hier die Befehle für Putty:

{% highlight shell linenos %}
sudo chmod 666 /var/www/logs/logfile.txt
sudo chmod 775 /var/www/logs/
sudo chmod 664 /var/www/config/pi-ager.sqlite3
sudo chown -R www-data:www-data /var/www/config/
sudo chmod 555 /var/sudowebscript.sh
sudo chmod 777 /var/www/csv/
{% endhighlight %}

Der Benutzer 'pi' ist standardmäßig Mitglied in der Gruppe 'gpio' und hat daher Zugriff auf die virtuellen Dateien /sys/class/gpio/ ... Der Webserver läuft aber als Benutzer 'www-data' und ist nicht Mitglied in dieser speziellen Gruppe. Um das zu ändern muss man also den 'www-data' Benutzer der Gruppe 'gpio' hinzufügen und den Webserver neu starten:

{% highlight shell linenos %}
sudo usermod -G gpio -a www-data
sudo service lighttpd force-reload
{% endhighlight %}

jetzt fahren wir den Raspberry Pi mittels

{% highlight shell linenos %}
sudo halt
{% endhighlight %}

herunter und ziehen den Stecker vom Netzteil.

Nun wird der Sensor am Raspberry Pi angeschlossen. Siehe dazu die [Bau- und Anschlussanleitung](https://github.com/Tronje-the-Falconer/Pi-Ager/wiki/3.i-Bau-und-Anschluss-des-Feuchtigkeits-und-Temperatursensors)

Sobald dies erfolgt ist, können wir den Raspberry wieder starten, indem wir den Netzstecker wieder anschließen.

Wenn wir nun die Webiste http://IPADRESSE/index.php aufrufen, sollte alles funktionieren.

[nach oben](#inhalt)