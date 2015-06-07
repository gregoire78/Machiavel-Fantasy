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

function fctredimimage($W_max, $H_max, $rep_Dst, $img_Dst, $rep_Src, $img_Src) {
    $condition = 0;
    // Si certains paramètres ont pour valeur '' :
    if ($rep_Dst=='') { $rep_Dst = $rep_Src; } // (même répertoire)
    if ($img_Dst=='') { $img_Dst = $img_Src; } // (même nom)
    // ---------------------
    // si le fichier existe dans le répertoire, on continue...
    if (file_exists($rep_Src.$img_Src) && ($W_max!=0 || $H_max!=0)) {
        // ----------------------
        // extensions acceptées :
        $extension_Allowed = 'jpg,jpeg,png';	// (sans espaces)
        // extension fichier Source
        $extension_Src = strtolower(pathinfo($img_Src,PATHINFO_EXTENSION));
        // ----------------------
        // extension OK ? on continue ...
        if(in_array($extension_Src, explode(',', $extension_Allowed))) {
            // ------------------------
            // récupération des dimensions de l'image Src
            $img_size = getimagesize($rep_Src.$img_Src);
            $W_Src = $img_size[0]; // largeur
            $H_Src = $img_size[1]; // hauteur
            // ------------------------
            // condition de redimensionnement et dimensions de l'image finale
            // ------------------------
            // A- LARGEUR ET HAUTEUR maxi fixes
            if ($W_max!=0 && $H_max!=0) {
                $ratiox = $W_Src / $W_max; // ratio en largeur
                $ratioy = $H_Src / $H_max; // ratio en hauteur
                $ratio = max($ratiox,$ratioy); // le plus grand
                $W = $W_Src/$ratio;
                $H = $H_Src/$ratio;
                $condition = ($W_Src>$W) || ($W_Src>$H); // 1 si vrai (true)
            }
            // ------------------------
            // B- HAUTEUR maxi fixe
            if ($W_max==0 && $H_max!=0) {
                $H = $H_max;
                $W = $H * ($W_Src / $H_Src);
                $condition = ($H_Src > $H_max); // 1 si vrai (true)
            }
            // ------------------------
            // C- LARGEUR maxi fixe
            if ($W_max!=0 && $H_max==0) {
                $W = $W_max;
                $H = $W * ($H_Src / $W_Src);
                $condition = ($W_Src > $W_max); // 1 si vrai (true)
            }
            // ---------------------------------------------
            // REDIMENSIONNEMENT si la condition est vraie
            // ---------------------------------------------
            // - Si l'image Source est plus petite que les dimensions indiquées :
            // Par defaut : PAS de redimensionnement.
            // - Mais on peut "forcer" le redimensionnement en ajoutant ici :
            // $condition = 1; (risque de perte de qualité)
            if ($condition==1) {
                // ---------------------
                // creation de la ressource-image "Src" en fonction de l extension
                switch($extension_Src) {
                    case 'jpg':
                    case 'jpeg':
                        $Ress_Src = imagecreatefromjpeg($rep_Src.$img_Src);
                        break;
                    case 'png':
                        $Ress_Src = imagecreatefrompng($rep_Src.$img_Src);
                        break;
                }
                // ---------------------
                // creation d une ressource-image "Dst" aux dimensions finales
                // fond noir (par defaut)
                switch($extension_Src) {
                    case 'jpg':
                    case 'jpeg':
                        $Ress_Dst = imagecreatetruecolor($W,$H);
                        break;
                    case 'png':
                        $Ress_Dst = imagecreatetruecolor($W,$H);
                        // fond transparent (pour les png avec transparence)
                        imagesavealpha($Ress_Dst, true);
                        $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
                        imagefill($Ress_Dst, 0, 0, $trans_color);
                        break;
                }
                // ---------------------
                // REDIMENSIONNEMENT (copie, redimensionne, re-echantillonne)
                imagecopyresampled($Ress_Dst, $Ress_Src, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src);
                // ---------------------
                // ENREGISTREMENT dans le repertoire (avec la fonction appropriee)
                switch ($extension_Src) {
                    case 'jpg':
                    case 'jpeg':
                        imagejpeg ($Ress_Dst, $rep_Dst.$img_Dst);
                        break;
                    case 'png':
                        imagepng ($Ress_Dst, $rep_Dst.$img_Dst);
                        break;
                }
                // ------------------------
                // liberation des ressources-image
                imagedestroy ($Ress_Src);
                imagedestroy ($Ress_Dst);
            }
            // ------------------------
        }
    }
    // ---------------------------------------------------
    // retourne : true si le redimensionnement et l'enregistrement ont bien eu lieu, sinon false
    if ($condition==1 && file_exists($rep_Dst.$img_Dst)) { return true; }
    else { return false; }
    // ---------------------------------------------------
};

function fctcropimage($W_fin, $H_fin, $rep_Dst, $img_Dst, $rep_Src, $img_Src) {
    // ---------------------
    $condition = 0;
    // Si certains paramètres ont pour valeur '' :
    if ($rep_Dst=='') { $rep_Dst = $rep_Src; } // (même répertoire)
    if ($img_Dst=='') { $img_Dst = $img_Src; } // (même nom)
    // ---------------------
    // si le fichier existe dans le répertoire, on continue...
    if (file_exists($rep_Src.$img_Src)) {
        // ----------------------
        // extensions acceptées :
        $extension_Allowed = 'jpg,jpeg,png';	// (sans espaces)
        // extension fichier Source
        $extension_Src = strtolower(pathinfo($img_Src,PATHINFO_EXTENSION));
        // ----------------------
        // extension OK ? on continue ...
        if(in_array($extension_Src, explode(',', $extension_Allowed))) {
            // ------------------------
            // récupération des dimensions de l'image Source
            $img_size = getimagesize($rep_Src.$img_Src);
            $W_Src = $img_size[0]; // largeur
            $H_Src = $img_size[1]; // hauteur
            // ------------------------------------------------
            // condition de crop et dimensions de l'image finale
            // ------------------------------------------------
            // A- crop aux dimensions indiquées
            if ($W_fin!=0 && $H_fin!=0) {
                $W = $W_fin;
                $H = $H_fin;
            }      // ------------------------
            // B- crop en HAUTEUR (meme largeur que la source)
            if ($W_fin==0 && $H_fin!=0) {
                $H = $H_fin;
                $W = $W_Src;
            }
            // ------------------------
            // C- crop en LARGEUR (meme hauteur que la source)
            if ($W_fin!=0 && $H_fin==0) {
                $W = $W_fin;
                $H = $H_Src;
            }
            // D- crop "carre" a la plus petite dimension de l'image source
            if ($W_fin==0 && $H_fin==0) {
                if ($W_Src >= $H_Src) {
                    $W = $H_Src;
                    $H = $H_Src;
                } else {
                    $W = $W_Src;
                    $H = $W_Src;
                }
            }
            // ------------------------
            // creation de la ressource-image "Src" en fonction de l extension
            switch($extension_Src) {
                case 'jpg':
                case 'jpeg':
                    $Ress_Src = imagecreatefromjpeg($rep_Src.$img_Src);
                    break;
                case 'png':
                    $Ress_Src = imagecreatefrompng($rep_Src.$img_Src);
                    break;
            }
            // ---------------------
            // creation d une ressource-image "Dst" aux dimensions finales
            // fond noir (par defaut)
            switch($extension_Src) {
                case 'jpg':
                case 'jpeg':
                    $Ress_Dst = imagecreatetruecolor($W,$H);
                    // fond blanc
                    $blanc = imagecolorallocate ($Ress_Dst, 255, 255, 255);
                    imagefill ($Ress_Dst, 0, 0, $blanc);
                    break;
                case 'png':
                    $Ress_Dst = imagecreatetruecolor($W,$H);
                    // fond transparent (pour les png avec transparence)
                    imagesavealpha($Ress_Dst, true);
                    $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
                    imagefill($Ress_Dst, 0, 0, $trans_color);
                    break;
            }
            // ------------------------
            // CENTRAGE du crop
            // coordonnees du point d origine Scr : $X_Src, $Y_Src
            // coordonnees du point d origine Dst : $X_Dst, $Y_Dst
            // dimensions de la portion copiee : $W_copy, $H_copy
            // ------------------------
            // CENTRAGE en largeur
            if ($W_fin==0) {
                if ($H_fin==0 && $W_Src < $H_Src) {
                    $X_Src = 0;
                    $X_Dst = 0;
                    $W_copy = $W_Src;
                } else {
                    $X_Src = 0;
                    $X_Dst = ($W - $W_Src) /2;
                    $W_copy = $W_Src;
                }
            } else {
                if ($W_Src > $W) {
                    $X_Src = ($W_Src - $W) /2;
                    $X_Dst = 0;
                    $W_copy = $W;
                } else {
                    $X_Src = 0;
                    $X_Dst = ($W - $W_Src) /2;
                    $W_copy = $W_Src;
                }
            }
            // ------------------------
            // CENTRAGE en hauteur
            if ($H_fin==0) {
                if ($W_fin==0 && $H_Src < $W_Src) {
                    $Y_Src = 0;
                    $Y_Dst = 0;
                    $H_copy = $H_Src;
                } else {
                    $Y_Src = 0;
                    $Y_Dst = ($H - $H_Src) /2;
                    $H_copy = $H_Src;
                }
            } else {
                if ($H_Src > $H) {
                    $Y_Src = ($H_Src - $H) /2;
                    $Y_Dst = 0;
                    $H_copy = $H;
                } else {
                    $Y_Src = 0;
                    $Y_Dst = ($H - $H_Src) /2;
                    $H_copy = $H_Src;
                }
            }
            // ------------------------------------------------
            // CROP par copie de la portion d image selectionnee
            imagecopyresampled($Ress_Dst,$Ress_Src,$X_Dst,$Y_Dst,$X_Src,$Y_Src,$W_copy,$H_copy,$W_copy,$H_copy);
            // ------------------------------------------------
            // ENREGISTREMENT dans le repertoire (avec la fonction appropriee)
            switch ($extension_Src) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg ($Ress_Dst, $rep_Dst.$img_Dst);
                    break;
                case 'png':
                    imagepng ($Ress_Dst, $rep_Dst.$img_Dst);
                    break;
            }
            // ---------------------
            // liberation des ressources-image
            imagedestroy ($Ress_Src);
            imagedestroy ($Ress_Dst);
            // ---------------------
            $condition = 1;
        }
    }
    // ---------------------------------------------------
    // retourne : true si le redimensionnement et l'enregistrement ont bien eu lieu, sinon false
    if ($condition==1 && file_exists($rep_Dst.$img_Dst)) { return true; }
    else { return false; }
    // ---------------------------------------------------
};
?>