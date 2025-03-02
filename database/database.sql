-- Crea la base de datos 'tienda' si no existe.
CREATE DATABASE IF NOT EXISTS tienda;

-- Selecciona la base de datos 'tienda' para trabajar con ella.
USE tienda;

-- Crea la tabla 'usuarios' para almacenar la información de los usuarios.
CREATE TABLE usuarios(
    id INT(255) AUTO_INCREMENT NOT NULL, -- Identificador único del usuario (clave primaria).
    nombre VARCHAR(100) NOT NULL, -- Nombre del usuario.
    apellidos VARCHAR(255) NOT NULL, -- Apellidos del usuario.
    email VARCHAR(255) NOT NULL, -- Correo electrónico del usuario (único).
    password VARCHAR(255) NOT NULL, -- Contraseña del usuario.
    rol VARCHAR(20) NOT NULL, -- Rol del usuario (por ejemplo, 'admin' o 'usuario').
    imagen VARCHAR(255) NULL, -- Ruta de la imagen de perfil del usuario (opcional).

    -- Define la clave primaria de la tabla.
    CONSTRAINT pk_usuarios PRIMARY KEY(id),
    -- Define una restricción de unicidad para el campo email.
    CONSTRAINT uq_email UNIQUE(email)
) ENGINE=InnoDb; -- Usa el motor de almacenamiento InnoDB.

-- Inserta un usuario administrador por defecto.
INSERT INTO usuarios VALUES (NULL, 'Admin', 'Admin', 'admin@admin.com', 'contraseña', 'admin', NULL);

-- Crea la tabla 'categorias' para almacenar las categorías de productos.
CREATE TABLE categorias(
    id INT(255) AUTO_INCREMENT NOT NULL, -- Identificador único de la categoría (clave primaria).
    nombre VARCHAR(100) NOT NULL, -- Nombre de la categoría.

    -- Define la clave primaria de la tabla.
    CONSTRAINT pk_categorias PRIMARY KEY(id)
) ENGINE=InnoDb; -- Usa el motor de almacenamiento InnoDB.

-- Crea la tabla 'productos' para almacenar la información de los productos.
CREATE TABLE productos(
    id INT(255) AUTO_INCREMENT NOT NULL, -- Identificador único del producto (clave primaria).
    categoria_id INT(255) NOT NULL, -- ID de la categoría a la que pertenece el producto.
    nombre VARCHAR(100) NOT NULL, -- Nombre del producto.
    descripcion TEXT, -- Descripción del producto.
    precio FLOAT(100,2) NOT NULL, -- Precio del producto.
    stock INT(255) NOT NULL, -- Cantidad de unidades en stock.
    oferta VARCHAR(2) NOT NULL, -- Indica si el producto está en oferta (por ejemplo, 'si' o 'no').
    fecha DATE NOT NULL, -- Fecha de creación o registro del producto.
    imagen VARCHAR(255), -- Ruta de la imagen del producto.

    -- Define la clave primaria de la tabla.
    CONSTRAINT pk_productos PRIMARY KEY(id),
    -- Define una clave foránea que relaciona el producto con su categoría.
    CONSTRAINT fk_producto_categoria FOREIGN KEY(categoria_id) REFERENCES categorias(id)
) ENGINE=InnoDb; -- Usa el motor de almacenamiento InnoDB.

-- Crea la tabla 'pedidos' para almacenar la información de los pedidos realizados por los usuarios.
CREATE TABLE pedidos(
    id INT(255) AUTO_INCREMENT NOT NULL, -- Identificador único del pedido (clave primaria).
    usuario_id INT(255) NOT NULL, -- ID del usuario que realizó el pedido.
    provincia VARCHAR(100) NOT NULL, -- Provincia de entrega del pedido.
    localidad VARCHAR(100) NOT NULL, -- Localidad de entrega del pedido.
    direccion VARCHAR(255) NOT NULL, -- Dirección de entrega del pedido.
    coste FLOAT(200,2) NOT NULL, -- Coste total del pedido.
    estado VARCHAR(100) NOT NULL, -- Estado actual del pedido (por ejemplo, 'pendiente', 'enviado').
    fecha DATE, -- Fecha en que se realizó el pedido.
    hora TIME, -- Hora en que se realizó el pedido.

    -- Define la clave primaria de la tabla.
    CONSTRAINT pk_pedidos PRIMARY KEY(id),
    -- Define una clave foránea que relaciona el pedido con el usuario que lo realizó.
    CONSTRAINT fk_pedido_usuario FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDb; -- Usa el motor de almacenamiento InnoDB.

-- Crea la tabla 'lineas_pedidos' para almacenar los productos asociados a cada pedido.
CREATE TABLE lineas_pedidos(
    id INT(255) AUTO_INCREMENT NOT NULL, -- Identificador único de la línea de pedido (clave primaria).
    pedido_id INT(255) NOT NULL, -- ID del pedido al que pertenece la línea.
    producto_id INT(255) NOT NULL, -- ID del producto asociado a la línea.
    unidades INT(255) NOT NULL, -- Cantidad de unidades del producto en el pedido.

    -- Define la clave primaria de la tabla.
    CONSTRAINT pk_lineas_pedidos PRIMARY KEY(id),
    -- Define una clave foránea que relaciona la línea de pedido con el pedido.
    CONSTRAINT fk_linea_pedido FOREIGN KEY(pedido_id) REFERENCES pedidos(id),
    -- Define una clave foránea que relaciona la línea de pedido con el producto.
    CONSTRAINT fk_linea_producto FOREIGN KEY(producto_id) REFERENCES productos(id)
) ENGINE=InnoDb; -- Usa el motor de almacenamiento InnoDB.