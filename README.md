# Foodie



## About Foodie

Seit Corona essen wir gerne von Zuhause. Deswegen bieten wir jetzt einen Lieferdienst an. Somit kann man problemlos von Zuhause aus sein Essen bestellen. Das geht ganz einfach über unsere Webseite.

<hr>

## Voraussetzungen
* [XAMPP (Windows)](https://www.apachefriends.org/download.html) oder [MAMP (Mac OS)](https://www.mamp.info/en/downloads/) ist installiert

## Installationsanleitung

Um diese Webseite betriebsbereit zu machen, cloned man sich zuerst alle Daten von unserem Git (https://github.com/raquelima/foodie)

Befehl: 
```
git clone https://github.com/raquelima/foodie
```


### Webseite
Alle Dateien im Hauptordner kopiert man dann in sein Webroot (Bei XAMP oder MAMP ist es der htdocs Ordner). Der Webservice muss online sein. Somit kann die Webseite aufgerufen werden. Jedoch können noch keine Daten angezeigt werden.

### Datenbank
Um jetzt Daten anzuzeigen, gibt es unter [./database/](./database/) eine restaurants.sql File. Diese muss jetzt in die Datenbank importiert werden. Nach dem Import werden auf der Webseite alle Daten angezeigt. Die Datenbank beinhaltet alle Tables (restaurants, food, users, orders). Ebenfalls wird ein Datenbank User namens Admin erstellt.

<hr>

Projekt von Raquel Lima [@raquelima](https://github.com/raquelima) und Elias Mattern [@CoalPlays](https://github.com/CoalPlays)
