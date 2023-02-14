CREATE TABLE clients(
    id SERIAL NOT NULL PRIMARY KEY,
    name VARCHAR(250) NOT NULL,
    email VARCHAR(250) NOT NULL,
    password VARCHAR(255) NOT NULL,
    active INT NOT NULL DEFAULT(1),
    updated_at TIMESTAMP WITHOUT TIME ZONE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT(NOW())
);

CREATE TABLE permissions (
    id SERIAL NOT NULL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    value INT NOT NULL,
    active INT NOT NULL DEFAULT(1),
    updated_at TIMESTAMP WITHOUT TIME ZONE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT(NOW())
);

CREATE TABLE permissions_client (
    id SERIAL NOT NULL PRIMARY KEY,
    id_permission INT NOT NULL,
    id_client INT NOT NULL,
    updated_at TIMESTAMP WITHOUT TIME ZONE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT(NOW())
);

CREATE TABLE menus (
    id SERIAL NOT NULL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    icon VARCHAR(250) NOT NULL,
    position INT NOT NULL,
    active INT NOT NULL DEFAULT(1),
    updated_at TIMESTAMP WITHOUT TIME ZONE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT(NOW())
);

CREATE TABLE pages (
    id SERIAL NOT NULL PRIMARY KEY,
    path VARCHAR(250) NOT NULL,
    name VARCHAR(250) NOT NULL,
    id_menu INT NOT NULL,
    access_id_permission INT NOT NULL,
    active INT NOT NULL DEFAULT(1),
    updated_at TIMESTAMP WITHOUT TIME ZONE,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT(NOW())
);

--       ##########################       ---
--          CHAVES ESTRANGEIRAS           ---
--       ##########################       ---

ALTER TABLE pages ADD CONSTRAINT fk_id_menu FOREIGN KEY (id_menu)
REFERENCES menus(id) ON DELETE CASCADE;

ALTER TABLE pages ADD CONSTRAINT access_id_permission FOREIGN KEY (access_id_permission)
REFERENCES permissions(id);

ALTER TABLE permissions_client ADD CONSTRAINT fk_id_client FOREIGN KEY (id_client)
REFERENCES clients(id) ON DELETE CASCADE;

ALTER TABLE permissions_client ADD CONSTRAINT fk_id_permission FOREIGN KEY (id_permission)
REFERENCES permissions(id) ON DELETE CASCADE;


--       ##########################       ---
--           INSERTS DO SISTEMA           ---
--       ##########################       ---

-- PASSWORD HASH ADMIN = "123456"
INSERT INTO clients (name, email, password, active, updated_at) VALUES ('admin', 'admin@admin.com', '$2y$10$d/jodesdEdVAmbwgrH.GA.O1FaB47mAwCiI1IGmW.q2xcnc5G1foy', 1, 'now');

INSERT INTO permissions (name,value,active,updated_at) VALUES ('ADMINISTRATOR', 100 , 1, 'now');
INSERT INTO permissions (name,value,active,updated_at) VALUES ('MANAGER', 50 , 1, 'now');
INSERT INTO permissions (name,value,active,updated_at) VALUES ('USER', 10 , 1, 'now');

INSERT INTO permissions_client (id_permission, id_client, updated_at) VALUES (1,1, 'now');

INSERT INTO menus (name, icon, position, active, updated_at) VALUES ('Administrator','fas fa-cogs', 1, 1,'now');

INSERT INTO pages (path, name, id_menu, access_id_permission, active, updated_at) VALUES ('admin/menu','Menus', 1, 1, 1,'now');
INSERT INTO pages (path, name, id_menu, access_id_permission, active, updated_at) VALUES ('admin/page','Pages', 1, 1, 1,'now');
