CREATE TABLE products (
	id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	code varchar(255) NOT NULL,
	name varchar(255) NOT NULL,
	price float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE client_types (
	id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	type_name varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE clients (
	id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL,
	client_type_id int(11) UNSIGNED DEFAULT NULL,
	product_id int(11) UNSIGNED DEFAULT NULL,
	product_quantity int(11) DEFAULT NULL,
	FOREIGN KEY (client_type_id) REFERENCES client_types (id) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO client_types (id, type_name) VALUES (1, "Авансово заплатил"), (2, "Предплатил с акредитив"), (3, "На консигнация (не е заплатил)");


CREATE VIEW clients_view AS
SELECT
	clients.id AS "client_id",
	clients.name AS "client_name",
	client_types.id AS "client_type_id",
	client_types.type_name AS "client_type_name",
	products.id AS "product_id",
	products.code AS "product_code",
	products.name AS "product_name",
	products.price AS "product_price",
	clients.product_quantity AS "product_quantity",
	products.price * clients.product_quantity AS "total_price"
FROM clients
INNER JOIN client_types ON clients.client_type_id = client_types.id
INNER JOIN products ON clients.product_id = products.id;


CREATE VIEW ordered_products_view AS
SELECT
	product_id AS "product_id",
	product_code AS "product_code",
	product_name AS "product_name",
	client_type_id AS "pay_type_id",
	client_type_name AS "pay_type_name",
	SUM(product_quantity) AS "product_quantity_total",
	SUM(total_price) AS "product_price_total"
FROM clients_view
GROUP BY product_id, client_type_id;