CREATE DATABASE WS_API_M07;

use WS_API_M07;

DROP TABLE IF EXISTS _sap_users;

create table _sap_users
(
    user_id   nvarchar(255) not null
        primary key,
    nickname  nvarchar(255),
    user_name nvarchar(255) not null,
    surname   nvarchar(255),
    pwd       varbinary(64) not null,
    phone     nvarchar(255),
    _mndt     int              default 0,
    _created  datetime         default getdate(),
    _updated  datetime,
    _deleted  datetime,
    _row_guid uniqueidentifier default newid()
)
go

DROP TABLE IF EXISTS _sap_conn;


 create table _sap_conn
(
    conn_guid uniqueidentifier default newid() not null,
    user_id   nvarchar(255) primary key constraint sap_conn_sap_users_user_id_fk references _sap_users,
    cTime     datetime,
    last_batch datetime,
    _mndt     int              default 0,
    _created  datetime         default getdate(),
    _updated  datetime,
    _deleted  datetime,
    _row_guid uniqueidentifier default newid()
)
go

DROP TABLE _sap_products

-- TABLAS CARRITOS
CREATE TABLE _sap_products(
    id INT IDENTITY (1,1) PRIMARY KEY,
    nombre NVARCHAR(255),
    price NVARCHAR(30),
    _created datetime default getdate(),
    _updated datetime,

);

-- SELECT * FROM _sap_products

-- Products
INSERT INTO _sap_products (nombre, price)
VALUES ('Book', '19.99'),
       ('Shoes', '49.99'),
       ('PC', '999.99'),
       ('Tablet', '299.99'),
       ('Mobile', '599.99');


DROP TABLE _sap_cart

CREATE TABLE _sap_cart (
    id INT IDENTITY(1,1) PRIMARY KEY,
    product_id INT,
    user_id NVARCHAR(255),
    quantity INT,
    _created datetime default getdate(),
    _updated datetime,
    FOREIGN KEY (product_id) REFERENCES _sap_products(id),
    FOREIGN KEY (user_id) REFERENCES _sap_users(user_id)
);



