-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : db.3wa.io
-- Généré le : mar. 28 mai 2024 à 10:57
-- Version du serveur :  5.7.33-0ubuntu0.18.04.1-log
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ryanroudaut_projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `stock` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `ingredients` text NOT NULL,
  `age` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `name`, `price`, `stock`, `category_id`, `image_id`, `description`, `ingredients`, `age`, `short_description`, `slug`) VALUES
(1, 'Wolf of Wilderness Adult Wild Hills - 12kg canard', 59.99, 11, 1, 2, '<h2>Le loup chasse le canard en se promenant dans les collines sauvages.</h2>\r\n<h3>Wolf of Wilderness - Wild Hills</h3>\r\n<p>Les croquettes Wolf of Wilderness constituent une nourriture adaptée pour chien, inspirée de l\'alimentation naturelle du loup à l\'état sauvage. Principalement composées de viande, ces recettes sans céréales contiennent aussi des baies, des racines et des herbes sauvages. Wolf of Wilderness – sauvage, libre et authentique !</p></br>\r\n\r\n<h3>Caractéristiques des croquettes Wolf of Wilderness \"Wild Hills\" pour chien :</h3>\r\n\r\n<ul>\r\n  <li>S\'inspirent de l\'alimentation naturelle du loup à l\'état sauvage : pour les chiens adultes de toutes les races et tailles</li>\r\n  <li>Recette sans céréales : recette également adaptée aux chiens souffrant d\'intolérances aux céréales</li>\r\n  <li>Protéines animales de qualité : au moins 40 % de viande fraîche de poulet (viande musculaire) et des protéines de canard</li>\r\n  <li>Naturelles et adaptées aux besoins des animaux : sans conservateurs, colorants ni arômes artificiels</li>\r\n  <li>Une nourriture sauvage et authentique : agrémentée de fruits des bois, de racines et d\'herbes sauvages</li>\r\n  <li>Qualité premium : nourriture produite dans une entreprise familiale</li>\r\n</ul>\r\n', '<ul>\r\n  <li>Viande fraîche de poulet (41 %)</li>\r\n  <li>Morceaux de pommes de terre (déshydratées)</li>\r\n  <li>Protéine de canard (10 %, déshydratée)</li>\r\n  <li>Protéine de volaille (10 %, déshydratée et hydrolysée)</li>\r\n  <li>Pulpe de betterave déshydratée (désucrée)</li>\r\n  <li>Graines de lin</li>\r\n  <li>Graisse de volaille</li>\r\n  <li>Levure de bière (déshydratée)</li>\r\n  <li>Chlorure de sodium</li>\r\n  <li>Phosphate monocalcique</li>\r\n  <li>Œuf (déshydraté)</li>\r\n  <li>Fruits des bois (0,3 %, déshydratés : cranberries, groseille, framboise, baies de sureau)</li>\r\n  <li>Herbes (0,2 %, déshydratées : armoise, millepertuis, ortie, camomille, achillée, tussilage, racine de pissenlit)</li>\r\n  <li>Extrait de levure de bière (déshydratée, = 0,2 % β-glucane et mannane-oligosaccharides)</li>\r\n  <li>Pomme (déshydratée)</li>\r\n  <li>Inuline de chicorée (0,1 %)</li>\r\n  <li>Huile de saumon</li>\r\n  <li>Huile de tournesol</li>\r\n</ul>', 'Adulte', 'Croquettes premium sans céréales, à base de canard et 41 % de viande fraîche de poulet, basées sur l\'alimentation naturelle du loup à l\'état sauvage, fruits des bois, racines, herbes sauvages.', 'wolf-of-wilderness-adult-wild-hills-12kg-canard'),
(2, 'PURINA PRO PLAN Medium Adult Everyday Nutrition - 14kg poulet', 49.78, 3, 1, 3, '<h2>Offrez à votre chien des croquettes de grande qualité pour toutes les occasions !</h2>\r\n<p>L\'aliment PURINA PRO PLAN Medium Adult Everyday Nutrition (anciennement : OPTIBALANCE) offre tout ce dont un chien a besoin pour être en pleine forme. Votre chien va en outre adorer le bon goût de ces croquettes.</p>\r\n\r\n<p>Les croquettes PURINA PRO PLAN Medium Adult Everyday Nutrition sont exclusivement formulées à base des meilleurs morceaux de poulet comme source de protéines animales. Leur teneur élevée en protéines aide à préserver une masse musculaire svelte. À cela s\'ajoutent des acides gras oméga 3 essentiels, qui sont importants pour de nombreuses fonctions corporelles. Ces croquettes contiennent un mélange de nutriments adapté pour une assimilation optimale des substances vitales.</p></br>\r\n\r\n<h3>Caractéristiques des croquettes PURINA PRO PLAN Medium Adult Everyday Nutrition pour chien :</h3>\r\n<ul>\r\n  <li>Croquettes pour les chiens adultes (1 - 7 ans) de moyennes races (10-25 kg)</li>\r\n  <li>Riches en protéines : pour préserver une masse musculaire svelte</li>\r\n  <li>À base des meilleures ingrédients de poulet : source de protéines digestes et faciles à assimiler</li>\r\n  <li>Huile de poisson : source d\'acides gras oméga 3 essentiels, pour la peau et les articulations</li>\r\n  <li>Vitamine D : aide à préserver les os et les dents</li>\r\n  <li>Mélange de nutriments optimal : pour une assimilation optimale des nutriments</li>\r\n  <li>Taille des croquettes adaptée à la mâchoire des chiens de races moyennes</li>\r\n  <li>Sans colorants artificiels</li>\r\n  <li>Recette complète et équilibrée : avec des minéraux, vitamines et oligo-éléments</li>\r\n  <li>Développées par des vétérinaires et des nutritionnistes</li>\r\n</ul>', '<ul>\r\n  <li>Poulet de grande qualité (20 %, composés de dos et de poitrine)</li>\r\n  <li>Blé</li>\r\n  <li>Protéines de volaille déshydratées</li>\r\n  <li>Maïs</li>\r\n  <li>Riz (9 %)</li>\r\n  <li>Graisse animale</li>\r\n  <li>Pulpe de betterave déshydratée</li>\r\n  <li>Autolysat</li>\r\n  <li>Farine de soja</li>\r\n  <li>Farine de protéines de maïs</li>\r\n  <li>Gluten de blé</li>\r\n  <li>Minéraux</li>\r\n  <li>Œuf déshydraté</li>\r\n  <li>Huile de poisson</li>\r\n</ul>', 'Adulte', 'Croquettes équilibrées pour les chiens adultes (1-7 ans) de moyennes races (10-25 kg), riches en protéines, avec des acides gras oméga 3, mélange de nutriments optimal.', 'purina-pro-plan-medium-adult-everyday-nutrition-14kg-poulet'),
(3, 'PURINA PRO PLAN Large Robust Puppy Healthy Start pour chiot - 12kg poulet', 54.99, 19, 1, 1, '<h2>Les croquettes PURINA PRO PLAN Large Robust Puppy Healthy Start (anciennement OPTISTART)</h2>\r\n<p>ont été spécialement formulées pour répondre aux besoins nutritionnels des chiots de grandes races et de constitution robuste. Ces croquettes riches en protéines sont idéales pour les jeunes chiens qui ont besoin de moins de calories que leurs congénères à la corpulence moins robuste.</p>\r\n\r\n<p>Ces croquettes contiennent du poulet, qui leur confère non seulement un goût savoureux, mais qui est aussi riche en protéines de qualité, essentielles pour développer et préserver les muscles du chiot. La recette est enrichie en colostrum et en acides gras oméga 3 essentiels. Les croquettes PURINA PRO PLAN Large Robust Puppy Healthy Start possèdent une formule complète, idéale pour tous les jours.</p></br>\r\n\r\n<h3>Caractéristiques des croquettes PURINA PRO PLAN Large Robust Puppy Healthy Start pour chiot :</h3>\r\n<ul>\r\n  <li>Croquettes équilibrées pour les chiots de grandes races (à partir de 25 kg à l\'âge adulte) et de constitution robuste jusqu\'à 24 mois</li>\r\n  <li>Conviennent aussi pour les chiennes gestantes et allaitantes</li>\r\n  <li>Recette adaptée aux besoins des chiots de grandes races qui ont besoin de moins de calories que leurs congénères à la corpulence moins robuste</li>\r\n  <li>À base de délicieux poulet : source de protéines animales de qualité et digeste</li>\r\n  <li>Mélange spécifique de nutriments : contribue au bon développement du chiot</li>\r\n  <li>Enrichies en colostrum : contribue au fonctionnement normal du système immunitaire et de la digestion</li>\r\n  <li>Contribuent au bon développement du chiot : teneur élevée en protéines, riches en acides gras oméga 3, teneur calcium/phosphore adaptée</li>\r\n  <li>Riches en substances vitales : ajout de vitamines et de minéraux pour une alimentation équilibrée, la vitamine D contribue à préserver les os et les dents du chien</li>\r\n  <li>Aliment complet, idéal pour tous les jours</li>\r\n  <li>Sans colorants artificiels</li>\r\n  <li>Sachet refermable : fermeture zippée pour préserver la fraîcheur</li>\r\n</ul>', '<ul>\r\n  <li>Poulet de grande qualité (18 %, composés de dos et de poitrine)</li>\r\n  <li>Protéines de volaille déshydratées</li>\r\n  <li>Riz (15 %)</li>\r\n  <li>Blé</li>\r\n  <li>Farine de soja</li>\r\n  <li>Maïs</li>\r\n  <li>Graisse animale</li>\r\n  <li>Fibres de blé</li>\r\n  <li>Autolysat</li>\r\n  <li>Pulpe de betteraves déshydratée</li>\r\n  <li>Farine de protéines de maïs</li>\r\n  <li>Gluten de blé</li>\r\n  <li>Minéraux</li>\r\n  <li>Œuf déshydraté</li>\r\n  <li>Huile de poisson</li>\r\n  <li>Colostrum déshydraté (0,10 %)</li>\r\n</ul>', 'Adulte', 'Croquettes riches en protéines pour chiot de grande race et de constitution robuste jusqu\'à 24 mois, poulet comme ingrédient principal, riches en acides gras oméga, colostrum pour soutenir le système immunitaire.', 'purina-pro-plan-large-robust-puppy-healthy-start-pour-chiot-12kg-poulet'),
(4, 'Eukanuba Senior Large & Giant Breed, riz pour chien - 12kg agneau', 49.99, 3, 1, 4, '<h2>Les croquettes Eukanuba Senior Large & Giant Breed agneau & riz pour chien</h2>\r\n<p>Bien que votre chien ne fasse pas encore partie du troisième âge à 5 ou 6 ans, ses besoins nutritionnels évoluent tout de même au fil du temps. Pour lui permettre de rester en pleine forme pendant de longues années, il est nécessaire de lui offrir une nourriture qui soit parfaitement adaptée à ses besoins à chaque étape de sa vie. Les croquettes Eukanuba Senior Large & Giant Breed agneau & riz sont idéales pour les chiens âgés de grande et de très grande taille.</p>\r\n\r\n<p>100 % complètes et équilibrées, ces croquettes pour chien sont principalement formulées à base d\'agneau et de riz, des ingrédients digestes et faciles à assimiler. Leur recette contient également du curcuma, qui fournit des antioxydants naturels afin de contribuer au fonctionnement normal du système immunitaire. Les croquettes Eukanuba Senior Large & Giant Breed agneau & riz fournissent des acides gras oméga-3 et oméga-6 qui contribuent à la brillance du poil et qui aident à préserver une peau normale.</p></br>\r\n\r\n<h3>Caractéristiques des croquettes Eukanuba Senior Large & Giant Breed agneau, riz pour chien :</h3>\r\n<ul>\r\n  <li>Croquettes de qualité premium pour les chiens de grande taille (25 - 40 kg) à partir de 6 ans</li>\r\n  <li>Conviennent également aux chiens âgés de très grande taille (> 40 kg) à partir de 5 ans</li>\r\n  <li>Idéales pour les chiens âgés : recette équilibrée et adaptée aux besoins des chiens à un âge avancé</li>\r\n  <li>Riches en agneau et en riz : ingrédients principaux digestes</li>\r\n  <li>Avec de précieux acides gras : source naturelle d\'acides gras oméga-3 et oméga-6 qui peuvent être bénéfiques pour la peau et le pelage</li>\r\n  <li>Riches en fibres : mélange équilibré de prébiotiques (FOS), MOS et pulpe de betterave qui améliorent la fonction intestinale</li>\r\n  <li>Enrichies en curcuma : contient des antioxydants qui contribuent au fonctionnement normal du système immunitaire</li>\r\n  <li>Source de glucosamine et chondroïtine et de L-carnitine</li>\r\n  <li>Soins dentaires : croquettes de forme hexagonale spécifique, contribuent à nettoyer les dents en les frottant lors de la mastication</li>\r\n</ul>\r\n', '<ul>\r\n  <li>Poulet et dinde déshydratés</li>\r\n  <li>Agneau (14 %)</li>\r\n  <li>Riz (14 %)</li>\r\n  <li>Maïs</li>\r\n  <li>Millet</li>\r\n  <li>Orge</li>\r\n  <li>Graisse de porc</li>\r\n  <li>Farine de poisson</li>\r\n  <li>Pulpe de betterave déshydratée (2,6 %)</li>\r\n  <li>Jus de poulet</li>\r\n  <li>Œuf déshydraté</li>\r\n  <li>Minéraux (dont hexamétaphosphate de sodium 0,34 %)</li>\r\n  <li>Fructo-oligosaccharides (0,25 %)</li>\r\n  <li>Huile de poisson</li>\r\n  <li>Mannan-oligosaccharides (0,13 %)</li>\r\n  <li>Curcuma (0,1 %)</li>\r\n  <li>Levure de bière déshydratée</li>\r\n  <li>Glucosamine (provenant de tissu animal) (0,04 %)</li>\r\n  <li>Sulfate de chondroïtine (0,004 %)</li>\r\n</ul>\r\n', 'Senior', 'Nourriture premium fabriquée à partir d\'ingrédients de qualité supérieure.', 'eukanuba-senior-large-giant-breed-riz-pour-chien-12kg-agneau'),
(5, 'Wolf of Wilderness Adult Blue River - 12kg saumon', 59.99, 3, 1, 5, '<h2>Tapi au bord de la rivière bruissante, le loup pêche les saumons d\'eau froide.</h2>\r\n<h3>Wolf of Wilderness - Blue River</h3>\r\n\r\n<p>Les croquettes Wolf of Wilderness constituent une nourriture adaptée pour chien, inspirée de l\'alimentation naturelle du loup à l\'état sauvage. Principalement composées de viande, ces recettes sans céréales contiennent aussi des fruits des bois, des racines et des herbes sauvages. Wolf of Wilderness – sauvage, libre et authentique !</p></br>\r\n\r\n<h3>Caractéristiques des croquettes Wolf of Wilderness Blue River pour chien :</h3>\r\n<ul>\r\n  <li>S\'inspirent de l\'alimentation naturelle du loup à l\'état sauvage : pour les chiens adultes de toutes les races et tailles</li>\r\n  <li>Recette sans céréales : recette également adaptée aux chiens souffrant d\'intolérances aux céréales</li>\r\n  <li>Protéines animales de qualité : au moins 40 % de viande fraîche de poulet (viande musculaire) et des protéines d\'agneau</li>\r\n  <li>Naturelles et adaptées aux besoins des animaux : sans conservateurs, colorants ni arômes artificiels</li>\r\n  <li>Une nourriture sauvage et authentique : agrémentée de fruits des bois, de racines et d\'herbes sauvages</li>\r\n  <li>Qualité premium : nourriture produite dans une entreprise familiale</li>\r\n</ul>\r\n', '<ul>\r\n  <li>Poulet et dinde déshydratés</li>\r\n  <li>Agneau (14 %)</li>\r\n  <li>Riz (14 %)</li>\r\n  <li>Maïs</li>\r\n  <li>Millet</li>\r\n  <li>Orge</li>\r\n  <li>Graisse de porc</li>\r\n  <li>Farine de poisson</li>\r\n  <li>Pulpe de betterave déshydratée (2,6 %)</li>\r\n  <li>Jus de poulet</li>\r\n  <li>Œuf déshydraté</li>\r\n  <li>Minéraux (dont hexamétaphosphate de sodium 0,34 %)</li>\r\n  <li>Fructo-oligosaccharides (0,25 %)</li>\r\n  <li>Huile de poisson</li>\r\n  <li>Mannan-oligosaccharides (0,13 %)</li>\r\n  <li>Curcuma (0,1 %)</li>\r\n  <li>Levure de bière déshydratée</li>\r\n  <li>Glucosamine (provenant de tissu animal) (0,04 %)</li>\r\n  <li>Sulfate de chondroïtine (0,004 %)</li>\r\n</ul>', 'Adulte', 'Croquettes premium sans céréales, à base de saumon et 41 % de viande fraîche de poulet, basées sur l\'alimentation naturelle du loup à l\'état sauvage, avec fruits des bois, racines et herbes sauvages.', 'wolf-of-wilderness-adult-blue-river-12kg-saumon'),
(6, 'Carnilove Adult pour chien - 12kg saumon', 62.49, 3, 1, 6, '<p>Le système digestif du chien, qui trouve ses origines chez le loup, est habitué à une alimentation composée principalement de protéines animales mais aussi de fruits des bois, de légumes et de plantes. La recette des croquettes Carnilove Adult au saumon contient 45 % de saumon (dont 20 % de filet) et 10 % de hareng. Cet aliment équilibré à base de pommes, de petits pois, de carottes est riche en vitamines et en extraits de plantes et fournit aux chiens de grandes les nutriments dont ils ont besoin pour être en pleine forme. Sa recette ne contient pas de céréales, de pommes de terre, de maïs, de soja ni de riz. Les croquettes Carnilove Adult au saumon pour chien constituent un aliment de qualité premium parfaitement bien toléré en cas d\'allergies ou d\'intolérances alimentaires.</p></br>\r\n\r\n<p>Outre leur teneur élevée en nutriments essentiels, ces délicieuses croquettes sont riches en ingrédients qui sont bénéfiques pour la santé et le bien-être de votre chien. Leur recette contient de l\'huile de saumon riche en acides gras insaturés qui favorisent la santé de la peau et du pelage. La levure de bière et les racines de chicorée sont riches en agents prébiotiques et contribuent à l\'équilibre de la flore intestinale et favorisent l\'assimilation des substances vitales. Cet aliment contient aussi des cranberries, des mûres et des framboises, riches en vitamines et en antioxydants qui protègent contre les radicaux libres et aident à renforcer le système immunitaire. Les croquettes Carnilove Adult au saumon constituent donc un aliment complet qui contribue à la santé des chiens adultes.</p></br>\r\n<h3>Caractéristiques des croquettes Carnilove Adult saumon pour chien :</h3>\r\n<ul>\r\n  <li>Croquettes de qualité pour les chiens adultes de toutes les races</li>\r\n  <li>Conviennent aussi pour les chiens souffrant d\'allergies ou d\'intolérances alimentaires : recette sans céréales, pommes de terre, maïs, soja ni riz</li>\r\n  <li>Teneur élevée en poisson : adaptée aux besoins naturels du chien, avec 45 % de saumon (dont 20 de filet) et 10 % de hareng, fournit des protéines animales essentielles</li>\r\n  <li>Aliment complet et équilibré : teneur optimale en nutriments issus de protéines, de graisses, de glucides et de substances vitales</li>\r\n  <li>Fruits, légumes et plantes : contribuent au bien-être du chien</li>\r\n  <li>Favorisent la santé de la peau et du pelage : l\'huile de saumon et les graines de lin sont naturellement riches en acides gras oméga</li>\r\n  <li>Équilibre digestif : avec des prébiotiques issus de la levure de bière (sources de MOS), des racines de chicorée (sources de FOS) et du psyllium qui favorisent le système gastro-intestinal</li>\r\n  <li>Cranberries, myrtilles et framboises : riches en antioxydants et en vitamines, aident à protéger contre les radicaux libres et à renforcer le système immunitaire</li>\r\n  <li>Coquilles de crustacés hydrolysées & extrait de cartilage : sources naturelles de glucosamine et de chondroïtine, favorisent la santé des articulations</li>\r\n  <li>Mélange de substances vitales : teneur adaptée en vitamines, minéraux et oligo-éléments</li>\r\n  <li>Extrait de yucca schidigera : aide à réduire les odeurs de selles</li>\r\n  <li>Grande appétence : recette savoureuse riche en viande</li>\r\n</ul>', '<ul>\r\n  <li>Farine de saumon (25 %)</li>\r\n  <li>Pois jaunes (20 %)</li>\r\n  <li>Farine de hareng (10 %)</li>\r\n  <li>Graisse de poulet (conservée avec des tocophérols) (9 %)</li>\r\n  <li>Foie de poulet (3 %)</li>\r\n  <li>Pommes (3 %)</li>\r\n  <li>Amidon de manioc (3 %)</li>\r\n  <li>Huile de saumon (3 %)</li>\r\n  <li>Carottes (1 %)</li>\r\n  <li>Graines de lin (1 %)</li>\r\n  <li>Pois chiches (1 %)</li>\r\n  <li>Coquilles de crustacés hydrolysées (source de glucosamine) (0,026 %)</li>\r\n  <li>Extrait de cartilage (source de chondroïtine) (0,016 %)</li>\r\n  <li>Levure de bière (source de mannanes-oligosaccharides) (0,015 %)</li>\r\n  <li>Racines de chicorée (source de fructo-oligosaccharides) (0,01 %)</li>\r\n  <li>Yucca schidigera (0,01 %)</li>\r\n  <li>Algues (0,01 %)</li>\r\n  <li>Psyllium (0,01 %)</li>\r\n  <li>Thym (0,01 %)</li>\r\n  <li>Romarin (0,01 %)</li>\r\n  <li>Origan (0,01 %)</li>\r\n  <li>Cranberries (0,0008 %)</li>\r\n  <li>Myrtilles (0,0008 %)</li>\r\n  <li>Framboises (0,0008 %)</li>\r\n</ul>', 'Adulte', 'Ces délicieuses croquettes sont riches en ingrédients qui sont bénéfiques pour la santé et le bien-être de votre chien.', 'carnilove-adult-pour-chien-12kg-saumon'),
(7, 'Royal Canin Medium Puppy pour chiot - 15kg', 78.49, 10, 1, 7, '<p>Les croquettes Royal Canin Medium Puppy ont été spécialement formulées pour répondre aux besoins des chiots de moyennes races (poids cible : 11 à 25 kg) de 2 à 12 mois. Leur recette contient des nutriments, comme des vitamines C et E, qui contribuent à renforcer le système immunitaire encore en développement des chiots.</p></br>\r\n\r\n<p>La présence d\'acides gras oméga 3 (par exemple DHA) favorise en outre le développement cérébral du chiot, tandis que l\'association de prébiotiques (FOS, MOS et pulpe de betterave) et de protéines digestes contribue à l\'équilibre de la flore intestinale et facilite la digestion.</p>\r\n\r\n<p>Enfin, la recette des croquettes Royal Canin Medium Puppy contient une teneur énergétique adaptée pour couvrir les besoins en calories des chiots de moyennes races.</p></br>\r\n<h3>Caractéristiques des croquettes Royal Canin Medium Puppy pour chiot :</h3>\r\n<ul>\r\n  <li>Croquettes pour les chiots de moyennes races (poids à l\'âge adulte : 11-25 kg) de 2 à 12 mois</li>\r\n  <li>Vitamines C & E : renforcent le système immunitaire</li>\r\n  <li>Acides gras oméga 3 : favorisent le bon développement cérébral</li>\r\n  <li>Favorisent l\'équilibre de la flore intestinale : l\'association de prébiotiques et de protéines digestes renforce le microbiote intestinal</li>\r\n  <li>Teneur énergétique optimisée : pour couvrir les besoins énergétiques élevés</li>\r\n  <li>Croquettes adaptées à la mâchoire des chiots de moyennes races</li>\r\n</ul>\r\n\r\n<p>La forme et la taille des croquettes favorisent la mastication et ralentissent le processus d\'absorption, augmentant ainsi le sentiment de satiété. L\'effet brossant mécanique favorise en outre l\'hygiène dentaire du chiot.</p>\r\n', '<ul>\r\n  <li>Protéines de volaille déshydratées</li>\r\n  <li>Graisse animale</li>\r\n  <li>Protéines de bœuf et de porc déshydratées</li>\r\n  <li>Maïs</li>\r\n  <li>Farine de blé</li>\r\n  <li>Pulpe de betterave déshydratée</li>\r\n  <li>Riz</li>\r\n  <li>Protéines animales hydrolysées</li>\r\n  <li>Farine de maïs</li>\r\n  <li>Blé</li>\r\n  <li>Gluten de maïs</li>\r\n  <li>Gluten de blé*</li>\r\n  <li>Minéraux</li>\r\n  <li>Huile de soja</li>\r\n  <li>Extraits de levures</li>\r\n  <li>Huile de poisson</li>\r\n  <li>Fructo-oligosaccharides</li>\r\n  <li>Levure hydrolysée (source de manno-oligosaccharides et de bêta-glucanes, 0,29 %)</li>\r\n  <li>Huile d\'algue Schizochytrium sp. (source de DHA)</li>\r\n  <li>Jus de yucca schidigera</li>\r\n  <li>Farine de roses d\'Inde</li>\r\n</ul>\r\n\r\n<p>* L.I.P. : protéines sélectionnées pour leur très haute assimilation.</p>\r\n', 'Chiot', 'Aliment complet pour les chiots de races moyennes (poids cible : de 11 à 25 kg) jusqu\'à 12 mois, teneur énergétique adaptée, croquettes adaptées, facilite la digestion.', 'royal-canin-medium-puppy-pour-chiot-15kg'),
(8, 'Sabots de veau et de bœuf pour chien - 400g', 3.99, 17, 2, 8, '<p>Les sabots de veau sont moins durs et plus petits que les sabots de bœuf et conviennent donc parfaitement aux chiens de petites et moyennes races qui ont un fort besoin de mastication. Les sabots de veau favorisent le nettoyage des dents. Avec seulement 1,7 % de matières grasses, ils constituent des friandises de qualité. Les sabots de veau ne contiennent pas de conservateurs, de colorants, ni d\'arômes et sont naturellement sans céréales ni sucres, ce qui vous permettra de récompenser votre chien sans avoir mauvaise conscience. Votre chien va prendre plaisir à mâcher ces sabots de veau pendant un long moment !</p></br>\r\n\r\n<h2>Voici des friandises idéales pour les chiens qui aiment mastiquer :</h2>\r\n\r\n<ul>\r\n  <li>50 % veau - 50 % bœuf</li>\r\n  <li>Peu de matières grasses</li>\r\n  <li>Pour les chiens au besoin accru de mastiquer</li>\r\n  <li>Très ferme - longue durée de mastication</li>\r\n  <li>Favorisent l\'hygiène bucco-dentaire</li>\r\n  <li>Sans conservateurs, colorants ni arômes</li>\r\n  <li>Naturellement sans sucres ni céréales</li>\r\n  <li>Intensité de l’odeur : 3 (sur une échelle de 1 à 5, 5 correspondant à une odeur très forte)</li>\r\n<li>Dimensions du produit (approximatives) : environ 10 - 12 cm de long et 5-8 cm de large. La couleur des sabots peut varier entre le beige clair et le noir.</li>\r\n<li>Dimensions de l\'emballage : H 32 x l 23 cm.</li>\r\n</ul></br>\r\n\r\n<h3>Faites confiance à la nature et surprenez votre chien avec ces friandises !</h3></br>\r\n<p>Les sabots de veau étant des friandises naturelles, leur taille et leur texture peuvent varier en fonction des lots.</p></br>\r\n\r\n<p>Ces friandises ne conviennent pas aux chiens qui ont tendance à avaler leur nourriture d\'un trait. Il est préférable dans ce cas de choisir des produits plus mous comme des oreilles, des poumons, du foie ou du nerf. Les sabots de veau étant un produit naturel, des petits éclats peuvent survenir au moment de la mastication. Veuillez les retirer avant de donner la friandise à votre chien et ne laissez jamais ce dernier sans surveillance.</p>\r\n', '<ul>\r\n<li>50 % veau - 50 % bœuf</li>\r\n</ul>', 'Indifférent', 'Friandises de qualité premium pour les chiens ayant un fort besoin de mastiquer, pauvres en matières grasses, favorisent le nettoyage des dents. Sans sucres, sans céréales.', 'sabots-de-veau-et-de-b-uf-pour-chien-400g'),
(9, 'Phil & Sons Pattes de poulet pour chien 5 pattes', 0.99, 22, 2, 9, '<p>Phil & Sons séduit naturellement :</br>\r\nUne grande variété d\'aliments à mâcher séchés, sans conservateurs, arômes ou colorants artificiels. De plus, toutes les friandises sont naturellement sans céréales ni gluten. Au total, sept sources de protéines différentes sont disponibles : bœuf, porc, volaille, cheval, gibier, agneau et poisson. Petits ou grands, Phil & Sons répond à tous les désirs de votre chien !</p>\r\n\r\n<p>Les pattes de poulet Phil & Sons font parties des friandises préférées des chiens et représentent un produit phare de notre gamme ! Croustillantes à souhait, elles offrent à tous les chiens un plaisir de mastication de courte à moyenne durée. Voilà une occupation idéale comme en-cas ou comme récompense !</p>\r\n\r\n<h2>Caractéristiques des pattes de poulet Phil & Sons pour chien :</h2>\r\n<ul>\r\n  <li>friandises monoprotéiques</li>\r\n  <li>sans conservateurs, arômes ou colorants artificiels</li>\r\n  <li>naturellement sans céréales ni gluten</li>\r\n  <li>plaisir de mastication de courte à moyenne durée</li>\r\n  <li>ne conviennent pas aux chiens ayant tendance à dévorer leur nourriture trop vite</li>\r\n</ul>\r\n', '<ul>\r\n<li>Pattes de poulet déshydratées</li>\r\n</ul>', 'Indifférent', 'Les oreilles de porc Phil & Sons font partie des friandises préférées des chiens ! Oreilles entières qui constituent de savoureuses friandises, idéales pour occuper votre chien entre les repas ! Testez-les ! ', 'phil-sons-pattes-de-poulet-pour-chien-5-pattes'),
(10, 'Barkoo Os à mâcher au cimier de bœuf pour chien 6 os - 330g', 8.99, 15, 2, 10, '<p>Les délicieux os à mâcher Barkoo vous permettront de compléter les repas quotidiens de votre chien de façon optimale : composés de peau de bœuf croustillante, ils occuperont votre animal pendant longtemps tout en renforçant naturellement son hygiène dentaire. Garnis de cimiers de bœuf, ils offrent un plaisir de mastication intense auquel votre chien ne saura résister ! Sans arômes, colorants ni conservateurs, les friandises pour chien Barkoo sont parfaites pour satisfaire toutes les petites faims. Les chiens aiment grignoter, mâcher et ronger. La gamme Barkoo satisfait cet instinct naturel et offre en même temps une grande diversité de friandises naturelles. Votre chien ne s\'en lassera pas !</p>\r\n\r\n<h2>Caractéristiques des os à mâcher Barkoo :</h2>\r\n<ul>\r\n  <li>Occupation idéale car se mâchent pendant longtemps</li>\r\n  <li>Garnis de cimiers de bœuf pour une appétence optimale</li>\r\n  <li>Os à mâcher naturels et pauvres en graisses</li>\r\n  <li>Sans arômes, colorants, ni conservateurs</li>\r\n  <li>Ne s\'effritent pas en petits morceaux, puisque les os ont été fabriqués à partir d\'un seul morceau de peau de bœuf</li>\r\n  <li>Soignent et renforcent les dents, les gencives et la mâchoire</li>\r\n  <li>Produits en Europe</li>\r\n</ul>\r\n\r\n<p>Les friandises Barkoo sont parfaites en toute occasion : pour le récompenser, l\'occuper, répondre à des besoins particuliers ou simplement pour lui faire plaisir !</p>\r\n\r\n<p>Conseil : les os à mâcher Barkoo peuvent aider votre chien à mieux vivre les situations stressantes.</p>\r\n\r\n<p>Les os au cimier de bœuf pour chien Barkoo constituent un aliment complémentaire et sont disponibles en différents poids et tailles.</p>\r\n', '<ul>\r\n<li>98 % de peau de bœuf, 2 % de farine de cimiers de bœuf</li>\r\n</ul>', 'Indifférent', 'Os à mâcher en peau de bœuf et garnis de cimiers de bœuf : grande appétence, favorisent l\'hygiène bucco-dentaire, disponibles en plusieurs tailles. Barkoo – des friandises qui font toujours plaisir.', 'barkoo-os-m-cher-au-cimier-de-b-uf-pour-chien-6-os-330g'),
(14, 'Balle Ultra Ball Chuckit! pour chien', 10, 10, 3, 24, '<p>Votre chien va l’adorer ! Cette balle résistante en caoutchouc naturel flotte et rebondit très haut, et se nettoie facilement une fois le jeu terminé. Parce que les chiens aiment courir après toutes sortes de balles, la balle Ultra Ball Chuckit! deviendra rapidement le jouet préféré de votre compagnon !</p>\r\n<p>Cette balle est idéale pour éduquer votre chien et lui apprendre à rapporter la balle. Vous pouvez utiliser le lanceur Chuckit! afin de lancer la balle encore plus loin sans effort et sans avoir besoin de vous baisser. Cette balle fera le bonheur des chiens actifs qui se feront un plaisir de la pourchasser.</p>\r\n\r\n<h2>Caractéristiques de la balle Ultra Ball Chuckit! pour chien :</h2>\r\n\r\n<ul>\r\n  <li>Balle en caoutchouc pour le jeu de lancer/rapporter</li>\r\n  <li>En caoutchouc naturel : balle extrêmement résistante, qui flotte et rebondit très haut</li>\r\n  <li>Se nettoie rapidement : vous avez fini de jouer avec votre chien et vous voulez ranger la balle dans votre sac ? Aucun problème, grâce à sa surface qui se nettoie facilement et sèche rapidement</li>\r\n  <li>Compatible avec le lanceur de balles Chuckit! pour lancer la balle encore plus loin</li>\r\n</ul>\r\n\r\n<p>Coloris : orange/bleu</p>\r\n<p>Matériau : en caoutchouc naturel</p>\r\n<p>Dimensions : 7,6 cm de diamètre environ (taille L)</p>\r\n\r\n\r\n', '', 'Indifférent', 'Balle qui flotte et rebondit très haut, idéale pour les chiens qui aiment se dépenser, compatible avec le lanceur Chuckit! pour lancer la balle très loin, facile à nettoyer, solide, caoutchouc naturel', 'balle-ultra-ball-chuckit-pour-chien'),
(15, 'Assiette à lécher Trixie Junior Lick\'n\'Snack pour chiot', 3.69, 4, 3, 25, '<p>La vie des chiots est trépidante et une petite pause s\'avère parfois nécessaire. L\'assiette à lécher Trixie Junior est idéale pour instaurer un retour au calme et occuper votre petit compagnon de façon détendue. En effet, lécher apaise le chien et lui procure beaucoup de plaisir.</p>\r\n\r\n<p>Vous pourrez recouvrir l\'assiette de pâtés, d\'aliments humides ou d\'autres friandises à tartiner, et même la placer au congélateur pour rafraîchir votre chien lorsqu\'il fait chaud. Vous pourrez aussi l\'utiliser pour servir les repas quotidiens de votre animal. L\'assiette à lécher encouragera votre chien à manger lentement et à ne pas avaler trop vite sa nourriture. Vous apprécierez les propriétés résistantes et hygiéniques de cette assiette. De plus, son matériau flexible n\'abîme pas les dents ni les gencives.</p>\r\n\r\n<h2>Caractéristiques de l\'assiette à lécher Trixie Junior Lick\'n\'Snack pour chiot :</h2>\r\n\r\n<ul>\r\n<li>Assiette à lécher pour chiot</li>\r\n<li>Lick’n‘Snack : à recouvrir de pâtés, d\'aliments humides, de produits lactés ou à remplir de petites friandises</li>\r\n<li>Activité reposante : lécher apaise le chien, favorise un retour au calme</li>\r\n<li>Permet de rafraîchir le chien par temps chaud : peut être remplie et placée au congélateur, parfait pour l\'été</li>\r\n<li>Convient parfaitement pour les petits gloutons : occupe le chien longtemps sans le gaver</li>\r\n<li>Pour les repas quotidiens : empêche le chien d\'avaler sa nourriture trop vite et d\'avoir des problèmes digestifs et des ballonnements</li>\r\n<li>En caoutchouc thermoplastique : solide, flexible, hygiénique, n\'abîme pas les dents ni les gencives</li>\r\n<li>Coloris : vert menthe</li>\r\n<li>Matériau : 100 % TPR</li>\r\n<li>Dimensions : 15 cm de diamètre</li>\r\n<li>Conseil d\'entretien : passe au lave-vaisselle</li>\r\n</ul>\r\n\r\n', '', 'Chiot', 'Assiette à lécher rainurée pour chiot, à remplir de friandises, occupe le chien longtemps sans le gaver, peut être placée au congélateur, matériau hygiénique, n\'abîme pas les dents ni les gencives, en TPR.', 'assiette-l-cher-trixie-junior-lick-n-snack-pour-chiot'),
(16, 'Jouet Trixie Dog Activity Flip Board pour chien', 6.49, 5, 3, 26, '<p>L\'entraînement cérébral permet de rester jeune - cela est aussi valable pour les chiens. Avec le jouet d\'intelligence Flip Board, votre chien sera occupé et son esprit stimulé. Il devra chercher en s\'amusant les friandises ou les croquettes que vous aurez cachées, en essayant et en adoptant différentes techniques d\'ouverture des cachettes. Votre chien reçoit sa récompense dès qu\'il a réussi et reste bien concentré.</p>\r\n\r\n<p>Pour un entraînement optimal, vous recevrez avec le jouet un livret contenant des conseils et astuces très utiles, pour vous permettre d\'utiliser le jouet correctement, ni trop ni trop peu. Au début, votre chien aura besoin de votre aide et de vos encouragements. Pour que le jouet reste intéressant et continue de stimuler votre compagnon, différents exercices sont proposés. Le plateau de jeu est doté de petites cavités recouvertes de couvercles abattants ou coulissants, et de deux quilles que votre chien doit soulever.</p>\r\n\r\n<p>Avec le jouet d\'intelligence pour chien Dog Activity Flip Board, l\'ennui appartient au passé ! Votre chien sera occupé pendant longtemps et motivé pour obtenir ses récompenses.</p>\r\n\r\n<h2>Caractéristiques du jouet pour chien Trixie Dog Activity Flip Board :</h2>\r\n\r\n<ul>\r\n<li>Coloris : noir, orange et rouge : coloris aléatoire !</li>\r\n<li>Dimensions : 23 cm de diamètre x H 8 cm</li>\r\n<li>Matériau : 100 % plastique</li>\r\n<li>2 quilles, cavités à couvercles abattants ou coulissants</li>\r\n<li>Convient aussi très bien aux petits chiens</li>\r\n<li>Antidérapant grâce au socle en caoutchouc</li>\r\n<li>Modèle déposé</li>\r\n<li>Passe au lave-vaisselle</li>\r\n<li>Contre l\'ennui</li>\r\n<li>Livret inclus pour un entraînement optimal</li>\r\n</ul>\r\n\r\n<p><strong>Attention :</strong> veuillez toujours surveiller votre animal lorsqu\'il s\'amuse avec un jouet. Bien vérifier que le jouet n\'est pas abîmé ou que des petits morceaux n\'ont pas été arrachés. Si le jouet est endommagé, mettez-le aussitôt hors de portée de votre animal. Nous vous conseillons fortement de remplacer immédiatement le jouet afin d\'éviter toute blessure.</p>\r\n', '', 'Indifférent', 'Jeu d\'intelligence pour chien, bon entraînement cérébral, quilles, cavités et couvercles, à remplir de friandises, plusieurs façons d\'ouvrir les cachettes et degrés de difficulté, livret d\'entraînement inclus, plastique.', 'jouet-trixie-dog-activity-flip-board-pour-chien');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `slug`) VALUES
(1, 'Croquettes', 'Croquettes pour chiens', 'croquettes'),
(2, 'Mastication', 'Friandises naturelles pour chien', 'mastications'),
(3, 'Jouets', 'Jouets pour chien', 'jouets');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `user_id`, `grade`, `comment`) VALUES
(1, 1, 25, 5, 'Très bonne croquettes, mon chien adore !'),
(2, 1, 11, 4, 'Mes chiens adorent ces croquettes ! Leur énergie semble inépuisable depuis qu\'ils mangent cette marque. De plus, je suis rassuré de savoir qu\'ils reçoivent une alimentation équilibrée et nutritive.'),
(3, 2, 24, 4, 'Mes chiens sont fous de ces croquettes ! Leur énergie est incroyable depuis que nous avons commencé à les nourrir avec ce produit. Leurs poils sont brillants et ils semblent en pleine forme. Je recommande vivement ces croquettes à tous les propriétaires de chiens !'),
(4, 5, 2, 5, 'Mes chiens ont essayé de nombreuses marques de croquettes, mais celles-ci sont définitivement leurs préférées. Leur pelage est plus doux et plus brillant, et ils ont une énergie débordante. Je suis convaincu que ces croquettes sont la meilleure option pour eux.'),
(5, 1, 33, 5, 'Je suis reconnaissant d\'avoir découvert ces croquettes pour chiens. Mon chien est très difficile en matière de nourriture, mais il a immédiatement adoré celles-ci. En plus, elles sont pleines de bons ingrédients qui maintiennent sa santé et son bien-être. Merci pour un excellent produit !'),
(6, 3, 21, 4, 'Je suis très satisfait de ces croquettes pour mon chien. Elles sont faciles à digérer et semblent lui apporter tous les nutriments dont il a besoin. De plus, il ne laisse pas une miette dans sa gamelle !'),
(7, 10, 36, 5, 'En tant que propriétaire de chiens exigeants, je suis toujours à la recherche de friandises de qualité. Ces friandises pour chien ont dépassé toutes mes attentes. Mes chiens les trouvent irrésistibles, et je suis rassuré de savoir qu\'elles sont fabriquées avec des ingrédients sains et naturels.'),
(8, 8, 27, 4, 'Mes chiens sont fous de ces friandises ! À chaque fois que je sors le sachet, ils se précipitent vers moi avec une excitation palpable. De plus, ces friandises sont non seulement délicieuses pour eux, mais elles sont également nutritives, ce qui me donne une grande tranquillité d\'esprit.'),
(9, 1, 1, 5, 'Parfait!    '),
(10, 3, 1, 5, 'Ces croquettes pour chiots sont excellentes ! Mon chiot les adore et je peux voir une nette amélioration de sa santé depuis qu\'il les consomme. Son système immunitaire semble renforcé et il est en pleine forme.'),
(11, 4, 1, 4, 'Mes chiens adorent ces croquettes ! Leur énergie semble inépuisable depuis qu&#039;ils mangent cette marque. De plus, je suis rassuré de savoir qu&#039;ils reçoivent une alimentation équilibrée et nutritive.    '),
(13, 7, 19, 5, 'Je suis reconnaissant d\'avoir découvert ces croquettes pour chiens. Mon chien est très difficile en matière de nourriture, mais il a immédiatement adoré celles-ci. En plus, elles sont pleines de bons ingrédients qui maintiennent sa santé et son bien-être. Merci pour un excellent produit !'),
(14, 1, 1, 5, 'Parfait !'),
(15, 10, 1, 5, 'Parfait !'),
(16, 10, 31, 5, 'Mon chien adore ces os à mâcher de Barkoo ! Ils sont parfaits pour le divertir pendant des heures.'),
(17, 10, 11, 5, 'J\'apprécie la composition naturelle de ces os à mâcher. Mon chien les adore et je sais qu\'il est en sécurité en les dégustant.'),
(18, 10, 11, 5, 'Mes chiens sont devenus accros à ces os à mâcher. C\'est leur récompense préférée après une longue promenade !.'),
(19, 10, 3, 5, 'Je recommande vivement ces os à mâcher. Mon chien ne peut pas s\'en passer et je suis heureux de lui offrir quelque chose de délicieux et sûr.');

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id`, `url`, `alt`) VALUES
(1, 'https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/proplan_large_robust_puppy.jpg', 'Proplan poulet pour chiot grand et robuste - 12kg'),
(2, 'https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/wow_classic_wildhills_12kg.jpg', 'Wolf of Wilderness Adult Wild Hills, canard - 12kg'),
(3, 'https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/proplan_medium_adult_optibalance.jpg', 'PURINA PRO PLAN Medium Adult poulet - 12kg'),
(4, 'https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/eukanuba-senior.jpg', 'Eukanuba senior agneau riz - 12kg'),
(5, 'https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/wow_classic_blueriver_12kg.jpg', 'Wolf of Wilderness Adult Blue River, saumon - 12kg'),
(6, 'https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/carnilove_salmon.jpg', 'Carnilove saumon, saumon - 12kg'),
(7, 'https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/royalcanin_dog_medium_puppy.jpg', 'Royal Canin Medium Puppy pour chiot - 15kg'),
(8, 'https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/dog_snagger_kalbshufe.jpg', 'Sabots de veau et de bœuf pour chien'),
(9, 'https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/chicken_feet.jpg', 'chicken feet 5 pattes'),
(10, 'https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/bones.jpg', 'Barkoo Os à mâcher au cimier de bœuf pour chien'),
(24, 'https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/balle.jpg', 'Balle Ultra Ball Chuckit'),
(25, 'https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/trixie-junior-lickn-snack.jpg', 'Assiette à lécher Trixie Junior Lick\'n\'Snack pour chiot'),
(26, 'https://ryanroudaut.sites.3wa.io/projet/Projet3wa/assets/media/trixie_dog_activity_flip_board.jpg', 'Jouet Trixie Dog Activity Flip Board pour chien');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `total_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `created_at`, `status`, `total_price`) VALUES
(1, 1, '2024-02-29', 'delivered', 0),
(2, 2, '2024-02-14', 'delivered', 0),
(4, 1, '2024-03-04', 'delivered', 0),
(5, 1, '2024-03-26', 'delivered', 0),
(11, 1, '2024-03-26', 'delivered', 0),
(16, 1, '2024-03-26', 'delivered', 0),
(17, 1, '2024-03-26', 'delivered', 0),
(18, 1, '2024-03-26', 'send', 0),
(19, 1, '2024-03-27', 'send', 0),
(20, 1, '2024-03-27', 'send', 0),
(21, 1, '2024-03-27', 'send', 0),
(22, 1, '2024-05-14', 'success', 141.96),
(23, 1, '2024-05-14', 'success', 80.97),
(24, 1, '2024-05-14', 'success', 80.97),
(25, 1, '2024-05-14', 'success', 68.98),
(26, 1, '2024-05-14', 'success', 121.76),
(27, 41, '2024-05-23', 'success', 24.97),
(28, 41, '2024-05-23', 'success', 59.77),
(29, 41, '2024-05-23', 'success', 69.98),
(30, 41, '2024-05-23', 'success', 69.98),
(31, 41, '2024-05-23', 'success', 69.98),
(32, 41, '2024-05-23', 'success', 69.98),
(33, 41, '2024-05-23', 'success', 69.98),
(34, 41, '2024-05-23', 'success', 69.98),
(35, 41, '2024-05-23', 'success', 69.98),
(36, 41, '2024-05-23', 'success', 69.98),
(37, 41, '2024-05-23', 'success', 69.98),
(38, 41, '2024-05-23', 'success', 69.98),
(39, 41, '2024-05-23', 'success', 69.98),
(40, 41, '2024-05-23', 'success', 69.98),
(41, 41, '2024-05-23', 'success', 69.98),
(42, 41, '2024-05-23', 'success', 69.98),
(43, 41, '2024-05-23', 'success', 69.98),
(44, 41, '2024-05-23', 'success', 69.98),
(45, 41, '2024-05-23', 'success', 69.98),
(46, 41, '2024-05-23', 'success', 69.98),
(47, 41, '2024-05-23', 'success', 69.98),
(48, 41, '2024-05-23', 'success', 69.98),
(49, 41, '2024-05-23', 'success', 69.98),
(50, 41, '2024-05-23', 'success', 69.98),
(51, 41, '2024-05-23', 'success', 69.98),
(52, 41, '2024-05-23', 'success', 69.98),
(53, 41, '2024-05-23', 'success', 0),
(54, 41, '2024-05-23', 'success', 0),
(55, 41, '2024-05-23', 'success', 73.97),
(56, 41, '2024-05-23', 'success', 0),
(57, 1, '2024-05-25', 'success', 11.99),
(58, 1, '2024-05-25', 'success', 11.99),
(59, 1, '2024-05-25', 'success', 11.99),
(60, 1, '2024-05-25', 'success', 11.99),
(61, 1, '2024-05-25', 'success', 11.99),
(62, 1, '2024-05-25', 'success', 11.99),
(63, 1, '2024-05-25', 'success', 11.99),
(64, 1, '2024-05-25', 'success', 11.99),
(65, 1, '2024-05-25', 'success', 11.99),
(66, 1, '2024-05-25', 'success', 61),
(67, 1, '2024-05-26', 'success', 856.58);

-- --------------------------------------------------------

--
-- Structure de la table `orders_articles`
--

CREATE TABLE `orders_articles` (
  `order_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `item_type` enum('article','shipping') DEFAULT 'article',
  `item_price` float NOT NULL,
  `item_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `orders_articles`
--

INSERT INTO `orders_articles` (`order_id`, `article_id`, `item_type`, `item_price`, `item_quantity`) VALUES
(1, 1, 'article', 59.99, 0),
(2, 2, 'article', 49.78, 0),
(1, 5, 'article', 0, 0),
(1, 1, 'article', 59.99, 0),
(1, 1, 'article', 59.99, 0),
(4, 5, 'article', 0, 0),
(2, 8, 'article', 0, 0),
(5, 3, 'article', 0, 0),
(5, 5, 'article', 0, 0),
(5, 6, 'article', 0, 0),
(5, 7, 'article', 0, 0),
(5, 8, 'article', 0, 0),
(11, 1, 'article', 0, 0),
(11, 2, 'article', 0, 0),
(16, 8, 'article', 0, 0),
(16, 7, 'article', 0, 0),
(16, 4, 'article', 0, 0),
(16, 10, 'article', 0, 0),
(16, 10, 'article', 0, 0),
(16, 10, 'article', 0, 0),
(17, 3, 'article', 0, 0),
(18, 1, 'article', 0, 0),
(19, 8, 'article', 0, 0),
(19, 10, 'article', 0, 0),
(20, 10, 'article', 0, 0),
(20, 5, 'article', 0, 0),
(20, 8, 'article', 0, 0),
(21, 10, 'article', 0, 0),
(21, 5, 'article', 0, 0),
(22, 1, 'article', 0, 0),
(23, 10, 'article', 0, 0),
(23, 5, 'article', 0, 0),
(24, 10, 'article', 0, 0),
(24, 5, 'article', 0, 0),
(25, 10, 'article', 0, 0),
(25, 5, 'article', 0, 0),
(26, 1, 'article', 0, 0),
(26, 2, 'article', 0, 0),
(34, 1, 'article', 0, 0),
(35, 1, 'article', 0, 0),
(36, 1, 'article', 0, 0),
(37, 1, 'article', 0, 0),
(38, 1, 'article', 0, 0),
(39, 1, 'article', 0, 0),
(41, 1, 'article', 0, 0),
(43, 1, 'article', 0, 0),
(44, 1, 'article', 0, 0),
(45, 1, 'article', 0, 0),
(46, 1, 'article', 0, 0),
(47, 1, 'article', 0, 0),
(48, 1, 'article', 0, 0),
(49, 1, 'article', 0, 0),
(50, 1, 'article', 0, 0),
(52, 1, NULL, 0, 0),
(52, 2, NULL, 0, 0),
(55, 3, 'article', 0, 0),
(55, 10, 'article', 0, 0),
(55, 2, 'shipping', 0, 0),
(64, 1, 'article', 59.99, 4),
(64, 1, 'article', 11.99, 1),
(65, 14, 'article', 10, 6),
(65, 1, 'shipping', 11.99, 1),
(66, 14, 'article', 10, 5),
(66, 1, 'shipping', 11.99, 1),
(67, 10, 'article', 8.99, 13),
(67, 8, 'article', 3.99, 17),
(67, 1, 'article', 59.99, 11),
(67, 1, 'shipping', 11.99, 1);

-- --------------------------------------------------------

--
-- Structure de la table `shipping`
--

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` tinytext,
  `price` float NOT NULL,
  `delivery_min` int(11) DEFAULT NULL,
  `delivery_max` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `shipping`
--

INSERT INTO `shipping` (`id`, `name`, `description`, `price`, `delivery_min`, `delivery_max`) VALUES
(1, 'UPD 2-3 jours', '2-3 jours ouvrés Udp', 11.99, 2, 3),
(2, 'Chronopost 4-5 jours ', 'Chronopost 4-5 jours ouvrés', 9.99, 4, 5),
(3, 'Remise en main propre', 'Venir chercher sur place', 0, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `country` varchar(255) NOT NULL,
  `role` varchar(5) NOT NULL DEFAULT 'USER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `address`, `city`, `postal_code`, `country`, `role`) VALUES
(1, 'Ryan', 'Roudaut', 'ryanroudaut8@gmail.com', '$2y$10$bGGKLjaBluepkBV8qCftvu0/F7Q5aokO3mYpkVLiCs6NYG1E1h.12', '120 rue Jean Gremillon', 'Brest', 29200, 'France', 'ADMIN'),
(2, 'John', 'Smith', 'johnsmith@gmail.com', '$2a$12$d4QSHdu7nyst/PftCN2kSuO0uduriQ7t2NwT4dOTx/IA069e9eaee', '1 rue de quimper', 'Quimper', 29000, 'France', 'USER'),
(3, 'John', 'Doe', 'johndoe@gmail.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '5 rue de la forge', 'Quimper', 29000, 'France', 'USER'),
(10, 'Jane', 'Smith', 'jane.smith@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '456 Oak St', 'Othertown', 54321, 'Canada', 'USER'),
(11, 'Alice', 'Johnson', 'alice.johnson@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '789 Elm St', 'Anothertown', 67890, 'UK', 'USER'),
(12, 'Bob', 'Brown', 'bob.brown@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '101 Pine St', 'Smalltown', 98765, 'Australia', 'USER'),
(13, 'Emily', 'Davis', 'emily.davis@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '202 Cedar St', 'Midtown', 54321, 'Canada', 'USER'),
(14, 'Michael', 'Wilson', 'michael.wilson@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '303 Maple St', 'Largetown', 23456, 'USA', 'USER'),
(15, 'Sarah', 'Anderson', 'sarah.anderson@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '404 Walnut St', 'Hometown', 87654, 'Canada', 'USER'),
(16, 'David', 'Martinez', 'david.martinez@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '505 Oak St', 'Bigtown', 12345, 'UK', 'USER'),
(17, 'Jennifer', 'Garcia', 'jennifer.garcia@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '606 Elm St', 'Citytown', 98765, 'Australia', 'USER'),
(19, 'Daniel', 'Taylor', 'daniel.taylor@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '808 Maple St', 'Smalltown', 12345, 'USA', 'USER'),
(20, 'Sophia', 'Hernandez', 'sophia.hernandez@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '909 Oak St', 'Midtown', 54321, 'Canada', 'USER'),
(21, 'James', 'Young', 'james.young@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '101 Cedar St', 'Largetown', 98765, 'UK', 'USER'),
(22, 'Olivia', 'Gonzalez', 'olivia.gonzalez@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '202 Walnut St', 'Bigtown', 67890, 'Australia', 'USER'),
(23, 'William', 'Lee', 'william.lee@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '303 Pine St', 'Hometown', 23456, 'USA', 'USER'),
(24, 'Ava', 'Clark', 'ava.clark@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '404 Elm St', 'Citytown', 54321, 'Canada', 'USER'),
(25, 'Alexander', 'Rodriguez', 'alexander.rodriguez@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '505 Maple St', 'Villagetown', 87654, 'UK', 'USER'),
(26, 'Mia', 'Lewis', 'mia.lewis@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '606 Oak St', 'Smalltown', 12345, 'Australia', 'USER'),
(27, 'Ethan', 'Walker', 'ethan.walker@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '707 Cedar St', 'Midtown', 98765, 'USA', 'USER'),
(28, 'Charlotte', 'Perez', 'charlotte.perez@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '808 Walnut St', 'Largetown', 23456, 'Canada', 'USER'),
(29, 'Benjamin', 'Hall', 'benjamin.hall@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '909 Pine St', 'Bigtown', 54321, 'UK', 'USER'),
(30, 'Amelia', 'Turner', 'amelia.turner@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '101 Elm St', 'Hometown', 87654, 'Australia', 'USER'),
(31, 'Henry', 'Baker', 'henry.baker@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '202 Cedar St', 'Citytown', 23456, 'USA', 'USER'),
(32, 'Sofia', 'Gonzalez', 'sofia.gonzalez@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '303 Maple St', 'Villagetown', 54321, 'Canada', 'USER'),
(33, 'Jacob', 'Wright', 'jacob.wright@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '404 Walnut St', 'Smalltown', 87654, 'UK', 'USER'),
(34, 'Avery', 'Roberts', 'avery.roberts@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '505 Oak St', 'Midtown', 12345, 'Australia', 'USER'),
(35, 'Mason', 'Nguyen', 'mason.nguyen@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '606 Pine St', 'Largetown', 98765, 'USA', 'USER'),
(36, 'Harper', 'Chavez', 'harper.chavez@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '707 Elm St', 'Citytown', 23456, 'Canada', 'USER'),
(37, 'Evelyn', 'Adams', 'evelyn.adams@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '808 Cedar St', 'Bigtown', 54321, 'UK', 'USER'),
(38, 'Sebastian', 'Thomas', 'sebastian.thomas@example.com', '$2y$10$CbnmftM7x6mdybEbLVtGAurNjlJ3CGDdzdRZlXMzphbTamCz32/Hq', '909 Walnut St', 'Hometown', 87654, 'Australia', 'USER'),
(39, 'Alexandre', 'MARTIN', 'hunger.for.web@gmail.com', '$2y$10$8fHINJM/DdVkAaO6OXoLjeByiFmVBaNoX20zgQazdPI.1zH3cRiaW', '32 Rue Emile Salaün', 'Hôpital-Camfrout', 29460, 'France', 'USER'),
(40, 'Alexandre', 'MARTIN', 'hungerforweb@gmail.com', '$2y$10$.IMoi1f68virSAgSTioG9O5hVnKxaOwuZYXLXIUM5VXkc5BybYp/W', '32 Rue Emile Salaün', 'Hôpital-Camfrout', 29460, 'France', 'USER'),
(41, 'Alexandre', 'MARTIN', 'hungerfor.web@gmail.com', '$2y$10$F1eQFiLzWdGopHO8ZPvlvuGquL/VWlrf5vfkDQp8HwH5M.3BbQ4hC', '32 Rue Emile Salaün', 'Hôpital-Camfrout', 29460, 'France', 'ADMIN');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `orders_articles`
--
ALTER TABLE `orders_articles`
  ADD KEY `article_id` (`article_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Index pour la table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT pour la table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `media` (`id`),
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `orders_articles`
--
ALTER TABLE `orders_articles`
  ADD CONSTRAINT `orders_articles_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `orders_articles_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
