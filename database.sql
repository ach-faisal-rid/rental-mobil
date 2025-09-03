CREATE DATABASE rental_mobil;
USE rental_mobil;

-- Tabel role
CREATE TABLE role (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL
);

INSERT INTO role (name) VALUES ('admin'), ('user');

-- Tabel users
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  name VARCHAR(100) NOT NULL,
  role_id INT,
  FOREIGN KEY (role_id) REFERENCES role(id)
);

-- Tabel mobil
CREATE TABLE mobil (
  id INT AUTO_INCREMENT PRIMARY KEY,
  merk VARCHAR(100) NOT NULL,
  name VARCHAR(100) NOT NULL,
  status ENUM('tersedia','disewa') DEFAULT 'tersedia',
  harga_sewa DECIMAL(12,2) NOT NULL
);

-- Tabel pelanggan
CREATE TABLE pelanggan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  alamat TEXT,
  nomor VARCHAR(20)
);

-- Tabel transaksi
CREATE TABLE transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_pelanggan INT,
  id_mobil INT,
  tgl_sewa DATE,
  tgl_kembali DATE,
  total_bayar DECIMAL(12,2),
  FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id),
  FOREIGN KEY (id_mobil) REFERENCES mobil(id)
);

INSERT INTO users (email, password, name, role_id) VALUES 
('admin@mail.com', MD5('admin123'), 'Admin', 1),
('user@mail.com', MD5('user123'), 'User', 2);

DROP TABLE IF EXISTS pelanggan;

CREATE TABLE pelanggan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNIQUE,
  name VARCHAR(100) NOT NULL,
  alamat TEXT,
  nomor VARCHAR(20),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

ALTER TABLE transaksi 
  ADD CONSTRAINT fk_transaksi_pelanggan 
  FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id) ON DELETE CASCADE;