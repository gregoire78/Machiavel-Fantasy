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
        return $msgErreurFile;
    }
}

/**
 * @param $file : le fichier $_FILE['id'] a recupérer
 * @param $data_width : la largeur du crop recupérée
 * @param $data_height : la hauteur du crop recupérée
 * @param $data_x : le point x du crop
 * @param $data_y : le point y du crop
 * @param $dst_width : la largeur de l'image finale (la hauteur est calculé avec le ratio)
 * @param $dst_path : le chemin du dossier de destination de l'image finale
 * @param $dst_name : le nom de l'image finale
 * @param $fill_color : la couleur de fond de l'image (en hexadecimal)
 * @return string : erreur(s) si il y en a.
 */
function crop_image($file,$data_width,$data_height,$data_x,$data_y,$dst_width,$dst_path,$dst_name,$fill_color)
{
    $msgErreurImageCrop = '';
    $traiterImageCropOK = true;

    if($data_width == 0)
    {
        $msgErreurImageCrop .= "Impossible de redimensionner l'image (hauteur = 0)";
        $traiterImageCropOK = false;
    }
    else
    {
        // calcul du ratio pour savoir s'il s'agit d'un carré(1:1) ou d'un rectangle(3:4)
        $ratio_src = $data_height/$data_width;
        $portrait = 4/3;
        if(round($ratio_src,7) == round($portrait,7)) // 3:4
        {
            $dst_height = round((4/3)*$dst_width);
        }
        else if($ratio_src == 1) // 1:1
        {
            $dst_height = $dst_width;
        }

        $src = $file['tmp_name'];
        // récupération du type MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
        $file_MimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        switch ($file_MimeType) {
            case 'image/gif':
                $src_img = imagecreatefromgif($src);
                break;

            case 'image/jpeg':
                $src_img = imagecreatefromjpeg($src);
                break;

            case 'image/png':
                $src_img = imagecreatefrompng($src);
                break;
        }

        if (!$src_img) {
            $msgErreurImageCrop .= "Lecture de l'image impossible";
            $traiterImageCropOK = false;
        }
        else
        {
            /**** calcul de la taille de l'image (complexe car on peut sortir des limites de l'image) ***********/
            $size = getimagesize($src);
            $size_w = $size[0]; // taille naturel largeur
            $size_h = $size[1]; // taille naturel hauteur

            $src_img_w = $size_w;
            $src_img_h = $size_h;

            $src_x = $data_x;
            $src_y = $data_y;

            if ($src_x <= -$data_width || $src_x > $src_img_w) {
                $src_x = $src_w = $dst_x = $dst_w = 0;
            } else if ($src_x <= 0) {
                $dst_x = -$src_x;
                $src_x = 0;
                $src_w = $dst_w = min($src_img_w, $data_width + $src_x);
            } else if ($src_x <= $src_img_w) {
                $dst_x = 0;
                $src_w = $dst_w = min($data_width, $src_img_w - $src_x);
            }

            if ($src_w <= 0 || $src_y <= -$data_height || $src_y > $src_img_h) {
                $src_y = $src_h = $dst_y = $dst_h = 0;
            } else if ($src_y <= 0) {
                $dst_y = -$src_y;
                $src_y = 0;
                $src_h = $dst_h = min($src_img_h, $data_height + $src_y);
            } else if ($src_y <= $src_img_h) {
                $dst_y = 0;
                $src_h = $dst_h = min($data_height, $src_img_h - $src_y);
            }

            // échelle de destination position et taille
            $ratio = $data_width / $dst_width;
            $dst_x /= $ratio;
            $dst_y /= $ratio;
            $dst_w /= $ratio;
            $dst_h /= $ratio;
            /** ********************************************* **/

            $dst_img = imagecreatetruecolor($dst_width, $dst_height); // on créer la nouvelle image

            /*--convertion hexadecimal vers rgb--*/
            $red = hexdec(substr($fill_color,1,2));
            $green = hexdec(substr($fill_color,3,2));
            $blue = hexdec(substr($fill_color,5,2));

            $color_back = imagecolorallocate($dst_img, $red, $green, $blue); // couleur de fond attribué a l'image
            imagefill($dst_img,0,0, $color_back); // remplissage de l'image par la couleur

            // copy de l'image modifié avec tout les paramètres de source et destinations
            $result = imagecopyresampled($dst_img,$src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
            $file_extension = '.'.strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
            $result1 = move_uploaded_file($file['tmp_name'], $dst_path.'originales/'.$dst_name.$file_extension);

            if ($result || $result1) {
                if (!imagepng($dst_img, $dst_path.$dst_name.'.png')) {
                    $msgErreurImageCrop .= "Impossible d'enregistrer l'image redimensionné";
                    $traiterImageCropOK = false;
                }
            } else {
                $msgErreurImageCrop .= "Impossible de redimensionner l'image";
                $traiterImageCropOK = false;
            }

            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
    }

    // -------------------------------------
    // si erreur : return erreur
    // -------------------------------------
    if ($traiterImageCropOK===false)
    {
        $msgErreurImageCrop = '<b>Erreur (crop image)</b> :<br />'.$msgErreurImageCrop;
        return $msgErreurImageCrop;
    }
}

/**
 * @param $name_file : le text d'entrée a convertir (formzter)
 * @return string : la chine de caractère formatée
 */
function formatNomFichier($name_file)
{
    $name_file = mb_strtolower($name_file, 'UTF-8');
    $name_file = str_replace(
        array(' ', 'à', 'â', 'ä', 'á', 'ã', 'å', 'î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 'ù', 'û', 'ü', 'ú', 'é', 'è', 'ê', 'ë', 'ç', 'ÿ', 'ñ'),
        array('_', 'a', 'a', 'a', 'a', 'a', 'a', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'e', 'e', 'e', 'e', 'c', 'y', 'n'),
        $name_file
    );
    return $name_file;
}