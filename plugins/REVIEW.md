# REVIEW

## General

K routes.php, middleware a controllerom nemám moc výhrady, máš to fajn

## Migrácie

Migrácie slúžia na manipulovanie s štruktúrov databázy
V súbore version.yaml je možné písať v akom poradí sa majú migrácie používať a taktiež sa k nim dajú dať notes (ako to aj robíš)

Keď si zoberieme tvoj momentálne stav version.yaml ...

v1.0.1: First version of User
v1.0.2: 
  - Create a join table for Users and Chatrooms
  - create_users_table.php
v1.0.3:
  - Added columns "username" and "password"
  - create_users_table.php
v1.0.4:
  - Added column "token" for JWT tokens
  - create_users_table.php
v1.0.5:
  - Change join table schema name to user_chat_room
  - create_users_table.php

Tak v podstate vidíme že máš 5 verzií, ktoré ale používajú jednu a tú istú migráciu, čo nedáva zmysel
Vo verzii v1.0.2 prvý krát zbehne create_users_table.php, ale v tejto migrácii sú už zmeny, ktoré opisuješ vo verzii v1.0.5, teda napr. "Added column "token" for JWT tokens"
Migrácie teda zbehne raz v kroku / verzii v1.0.2, a potom už nikdy nezbehne znovu, a len je tu v podstate napísané že nastali zmeny v nových verziách aj keď už boli uplatnené

Tieto verzie v version.yaml sa používajú napr. keď pol roka funguje aplikácia bez nejakého údaju, a potom sa pridá nový údaj a musí sa pridať aj do databázy
V takejto situácii bakcend developer nemôže jednoducho editnúť migráciu ktorá už dávno zbehla, pretože už znova nezbehne aj keď sa zmenila
Na uplatnenie novej zmeny by musel vytvoriť novú migráciu, čiže version.yaml súbor by vyzeral skôr takto

v1.0.1:
  - Create users table
  - create_users_table.php
v1.0.2:
  - Add "token" column
  - add_token_to_users_table.php
v1.0.3:
  - Remove "email" column
  - remove_email_from_users_table.php

V testovaciom / lokálnom prostredí si vieš databázu refreshnúť a starú upravenú migráciu zbehnúť znovu (čo predpokladám že takto robíš) a teda by ti stačil jedna verzia
Len ti to vysvetlujem aby si rozumel významu verzií, a že zbehnutá migrácia už na produkčnom prostredí znovu nezbehne (keďže na produkčnom prostredí nemôžeš len tak refreshnúť databázu so všetkými údajmi :DD)

A ešte som si všimol že na viacerých miestach vytvoríš pivot table spolu s ďalším table v jednej mográcii, odporúčam robiť to skôr tak že pre každý oddleneý table urob samostatnú migráciu

## Admin

V tomto projekte nemáš implementovaný Admin Page pomocou List a Form, je to v Leveli 2 popísané ale budeš musieť použiť aj dokumentáciu (ako vždy)
