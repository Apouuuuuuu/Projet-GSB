-- Partie A : Eviter qu'un utilisateur qui à créer le trajet puisse réserver son propre trajet

DELIMITER //

CREATE TRIGGER anti_reservation_creation 
BEFORE INSERT ON reservation 
FOR EACH ROW 
BEGIN 
    --Si il existe un trajet ou le createur du trajet est la personne qui veut réserver
    IF EXISTS (SELECT 1 FROM trajet WHERE id_trajet = NEW.id_trajet AND createur_projet = NEW.pseudo) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Vous ne pouvez pas réserver votre propre trajet.';
    END IF;
END;//

DELIMITER ;

-- Pour créer la propriété date en SQL
ALTER TABLE trajet
ADD COLUMN date_trajet DATE;


--Pour tester le déclencheur : 
INSERT INTO reservation (id_trajet, pseudo) 
VALUES (73, 'Apou'); --





--Partie B : Compter le nombre de fois qu'une voiture à été utilisée 
-- Créer le tableau avec les colones : modele, Année, Nombre de fois utilisés
SELECT modele_voiture_trajet AS modele, YEAR(date_trajet) AS Année, COUNT(*) AS 'Nombre de fois utilisés'
FROM trajet
WHERE modele_voiture_trajet <> '' --Enlève les modeles de voiture vides
GROUP BY modele, Année 
ORDER BY Année; 



-- Partie C

-- Créer la propriété kilometrage
ALTER TABLE trajet
ADD COLUMN kilometrage INT;


-- Mettre à jour le kilométrage d'un trajet
UPDATE trajet
SET kilometrage = 50
WHERE id_trajet = 68;

-- Afficher le kilométrage par mois
SELECT modele_voiture_trajet AS modele, MONTH(date_trajet) AS mois, SUM(kilometrage) AS kilometrage_total
FROM trajet
WHERE MONTH(date_trajet) = 6
AND YEAR(date_trajet) = 2023
GROUP BY modele, mois
ORDER BY modele, mois;