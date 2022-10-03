
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table course_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `course_groups`;

CREATE TABLE `course_groups` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `course_groups` WRITE;
/*!40000 ALTER TABLE `course_groups` DISABLE KEYS */;

INSERT INTO `course_groups` (`id`, `name`)
VALUES
	(1,'Business & Communication'),
	(2,'Applied Information Technology'),
	(3,'Creative Design & Development'),
	(4,'Computer Programming'),
	(5,'Workplace Learning');

/*!40000 ALTER TABLE `course_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table courses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `courses`;

CREATE TABLE `courses` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `name_short` varchar(64) DEFAULT NULL,
  `description` text,
  `image` varchar(128) DEFAULT NULL,
  `course_group_id` int DEFAULT NULL,
  `period` int DEFAULT NULL,
  `year` int DEFAULT NULL,
  `teacher_short` varchar(5) DEFAULT NULL,
  `credits` int DEFAULT NULL,
  `website` varchar(128) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;

INSERT INTO `courses` (`id`, `name`, `name_short`, `description`, `image`, `course_group_id`, `period`, `year`, `teacher_short`, `credits`, `website`, `updated_at`, `created_at`)
VALUES
	(1,'Programming 1: Essentials','Programmeren 1','In het opleidingsonderdeel Programming 1: Essentials leren we de basis van de programmeertaal JavaScript. Ter voorbereiding van het volgende college doorloop je een aantal LinkenIn Learning video tutorials op eigen tempo. Op deze manier kan je het college goed volgen, antwoorden op gestelde vragen en taken succesvol realiseren.\n\nJe leert eerst programmeren met als output het console venster, vervolgens leren we programmeren door visuals in de browser te genereren (via de Canvas API) en tenslotte zullen we webpagina’s manipuleren en interactief maken via JavaScript.\n\nDe Computer Programming leerlijn is de fundamentele leerlijn binnen Graduaat Programmeren. We leiden je op als een echte goede JavaScript programmeur en Front-End Developer.\n\n#','pgm1.jpg',4,1,1,'PDP',6,'https://www.pgm.gent/pgm-1/',NULL,'2022-09-28 18:40:20'),
	(2,'Programming 2: Intermediate','Programmeren 2','De kennis verworven bij de vakken Programming 1: Essentials en Web Design wordt uitgebreid met o.a. externe data inladen en vervolgens consumeren, formulieren valideren, werken met template systemen, objectgeoriënteerd programmeren, project automatiseren …','pgm2.jpg',4,2,1,'MDP',6,'https://www.pgm.gent/pgm-2/',NULL,'2022-09-28 18:40:20'),
	(3,'@work 1','@work 1','De kennis verworven bij de vakken Programming 1: Essentials, Web Design en Computer Systems wordt toegepast tijdens de realisatie van één of meerdere concrete cases.','at-work1.jpg',5,2,1,'PDP',6,'https://www.pgm.gent/at-work-1',NULL,'2022-09-28 18:40:20'),
	(4,'User Interface Design','UI Design','<div class=\"theme-default-content content__default\"><h1 id=\"ui-versus-ux\"><a href=\"#ui-versus-ux\" class=\"header-anchor\">#</a> <abbr title=\"User Interface\">UI</abbr> versus <abbr title=\"User Experience\">UX</abbr></h1> <h2 id=\"wat-is-ui\"><a href=\"#wat-is-ui\" class=\"header-anchor\">#</a> Wat is <abbr title=\"User Interface\">UI</abbr>?</h2> <p><abbr title=\"User Interface\">UI</abbr> staat voor <em>User Interface</em> (Ned. gebruikersinterface). En gaat over de mogelijke interactie die een gebruiker kan hebben met een computer (<abbr title=\"Human-Computer Interaction\">HCI</abbr>).</p> <p>Een goede interactie ontstaat wanneer:</p> <ol><li>de gebruiker (human) iets aan de computer doorgeeft (<strong>input</strong>);</li> <li>de computer deze input begrijpt en aan de slag gaat en met deze input;</li> <li>de computer een resultaat formuleert en terug geeft aan de gebruiker (<strong>output</strong>);</li> <li>de gebruiker (human) dit resultaat begrijpt.</li></ol> <p>Er zijn heel wat soorten en vormen van gebruikersinterfaces, met daarbij nog eens verschillende input- en output mogelijkheden.</p> <p>De eerste interactie die de gebruiker kon hebben met een computer was aan de hand van ponskaarten. Hierop stond data die begrepen kon worden door een computer. Later kon men rechtstreeks op de computer instructies ingeven in een commandoprompt (cmd / terminal) via een toetsenbord. Het resultaat wordt in de meeste gevallen op een scherm getoond.</p> <p><img src=\"/ui-design/images/content/punchcard.jpg\" alt=\"ponskaart\" title=\"Ponskaart input\"></p> <h3 id=\"gui\"><a href=\"#gui\" class=\"header-anchor\">#</a> <abbr title=\"Graphical User Interface\">GUI</abbr></h3> <p><abbr title=\"Graphical User Interface\">GUI</abbr> staat dan weer voor <em>Graphical User Interface</em> en gaat specifiek over de grafische weergave van een gebruikersinterface. De eerste computer met <abbr title=\"Graphical User Interface\">GUI</abbr> kwam in 1980 op de markt door Xerox. Een gebruiker kon nu interactie hebben met een computer aan de hand van knoppen, iconen, links, menu’s …</p> <iframe src=\"https://www.youtube.com/embed/6o5I20WcNUM\" width=\"560\" height=\"315\" allowfullscreen=\"allowfullscreen\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\"></iframe> <h3 id=\"andere-vormen-van-ui\"><a href=\"#andere-vormen-van-ui\" class=\"header-anchor\">#</a> Andere vormen van <abbr title=\"User Interface\">UI</abbr></h3> <p>Momenteel hebben we als gebruikers ook reeds interactie met een computer via een <abbr title=\"Voice User Interface\">VUI</abbr>. Denk maar aan de komst van Siri in Apple HomePod, Alexa en de Google Home speakers.</p> <p>Ook kunnen we via Gestural <abbr title=\"User Interface\">UI</abbr> interactie hebben (Gesture = gebaar). Voorbeelden hiervan zijn de Xbox kinect.</p> <iframe src=\"https://www.youtube.com/embed/QjjkqBLRALo\" width=\"560\" height=\"315\" allowfullscreen=\"allowfullscreen\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\"></iframe> <h3 id=\"toekomst\"><a href=\"#toekomst\" class=\"header-anchor\">#</a> Toekomst</h3> <p>In de (nabije) toekomst zullen er nog meer manieren van interactie bijkomen. Dan denken we bijvoorbeeld aan interactie via …</p> <ul><li>het samentrekken van spieren (bionische arm);</li> <li>het interpreteren van de emotie van een gebruiker (aan de hand van gezicht en emotie herkenning);</li> <li>hersenactiviteit (Brain-computer interface of <abbr title=\"Brain-Computer Interface\">BCI</abbr>);</li> <li>…</li></ul> <h2 id=\"wat-is-ux\"><a href=\"#wat-is-ux\" class=\"header-anchor\">#</a> Wat is <abbr title=\"User Experience\">UX</abbr>?</h2> <p>Er zijn heel wat delen binnen het <abbr title=\"Human-Computer Interaction\">HCI</abbr>-process waar een foute interpretatie kan zijn van input, output … die dan frustratie opwekken bij de gebruiker. Wat dus een slechte <abbr title=\"User Experience\">UX</abbr> is.</p> <p>De <strong>User Experience</strong> (<abbr title=\"User Experience\">UX</abbr>) gaan dus over de gebruikersbeleving. Hoe ervaart de gebruiker de interactie met een product of dienst. Op zich staat dit los van de <abbr title=\"Human-Computer Interaction\">HCI</abbr>. Je kan bijvoorbeeld ook een goede gebruikersbeleving hebben met de infobalie van een gemeente.</p> <h2 id=\"ux-designer-vs-ui-designer\"><a href=\"#ux-designer-vs-ui-designer\" class=\"header-anchor\">#</a> <abbr title=\"User Experience\">UX</abbr> designer vs <abbr title=\"User Interface\">UI</abbr> designer</h2> <p>Een <abbr title=\"User Experience\">UX</abbr> designer is dus vooral bezit met het onderzoek naar wat de gebruiker wil bereiken en hoe dit op een zo efficiënt mogelijke manier kan.</p> <p>Een <abbr title=\"User Interface\">UI</abbr> designer ontwerp dus de interface. Bij een webdesigner gaat het dus over het grafisch ontwerp van de website</p> <p>In dit vak gaan we leren om een gebruiksvriendelijke <abbr title=\"User Interface\">UI</abbr> te maken met een goede <abbr title=\"User Experience\">UX</abbr>. Indien deze <abbr title=\"User Interface\">UI</abbr> dan ook nog eens mooi is qua design. Dan kan dit de <abbr title=\"User Experience\">UX</abbr> alleen maar verhogen.</p></div>','uidesign.jpg',3,2,1,'DDW',6,NULL,NULL,'2022-09-28 18:40:20'),
	(5,'Programming 3: Front-End Expert ','Programmeren 3',NULL,'pgm3.jpg',4,3,1,'FRG',6,NULL,NULL,'2022-09-28 18:40:20'),
	(6,'Datamanagement met PHP en MySQL','Datamangement','In deze cursus leren jullie back-end development aan de hand van PHP en MySQL. Nog steeds een veel gebruikte technologie in webdevelopment.','datamangement.jpg',2,1,2,'DDW',6,'https://github.com/pgmgent/datamanagment_2022_23',NULL,'2022-09-28 18:40:20'),
	(7,'Computer Systems','Computer Systems',NULL,NULL,2,1,1,'AGB',6,NULL,NULL,'2022-09-28 18:40:20'),
	(8,'Web Design','Web Design',NULL,NULL,3,1,1,'EVR',6,NULL,NULL,'2022-09-28 18:40:20'),
	(9,'IT Communication','IT Communication',NULL,NULL,1,3,1,'CGR',3,NULL,NULL,'2022-09-28 18:40:20'),
	(10,'IT Business','IT Business',NULL,NULL,1,4,1,'CGR',3,NULL,NULL,'2022-09-28 18:40:20'),
	(11,'User Interface Prototyping','User Interface Prototyping',NULL,NULL,3,3,1,'MVP',6,NULL,NULL,'2022-09-28 18:40:20'),
	(12,'Programming 4','Programming 4',NULL,NULL,4,4,1,'AGB',6,NULL,NULL,'2022-09-28 18:40:20'),
	(13,'@Work 2','@work 2',NULL,NULL,5,4,1,'EVR',6,NULL,NULL,'2022-09-28 18:40:20'),
	(14,'Digital Marketing','Digital Marketing',NULL,NULL,1,1,2,NULL,3,NULL,NULL,'2022-09-28 18:40:20'),
	(15,'Programming 5','Programming 5',NULL,NULL,4,1,2,'TDP',6,NULL,NULL,'2022-09-28 18:40:20'),
	(16,'Content Management','Content Management',NULL,NULL,2,2,2,'AGB',6,NULL,NULL,'2022-09-28 18:40:20'),
	(17,'Programming 6','Programming 6',NULL,NULL,4,2,2,NULL,6,NULL,NULL,'2022-09-28 18:40:20'),
	(18,'@Work 3','@Work 3',NULL,NULL,5,2,2,'TDP',6,NULL,NULL,'2022-09-28 18:40:20'),
	(19,'IT Exploration','IT Exploration',NULL,NULL,2,3,2,'EVR',3,NULL,NULL,'2022-09-28 18:40:20'),
	(20,'@Work 4','@Work 4',NULL,NULL,5,3,2,'PDP',15,NULL,NULL,'2022-09-28 18:40:20'),
	(21,'IT Entrepreneurship','IT Entrepreneurship',NULL,NULL,1,4,2,NULL,3,NULL,NULL,'2022-09-28 18:40:20'),
	(22,'@Work 5','@Work 5',NULL,NULL,5,4,2,'MVP',9,NULL,NULL,'2022-09-28 18:40:20');

/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table teachers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `teachers`;

CREATE TABLE `teachers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(64) DEFAULT NULL,
  `lastname` varchar(64) DEFAULT NULL,
  `short_name` varchar(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;

INSERT INTO `teachers` (`id`, `firstname`, `lastname`, `short_name`, `created_at`, `updated_at`)
VALUES
	(1,'Dieter','De Weirdt','DDW',NULL,NULL),
	(2,'Evelien','Rutsaert','EVR',NULL,NULL),
	(3,'Tim','De Paepe','TDP',NULL,NULL),
	(4,'Claire','Geeraerts','CGR',NULL,NULL),
	(5,'Frederick','Roegiers','FRG',NULL,NULL),
	(6,'Mathieu','Spillebeen','MSL',NULL,NULL),
	(7,'Adriaan','Gilbert','AGB',NULL,NULL),
	(8,'Michael','Vanderpoorten','MVD',NULL,NULL),
	(9,'Philippe','De Pauw - Waterschoot','PDP',NULL,NULL),
	(10,'Olivier','Parent','OPR',NULL,NULL);

/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
