-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 31 2017 г., 13:53
-- Версия сервера: 5.6.37
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Categories`
--

CREATE TABLE `Categories` (
  `id` int(11) NOT NULL,
  `category` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Categories`
--

INSERT INTO `Categories` (`id`, `category`) VALUES
(2, 'Laptop'),
(1, 'Phone');

-- --------------------------------------------------------

--
-- Структура таблицы `Customers`
--

CREATE TABLE `Customers` (
  `id` int(11) NOT NULL,
  `login` varchar(32) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `roleid` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `imagepath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Customers`
--

INSERT INTO `Customers` (`id`, `login`, `pass`, `roleid`, `discount`, `total`, `imagepath`) VALUES
(2, 'andr', 'dd7c8a297a8d34ba5dc7cd4b45a1e593', 2, 0, 0, 'images/v1.jpg'),
(3, 'traval', '802a051cc90f5d3f9c4ca40ce703c3c0', 2, 0, 0, 'images/travel.jpg'),
(5, 'shoper', '61e352743ecee4ca9c8a94a5eec1a483', 2, 0, 0, 'images/stars.png');

-- --------------------------------------------------------

--
-- Структура таблицы `Images`
--

CREATE TABLE `Images` (
  `id` int(11) NOT NULL,
  `itemid` int(11) DEFAULT NULL,
  `imagepath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Items`
--

CREATE TABLE `Items` (
  `id` int(11) NOT NULL,
  `itemname` varchar(128) NOT NULL,
  `catid` int(11) DEFAULT NULL,
  `pricein` int(11) NOT NULL,
  `pricesale` int(11) NOT NULL,
  `info` varchar(256) NOT NULL,
  `rate` double DEFAULT NULL,
  `imagepath` varchar(256) NOT NULL,
  `action` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Items`
--

INSERT INTO `Items` (`id`, `itemname`, `catid`, `pricein`, `pricesale`, `info`, `rate`, `imagepath`, `action`) VALUES
(1, 'IPhone X', 1, 34000, 38000, 'Мы всегда мечтали сделать iPhone одним большим дисплеем. Настолько впечатляющим дисплеем, чтобы вы забывали о самом физическом устройстве. И настолько умным устройством, чтобы оно реагировало на прикосновение, слово и даже взгляд. iPhone X воплощает мечту ', 0, 'images/apple_iphone_x_256gb_silver_images_2207147190.jpg', 0),
(2, 'IPhone 8', 1, 22000, 26000, 'iPhone 8 открывает совершенно новые возможности, для нового поколения продуктов Apple. Великолепная и так камера доработана и модифицирована, с лицевой и тыльной стороны стеклянные панели, беспрецедентный мощный и умный процессор, лучший среди всех ранее с', 0, 'images/apple_iphone_8_3_.jpg', 0),
(3, 'Samsung Galaxy S8', 1, 20500, 23000, 'Новый форм-фактор и революционный экран, изогнутый с двух сторон и радующий эффектом полного погружения, передовое «железо» и голосовой ассистент Bixby, обновленные камеры и много других фишек. Модель однозначно интересная. И это совершенно новое устройств', 0, 'images/Bezramochnyiy-e`kran-unikalnyie-osobennosti-Samsung-Galaxy-S8.jpg', 0),
(4, 'Samsung Galaxy A5', 1, 10000, 12000, 'Вместе с Galaxy A5 (2017) почувствуйте себя профессиональным фотографом. Наличие широкого выбора фильтров позволяет подойти к процессу съемки более креативно. Теперь каждая фотография будет особенной.', 0, 'images/samsung_a520f_galaxy_a5_2017_b_6.jpg', 0),
(5, 'Lenovo IdeaPad 110s-11IBR (80WG002SRA) Silver', 2, 5000, 6400, 'Екран\r\nДіагональ екрану 11,6\'\'\r\nРоздільна здатність екрану 1366x768 HD\r\nПокриття екрану Матове\r\nПроцесор\r\nЦентральний процесор Intel Celeron\r\nМодель центрального процесора N3060\r\nКількість ядер 2 ядра\r\nЧастота центрального процесора 1,6 (2,48) ГГц\r\nОЗП\r\nОб', 0, 'images/lenovo_ideapad_110s-11ibr_80wg002sra_silver.jpg', 0),
(6, 'Asus R541NA-GO224T Chocolate Black', 2, 8000, 10000, 'Екран\r\nДіагональ екрану 15,6\'\'\r\nРоздільна здатність екрану 1366x768 HD\r\nПроцесор\r\nЦентральний процесор Intel Pentium\r\nМодель центрального процесора N4200\r\nКількість ядер 4 ядра\r\nЧастота центрального процесора 1,1 (2,5) ГГц\r\nОЗП\r\nОб\'єм ОЗУ 4 ГБ\r\nТип операти', 0, 'images/asus_r541na-go224t_10_1.jpg', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `Roles`
--

CREATE TABLE `Roles` (
  `id` int(11) NOT NULL,
  `role` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Roles`
--

INSERT INTO `Roles` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Customer');

-- --------------------------------------------------------

--
-- Структура таблицы `Sales`
--

CREATE TABLE `Sales` (
  `id` int(11) NOT NULL,
  `customername` varchar(32) DEFAULT NULL,
  `itemname` varchar(128) DEFAULT NULL,
  `pricein` int(11) DEFAULT NULL,
  `pricesale` int(11) DEFAULT NULL,
  `datesale` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `SubCategories`
--

CREATE TABLE `SubCategories` (
  `id` int(11) NOT NULL,
  `sucategory` varchar(64) NOT NULL,
  `catid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category` (`category`);

--
-- Индексы таблицы `Customers`
--
ALTER TABLE `Customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `roleid` (`roleid`);

--
-- Индексы таблицы `Images`
--
ALTER TABLE `Images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itemid` (`itemid`);

--
-- Индексы таблицы `Items`
--
ALTER TABLE `Items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catid` (`catid`);

--
-- Индексы таблицы `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role` (`role`);

--
-- Индексы таблицы `Sales`
--
ALTER TABLE `Sales`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `SubCategories`
--
ALTER TABLE `SubCategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sucategory` (`sucategory`),
  ADD KEY `catid` (`catid`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Categories`
--
ALTER TABLE `Categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `Customers`
--
ALTER TABLE `Customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `Images`
--
ALTER TABLE `Images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Items`
--
ALTER TABLE `Items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `Roles`
--
ALTER TABLE `Roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `Sales`
--
ALTER TABLE `Sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `SubCategories`
--
ALTER TABLE `SubCategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Customers`
--
ALTER TABLE `Customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`roleid`) REFERENCES `Roles` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `Images`
--
ALTER TABLE `Images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`itemid`) REFERENCES `Items` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `Items`
--
ALTER TABLE `Items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`catid`) REFERENCES `Categories` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `SubCategories`
--
ALTER TABLE `SubCategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`catid`) REFERENCES `Categories` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
