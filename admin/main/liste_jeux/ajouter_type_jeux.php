<?php
//
// Created by Grégoire JONCOUR on 03/06/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//

include_once('../functions/functions_file.php');
include_once('../functions/functions_jeu.php');

if(isset($_POST['valider']))
{
    $libelleTypeJeu=htmlentities(trim($_POST['libelleTypeJeu']));
    $descriptionTypeJeu=htmlentities(trim($_POST['descriptionTypeJeu']));
    $couleurTypeJeu=htmlentities(trim($_POST['couleurTypeJeu']));

    /********************** Vérifications pour le libellé de la categorie ************************/
    $string = 50;
    if(empty($libelleTypeJeu))
    {
        $errors[1] = "Veuillez mettre un nom à la catégorie";
    }
    else if(strlen(html_entity_decode($libelleTypeJeu)) > $string)
    {
        $errors[1] = "Le titre ne doit pas dépasser <b>".$string." caractères</b>";
    }
    //vérifions s'il ya des caracteres speciaux
    else if(preg_match('/[^0-9A-Za-zàâçéèêëîïôûùüÿñæœ\- \']/',html_entity_decode($libelleTypeJeu)))
    {
        $errors[1] = "Veuillez n'insérer que des lettres ou chiffres dans le nom de la catégorie.";
    }
    //vérifions si la catégorie éxiste
    else if(verif_existe('id_type_jeu','type_jeu','libelle_type_jeu',html_entity_decode($libelleTypeJeu))!=0)
    {
        $errors[1] = "Cette catégorie éxiste déjà";
    }
    /********************** Vérifications pour la description de la categorie ************************/
    $string = 50;
    if(empty($descriptionTypeJeu))
    {
        $errors[2] = "Veuillez mettre une description à la catégorie";
    }
    else if(strlen(html_entity_decode($descriptionTypeJeu)) > 150)
    {
        $errors[2] = "La description ne doit pas dépasser <b>150 caractères</b>";
    }
    /********************** Vérifications pour la couleur de la categorie ************************/
    $string = 50;
    if(empty($couleurTypeJeu))
    {
        $errors[3] = "Veuillez mettre une couleur à la catégorie";
    }
    //vérifions s'il ya des caracteres speciaux
    if(!preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',html_entity_decode($couleurTypeJeu)))
    {
        $errors[3] = "Veuillez mettre une couleur au format hexadecimal";
    }

    /**************************** Si il n'y a aucune erreur(s) *************************/
    if(empty($errors))
    {
        var_dump($_POST);
        $result = create_type_jeu($libelleTypeJeu,$descriptionTypeJeu,$couleurTypeJeu);
        if($result==true)
        {
            header('Location:index.php?i=liste_jeux&j=liste_type_jeux');
        }
        else
        {
            echo "erreur lors de la création du type jeu";
        }
    }
    else
    {
        var_dump($errors);
    }
}

include_once("ajouter_type_jeux.html");
