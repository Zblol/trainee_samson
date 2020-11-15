
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_samson`
--

-- --------------------------------------------------------

--
-- Структура таблицы `a_category`
--

CREATE TABLE `a_category`
(
    `категория_ид` int(11) NOT NULL,
    `код`        varchar(255)     DEFAULT NULL,
    `название`        varchar(255)     DEFAULT NULL,
    `родительский_ид`   int(11) NOT NULL DEFAULT '0'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `a_price`
--

CREATE TABLE `a_price`
(
    `товар_ид` int(11) NOT NULL,
    `тип`       varchar(255)   DEFAULT NULL,
    `цена`      decimal(15, 2) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `a_product`
--

CREATE TABLE `a_product`
(
    `товар_ид` int(11) NOT NULL,
    `код`       varchar(255) DEFAULT NULL,
    `название`       varchar(255) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `a_product_category`
--

CREATE TABLE `a_product_category`
(
    `товар_ид`  int(11) NOT NULL,
    `категория_ид` int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `a_property`
--

CREATE TABLE `a_property`
(
    `товар_ид` int(11) NOT NULL,
    `название`       varchar(255) DEFAULT NULL,
    `свойства`   varchar(255) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `a_category`
--
ALTER TABLE `a_category`
    ADD PRIMARY KEY (`категория_ид`);

--
-- Индексы таблицы `a_product`
--
ALTER TABLE `a_product`
    ADD PRIMARY KEY (`товар_ид`);

--
-- Индексы таблицы `a_product_category`
--
ALTER TABLE `a_product_category`
    ADD PRIMARY KEY (`товар_ид`, `категория_ид`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `a_category`
--
ALTER TABLE `a_category`
    MODIFY `категория_ид` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `a_product`
--
ALTER TABLE `a_product`
    MODIFY `товар_ид` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
