CREATE VIEW pret_info AS
SELECT 
    pc.id AS id_pret_client,
    pc.id_client,
    pc.id_etab,
    pc.montant,
    pc.date,
    pc.duree As dur,
    pt.id AS id_pret_type,
    pt.libelle,
    pt.taux,
    pt.duree
FROM 
    pret_client pc 
LEFT JOIN 
    pret_type pt ON pc.id_pret_type = pt.id;