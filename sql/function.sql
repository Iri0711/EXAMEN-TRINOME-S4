CREATE VIEW pret_info AS
SELECT * FROM pret_client pc LEFT JOIN pret_type pt ON pc.id_pret_type = pt.id;

DELIMITER //

CREATE PROCEDURE interetParMois(IN debut DATE)
BEGIN
    -- Create a temporary table to store interest calculations
    CREATE TEMPORARY TABLE IF NOT EXISTS interet(
        id INTEGER,
        montant DECIMAL(11,2)
    ) ENGINE = MEMORY;

    -- Clear any existing data in the temporary table
    TRUNCATE TABLE interet;

    -- Calculate monthly interest for each loan and insert into temp table
    INSERT INTO interet
    SELECT 
        id_pret_client,
        (((montant * taux) * dur) / duree) / 30 
    FROM pret_info WHERE date BETWEEN debut AND date+duree;

    -- Return the calculated interest values
    SELECT * FROM interet;

    -- Clean up by dropping the temporary table
    DROP TEMPORARY TABLE IF EXISTS interet;
END //


DELIMITER ;

DROP PROCEDURE calculInteretMensuel;

DELIMITER //

CREATE PROCEDURE calculInteretMensuel(
    IN date_debut DATE, 
    IN date_fin DATE
)
BEGIN
    -- Table temporaire pour stocker les résultats
    CREATE TEMPORARY TABLE IF NOT EXISTS interets_mensuels (
        id_pret INT,
        mois DATE,
        interet_mensuel DECIMAL(11,2)
    ) ENGINE = MEMORY;

    TRUNCATE TABLE interets_mensuels;

    -- Insertion de tous les mois dans la période pour chaque prêt
    INSERT INTO interets_mensuels
    SELECT 
        p.id_pret_client,
        m.mois,
        CASE 
            WHEN m.mois < p.date THEN 0 -- Mois avant le début du prêt
            WHEN m.mois >= DATE_ADD(p.date, INTERVAL p.dur DAY) THEN 0 -- Mois après la fin du prêt
            ELSE ((p.montant * (p.taux/100)) * p.dur / (p.duree * 30)) -- Calcul normal
        END AS interet_mensuel
    FROM 
        (WITH RECURSIVE dates_mois AS (
            SELECT DATE_FORMAT(date_debut, '%Y-%m-01') AS mois
            UNION ALL
            SELECT DATE_ADD(mois, INTERVAL 1 MONTH)
            FROM dates_mois
            WHERE DATE_ADD(mois, INTERVAL 1 MONTH) <= date_fin
        )
        SELECT * FROM dates_mois) m
    CROSS JOIN 
        pret_info p
    WHERE 
        m.mois BETWEEN DATE_FORMAT(date_debut, '%Y-%m-01') 
                AND DATE_FORMAT(date_fin, '%Y-%m-01');

    -- Résultat final
    SELECT 
        DATE_FORMAT(mois, '%Y-%m') AS 'Mois',
        ROUND(SUM(interet_mensuel), 2) AS 'Interet'
    FROM 
        interets_mensuels
    GROUP BY 
        mois;

    DROP TEMPORARY TABLE IF EXISTS interets_mensuels;
END //

DELIMITER ;

 CALL calculInteretMensuel('2023-01-01', '2023-12-31');