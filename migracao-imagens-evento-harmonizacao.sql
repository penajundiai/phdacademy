ALTER TABLE eventos ADD COLUMN imagem_banner VARCHAR(255) NULL AFTER imagem;

UPDATE eventos
SET imagem = 'harmonizacao-glutea-card-9x16.png',
    imagem_banner = 'harmonizacao-glutea-banner-16x9.png'
WHERE slug = 'workshop-phd-harmonizacao-glutea-com-pratica-3d';
