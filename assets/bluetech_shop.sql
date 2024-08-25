-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2024 at 12:35 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bluetech_shop`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk`
--

CREATE TABLE `koszyk` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `subtotal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `koszyk`
--

INSERT INTO `koszyk` (`id`, `id_user`, `subtotal`) VALUES
(5, 3, 8316),
(10, 5, 6048);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk_products`
--

CREATE TABLE `koszyk_products` (
  `id` int(11) NOT NULL,
  `id_koszyk` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `row_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `koszyk_products`
--

INSERT INTO `koszyk_products` (`id`, `id_koszyk`, `id_product`, `quantity`, `row_total`) VALUES
(15, 5, 1, 1, 3249),
(16, 5, 9, 2, 318),
(17, 5, 4, 5, 4749),
(43, 10, 1, 1, 3249),
(44, 10, 16, 1, 2799);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `img`) VALUES
(1, 'Gigabyte AORUS Stealth 500 RTX3070', 'Komputery', 3249, 'assets\\img products\\Gigabyte-AORUS-Stealth-500-RTX3070.jpg'),
(2, 'Xiaomi Redmi 12 4+128GB Sky Blue', 'Smartfony', 799, 'assets\\img products\\Xiaomi-Redmi-12-4+128GB-Sky-Blue.jpg'),
(3, 'LOGITECH HD Pro C920', 'Akcesoria', 369, 'assets\\img products\\Logitech-HD-Pro-C920.jpg'),
(4, 'Komputer Game X G300, Core i5-13400F, 32 GB, RTX 4', 'Komputery', 4749, 'assets\\img products\\Komputer-Game-X-G300-Core-i5_13400F-32GB-RTX-4060-Ti.jpg'),
(5, 'Komputer Kowalski Gaming Armis, Core i5-13400F, 32', 'Komputery', 4499, 'assets\\img products\\Komputer-Kowalski-Gaming-Armis-Core-i5_13400F-32GB-RTX-4060-Ti.jpg'),
(6, 'Dark Project DPO87 Violet Horizon Combo G3MS Sapph', 'Akcesoria', 219, 'assets\\img products\\Dark-Project-DPO87-Violet-Horizon-Combo-G3MS-Sapphire.jpg'),
(7, 'Gogle VR Oculus Meta Quest 3 128GB', 'Akcesoria', 2749, 'assets\\img products\\Gogle-VR-Oculus-Meta-Quest-3-128GB.jpg'),
(8, 'Podkładka PREYON Falcon Speed XXL', 'Akcesoria', 69, 'assets\\img products\\Podkładka-PREYON-Falcon-Speed-XXL.jpg'),
(9, 'Mysz Logitech G305 Lightspeed Czarna', 'Akcesoria', 159, 'assets\\img products\\Mysz-Logitech-G305-Lightspeed-Czarna.jpg'),
(10, 'Silver Monkey X Battlestation ARGB R5-5600/16GB/1T', 'Komputery', 4399, 'assets\\img products\\Silver-Monkey-X-Battlestation-ARGB-R5_5600-16GB-1TB-RTX4060-W11x.jpg'),
(11, 'Smartfon HTC U23 Pro 5G 8+256GB Biały', 'Smartfony', 1599, 'assets\\img products\\Smartfon-HTC-U23-Pro-5G-8+256GB-Biały.jpg'),
(12, 'Samsung Galaxy S24 Ultra 12GB/256GB Szary', 'Smartfony', 6599, 'assets\\img products\\Samsung-Galaxy-S24-Ultra-12+256GB-Szary.jpg'),
(13, 'Smartfon Samsung Galaxy A14 4+128GB Czarny', 'Smartfony', 679, 'assets\\img products\\Smartfon-Samsung-Galaxy-A14-4+128GB-Czarny.jpg'),
(14, 'HyperX Cloud II Headset (stalowoszare)', 'Akcesoria', 229, 'assets\\img products\\HyperX-Cloud-II-Headset-(stalowoszare).jpg'),
(15, 'Smartfon Xiaomi Redmi Note 12S 8+256GB Czarny', 'Smartfony', 908, 'assets\\img products\\Xiaomi-Redmi-12-4+128GB-Sky-Blue.jpg'),
(16, 'Komputer Dell Vostro 3910, Core i5-12400, 16 GB, I', 'Komputery', 2799, 'assets\\img products\\Komputer-Dell-Vostro-3910-Core-i5_12400-16GB-Intel-UHD-Graphics-730.jpg'),
(17, 'Dell Vostro 3710 SFF i5-12400/16GB/512/Win11P', 'Komputery', 3099, 'assets\\img products\\Dell-Vostro-3710-SFF-i5_12400-16GB-512-Win11P.jpg'),
(18, 'Apple iPhone 14 128GB Starlight', 'Smartfony', 3449, 'assets\\img products\\Apple-iPhone-14-128GB-Starlight.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `shop_order`
--

CREATE TABLE `shop_order` (
  `id` int(11) NOT NULL,
  `postcode` varchar(6) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `delivery` float DEFAULT NULL,
  `grandtotal` float DEFAULT NULL,
  `delivery_method` varchar(50) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `shop_order`
--

INSERT INTO `shop_order` (`id`, `postcode`, `city`, `street`, `delivery`, `grandtotal`, `delivery_method`, `first_name`, `last_name`, `phone`, `email`) VALUES
(1, '88-922', 'Katowice', 'Bożego 5', 30, 7335, 'Kurier za pobraniem', 'Mateusz', 'Zymeła', '+48132756324', 'mateuszzymela@gmail.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `first_name`, `last_name`, `email`) VALUES
(3, 'admin', '$2y$10$6glibg4viD4yxfOJdV2f9OD75L3eWniAnYCxbbukvSPkFdAZMJ1sK', 'Mateusz', 'Zymeła', 'mateuszzymela@gmail.com'),
(5, 'kowal', '$2y$10$44zIf3mjVWMqEBW2hAeAt.CmccCZU8Tf21Bq2JRMmKTmvN5uIIZvq', 'Adam', 'Adamski', 'kowal@o2.pl'),
(6, 'test', '$2y$10$nV0/kSn/jCQ/kofDbTzW2O2beGkNUGyGOIcGKDQ8TvWoNe9UU5gUu', 'Nauczyciel', 'Nauczycielski', 'nauczyciel@szkola.pl');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `KOSZYK_USER_ID_USER_ID` (`id_user`);

--
-- Indeksy dla tabeli `koszyk_products`
--
ALTER TABLE `koszyk_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `KOSZYK_ID` (`id_koszyk`),
  ADD KEY `PRODUCT_ID` (`id_product`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `shop_order`
--
ALTER TABLE `shop_order`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `koszyk`
--
ALTER TABLE `koszyk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `koszyk_products`
--
ALTER TABLE `koszyk_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `shop_order`
--
ALTER TABLE `shop_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `koszyk`
--
ALTER TABLE `koszyk`
  ADD CONSTRAINT `KOSZYK_USER_ID_USER_ID` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `koszyk_products`
--
ALTER TABLE `koszyk_products`
  ADD CONSTRAINT `KOSZYK_ID` FOREIGN KEY (`id_koszyk`) REFERENCES `koszyk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `PRODUCT_ID` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
