#!/bin/bash

# Script-Name: pi-ager_image
# Version    : 0.0.5
# Autor      : DerBurgermeister
# Datum      : 11.01.2020
# Dieses Script erstellt aus einem Backup ein Image. Nur für internen Gebrauch
# Vorher auf dem Source System noch folgende Befehle ausführen:
# apt -y update && apt -y upgrade && apt -y install linux-image && apt --fix-broken install
# Grund: Bei einem Kernel Upgrade gibt es Probleme
#####################################################################
#Variablen
#####################################################################
#

# Pfad zur NFS Freigabe (Muss im NAS angelegt werden)
NFSVOL=$(sqlite3 /var/www/config/pi-ager.sqlite3 "select nfsvol from nfs_backup where active = 1")

# dieses Verzeichniss muss im NAS angelegt sein
SUBDIR=$(sqlite3 /var/www/config/pi-ager.sqlite3 "select subdir from nfs_backup where active = 1")

#NFSMOUNT=/home/pi/backup							# Pfad auf dem Pi indem das Backup gespeichert wird
NFSMOUNT=$(sqlite3 /var/www/config/pi-ager.sqlite3 "select nfsmount from nfs_backup where active = 1")

# setzt sich zusammen aus dem Dateipfad auf dem Pi und dem Verzeichnis im NAS
BACKUP_PFAD=$(sqlite3 /var/www/config/pi-ager.sqlite3 "select backup_path from nfs_backup where active = 1")

# behält die letzten "n" Backups
BACKUP_ANZAHL=$(sqlite3 /var/www/config/pi-ager.sqlite3 "select number_of_backups from nfs_backup where active = 1")

# Name des Backup
BACKUP_NAME=$(sqlite3 /var/www/config/pi-ager.sqlite3 "select backup_name from nfs_backup where active = 1")

# ENDE VARIABLEN
 
#####################################################################
# Skript (hier sollten nur erfahrene User anpassungen machen!)
#####################################################################
COMMAND_LINE_OPTIONS_HELP='
Command line options:
    -c          Copy input File. Otherwise the input file will be changed
    -h          Print this help menu

Examples:
    Copy backup file to a new image file
        '`basename $0`' -c PiAgerBackup_2020-01-22-07:02:17.img

    Use backup file as a new image file
        '`basename $0`' PiAgerBackup_2020-01-22-07:02:17.img

'

VALID_COMMAND_LINE_OPTIONS=":c:h"


while getopts $VALID_COMMAND_LINE_OPTIONS options; do
    #echo "option is " $options
    case $options in
        c)
        	$do_copy = true;
        ;;
        h)
            echo "$COMMAND_LINE_OPTIONS_HELP"
            exit $E_OPTERROR;
        ;;
        \?)
            echo "Usage: `basename $0` -h for help";
            echo "$COMMAND_LINE_OPTIONS_HELP"
            exit $E_OPTERROR;
        ;;
        *) 
	        echo "$COMMAND_LINE_OPTIONS_HELP"
            exit $E_OPTERROR; 
        ;;
    esac
done
#if [ "$do_copy" == true ]; then
if [ 1==1  ];
	then
		img_old="$1"
		img="PiAger_image.img"
		echo "Coping $img_old to $img"
		rsync -a --info=progress2 "./$img_old" "$img"
 	else
 		img="$1"
 		echo "Using $img as source and target"
 	
 fi
#img_old="$2"
#read -p "Press enter to continue after copy image"
echo "####################################################################################"
parted_output=$(parted -ms "$img" unit B print | tail -n 1)
partnum=$(echo "$parted_output" | cut -d ':' -f 1)
partstart=$(echo "$parted_output" | cut -d ':' -f 2 | tr -d 'B')
loopback=$(losetup -f --show -o "$partstart" "$img")
echo "parted_output = $parted_output"
echo "partnum = $partnum"
echo "partstart = $partstart"
echo "loopback = $loopback"
echo "####################################################################################"
parted_output_boot=$(parted -ms "$img" unit B print | head -n3 | tail -n1)
partnum_boot=$(echo "$parted_output_boot" | cut -d ':' -f 1)
partstart_boot=$(echo "$parted_output_boot" | cut -d ':' -f 2 | tr -d 'B')
loopback_boot=$(losetup -f --show -o "$partstart_boot" "$img")
echo "parted_output_boot = $parted_output_boot"
echo "partnum_boot = $partnum_boot"
echo "partstart_boot = $partstart_boot"
echo "loopback_boot = $loopback_boot"
echo "####################################################################################"



#read -p "Press enter to continue before image mount"
mountdir=$(mktemp -d)

mount "$loopback" "$mountdir"
#read -p "Press enter to continue after mounting $loopback to $mountdir"

mount -t msdos "$loopback_boot" "$mountdir/boot"
#read -p "Press enter to continue after mounting $loopback_boot $mountdir/boot"
#echo "Copy $mountdir/boot.bak/ to $mountdir/boot/"
#rsync -a --info=progress2 "$mountdir/boot.bak/" "$mountdir/boot/"
#read -p "Press enter to continue after copy boot.bak to boot"

for i in dev proc sys dev/pts
do
    mount -o bind /$i $mountdir/$i
done
#read -p "Press enter to continue after mount dev sys ..."
echo $mountdir
regex='(\/.*\/)(.*)'
[[ $mountdir =~ $regex ]]
chrootdir=${BASH_REMATCH[2]}
echo $chrootdir
cd ${BASH_REMATCH[1]} 
pwd
chroot $chrootdir /bin/bash <<EOF
# This commands are called inside of the chroot environment 
# The aim is to make an new image for the Pi-Ager Communtiy

######################################################
# System delete not needed packages and cleanup
# apt update and upgrade don't work. Error loding module and hciuart.service
######################################################

apt -y update && apt -y upgrade && apt -y install linux-image && apt --fix-broken install
apt remove -y timidity lxmusic gnome-disk-utility deluge-gtk evince wicd wicd-gtk clipit usermode gucharmap gnome-system-tools pavucontrol
apt remove -y influxdb grafana-rpi sysstat stress bareos-common bareos-filedaemon check-mk-agent subversion
apt -y autoremove && apt -y clean &&  apt -y autoclean 

# C++
#apt remove -y g++-8/stable g++ gcc-4.6-base gcc-4.7-base gcc-4.8-base gcc-4.9-base gcc-5-base gcc-6-base gcc-6 gcc-7-base gcc-8-base gcc-8 gcc gdb 
# Fortran
apt remove -y gfortran-6 gfortran-8 gfortran
# Old python version
apt remove -y python2-minimal python2.7-minimal python2.7 python2
# Pango
apt remove -y libpango-1.0-0 libpangocairo-1.0-0 libpangoft2-1.0-0

######################################################
# Pip upgrade and update packages
######################################################

pip install --upgrade pip
pip3 list --outdated --format=freeze | grep -v '^\-e' | cut -d = -f 1  | xargs -n1 pip3 install 




######################################################
# delete not needed files
######################################################

find /var/log/ -type f -exec rm "{}" \;
find /var/mail/ -type f -exec rm "{}" \;
find /var/tmp/ -type f -exec rm "{}" \;
find /var/cache/ -type f -exec rm "{}" \;
find /var/www/logs/ -type f -exec rm "{}" \;
find /tmp/ -type f -exec rm "{}" \;
find /root/.cache/ -type f -exec rm "{}" \;

rm -r /opt/git
rm -r /opt/GPIO-Test
rm -r /opt/MCP3204
rm -r /opt/vc
# remove obsolete direcectories after upgrade
rm -r /boot.bak
rm -r /lib/modules.bak
#PRUNE_MODULES=1 sudo rpi-update

# remove obsolete systemd start files
rm /etc/systemd/system/bareos-fd.service
rm /etc/systemd/system/bacula-fd.service
rm /etc/systemd/system/bareos-filedaemon.service
rm /etc/systemd/system/'check_mk@.service'
rm /etc/systemd/system/check_mk.socket
rm /etc/systemd/system/haveged.service
rm /etc/systemd/system/influxd.service

######################################################
# Delete personal files (ssh keys ...)
######################################################
# root user
rm -f /root/.ssh/authorized_keys
rm -f /root/.ssh/known_hosts

# pi user
rm -f /home/pi/.ssh/authorized_keys
rm -f /home/pi/.bash_history

######################################################
# Change some settings
######################################################
# change ssh port:
sed -i "s/Port 57673/Port 22/g" /etc/ssh/sshd_config

# change hostname
raspi-config nonint do_hostname rpi-Pi-Ager

######################################################
#Force password change for user root
######################################################
chage -d 0 root

######################################################
# move needed settings
######################################################

# Restore /etc/wpa_supplicant/wpa_supplicant.conf
mv /etc/wpa_supplicant/wpa_supplicant.conf.org /etc/wpa_supplicant/wpa_supplicant.conf

# Restore /var/.htcredentials
mv /var/.htcredentials.org /var/.htcredentials

######################################################
# SQLite3 changes
######################################################

sqlite3 /var/www/config/pi-ager.sqlite3 "update debug set value = 20 where key = 'loglevel_file'"
sqlite3 /var/www/config/pi-ager.sqlite3 "update debug set value = 20 where key = 'loglevel_console'"
sqlite3 /var/www/config/pi-ager.sqlite3 "delete from nfs_backup"
sqlite3 /var/www/config/pi-ager.sqlite3 "delete from alarm"
sqlite3 /var/www/config/pi-ager.sqlite3 "delete from email_server"
sqlite3 /var/www/config/pi-ager.sqlite3 "delete from email_recipient"
sqlite3 /var/www/config/pi-ager.sqlite3 "delete from messenger"

BACKUP_NAME=$(sqlite3 /var/www/config/pi-ager.sqlite3 "select backup_name from nfs_backup where active = 1")

EOF

for i in dev/pts proc sys dev
do
    umount $mountdir/$i
done

#read -p "Press enter to continue after umount dev sys ..."
umount "$mountdir/boot"
umount "$mountdir"
if [ $? -ne 0 ]
then
  	echo "Error unmounting $mountdir. Maybe $mountdir is open. Image is then corrupt."
  	lsof $loopdir
  	exit 1
else
	rm -rf $mountdir/boot
	rm -rf $mountdir
	
	# Shrink and zip image
	# Shrink and zip image
	pishrink.sh -r -z ${BACKUP_PFAD}/$img 
	#${BACKUP_PFAD}/PiAger_image_$(date +%Y-%m-%d-%H:%M:%S).img.zip.
	# Backup umbenennen mit Datum
	mv ${BACKUP_PFAD}/PiAger_image.img.gz ${BACKUP_PFAD}/PiAger_image_$(date +%Y-%m-%d-%H:%M:%S).img.gz
	echo "The image ${BACKUP_PFAD}/PiAger_image_$(date +%Y-%m-%d-%H:%M:%S).img.gz was successfully created."

	
fi