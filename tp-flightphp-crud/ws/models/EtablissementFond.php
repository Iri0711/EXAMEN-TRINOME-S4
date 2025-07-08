<?php
require_once __DIR__ . '/../db.php';

class EtablissementFond{
    public static function getAll(){
        $db = getDB();
        $stmt = $db->query("SELECT * FROM etablissement_fond WHERE id not in (SELECT id_etab_fond FROM fond_validation)");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id){
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM etablissement_fond WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data){
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO etablissement_fond (id_etab,montant,date,libelle) VALUES (?, ?, ?, ?)");
        $stmt->execute([ $data->id_etab, $data->montant, $data->date, $data->libelle]);
        return $db->lastInsertId();
    }

    public static function update($id, $data){
        $db = getDB();
        $stmt = $db->prepare("UPDATE etablissement_fond SET id_etab = ?, montant = ?, date = ?, libelle = ? WHERE id = ?");
        $stmt->execute([$data->id_etab, $data->montant, $data->date, $data->libelle, $id]);
    }

    public static function delete($id){
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM etablissement_fond WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function getAllByEtablissementId($etablissement_id){
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM etablissement_fond WHERE id_etab = ?");
        $stmt->execute([$etablissement_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}