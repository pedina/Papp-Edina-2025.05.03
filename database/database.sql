DROP DATABASE IF EXISTS mozi;
CREATE DATABASE IF NOT EXISTS mozi DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE mozi;

-- rendezo tábla létrehozása
CREATE TABLE rendezo (
    id INT NOT NULL AUTO_INCREMENT,
    nev VARCHAR(50),
    PRIMARY KEY(id)
);

-- mufaj tábla létrehozása
CREATE TABLE mufaj (
    id INT NOT NULL AUTO_INCREMENT,
    nev VARCHAR(50),
    PRIMARY KEY(id)
);

-- besorolas tábla létrehozása
CREATE TABLE besorolas (
    id INT NOT NULL AUTO_INCREMENT,
    kor INT,
    PRIMARY KEY(id)
);

-- film tábla létrehozása
CREATE TABLE film (
    id INT NOT NULL AUTO_INCREMENT,
    cim VARCHAR(50),
    leiras TEXT,
    hossz INT,
    url VARCHAR(30),
    rendezoId INT,
    mufajId INT,
    besorolasId INT,
    ev INT,
    PRIMARY KEY(id),
    KEY rendezoId (rendezoId), CONSTRAINT fk_rend_rendId FOREIGN KEY (rendezoId) REFERENCES rendezo (id),
    KEY mufajId (mufajId), CONSTRAINT fk_mufaj_mufajId FOREIGN KEY (mufajId) REFERENCES mufaj (id),
    KEY besorolasId (besorolasId), CONSTRAINT fk_bes_besorId FOREIGN KEY (besorolasId) REFERENCES besorolas (id)
);

-- terem tábla létrehozása
CREATE TABLE terem (
    id INT NOT NULL AUTO_INCREMENT,
    ferohely INT,
    PRIMARY KEY(id)
);

-- vetites tábla létrehozása
CREATE TABLE vetites (
    id INT NOT NULL AUTO_INCREMENT,
    filmId INT,
    datum DATE,
    ido TIME,
    teremId INT,
    PRIMARY KEY(id),
    KEY filmId (filmId), CONSTRAINT fk_film_filmId FOREIGN KEY (filmId) REFERENCES film (id),
    KEY teremId (teremId), CONSTRAINT fk_terem_teremId FOREIGN KEY (teremId) REFERENCES terem (id)
);

-- felhasznalo tábla létrehozása
CREATE TABLE felhasznalo (
    id INT NOT NULL AUTO_INCREMENT,
    nev VARCHAR(50),
    email VARCHAR(50),
    jelszo VARCHAR(255),
    admin TINYINT(1),
    PRIMARY KEY(id)
);

-- arazas tábla létrehozása
CREATE TABLE arazas (
    id INT NOT NULL AUTO_INCREMENT,
    kategoria VARCHAR(50),
    ar INT,
    PRIMARY KEY(id)
);

-- foglalas tábla létrehozása
CREATE TABLE foglalas (
    id INT NOT NULL AUTO_INCREMENT,
    felhasznaloId INT,
    vetitesId INT,
    datum TIMESTAMP,
    szekszam INT,
    jegytipus INT,
    PRIMARY KEY(id),
    KEY felhasznaloId (felhasznaloId), CONSTRAINT fk_felh_felhId FOREIGN KEY (felhasznaloId) REFERENCES felhasznalo (id),
    KEY vetitesId (vetitesId), CONSTRAINT fk_vetit_vetitesId FOREIGN KEY (vetitesId) REFERENCES vetites (id),
    KEY jegytipus (jegytipus), CONSTRAINT fk_jegy_jegytipus FOREIGN KEY (jegytipus) REFERENCES arazas (id)
);

INSERT INTO `felhasznalo`(`nev`, `email`, `jelszo`, `admin`) VALUES ('Kiss Klára','klara@gmail.com','ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f',false);

INSERT INTO `felhasznalo`(`nev`, `email`, `jelszo`, `admin`) VALUES ('Kovács Ella','ella@gmail.com','7e071fd9b023ed8f18458a73613a0834f6220bd5cc50357ba3493c6040a9ea8c',false);

INSERT INTO `felhasznalo`(`nev`, `email`, `jelszo`, `admin`) VALUES ('Minta Péter','admin@admin.com','4cf0c1012276f46af31e44d2fbb03ae7af56f03c9996eb9452b99b3e6273698e',true);

INSERT INTO rendezo (nev) VALUES
('Greta Gerwig'),
('Steven Spielberg'),
('Christopher Nolan'),
('Damien Chazelle'),
('Denis Villeneuve'),
('David O. Russell'),
('Robert Zemeckis'),
('Byron Howard'),
('David Yates'),
('Thomas Kail'),
('John McTiernan'),
('Kyle Balda'),
('Sam Wrench'),
('Joe Wright');

INSERT INTO mufaj (nev) VALUES
('Akció'),
('Vígjáték'),
('Dráma'),
('Thriller'),
('Sci-fi'),
('Fantasy'),
('Krimi'),
('Romantikus'),
('Kaland'),
('Animációs'),
('Történelmi'),
('Musical'),
('Koncertfilm');

INSERT INTO `besorolas`(`kor`) VALUES (0),(6),(12),(16),(18);


INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Kisasszonyok','A Kisasszonyok négy nővér, Amy, Meg, Beth és Jo története az amerikai polgárgáború idejéről. Míg apjuk a frontvonalon harcol, édesanyjuk mindent elkövet, hogy rendezett életet biztosítson lányai számára.',135, '1.jpg', 1,3,3,2019);

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Dűne', 'Paul Atreidesre olyan sors vár, amelyet senki fel nem foghat: sem más, sem ő. A távoli jövőben, a bolygóközi királyságok korában járunk. A királyságok az Arrakis bolygó feletti uralomért harcolnak, de a naprendszereken átívelő cselszövések, háborúk és politikai manőverek közepette van egy ember, aki talán békét hozhat az univerzumnak. De ehhez harcolnia kell.Ellenséges bolygók, fantasztikus tájak, különös lények és emberfölötti teljesítmények története ez. És két évszázados királyi ház, az Atreidesek és a Harkonnenek viszályáé. És egy szerelemé, amelyet egész hadseregek sem tehetnek semmissé.',155,'2.jpg',5,5,4,2021);

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Joy', 'Joy neve azt jelenti: öröm. És valószínűleg nem véletlenül. Különleges nő: szeszélyes, bolondos, elszánt és erős; és bármire hajlandó, hogy együtt tartsa családját, melynek tagjai legalább olyan dilisek és olyan makacsok, mint ő maga. Nincs túl sok esélye a sikerre. És ez ad neki szárnyakat. A szükség és egy álom, amelyhez gyerekkora óta ragaszkodik, végül elrepíti odáig, hogy egy sok millió dollár értékű vállalatbirodalom alapítója legyen.',124, '3.jpg', 6,3,3,2015);

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Csillagok között', 'Egy csapat tudós az űrutazás forradalmian új módját fedezi fel: egy féreglyuk segítségével olyan távolságra is eljuthat ember a csillagok közé, ahova eddig még sosem. A felfedezés fontosságát csak növeli, hogy a Föld haldoklik, és így az emberiségnek sincs nagy jövője ezen a planétán. Most a csillagok között lehetőség nyílik megtalálni a megoldást a bolygószintű problémára.',169,'4.jpg',3,5,3, 2014);

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Vissza a jövőbe 3.','Az 1955-ös furcsa villámlás után Martynak egyenesen 1885-be kell visszautaznia, hogy megmentse a Dokit egy túl korai haláltól. Nagy nehezen túléli az indiánok támadását és a barátságtalan városlakók intrikáit, s végül ráakad a Dokira, aki nem más, mint a városka kovácsa. Doki azonban nem hallgat a figyelmeztetésre, mivel fülig beleszeretett az elbűvölő tanítónőbe, Clara Claytonba. Így Marty feladata lesz, hogy kimenekítse őket a Vadnyugatról, s visszatérjenek a jövőbe.',115, '5.jpg', 7,5,3,1990);

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Az elveszett frigyláda fosztogatói','Indiana Jones régész, professzor és kalandor egy személyben, aki semmilyen veszélytől sem riad vissza, hogy megszerezzen egy műkincset. 1936-ban híre jön, hogy a németek hatalmas ásatásokba kezdtek Egyiptomban. A Biblia legendás ereklyéjét, a frigyládát keresik, amiben Mózes kőtáblái találhatók a tízparancsolattal. A mítosz szerint ugyanis legyőzhetetlenné válik, aki a ládát birtokolja. Az amerikai titkosszolgálat megbízza Indiana Jones-t, hogy előzze meg a nácikat. A kalandvágyó professzor Egyiptomba utazik, ahol elkeseredett harc bontakozik ki a frigyládáért.',115, '6.jpg', 2,9,3,1981);

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Kaliforniai álom','Mia, a feltörekvő, fiatal színésznő és Sebastian, a szépreményű jazz zongorista a Csillagok Városában, Los Angelesben keresi az álmait. Mia meghallgatásról meghallgatásra jár, és csak arra vágyik, hogy végre ne szakítsák félbe, Sebastian pedig szenvedélyesen küzd azért, hogy a klasszikus jazzt újra divatba hozza. Távlati terveikben a hollywoodi karrier, illetve egy saját zenés klub megalapítása szerepel – ekkor botlanak egymásba egy zsúfolt autópálya kellős közepén.
A két fiatal szerelemre lobban, és vállvetve segíti egymást a kudarcokkal kikövezett úton. A sikerért keményen meg kell küzdeniük, ám eljön a nap, amikor dönteniük kell, mennyit hajlandóak feláldozni az álmaikért…','126','7.jpg','4','12','3','2016');

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Barbie','Van ám olyan világ, ahol minden csodálatos! Mindig süt a nap, lenn a parton mindig lágyan hullámzik a tenger, és szörfdeszkákon, a nyugágyakban meg a bulizósabb helyeken sokféle, de mindig gyönyörű strandoló gyűlik össze: Barbie és Ken meg a többi Barbie és Ken.
De még a legtökéletesebb, legrózsaszínebb, legszerelmesebb helyen is történhetnek bajok. Szerencsére Barbie nemcsak szép, hanem talpraesett is. Ha kell, még a valóságos világba is elmegy, hogy megvédje a maga különleges országát. És persze sosincs egyedül. Lehet, hogy Ken nem olyan éles eszű, vagy nem akkora vagány, mint ő, de van egy nagyon fontos tulajdonsága: mindig kiáll az ő Barbie-jáért, és sosem hagyja cserben.','114','8.jpg','1','2','3','2023');

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Oppenheimer','A II. világháború egyik legborzalmasabb velejárója az atombomba feltalálása, amelynek első – és egyben utolsó – bevetése annak idején sokkolta a világot. A pusztító fegyver feltalálása J. Robert Oppenheimer nevéhez fűződik, akinek történetét e film keretei között most megismerhetjük. Az atombomba megjelenése az emberiség történetének egyik legmegrázóbb pillanatát okozta, közben pedig bepillantást nyerhetünk annak az embernek az életébe is, aki talán sosem volt képes arra, hogy találmányának borzasztó hatásaival megbirkózzon.','180','9.jpg','3','11','4','2023');

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Zootropolis','Zootropolis, a modern emlősök fővárosa, különleges hely. Olyan részekből áll, mint az elegáns Szahara tér vagy a zord Tundraváros. Ebben a színes kavalkádban a világ minden tájáról származó állatok élnek egymás mellett békében. Itt nem számít ki vagy, a legnagyobb elefánt és a legkisebb mókuscickány is megfér egymással. Amikor megérkezik a városba Judy Hopps, a zöldfülű rendőr, rá kell, hogy ébredjen, nem egyszerű feladat első nyuszinak lenni a nagy és erős állatokkal telezsúfolt rendőrségen. Judy azonban elszántan bizonyítani akar, ezért ugrik az első lehetőségre, hogy a végére járjon egy ügynek, még ha ez azt is jelenti, hogy együtt kell dolgoznia a gyors észjárású szélhámos rókával, Nick Wilde-dal.','108','10.jpg','8','10','1','2016');

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Harry Potter és a Félvér Herceg','Roxfort körül egyre szaporodnak az árnyak. Pedig a hatodik osztályba lépő Harry Potter és barátai számára a Boszorkány- és Varázslóképző Szakiskola mindennapjai is bőven elég izgalmat jelentenek nekik: Harry különleges titkokat hordozó bájital tankönyve, Ron barátnője és Hermione szerelme is épp elég titokzatos és ijesztő. De Harrynek egyre több oka van a félelemre. A halálfalók már mindenütt ott vannak, a dementortámadások szaporodnak, és az iskola fölött megjelenik a Sötét Jegy. Dumbledore abban reménykedik, hogy védence megerősödhet, ha jobban megismeri a múltját. De van veszély, amelyre ő sem készülhet fel.','153','11.jpg','9','6','3','2009');

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Drágán add az életed!','John McClane nyomozó New Yorkból Los Angelesbe tart, hogy rendbehozza házasságát. Még csak nem is sejti, hogy rajta kívül még mások is nagy dobásra készülnek Los Angelesben, méghozzá éppen a szeretet ünnepén. Terroristák egy csapata a hidegvérű Hans Gruber vezényletével ugyanis arra készül, hogy megszabadítsa a multinacionális Nakatomi céget több száz milliónyi kötvényétől.John McClane felesége, Holly pedig a Nakatominál dolgozik és munkatársaival éppen a karácsonyi mulatságon ünnepli meg a cég eddigi történetének legsikeresebb esztendejét. McClane türelmesen vár arra, hogy a munkahelyi buli véget érjen, miközben a terroristák gond nélkül behatolnak a szinte üres épületbe, túszul ejtik a Nakatomi cég dolgozóit. A 34 emeletes épületben megkezdődik a macska-egér harc.','131','12.jpg','11','1','4','1988');

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Dűne: Második rész','A távoli jövőben, a bolygóközi királyságok korában játszódó történetben két nagyhatalmú uralkodóház harcol az Arrakis bolygó feletti hatalomért, mert az ismert univerzumban egyedül az itteni végtelen sivatagban bányászható az a fűszer, amely lehetővé teszi a csillagközi utazást.A Harkonnenek ura kiirtatta az Atreides családot. De Paul Atreides herceg (Timothée Chalamet) megmenekült: a pusztaságban bujkál egy titokzatos, nomád nép, a fremenek között, ahol megismerkedik egy lánnyal, Csanival (Zendaya). Az a sorsa, hogy bosszút álljon a családjáért, háborúba vezesse a hozzá hű seregeket. Döntenie kell, hogy élete nagy szerelmét választja-e, vagy beteljesíti a végzetét.Az univerzum sorsa múlik azon, hogy mit határoz: és végül olyan útra lép, amely megváltoztathatja azt a szörnyű jövőt, amelyet egyedül ő lát előre.','166','13.jpg','5','5','4','2024');

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Hamilton','Amerika egyik alapító atyja és első pénzügyminisztere, Alexander Hamilton életéről szól ez a musical. Élőben a Broadway-ről, a Richard Rodgers Színházban felvéve, az eredeti szereplőgárdával.','160','14.jpg','10','12','3','2020');

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Gru 3','Gru, aki már visszavonult és letett a gonosz pályafutásáról, apaként próbálja nevelni három fogadott lányát Dr Senkiházival és minyonok seregével. Az élet azonban újfent próbatétel elé állítja, de szerencsére ott van vele újdonsült felesége is. Vajon letudják küzdeni a közelgő gonoszt és a hétköznapi problémákat?','90','15.jpg','12','10','2','2017');

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Taylor Swift: The Eras Tour','Ami idén a filmeknél a Barbenheimer volt, az a zenében Taylor Swift lett. Világszerterajongók milliói kezdtek áradozni a közösségi médiában a The Eras Tourról, külső szemmel érthetetlen mértékű hype-ot generálva. A „Swiftie”-k persze pontosan tudják miért is különleges. Ez Taylor karrierjének legnagyobb turnéja, amely idén márciustól jövő novemberig 5 kontinensen 146 fellépést fed le stadionokban megtartva. A cím arra utal, hogy ezzel pályafutása összes érájának és albumának emléket állít – picit több, mint 3 órába belezsúfolva 44 dalt, 10 felvonásban, melyek mind 1-1 lemezt szimbolizálnak. A film picit vágottan, 165 percben dokumentálja az inglewoodi SoFi Stadiumban tartott első három előadást augusztus elejéről, Los Angeles körzetéből.','170','16.jpg','13','13','3','2023');

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Eredet','A profi tolvaj mindent el tud lopni. Minél nagyobb mester a szakmájában, annál kevésbé lehet előtte akadály. Dom Cobb a legjobbak között is az első: ő mások álmait szerzi meg. Amikor áldozata éjszaka az álomfázisba jut, ő belopózik, és a legnagyobb értékekkel távozik. E tudás tette Cobbot az ipari kémkedés legkeresettebb bűnözőjévé és örökké menekülő, magányos férfivá. És most kap egy esélyt, hogy helyrehozza az összes régi hibáját, és visszaszerezze az elveszett életét. Ehhez nem lopnia kell, hanem profi bandája segítségével visszatérnie az eredethez, és egy gondolatot elültetni valakinek a fejében. Ez lesz a tökéletes bűntény. De a legjobb tervet is keresztülhúzhatja, ha a kiszemelt áldozat maga is profi. Aki olyan veszélyes, amilyenről Cobb még csak nem is álmodott.','148','17.jpg','3','4','4','2010');

INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('Büszkeség és balítélet','Anglia a 18. század végén. A Bennet család élete felbolydul, amikor a közelükbe költözik Mr. Bingley, a tehetős agglegény. A férfi barátai között ugyanis biztosan bőven akad majd kérő mind az öt Bennet lány számára. Jane, a legidősebb nővér azon fáradozik, hogy meghódítsa Mr. Bingley szívét, míg a vadóc Lizzie a jóképű és dölyfös Mr. Darcyval ismerkedik meg, kirobbantva ezzel a nemek háborúját. Amikor Mr. Bingley váratlanul Londonba utazik, magára hagyva a kétségbeesett Jane-t, Lizzie Mr. Darcy-t teszi felelőssé a szakításért.','129','18.jpg','14','8','3','2005');

INSERT INTO `terem`(`id`, `ferohely`) VALUES (1,100);
INSERT INTO `terem`(`id`, `ferohely`) VALUES (2,60);
INSERT INTO `terem`(`id`, `ferohely`) VALUES (3,40);
INSERT INTO `terem`(`id`, `ferohely`) VALUES (4,70);

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-04-09','11:00:00',1);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-04-09','14:00:00',2);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (12,'2025-04-09','16:00:00',3);

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-04-16','11:00:00',1);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-04-16','14:00:00',2);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-04-16','15:00:00',4);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-04-16','18:00:00',2);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (12,'2025-04-16','20:00:00',3);

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-04-23','10:00:00',1);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-04-23','11:00:00',4);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (12,'2025-04-23','15:45:00',2);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (12,'2025-04-23','18:00:00',3);

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (12,'2025-04-30','10:00:00',1);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-04-30','11:20:00',4);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-04-30','15:00:00',2);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-04-30','18:00:00',3);

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-05-07','11:20:00',4);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-05-07','11:00:00',3);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (12,'2025-05-07','15:40:00',1);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-05-07','18:05:00',3);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-05-07','18:30:00',4);

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-05-14','11:20:00',4);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (12,'2025-05-14','11:00:00',3);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-05-14','15:40:00',1);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-05-14','18:05:00',3);

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-05-21','10:10:00',4);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-05-21','11:30:00',3);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (12,'2025-05-21','15:40:00',1);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-05-21','18:05:00',3);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-05-21','18:30:00',4);

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-05-28','12:20:00',4);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (12,'2025-05-28','11:00:00',3);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-05-28','16:40:00',1);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-05-28','18:05:00',3);

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (12,'2025-06-04','10:20:00',1);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-06-04','11:00:00',3);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (12,'2025-06-04','15:40:00',2);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-06-04','18:05:00',3);

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (12,'2025-06-11','10:00:00',1);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-06-11','11:20:00',4);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-06-11','11:50:00',3);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (12,'2025-06-11','16:00:00',2);
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-06-11','18:00:00',3);


INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-04-10','10:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-04-10','12:20:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-04-10','18:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (16,'2025-04-10','20:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-04-11','11:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (13,'2025-04-11','12:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (15,'2025-04-11','16:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (17,'2025-04-11','18:50:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-04-11','16:30:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (3,'2025-04-11','19:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-04-12','10:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-04-12','10:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (14,'2025-04-12','13:05:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-04-12','14:50:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (13,'2025-04-12','15:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (11,'2025-04-12','21:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (2,'2025-04-13','12:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (4,'2025-04-13','14:35:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (18,'2025-04-13','15:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (11,'2025-04-13','18:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (18,'2025-04-14','10:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (17,'2025-04-14','11:05:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (16,'2025-04-14','12:10:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-04-14','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (3,'2025-04-14','19:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-04-15','10:30:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-04-15','12:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-04-15','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-04-15','17:00:00','4');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-04-17','10:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-04-17','12:20:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-04-17','18:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (16,'2025-04-17','20:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-04-18','11:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-04-18','12:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (15,'2025-04-18','16:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (18,'2025-04-18','18:50:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-04-18','16:30:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (3,'2025-04-18','19:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (15,'2025-04-19','10:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-04-19','10:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (14,'2025-04-19','13:05:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-04-19','15:50:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (13,'2025-04-19','15:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (11,'2025-04-19','21:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-04-20','12:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-04-20','11:35:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-04-20','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (17,'2025-04-20','18:05:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (2,'2025-04-21','10:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (4,'2025-04-21','11:05:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (14,'2025-04-21','12:10:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (17,'2025-04-21','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (3,'2025-04-21','19:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-04-22','10:30:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-04-22','11:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-04-22','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-04-22','19:00:00','4');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (18,'2025-04-24','14:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-04-24','20:00:00','3');


INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-04-25','10:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (14,'2025-04-25','12:20:00','1');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-04-26','18:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (16,'2025-04-26','20:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-04-27','11:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (13,'2025-04-27','12:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (15,'2025-04-27','16:45:00','3');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (17,'2025-04-28','18:50:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-04-28','16:30:00','4');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-04-29','19:30:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-04-29','10:00:00','2');


INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-01 ','10:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (18,'2025-05-01 ','11:20:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-05-01 ','18:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (13,'2025-05-01 ','19:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-02 ','11:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-05-02 ','16:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-02 ','18:50:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-02 ','16:30:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (3,'2025-05-02 ','19:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (2,'2025-05-03 ','10:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (14,'2025-05-03 ','10:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (3,'2025-05-03 ','13:05:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-03 ','14:50:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-05-03 ','15:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (11,'2025-05-03 ','20:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (2,'2025-05-04 ','12:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-05-04 ','14:35:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-04 ','15:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (16,'2025-05-04 ','18:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-05 ','11:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-05 ','11:05:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (4,'2025-05-05 ','12:10:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-05 ','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-05 ','19:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (3,'2025-05-06 ','10:05:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-05-06 ','11:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (16,'2025-05-06','13:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-06 ','20:00:00','1');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (3,'2025-05-08','12:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-05-08','14:35:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-08','15:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (16,'2025-05-08','18:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-09','11:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-09','11:05:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (13,'2025-05-09','12:10:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-09','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-09','19:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-10','10:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-10','12:20:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-05-10','18:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (16,'2025-05-10','20:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-11','11:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (13,'2025-05-11','12:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (15,'2025-05-11','16:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (17,'2025-05-11','18:50:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-11','16:30:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (3,'2025-05-11','19:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-12','10:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-05-12','10:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (14,'2025-05-12','13:05:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-12','14:50:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (13,'2025-05-12','15:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (11,'2025-05-12','21:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (2,'2025-05-13','12:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (4,'2025-05-13','14:35:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (18,'2025-05-13','15:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (11,'2025-05-13','18:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-15','10:30:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2024-5-15','12:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-05-15','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-15','17:00:00','4');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-17','10:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-17','12:20:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-05-17','18:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (16,'2025-05-17','20:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-18','11:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-18','12:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (15,'2025-05-18','16:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (18,'2025-05-18','18:50:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-18','16:30:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (3,'2025-05-18','19:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (15,'2025-05-19','10:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-05-19','10:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (14,'2025-05-19','13:05:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-19','15:50:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (13,'2025-05-19','15:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (11,'2025-05-19','21:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-20','12:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-20','11:35:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-20','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (17,'2025-05-20','18:05:00','2');


INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-22','10:30:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-05-22','11:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-05-22','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-22','19:00:00','4');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (15,'2025-05-23','11:20:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (18,'2025-05-23','14:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-05-23','20:00:00','3');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (2,'2025-05-24','12:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (11,'2025-05-24','11:35:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-24','17:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (17,'2025-05-24','18:05:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-25','10:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (14,'2025-05-25','12:20:00','1');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-05-26','18:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (16,'2025-05-26','20:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-27','11:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (13,'2025-05-27','12:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (15,'2025-05-27','16:45:00','3');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (17,'2025-05-28','18:50:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-28','16:30:00','4');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-29','19:30:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-29','10:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (16,'2025-05-29','11:30:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-29','10:40:00','3');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-30','11:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-30','11:05:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (17,'2025-05-30','12:10:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-05-30','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (13,'2025-05-30','19:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (13,'2025-05-31','10:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-05-31','11:05:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (4,'2025-05-31','12:10:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (2,'2025-05-31','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-05-31','19:00:00','2');



INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-06-01 ','10:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-06-01 ','12:20:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-06-01 ','18:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-06-01 ','20:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-06-02 ','11:20:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (5,'2025-06-02 ','12:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-06-02 ','16:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-06-02 ','18:50:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-06-02 ','16:30:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (3,'2025-06-02 ','19:30:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (2,'2025-06-03 ','10:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-06-03 ','10:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (3,'2025-06-03 ','13:05:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-06-03 ','14:50:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-06-03 ','15:45:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (11,'2025-06-03 ','21:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (2,'2025-06-04 ','12:00:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (6,'2025-06-04 ','14:35:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-06-04 ','15:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (11,'2025-06-04 ','18:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-06-05 ','10:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-06-05 ','11:05:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (4,'2025-06-05 ','12:10:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (7,'2025-06-05 ','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-06-05 ','19:00:00','2');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (3,'2025-06-06 ','10:05:00','4');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-06-06 ','11:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (11,'2025-06-06','13:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-06-06 ','20:00:00','1');

INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (8,'2025-06-07 ','10:30:00','2');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (9,'2025-06-07 ','12:00:00','1');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (10,'2025-06-07 ','16:50:00','3');
INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES (1,'2025-06-07 ','17:00:00','4');


INSERT INTO `arazas`(`id`, `kategoria`, `ar`) VALUES (1,'Kedvezményes (diák, nyugdíjas)',2000);
INSERT INTO `arazas`(`id`, `kategoria`, `ar`) VALUES (2,'Teljes árú',2300);

INSERT INTO `foglalas`(`felhasznaloId`, `vetitesId`,`datum`,`szekszam`, `jegytipus`) VALUES (1,3,'2025-04-17 11:07:51',5,1);
INSERT INTO `foglalas`(`felhasznaloId`, `vetitesId`,`datum`, `szekszam`, `jegytipus`) VALUES (1,21,'2025-04-30 18:30:05',12,2);
INSERT INTO `foglalas`(`felhasznaloId`, `vetitesId`,`datum`, `szekszam`, `jegytipus`) VALUES (1,256,'2025-05-25 12:03:42',22,1);
INSERT INTO `foglalas`(`felhasznaloId`, `vetitesId`,`datum`, `szekszam`, `jegytipus`) VALUES (1,197,'2025-05-11 16:12:14',3,2);
INSERT INTO `foglalas`(`felhasznaloId`, `vetitesId`,`datum`, `szekszam`, `jegytipus`) VALUES (1,165,'2025-05-08 21:08:53',9,1);
