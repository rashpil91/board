-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Авг 27 2020 г., 17:37
-- Версия сервера: 10.4.14-MariaDB
-- Версия PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `board`
--

CREATE TABLE `board` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `falled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `board`
--

INSERT INTO `board` (`id`, `user_id`, `category`, `city`, `title`, `text`, `date`, `price`, `status`, `falled`) VALUES
(8, 5, 1, 4, 'Продам дом', 'Тёплый, красивый, удобный', 1598499415, 100000000, 1, 0),
(9, 5, 2, 2, 'Nissan', 'Технологии Nissan Intelligent Mobility меняют привычное представление о движении, вождении и интеграции автомобиля в повседневную жизнь. Новый Nissan Qashqai — это совершенное воплощение Nissan Intelligent Mobility. От Интеллектуальной системы помощи при парковке до Интеллектуальной системы экстренного торможения — новый Nissan Qashqai буквально соткан из технологий, обеспечивающих ваш комфорт и спокойствие за рулём.', 1598501272, 1350000, 1, 0),
(16, 5, 6, 1, 'Продам стиральную машину', 'Стиральная машина LG F4H5VS6W обладает мотором с прямым приводом без подвижных элементов, что способствует минимальному уровню шума в процессе работы, низкому потреблению электроэнергии и длительному сроку службы.\r\n\r\nБлагодаря предустановленным программам обеспечивается качественное удаление пятен с синтетических и деликатных тканей, детской и спортивной одежды, а также обработка вещей паром и выполнение дополнительного ополаскивания. В зависимости от степени загрязнения белья барабан двигается в шести различных направлениях.', 1598513786, 15000, 1, 0),
(17, 5, 2, 3, 'Продам автомобиль', 'Черный', 1598514012, 900000, 1, 0),
(18, 5, 6, 3, 'Продам телевизор', 'Широкоформатный телевизор', 1598514367, 50000, 1, 0),
(19, 5, 5, 1, 'Клоун на праздник', 'Цена за час', 1598514666, 5000, 1, 0),
(20, 5, 0, 0, '', '', 0, 0, 0, 1),
(21, 5, 4, 1, 'Заголовок', 'Описание', 1598515116, 2, 2, 0),
(22, 5, 3, 1, 'Продам мяч', 'Мяч футбольный', 1598519999, 500, 1, 0),
(23, 5, 0, 0, '', '', 0, 0, 0, 1),
(24, 6, 0, 0, '', '', 0, 0, 0, 1),
(25, 6, 2, 1, 'Продам велосипед', 'MTB, в комплекте: насос, велосипедная фляга и замок', 1598536179, 30000, 2, 0),
(26, 5, 0, 0, '', '', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Недвижимость'),
(2, 'Транспорт'),
(3, 'Личные вещи'),
(4, 'Хобби и отдых'),
(5, 'Услуги'),
(6, 'Бытовая техника');

-- --------------------------------------------------------

--
-- Структура таблицы `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `city`
--

INSERT INTO `city` (`id`, `name`) VALUES
(1, 'Моксва'),
(2, 'Санкт-Петербург'),
(3, 'Томск'),
(4, 'Саратов');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1598387833),
('m130524_201442_init', 1598387837),
('m190124_110200_add_verification_token_column_to_user_table', 1598387837);

-- --------------------------------------------------------

--
-- Структура таблицы `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `photo`
--

INSERT INTO `photo` (`id`, `board_id`, `date`, `filename`) VALUES
(3, 8, 1598494314, '1598494314_mdvoB.jpg'),
(21, 9, 1598513156, '1598513156_mjhZD.png'),
(23, 17, 1598513986, '1598513986_yfJlK.png'),
(24, 18, 1598514346, '1598514345_s0dmO.png'),
(25, 16, 1598514504, '1598514503_Vkegt.png'),
(26, 19, 1598514597, '1598514596_IMFag.png'),
(28, 25, 1598536168, '1598536166_eyzXm.jpg'),
(42, 22, 1598541827, '1598541827_EhI8b.png');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` int(11) NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `details` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`, `avatar`, `city`, `phone`, `details`) VALUES
(5, 'Имя', 'NXYGsz1Iw_Y7dfR4cN_qV1gkFUzkp2Br', '$2y$13$8SMj4N0PCc82O7/4s2UK8eM7SUrad3.ukMGLwyWdFVEHZ6DKro3ZK', NULL, 'new@new.ru', 10, 1598392538, 1598509194, 'iO-S-CVPd4vnGI9EdsFgfn-xyqBRfwY7_1598392538', '1598509194_-zmfY.png', 2, '9876543211', 'Звонить после 18:00'),
(6, 'Новый пользователь', 'mGdZja-RV5p_qRWkHBYAJxgnrdoNhJcO', '$2y$13$GsNLCN0ObKm.HKTDNkDoEOO74PQBK.IbVTFkv43l8Uk.YLUPACeuW', NULL, 'email@board.com', 10, 1598535912, 1598541904, '7g2n2CfVCZ4IPqrZATc-9uojGgrN5nxK_1598535912', '1598541904_4XiDG.png', 4, '1234567890', 'Звонить по выходным в любое время');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `board`
--
ALTER TABLE `board`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
