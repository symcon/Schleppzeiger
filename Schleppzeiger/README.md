# Schleppzeiger
Eine Variable, welche auf dem höchsten oder niedrigsten Wert bis zum Reset stehen bleibt.

### Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [WebFront](#6-webfront)
7. [PHP-Befehlsreferenz](#7-php-befehlsreferenz)

### 1. Funktionsumfang

* Variable, welche den höchsten/niedrigsten Wert seit dem letztem Reset anzeigt
* Reset via Timer oder manuel möglich

### 2. Voraussetzungen

- IP-Symcon ab Version 6.0

### 3. Software-Installation

* Über den Module Store das 'Schleppzeiger'-Modul installieren.

### 4. Einrichten der Instanzen in IP-Symcon

 Unter 'Instanz hinzufügen' kann das 'Schleppzeiger'-Modul mithilfe des Schnellfilters gefunden werden.  
	- Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)

__Konfigurationsseite__:

Name         | Beschreibung
------------ | ------------------
Zielvariable | Variable, deren Werte ausgelesen werden
Optionen     | __Maximum__ Gibt an ob der Schleppzeigen den höchsten oder niedrigsten Wert anzeigen soll
Intervall    | Zeitangabe in Sekunden bis der Schleppzeiger auf den Wert der Zielvariable zurückgesetzt wird. 

### 5. Statusvariablen und Profile

Die Statusvariablen/Kategorien werden automatisch angelegt. Das Löschen einzelner kann zu Fehlfunktionen führen.

#### Statusvariablen

Name          | Typ     | Beschreibung
------------- | ------- | ------------
Schleppzeiger | float   | Zeigt den höchsten/niedrigsten Wert seit dem letzten Reset an
Zurücksetzen  | int     | Assoziation zum Zurücksetzen des Schleppzeigers

#### Profile

Name   | Typ
------ | -------
SZ.Reset | int

### 6. WebFront

Anzeige, sowie Zurücksetzen des Schleppzeigers

### 7. PHP-Befehlsreferenz

`boolean SZ_Reset(integer $InstanzID);`
Setzt den Schleppzeiger zurück.

Beispiel:
`SZ_Reset(12345);`