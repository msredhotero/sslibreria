-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-11-2016 a las 21:57:47
-- Versión del servidor: 5.1.36-community-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sslibreria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbclientes`
--

CREATE TABLE IF NOT EXISTS `dbclientes` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombrecompleto` varchar(120) NOT NULL,
  `cuil` varchar(11) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `observaciones` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`idcliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `dbclientes`
--

INSERT INTO `dbclientes` (`idcliente`, `nombrecompleto`, `cuil`, `dni`, `direccion`, `telefono`, `email`, `observaciones`) VALUES
(1, 'Saupurein Marcos', '20315524661', '31552466', '76', '4661100', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbdetallepedido`
--

CREATE TABLE IF NOT EXISTS `dbdetallepedido` (
  `iddetallepedido` int(11) NOT NULL AUTO_INCREMENT,
  `refpedidos` int(11) NOT NULL,
  `refproductos` int(11) NOT NULL,
  `cantidad` smallint(6) DEFAULT NULL,
  `precio` decimal(12,2) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `falto` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`iddetallepedido`),
  KEY `fk_DetallePedido_Pedido1` (`refpedidos`),
  KEY `fk_DetallePedido_Producto1` (`refproductos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `dbdetallepedido`
--

INSERT INTO `dbdetallepedido` (`iddetallepedido`, `refpedidos`, `refproductos`, `cantidad`, `precio`, `total`, `falto`) VALUES
(31, 3, 7, 14, '50.00', '700.00', 0),
(32, 3, 6, 3, '30.00', '90.00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbdetallepedidoaux`
--

CREATE TABLE IF NOT EXISTS `dbdetallepedidoaux` (
  `iddetallepedidoaux` int(11) NOT NULL AUTO_INCREMENT,
  `refproductos` int(11) NOT NULL,
  `cantidad` smallint(6) DEFAULT NULL,
  `precio` decimal(12,2) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`iddetallepedidoaux`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbdetalleventas`
--

CREATE TABLE IF NOT EXISTS `dbdetalleventas` (
  `iddetallecompra` int(11) NOT NULL AUTO_INCREMENT,
  `refventas` int(11) NOT NULL,
  `refproductos` int(11) NOT NULL,
  `producto` varchar(140) NOT NULL,
  `cantidad` smallint(6) NOT NULL,
  `precio` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  PRIMARY KEY (`iddetallecompra`),
  KEY `fk_DetalleCompra_Compra1_idx` (`refventas`),
  KEY `fk_DetalleCompra_Producto1_idx` (`refproductos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbempleados`
--

CREATE TABLE IF NOT EXISTS `dbempleados` (
  `idempleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(80) NOT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `sexo` varchar(15) NOT NULL,
  `fechanac` date NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `fechaing` date NOT NULL,
  `sueldo` decimal(8,2) DEFAULT NULL,
  `estado` varchar(30) NOT NULL,
  PRIMARY KEY (`idempleado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `dbempleados`
--

INSERT INTO `dbempleados` (`idempleado`, `nombre`, `apellido`, `dni`, `sexo`, `fechanac`, `direccion`, `telefono`, `celular`, `email`, `fechaing`, `sueldo`, `estado`) VALUES
(1, 'Gisela', 'Marin', '31558449', 'femenino', '1980-07-16', '', '', '', '', '2016-01-07', '7500.00', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbpedidos`
--

CREATE TABLE IF NOT EXISTS `dbpedidos` (
  `idpedido` int(11) NOT NULL AUTO_INCREMENT,
  `fechasolicitud` datetime DEFAULT NULL,
  `fechaentrega` datetime DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `refestados` int(11) NOT NULL,
  `referencia` varchar(45) DEFAULT NULL,
  `observacion` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`idpedido`),
  KEY `fk_Pedido_EstadoEnvio1_idx` (`refestados`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `dbpedidos`
--

INSERT INTO `dbpedidos` (`idpedido`, `fechasolicitud`, `fechaentrega`, `total`, `refestados`, `referencia`, `observacion`) VALUES
(3, '2016-10-27 00:00:00', '2016-11-05 00:00:00', '0.00', 3, 'aiusdyhaiushdi', 'Prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbproductos`
--

CREATE TABLE IF NOT EXISTS `dbproductos` (
  `idproducto` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) DEFAULT NULL,
  `codigobarra` varchar(45) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` smallint(6) DEFAULT NULL,
  `stockmin` smallint(6) DEFAULT NULL,
  `preciocosto` decimal(8,2) DEFAULT NULL,
  `precioventa` decimal(8,2) DEFAULT NULL,
  `utilidad` decimal(8,2) DEFAULT NULL,
  `estado` varchar(30) DEFAULT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `refcategorias` int(11) NOT NULL,
  `tipoimagen` varchar(15) DEFAULT NULL,
  `unidades` smallint(6) DEFAULT '1',
  `descripcion` varchar(300) DEFAULT NULL,
  `activo` bit(1) NOT NULL,
  PRIMARY KEY (`idproducto`),
  KEY `fk_Producto_Categoria_idx` (`refcategorias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `dbproductos`
--

INSERT INTO `dbproductos` (`idproducto`, `codigo`, `codigobarra`, `nombre`, `stock`, `stockmin`, `preciocosto`, `precioventa`, `utilidad`, `estado`, `imagen`, `refcategorias`, `tipoimagen`, `unidades`, `descripcion`, `activo`) VALUES
(2, 'PRO00001', '13216549849', 'Abrochadora Mex', 20, 3, '25.35', '69.00', '50.00', 'Bueno', '', 1, '', 1, 'Abrochadora tamaño chico', b'1'),
(6, 'PRO00002', '13546879846', 'AKSJDHASKHD', 50, 10, '30.00', '60.00', '0.00', 'bueno', '', 1, '', 1, '', b'1'),
(7, 'PRO00004', '3165498496563', 'cinta', 4, 9, '50.00', '62.50', '12.50', 'malo', '', 3, '', 1, '', b'1'),
(10, 'PRO000008', '2342351231222', 'ooooooooooooo', 50, 3, '69.00', '156.00', '87.00', 'bueno', '', 2, '', 1, '', b'1'),
(11, 'PRO000011', '5168798654', 'Lapiz', 50, 10, '60.00', '150.00', '90.00', 'Bueno', '', 2, '', 20, '', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbproveedores`
--

CREATE TABLE IF NOT EXISTS `dbproveedores` (
  `idproveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `cuit` varchar(11) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `observacionces` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`idproveedor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `dbproveedores`
--

INSERT INTO `dbproveedores` (`idproveedor`, `nombre`, `cuit`, `dni`, `direccion`, `telefono`, `celular`, `email`, `observacionces`) VALUES
(1, 'Articulos de Libreria Jose', '33225569871', '22556987', 'Alberdi 235', '4600178', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbusuarios`
--

CREATE TABLE IF NOT EXISTS `dbusuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `refroles` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nombrecompleto` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idusuario`),
  KEY `fk_dbusuarios_tbroles1_idx` (`refroles`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `dbusuarios`
--

INSERT INTO `dbusuarios` (`idusuario`, `usuario`, `password`, `refroles`, `email`, `nombrecompleto`) VALUES
(1, 'marcos', 'marcos', 1, 'msredhotero@msn.com', 'Saupurein Marcos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbventas`
--

CREATE TABLE IF NOT EXISTS `dbventas` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
  `reftipopago` int(11) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `totalventa` decimal(18,2) NOT NULL,
  `refestados` int(11) NOT NULL,
  `usuacrea` varchar(120) NOT NULL,
  `fechacrea` datetime NOT NULL,
  `usuamodi` varchar(120) DEFAULT NULL,
  `fechamodi` datetime DEFAULT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idventa`),
  KEY `fk_Venta_TipoDocumento1_idx` (`reftipopago`),
  KEY `fk_ventas_estados_idx` (`refestados`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `idfoto` int(11) NOT NULL AUTO_INCREMENT,
  `refproyecto` int(11) NOT NULL,
  `refuser` int(11) NOT NULL,
  `imagen` varchar(500) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `principal` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idfoto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `images`
--

INSERT INTO `images` (`idfoto`, `refproyecto`, `refuser`, `imagen`, `type`, `principal`) VALUES
(1, 6, 0, 'ABMMIPIN50P.jpg', 'image/jpeg', NULL),
(9, 10, 0, 'factura.png', 'image/png', NULL),
(12, 7, 0, 'casas12.jpg', 'image/jpeg', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predio_menu`
--

CREATE TABLE IF NOT EXISTS `predio_menu` (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `icono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Orden` smallint(6) DEFAULT NULL,
  `hover` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `permiso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idmenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `predio_menu`
--

INSERT INTO `predio_menu` (`idmenu`, `url`, `icono`, `nombre`, `Orden`, `hover`, `permiso`) VALUES
(1, '../index.php', 'icodashboard', 'Dashboard', 1, NULL, 'Empleado, Administrador, SuperAdmin'),
(3, '../ventas/', 'icoventas', 'Ventas', 3, NULL, 'Empleado, Administrador, SuperAdmin'),
(4, '../clientes/', 'icousuarios', 'Clientes', 4, NULL, 'Empleado, Administrador, SuperAdmin'),
(5, '../productos/', 'icoproductos', 'Productos', 2, NULL, 'Empleado, Administrador, SuperAdmin'),
(6, '../proveedores/', 'icocontratos', 'Proveedores', 6, NULL, 'Empleado, Administrador, SuperAdmin'),
(7, '../reportes/', 'icoreportes', 'Reportes', 11, NULL, 'Empleado, Administrador, SuperAdmin'),
(8, '../logout.php', 'icosalir', 'Salir', 30, NULL, 'Empleado, Administrador, SuperAdmin'),
(9, '../configuraciones/', 'icoconfiguracion', 'Configuraciones', 7, NULL, 'Empleado, Administrador, SuperAdmin'),
(15, '../categorias/', 'icozonas', 'Categorias', 8, NULL, 'Empleado, Administrador, SuperAdmin'),
(16, '../empleados/', 'icojugadores', 'Empleados', 10, NULL, 'Empleado, Administrador, SuperAdmin'),
(17, '../pedidos/', 'icoalquileres', 'Pedidos', 5, NULL, 'Administrador, SuperAdmin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcategorias`
--

CREATE TABLE IF NOT EXISTS `tbcategorias` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  `esegreso` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tbcategorias`
--

INSERT INTO `tbcategorias` (`idcategoria`, `descripcion`, `esegreso`) VALUES
(1, 'Abrochadoras y Perforadoras', b'1'),
(2, 'Agendas', b'1'),
(3, 'Biblioratos y Carpetas', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbestados`
--

CREATE TABLE IF NOT EXISTS `tbestados` (
  `idestado` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(29) NOT NULL,
  `icono` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`idestado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `tbestados`
--

INSERT INTO `tbestados` (`idestado`, `estado`, `icono`) VALUES
(1, 'Cargado', NULL),
(2, 'En Curso', NULL),
(3, 'Finalizado', NULL),
(4, 'Finalizado - Incompleto', NULL),
(5, 'Cancelado', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbroles`
--

CREATE TABLE IF NOT EXISTS `tbroles` (
  `idrol` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `activo` bit(1) NOT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tbroles`
--

INSERT INTO `tbroles` (`idrol`, `descripcion`, `activo`) VALUES
(1, 'Administrador', b'1'),
(2, 'Empleado', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipopago`
--

CREATE TABLE IF NOT EXISTS `tbtipopago` (
  `idtipopago` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(80) NOT NULL,
  PRIMARY KEY (`idtipopago`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tbtipopago`
--

INSERT INTO `tbtipopago` (`idtipopago`, `descripcion`) VALUES
(1, 'Contado'),
(2, 'Debito'),
(3, 'Credito'),
(4, 'Cheques');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dbdetallepedido`
--
ALTER TABLE `dbdetallepedido`
  ADD CONSTRAINT `fk_pedido_detalle` FOREIGN KEY (`refpedidos`) REFERENCES `dbpedidos` (`idpedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_detalle` FOREIGN KEY (`refproductos`) REFERENCES `dbproductos` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbdetalleventas`
--
ALTER TABLE `dbdetalleventas`
  ADD CONSTRAINT `fk_detalle_productos` FOREIGN KEY (`refproductos`) REFERENCES `dbproductos` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_ventas` FOREIGN KEY (`refventas`) REFERENCES `dbventas` (`idventa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbpedidos`
--
ALTER TABLE `dbpedidos`
  ADD CONSTRAINT `fk_pedido_estado` FOREIGN KEY (`refestados`) REFERENCES `tbestados` (`idestado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbproductos`
--
ALTER TABLE `dbproductos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`refcategorias`) REFERENCES `tbcategorias` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbventas`
--
ALTER TABLE `dbventas`
  ADD CONSTRAINT `fk_ventas_estados` FOREIGN KEY (`refestados`) REFERENCES `tbestados` (`idestado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ventas_tipopago` FOREIGN KEY (`reftipopago`) REFERENCES `tbtipopago` (`idtipopago`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
