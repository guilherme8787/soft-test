-- Adminer 4.8.1 PostgreSQL 16.3 (Debian 16.3-1.pgdg120+1) dump

\connect "postgres";

DROP TABLE IF EXISTS "product_types";
DROP SEQUENCE IF EXISTS product_types_id_seq;
CREATE SEQUENCE product_types_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."product_types" (
    "id" integer DEFAULT nextval('product_types_id_seq') NOT NULL,
    "name" character varying(100) NOT NULL,
    "percentage" numeric(5,2) NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT "product_types_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "product_types" ("id", "name", "percentage", "created_at") VALUES
(1,	'Eletronicos',	1.20,	'2024-06-13 03:33:21.658989'),
(2,	'Livros',	3.00,	'2024-06-13 03:33:21.66036'),
(3,	'Roupas',	1.00,	'2024-06-13 03:33:21.660998'),
(4,	'Móveis',	5.00,	'2024-06-13 03:33:21.661631');

DROP TABLE IF EXISTS "products";
DROP SEQUENCE IF EXISTS products_id_seq;
CREATE SEQUENCE products_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."products" (
    "id" integer DEFAULT nextval('products_id_seq') NOT NULL,
    "name" character varying(100) NOT NULL,
    "price" numeric(10,2) NOT NULL,
    "product_type" integer,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT "products_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "products" ("id", "name", "price", "product_type", "created_at") VALUES
(1,	'Notebook',	1000.00,	1,	'2024-06-13 03:33:21.662221'),
(2,	'IPhone',	2000.00,	1,	'2024-06-13 03:33:21.663323'),
(3,	'Alexa',	122.00,	1,	'2024-06-13 03:33:21.663969'),
(4,	'Kindle',	213.00,	1,	'2024-06-13 03:33:21.664594'),
(5,	'Anjos e Demonios',	22.00,	2,	'2024-06-13 03:33:21.665214'),
(6,	'Avalie o que realmente importa',	32.00,	2,	'2024-06-13 03:33:21.665867'),
(7,	'Altered Carbon',	12.00,	2,	'2024-06-13 03:33:21.666536'),
(8,	'Blitzscaling',	42.00,	2,	'2024-06-13 03:33:21.667167'),
(9,	'Camiseta',	12.00,	3,	'2024-06-13 03:33:21.667799'),
(10,	'Jeans',	40.00,	3,	'2024-06-13 03:33:21.668395'),
(11,	'Jaqueta',	222.00,	3,	'2024-06-13 03:33:21.668992'),
(12,	'Meias',	3.00,	3,	'2024-06-13 03:33:21.669623'),
(13,	'Cadeira',	200.00,	4,	'2024-06-13 03:33:21.670221'),
(14,	'Mesa',	405.00,	4,	'2024-06-13 03:33:21.670823'),
(15,	'Sofá',	102.00,	4,	'2024-06-13 03:33:21.671432'),
(16,	'Cama',	600.00,	4,	'2024-06-13 03:33:21.672018');

DROP TABLE IF EXISTS "sales";
DROP SEQUENCE IF EXISTS sales_id_seq;
CREATE SEQUENCE sales_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."sales" (
    "id" integer DEFAULT nextval('sales_id_seq') NOT NULL,
    "name" character varying(100) NOT NULL,
    "price" numeric(10,2) NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT "sales_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "sales_products";
DROP SEQUENCE IF EXISTS sales_products_id_seq;
CREATE SEQUENCE sales_products_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."sales_products" (
    "id" integer DEFAULT nextval('sales_products_id_seq') NOT NULL,
    "price" numeric(10,2) NOT NULL,
    "sale_id" integer,
    "product_id" integer,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT "sales_products_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


ALTER TABLE ONLY "public"."products" ADD CONSTRAINT "products_product_type_fkey" FOREIGN KEY (product_type) REFERENCES product_types(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."sales_products" ADD CONSTRAINT "sales_products_product_id_fkey" FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."sales_products" ADD CONSTRAINT "sales_products_sale_id_fkey" FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE NOT DEFERRABLE;

-- 2024-06-13 03:44:24.157837+00
