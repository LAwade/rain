CREATE TABLE categories(
    id SERIAL NOT NULL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description VARCHAR(150) NOT NULL,
    active INT NOT NULL DEFAULT(1),
    updated_at TIMESTAMP WITHOUT TIME ZONE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT(NOW())
);

CREATE TABLE products(
    id SERIAL NOT NULL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price FLOAT NOT NULL,
    description VARCHAR(150) NOT NULL,
    unity INT NOT NULL,
    split_payment INT,
    tax INT NOT NULL,
    test_period INT DEFAULT(0),
    id_category INT NOT NULL,
    active INT NOT NULL DEFAULT(1),
    updated_at TIMESTAMP WITHOUT TIME ZONE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT(NOW())
);

ALTER TABLE products ADD CONSTRAINT fk_id_category FOREIGN KEY (id_category)
REFERENCES categories(id) ON DELETE CASCADE;

INSERT INTO status (name) VALUES ('ATIVA');
INSERT INTO status (name) VALUES ('CANCELADO');
INSERT INTO status (name) VALUES ('PENDENTE');
INSERT INTO status (name) VALUES ('PERIODO DE TESTE');
INSERT INTO status (name) VALUES ('ATRASADA');
INSERT INTO status (name) VALUES ('FINALIZADO');
INSERT INTO status (name) VALUES ('PAGA');

CREATE TABLE status(
    id SERIAL NOT NULL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    updated_at TIMESTAMP WITHOUT TIME ZONE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT(NOW())
);

CREATE TABLE orders(
    id SERIAL NOT NULL PRIMARY KEY,
    id_client INT NOT NULL,
    id_status INT NOT NULL,
    active INT NOT NULL DEFAULT(1),
    updated_at TIMESTAMP WITHOUT TIME ZONE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT(NOW())
);

ALTER TABLE orders ADD CONSTRAINT fk_id_client FOREIGN KEY (id_client)
REFERENCES clients(id) ON DELETE CASCADE;

ALTER TABLE orders ADD CONSTRAINT fk_id_status FOREIGN KEY (id_status)
REFERENCES status(id) ON DELETE CASCADE;

CREATE TABLE itens(
    id SERIAL NOT NULL PRIMARY KEY,
    id_order INT NOT NULL,
    id_product INT NOT NULL,
    quantity INT NOT NULL,
    active INT NOT NULL DEFAULT(1),
    updated_at TIMESTAMP WITHOUT TIME ZONE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT(NOW())
);

ALTER TABLE itens ADD CONSTRAINT fk_id_order FOREIGN KEY (id_order)
REFERENCES orders(id) ON DELETE CASCADE;

ALTER TABLE itens ADD CONSTRAINT fk_id_product FOREIGN KEY (id_product)
REFERENCES products(id) ON DELETE CASCADE;

CREATE TABLE invoices(
    id SERIAL NOT NULL PRIMARY KEY,
    id_order INT NOT NULL,
    payment_date TIMESTAMP WITHOUT TIME ZONE,
    due_date TIMESTAMP WITHOUT TIME ZONE,
    amount FLOAT NOT NULL,
    id_status INT NOT NULL,
    active INT NOT NULL DEFAULT(1),
    updated_at TIMESTAMP WITHOUT TIME ZONE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT(NOW())
);

ALTER TABLE invoices ADD CONSTRAINT fk_id_order FOREIGN KEY (id_order)
REFERENCES orders(id);

ALTER TABLE invoices ADD CONSTRAINT fk_id_status FOREIGN KEY (id_status)
REFERENCES status(id);

CREATE TABLE banks(
    id SERIAL NOT NULL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description VARCHAR(150),
    url VARCHAR(255),
    url_notification VARCHAR(255),
    key VARCHAR(255),
    extra_code VARCHAR(255),
    active INT NOT NULL DEFAULT(1),
    updated_at TIMESTAMP WITHOUT TIME ZONE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT(NOW())
);

CREATE TABLE payments(
    id SERIAL NOT NULL PRIMARY KEY,
    id_invoice INT NOT NULL,
    id_status INT NOT NULL,
    received FLOAT NOT NULL,
    amount FLOAT NOT NULL,
    id_bank INT NOT NULL,
    code_reference VARCHAR(255),
    external_id VARCHAR(255),
    logs TEXT,
    updated_at TIMESTAMP WITHOUT TIME ZONE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT(NOW())
);

ALTER TABLE payments ADD CONSTRAINT fk_id_invoice FOREIGN KEY (id_invoice)
REFERENCES orders(id);

ALTER TABLE payments ADD CONSTRAINT fk_id_bank FOREIGN KEY (id_bank)
REFERENCES banks(id);

ALTER TABLE payments ADD CONSTRAINT fk_id_status FOREIGN KEY (id_status)
REFERENCES status(id);