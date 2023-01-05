-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 05, 2023 at 03:58 AM
-- Server version: 5.7.36
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mis_maleki`
--

-- --------------------------------------------------------

--
-- Table structure for table `ms011_categories`
--

DROP TABLE IF EXISTS `ms011_categories`;
CREATE TABLE IF NOT EXISTS `ms011_categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'عنوان خالی',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT '0',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `cat_property` int(11) DEFAULT '0' COMMENT 'شناسه دسته خصوصبات که برای این دسته بندی فیلترینگش فعال میشود',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=544 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ms011_categories`
--

INSERT INTO `ms011_categories` (`id`, `parent_id`, `type`, `group_id`, `title`, `seo_title`, `seo_description`, `url`, `target`, `img`, `thumb`, `description`, `tags`, `value`, `icon`, `class`, `sort`, `status`, `cat_property`, `created_at`, `updated_at`) VALUES
(164, 167, 'post', 0, 'تلاش و پشتکار', NULL, NULL, '', '_self', 'photo_۲۰۲۰-۰۷-۱۱_۰۹-۳۳-۲۵.jpg', NULL, '', '', 'wqerwq', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(9, 0, 'post', 0, 'داستان زندگی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(167, 0, 'post', 0, 'رمز های موفقیت', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(168, 167, 'post', 0, 'مقاومت و سرسختی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(169, 167, 'post', 0, 'توکل', NULL, NULL, '', '_self', 'folder.png', NULL, '', '', 'rrrrr', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(170, 167, 'post', 0, 'استمرار در کار', NULL, NULL, '', '_self', 'film/apple-icon-144x144.png', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(175, 174, 'post', 0, 'سه تا پسر', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(176, 174, 'post', 0, 'یک دختر - ملکه قلب', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(178, 0, 'post', 0, 'ورزش', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(179, 0, 'post', 0, 'فیتنس', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(180, 0, 'post', 0, 'بادی بیلدینگ', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(181, 0, 'shop', 0, 'غذایی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(182, 0, 'shop', 0, 'پوشاک', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(183, 0, 'shop', 0, 'صنعتی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(184, 0, 'shop', 0, 'فست فود و رستوران', NULL, NULL, '', '_self', NULL, NULL, '', '', NULL, NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(235, 0, 'product', 0, 'کالای دیجیتال', 'عنوان سئو', 'توضیحات سئو', 'digital-product', '_self', 'galaxy-s22-ultra-onleaks-768x768-1.jpg', 'galaxy-s22-ultra-onleaks-768x768-1.jpg', '<h1>شامپو</h1>\r\n<p>با توجه به نقش پررنگ موها در زیبایی افراد، اهمیت زیادی دارد که برای انتخاب و خرید شامپو، به دنبال برندهای معتبر و محصولات حرفه ای باشید. انتخاب شامپو مناسب برای موهای معمولی، خشک یا چرب، کمک می کند تا ضمن شستشوی لازم، سلامت، شادابی و لطافت موها تامین شود.</p>\r\n<h2>انواع شامپو</h2>\r\n<p>با توجه به نوع مو، شامپوها به سه دسته معمولی، مخصوص موهای خشک و مخصوص موهای چرب تقسیم بندی می شوند. ترکیبات شامپوهای مخصوص موهای چرب، به حذف چربی زائد موها و پوست سر کمک کرده و موجب درخشش و لطافت موها می شوند. به طور مثال استفاده از عصاره لیمو در این محصولات، کمک می کند تا به راحتی چربی پوست سر از بین رفته و مشکل دائمی روغنی شدن تار موها، برطرف گردد.</p>\r\n<p>به همین شکل در محصولات مناسب موهای خشک، عصاره های ترمیم کننده چون عصاره آلوئه ورا یا روغن درخت چای استفاده می شود. در صورتی که به طور مستمر از این محصولات برای شستشوی موهای خود استفاده کنید، در کوتاه ترین مدت تاثیرگذاری آن ها در رفع خشکی موها را تجربه خواهید کرد.</p>\r\n<h2>شامپوهای تخصصی</h2>\r\n<p>شامپوهای تخصصی به گروهی از این محصولات گفته می شود که به طور خاص برای مشکلات و عارضه های مختلف مربوط به موها، فرموله شده اند. به طور مثال می توان به شامپوهای زیر در این گروه کالایی پرداخت:</p>\r\n<h3>شامپو ضدشوره</h3>\r\n<p>استفاده از ترکیبات ضدشوره از جمله پیریتیون روی، کتوکونازول، کلیمبازول، پیروکتون اولامین، سلنیوم سولفاید و ... در محصولات ضدشوره، به حذف دائمی شوره و بازگرداندن موها به سلامت اولیه و درخشش، کمک قطعی می کنند. برای خرید شامپو ضدشوره، دقت به اعتبار برند و همین طور مشخصات محصول داشته باشید.</p>\r\n<h3>شامپو حجم دهنده</h3>\r\n<p>شامپو حجم دهنده&nbsp;از روغن های گیاهی و ترکیبات ویتامینه استفاده کرده و یکی از بهترین آن ها، شامپوهای کراتینه و شامپو کافئین هستند. همین طور در سبد کالایی برندهایی چون پنتن، اویدرم، فولیکا، استم سل و ... نمونه هایی عالی را خواهید یافت.</p>\r\n<h3>شامپو ضدریزش</h3>\r\n<p>شامپو ضدریزش مو، برای استحکام بخشیدن به ریشه موها و همین طور تقویت ساقه ها و رفع خشکی فرموله شده اند. با انتخاب بهترین برند شامپو ضدریزش و همین طور استفاده مستمر از آن، ریزش موی شما متوقف شده و رفته رفته موها رشد دوباره خود را در بخش های ریخته شده از سر می گیرند. استفاده از عصاره آلوئه ورا، رزماری، ویتامین های E و B، روغن بابونه و ... در محصولات ضدریزش مو، به متوقف کردن این فرایند کمک می کنند.</p>\r\n<h3>شامپو حفاظت از رنگ مو</h3>\r\n<p>پس از رنگ کردن های مداوم، موها آسیب دیده، خشک و شکننده می شوند. در عین حال نگران هستیم که با شستشو رنگ موها از بین رفته و درخشش و جلای خود را از دست بدهد. شامپوهای بعد از رنگ مو، برای هر دو منظور بازگرداندن لطافت و نرمی موها و همین طور حفاظت از رنگ آن ها، مناسب هستند.</p>\r\n<h3>شامپو بدون سولفات</h3>\r\n<p>شامپوهای بدون سولفات در مقایسه با شامپوهای معمولی، کف کمتری حین شستشو خواهند داشت؛ اما عاری بودن این محصولات از سولفات، باعث می شود تا موها کمتر آسیب دیده و سالم تر باشند. این دسته از محصولات به طور خاص برای موهای خشک و آسیب دیده عالی هستند.</p>\r\n<h2>بهترین برندهای شامپو</h2>\r\n<p>از بهترین برندهای شامپو ایرانی می توان به برندهای&nbsp;<a href=\"https://mootanroo.com/alpecin-shampoo\">شامپو آلپسین</a>، سینره، فولیکا، مای، استم سل، کامان، سریتا و ... اشاره کرد. در میان محصولات این برندها، شامپوهای معمولی، شامپو مناسب موهای خشک و چرب، محصولات تخصصی ضدشوره، ضدریزش مو و ... را می یابید.</p>\r\n<p>همین طور در میان محصولات خارجی، برندهای داو، کلییر، لورآل، ایو روشه، گارنیه و ... دارای محصولات ممتازی هستند. با در نظر گرفتن جنس مو و مشکلات احتمالی که موهای شما دارند، محصولات حرفه ای از میان این برندها، کمک می کنند تا موهایی سالم و بانشاط داشته باشید.</p>\r\n<p><a href=\"https://mootanroo.com/Volumizing-shampoo\">شامپو حجم دهنده</a>&nbsp;&nbsp; &nbsp;&nbsp;<a href=\"https://mootanroo.com/Anti-hairfall-shampoos\">شامپو ضدریزش مو</a>&nbsp; &nbsp; &nbsp;<a href=\"https://mootanroo.com/sulfate-free-shampoo\">شامپو بدون سولفات</a>&nbsp; &nbsp; &nbsp;<a href=\"https://mootanroo.com/keratin-shampoo\">شامپو کراتین</a>&nbsp; &nbsp; &nbsp;<a href=\"https://mootanroo.com/oily-hair-shampoo\">شامپو برای موهای چرب</a>&nbsp; &nbsp; &nbsp;<a href=\"https://mootanroo.com/dry-hair-shampoo\">شامپو برای موهای خشک</a></p>\r\n<p><a href=\"https://mootanroo.com/hair-care-products\">محصولات مراقبت از مو</a>&nbsp;|&nbsp;<a href=\"https://mootanroo.com/hair-strengthening-products\">تقویت کننده مو</a>&nbsp;|&nbsp;<a href=\"https://mootanroo.com/hair-cream\">کرم مو</a>&nbsp;|&nbsp;<a href=\"https://mootanroo.com/hair-oils\">روغن مو</a>&nbsp;|&nbsp;<a href=\"https://mootanroo.com/hair-serum\">سرم مو</a>&nbsp;|&nbsp;<a href=\"https://mootanroo.com/hair-mask\">ماسک مو</a>&nbsp;|&nbsp;<a href=\"https://mootanroo.com/hair-conditioner\">نرم کننده مو</a></p>', '', NULL, NULL, NULL, 1, 'active', 468, '2022-01-06 03:32:58', '2022-10-30 04:18:13'),
(236, 0, 'product', 0, 'خانگی', NULL, NULL, 'khanegi', '_self', '5563676.jpg', 'index-page/khanegi.jpg', '', '', NULL, NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-09 14:48:40'),
(237, 0, 'product', 0, 'ابزار و تجهیزات صنعتی', NULL, NULL, 'tajhizat', '_self', '8127537_big.jpg', 'index-page/tajhizat.jpg', '', '', NULL, NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-09 14:49:35'),
(239, 0, 'product', 0, 'زیبایی و سلامت', NULL, NULL, 'zibaye', '_self', '1347474247_12_01.jpg', 'index-page/zibaye.jpg', '', '', NULL, NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-09 14:51:18'),
(238, 0, 'product', 0, 'مد و پوشاک', NULL, NULL, 'lebas', '_self', 'modposhak.jpg', 'index-page/lebas.jpg', '', '', NULL, NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-09 14:50:30'),
(240, 235, 'product', 0, 'گوشی موبایل', 'گوشی موبایل', NULL, 'mobile', '_self', 'صفحه اول/banner-lg-01.gif', 'cat-icon/mobile.png', '', '', NULL, NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-12-21 05:56:02'),
(241, 240, 'product', 0, 'سامسونگ', NULL, NULL, 'mobile-sumsung', '_self', NULL, NULL, '', '', NULL, NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-12 07:06:23'),
(251, 240, 'product', 0, 'اپل', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(243, 240, 'product', 0, 'شیائومی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(244, 240, 'product', 0, 'نوکیا', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(245, 235, 'product', 0, 'لوازم جانبی گوشی', 'لوازم جانبی موبایل', NULL, 'janebi-mobile', '_self', NULL, 'cat-icon/airpod.png', '', '', NULL, NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-12-21 05:55:38'),
(246, 235, 'product', 0, 'واقعیت مجازی', 'واقعیت مجازی', NULL, 'vr', '_self', 'ar-dmacourse.jpg', 'cat-icon/vr.png', '', '', NULL, NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-12-21 05:56:23'),
(247, 246, 'product', 0, 'لنوو', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(248, 246, 'product', 0, 'ایسوز', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(249, 246, 'product', 0, 'سونی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(250, 240, 'product', 0, 'گوگل پیکسل', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(252, 236, 'product', 0, 'محصولات چوبی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(253, 252, 'product', 0, 'میز تحریر', NULL, NULL, 'tahrir', '_self', NULL, NULL, '', '', NULL, NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(254, 235, 'product', 0, 'مچ بند و ساعت هوشمند', 'مچ بند و ساعت هوشمند', NULL, 'smart-watch', '_self', NULL, 'cat-icon/smartwatch.png', '', '', NULL, NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-12-21 05:56:50'),
(255, 235, 'product', 0, 'هد فون هدست هندزفری', 'هد فون هدست هندزفری', NULL, 'headphon', '_self', NULL, 'cat-icon/هدفون.png', '', '', NULL, NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-12-21 05:57:08'),
(256, 235, 'product', 0, 'اسپیکر بلوتوث و با سیم', 'اسپیکر بلوتوث و با سیم', NULL, 'speaker', '_self', NULL, 'cat-icon/speaker.png', '', '', NULL, NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-12-21 05:57:28'),
(265, 0, 'shop', 0, 'محصولات چوبی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(258, 235, 'product', 0, 'هارد و فلش ssd', 'هارد و فلش ssd', NULL, 'flash-memory', '_self', NULL, 'cat-icon/usb-flash.png', '', '', NULL, NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-12-21 05:57:52'),
(259, 235, 'product', 0, 'دوربین', 'دوربین', NULL, 'camera', '_self', NULL, 'cat-icon/camera.png', '', '', NULL, NULL, NULL, 8, 'active', NULL, '2022-01-06 03:32:58', '2022-12-21 05:58:06'),
(260, 235, 'product', 0, 'لوازم جانبی دوربین', 'لوازم جانبی دوربین', NULL, 'cemera-tools', '_self', NULL, 'cat-icon/cameaq-tools.png', '', '', NULL, NULL, NULL, 9, 'active', NULL, '2022-01-06 03:32:58', '2022-12-21 05:58:28'),
(261, 235, 'product', 0, 'دوربین دوچشمی و شکاری', 'دوربین دوچشمی و شکاری', NULL, 'camera-perofetional', '_self', NULL, 'cat-icon/binoculars.png', '', '', NULL, NULL, NULL, 10, 'active', NULL, '2022-01-06 03:32:58', '2022-12-21 06:02:29'),
(262, 0, 'product', 0, 'کتاب ، لوازم تحریر و هنر', NULL, NULL, 'ketab', '_self', 'ketab.jpg', 'index-page/ketab.jpg', '', '', NULL, NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-09 14:52:15'),
(263, 0, 'product', 0, 'اسباب بازی کودک و نوزاد', NULL, NULL, 'asbabbazi', '_self', 'qqtdavxioo2j.jpeg', 'index-page/asbabbazi.jpg', '', '', NULL, NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-07-09 14:52:51'),
(264, 0, 'product', 0, 'ورزش و سفر', NULL, NULL, 'sport', '_self', 'shakhes-1.jpg', 'index-page/sport.png', '', '', NULL, NULL, NULL, 8, 'active', NULL, '2022-01-06 03:32:58', '2022-07-09 14:55:19'),
(266, 0, 'shop', 0, 'تجاری و زنجیره ای', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(267, 252, 'product', 0, 'کمد لباس', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(268, 252, 'product', 0, 'میز ناهارخوری', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(269, 252, 'product', 0, 'بوفه و آینه', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(270, 252, 'product', 0, 'تخت خواب', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(271, 252, 'product', 0, 'مبل و صندلی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(272, 236, 'product', 0, 'محصولات برقی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(273, 236, 'product', 0, 'ظروف کریستال', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(274, 236, 'product', 0, 'وسایل آشپزخانه', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(275, 272, 'product', 0, 'هم زن', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(276, 272, 'product', 0, 'جاروبرقی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(277, 272, 'product', 0, 'ماشین لباسشویی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(278, 273, 'product', 0, 'میوه خوری', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(279, 273, 'product', 0, 'شیرینی خوری', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(280, 273, 'product', 0, 'چای خوری', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(446, 0, 'portfolio', 0, 'شخصی', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(439, 0, 'index-menu', 0, 'نمایش فروشگاه', NULL, NULL, '{SITE_URL}/shop', '_self', NULL, NULL, NULL, NULL, NULL, '<i class=\"bi bi-shop font-medium\"></i>', NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-13 05:27:03'),
(444, 0, 'portfolio', 0, 'خبری', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(445, 0, 'portfolio', 0, 'چند فروشگاهی', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(443, 0, 'portfolio', 0, 'فروشگاهی', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(286, 237, 'product', 0, 'ابزار و یراق', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(287, 286, 'product', 0, 'سنگ چرخ', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(288, 286, 'product', 0, 'انبردست', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(289, 286, 'product', 0, 'پیچ کوشتی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(290, 286, 'product', 0, 'مته - دریلر', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(291, 286, 'product', 0, 'انواع آچار', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(292, 286, 'product', 0, 'یراق آلات', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(293, 286, 'product', 0, 'بوکس و شش پری', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(294, 237, 'product', 0, 'قطعات خودرو', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(295, 294, 'product', 0, 'چرخ و لاستیک', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(296, 294, 'product', 0, 'جلوبندی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(297, 294, 'product', 0, 'موتور و سوپاپ', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(298, 294, 'product', 0, 'سپر و اینه', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(299, 294, 'product', 0, 'شیشه و دستگیره', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(300, 294, 'product', 0, 'برقی و اتصالات', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(301, 294, 'product', 0, 'یدک و کمکی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(302, 294, 'product', 0, 'زنجیر چرخ', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 8, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(303, 294, 'product', 0, 'گیربکس و میل گاردن', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 9, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(304, 294, 'product', 0, 'موتور و سیلندر', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 10, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(305, 238, 'product', 0, 'لباسهای زنانه', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(306, 305, 'product', 0, 'دکلت', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(307, 305, 'product', 0, 'شومیز', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(308, 305, 'product', 0, 'رومیز', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(309, 305, 'product', 0, 'پیراهن', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(310, 305, 'product', 0, 'لباس خواب', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(311, 305, 'product', 0, 'لباس بیدار', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(312, 305, 'product', 0, 'دامن', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(313, 305, 'product', 0, 'شلوار ', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 8, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(314, 305, 'product', 0, 'ساپورت', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 9, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(315, 305, 'product', 0, 'لباس زیر', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 10, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(316, 305, 'product', 0, 'لباس رو', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 11, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(317, 238, 'product', 0, ' لباس های بچه گانه', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(318, 317, 'product', 0, 'پیراهن شلوار', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(319, 317, 'product', 0, 'بلوز', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(320, 317, 'product', 0, 'بافت', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(321, 317, 'product', 0, 'آستین کوتاه', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(322, 317, 'product', 0, 'آستین بلند', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(323, 317, 'product', 0, 'لباس راحتی فرزند', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(324, 317, 'product', 0, 'لباس مهمانی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(325, 317, 'product', 0, 'لباس پلوخوری', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 8, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(326, 238, 'product', 0, ' لباس های مردانه', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(327, 326, 'product', 0, 'لباس مجلسی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(328, 326, 'product', 0, 'کت و شلوار', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(329, 326, 'product', 0, 'جلیه', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(330, 326, 'product', 0, 'پیراهن', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(331, 326, 'product', 0, 'لباس خانگی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(332, 326, 'product', 0, 'سوییشرت', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(333, 326, 'product', 0, 'بافتنی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(334, 326, 'product', 0, 'هاوایی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 8, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(335, 326, 'product', 0, 'لباس زیر', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 9, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(336, 326, 'product', 0, 'تابستانه', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 10, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(337, 239, 'product', 0, 'لوازم آرایشی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(338, 337, 'product', 0, 'کرم های صورت', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(339, 337, 'product', 0, 'پودر و مات کننده', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(340, 337, 'product', 0, 'رنگ مو', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(341, 337, 'product', 0, 'براش های آرایشی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(342, 337, 'product', 0, 'ست کامل ', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(343, 337, 'product', 0, 'دستگاه لیزر', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(344, 337, 'product', 0, 'ماشین اپیلاسیون', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(345, 337, 'product', 0, 'ابزار ارایشی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 8, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(346, 337, 'product', 0, 'روغن های پوست', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 9, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(347, 337, 'product', 0, 'شنیون', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 10, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(348, 239, 'product', 0, 'لوازم بهداشتی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(349, 348, 'product', 0, 'پد های پاک کننده', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(350, 348, 'product', 0, 'شامپوهای سر', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(351, 348, 'product', 0, 'الکل و تمیز کننده', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(352, 348, 'product', 0, 'لوازم محافظتی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(353, 348, 'product', 0, 'روان کننده های بهداشتی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(354, 348, 'product', 0, 'مسواک و دندان', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(355, 348, 'product', 0, 'نخ دندان', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(356, 348, 'product', 0, 'پنبه و الیاف پاک ککنده', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 8, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(357, 262, 'product', 0, 'کتاب هنری', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(358, 357, 'product', 0, 'نحوه نقاشی کردن', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(359, 357, 'product', 0, 'قلم زنی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(360, 357, 'product', 0, 'شمسه و تذهیب', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(361, 357, 'product', 0, 'معماری اسلامی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(362, 357, 'product', 0, 'معماری مدرن', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(363, 357, 'product', 0, 'آموزش هنر', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(364, 357, 'product', 0, 'چگونه بیاموزیم', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(365, 262, 'product', 0, 'رمان و درام', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(366, 365, 'product', 0, 'رومئو و ژولیت', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(367, 365, 'product', 0, 'شکسپیر', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(368, 365, 'product', 0, 'نویسندگن مشهور', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(369, 365, 'product', 0, 'رمان های ایرانی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(370, 365, 'product', 0, 'پیشنهادات خارجی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(371, 365, 'product', 0, 'سبک کلاسیک', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(372, 365, 'product', 0, 'سبک مدرن', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(373, 262, 'product', 0, 'کتاب های مصور', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(374, 373, 'product', 0, 'داستانهای جنگی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(375, 373, 'product', 0, 'عاشقانه', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(376, 373, 'product', 0, 'فلسفی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(377, 373, 'product', 0, 'جنایی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(378, 373, 'product', 0, 'پلیسی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(379, 373, 'product', 0, 'ژانر علمی و تخیلی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(380, 263, 'product', 0, 'اسبا بازی پسرانه', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(381, 380, 'product', 0, 'تفنگهای پلاستیکی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(382, 380, 'product', 0, 'خودرو برقی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(383, 380, 'product', 0, 'رو روعک', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(384, 380, 'product', 0, 'کمان', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(385, 380, 'product', 0, 'تیرکمان سنگی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(386, 380, 'product', 0, 'نیزه پلاستیکی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(387, 380, 'product', 0, 'آب پاش برقی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(388, 380, 'product', 0, 'اسکوتر', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 8, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(389, 263, 'product', 0, 'اسباب بازی دخترانه', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(390, 389, 'product', 0, 'عروسک', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(391, 389, 'product', 0, 'ادمک های برقی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(392, 389, 'product', 0, 'ظروف اشپزخانه پلاستیکی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(393, 389, 'product', 0, 'لباس های کوچک', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(394, 389, 'product', 0, 'لوازم دخترانه ظاهری', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(395, 389, 'product', 0, 'دستگاههای اشپزی کوچک', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(396, 389, 'product', 0, 'برس و شانه پلاستیکی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(397, 264, 'product', 0, 'کوهنوردی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(398, 397, 'product', 0, 'طناب', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(399, 397, 'product', 0, 'گیره های فلزی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(400, 397, 'product', 0, 'عصای کوهنوردی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(401, 397, 'product', 0, 'کلاه', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(402, 397, 'product', 0, 'عینک نورگیر', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(403, 397, 'product', 0, 'کفش سنگ شکن', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(404, 397, 'product', 0, 'لباس های گرم', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(405, 397, 'product', 0, 'دستکش ها', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 8, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(406, 264, 'product', 0, 'استادیوم', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(407, 406, 'product', 0, 'پیراهن ورزشی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(408, 406, 'product', 0, 'شورت ورزشی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(409, 406, 'product', 0, 'توپ', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(410, 406, 'product', 0, 'انواع راکد', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(411, 406, 'product', 0, 'کفش', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(412, 406, 'product', 0, 'البسه مناسب', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(413, 264, 'product', 0, 'فکری', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(414, 413, 'product', 0, 'شطرنج', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(415, 413, 'product', 0, 'منچ', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(416, 413, 'product', 0, 'مارپله', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(417, 413, 'product', 0, 'تخنه نرد', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(418, 413, 'product', 0, 'ایروپولی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(419, 0, 'index-menu', 0, 'تماس با ما', NULL, NULL, '{SITE_URL}/contact', '_self', NULL, NULL, '', '', NULL, '<i class=\"bi bi-telephone-fill font-medium\"></i>', NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-07-28 07:49:40'),
(420, 0, 'index-menu', 0, 'درباره ما', NULL, NULL, '{SITE_URL}/about', '_self', NULL, NULL, '', '', NULL, '<i class=\"bi bi-file-earmark-ruled font-medium\"></i>', NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-07-28 07:49:55'),
(422, 245, 'product', 0, 'شارژر', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(423, 245, 'product', 0, 'متعلقات', NULL, NULL, 'متعلقات-مجازی', '_self', NULL, NULL, '', '', NULL, NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(424, 0, 'post', 0, 'علم و  تکنولوژی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(425, 424, 'post', 0, 'موبایل و گجت', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 1, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(426, 424, 'post', 0, 'اپلیکشن و نرم افزار', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 2, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(427, 424, 'post', 0, 'تجارت الکترونیک', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(428, 424, 'post', 0, 'خودرو و حمل و نقل', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 4, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(429, 424, 'post', 0, 'زمین و محیط زیست', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(430, 424, 'post', 0, 'هوا فضا', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(431, 0, 'post', 0, 'بازی ویدئویی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(432, 0, 'post', 0, 'کتاب و ادبیات', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 8, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(433, 0, 'post', 0, 'هنر و سینما', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 9, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(434, 0, 'post', 0, 'سبک زندگی', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 10, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(435, 0, 'index-menu', 0, 'نمونه وبلاگ', NULL, NULL, '{SITE_URL}/blog', '_self', NULL, NULL, '', '', NULL, '<i class=\"bi bi-file-earmark-post font-medium\"></i>', NULL, 3, 'active', NULL, '2022-01-06 03:32:58', '2022-07-13 05:28:18'),
(436, 305, 'product', 0, 'تیشرت', NULL, NULL, '', '_self', '', NULL, '', '', '', NULL, NULL, 12, 'active', NULL, '2022-01-06 03:32:58', '2022-07-06 14:58:35'),
(463, 0, 'index-menu', 0, 'اسکریپت چند فروشگاهی یکتا شاپ', NULL, NULL, '{SITE_URL}/digishop', '_self', NULL, NULL, NULL, NULL, NULL, '<i class=\"bi bi-sun font-medium vertical-align-middle\"></i>', 'text-danger', 7, 'active', NULL, '2022-02-23 20:09:21', '2022-07-28 07:50:12'),
(447, 0, 'portfolio', 0, 'شرکتی', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(448, 0, 'portfolio', 0, 'استارت اپ', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(449, 0, 'portfolio', 0, 'تولید و معرفی', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(450, 0, 'portfolio', 0, 'رستوران', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, 'active', NULL, '2022-01-06 03:32:58', '2022-01-06 03:32:58'),
(462, 0, 'index-menu', 0, 'منو با آیکن و رنگ', NULL, NULL, '{SITE_URL}/contact', '_self', NULL, NULL, NULL, NULL, NULL, '<i class=\"bi bi-columns-gap font-medium vertical-align-middle\"></i>', 'text-info', 6, 'active', NULL, '2022-02-23 20:09:21', '2022-07-28 07:50:04'),
(454, 0, 'footer-menu', 0, 'بخوانید و بدانید', NULL, NULL, '{SITE_URL}', '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'active', NULL, '2022-01-06 12:25:25', '2022-01-13 04:10:08'),
(455, 0, 'footer-menu', 0, 'پاسخ به پرسش‌های متداول', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 'active', NULL, '2022-01-06 12:25:25', '2022-01-13 04:10:08'),
(456, 0, 'footer-menu', 0, 'رویه‌های بازگرداندن کالا', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 'active', NULL, '2022-01-06 12:25:25', '2022-01-13 04:10:08'),
(457, 0, 'footer-menu', 0, 'شرایط استفاده', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 'active', NULL, '2022-01-13 04:08:56', '2022-01-13 04:10:08'),
(458, 0, 'footer-menu', 0, 'حریم خصوصی', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, 'active', NULL, '2022-01-13 04:08:56', '2022-01-13 04:10:08'),
(464, 0, 'index-menu', 0, 'سوالی دارید ؟', NULL, NULL, '{SITE_URL}/contact', '_self', NULL, NULL, NULL, NULL, NULL, '<i class=\"bi bi-patch-question font-medium vertical-align-middle\"></i>', 'text-warning', 8, 'active', NULL, '2022-02-23 20:11:18', '2022-07-28 07:50:21'),
(466, 241, 'product', 0, 'گوشی های پرچمدار (سری S)', 'سئو عنوان', 'سئو توضیحات', 'گوشی-ایفون', '_self', 'contentiphon13-1.jpg', 'contentiphon13-1.jpg', '<h1>شامپو</h1>\r\n<p>با توجه به نقش پررنگ موها در زیبایی افراد، اهمیت زیادی دارد که برای انتخاب و خرید شامپو، به دنبال برندهای معتبر و محصولات حرفه ای باشید. انتخاب شامپو مناسب برای موهای معمولی، خشک یا چرب، کمک می کند تا ضمن شستشوی لازم، سلامت، شادابی و لطافت موها تامین شود.</p>\r\n<h2>انواع شامپو</h2>\r\n<p>با توجه به نوع مو، شامپوها به سه دسته معمولی، مخصوص موهای خشک و مخصوص موهای چرب تقسیم بندی می شوند. ترکیبات شامپوهای مخصوص موهای چرب، به حذف چربی زائد موها و پوست سر کمک کرده و موجب درخشش و لطافت موها می شوند. به طور مثال استفاده از عصاره لیمو در این محصولات، کمک می کند تا به راحتی چربی پوست سر از بین رفته و مشکل دائمی روغنی شدن تار موها، برطرف گردد.</p>\r\n<p>به همین شکل در محصولات مناسب موهای خشک، عصاره های ترمیم کننده چون عصاره آلوئه ورا یا روغن درخت چای استفاده می شود. در صورتی که به طور مستمر از این محصولات برای شستشوی موهای خود استفاده کنید، در کوتاه ترین مدت تاثیرگذاری آن ها در رفع خشکی موها را تجربه خواهید کرد.</p>\r\n<h2>شامپوهای تخصصی</h2>\r\n<p>شامپوهای تخصصی به گروهی از این محصولات گفته می شود که به طور خاص برای مشکلات و عارضه های مختلف مربوط به موها، فرموله شده اند. به طور مثال می توان به شامپوهای زیر در این گروه کالایی پرداخت:</p>\r\n<h3>شامپو ضدشوره</h3>\r\n<p>استفاده از ترکیبات ضدشوره از جمله پیریتیون روی، کتوکونازول، کلیمبازول، پیروکتون اولامین، سلنیوم سولفاید و ... در محصولات ضدشوره، به حذف دائمی شوره و بازگرداندن موها به سلامت اولیه و درخشش، کمک قطعی می کنند. برای خرید شامپو ضدشوره، دقت به اعتبار برند و همین طور مشخصات محصول داشته باشید.</p>\r\n<h3>شامپو حجم دهنده</h3>\r\n<p>شامپو حجم دهنده&nbsp;از روغن های گیاهی و ترکیبات ویتامینه استفاده کرده و یکی از بهترین آن ها، شامپوهای کراتینه و شامپو کافئین هستند. همین طور در سبد کالایی برندهایی چون پنتن، اویدرم، فولیکا، استم سل و ... نمونه هایی عالی را خواهید یافت.</p>\r\n<h3>شامپو ضدریزش</h3>\r\n<p>شامپو ضدریزش مو، برای استحکام بخشیدن به ریشه موها و همین طور تقویت ساقه ها و رفع خشکی فرموله شده اند. با انتخاب بهترین برند شامپو ضدریزش و همین طور استفاده مستمر از آن، ریزش موی شما متوقف شده و رفته رفته موها رشد دوباره خود را در بخش های ریخته شده از سر می گیرند. استفاده از عصاره آلوئه ورا، رزماری، ویتامین های E و B، روغن بابونه و ... در محصولات ضدریزش مو، به متوقف کردن این فرایند کمک می کنند.</p>\r\n<h3>شامپو حفاظت از رنگ مو</h3>\r\n<p>پس از رنگ کردن های مداوم، موها آسیب دیده، خشک و شکننده می شوند. در عین حال نگران هستیم که با شستشو رنگ موها از بین رفته و درخشش و جلای خود را از دست بدهد. شامپوهای بعد از رنگ مو، برای هر دو منظور بازگرداندن لطافت و نرمی موها و همین طور حفاظت از رنگ آن ها، مناسب هستند.</p>\r\n<h3>شامپو بدون سولفات</h3>\r\n<p>شامپوهای بدون سولفات در مقایسه با شامپوهای معمولی، کف کمتری حین شستشو خواهند داشت؛ اما عاری بودن این محصولات از سولفات، باعث می شود تا موها کمتر آسیب دیده و سالم تر باشند. این دسته از محصولات به طور خاص برای موهای خشک و آسیب دیده عالی هستند.</p>\r\n<h2>بهترین برندهای شامپو</h2>\r\n<p>از بهترین برندهای شامپو ایرانی می توان به برندهای&nbsp;<a href=\"https://mootanroo.com/alpecin-shampoo\">شامپو آلپسین</a>، سینره، فولیکا، مای، استم سل، کامان، سریتا و ... اشاره کرد. در میان محصولات این برندها، شامپوهای معمولی، شامپو مناسب موهای خشک و چرب، محصولات تخصصی ضدشوره، ضدریزش مو و ... را می یابید.</p>\r\n<p>همین طور در میان محصولات خارجی، برندهای داو، کلییر، لورآل، ایو روشه، گارنیه و ... دارای محصولات ممتازی هستند. با در نظر گرفتن جنس مو و مشکلات احتمالی که موهای شما دارند، محصولات حرفه ای از میان این برندها، کمک می کنند تا موهایی سالم و بانشاط داشته باشید.</p>\r\n<p><a href=\"https://mootanroo.com/Volumizing-shampoo\">شامپو حجم دهنده</a>&nbsp;&nbsp; &nbsp;&nbsp;<a href=\"https://mootanroo.com/Anti-hairfall-shampoos\">شامپو ضدریزش مو</a>&nbsp; &nbsp; &nbsp;<a href=\"https://mootanroo.com/sulfate-free-shampoo\">شامپو بدون سولفات</a>&nbsp; &nbsp; &nbsp;<a href=\"https://mootanroo.com/keratin-shampoo\">شامپو کراتین</a>&nbsp; &nbsp; &nbsp;<a href=\"https://mootanroo.com/oily-hair-shampoo\">شامپو برای موهای چرب</a>&nbsp; &nbsp; &nbsp;<a href=\"https://mootanroo.com/dry-hair-shampoo\">شامپو برای موهای خشک</a></p>\r\n<p><a href=\"https://mootanroo.com/hair-care-products\">محصولات مراقبت از مو</a>&nbsp;|&nbsp;<a href=\"https://mootanroo.com/hair-strengthening-products\">تقویت کننده مو</a>&nbsp;|&nbsp;<a href=\"https://mootanroo.com/hair-cream\">کرم مو</a>&nbsp;|&nbsp;<a href=\"https://mootanroo.com/hair-oils\">روغن مو</a>&nbsp;|&nbsp;<a href=\"https://mootanroo.com/hair-serum\">سرم مو</a>&nbsp;|&nbsp;<a href=\"https://mootanroo.com/hair-mask\">ماسک مو</a>&nbsp;|&nbsp;<a href=\"https://mootanroo.com/hair-conditioner\">نرم کننده مو</a></p>', NULL, NULL, 'vvv', 'aaa', 1, 'active', NULL, '2022-02-24 08:51:12', '2022-09-13 07:21:51'),
(467, 241, 'product', 0, 'گوشی های سری A', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'active', NULL, '2022-02-24 08:51:12', '2022-07-06 14:58:35'),
(468, 0, 'cat_property', 0, 'مشخصات موبایل', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'active', NULL, '2022-02-28 14:11:43', NULL),
(469, 0, 'cat_property', 0, 'پارچه و لباس و البسه', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'active', NULL, '2022-02-28 14:30:51', '2022-02-28 14:31:54'),
(470, 0, 'cat_property', 0, 'لوازم آشپزخانه', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'active', NULL, '2022-03-03 13:48:47', NULL),
(471, 0, 'cat_property', 0, 'وسایل دکوراسیون', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 'active', NULL, '2022-03-03 13:48:59', NULL),
(472, 0, 'cat_property', 0, 'ویژگی های بهداشتی', NULL, NULL, NULL, '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 'active', NULL, '2022-03-03 13:49:08', NULL),
(474, 0, 'index-menu', 0, 'چند عمقی محصولات', NULL, NULL, '#', '_self', NULL, NULL, NULL, NULL, NULL, '<i class=\"fal fa-bars\"></i>', 'toggle-level-menu d-xl-none', 1, 'active', NULL, '2022-03-16 10:08:28', '2022-08-18 05:55:04'),
(476, 0, 'footer-menu2', 0, 'نحوه ثبت سفارش', NULL, NULL, '', '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'active', NULL, '2022-07-29 16:06:16', NULL),
(477, 0, 'footer-menu2', 0, 'رویه ارسال سفارش', NULL, NULL, '', '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'active', NULL, '2022-07-29 16:06:16', NULL),
(478, 0, 'footer-menu2', 0, 'شیوه های پرداخت', NULL, NULL, '', '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 'active', NULL, '2022-07-29 16:06:16', NULL),
(479, 0, 'footer-menu2', 0, 'شرایط استفاده', NULL, NULL, '', '_self', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 'active', NULL, '2022-07-29 16:06:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ms011_login_info`
--

DROP TABLE IF EXISTS `ms011_login_info`;
CREATE TABLE IF NOT EXISTS `ms011_login_info` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(198) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'اطلاعات مرورگر',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=493 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ms011_login_info`
--

INSERT INTO `ms011_login_info` (`id`, `user_id`, `username`, `ip`, `agent`, `created_at`) VALUES
(492, 412, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', '2023-01-04 19:55:36'),
(486, 434, 'maleki', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', '2023-01-01 14:08:21'),
(487, 434, 'maleki', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', '2023-01-01 14:28:30'),
(488, 412, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', '2023-01-04 16:37:58'),
(489, 412, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', '2023-01-04 17:55:28'),
(490, 437, 'admin_09156250277', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', '2023-01-04 18:40:18'),
(491, 437, 'admin_09156250277', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', '2023-01-04 18:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `ms011_migrations`
--

DROP TABLE IF EXISTS `ms011_migrations`;
CREATE TABLE IF NOT EXISTS `ms011_migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ms011_migrations`
--

INSERT INTO `ms011_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_12_02_132401_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ms011_options`
--

DROP TABLE IF EXISTS `ms011_options`;
CREATE TABLE IF NOT EXISTS `ms011_options` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `json` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `ms011_options`
--

INSERT INTO `ms011_options` (`id`, `key`, `value`, `description`, `json`, `created_at`, `updated_at`) VALUES
(62, 'them_setting', NULL, '', '{\"menu_dark\":\"false\",\"menu_color\":\"gradient-45deg-indigo-purple\",\"menu_select_rounded\":\"sidenav-active-rounded\",\"collaps_menu\":\"false\",\"navbar_color\":\"gradient-45deg-indigo-purple\",\"navbar_fix\":\"true\",\"footer_dark\":\"false\",\"footer_fix\":\"false\"}', '2021-01-26 06:50:03', '2022-11-25 14:17:01'),
(63, 'currency', 'تومان', NULL, NULL, '2021-02-09 07:11:44', '2022-12-03 13:01:04'),
(64, 'blog_title', 'فروشگاه آنلاین یکتا شاپ', NULL, NULL, '2021-02-09 13:59:21', '2022-07-13 04:33:51'),
(65, 'description', 'طراحی وب سایت | اپلیکشن های تحت وب | نرم افزار املاک | سامانه های مدیریتی | سامانه های تحت وب | فروشگاه اینترنتی | چند فروشگاهی | وب سایت مشاور املاک | طراحی وب سایت خبری | پرتال آموزشی | وب سایت مدارس | سامانه آزمون انلاین | وب سایت شرکتی | طراحی وب سایت در مازندران | طراحی وب سایت در بابل | طراحی وب سایت در ساری | طراحی فروشگاه انلاین در بابل', NULL, NULL, '2021-02-09 13:59:32', '2022-07-13 04:33:51'),
(66, 'sms_server', 'http://payamak-service.ir/SendService.svc?wsdl', NULL, NULL, '2021-02-09 14:05:54', '2022-05-16 21:09:00'),
(106, 'refresh_time', '60000', NULL, NULL, '2021-11-24 14:38:20', '2022-07-13 04:33:51'),
(67, 'sms_user', 't.mohammadshoja65', NULL, NULL, '2021-02-09 14:05:59', '2022-05-16 21:09:00'),
(68, 'sms_password', 'qqe@850', NULL, NULL, '2021-02-09 14:06:04', '2022-05-16 21:09:00'),
(69, 'sms_line', '10000000005', NULL, NULL, '2021-02-09 14:06:09', '2022-05-16 21:09:00'),
(72, 'tags', 'طراحی وب سایت,طراحی وب سایت در مازندران,طراحی وب سایت در بابل,طراحی وب سایت در ساری,طراحی وب سایت فروشگاهی,طراحی وب سایت شرکتی,طراحی وب سایت مدارس,فروشگاه انلاین,چند فروشگاهی,سامانه ازمون انلاین,اپلیکیشن های تحت وب,وب سایت خبری,website,online shop,online store,babol,mazandaran,sari,ghaemshahr,application,mobile', NULL, NULL, '2021-02-10 04:54:33', '2022-07-13 04:33:51'),
(77, 'logo_small', 'logo_small.png', NULL, NULL, '2021-02-10 12:13:40', '2021-11-22 05:30:10'),
(78, 'logo_medium', 'logo-medium.png', NULL, NULL, '2021-02-10 12:25:24', '2021-11-22 05:22:59'),
(79, 'logo_large', 'logo_large.png', NULL, NULL, '2021-02-10 12:27:43', '2021-09-15 05:09:01'),
(80, 'tel', '01132255960', NULL, NULL, '2021-02-22 06:35:58', '2022-08-25 05:38:09'),
(81, 'tax', '0.09', 'در صد مالیات بر ارزش افزوده', NULL, '2021-09-18 09:52:39', '2022-12-03 13:01:04'),
(82, 'state', '27', 'استان سامانه', NULL, '2021-09-21 09:02:50', '2022-07-13 04:33:51'),
(83, 'city', '588', 'شهر سامانه', NULL, '2021-09-21 09:02:54', '2022-07-13 04:33:51'),
(84, 'bank_parsian', NULL, NULL, '{\"title\":\"بانک پارسیان\",\"terminalNumber\":\"44582306\",\"pinCode\":\"kUiw5wJ0I0c74ousq10F\",\"factorAmount\":\"10\",\"active\":\"true\"}', '2021-10-08 18:59:35', '2022-11-08 15:38:10'),
(86, 'bank_melli', NULL, NULL, '{\"title\":\"بانک ملی\",\"terminalNumber\":\"YourTerminalId\",\"merchantId\":\"YourMerchantId\",\"key\":\"YourKey\",\"factorAmount\":\"10\",\"active\":\"true\"}', '2021-10-08 18:59:49', '2022-07-23 05:31:19'),
(87, 'bank_zarinpal', NULL, NULL, '{\"title\":\"بانک زرین پال\",\"merchantId\":\"4de235aa-6d19-11ea-bd92-000c295eb8fc\",\"factorAmount\":\"10\",\"active\":\"true\"}', '2021-10-08 18:59:56', '2022-07-23 05:31:21'),
(88, 'bank_saderat', NULL, NULL, '{\"title\":\"بانک صادرات\",\"terminalNumber\":\"69005741\",\"factorAmount\":\"10\",\"active\":\"true\"}', '2021-10-09 10:30:59', '2022-07-23 05:31:17'),
(89, 'bank_nextpay', NULL, NULL, '{\"title\":\"بانک نکست پی\",\"apikey\":\"50319731-c271-4ae1-9fcb-d7842672f47b--------\",\"factorAmount\":\"1\",\"active\":\"true\"}', '2021-10-27 03:49:17', '2022-12-05 07:21:28'),
(90, 'sms_out_server', 'https://moderniz.ir/sms/send-message-with-curl', NULL, NULL, '2021-10-27 06:19:44', '2022-05-16 19:52:42'),
(91, 'sms_out_user', 'shoja', NULL, NULL, '2021-10-27 06:19:44', '2022-05-16 19:52:42'),
(92, 'sms_out_password', '123456', NULL, NULL, '2021-10-27 06:19:44', '2022-05-16 19:52:42'),
(93, 'notify', 'disable', NULL, NULL, '2021-10-30 03:52:05', '2022-07-13 04:33:51'),
(94, 'mobile', '09353501323', NULL, NULL, '2021-10-30 04:09:30', '2022-08-25 05:38:09'),
(95, 'multiStore', 'enable', NULL, NULL, '2021-11-02 13:54:42', '2022-12-03 13:01:04'),
(96, 'email', 'moderniz.ir@gmail.com', NULL, NULL, '2021-11-06 07:07:34', '2022-08-25 05:38:09'),
(97, 'telegram', 'a', NULL, NULL, '2021-11-18 15:20:12', '2022-01-06 13:08:43'),
(98, 'instagram', 'aa', NULL, NULL, '2021-11-18 15:30:10', '2022-01-06 13:08:43'),
(99, 'watsapp', 'aaa', NULL, NULL, '2021-11-18 15:30:10', '2022-01-06 13:08:43'),
(100, 'linkedin', 'aaaa', NULL, NULL, '2021-11-18 15:30:10', '2022-01-06 13:08:43'),
(101, 'twitter', 'aaaaa', NULL, NULL, '2021-11-18 15:30:10', '2022-01-06 13:08:43'),
(102, 'address', 'مازندران - بابل بعد از کمربندی شرقی سه راه پاسارگاد', NULL, NULL, '2021-11-22 06:38:53', '2022-08-25 05:38:09'),
(103, 'lat', '36.555154183865234', NULL, NULL, '2021-11-22 06:38:53', '2022-08-25 05:38:09'),
(104, 'lng', '52.68287658691406', NULL, NULL, '2021-11-22 06:38:53', '2022-08-25 05:38:09'),
(105, 'zip_code', '4712365898', NULL, NULL, '2021-11-22 06:38:53', '2022-08-25 05:38:09'),
(107, 'about_me', 'اجازه دهید صفحه درباره ما بگوید شرکت چگونه شروع به کار کرده است. یک روایت کوتاهی را به اشتراک بگذارید که انگیزه‌ای برای تشکیل شرکت بوده است. یک نوار زمان (timeline) از آنچه که شرکت انجام داده، ارائه کنید. در این صفحه بیان کنید که چرا شرکت شما در مورد آنچه که انجام می‌دهید پر اشتیاق است و اجازه دهید تا افراد با مطالعه این صفحه تا حد بیشتری با شما و نقاط قوتی که شرکت شما با سایر رقبا در حوزه کاری خود دارد، آشنا شوند. مشتریان دوست دارند وضعیت یک کسب و کار را درک کنند.', NULL, NULL, '2022-01-06 13:06:18', '2022-01-06 13:08:43'),
(108, 'about_me_link', '{SITE_URL}/post/about', NULL, NULL, '2022-01-06 13:06:18', '2022-01-06 13:08:43'),
(109, 'footer_copy_write', '© تمام حقوق این سایت برای\r\n<a class=\"not-color text-info\" href=\"{SITE_URL}\"> گروه نرم افزاری اَپِک </a>\r\nمحفوظ میباشد', NULL, NULL, '2022-01-06 13:14:28', '2022-07-13 04:33:51'),
(110, 'logo', '470738572290399.png', NULL, NULL, '2022-01-07 03:28:07', '2022-12-18 07:40:32'),
(111, 'logo_dark', '836722965218711.png', NULL, NULL, '2022-01-07 03:37:30', '2022-12-18 07:41:52'),
(112, 'namad1', '<a href=\"#\"><img src=\"http://localhost/yektashop/front/yekta/images/symbol/01.png\" alt=\"\"></a>', NULL, NULL, '2022-01-07 04:06:11', '2022-07-28 13:09:58'),
(113, 'namad2', '<a href=\"#\"><img src=\"http://localhost/yektashop/front/yekta/images/symbol/02.png\" alt=\"\"></a>', NULL, NULL, '2022-01-07 04:06:11', '2022-07-28 13:09:58'),
(114, 'namad3', '<a href=\"#\"><img src=\"http://localhost/yektashop/front/yekta/images/symbol/03.png\" alt=\"\"></a>', NULL, NULL, '2022-01-07 04:06:11', '2022-07-28 13:09:58'),
(115, 'favicon', '664642446451619.png', NULL, NULL, '2022-01-07 04:32:20', '2022-11-26 06:38:00'),
(116, 'pre_loading', 'disable', NULL, NULL, '2022-02-08 15:27:07', '2022-12-17 06:15:29'),
(117, 'app_version', '0.1', NULL, NULL, '2022-02-10 06:47:08', '2022-12-17 06:15:29'),
(118, 'bank_zibal', NULL, NULL, '{\"title\":\"بانک زیبال\",\"merchantId\":\"32323\",\"factorAmount\":\"10\",\"active\":\"true\"}', '2022-02-20 16:33:49', '2022-07-23 05:31:37'),
(119, 'product_mega_menu', 'enable', NULL, NULL, '2022-03-16 10:20:19', '2022-12-17 06:15:29'),
(120, 'product_level_menu', 'enable', NULL, NULL, '2022-03-16 10:20:19', '2022-12-17 06:15:29'),
(121, 'factor_amount', '10', NULL, NULL, '2022-05-25 06:08:40', NULL),
(122, 'bank_mellat', NULL, NULL, '{\"title\":\"بانک ملت\",\"terminalId\":\"6411224\",\"userName\":\"sakha40\",\"userPassword\":\"53447645\",\"factorAmount\":\"10\",\"active\":\"true\"}', '2022-05-25 07:18:41', '2022-07-23 05:36:24'),
(123, 'bank_irankish', NULL, NULL, '{\"title\":\"بانک ایران کیش\",\"terminalID\":\"02041092\",\"password\":\"DD75FE0A624BBEDA\",\"acceptorId\":\"992180002041092\",\"pubKey\":\"-----BEGIN PUBLIC KEY-----\\r\\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCuvdMr9pdDUSAi\\/QtQEBNNuBCR\\r\\n4hmfMwGAS6rH6EbNSrImMe8liY9\\/s6uiHWNXrJ6uvPNob081MHfCpy0355Jhr\\/ze\\r\\neUtINDMXrBjQ38PGPDhLtHitntGINd+IeNI+y0oj+9ADRQK\\/3mnF8BYr4GzCOe3U\\r\\nfrzOmpxu2K8\\/vxO0bwIDAQAB\\r\\n-----END PUBLIC KEY-----\",\"factorAmount\":\"10\",\"active\":\"true\"}', '2022-05-25 13:11:58', '2022-07-23 05:31:44'),
(124, 'template_name', 'yekta', NULL, NULL, '2022-06-29 13:22:05', NULL),
(125, 'about', 'مشتریان فروشگاه می‏‏‌توانند با حق انتخابی بسیار بالا و با دریافت اطلاعاتی کامل برای انتخاب درست کالای مورد نظر خود، وب سایت وارمیلو را بررسی کنند و با حداکثر اطمینان کالای خود را انتخاب و خرید کنند. همواره بهترین انتخاب و بهترین خدمات، شایسته مشتریان فروشگاه است.', NULL, NULL, '2022-07-11 15:42:26', '2022-12-17 06:15:29'),
(135, 'count_limit', '10', NULL, NULL, '2022-09-27 07:47:51', '2022-12-03 13:01:04'),
(134, 'expire_invoice_payment', '12', NULL, NULL, '2022-09-15 04:00:15', '2022-12-03 13:01:04'),
(126, 'invoice_prefix', 'DKC-', NULL, NULL, '2022-08-12 14:39:03', '2022-12-03 13:01:04'),
(127, 'send_by_seller', 'no', NULL, NULL, '2022-08-12 14:42:24', '2022-09-27 07:47:51'),
(128, 'smsPanel_kavenegar', NULL, NULL, '{\"title\":\"پنل پیامک کاوه نگار\",\"patternMod\":\"yes\",\"api\":\"664C345777746E59624C48316B346B362B47623066446271795A6A717A616E4168314830394F4D334849553D\"}', '2022-08-15 13:26:22', '2022-08-18 15:07:42'),
(129, 'smsPanel_inductor', NULL, NULL, '{\"title\":\"پنل پیامک واسطه ای\",\"patternMod\":\"no\",\"server\":\"https:\\/\\/moderniz.ir\\/sms\\/send-message-with-curl\",\"user\":\"shoja\",\"pass\":\"123456\"}', '2022-08-15 13:32:40', '2022-08-18 15:04:30'),
(130, 'smsPanel_niazpardaz', NULL, NULL, '{\"title\":\"پنل ارسال مستقیم نیاز پرداز\",\"patternMod\":\"no\",\"server\":\"http:\\/\\/payamak-service.ir\\/SendService.svc?wsdl\",\"user\":\"t.mohammadshoja65\",\"pass\":\"qqe@850\",\"lineNumber\":\"10000000005\"}', '2022-08-15 13:45:43', '2022-08-25 12:03:47'),
(131, 'smsPanel_mellipayamak', NULL, NULL, '{\"title\":\"پنل پیامک ملی پیامک\",\"patternMod\":\"yes\",\"user\":\"aass\",\"pass\":\"ffgfff\"}', '2022-08-15 13:54:59', '2022-08-15 14:37:35'),
(132, 'smsPanel_smsir', NULL, NULL, '{\"title\":\"پیامک پترنی SMS.IR\",\"patternMod\":\"yes\",\"apikey\":\"d0485cbf13a1ae2ba65a5cbf\",\"secretkey\":\"bazanil!@#%^&*()\"}', '2022-08-15 13:59:54', '2022-08-23 03:02:58'),
(133, 'smsPanelDefault', 'smsPanel_niazpardaz', NULL, NULL, '2022-08-15 14:28:33', '2022-08-25 12:03:47'),
(136, 'mobile_app_url', 'https://moderniz.ir/app', NULL, NULL, '2022-11-09 07:07:22', '2022-12-17 06:15:29'),
(137, 'redirect_to_mobile', 'no', NULL, NULL, '2022-11-09 07:07:22', '2022-12-17 06:15:29'),
(138, 'privacy_policy', '57', NULL, NULL, '2022-11-14 13:02:17', '2022-12-17 06:15:29'),
(139, 'site_rule', '63', NULL, NULL, '2022-11-14 13:02:17', '2022-12-17 06:15:29'),
(140, 'is_store_plan', 'no', NULL, NULL, '2022-11-16 06:04:21', '2022-12-03 13:01:04'),
(141, 'deliveryPeriodStartDay', '4', NULL, NULL, '2022-12-18 09:30:24', '2022-12-22 13:52:35'),
(142, 'deliveryMaxSearchDays', '5', NULL, NULL, '2022-12-18 09:30:24', '2022-12-22 13:52:35'),
(143, 'delivery_datetime', 'yes', NULL, NULL, '2022-12-22 13:45:33', '2022-12-22 13:52:35');

-- --------------------------------------------------------

--
-- Table structure for table `ms011_permission`
--

DROP TABLE IF EXISTS `ms011_permission`;
CREATE TABLE IF NOT EXISTS `ms011_permission` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=453 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ms011_permission`
--

INSERT INTO `ms011_permission` (`id`, `group_title`, `status`, `created_at`, `updated_at`) VALUES
(421, 'داشبورد', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(423, 'مدیران و پرسنل', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(424, 'مشتریان', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(440, 'دفترچه تلفن', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(439, 'تیکت', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(441, 'وبلاگ', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(442, 'دیدگاهها', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(443, 'صفحه اول یا چیدمان قالب', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(444, 'فروشندگان', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(446, 'محصولات', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(447, 'کوپن و جشنواره', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(448, 'مدیریت سفارشات فروشگاه', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(449, 'گزارشات', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(451, 'تنظیمات', 1, '2022-06-29 06:43:20', '2021-11-22 07:02:46'),
(452, 'املاک', 0, '2022-06-29 06:43:20', '2021-11-22 08:20:05');

-- --------------------------------------------------------

--
-- Table structure for table `ms011_permission_item`
--

DROP TABLE IF EXISTS `ms011_permission_item`;
CREATE TABLE IF NOT EXISTS `ms011_permission_item` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `routes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=138 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ms011_permission_item`
--

INSERT INTO `ms011_permission_item` (`id`, `permission_id`, `title`, `routes`, `created_at`, `updated_at`) VALUES
(35, 424, 'حذف مشتری', 'customer-delete', '2021-07-30 11:34:06', '2021-07-30 11:34:50'),
(14, 421, 'صفحه اول', 'dashboard,access-denied,empty,find-post,find-cat,find-comment,find-user,find-rs-agent,search-menu,redirect,profile,profile-update,profile-meta-save,profile-notify-save,file-list,file-uploader,files-delete,cat-item-update,save-them-setting,get-them-setting,setting-update,shop/get-city/{parent_id?},shop/find-user,get-city/{parent_id?},new-directory', '2021-07-29 06:10:30', '2021-11-21 15:21:28'),
(16, 423, 'لیست مدیران', 'user-list,user-list-dt', '2021-07-29 06:11:58', '2021-07-29 06:12:37'),
(17, 423, 'افزودن مدیر یا پرسنل', 'user-add,user-insert', '2021-07-29 06:12:21', '2021-07-29 06:12:51'),
(18, 423, 'ویرایش مدیر یا پرسنل', 'user-edit/{id},user-update,address-delete,address-insert,address-list/{id},change-pass', '2021-07-29 06:12:35', '2021-11-21 15:16:36'),
(19, 423, 'حذف مدیر یا پرسنل', 'user-delete', '2021-07-29 06:13:22', '2021-07-29 06:13:36'),
(20, 423, 'بروز رسانی متای پرسنل', 'user-meta-save,user-notify-save', '2021-07-29 06:14:13', '2021-07-29 06:14:17'),
(32, 424, 'لیست مشتریان', 'customer-list,customer-list-dt', '2021-07-30 11:33:41', '2021-07-30 11:34:16'),
(33, 424, 'افزودن مشتری', 'customer-add,customer-insert', '2021-07-30 11:33:50', '2021-07-30 11:34:27'),
(34, 424, 'ویرایش مشتری', 'customer-edit/{id},customer-update', '2021-07-30 11:33:59', '2021-07-30 11:34:39'),
(60, 440, 'حذف از دفتر تلفن', 'contact-delete', '2021-11-21 13:07:47', '2021-11-21 13:08:35'),
(50, 439, 'نمایش لیست تیکتها', 'ticket-list', '2021-11-21 13:03:14', '2021-11-21 13:04:15'),
(51, 439, 'نمایش جزییات تیکت', 'ticket-message/{id}', '2021-11-21 13:03:30', '2021-11-21 13:04:31'),
(52, 439, 'پاسخ به تیکت', 'ticket-save', '2021-11-21 13:03:42', '2021-11-21 13:04:51'),
(53, 439, 'بستن تیکت', 'ticket-closed', '2021-11-21 13:03:59', '2021-11-21 13:04:59'),
(54, 439, 'حذف یک یا چند پیام تیکت', 'ticket-message-delete', '2021-11-21 13:05:29', '2021-11-21 13:05:41'),
(55, 439, 'حذف کامل یک تیکت', 'ticket-delete', '2021-11-21 13:05:56', '2021-11-21 13:06:06'),
(56, 440, 'نمایش لیست تلفن ها', 'contact-list,contact-list-dt', '2021-11-21 13:06:46', '2021-11-21 13:08:00'),
(57, 440, 'نمایش جزییات', 'contact-edit/{id}', '2021-11-21 13:06:57', '2021-11-21 13:08:12'),
(58, 440, 'افزودن شماره جدید', 'contact-add,contact-insert', '2021-11-21 13:07:29', '2021-11-21 13:08:23'),
(59, 440, 'ورایش جزییات', 'contact-update', '2021-11-21 13:07:36', '2021-11-21 13:08:29'),
(36, 424, 'ویرایش اطلاعات اضافی مشتری', 'customer-meta-save,customer-notify-save', '2021-07-30 11:35:07', '2021-07-30 11:35:18'),
(65, 441, 'حذف مطالب', 'post-delete', '2021-11-21 13:09:58', '2021-11-21 13:11:31'),
(66, 441, 'نمایش دسته بندی مطالب', 'post-cat', '2021-11-21 13:12:02', '2021-11-21 13:20:21'),
(67, 441, 'نمایش جزییات دسته مطالب', 'post-cat-detail', '2021-11-21 13:16:03', '2021-11-21 13:21:39'),
(61, 441, 'دیدن لیست مطالب', 'post-list,post-list-dt,add-fast-category', '2021-11-21 13:09:07', '2021-11-21 15:17:05'),
(62, 441, 'افزودن مطلب جدید', 'post-add', '2021-11-21 13:09:31', '2021-11-21 13:10:42'),
(63, 441, 'دیدن جزییات مطلب', 'post-edit/{id}', '2021-11-21 13:09:41', '2021-11-21 13:10:50'),
(64, 441, 'بروز رسانی مطالب', 'post-update,post-get-gallery/{id},post-save-gallery', '2021-11-21 13:09:49', '2021-11-21 13:11:17'),
(68, 441, 'بروز رسانی جزییات دسته', 'post-cat-detail-update', '2021-11-21 13:19:53', '2021-11-21 13:21:47'),
(69, 441, 'حذف دسته مطالب', 'post-cat-item-delete', '2021-11-21 13:20:04', '2021-11-21 13:21:53'),
(70, 442, 'نمایش لیست دیدگاهها', 'comment-list,comment-list-dt', '2021-11-21 13:22:27', '2021-11-21 13:23:42'),
(71, 442, 'نمایش جزییات دیدگاه', 'comment-edit/{id}', '2021-11-21 13:22:38', '2021-11-21 13:23:54'),
(72, 442, 'بروز رسانی دیدگاه', 'comment-update', '2021-11-21 13:22:57', '2021-11-21 13:24:08'),
(73, 442, 'حذف دیدگاه', 'comment-delete', '2021-11-21 13:23:30', '2021-11-21 13:24:22'),
(74, 442, 'نمایش سطل زباله', 'comment-trash-list,comment-restore/{id}/{list_address?},comment-trashed/{id}/{list_address?}', '2021-11-21 13:24:56', '2021-11-21 15:17:51'),
(75, 443, 'لیست همه المانها', 'first-page-list,first-page-list-dt', '2021-11-21 13:29:31', '2021-11-21 13:30:47'),
(81, 443, 'حذف ایتم یا المان', 'first-page-delete', '2021-11-21 13:34:31', '2021-11-21 13:34:35'),
(80, 443, 'ایجاد و ویرایش', 'design-f-page,design-page-edit/{id},first-page-update', '2021-11-21 13:33:25', '2021-11-21 13:33:58'),
(82, 443, 'مدیریت منوی اصلی', 'index-menu', '2021-11-21 13:35:40', '2021-11-21 13:35:57'),
(83, 444, 'نمایش لیست فروشندگان', 'shop/store-list,shop/store-list-dt', '2021-11-21 13:38:51', '2021-11-21 13:39:00'),
(84, 444, 'نمایش جزییات فروشنده', 'shop/store-edit/{id}', '2021-11-21 13:39:19', '2021-11-21 13:39:24'),
(85, 444, 'بروز رسانی جزییات فروشنده', 'shop/store-update', '2021-11-21 13:39:37', '2021-11-21 13:39:45'),
(86, 444, 'افزودن فروشنده جدید', 'shop/store-add,shop/store-insert', '2021-11-21 13:40:01', '2021-11-21 13:40:03'),
(87, 444, 'حذف فروشنده', 'shop/store-delete', '2021-11-21 13:40:24', '2021-11-21 13:40:41'),
(88, 444, 'دسته بندی فروشگاه', 'shop/store-cat-detail,shop/store-cat-detail-update,shop/store-cat-item-delete,shop/cat-store', '2021-11-21 13:41:23', '2021-11-21 13:42:14'),
(89, 444, 'نمایش تسویه حساب فروشندگان', 'shop/store-clearing', '2021-11-21 13:43:19', '2021-11-21 13:43:40'),
(90, 444, 'ثبت تسویه حساب جدید', 'shop/store-clearing-done', '2021-11-21 13:44:04', '2021-11-21 13:44:25'),
(91, 444, 'نمایش مدیران فروشگاه', 'shop/store-user,shop/store-user-dt', '2021-11-21 13:44:56', '2021-11-21 13:45:04'),
(92, 446, 'نمایش و بروز رسانی دسته محصولات', 'shop/cat,shop/cat-detail', '2021-11-21 13:46:56', '2021-11-21 13:47:51'),
(93, 446, 'بروز رسانی جزییات دسته محصولات', 'shop/cat-detail-update', '2021-11-21 13:47:30', '2021-11-21 13:47:40'),
(94, 446, 'حذف دسته محصولات', 'shop/cat-item-delete', '2021-11-21 13:48:10', '2021-11-21 13:48:20'),
(95, 446, 'نمایش لیست محصولات', 'shop/product-list', '2021-11-21 13:54:28', '2021-11-21 13:54:53'),
(96, 446, 'افزودن محصول', 'shop/product-new', '2021-11-21 13:55:15', '2021-11-21 13:55:31'),
(97, 446, 'نمایش جزییات محصول', 'shop/product-edit/{id}', '2021-11-21 13:57:18', '2021-11-21 13:57:26'),
(98, 446, 'بروز رسانی محصول', 'shop/product-update,shop/product-images,shop/product-custom-field,shop/product-custom-field-update', '2021-11-21 13:57:35', '2021-11-21 14:13:26'),
(99, 446, 'ثبت موجودی محصول', 'shop/product-quantity/{id}', '2021-11-21 13:58:07', '2021-11-21 13:58:27'),
(100, 446, 'تغییر قیمت گروهی محصولات', 'shop/product-change-price', '2021-11-21 14:11:06', '2021-11-21 14:11:28'),
(101, 446, 'حذف محصولات', 'shop/product-delete', '2021-11-21 14:11:55', '2021-11-21 14:12:11'),
(102, 446, 'طراحی مشخصات فنی محصول', 'shop/custom-field', '2021-11-21 14:14:02', '2021-11-21 14:14:18'),
(103, 446, 'مدیریت رنگ ها', 'shop/color', '2021-11-21 14:14:43', '2021-11-21 14:15:10'),
(104, 446, 'مدیریت سایز و اندازه', 'shop/size', '2021-11-21 14:14:52', '2021-11-21 14:15:19'),
(105, 446, 'مدیریت برند ها', 'shop/brand', '2021-11-21 14:15:02', '2021-11-21 14:15:28'),
(106, 447, 'مدیریت پلن تخفیفات (جشنواره)', 'shop/discount', '2021-11-21 14:17:10', '2021-11-21 14:17:30'),
(107, 447, 'مدیریت کوپن های تخفیف', 'shop/coupon-cart', '2021-11-21 14:17:21', '2021-11-21 14:17:37'),
(108, 448, 'مدیریت فاکتورها', 'shop/invoice', '2021-11-21 14:22:31', '2021-11-21 14:22:39'),
(109, 448, 'روشهای حمل محصول', 'shop/shipping', '2021-11-21 14:23:04', '2021-11-21 14:23:19'),
(110, 449, 'لیست همه تراکنشات', 'transaction-list,transaction-list-dt', '2021-11-21 14:25:24', '2021-11-21 14:25:35'),
(111, 449, 'افزودن تراکنش جدید', 'transaction-insert', '2021-11-21 14:25:48', '2021-11-21 14:26:12'),
(112, 449, 'پرداختی های درگاه', 'payment-list,payment-list-dt,payment-detail', '2021-11-21 14:45:21', '2021-11-21 14:45:36'),
(114, 449, 'نمایش پیامک ها', 'sms-list,sms-list-dt,sms-detail', '2021-11-21 14:47:49', '2021-11-21 14:48:20'),
(115, 449, 'ارسال پیامک دستی', 'sms-send', '2021-11-21 14:48:05', '2021-11-21 14:48:13'),
(116, 449, 'رویدادها', 'notify-list,notify-list-dt,notify-refresh', '2021-11-21 15:06:53', '2021-11-21 15:07:42'),
(117, 449, 'خواندن و تغییر وضعیت رویداد', 'notify-read,notify-delete', '2021-11-21 15:08:05', '2021-11-21 15:08:31'),
(120, 451, 'پیکر بندی', 'setting,setting-image-update', '2021-11-21 15:11:28', '2021-11-21 15:12:26'),
(121, 451, 'شبکه های اجتماعی', 'setting-social', '2021-11-21 15:12:12', '2021-11-21 15:12:18'),
(122, 451, 'قالب ارسال رویداد', 'shop/notify-temp', '2021-11-21 15:13:04', '2021-11-21 15:13:07'),
(123, 451, 'پشتیبان گیری', 'backup-list,import-database,export-database', '2021-11-21 15:13:34', '2021-11-21 15:14:45'),
(124, 449, 'حذف تراکنش (در انتخاب این مجوز دقت شود)', 'transaction-delete', '2021-11-21 15:19:01', '2021-11-21 15:19:25'),
(125, 452, 'نمایش لیست املاک', 'amlak-list,amlak-list-dt,amlak/print/{id}', '2021-11-22 07:55:31', '2021-11-22 08:15:30'),
(126, 452, 'افزودن ملک', 'amlak-add,amlak-insert', '2021-11-22 08:12:00', '2021-11-22 08:12:11'),
(127, 452, 'نمایش جزییات املاک', 'amlak-edit/{id}', '2021-11-22 08:12:21', '2021-11-22 08:12:31'),
(128, 452, 'بروز رسانی املاک', 'amlak-edit-address/{id},amlak-edit-content/{id},amlak-edit-image/{id},amlak-update,amlak-address-update,amlak-file-update,amlak-get-image/{id},amlak-content-update,amlak-video-update,amlak-delete-image', '2021-11-22 08:12:40', '2021-11-22 08:13:43'),
(129, 452, 'حذف ملک', 'amlak-delete', '2021-11-22 08:13:14', '2021-11-22 08:13:53'),
(130, 452, 'مدیریت دسته بندی املاک', 'amlak-cat,amlak-cat-detail,amlak-cat-detail-update,amlak-cat-item-delete', '2021-11-22 08:14:06', '2021-11-22 08:14:22'),
(131, 452, 'مدیریت امکانات ملک', 'amlak-property,amlak-property-detail,amlak-property-detail-update,amlak-property-item-delete', '2021-11-22 08:14:47', '2021-11-22 08:15:00'),
(132, 452, 'مدیریت زونکن ها', 'amlak-zonkan,amlak-zonkan-item-delete', '2021-11-22 08:15:10', '2021-11-22 08:15:20'),
(133, 452, 'نمایش لیست سرنخ ها', 'clue-list,clue-list-dt', '2021-11-22 08:16:05', '2021-11-22 08:16:20'),
(134, 452, 'افزودن سرنخ جدید', 'clue-add,clue-insert', '2021-11-22 08:16:33', '2021-11-22 08:16:40'),
(135, 452, 'نمایش جزییات سرنخ', 'clue-edit/{id}', '2021-11-22 08:16:52', '2021-11-22 08:17:00'),
(136, 452, 'بروز رسانی سرنخ ها', 'clue-update', '2021-11-22 08:17:09', '2021-11-22 08:17:15'),
(137, 452, 'حذف سرنخ ها', 'clue-delete', '2021-11-22 08:17:22', '2021-11-22 08:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `ms011_permission_list`
--

DROP TABLE IF EXISTS `ms011_permission_list`;
CREATE TABLE IF NOT EXISTS `ms011_permission_list` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=420 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `ms011_permission_list`
--

INSERT INTO `ms011_permission_list` (`id`, `title`, `items`, `created_at`, `updated_at`) VALUES
(419, 'مجوز نمایندگان سطح 1', '[\"dashboard\",\"access-denied\",\"empty\",\"find-post\",\"find-cat\",\"find-comment\",\"find-user\",\"find-rs-agent\",\"search-menu\",\"redirect\",\"profile\",\"profile-update\",\"profile-meta-save\",\"profile-notify-save\",\"file-list\",\"file-uploader\",\"files-delete\",\"cat-item-update\",\"save-them-setting\",\"get-them-setting\",\"setting-update\",\"shop\\/get-city\\/{parent_id?}\",\"shop\\/find-user\",\"get-city\\/{parent_id?}\",\"new-directory\",\"user-list\",\"user-list-dt\",\"user-add\",\"user-insert\",\"user-edit\\/{id}\",\"user-update\",\"address-delete\",\"address-insert\",\"address-list\\/{id}\",\"change-pass\",\"user-delete\",\"user-meta-save\",\"user-notify-save\",\"ticket-save\",\"ticket-message-delete\",\"post-cat-detail\",\"post-list\",\"post-list-dt\",\"add-fast-category\",\"post-update\",\"post-get-gallery\\/{id}\",\"post-save-gallery\",\"design-f-page\",\"design-page-edit\\/{id}\",\"first-page-update\",\"shop\\/store-add\",\"shop\\/store-insert\",\"shop\\/store-delete\",\"shop\\/store-clearing\",\"shop\\/product-new\",\"shop\\/product-change-price\"]', '2021-09-28 09:53:39', '2021-11-21 15:25:26');

-- --------------------------------------------------------

--
-- Table structure for table `ms011_post`
--

DROP TABLE IF EXISTS `ms011_post`;
CREATE TABLE IF NOT EXISTS `ms011_post` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'post',
  `content_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'text' COMMENT 'نوع محتوا مثلا متنی یا گالری یا از نوع فیلم یا پادکست',
  `lang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'fa' COMMENT 'زبان مطلب',
  `unique_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'میتوانید پیوند یکتا این پست را ایجاد کنید',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `excerpt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery` json DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `comment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `edit_by` int(11) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cats` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'public' COMMENT 'vip | login | money',
  `amount` decimal(10,2) DEFAULT '0.00',
  `rate_total` int(11) DEFAULT NULL COMMENT 'جمع امتیازات این مطلب',
  `rate_number` tinyint(4) DEFAULT '0' COMMENT 'ستاره این مطلب',
  `view` int(11) DEFAULT '0' COMMENT 'تعداد بازدید این مطلب',
  `info` text COLLATE utf8mb4_persian_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `ms011_post`
--

INSERT INTO `ms011_post` (`id`, `parent_id`, `title`, `type`, `content_type`, `lang`, `unique_title`, `content`, `excerpt`, `img`, `file`, `thumbnail`, `gallery`, `url`, `status`, `comment_status`, `edit_by`, `created_by`, `tags`, `cats`, `access_type`, `amount`, `rate_total`, `rate_number`, `view`, `info`, `created_at`, `updated_at`) VALUES
(48, 0, 'سرفیس پرو ۸ مایکروسافت با نمایشگر ۱۳ اینچی معرفی شد', 'education', 'text', 'fa', 'سرفیس-پرو-۸-مایکروسافت-با-نمایشگر-۱۳-اینچی-معرفی-شد', '<p>مایکروسافت ساعاتی پیش و در جریان کنفرانسی اختصاصی، عضوی جدید تحت عنوان سرفیس پرو ۸ را به خانواده مدل&zwnj;های سرفیس خود اضافه کرد.</p>\r\n<p>محصولی که با به&zwnj;روزرسانی&zwnj;ها و تغییرات قابل&zwnj;توجهی همراه شده و از طراحی جدیدی نسبت به مدل&zwnj;های قبلی سرفیس پرو بهره می&zwnj;برد. مهندسان مایکروسافت برای اولین بار در این محصول از نمایشگر ۱۲۰ هرتزی با حاشیه&zwnj;های کناری بسیار باریک استفاده و آن را به کیبورد جدید و همچنین قلم سرفیس اسلیم پن ۲ ارتقایافته، مجهز کرده&zwnj;اند.</p>\r\n<p>از دیگر مشخصات سرفیس پرو ۸ می&zwnj;توان به نمایشگر ۱۳ اینچی پیکسل&zwnj;سنس فلو دیسپلی اشاره کرد که نسبت به دیگر مدل&zwnj;های ۱۲.۳ اینچی سرفیس پرو، بزرگ&zwnj;تر است و از رزولوشن بالاتری نیز بهره می&zwnj;برد به طوری که طبق گفته مایکروسافت، ۱۱ درصد بزرگ&zwnj;تر شده، از ۱۲.۵ درصد روشنایی بیشتر بهره می&zwnj;برد و رزولوشن آن نیز ۱۱ درصد بیشتر شده است.</p>\r\n<div class=\"crp_related  \">\r\n<div class=\"mag-box-title the-global-title\">\r\n<h3>مقالات مرتبط:</h3>\r\n</div>\r\n<div class=\"related-posts\">\r\n<div class=\"posts\"><a class=\"crp_link post-71007\" href=\"https://itiran.com/2019/10/07/%d9%85%d9%82%d8%a7%db%8c%d8%b3%d9%87-%d8%b3%d8%b1%d9%81%db%8c%d8%b3-%d9%be%d8%b1%d9%88-%d8%a7%db%8c%da%a9%d8%b3-%d9%88-%d8%b3%d8%b1%d9%81%db%8c%d8%b3-%d9%be%d8%b1%d9%88-7/\"><span class=\"crp_title\">مقایسه سرفیس پرو ایکس و سرفیس پرو 7</span></a></div>\r\n<div class=\"posts\"><a class=\"crp_link post-70955\" href=\"https://itiran.com/2019/10/03/%d8%b3%d8%b1%d9%81%db%8c%d8%b3-%d9%be%d8%b1%d9%88-%d8%a7%db%8c%da%a9%d8%b3%d8%8c-%d9%85%d8%ad%d8%b5%d9%88%d9%84-%d8%ac%d8%af%db%8c%d8%af-%d9%85%d8%a7%db%8c%da%a9%d8%b1%d9%88%d8%b3%d8%a7%d9%81%d8%aa/\"><span class=\"crp_title\">سرفیس پرو ایکس محصول جدید مایکروسافت برای علاقمندان&hellip;</span></a></div>\r\n<div class=\"posts\"><a class=\"crp_link post-69848\" href=\"https://itiran.com/2019/09/15/%d9%85%d8%a7%db%8c%da%a9%d8%b1%d9%88%d8%b3%d8%a7%d9%81%d8%aa-%d8%b3%d8%b1%d9%81%db%8c%d8%b3-%d9%84%d9%be%d8%aa%d8%a7%d9%be-3-%d9%86%d8%b3%d8%ae%d9%87-15-%d8%a7%db%8c%d9%86%da%86%db%8c-%d9%85%d8%b9/\"><span class=\"crp_title\">مایکروسافت سرفیس لپتاپ 3 نسخه 15 اینچی معرفی می&zwnj;کند؟</span></a></div>\r\n<div class=\"posts\"><a class=\"crp_link post-70945\" href=\"https://itiran.com/2019/10/03/%d8%b3%d8%b1%d9%81%db%8c%d8%b3-%d9%86%d8%a6%d9%88-%d8%b1%d8%b3%d9%85%d8%a7-%d9%85%d8%b9%d8%b1%d9%81%db%8c-%d8%b4%d8%af%d8%9b-%d8%aa%d8%a8%d9%84%d8%aa%db%8c-%d9%85%d8%ac%d9%87%d8%b2-%d8%a8%d9%87-%d8%af/\"><span class=\"crp_title\">مایکروسافت سرفیس نئو رسما معرفی شد؛ تبلتی مجهز به دو نمایشگر</span></a></div>\r\n</div>\r\n<div class=\"crp_clear\">&nbsp;</div>\r\n</div>\r\n<p>همچنین این نمایشگر از فناوری&zwnj;های دالبی ویژن و آداپتیو کالر تکنولوژی می&zwnj;برد. مایکروسافت اعلام کرد که این نمایشگر، از لحاظ فنی، پیشرفته&zwnj;ترین نمایشگری است که تاکنون توسط این شرکت تولید شده است.</p>\r\n<p>همچنین حاشیه&zwnj;های کناری نمایشگر نیز کوچک&zwnj;تر شده و ظاهری شبیه به سرفیس پرو ایکس را برای سرفیس پرو ۸ به ارمغان آورده است. نرخ رفرش این نمایشگر هم برابر با ۱۲۰ هرتز عنوان شده که البته به صورت پیش&zwnj;فرض روی ۶۰ هرتز تنظیم شده که تا ۱۲۰ هرتز افزایش خواهد یافت.</p>\r\n<p>به گفته مایکروسافت، در سرفیس پرو ۸ قابلیت جدید Dynamic Refresh Rate ویندوز ۱۱ به&zwnj;کار رفته که از عملکردی شبیه به قابلیت پروموشن نمایشگرهای اپل برخوردار است و به نمایشگر اجازه می&zwnj;دهد تا با توجه به محتوای در حال نمایش و کاری که انجام می&zwnj;دهد، نرخ رفرش مناسب را انتخاب و اعمال کند.</p>\r\n<p>همچنین این محصول به کیبرد سرفیس پرو سیگنچر و قلم سرفیس اسلیم پن ۲ مجهز شده است. این قلم به یک موتور لمسی داخلی مجهز شده که می&zwnj;تواند حسی شبیه به نوشتن با یک قلم معمولی را برای کاربر به ارمغان آورد. همچنین این استایلوس به لطف برخورداری از نوک جدید به دقت بالاتر و تاخیر واکنش کمتر مجهز شده است.</p>\r\n<p><a href=\"https://itiran.com/wp-content/uploads/2021/09/01-1.jpg\"><img class=\"alignnone wp-image-105893 lazyloaded\" src=\"https://itiran.com/wp-content/uploads/2021/09/01-1.jpg\" sizes=\"(max-width: 400px) 100vw, 400px\" srcset=\"https://itiran.com/wp-content/uploads/2021/09/01-1.jpg 715w, https://itiran.com/wp-content/uploads/2021/09/01-1-300x176.jpg 300w\" alt=\"سرفیس پرو ۸\" width=\"400\" height=\"235\" data-ll-status=\"loaded\" /></a></p>\r\n<p>روی بدنه سرفیس پرو ۸ نیز درگاه&zwnj;های متعددی تعبیه شده است. مایکروسافت بالاخره پشتیبانی از درگاه تاندربولت ۴ را به این محصول اضافه و درگاه USB-A قدیمی&zwnj; را حذف کرد. این دستگاه از دو درگاه USB-C تاندربولت ۴ و درگاه سرفیس کانکت برای شارژ بهره می&zwnj;برد.</p>\r\n<p><a href=\"https://itiran.com/wp-content/uploads/2021/09/00.jpg\"><img class=\"alignnone wp-image-105894 lazyloaded\" src=\"https://itiran.com/wp-content/uploads/2021/09/00.jpg\" sizes=\"(max-width: 400px) 100vw, 400px\" srcset=\"https://itiran.com/wp-content/uploads/2021/09/00.jpg 723w, https://itiran.com/wp-content/uploads/2021/09/00-300x167.jpg 300w\" alt=\"سرفیس پرو ۸\" width=\"400\" height=\"222\" data-ll-status=\"loaded\" /></a></p>\r\n<p>این یعنی کاربران می&zwnj;توانند سرفیس پرو ۸ خود را به چند نمایشگر ۴K متصل کنند، از حافظه اکسترنال با سرعت بالا بهره&zwnj;مند شوند و یا حتی از یک پردازنده اکسترنال برای تبدیل کردن این محصول به یک پی&zwnj;سی گیمینگ استفاده کنند.</p>\r\n<p>در خصوص دیگر مشخصات سخت&zwnj;افزاری سرفیس پرو ۸ نیز باید گفت که این محصول در مدل&zwnj;هایی مجهز به پردازنده&zwnj;های نسل یازدهم Core i۷، Core i۵ و حتی Core i۳ قابل انتخاب خواهد بود. مدل پایه این دستگاه از رم ۸ گیگابایتی و حافظه ۱۲۸ گیگابایتی بهره می&zwnj;برد که به ترتیب تا ۳۲ گیگابایت و یک ترابایت قابل ارتقا هستند.</p>\r\n<p><a href=\"https://itiran.com/wp-content/uploads/2021/09/03-1.jpg\"><img class=\"alignnone wp-image-105892 lazyloaded\" src=\"https://itiran.com/wp-content/uploads/2021/09/03-1.jpg\" sizes=\"(max-width: 400px) 100vw, 400px\" srcset=\"https://itiran.com/wp-content/uploads/2021/09/03-1.jpg 719w, https://itiran.com/wp-content/uploads/2021/09/03-1-300x172.jpg 300w\" alt=\"سرفیس پرو ۸\" width=\"400\" height=\"230\" data-ll-status=\"loaded\" /></a></p>\r\n<p>طبق اعلام مایکروسافت، عملکرد پردازشی سرفیس پرو ۸ نسبت به سرفیس پرو ۷ تا ۴۰ درصد سریع&zwnj;تر است و توان گرافیکی آن نیز حدود ۷۴ درصد بالاتر است. در خصوص باتری نیز باید گفت که سرفیس پرو ۸ از طول عمر باتری ۱۶ ساعته بهره می&zwnj;برد. قیمت پایه این دستگاه برابر با ۱۰۹۹ دلار تعیین شده و فروش آن از ۵ اکتبر آغاز خواهد شد.</p>\r\n<p><a href=\"https://itiran.com/wp-content/uploads/2021/09/04-1.jpg\"><img class=\"alignnone wp-image-105891 lazyloaded\" src=\"https://itiran.com/wp-content/uploads/2021/09/04-1.jpg\" sizes=\"(max-width: 400px) 100vw, 400px\" srcset=\"https://itiran.com/wp-content/uploads/2021/09/04-1.jpg 565w, https://itiran.com/wp-content/uploads/2021/09/04-1-300x277.jpg 300w\" alt=\"سرفیس پرو ۸\" width=\"400\" height=\"370\" data-ll-status=\"loaded\" /></a></p>\r\n<div class=\"post-bottom-meta post-bottom-tags post-tags-modern\">&nbsp;</div>', 'تعویض باطری', 'surfacepro8no-780x470.jpg', NULL, '', '\"[]\"', '', 'active', 'open', 1, 1, '', '169,179,180', 'public', '0.00', NULL, 0, 0, NULL, '2019-09-04 12:16:03', '2022-08-04 14:40:10'),
(77, 0, 'یک نمونه در حال تست', 'portfolio', 'text', 'fa', 'یک-نمونه-تست', '<div id=\"desc\" class=\"c-content-expert js-product-tab-content is-active\" data-method=\"desc\">\r\n<article>\r\n<div class=\"o-box__header\"><span class=\"o-box__title\">نقد و بررسی اجمالی</span><span class=\"o-box__header-desc\">Xiaomi POCO F3 5G M2012K11AG Dual SIM 256GB And 8GB RAM Mobile Phone</span></div>\r\n<section class=\"c-content-expert__summary\">\r\n<div class=\"c-mask js-mask\">\r\n<div class=\"c-mask__text c-mask__text--product-summary js-mask__text is-active\">گوشی موبایل شیائومی مدل Poco F3 دو سیم&zwnj; کارت ظرفیت 256 گیگابایت از جمله محصولات برند شیائومی که در سال 2021 روانه بازار شده است. این محصول دارای ساختاری متوازن و خوش&zwnj;ساخت بدون پشتیبانی از تکنولوژی 5G روانه بازار شده است. این محصول از بدنه شیشه&zwnj;ای و فریم پلاستیکی ساخته شده است که قاب جلو شیشه&zwnj;ای جلوه ویژه&zwnj;ای به این مدل بخشیده است. صفحه&zwnj;نمایش گوشی موبایل شیائومی مدل POCO F3 دو سیم&zwnj; کارت ظرفیت 256 گیگابایت در اندازه 6.67 منتشر شده است. این صفحه&zwnj;نمایش کاملاً تمام&zwnj;صفحه است و در بالا وسط اثری از بریدگی یا حفره دوربین سلفی وجود دیده می&zwnj;شود. دوربین سلفی این محصول دارای حسگر 20 مگاپیکسلی است .صحفه&zwnj;نمایش گوشی موبایل شیائومی مدل POCO F3 با استفاده از فناوری Corning Gorilla Glass 5 در برابر خط&zwnj;وخش و صدمات احتمالی محافظت می&zwnj;شود. گفتنی است 3 دوربین که سنسور اصلی آن 48 مگاپیکسلی است در قسمت پشتی این گوشی جا خوش کرده&zwnj;اند. این دوربین&zwnj;ها قادر هستند ویدئوی 4K را ثبت و ضبط کنند. دوربین&zwnj; سلفی این محصول هم به سنسوری 20 مگاپیکسلی مجهز شده است. بلوتوث نسخه 5.1 ، نسخه 11 سیستم عامل اندروید و باتری 4520 میلی&zwnj;آمپرساعتی از دیگر ویژگی&zwnj;&zwnj;های این گوشی جدید هستند.</div>\r\n</div>\r\n</section>\r\n<div class=\"c-content-expert__separator\">&nbsp;</div>\r\n</article>\r\n</div>\r\n<div id=\"expert_review\" class=\"c-content-expert js-product-tab-content is-active\" data-method=\"expert_review\">\r\n<article>\r\n<div class=\"o-box__header\"><span class=\"o-box__title\">نقد و بررسی تخصصی</span><span class=\"o-box__header-desc\">Xiaomi POCO F3 5G M2012K11AG Dual SIM 256GB And 8GB RAM Mobile Phone</span></div>\r\n<div class=\"c-content-expert__articles js-product-review-container is-open\">\r\n<section class=\"c-content-expert__article js-expert-article is-active\">\r\n<h3 class=\"c-content-expert__title\">معرفی</h3>\r\n<div class=\"c-content-expert__text\">\r\n<p>&nbsp;</p>\r\n<p>بسیاری از ما به دلیل بالا بودن قیمت گوشی&zwnj;های پرچمدار امکان خرید این محصولات را نداریم. بنابراین در بازار گوشی&zwnj;های میان&zwnj;رده باید گوشی مورد نظر خود را جستجو کنیم. حال در این میان شرکت بزرگ شیائومی که یکی از بزرگترین شرکت&zwnj;های تولید کننده گوشی موبایل در جهان است تنوع بالایی از گوشی&zwnj;های میان&zwnj;رده با کیفیت و هزینه معقول روانه بازار کرده است. سری پوکو برند شیائومی یکی از محبوب&zwnj;ترین میان&zwnj;رده&zwnj;های موجود در بازار است.&nbsp;شیائومی این بار گوشی موبایل&nbsp;POCO F3 را طراحی کرده است. این گوشی در بعضی از سطوح در حد و اندازه یک پرچمدار است.&nbsp;&nbsp;این گوشی موبایل دارای یک طراحی زیبا &nbsp;در قامت&nbsp;یک پرچمدار در اواخر مارس ۲۰۲۱ معرفی شده است.&nbsp;شیائومی نسخه POCO F3 با تکنولوژی 5G&nbsp;را با وزنی مناسب و یک طراحی متفاوت نسبت به سری&zwnj;های قبلی روانه بازار کرده است.&nbsp;شرکت شیائومی برای گوشی&nbsp;POCO F3 هم سه دوربین واید، التراواید و ماکرو در نظر کرفته است. تراشه یا چیپست رده بالا از دیگر امکانات قابل ذکر و مهم این مدل است.&nbsp;شرکت شیائومی با ساخت گوشی موبایل مدل POCO F3 5G M2012K11AG بار دیگر سعی کرده است تا سهم بازار خود را در گوشی&lrm;&zwnj;های میان رده حفظ کند.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"c-content-expert__text c-content-expert__text--center\">\r\n<div class=\"c-content-expert__img c-content-expert__img--center\"><img src=\"https://dkstatics-public.digikala.com/digikala-reviews/00c4d45f3cf6b7f832cdb70084716c8b0adfdefc_1627204357.jpg?x-oss-process=image/resize,w_960/quality,q_70\" data-src=\"https://dkstatics-public.digikala.com/digikala-reviews/00c4d45f3cf6b7f832cdb70084716c8b0adfdefc_1627204357.jpg?x-oss-process=image/resize,w_960/quality,q_70\" /></div>\r\n</div>\r\n</section>\r\n<section class=\"c-content-expert__article js-expert-article is-active\">\r\n<h3 class=\"c-content-expert__title\">طراحی و صفحه نمایش</h3>\r\n<div class=\"c-content-expert__text\">\r\n<p>&nbsp;</p>\r\n<p>طراحی و ظاهر مدل&nbsp;POCO F3 اندکی با سری&zwnj;های قبلی&nbsp;POCO متفاوت&zwnj;تر است. بدنه جلو وعقب گوشی توسط&nbsp;&nbsp;گوریلا گلس ۵ محافظت شده است. همچنین مهندسان شیائومی مدل&nbsp;POCO F3 را به گواهینامه IP53 مجهز کرده&zwnj;اند که به این معنا است که این محصول در برابر قطرات آب و گردوغبار مقاوم است.&nbsp;&nbsp;قاب پشتی گوشی POCO F3 مانند بسیاری از گوشی&zwnj;های مدرن که درعین سادگی به کیفیت هم فکر می&zwnj;کنند از یک رنگ و بافت منحصربه&zwnj;فرد برخوردارند و دارای طراحی خاصی است. برخلاف سری&zwnj;های پیشین&nbsp;POCO حسگر های دوربین از مرکز پشت قاب، به گوشه نقل مکان کرده&zwnj;اند. سنسور اثرانگشت هم روی لبه قاب تعبیه شده که به همراه کلید&zwnj;های کنترل صدا در یک سمت قرار گرفته است.&nbsp;قاب جلویی گوشی را یک نمایشگر تمام صفحه پر کرده است. گوشی F3&nbsp;از صفحه&zwnj;نمایشی بزرگ بهره می&zwnj;برد که شیائومی این روزها ارائه می&zwnj;دهد. صفحه&zwnj;نمایش 6.67 اینچی Full HD Plus با فناوری AMOLED با محافظ گوریلا گلس ۵ همراه&zwnj;شده است. این صفحه نمایش با دقت تصویر ۲۴۰۰ &times; ۱۰۸۰ پیکسل و تراکم پیکسلی ۳۹۵ پیکسل در هر اینچ، کیفیت مرغوبی را برای تماشای ویدیو، بازی کردن و گشت&zwnj;وگذار در اینترنت برای کاربران فراهم می&zwnj;کند. در این صفحه نمایش از فناوری E4 AMOLED بهره گرفته شده است علاوه بر اینکه&nbsp;می&zwnj;تواند تا ۱۶ میلیون رنگ را به راحتی آنالیز و نمایش دهد باعث افزایش ۱۵ درصدی عمر باتری هم خواهد شد. وجود نمایشگر با فناوری&nbsp;HDR10+ و 1300 نیت روشنایی موجب بهبود کیفیت رنگ&zwnj;ها شده است.&nbsp;بنابراین شما می&zwnj;توانید رنگ&zwnj;ها را در صفحه&zwnj;نمایش POCO F3&nbsp;بسیار زنده و با جزئیات مشاهده کنید.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"c-content-expert__text c-content-expert__text--center\">\r\n<div class=\"c-content-expert__img c-content-expert__img--center\"><img src=\"https://dkstatics-public.digikala.com/digikala-reviews/1d7c2d87290c00401a6fa68ce3ca3d21ef756fd8_1627218463.jpg?x-oss-process=image/resize,w_960/quality,q_70\" data-src=\"https://dkstatics-public.digikala.com/digikala-reviews/1d7c2d87290c00401a6fa68ce3ca3d21ef756fd8_1627218463.jpg?x-oss-process=image/resize,w_960/quality,q_70\" /></div>\r\n</div>\r\n</section>\r\n<section class=\"c-content-expert__article js-expert-article is-active\">\r\n<h3 class=\"c-content-expert__title\">عملکرد</h3>\r\n<div class=\"c-content-expert__text c-content-expert__text--row\">\r\n<div class=\"c-content-expert__text--right\">\r\n<p>&nbsp;</p>\r\n<p>اگر بخواهیم به&zwnj;صورت کاملا فنی و دقیق به مهم&zwnj;ترین بخش&zwnj;های داخلی سخت&zwnj;افزاری گوشی که تراشه، پردازنده، پردازنده گرافیکی و حافظه&zwnj;ها هستند به طور خلاصه نگاهی داشت، می&zwnj;&zwnj;توان گفت که گوشی موبایل پوکو مدل POCO F3 M2012K11AG دو سیم&zwnj; کارت ظرفیت 256 گیگابایت به تراشه Qualcomm SM8250-AC Snapdragon 870 5G (7 nm) Chipset مجهز شده است. تراشه&zwnj;ای که برای استفاده روی گوشی&zwnj;های میان&zwnj;رده&nbsp;رو به&zwnj; بالا&nbsp;ساخته و طراحی&zwnj;شده است. این تراشه ۳ پردازنده Kryo 585، Triple-Core Kryo 585 و&nbsp;Quad-Core Kryo 585 با فرکانس&zwnj;های&nbsp;3.2، 2.42، 1.80 گیگاهرتز&nbsp;را در خود قرار داده که بتواند سرعت و قدرت عملیاتی بالایی را برای گوشی را فراهم کند. روی این تراشه از پردازنده گرافیکی Adreno 650 GPU هم استفاده&zwnj;شده است که می&zwnj;توان با آن کارها و بازی&zwnj;های گرافیکی معمولی یا نیمه&zwnj;سنگین و در برخی اوقات سنگین را هم انجام داد. باید به این اشاره داشته باشیم که پردازنده این گوشی ۶۴ بیتی بوده و دارای سرعت بسیار بالاتری نسبت به پردازنده&zwnj;های ۳۲ بیتی است. ۸ گیگابایت حافظه رم هم برای این تلفن همراه هوشمند در نظر گرفته&zwnj;شده تا گوشی در بهترین حالت ممکن بتواند چند کار را با هم انجام دهد ولی با کمی کاهش سرعت روبرو می&zwnj;شود. این مقدار حافظه رم نقطه ضعفی برای این گوشی محبوب نیست. سازندگان POCO F3&nbsp;برای این مدل از حافظه داخلی ۲۵۶ گیگابایت استفاده کرده&zwnj;اند. در آزمایشات ما نشان&zwnj;داده شده است که این گوشی با این مقدار حافظه و RAM می&zwnj;تواند به راحتی پاسخ گوی نیازهای شما باشد. همچنین شیائومی با بکارگیری فناوری&nbsp;LiquidCool یا خنک&zwnj;کننده مایع، موجب خنک شدن گوشی در هنگام اجرای برنامه&zwnj;های سنگین شده است که این امر باعث بهبود عملکرد کلی دستگاه می&zwnj;شود.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"c-content-expert__img c-content-expert__img--left\"><img src=\"https://dkstatics-public.digikala.com/digikala-reviews/a3c8312aecf3195e6b027f264218f5ca7353e15d_1627216323.jpg?x-oss-process=image/resize,w_360/quality,q_70\" data-src=\"https://dkstatics-public.digikala.com/digikala-reviews/a3c8312aecf3195e6b027f264218f5ca7353e15d_1627216323.jpg?x-oss-process=image/resize,w_360/quality,q_70\" /></div>\r\n</div>\r\n</section>\r\n<section class=\"c-content-expert__article js-expert-article is-active\">\r\n<h3 class=\"c-content-expert__title\">دوربین</h3>\r\n<div class=\"c-content-expert__text c-content-expert__text--row\">\r\n<div class=\"c-content-expert__img c-content-expert__img--right\"><img src=\"https://dkstatics-public.digikala.com/digikala-reviews/97fcbb6be33fa25137c14ef7645357fbc16d3a5e_1627216869.jpg?x-oss-process=image/resize,w_360/quality,q_70\" data-src=\"https://dkstatics-public.digikala.com/digikala-reviews/97fcbb6be33fa25137c14ef7645357fbc16d3a5e_1627216869.jpg?x-oss-process=image/resize,w_360/quality,q_70\" /></div>\r\n<div class=\"c-content-expert__text--left\">\r\n<p>&nbsp;</p>\r\n<p>POCO F3 هم با سه دوربین ۴۸، ۸&nbsp;و ۵ مگاپیکسل معرفی شد. دوربین مخصوص و بسیار محبوب عکاسی از اجسام بسیار ریز یا همان ماکرو دارای قدرت بیشتری شده بود و طرفداران این نوع عکاسی که از محصولات شیائومی استفاده می&zwnj;کردند نظرات بسیار مثبتی به این موضوع داشتند. حالا شیائومی، دوربین POCO F3&nbsp;خود را با یک لنز فوق عریض با رزولوشن بالا و یک لنز ماکرو ۵&nbsp;مگاپیکسلی ارتقاء داده است. به این ترتیب دوربین POCO&nbsp;F3 شامل سه دوربین روی قاب پشتی است. این دوربین&zwnj;ها شامل یک لنز اصلی با رزولوشن ۴۸ مگاپیکسل، یک لنز فوق عریض ۸ مگاپیکسل&nbsp;و یک لنز ماکرو ۵ مگاپیکسلی است. البته یک فلش LED دوربین هم تعبیه&zwnj;شده است. در قاب&nbsp;جلو هم یک دوربین سلفی ۲۰ مگاپیکسل قرار گرفته است.&nbsp;دوربین اصلی POCO&nbsp;F3، عکس&zwnj;های بسیار خوبی را ثبت می&zwnj;کند و رنگ&zwnj;های طبیعی با جزئیات فراوان را برای کاربر به همراه دارد. همچنین عکس&zwnj;ها از رنگ، کنتراست و گستره داینامیک (Dynamic Range) خوبی برخوردار است. البته گستره داینامیک با استفاده از HDR هم تقویت می&zwnj;شود که البته برخی از جزئیات عکس در حین پردازش از بین می&zwnj;رود. کاهش نویز در تصاویر هم به&zwnj;خوبی انجام می&zwnj;گیرد. به&zwnj;طور کلی عکس&zwnj;های ۴۸ مگاپیکسلی پیش&zwnj;فرض برای یک گوشی میان&zwnj;رده رو به بالا کاملا&nbsp;عالی و قابل&zwnj;قبول هستند.&nbsp;به لطف وجود سنسور ماکرو، امکان ثبت تصاویر باکیفیت از فاصله بسیار نزدیک فراهم&zwnj;شده است. دوربین ۵ مگاپیکسلی ماکرو دارای فوکس ثابت در فاصله ۳ الی ۵ سانتی&zwnj;متری است؛ از این&zwnj;رو اگر سوژه مورد نظر در این فاصله قرار نگرفته باشد، با تصاویر تار مواجه خواهیم بود. استفاده از سنسور عمق برای عکاسی&lrm;&zwnj;های پرتره کاربرد دارد که باعث می&zwnj;&lrm;شود تصویر پشت سوژه محو (Bukeh) به نظر برسد. گفتنی است گه از لنز ماکرو می&zwnj;توان برای عکاسی از اجسام&nbsp;بسیار ریز هم مورد استفاده باشد.&nbsp;عکس&zwnj;های ثبت&zwnj;شده در نور کم هم همچنان از کیفیت مطلوبی برخوردارند. تصاویر از رنگ&zwnj;های خوبی برخوردار است و نویز در سطح پایین نگه&zwnj;داشته می&zwnj;شود.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n</div>\r\n<div class=\"c-content-expert__text\">\r\n<p>&nbsp;</p>\r\n<p>گوشی موبایل پوکو مدل F3&nbsp;دو سیم&zwnj; کارت ظرفیت 256 گیگابایت&nbsp;همچنین می&zwnj;تواند ویدیوهایی با رزولوشن&zwnj;ها و سرعت&zwnj;های مختلفی را &nbsp;با دوربین اصلی، لنز فوق عریض و دوربین سلفی فیلمبرداری ضبط کند. موضوعی که در فیلم&zwnj;برداری POCO F3 برای تمامی کاربران و منتقدان جالب و ارزشمند است، این بوده که این گوشی توانایی این را دارد که با حالات و سرعت&zwnj;های مختلفی فیلمبرداری کند و با تثبیت&zwnj;کننده الکترونیکی تصویر مبتنی بر ژیروسکوپ (gyro-EIS) تصاویری بسیار دقیق و با کیفیت را برای ما ثبت کند. همچنین ویدیوها از کنتراست و Dynamic Range خوبی برخوردار هستند. با متداول شدن دوربین&zwnj;هایی با کیفیت تصویر بهتر و بالاتر و افزایش قدرت بزرگنمایی دوربین&zwnj;ها از سمتی دیگر، مشکلات و ایرادهای تصویر در مواقع مختلف بیشتر به چشم کاربران می&zwnj;آید. حساسیت نسبت به تامین تصویری با کیفیت در تمامی شرایط و تمام طول شبانه روز افزایش قابل توجهی پیدا کرده است. EIS و یا (DIS (Digital Image Stabilization بر مبنای الگوریتم&zwnj;هایی کار می&zwnj;کند که به شبیه&zwnj;سازی حرکات دوربین و نیز کاهش اثر این حرکات در تصویر می&zwnj;پردازند. نقطه ضعف این روش این است که امکان دارد حرکت اجسام متحرک در تصویر (به ویژه اجسام متحرک با سرعت بالا) با ارتعاش ایجاد شده بر روی کل دوربین اشتباه گرفته شود. مزیت این روش نیز، عدم استفاده از قطعات بیشتر و هزینه کم پیاده&zwnj;سازی آن است. برای رفع مشکل ذکر شده از تکنیک Optical Image Stabilization استفاده می&zwnj;کنند. این تکنیک بر مبنای داده&zwnj;های حاصل از Gyroscope و یا همان شتاب&zwnj;سنج برای تشخیص و اندازه&zwnj;گیری میزان حرکت دوربین طی یک ارتعاش (لرزه) کار می&zwnj;کند. اطلاعات به&zwnj;دست&zwnj;آمده از شتاب&zwnj;سنج&zwnj;ها صرفا محدود به حرکت افقی و عمودی دوربین (Pan&amp;Tilt) هستند و باید بعدا توسط رله&zwnj;ها به&zwnj;سمت محرک&zwnj;ها (Actuator) موتور کنترل&zwnj;کننده لنز هدایت شوند. در بعضی موارد به جای حرکت لنز،&nbsp;سنسور تصویر توسط موتورهای خطی حرکت داده می&zwnj;شود. در هر صورت&zwnj;، چه لنز حرکت کند یا سنسور، این حرکات با این هدف است که نور درست همانند وقتی که لرزشی در کار نیست به سنسور برسد. این روش به ویژه در مواردی که از لنزهای با فاصله کانونی&zwnj;های دورتر (Longer Focal Length) استفاده می&zwnj;کنیم کاربرد دارد و نیز در تصویر برداری در محیط کم نور به بهبود تصویر کمک میکند. تنها نکته منفی در این روش هزینه بالای آن است.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n</section>\r\n<section class=\"c-content-expert__article js-expert-article is-active\">\r\n<h3 class=\"c-content-expert__title\">باتری</h3>\r\n<div class=\"c-content-expert__text\">\r\n<p>&nbsp;</p>\r\n<p>گوشی موبایل شیائومی POCO F3&nbsp;دو سیم&zwnj; کارت&nbsp;یک&nbsp;باتری لیتیوم-پلیمر با ظرفیت 4520 میلی&zwnj;آمپرساعت دارد. این میزان ظرفیت باتری فوق&zwnj;العاده است و می&zwnj;تواند این گوشی را به محصولی شگفت&zwnj;انگیز از لحاظ قدرت و ماندگاری شارژ باتری در بین محصولات میان&zwnj;رده بازار تبدیل کند. باتری در شرایط استفاده معمولی، می&zwnj;تواند ۲ الی ۳ روز گوشی را روشن نگه دارد. با این حال تماشای فیلم با صفحه نمایش کاملا روشن و بازی کردن، مخصوصا بازی&zwnj;های سبک، مصرف باتری را بالا می&zwnj;برد و اینجا است که مشاهده می&zwnj;کنید باتری زودتر تمام می&zwnj;شود. این باتری استفاده شده در F3&nbsp;لیتیوم-پولیمری است که جدیدترین نوع باتری برای استفاده در گوشی&zwnj;ها است. گفتنی است طبق ادعای شیائومی باتری این گوشی&nbsp;52 زمان برای تکمیل شارژ نیاز دارد و این موضوع نشان از شارژر سریع 33 واتی اسن محصول است.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"c-content-expert__text c-content-expert__text--center\">\r\n<div class=\"c-content-expert__img c-content-expert__img--center\"><img src=\"https://dkstatics-public.digikala.com/digikala-reviews/141d70d774c18b260165c729453ee838a7102155_1627218204.jpg?x-oss-process=image/resize,w_960/quality,q_70\" data-src=\"https://dkstatics-public.digikala.com/digikala-reviews/141d70d774c18b260165c729453ee838a7102155_1627218204.jpg?x-oss-process=image/resize,w_960/quality,q_70\" /></div>\r\n</div>\r\n</section>\r\n</div>\r\n</article>\r\n</div>', NULL, 'shakhes-1.jpg', NULL, NULL, NULL, NULL, 'active', 'open', 412, 412, '', '443,444,447', 'public', '0.00', NULL, 0, 2, '[{\"name\":\"\\u062a\\u06a9\\u0646\\u0648\\u0644\\u0648\\u0698\\u06cc \\u0645\\u0648\\u0631\\u062f \\u0627\\u0633\\u062a\\u0641\\u0627\\u062f\\u0647\",\"value\":\"php , VueJs , NodeJs , Csst , Laravel , Redis , Material\",\"class\":\"fal fa-user\"},{\"name\":\"\\u0627\\u062f\\u0631\\u0633 \\u062f\\u0627\\u0645\\u0646\\u0647\",\"value\":\"http:\\/\\/sakha.com\",\"class\":\"fal fa-globe\"},{\"name\":\"\\u0646\\u0648\\u0639 \\u0633\\u0627\\u06cc\\u062a\",\"value\":\"\\u0641\\u0631\\u0648\\u0634\\u06af\\u0627\\u0647\\u06cc \\u060c \\u062e\\u0628\\u0631\\u06cc\",\"class\":\"fal fa-bookmark\"},{\"name\":\"\\u0632\\u0645\\u0627\\u0646 \\u067e\\u0631\\u0648\\u0698\\u0647\",\"value\":\"45 \\u0631\\u0648\\u0632\",\"class\":\"fal fa-bell\"}]', '2022-01-05 13:15:23', '2022-08-04 14:40:10'),
(78, 0, 'یک نمونه در حال تست2', 'portfolio', 'text', 'fa', 'یک-نمونه-در-حال-تست2', '<div id=\"desc\" class=\"c-content-expert js-product-tab-content is-active\" data-method=\"desc\">\r\n<article>\r\n<div class=\"o-box__header\" style=\"text-align: justify;\"><span class=\"o-box__title\">نقد و بررسی اجمالی</span><span class=\"o-box__header-desc\">Xiaomi POCO F3 5G M2012K11AG Dual SIM 256GB And 8GB RAM Mobile Phone</span></div>\r\n<section class=\"c-content-expert__summary\">\r\n<div class=\"c-mask js-mask\">\r\n<div class=\"c-mask__text c-mask__text--product-summary js-mask__text is-active\" style=\"text-align: justify;\">گوشی موبایل شیائومی مدل Poco F3 دو سیم&zwnj; کارت ظرفیت 256 گیگابایت از جمله محصولات برند شیائومی که در سال 2021 روانه بازار شده است. این محصول دارای ساختاری متوازن و خوش&zwnj;ساخت بدون پشتیبانی از تکنولوژی 5G روانه بازار شده است. این محصول از بدنه شیشه&zwnj;ای و فریم پلاستیکی ساخته شده است که قاب جلو شیشه&zwnj;ای جلوه ویژه&zwnj;ای به این مدل بخشیده است. صفحه&zwnj;نمایش گوشی موبایل شیائومی مدل POCO F3 دو سیم&zwnj; کارت ظرفیت 256 گیگابایت در اندازه 6.67 منتشر شده است. این صفحه&zwnj;نمایش کاملاً تمام&zwnj;صفحه است و در بالا وسط اثری از بریدگی یا حفره دوربین سلفی وجود دیده می&zwnj;شود. دوربین سلفی این محصول دارای حسگر 20 مگاپیکسلی است .صحفه&zwnj;نمایش گوشی موبایل شیائومی مدل POCO F3 با استفاده از فناوری Corning Gorilla Glass 5 در برابر خط&zwnj;وخش و صدمات احتمالی محافظت می&zwnj;شود. گفتنی است 3 دوربین که سنسور اصلی آن 48 مگاپیکسلی است در قسمت پشتی این گوشی جا خوش کرده&zwnj;اند. این دوربین&zwnj;ها قادر هستند ویدئوی 4K را ثبت و ضبط کنند. دوربین&zwnj; سلفی این محصول هم به سنسوری 20 مگاپیکسلی مجهز شده است. بلوتوث نسخه 5.1 ، نسخه 11 سیستم عامل اندروید و باتری 4520 میلی&zwnj;آمپرساعتی از دیگر ویژگی&zwnj;&zwnj;های این گوشی جدید هستند.</div>\r\n</div>\r\n</section>\r\n<div class=\"c-content-expert__separator\" style=\"text-align: justify;\">&nbsp;</div>\r\n</article>\r\n</div>\r\n<div id=\"expert_review\" class=\"c-content-expert js-product-tab-content is-active\" data-method=\"expert_review\">\r\n<article>\r\n<div class=\"o-box__header\" style=\"text-align: justify;\"><span class=\"o-box__title\">نقد و بررسی تخصصی</span><span class=\"o-box__header-desc\">Xiaomi POCO F3 5G M2012K11AG Dual SIM 256GB And 8GB RAM Mobile Phone</span></div>\r\n<div class=\"c-content-expert__articles js-product-review-container is-open\">\r\n<section class=\"c-content-expert__article js-expert-article is-active\">\r\n<h3 class=\"c-content-expert__title\">معرفی</h3>\r\n<div class=\"c-content-expert__text\">\r\n<p>&nbsp;</p>\r\n<p style=\"text-align: justify;\">بسیاری از ما به دلیل بالا بودن قیمت گوشی&zwnj;های پرچمدار امکان خرید این محصولات را نداریم. بنابراین در بازار گوشی&zwnj;های میان&zwnj;رده باید گوشی مورد نظر خود را جستجو کنیم. حال در این میان شرکت بزرگ شیائومی که یکی از بزرگترین شرکت&zwnj;های تولید کننده گوشی موبایل در جهان است تنوع بالایی از گوشی&zwnj;های میان&zwnj;رده با کیفیت و هزینه معقول روانه بازار کرده است. سری پوکو برند شیائومی یکی از محبوب&zwnj;ترین میان&zwnj;رده&zwnj;های موجود در بازار است.&nbsp;شیائومی این بار گوشی موبایل&nbsp;POCO F3 را طراحی کرده است. این گوشی در بعضی از سطوح در حد و اندازه یک پرچمدار است.&nbsp;&nbsp;این گوشی موبایل دارای یک طراحی زیبا &nbsp;در قامت&nbsp;یک پرچمدار در اواخر مارس ۲۰۲۱ معرفی شده است.&nbsp;شیائومی نسخه POCO F3 با تکنولوژی 5G&nbsp;را با وزنی مناسب و یک طراحی متفاوت نسبت به سری&zwnj;های قبلی روانه بازار کرده است.&nbsp;شرکت شیائومی برای گوشی&nbsp;POCO F3 هم سه دوربین واید، التراواید و ماکرو در نظر کرفته است. تراشه یا چیپست رده بالا از دیگر امکانات قابل ذکر و مهم این مدل است.&nbsp;شرکت شیائومی با ساخت گوشی موبایل مدل POCO F3 5G M2012K11AG بار دیگر سعی کرده است تا سهم بازار خود را در گوشی&lrm;&zwnj;های میان رده حفظ کند.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"c-content-expert__text c-content-expert__text--center\">\r\n<div class=\"c-content-expert__img c-content-expert__img--center\"><img src=\"https://dkstatics-public.digikala.com/digikala-reviews/00c4d45f3cf6b7f832cdb70084716c8b0adfdefc_1627204357.jpg?x-oss-process=image/resize,w_960/quality,q_70\" data-src=\"https://dkstatics-public.digikala.com/digikala-reviews/00c4d45f3cf6b7f832cdb70084716c8b0adfdefc_1627204357.jpg?x-oss-process=image/resize,w_960/quality,q_70\" /></div>\r\n</div>\r\n</section>\r\n<section class=\"c-content-expert__article js-expert-article is-active\">\r\n<h3 class=\"c-content-expert__title\">طراحی و صفحه نمایش</h3>\r\n<div class=\"c-content-expert__text\">\r\n<p>&nbsp;</p>\r\n<p style=\"text-align: justify;\">طراحی و ظاهر مدل&nbsp;POCO F3 اندکی با سری&zwnj;های قبلی&nbsp;POCO متفاوت&zwnj;تر است. بدنه جلو وعقب گوشی توسط&nbsp;&nbsp;گوریلا گلس ۵ محافظت شده است. همچنین مهندسان شیائومی مدل&nbsp;POCO F3 را به گواهینامه IP53 مجهز کرده&zwnj;اند که به این معنا است که این محصول در برابر قطرات آب و گردوغبار مقاوم است.&nbsp;&nbsp;قاب پشتی گوشی POCO F3 مانند بسیاری از گوشی&zwnj;های مدرن که درعین سادگی به کیفیت هم فکر می&zwnj;کنند از یک رنگ و بافت منحصربه&zwnj;فرد برخوردارند و دارای طراحی خاصی است. برخلاف سری&zwnj;های پیشین&nbsp;POCO حسگر های دوربین از مرکز پشت قاب، به گوشه نقل مکان کرده&zwnj;اند. سنسور اثرانگشت هم روی لبه قاب تعبیه شده که به همراه کلید&zwnj;های کنترل صدا در یک سمت قرار گرفته است.&nbsp;قاب جلویی گوشی را یک نمایشگر تمام صفحه پر کرده است. گوشی F3&nbsp;از صفحه&zwnj;نمایشی بزرگ بهره می&zwnj;برد که شیائومی این روزها ارائه می&zwnj;دهد. صفحه&zwnj;نمایش 6.67 اینچی Full HD Plus با فناوری AMOLED با محافظ گوریلا گلس ۵ همراه&zwnj;شده است. این صفحه نمایش با دقت تصویر ۲۴۰۰ &times; ۱۰۸۰ پیکسل و تراکم پیکسلی ۳۹۵ پیکسل در هر اینچ، کیفیت مرغوبی را برای تماشای ویدیو، بازی کردن و گشت&zwnj;وگذار در اینترنت برای کاربران فراهم می&zwnj;کند. در این صفحه نمایش از فناوری E4 AMOLED بهره گرفته شده است علاوه بر اینکه&nbsp;می&zwnj;تواند تا ۱۶ میلیون رنگ را به راحتی آنالیز و نمایش دهد باعث افزایش ۱۵ درصدی عمر باتری هم خواهد شد. وجود نمایشگر با فناوری&nbsp;HDR10+ و 1300 نیت روشنایی موجب بهبود کیفیت رنگ&zwnj;ها شده است.&nbsp;بنابراین شما می&zwnj;توانید رنگ&zwnj;ها را در صفحه&zwnj;نمایش POCO F3&nbsp;بسیار زنده و با جزئیات مشاهده کنید.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"c-content-expert__text c-content-expert__text--center\">\r\n<div class=\"c-content-expert__img c-content-expert__img--center\"><img src=\"https://dkstatics-public.digikala.com/digikala-reviews/1d7c2d87290c00401a6fa68ce3ca3d21ef756fd8_1627218463.jpg?x-oss-process=image/resize,w_960/quality,q_70\" data-src=\"https://dkstatics-public.digikala.com/digikala-reviews/1d7c2d87290c00401a6fa68ce3ca3d21ef756fd8_1627218463.jpg?x-oss-process=image/resize,w_960/quality,q_70\" /></div>\r\n</div>\r\n</section>\r\n<section class=\"c-content-expert__article js-expert-article is-active\">\r\n<h3 class=\"c-content-expert__title\" style=\"text-align: justify;\">عملکرد</h3>\r\n<div class=\"c-content-expert__text c-content-expert__text--row\">\r\n<div class=\"c-content-expert__text--right\">\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">اگر بخواهیم به&zwnj;صورت کاملا فنی و دقیق به مهم&zwnj;ترین بخش&zwnj;های داخلی سخت&zwnj;افزاری گوشی که تراشه، پردازنده، پردازنده گرافیکی و حافظه&zwnj;ها هستند به طور خلاصه نگاهی داشت، می&zwnj;&zwnj;توان گفت که گوشی موبایل پوکو مدل POCO F3 M2012K11AG دو سیم&zwnj; کارت ظرفیت 256 گیگابایت به تراشه Qualcomm SM8250-AC Snapdragon 870 5G (7 nm) Chipset مجهز شده است. تراشه&zwnj;ای که برای استفاده روی گوشی&zwnj;های میان&zwnj;رده&nbsp;رو به&zwnj; بالا&nbsp;ساخته و طراحی&zwnj;شده است. این تراشه ۳ پردازنده Kryo 585، Triple-Core Kryo 585 و&nbsp;Quad-Core Kryo 585 با فرکانس&zwnj;های&nbsp;3.2، 2.42، 1.80 گیگاهرتز&nbsp;را در خود قرار داده که بتواند سرعت و قدرت عملیاتی بالایی را برای گوشی را فراهم کند. روی این تراشه از پردازنده گرافیکی Adreno 650 GPU هم استفاده&zwnj;شده است که می&zwnj;توان با آن کارها و بازی&zwnj;های گرافیکی معمولی یا نیمه&zwnj;سنگین و در برخی اوقات سنگین را هم انجام داد. باید به این اشاره داشته باشیم که پردازنده این گوشی ۶۴ بیتی بوده و دارای سرعت بسیار بالاتری نسبت به پردازنده&zwnj;های ۳۲ بیتی است. ۸ گیگابایت حافظه رم هم برای این تلفن همراه هوشمند در نظر گرفته&zwnj;شده تا گوشی در بهترین حالت ممکن بتواند چند کار را با هم انجام دهد ولی با کمی کاهش سرعت روبرو می&zwnj;شود. این مقدار حافظه رم نقطه ضعفی برای این گوشی محبوب نیست. سازندگان POCO F3&nbsp;برای این مدل از حافظه داخلی ۲۵۶ گیگابایت استفاده کرده&zwnj;اند. در آزمایشات ما نشان&zwnj;داده شده است که این گوشی با این مقدار حافظه و RAM می&zwnj;تواند به راحتی پاسخ گوی نیازهای شما باشد. همچنین شیائومی با بکارگیری فناوری&nbsp;LiquidCool یا خنک&zwnj;کننده مایع، موجب خنک شدن گوشی در هنگام اجرای برنامه&zwnj;های سنگین شده است که این امر باعث بهبود عملکرد کلی دستگاه می&zwnj;شود.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"c-content-expert__img c-content-expert__img--left\"><img src=\"https://dkstatics-public.digikala.com/digikala-reviews/a3c8312aecf3195e6b027f264218f5ca7353e15d_1627216323.jpg?x-oss-process=image/resize,w_360/quality,q_70\" data-src=\"https://dkstatics-public.digikala.com/digikala-reviews/a3c8312aecf3195e6b027f264218f5ca7353e15d_1627216323.jpg?x-oss-process=image/resize,w_360/quality,q_70\" /></div>\r\n</div>\r\n</section>\r\n<section class=\"c-content-expert__article js-expert-article is-active\">\r\n<h3 class=\"c-content-expert__title\">دوربین</h3>\r\n<div class=\"c-content-expert__text c-content-expert__text--row\">\r\n<div class=\"c-content-expert__img c-content-expert__img--right\"><img src=\"https://dkstatics-public.digikala.com/digikala-reviews/97fcbb6be33fa25137c14ef7645357fbc16d3a5e_1627216869.jpg?x-oss-process=image/resize,w_360/quality,q_70\" data-src=\"https://dkstatics-public.digikala.com/digikala-reviews/97fcbb6be33fa25137c14ef7645357fbc16d3a5e_1627216869.jpg?x-oss-process=image/resize,w_360/quality,q_70\" /></div>\r\n<div class=\"c-content-expert__text--left\">\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">POCO F3 هم با سه دوربین ۴۸، ۸&nbsp;و ۵ مگاپیکسل معرفی شد. دوربین مخصوص و بسیار محبوب عکاسی از اجسام بسیار ریز یا همان ماکرو دارای قدرت بیشتری شده بود و طرفداران این نوع عکاسی که از محصولات شیائومی استفاده می&zwnj;کردند نظرات بسیار مثبتی به این موضوع داشتند. حالا شیائومی، دوربین POCO F3&nbsp;خود را با یک لنز فوق عریض با رزولوشن بالا و یک لنز ماکرو ۵&nbsp;مگاپیکسلی ارتقاء داده است. به این ترتیب دوربین POCO&nbsp;F3 شامل سه دوربین روی قاب پشتی است. این دوربین&zwnj;ها شامل یک لنز اصلی با رزولوشن ۴۸ مگاپیکسل، یک لنز فوق عریض ۸ مگاپیکسل&nbsp;و یک لنز ماکرو ۵ مگاپیکسلی است. البته یک فلش LED دوربین هم تعبیه&zwnj;شده است. در قاب&nbsp;جلو هم یک دوربین سلفی ۲۰ مگاپیکسل قرار گرفته است.&nbsp;دوربین اصلی POCO&nbsp;F3، عکس&zwnj;های بسیار خوبی را ثبت می&zwnj;کند و رنگ&zwnj;های طبیعی با جزئیات فراوان را برای کاربر به همراه دارد. همچنین عکس&zwnj;ها از رنگ، کنتراست و گستره داینامیک (Dynamic Range) خوبی برخوردار است. البته گستره داینامیک با استفاده از HDR هم تقویت می&zwnj;شود که البته برخی از جزئیات عکس در حین پردازش از بین می&zwnj;رود. کاهش نویز در تصاویر هم به&zwnj;خوبی انجام می&zwnj;گیرد. به&zwnj;طور کلی عکس&zwnj;های ۴۸ مگاپیکسلی پیش&zwnj;فرض برای یک گوشی میان&zwnj;رده رو به بالا کاملا&nbsp;عالی و قابل&zwnj;قبول هستند.&nbsp;به لطف وجود سنسور ماکرو، امکان ثبت تصاویر باکیفیت از فاصله بسیار نزدیک فراهم&zwnj;شده است. دوربین ۵ مگاپیکسلی ماکرو دارای فوکس ثابت در فاصله ۳ الی ۵ سانتی&zwnj;متری است؛ از این&zwnj;رو اگر سوژه مورد نظر در این فاصله قرار نگرفته باشد، با تصاویر تار مواجه خواهیم بود. استفاده از سنسور عمق برای عکاسی&lrm;&zwnj;های پرتره کاربرد دارد که باعث می&zwnj;&lrm;شود تصویر پشت سوژه محو (Bukeh) به نظر برسد. گفتنی است گه از لنز ماکرو می&zwnj;توان برای عکاسی از اجسام&nbsp;بسیار ریز هم مورد استفاده باشد.&nbsp;عکس&zwnj;های ثبت&zwnj;شده در نور کم هم همچنان از کیفیت مطلوبی برخوردارند. تصاویر از رنگ&zwnj;های خوبی برخوردار است و نویز در سطح پایین نگه&zwnj;داشته می&zwnj;شود.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n</div>\r\n</div>\r\n<div class=\"c-content-expert__text\">\r\n<p>&nbsp;</p>\r\n<p style=\"text-align: justify;\">گوشی موبایل پوکو مدل F3&nbsp;دو سیم&zwnj; کارت ظرفیت 256 گیگابایت&nbsp;همچنین می&zwnj;تواند ویدیوهایی با رزولوشن&zwnj;ها و سرعت&zwnj;های مختلفی را &nbsp;با دوربین اصلی، لنز فوق عریض و دوربین سلفی فیلمبرداری ضبط کند. موضوعی که در فیلم&zwnj;برداری POCO F3 برای تمامی کاربران و منتقدان جالب و ارزشمند است، این بوده که این گوشی توانایی این را دارد که با حالات و سرعت&zwnj;های مختلفی فیلمبرداری کند و با تثبیت&zwnj;کننده الکترونیکی تصویر مبتنی بر ژیروسکوپ (gyro-EIS) تصاویری بسیار دقیق و با کیفیت را برای ما ثبت کند. همچنین ویدیوها از کنتراست و Dynamic Range خوبی برخوردار هستند. با متداول شدن دوربین&zwnj;هایی با کیفیت تصویر بهتر و بالاتر و افزایش قدرت بزرگنمایی دوربین&zwnj;ها از سمتی دیگر، مشکلات و ایرادهای تصویر در مواقع مختلف بیشتر به چشم کاربران می&zwnj;آید. حساسیت نسبت به تامین تصویری با کیفیت در تمامی شرایط و تمام طول شبانه روز افزایش قابل توجهی پیدا کرده است. EIS و یا (DIS (Digital Image Stabilization بر مبنای الگوریتم&zwnj;هایی کار می&zwnj;کند که به شبیه&zwnj;سازی حرکات دوربین و نیز کاهش اثر این حرکات در تصویر می&zwnj;پردازند. نقطه ضعف این روش این است که امکان دارد حرکت اجسام متحرک در تصویر (به ویژه اجسام متحرک با سرعت بالا) با ارتعاش ایجاد شده بر روی کل دوربین اشتباه گرفته شود. مزیت این روش نیز، عدم استفاده از قطعات بیشتر و هزینه کم پیاده&zwnj;سازی آن است. برای رفع مشکل ذکر شده از تکنیک Optical Image Stabilization استفاده می&zwnj;کنند. این تکنیک بر مبنای داده&zwnj;های حاصل از Gyroscope و یا همان شتاب&zwnj;سنج برای تشخیص و اندازه&zwnj;گیری میزان حرکت دوربین طی یک ارتعاش (لرزه) کار می&zwnj;کند. اطلاعات به&zwnj;دست&zwnj;آمده از شتاب&zwnj;سنج&zwnj;ها صرفا محدود به حرکت افقی و عمودی دوربین (Pan&amp;Tilt) هستند و باید بعدا توسط رله&zwnj;ها به&zwnj;سمت محرک&zwnj;ها (Actuator) موتور کنترل&zwnj;کننده لنز هدایت شوند. در بعضی موارد به جای حرکت لنز،&nbsp;سنسور تصویر توسط موتورهای خطی حرکت داده می&zwnj;شود. در هر صورت&zwnj;، چه لنز حرکت کند یا سنسور، این حرکات با این هدف است که نور درست همانند وقتی که لرزشی در کار نیست به سنسور برسد. این روش به ویژه در مواردی که از لنزهای با فاصله کانونی&zwnj;های دورتر (Longer Focal Length) استفاده می&zwnj;کنیم کاربرد دارد و نیز در تصویر برداری در محیط کم نور به بهبود تصویر کمک میکند. تنها نکته منفی در این روش هزینه بالای آن است.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n</section>\r\n<section class=\"c-content-expert__article js-expert-article is-active\">\r\n<h3 class=\"c-content-expert__title\" style=\"text-align: justify;\">باتری</h3>\r\n<div class=\"c-content-expert__text\" style=\"text-align: justify;\">\r\n<p>&nbsp;</p>\r\n<p>گوشی موبایل شیائومی POCO F3&nbsp;دو سیم&zwnj; کارت&nbsp;یک&nbsp;باتری لیتیوم-پلیمر با ظرفیت 4520 میلی&zwnj;آمپرساعت دارد. این میزان ظرفیت باتری فوق&zwnj;العاده است و می&zwnj;تواند این گوشی را به محصولی شگفت&zwnj;انگیز از لحاظ قدرت و ماندگاری شارژ باتری در بین محصولات میان&zwnj;رده بازار تبدیل کند. باتری در شرایط استفاده معمولی، می&zwnj;تواند ۲ الی ۳ روز گوشی را روشن نگه دارد. با این حال تماشای فیلم با صفحه نمایش کاملا روشن و بازی کردن، مخصوصا بازی&zwnj;های سبک، مصرف باتری را بالا می&zwnj;برد و اینجا است که مشاهده می&zwnj;کنید باتری زودتر تمام می&zwnj;شود. این باتری استفاده شده در F3&nbsp;لیتیوم-پولیمری است که جدیدترین نوع باتری برای استفاده در گوشی&zwnj;ها است. گفتنی است طبق ادعای شیائومی باتری این گوشی&nbsp;52 زمان برای تکمیل شارژ نیاز دارد و این موضوع نشان از شارژر سریع 33 واتی اسن محصول است.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n<div class=\"c-content-expert__text c-content-expert__text--center\">\r\n<div class=\"c-content-expert__img c-content-expert__img--center\" style=\"text-align: justify;\"><img src=\"https://dkstatics-public.digikala.com/digikala-reviews/141d70d774c18b260165c729453ee838a7102155_1627218204.jpg?x-oss-process=image/resize,w_960/quality,q_70\" data-src=\"https://dkstatics-public.digikala.com/digikala-reviews/141d70d774c18b260165c729453ee838a7102155_1627218204.jpg?x-oss-process=image/resize,w_960/quality,q_70\" /></div>\r\n</div>\r\n</section>\r\n</div>\r\n</article>\r\n</div>', NULL, 'open13.png', NULL, NULL, NULL, NULL, 'active', 'open', 412, 412, ',شرکتی,طراحی سایت,نمونه کار فروشگاهی,خبری', '443,444,447', 'public', '0.00', NULL, 0, 3, '[{\"name\":\"\\u062a\\u06a9\\u0646\\u0648\\u0644\\u0648\\u0698\\u06cc \\u0645\\u0648\\u0631\\u062f \\u0627\\u0633\\u062a\\u0641\\u0627\\u062f\\u0647\",\"value\":\"php , VueJs , NodeJs , Csst , Laravel , Redis , Material\",\"class\":\"fal fa-user\"},{\"name\":\"\\u0627\\u062f\\u0631\\u0633 \\u062f\\u0627\\u0645\\u0646\\u0647\",\"value\":\"http:\\/\\/sakha.com\",\"class\":\"fal fa-globe\"},{\"name\":\"\\u0646\\u0648\\u0639 \\u0633\\u0627\\u06cc\\u062a\",\"value\":\"\\u0641\\u0631\\u0648\\u0634\\u06af\\u0627\\u0647\\u06cc \\u060c \\u062e\\u0628\\u0631\\u06cc\",\"class\":\"fal fa-bookmark\"},{\"name\":\"\\u0632\\u0645\\u0627\\u0646 \\u067e\\u0631\\u0648\\u0698\\u0647\",\"value\":\"45 \\u0631\\u0648\\u0632\",\"class\":\"fal fa-bell\"}]', '2022-01-05 13:41:07', '2022-08-04 14:40:10'),
(88, 0, 'اولین مکاتبه تست', 'post', 'text', 'fa', NULL, '<p>متن با محتوای مکاتبه</p>', NULL, NULL, 'D:\\wamp64\\www\\mis_maleki/uploads/post/88_lantern-installer.exe', NULL, NULL, NULL, 'active', 'open', 412, 412, NULL, NULL, 'public', '0.00', NULL, 0, 0, NULL, '2022-12-29 15:45:56', '2022-12-29 16:11:06'),
(89, 0, 'مکاتبه شماره 2', 'post', 'text', 'fa', NULL, '<p>با سلام و عرض ادب&nbsp;</p>\r\n<p>مکاتبه دیگری با این سامانه توسط بنده در جال تست است</p>', NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'open', 412, 412, NULL, NULL, 'public', '0.00', NULL, 0, 0, NULL, '2022-12-31 07:47:16', NULL),
(90, 0, 'مکاتبه شماره سه با یک فایل ضمیمه', 'post', 'text', 'fa', NULL, '<p>در این مکاتبه من یک فایل تصویر با مضمون <strong><span style=\"color: #2dc26b;\">انجیر و خواص</span></strong> ان ضمیمه کردم که قابل مشاهده است</p>', NULL, NULL, 'D:\\wamp64\\www\\mis_maleki/uploads/post/90_صفر-تا-صد-انجیر-خواص،-انواع-و-قیمت-خرید-این-میوه-تابستانی.jpg', NULL, NULL, NULL, 'active', 'open', 412, 412, NULL, NULL, 'public', '0.00', NULL, 0, 0, NULL, '2022-12-31 07:49:14', '2022-12-31 07:50:34'),
(91, 0, 'مکاتبه شماره سه با یک فایل ضمیمه (copy)', 'post', 'text', 'fa', NULL, '<p>در این مکاتبه من یک فایل تصویر با مضمون <strong><span style=\"color: #2dc26b;\">انجیر و خواص</span></strong> ان ضمیمه کردم که قابل مشاهده است</p>', NULL, NULL, 'C:\\wamp64\\www\\mis_maleki/uploads/post/91_رزومه الهام ملکی.pdf', NULL, NULL, NULL, 'active', 'open', 412, 412, NULL, NULL, 'public', '0.00', NULL, 0, 0, NULL, '2023-01-01 14:03:49', '2023-01-01 14:03:49'),
(93, 0, 'عنوان مکاتبه من', 'post', 'text', 'fa', NULL, '<p>مکاتبه من <img src=\"http://localhost/mis_maleki/uploads/media/Screenshot_2021_09_10_7.38.39_AM.0.jpg\" alt=\"Mohammad Shoja\" /></p>', NULL, NULL, 'C:\\wamp64\\www\\mis_maleki/uploads/post/93_رزومه الهام ملکی.pdf', NULL, NULL, NULL, 'inactive', 'open', 412, 412, NULL, NULL, 'public', '0.00', NULL, 0, 0, NULL, '2023-01-04 17:18:36', '2023-01-04 17:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `ms011_role`
--

DROP TABLE IF EXISTS `ms011_role`;
CREATE TABLE IF NOT EXISTS `ms011_role` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'روتهای استثنا برای دیدن شدن درمنوی این نقش کاربری',
  `access_panel` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'no' COMMENT 'اجازه ورود به پنل ادمین',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=404 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ms011_role`
--

INSERT INTO `ms011_role` (`id`, `role`, `title`, `menu`, `access_panel`, `created_at`, `updated_at`) VALUES
(399, 'administrator', 'مدیر ارشد', 'administrator', 'yes', '2021-02-02 14:38:01', '2021-02-02 14:38:04'),
(400, 'operator', 'اپراتور', 'operator', 'yes', '2021-02-03 08:57:17', '2021-07-29 12:09:52'),
(401, 'personal', 'پرسنل', 'administrator', 'yes', '2021-02-03 08:59:04', '2021-02-03 08:59:06'),
(402, 'customer', 'مشتری', '', 'no', '2021-02-03 08:59:07', '2021-02-03 08:59:14'),
(403, 'rs_agent', 'نماینده املاک', 'operator', 'yes', '2021-09-28 09:52:24', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ms011_users`
--

DROP TABLE IF EXISTS `ms011_users`;
CREATE TABLE IF NOT EXISTS `ms011_users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(198) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'customer',
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `nickname` varchar(198) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `fname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `lname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `request_email` varchar(198) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(198) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission_id` int(11) DEFAULT '0',
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `credit` decimal(10,0) DEFAULT '0',
  `income` decimal(10,1) DEFAULT '0.0',
  `score` float(10,0) DEFAULT '0',
  `debit` decimal(10,2) DEFAULT '0.00' COMMENT 'سقف بدهی استاد کار',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'verification',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` int(11) DEFAULT '0',
  `city` int(11) DEFAULT '0',
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_melli` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `birthday` datetime DEFAULT NULL,
  `married` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `about_me` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'متن توصیحی درباره سابقه مهارتها',
  `rate` float(7,0) DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_verify_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'کد تایید پیامکی موبایل',
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recovery_pass_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edit_by` int(11) DEFAULT '0',
  `present_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intro_id` int(11) DEFAULT '0' COMMENT 'نحوه اشنایی',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'real' COMMENT 'rea | legal',
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'نام شرکت',
  `owner_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'نام مدیر شرکت',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_email_unique` (`email`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=438 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ms011_users`
--

INSERT INTO `ms011_users` (`id`, `username`, `parent_id`, `role`, `mobile`, `nickname`, `fname`, `lname`, `request_email`, `email`, `password`, `permission_id`, `tel`, `credit`, `income`, `score`, `debit`, `status`, `address`, `state`, `city`, `zip_code`, `lat`, `lng`, `code_melli`, `birthday`, `married`, `sex`, `avatar`, `description`, `about_me`, `rate`, `remember_token`, `mobile_verify_code`, `api_token`, `recovery_pass_token`, `edit_by`, `present_code`, `intro_id`, `type`, `company_name`, `owner_name`, `created_at`, `updated_at`) VALUES
(412, 'admin', 0, 'administrator', '09115119590', 'محمد شجاع', 'محمد', 'شجاع', NULL, 'mohammadshoja65@gmail.com', '$2y$10$aUqGnUr2H.AOGsAHQ8Nd/.KoaPv9nFh.NnlCpyd6Segx64FYXfDbS', 0, '', '922054210', '0.0', 0, '0.00', 'active', 'کمربندی بعد از میدان کشوری', 27, 588, '26598989', '', '', NULL, '1986-05-23 00:00:00', '', 'man', '3433911965.jpg', NULL, '', 0, 'KDXEO0mBIIDDkSRinZ9sJrXhjxToDJzjdl42bSyuwqxth5XpzYLFo4SCUbI5', '11111', '', 'eyJpdiI6ImgwUU1qQ2NXa3FVNlRodXVKc1VjVnc9PSIsInZhbHVlIjoidHRMSHVlWFZBYktYczZTRjlXT21QZz09IiwibWFjIjoiZGFmZDM4MTE4ZDcxYzNiN2QwZGVjMTI2YjQyZDk3YzY0MDkwNzM1NTViNjVkMzI4MDA0NjBiMTU0YjM0MWIyOCIsInRhZyI6IiJ9', 412, '203201', 0, NULL, NULL, NULL, '2021-02-07 07:30:42', '2022-12-31 08:35:59'),
(434, 'maleki', 0, 'administrator', '09145652365', 'خانم ملکی', 'خانم', 'ملکی', NULL, NULL, '$2y$10$Hl6ivhEEUmmXlg29pldexuZz8lcDHPnSsccLJg9zbktJ/3wfIfDOK', 0, '', '0', '0.0', 0, '0.00', 'active', '', 0, 0, '', NULL, NULL, '3265695965', '2023-01-01 00:00:00', '', NULL, NULL, NULL, NULL, 0, 'uaEOIsdnIKkgFJP5WTxgdfk6lISozyYd8Eomapwb9vepoYL3VBSeAp1xSd3H', NULL, NULL, NULL, 412, '3550589', 0, 'legal', 'رسولی', 'احمد', '2022-12-31 08:21:12', '2022-12-31 08:34:45'),
(437, 'admin_09156250277', 0, 'administrator', '09156250277', 'حسین محمدی', 'حسین', 'محمدی', NULL, NULL, '$2y$10$W4Onh7/I5UeJgDLIlmPVTun2QzSUgN0VWquPYKSy2IKz74K1ynFEi', 0, '', '0', '0.0', 0, '0.00', 'active', NULL, 0, 0, '', NULL, NULL, '0944914942', NULL, '', NULL, '3566468776.jpg', NULL, NULL, 0, NULL, NULL, NULL, NULL, 437, NULL, 0, 'legal', 'نام شرکت شرکت ایلیا', 'نام مدیر شرکت حسن فرشچی', '2023-01-04 18:39:16', '2023-01-04 18:49:30');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
