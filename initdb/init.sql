\c postgres

CREATE TABLE product_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    percentage NUMERIC(5,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    product_type INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_type) REFERENCES product_types(id) ON DELETE CASCADE
);

CREATE TABLE sales (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sales_products (
    id SERIAL PRIMARY KEY,
    price DECIMAL(10, 2) NOT NULL,
    sale_id INT,
    product_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

INSERT INTO product_types (name, percentage) VALUES ('Eletronicos', 1.2);
INSERT INTO product_types (name, percentage) VALUES ('Livros', 3);
INSERT INTO product_types (name, percentage) VALUES ('Roupas', 1);
INSERT INTO product_types (name, percentage) VALUES ('Móveis', 5);

INSERT INTO products (name, product_type, price) VALUES ('Notebook', 1, 1000);
INSERT INTO products (name, product_type, price) VALUES ('IPhone', 1, 2000);
INSERT INTO products (name, product_type, price) VALUES ('Alexa', 1, 122);
INSERT INTO products (name, product_type, price) VALUES ('Kindle', 1, 213);

INSERT INTO products (name, product_type, price) VALUES ('Anjos e Demonios', 2, 22);
INSERT INTO products (name, product_type, price) VALUES ('Avalie o que realmente importa', 2, 32);
INSERT INTO products (name, product_type, price) VALUES ('Altered Carbon', 2, 12);
INSERT INTO products (name, product_type, price) VALUES ('Blitzscaling', 2, 42);

INSERT INTO products (name, product_type, price) VALUES ('Camiseta', 3, 12);
INSERT INTO products (name, product_type, price) VALUES ('Jeans', 3, 40);
INSERT INTO products (name, product_type, price) VALUES ('Jaqueta', 3, 222);
INSERT INTO products (name, product_type, price) VALUES ('Meias', 3, 3);

INSERT INTO products (name, product_type, price) VALUES ('Cadeira', 4, 200);
INSERT INTO products (name, product_type, price) VALUES ('Mesa', 4, 405);
INSERT INTO products (name, product_type, price) VALUES ('Sofá', 4, 102);
INSERT INTO products (name, product_type, price) VALUES ('Cama', 4, 600);
