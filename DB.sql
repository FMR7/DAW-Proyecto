-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2018 a las 21:50:17
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `recetas`
--
CREATE DATABASE IF NOT EXISTS `recetas` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `recetas`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `confirmemail`
--

CREATE TABLE `confirmemail` (
  `username` varchar(22) NOT NULL,
  `tokenEmail` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `confirmemail`
--

INSERT INTO `confirmemail` (`username`, `tokenEmail`) VALUES
('Isidra', '2879535cc4dd1d2e38ba324344fd0713f145f0dea24da8f561b1d522446159d937890df042d8f7c8341213c96cf5f4701e14e51c4ac1948896cfa5d9b277cc9a'),
('Amparo', '4dd9e26fa2b1883eb102ce9aba4c1fd6c17c16343986345069dc14d3eb78584d6b0d7b5abf4a15469e10730300898f2b8cefda972fbf4124af2a5273cf4ae02a'),
('fernando', 'c15296bd62b1c6e3aab0a1ce996db4353989e0c22391689b726ed6cb80baacd88419ecca00fd6f8f01f55fa8491e10ff4b2a69bb9750adc565900c7191001f84'),
('admin', 'e64df9ce881bb324e7828c45673bc10685ba7a0be268ba2ad6da12027e0d0689f85fac88d0352913ae52983499558a7b9cb136ff9bd6c0dcb2427a813ed419f5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forgetpass`
--

CREATE TABLE `forgetpass` (
  `username` varchar(22) NOT NULL,
  `tokenPass` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opiniones`
--

CREATE TABLE `opiniones` (
  `idReceta` int(11) NOT NULL,
  `username` varchar(22) DEFAULT NULL,
  `comentario` text,
  `meGusta` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `opiniones`
--

INSERT INTO `opiniones` (`idReceta`, `username`, `comentario`, `meGusta`) VALUES
(32, 'Amparo', NULL, 2),
(33, 'Amparo', NULL, 2),
(35, 'Amparo', NULL, 2),
(32, 'Isidra', NULL, 2),
(36, 'Amparo', NULL, 2),
(37, 'Isidra', 'Para quitar el picor de la cebolla podemos, una vez picada, dejarla sumergida en una mezcla de agua y vinagre (o limón) durante la preparación de la ensalada y al final añadir la cebolla, lavada y escurrida, a la fuente.', NULL),
(39, 'Amparo', 'En lugar de leche también puede hacerse con yogur blanco', 2),
(40, 'Isidra', NULL, 2),
(41, 'Isidra', 'Aguacate: la variedad Hass aporta un agradable sabor almendrado, la Fuerte, con pulpa consistente y con unas características parecidas a la especie Hass y finalmente nos encontramos con otra variedad llamada Bacon, que es mucho más suave y ligera que las dos anteriores.', NULL),
(42, 'Isidra', 'El pescado debe ser blanco, especialmente aquellos que tienen una carne compacta, para que éste no se deshaga con la acción de los limones. Una buena opción, si queremos que no solo sea de merluza o de un solo pescado, es comprar piezas de diferentes clases de pescado', NULL),
(43, 'Isidra', 'Puedes sustituir el jamón por filetes finos de pollo preparados a la plancha.', NULL),
(40, 'Amparo', NULL, 2),
(41, 'Amparo', NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `idReceta` int(11) NOT NULL,
  `nombre` varchar(24) NOT NULL,
  `ingredientes` text NOT NULL,
  `elaboracion` text NOT NULL,
  `dificultad` int(11) NOT NULL,
  `tipoIngredientes` int(11) NOT NULL,
  `numComensales` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`idReceta`, `nombre`, `ingredientes`, `elaboracion`, `dificultad`, `tipoIngredientes`, `numComensales`) VALUES
(32, 'Salmorejo', '10#Tomates;100 ml#Aceite;5 g#Sal;2 #Rebanadas de pan;1#Diente de ajo', 'Cortamos el ajo a trocitos lo metemos en la batidora de vaso junto con el aceite y la sal  Batimos un poco  Después vamos añadiendo los tomates el pan remojado en agua y escurrido y seguimos batiendo  Si está demasiado espeso añadimos un poco de agua al final  Tomar bien frío con huevo duro jamón atún tostones etc', 1, 1, 4),
(33, 'Hervido valenciano', '2#Patatas medianas;2 #Zanahorias;200 g#Judías verdes;1#Cebolla grande;5 g#Sal;250 ml#Agua para hervir', 'Pelamos y troceamos las verduras En el caso de las judías les quitamos las puntas y las hebras de la vaina Enjuagamos bien y ponemos en la olla a presión \nCerramos y cuando suba la presión rebajamos y lo dejamos  minutos\nServimos seco o escurrido y se le añade aceite vinagre o limón y sal al gusto', 1, 1, 2),
(34, 'Pisto manchego', '2#Dientes de ajo;250 g#Cebolla;200 g#Pimiento verde;200 g#Pimiento rojo;4 #Tomates;300 g#Calabacín;5 g#Sal;5 g#Pimienta negra molida;10 cl#Aceite de oliva virgen extra', 'Calentamos agua en una cacerola amplia y la llevamos a ebullición Retiramos la parte dura de los tomates y practicamos un corte de cruz en la base Los introducimos en el agua hirviendo durante unos  segundos los sacamos y los introducimos en un cuenco de agua helada Los pelamos y trituramos\n\nPelamos los dientes de ajo y la cebolla y los picamos finamente Lavamos bien el resto de las verduras y las cortamos en pequeños trozos de igual tamaño Las reservamos separadas unas de otras pues las iremos añadiendo a la cazuela en distintas fases\nCalentamos una cantidad generosa de aceite de oliva virgen extra en una cazuela y pochamos el ajo y la cebolla picados durante  minutos a fuego suave Añadimos el pimiento picado y pochamos  minutos más Por último incorporamos el calabacín y el tomate triturado salpimentamos al gusto tapamos y dejamos pochar durante un mínimo de una hora y media\n\nTranscurrido este tiempo retiramos la tapadera de la cazuela subimos un poco el fuego y cocemos durante  minutos más o hasta que el agua del tomate se haya evaporado Queremos que nos quede jugoso pero sin restos del agua que sueltan las verduras con todos los ingredientes bien amalgamados una vez conseguida esta consistencia servimos inmediatamente', 2, 1, 4),
(35, 'Tortilla de patata', '6#Huevos;600 g#Patatas;1#Cebolla pequeña;2 vasos#Aceite de oliva;5 g#Sal', 'Pela y pica la cebolla en dados medianos\nCorta las patatas en medias lunas finas de  centímetro\nIntroduce todo en la sartén sazona a tu gusto y fríe a fuego suave durante  minutos\nRetira la fritada y escúrrela Pasa el aceite a un recipiente y resérvalo Limpia la sartén con papel absorbente de cocina\n\nCasca los huevos colócalos en un recipiente grande y bátelos Sálalos a tu gusto agrega la fritada de patatas y cebolla y mezcla bien\n\nColoca la sartén nuevamente en el fuego agrega un chorrito del aceite reservado y agrega la mezcla Remueve un poco con una cuchara de madera y espera  segundos a que empiece a cuajarse\n\nSepara los bordes cubre la sartén con un plato de mayor diámetro que la sartén y dale la vuelta\n\nÉchala de nuevo para que cuaje por el otro lado\n', 3, 1, 4),
(36, 'Sushi', '2 vasos#Arroz (grano redondo);3 láminas#Alga nori;10 ml#Vinagre de sidra o manzana;5 g#Wasabi;100 g#Salmón;100 g#Palitos de cangrejo;2 #Aguacates;2 #Zanahorias;10 g#Azúcar;5 g#Sal', 'Comenzamos con el Sushi Maki En primer lugar vamos a lavar el arroz utilizando un colador y un bol Para cocerlo utilizaremos una cacerola con tapa de cristal donde echaremos  tazas de arroz y  de agua Cuando empiece a hervir el agua caliente lo mantenemos a fuego bajo durante  minutos Posteriormente dejamos reposar otros  minutos Ya tendremos preparado el arroz gohan \n\nPara preparar el aliño o sushizu utilizaremos  cucharadas de vinagre  cucharadas de azúcar y una cucharada de sal Removemos y lo llevamos al fuego hasta que el azúcar quede bien disuelto \n\nMezclamos el gohan con el sushizu y conseguimos el Sushi Meshi es decir el arroz preparado para hacer sushi Utilizaremos una tabla de arroz o plástico y una espátula para realizar esta operación Para que se enfríe utilizaremos un abanico \n\nPara realizar el Sushi Maki necesitaremos alga nori el wasabi aguacate zanahoria y palitos de cangrejo Emplearemos una esterilla de bambú sobre la que pondremos papel film Ponemos el alga nori y vamos incorporando el arroz Añadimos un poco de wasabi y los ingredientes seleccionados Enrollamos ayudándonos de la esterilla Cortamos en trozos \n\nOtra opción es preparar el Sushi Nigiri Cogemos un poco de arroz y formamos una masa Añadimos una pizca de wasabi y una tira de salmón ahumado Acompañamos con salsa de soja y si queremos wasabi', 3, 2, 2),
(37, 'Tabuleh', '2 tazas#Cous cous;2 tazas#Agua;1/2#Cebolla;1#Zanahoria;2#Tomates;20#Aceitunas sin hueso;1/2 taza#Aceite de oliva;1/2 taza#Zumo de limón;50 g#Perejil fresco;50 g#Hierbabuena o menta;5 g#Sal;5 g#Pimienta', 'Primero hacemos el couscous para que se vaya enfriando una vez cocido Tradicionalmente es cocido al vapor pero es facil encontrar couscous precocido cuya preparación es muy sencilla\n\nPonemos en un recipiente amplio las  tazas de couscous Calentamos la misma cantidad de agua salada y cuando hierva la añadimos al recipiente de la sémola y lo tapamos Dejamos reposar unos  minutos y removemos para asegurarnos que absorve todo el agua Echamos un chorrito de aceite y removemos para que el grano quede suelto\n\nAñadimos el zumo de limón y el aceite al recipiente del couscous salpimentamos y dejamos enfriar\n\nMientras se va enfriando picamos finamente el perejil la hierbabuena o la menta y la cebolla cortamos en cuadraditos pequeñitos los tomates la zanahoria y las aceitunas\n\nMezclamos todos los ingredientes y dejamos enfriar en la nevera para servirlo fresquito', 2, 2, 4),
(38, 'Chuletas de cordero', '6#Patatas;2 #Dientes de ajo;50 g#Romero fresco;80 ml#Aceite de oliva;20#Chuletas de cordero;1 copa#Vino blanco seco;10 g#Sal;10 g#Pimienta seca molida', 'En primer lugar precalentamos el horno a  grados para que ya esté caliente cuando metamos el cordero Preparamos también dos fuentes para horno grandes engrasándolas con la cucharada de aceite de oliva para que no se pegue el cordero\n\nPelamos y lavamos las patatas y las cortamos por la mitad o en cuartos si nos gustan más pequeñas Colocamos las patatas en las  fuentes con los ajos picados las hojas de romero y  ml de aceite de oliva repartido de forma equitativa\n\nSazonamos todo con una buena cantidad de sal y pimienta negra y mezclamos todos los ingredientes para que se repartan uniformemente\n\nIntroducimos las dos bandejas en el horno precalentado durante  minutos o hasta que veamos que las patatas empiezan a coger un color dorado y estén tiernas\nColocamos las chuletas de cordero en la parte superior de las patatas sin apagar el horno Embadurnamos las chuletas con el aceite de oliva restante sazonamos con sal y pimienta al gusto y espolvoreamos unas hojas de romero más\n\nVertemos la copia de vino blanco por encima Volvemos a introducirlo en el horno durante  minutos más o hasta que el cordero se cocine a nuestro gusto e intercambiamos la posición de las fuentes a mitad de la cocción aproximadamente a los  minutos para que tengan la misma cocción\n\nServimos las chuletas acompañadas de las patatas y la salsa del fondo de la fuente', 2, 1, 4),
(39, 'Batido de fresa', '500 g#Fresas;300 ml#Leche entera;5 c/s#Azúcar', ' En primer lugar tenemos que limpiar las fresas del rabito que tienen y las hojas que llevan en la parte superior del fruto cuando las tengamos ya limpias las lavaremos bajo el grifo del agua y dejaremos escurrir en un escurridor\n\n En un bol las trocearemos en trozos del mismo tamaño y dejaremos macerar con el azúcar durante una hora para que las fresas absorban el azúcar y creen un jugo muy rico\n\n Las batiremos con  la batidora de vaso o con la batidora eléctrica echaremos las fresas junto a la leche y batir hasta que este todo homogéneo probaremos si está bien de azúcar a nuestro gusto y podemos añadirle más\n\n Colar el batido antes de consumirlo puede tener trazas de las fresas que no os gusten a mi me gusta porque aporta fibra pero es cuestión de gustos queda más fino si lo pasamos por el colador\n\n  Dejaremos enfriar en el frigorífico y consumir cuando queramos\n\n', 1, 1, 1),
(40, 'Tarta de queso fría', ' 150 g#Galletas;50 g#Mantequilla;500 g#Queso crema;400 ml#Nata líquida;4 hojas#Gelatina;80 g#Azúcar;4 c/s#Mermelada de fresa', ' Primero vamos a preparar la base de la tarta Colocamos las galletas dentro de una bolsa de congelación con cierre hermético hacemos rodar un rodillo por encima hasta que estén totalmente deshechas y las pasamos a un bol \nDerretimos la mantequilla y la añadimos a las galletas\n\n Mezclamos con una cuchara hasta obtener una masa homogénea Colocamos esta masa en la base del molde y vamos presionando con las manos hasta cubrir toda la superficie\nLa metemos en la nevera y reservamos\n\n Ponemos una tartera a fuego bajomedio e introducimos la nata líquida y el azúcar Removemos bien hasta que se disuelva el azúcar A continuación añadimos el queso crema Mientras tanto ponemos a hidratar las hojas de gelatina en un bol con agua durante aproximadamente  minutos\n\n Removemos con la varilla hasta que el queso crema se deshaga por completo Sacamos las hojas de gelatina las escurrimos introducimos en la tartera y removemos hasta que se deshagan con el calor Retiramos del fuego y dejamos que la mezcla se temple durante un par de minutos\n\n Sacamos el molde de la nevera y vertemos la mezcla con cuidado Dejamos que pierda temperatura y la metemos otra vez en la nevera durante un par de horas\nUna vez fría la tarta cubrimos la superficie con mermelada de fresa\n\n Desmoldamos la tarta con cuidado y la servimos fría\n', 3, 1, 8),
(41, 'Guacamole', '3#Aguacates;1#Cebolla;1#Lima;1#Pimiento jalapeño;1#Chile serrano;50 g#Cilantro fresco;5 g#Sal', 'El primer paso es coger os aguacates hacerles un corte profundo por todo su perímetro y poder separar sus dos mitades sin ningún problema Quitaremos el hueso y le sacaremos la pulpa con una cuchara la cual iremos depositando en un plato hondo\n\nCuando hayamos sacado toda la pulpa podremos machacarla toda con un tenedor hasta dejarlo con una masa cremosa pero con cierta consistencia como si se tratase de un puré\n\nUna vez machacado agregaremos el zumo de lima recién exprimida para evitar que el aguacate se oxide y adquiera un color oscuro\n\nPor otro lado pelaremos la cebolla y picaremos la mitad en trozos muy finos algo que podemos hacer o con un cuchillo muy afilado o con una mandolina con lo que acabaremos rápidamente La cebolla que hemos picado la incorporaremos al aguacate que tenemos en el plato ya triturado\n\nPicaremos el jalapeño muy fino procurando quitarle las pepitas si no queremos que pique demasiado lo incorporaremos al resto de ingredientes junto a un pellizco de sal y a unas hojas de cilantro fresco recién picado\nCon el tenedor removeremos todos los ingredientes para que poco a poco se vayan mezclando todos los ingredientes y encontrando el equilibrio entre todos ellos\n\nAhora ya estará listo para consumir con cualquiera de las elaboraciones de la gastronomía mexicana que hayamos hecho desde unos sencillos nachos hasta un plato de pollo o carne picante', 3, 2, 8),
(42, 'Ceviche peruano', '1,5 k#Pescado blanco;10#Limones verdes;2#Chiles rojos;1/2 taza#Cilantro fresco;2#Cebollas rojas;6#Dientes de ajo;5 g#Sal;5 g#Pimienta', 'Quitaremos las espinas que pudiera tener el pescado y lo cortaremos en dados después los pondremos en agua fría con sal Por otro lado cortaremos la cebolla en juliana y los chiles y los ajos los picaremos lo más fino que podamos\n\nEn un recipiente exprimiremos todos los limones teniendo cuidado de que no se nos caigan las pepitas algo que podemos hacer o bien con un colador con un exprimidor de mano o simplemente los exprimimos fuera y echamos el líquido\n\nEn este recipiente echaremos el ajo los chiles picados la sal y la pimienta lo removeremos bien e incorporaremos el pescado y el cilantro fresco recién picado lo removeremos procurando que el pescado quede bien cubierto por el zumo de los limones y dejaremos reposar hasta que la carne del pescado se curta preferiblemente dentro de la nevera para que los ingredientes reposen y se integren entre sí\n\nDespués de una hora aproximadamente sacaremos el pescado con los ingredientes y le incorporaremos la cebolla removeremos bien y el plato ya estará listo para ser degustado', 2, 2, 6),
(43, 'Sándwich club', '3#Panes de sándwich;100 g#Lechuga picada;3 tiras#Bacon;4 rodajas#Tomate;1 loncha#Queso;1 loncha#Jamón cocido;1#Huevo duro;1 c/s#Mayonesa;1/2 c/s#Mostaza', 'Untamos una rebanada de pan con la salsa mayonesa mezclada con un poquito de mostaza\nColocamos primero la loncha de queso para que impermeabilice un poco el pan Vamos poniendo el resto de ingredientes al gusto\nLas tiras de bacón hay que saltearlas un minuto al fuego en su propia grasa también podemos meter unos segundos al microondas hasta que empieza a crujir\nLas verduras lechuga y tomate tienen que estar bien escurridas y secas\nNo pongas demasiados ingredientes en cada piso Coloca la siguiente rebanada de pan untada ligeramente en salsa por las dos caras y termina con el resto de los ingredientes\nCerramos con la tercera rebanada de pan y coronamos con un palillo de dientes o un pinchito para que el sándwich se sostenga bien\nTradicionalmente se corta el sándwich en  triángulos antes de servir Hay que servir al momento de prepararlo para que el pan no se humedezca\n', 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_tipos`
--

CREATE TABLE `recetas_tipos` (
  `idReceta` int(11) NOT NULL,
  `idTipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `recetas_tipos`
--

INSERT INTO `recetas_tipos` (`idReceta`, `idTipo`) VALUES
(32, 3),
(32, 5),
(32, 6),
(32, 9),
(33, 5),
(33, 6),
(34, 3),
(34, 5),
(34, 7),
(35, 2),
(35, 3),
(35, 5),
(35, 7),
(36, 3),
(36, 5),
(37, 3),
(37, 5),
(37, 9),
(38, 3),
(38, 7),
(39, 1),
(39, 10),
(40, 8),
(41, 9),
(42, 9),
(43, 2),
(43, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodificultades`
--

CREATE TABLE `tipodificultades` (
  `idDificultad` int(11) NOT NULL,
  `dificultad` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipodificultades`
--

INSERT INTO `tipodificultades` (`idDificultad`, `dificultad`) VALUES
(1, 'Fácil'),
(2, 'Normal'),
(3, 'Difícil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoingredientes`
--

CREATE TABLE `tipoingredientes` (
  `idTipoIngrediente` int(11) NOT NULL,
  `tipoIngrediente` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipoingredientes`
--

INSERT INTO `tipoingredientes` (`idTipoIngrediente`, `tipoIngrediente`) VALUES
(1, 'Habituales'),
(2, 'Exóticos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiporeceta`
--

CREATE TABLE `tiporeceta` (
  `idTipo` int(11) NOT NULL,
  `tipo` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tiporeceta`
--

INSERT INTO `tiporeceta` (`idTipo`, `tipo`) VALUES
(1, 'Desayuno'),
(2, 'Almuerzo'),
(3, 'Comida'),
(4, 'Merienda'),
(5, 'Cena'),
(6, 'Primero'),
(7, 'Segundo'),
(8, 'Postre'),
(9, 'Entrante'),
(10, 'Bebida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `username` varchar(22) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(48) NOT NULL,
  `emailConfirmed` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`username`, `password`, `email`, `emailConfirmed`, `admin`) VALUES
('admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'admin@ejemplo.com', 0, 1),
('Amparo', '6518f0debdaae65d8d1cfa239e6b5632745678eca134b0cf4f1ed48f01fa87fbd0b95b8941e31f8029e719601bbdf1dc4ee506d4873d146520bdf7d23afe77d0', 'amparo@ejemplo.com', 0, 0),
('fernando', '936238025aeb5e6812b3b899259c64a2ba41982d75c2eea08f35be315826e9a4506ee69a41023c3a1925868b998c437480f6ae4df7b3f204053b290b9b50193a', 'fernando@ejemplo.com', 0, 0),
('Isidra', 'd69dc95d7aa02ea36bea0c4815911e4e2396aab9ff27df4ee7d705c5a877386be0ad4b814e844b4f7b960be2d56ef982d96c2add97f1c239cb27280082cb53be', 'isidra@ejemplo.com', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_recetas`
--

CREATE TABLE `usuario_recetas` (
  `username` varchar(22) DEFAULT NULL,
  `idReceta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_recetas`
--

INSERT INTO `usuario_recetas` (`username`, `idReceta`) VALUES
('Amparo', 32),
('Amparo', 33),
('Amparo', 34),
('Amparo', 35),
('Isidra', 36),
('Isidra', 37),
('Isidra', 38),
('Isidra', 39),
('Isidra', 40),
('Isidra', 41),
('Isidra', 42),
('Isidra', 43);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `confirmemail`
--
ALTER TABLE `confirmemail`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `tokenEmail` (`tokenEmail`),
  ADD KEY `username` (`username`);

--
-- Indices de la tabla `forgetpass`
--
ALTER TABLE `forgetpass`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `tokenPass` (`tokenPass`),
  ADD KEY `username` (`username`);

--
-- Indices de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  ADD UNIQUE KEY `opinionReceta` (`idReceta`,`username`) USING BTREE,
  ADD KEY `opiniones_ibfk_2` (`username`);

--
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`idReceta`),
  ADD KEY `dificultad` (`dificultad`),
  ADD KEY `tipoIngredientes` (`tipoIngredientes`);

--
-- Indices de la tabla `recetas_tipos`
--
ALTER TABLE `recetas_tipos`
  ADD UNIQUE KEY `recetaTipo` (`idReceta`,`idTipo`) USING BTREE,
  ADD KEY `receta` (`idReceta`),
  ADD KEY `tipo` (`idTipo`);

--
-- Indices de la tabla `tipodificultades`
--
ALTER TABLE `tipodificultades`
  ADD PRIMARY KEY (`idDificultad`);

--
-- Indices de la tabla `tipoingredientes`
--
ALTER TABLE `tipoingredientes`
  ADD PRIMARY KEY (`idTipoIngrediente`);

--
-- Indices de la tabla `tiporeceta`
--
ALTER TABLE `tiporeceta`
  ADD PRIMARY KEY (`idTipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `usuario_recetas`
--
ALTER TABLE `usuario_recetas`
  ADD UNIQUE KEY `idReceta` (`idReceta`) USING BTREE,
  ADD KEY `username` (`username`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `idReceta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `tipodificultades`
--
ALTER TABLE `tipodificultades`
  MODIFY `idDificultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipoingredientes`
--
ALTER TABLE `tipoingredientes`
  MODIFY `idTipoIngrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tiporeceta`
--
ALTER TABLE `tiporeceta`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `confirmemail`
--
ALTER TABLE `confirmemail`
  ADD CONSTRAINT `confirmemail_ibfk_1` FOREIGN KEY (`username`) REFERENCES `usuarios` (`username`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `forgetpass`
--
ALTER TABLE `forgetpass`
  ADD CONSTRAINT `forgetpass_ibfk_1` FOREIGN KEY (`username`) REFERENCES `usuarios` (`username`) ON DELETE CASCADE;

--
-- Filtros para la tabla `opiniones`
--
ALTER TABLE `opiniones`
  ADD CONSTRAINT `opiniones_ibfk_1` FOREIGN KEY (`idReceta`) REFERENCES `recetas` (`idReceta`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `opiniones_ibfk_2` FOREIGN KEY (`username`) REFERENCES `usuarios` (`username`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Filtros para la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD CONSTRAINT `recetas_ibfk_1` FOREIGN KEY (`dificultad`) REFERENCES `tipodificultades` (`idDificultad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `recetas_ibfk_2` FOREIGN KEY (`tipoIngredientes`) REFERENCES `tipoingredientes` (`idTipoIngrediente`);

--
-- Filtros para la tabla `recetas_tipos`
--
ALTER TABLE `recetas_tipos`
  ADD CONSTRAINT `recetas_tipos_ibfk_1` FOREIGN KEY (`idReceta`) REFERENCES `recetas` (`idReceta`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `recetas_tipos_ibfk_2` FOREIGN KEY (`idTipo`) REFERENCES `tiporeceta` (`idTipo`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_recetas`
--
ALTER TABLE `usuario_recetas`
  ADD CONSTRAINT `usuario_recetas_ibfk_1` FOREIGN KEY (`username`) REFERENCES `usuarios` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_recetas_ibfk_2` FOREIGN KEY (`idReceta`) REFERENCES `recetas` (`idReceta`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
