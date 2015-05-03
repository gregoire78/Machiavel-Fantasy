<?php
//
// Created by Grégoire JONCOUR on 03/05/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//

/**
 * @param $file : le fichier $_FILE['id'] a recupérer
 * @param $taille_max : La taille maximum du fichier à uploader (en octets)
 * @param $extensions : Extension(s) autorisée(s)
 * @param $mimes : Type(s) Mime autorisé(s)
 * @param $type_upload : Le type de ficher à uploader; ex:document, photo,...
 * @return string : erreur(s) si il y en a.
 */
function traitement_fichier($file,$taille_max,$extensions,$mimes,$type_upload)
{
    //initialsation
    $msgErreurFile='';
    $traiterFileOK = true;

    // recupération des données du fichier
    $file_name = basename($file['name']); // nom du fichier (sans extension)
    $file_taille = filesize($file['tmp_name']); // taille du fichier
    $file_extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
    // récupération du type MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
    $file_MimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    //definition des constantes
    define("FILE_EXTENSION_FILE", $extensions);
    define("FILE_MIMETYPE_FILE", $mimes);
    define("FILE_SIZEMAX_FILE", $taille_max);

    // -------------------------------------
    // GESTION DES ERREURS
    // -------------------------------------
    // on vérifie les RESTRICTIONS sur les fichiers
    if (UPLOAD_ERR_OK<>0 && UPLOAD_ERR_FORM_SIZE==2)
    {
        $msgErreurFile 	.= 'Taille de fichier trop important ('.FILE_SIZEMAX_FILE.' octets)<br />';
        $traiterFileOK 	= false;
    }
    // -----------------
    // on vérifie la TAILLE MAXI
    elseif ($file_taille > FILE_SIZEMAX_FILE)
    {
        $msgErreurFile     .= 'Taille de fichier supérieure à la taille maxi autorisée ('.FILE_SIZEMAX_FILE.' octets)<br />';
        $traiterFileOK     = false;
    }
    // -----------------
    // on vérifie l'EXTENSION
    elseif(!in_array($file_extension, explode(',', constant('FILE_EXTENSION_FILE'))))
    {
        $msgErreurFile 	.= 'L\'extension ne correspond pas (Extensions acceptées  : <b>'.constant('FILE_EXTENSION_FILE').'</b>)<br />';
        if(in_array($file_MimeType, explode(',', constant('FILE_MIMETYPE_FILE'))))
        {
            $msgErreurFile 	.= '<b>Attention</b> : Ce fichier est peut-être corrompu !<br />';
            $msgErreurFile 	.= 'L\'extension ne correspond pas au type MIME !<br />';
        }
        $traiterFileOK 	= false;
    }
    // -----------------
    // on vérifie le TYPE MIME
    elseif(!in_array($file_MimeType, explode(',', constant('FILE_MIMETYPE_FILE')))) 
    {
        $msgErreurFile 	.= 'Le type MIME ne correspond pas (Extensions acceptées  : <b>'.constant('FILE_EXTENSION_FILE').'</b>)<br />';
        if(in_array($file_extension, explode(',', constant('FILE_EXTENSION_FILE')))) {
            $msgErreurFile 	.= '<b>Attention</b> : Ce fichier est peut-être corrompu !<br />';
            $msgErreurFile 	.= 'L\'extension ne correspond pas au type MIME !<br />';
        }
        $traiterFileOK 	= false;
    }
    // -----------------
    if ($traiterFileOK===false) 
    {
        $msgErreurFile 	= '<b>Erreur ('.$type_upload.')</b> :<br />'.$msgErreurFile.'Impossible d\'enregistrer le fichier.';
        //return $msgErreurFile;
    }
    // -------------------------------------
    // si pas d'erreur : TRAITEMENT
    // -------------------------------------
    if ($traiterFileOK===true)
    {
        echo "C'est bien un fichier dans les règles";
        //return $traiterFileOK;
    }
    var_dump($file_name,$file_taille,$file_extension,$file_MimeType,$msgErreurFile,$traiterFileOK);
}
