
DROP TABLE IF EXISTS `#__nam`;
DROP TABLE IF EXISTS `#__diem`;
DROP TABLE IF EXISTS `#__hk`;
DROP TABLE IF EXISTS `#__xl`;
DROP TABLE IF EXISTS `#__hs`;

CREATE TABLE IF NOT EXISTS `#__diem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mhs` varchar(15) NOT NULL,
  `mlop` varchar(10) NOT NULL,
  `mnam` varchar(15) NOT NULL,
  `mhk` varchar(2) NOT NULL,
  `mmon` varchar(5) NOT NULL,
  `dm_1` varchar(5) NOT NULL,
  `dm_2` varchar(5) NOT NULL,
  `d15_1` varchar(5) NOT NULL,
  `d15_2` varchar(5) NOT NULL,
  `d15_3` varchar(5) NOT NULL,
  `d15_4` varchar(5) NOT NULL,
  `d15_5` varchar(5) NOT NULL,
  `d1t_1` varchar(5) NOT NULL,
  `d1t_2` varchar(5) NOT NULL,
  `d1t_3` varchar(5) NOT NULL,
  `d1t_4` varchar(5) NOT NULL,
  `d1t_5` varchar(5) NOT NULL,
  `dthi` varchar(5) NOT NULL,
  `dtb` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mhk` varchar(7) NOT NULL,
  `hk` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mhs` varchar(15) NOT NULL,
  `mnam` varchar(15) NOT NULL,
  `hoten` varchar(50) NOT NULL,
  `mlop` varchar(10) NOT NULL,
  `phai` varchar(2) NOT NULL,
  `namsinh` varchar(10) NOT NULL,
  `noisinh` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__nam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mnam` varchar(7) NOT NULL,
  `nam` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__xl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mhs` varchar(15) NOT NULL,
  `mlop` varchar(10) NOT NULL,
  `mnam` varchar(15) NOT NULL,
  `mhk` varchar(2) NOT NULL,

  `dtbm` varchar(5) NOT NULL,
  `hluc` varchar(15) NOT NULL,
  `hkiem` varchar(15) NOT NULL,
  `snncp` varchar(3) NOT NULL,
  `snnkp` varchar(3) NOT NULL,
  `dhieu` varchar(15) NOT NULL,
  `nhanxet` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;