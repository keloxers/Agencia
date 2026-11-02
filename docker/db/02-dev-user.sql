-- Usuario solo para desarrollo local (admin@agencia.local / agencia-dev).
INSERT INTO users (username, email, password, created_at, updated_at)
VALUES ('admin', 'admin@agencia.local', '$2y$10$J7Cn9OwvH3R2uASG3/caquH9p7Oe.hf1qKCxGpJV90K1r019rL6vu', NOW(), NOW());
