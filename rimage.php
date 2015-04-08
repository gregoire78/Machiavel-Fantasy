<?php


$redim = crop_image(0,0,'images/avatars/','la1.jpg','images/avatars/','498.jpeg');
$redim = redim_image(120,0,'','','images/avatars/','la1.jpg');
if ($redim==true) { echo 'picto carré créé !'; }

//La fonction croppant l'image
function crop_image($W_fin, $H_fin, $rep_Dst, $img_Dst, $rep_Src, $img_Src) {

    $condition = 0;

    // Si certains paramètres ont pour valeur '' on met même répertoire ou même nom
    if ($rep_Dst=='')
    {
        $rep_Dst = $rep_Src;
    }
    if ($img_Dst=='')
    {
        $img_Dst = $img_Src;
    }


    // si le fichier existe dans le répertoire
    if (file_exists($rep_Src.$img_Src))
    {
        $extension_Allowed = 'jpg,jpeg,png';	// extensions acceptées

        $extension_Src = strtolower(pathinfo($img_Src,PATHINFO_EXTENSION)); // extension fichier Source

        if(in_array($extension_Src, explode(',', $extension_Allowed))) // si extension OK
        {
            $img_size = getimagesize($rep_Src.$img_Src); // récupération des dimensions de l'image Source
            $W_Src = $img_size[0]; // largeur
            $H_Src = $img_size[1]; // hauteur

            //---------------------------
            // condition de crop et dimensions de l'image finale(repris)
            //---------------------------

            // A- crop aux dimensions indiquées
            if ($W_fin!=0 && $H_fin!=0)
            {
                $W = $W_fin;
                $H = $H_fin;
            }

            // B- crop en HAUTEUR (meme largeur que la source)
            if ($W_fin==0 && $H_fin!=0)
            {
                $H = $H_fin;
                $W = $W_Src;
            }

            // C- crop en LARGEUR (meme hauteur que la source)
            if ($W_fin!=0 && $H_fin==0)
            {
                $W = $W_fin;
                $H = $H_Src;
            }

            // D- crop "carre" a la plus petite dimension de l'image source
            if ($W_fin==0 && $H_fin==0)
            {
                if ($W_Src >= $H_Src)
                {
                    $W = $H_Src;
                    $H = $H_Src;
                }
                else
                {
                    $W = $W_Src;
                    $H = $W_Src;
                }
            }

            // creation de la ressource-image "Src" en fonction de l extension
            switch($extension_Src)
            {
                case 'jpg':
                case 'jpeg':
                    $Ress_Src = imagecreatefromjpeg($rep_Src.$img_Src);
                    break;
                case 'png':
                    $Ress_Src = imagecreatefrompng($rep_Src.$img_Src);
                    break;
            }

            // creation d une ressource-image "Dst" aux dimensions finales
            // fond noir (par defaut)
            switch($extension_Src)
            {
                case 'jpg':
                case 'jpeg':
                    $Ress_Dst = imagecreatetruecolor($W,$H);
                    $blanc = imagecolorallocate ($Ress_Dst, 255, 255, 255);// fond blanc
                    imagefill ($Ress_Dst, 0, 0, $blanc);
                    break;
                case 'png':
                    $Ress_Dst = imagecreatetruecolor($W,$H);
                    imagesavealpha($Ress_Dst, true);// fond transparent (pour les png avec transparence)
                    $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
                    imagefill($Ress_Dst, 0, 0, $trans_color);
                    break;
            }

            if ($W_fin==0) // CENTRAGE en largeur
            {
                if ($H_fin==0 && $W_Src < $H_Src)
                {
                    $X_Src = 0;
                    $X_Dst = 0;
                    $W_copy = $W_Src;
                }
                else
                {
                    $X_Src = 0;
                    $X_Dst = ($W - $W_Src) /2;
                    $W_copy = $W_Src;
                }
            }
            else
            {
                if ($W_Src > $W)
                {
                    $X_Src = ($W_Src - $W) /2;
                    $X_Dst = 0;
                    $W_copy = $W;
                }
                else
                {
                    $X_Src = 0;
                    $X_Dst = ($W - $W_Src) /2;
                    $W_copy = $W_Src;
                }
            }


            if ($H_fin==0) // CENTRAGE en hauteur
            {
                if ($W_fin==0 && $H_Src < $W_Src)
                {
                    $Y_Src = 0;
                    $Y_Dst = 0;
                    $H_copy = $H_Src;
                } else {
                    $Y_Src = 0;
                    $Y_Dst = ($H - $H_Src) /2;
                    $H_copy = $H_Src;
                }
            }
            else
            {
                if ($H_Src > $H)
                {
                    $Y_Src = ($H_Src - $H) /2;
                    $Y_Dst = 0;
                    $H_copy = $H;
                }
                else
                {
                    $Y_Src = 0;
                    $Y_Dst = ($H - $H_Src) /2;
                    $H_copy = $H_Src;
                }
            }

            // CROP par copie de la portion d image selectionnee
            imagecopyresampled($Ress_Dst,$Ress_Src,$X_Dst,$Y_Dst,$X_Src,$Y_Src,$W_copy,$H_copy,$W_copy,$H_copy);

            // ENREGISTREMENT dans le repertoire (avec la fonction appropriee)
            switch ($extension_Src) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg ($Ress_Dst, $rep_Dst.$img_Dst,100);
                    break;
                case 'png':
                    imagepng ($Ress_Dst, $rep_Dst.$img_Dst);
                    break;
            }

            // liberation des ressources-image
            imagedestroy ($Ress_Src);
            imagedestroy ($Ress_Dst);

            $condition = 1;
        }
    }

    // retourne : true si le redimensionnement et l'enregistrement ont bien eu lieu, sinon false
    if ($condition==1 && file_exists($rep_Dst.$img_Dst)) { return true; }
    else { return false; }
};

//La fonction redimentionnant une image
// $redimOK = fctredimimage(120,80,'reppicto/','monpicto.jpg','repimage/','monimage.jpg');
function redim_image($W_max, $H_max, $rep_Dst, $img_Dst, $rep_Src, $img_Src)
{
    $condition = 0;
    // Si certains paramètres ont pour valeur '' :
    if ($rep_Dst=='') { $rep_Dst = $rep_Src; } // (même répertoire)
    if ($img_Dst=='') { $img_Dst = $img_Src; } // (même nom)

    // si le fichier existe dans le répertoire, on continue...
    if (file_exists($rep_Src.$img_Src) && ($W_max!=0 || $H_max!=0))
    {

        // extensions acceptées :
        $extension_Allowed = 'jpg,jpeg,png';	// (sans espaces)
        // extension fichier Source
        $extension_Src = strtolower(pathinfo($img_Src,PATHINFO_EXTENSION));

        // extension OK ? on continue ...
        if(in_array($extension_Src, explode(',', $extension_Allowed)))
        {

            // récupération des dimensions de l'image Src
            $img_size = getimagesize($rep_Src.$img_Src);
            $W_Src = $img_size[0]; // largeur
            $H_Src = $img_size[1]; // hauteur

            // condition de redimensionnement et dimensions de l'image finale

            // A- LARGEUR ET HAUTEUR maxi fixes
            if ($W_max!=0 && $H_max!=0)
            {
                $ratiox = $W_Src / $W_max; // ratio en largeur
                $ratioy = $H_Src / $H_max; // ratio en hauteur
                $ratio = max($ratiox,$ratioy); // le plus grand
                $W = $W_Src/$ratio;
                $H = $H_Src/$ratio;
                $condition = ($W_Src>$W) || ($W_Src>$H); // 1 si vrai (true)
            }

            // B- HAUTEUR maxi fixe
            if ($W_max==0 && $H_max!=0)
            {
                $H = $H_max;
                $W = $H * ($W_Src / $H_Src);
                $condition = ($H_Src > $H_max); // 1 si vrai (true)
            }

            // C- LARGEUR maxi fixe
            if ($W_max!=0 && $H_max==0)
            {
                $W = $W_max;
                $H = $W * ($H_Src / $W_Src);
                $condition = ($W_Src > $W_max); // 1 si vrai (true)
            }

            // REDIMENSIONNEMENT si la condition est vraie

            // - Si l'image Source est plus petite que les dimensions indiquées :
            // Par defaut : PAS de redimensionnement.
            // - Mais on peut "forcer" le redimensionnement en ajoutant ici :
            // $condition = 1; (risque de perte de qualité)
            if ($condition==1)
            {
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

                // creation d une ressource-image "Dst" aux dimensions finales
                // fond noir (par defaut)
                switch($extension_Src)
                {
                    case 'jpg':
                    case 'jpeg':
                        $Ress_Dst = imagecreatetruecolor($W,$H);
                        break;
                    case 'png':
                        $Ress_Dst = imagecreatetruecolor($W,$H);
                        imagesavealpha($Ress_Dst, true);// fond transparent (pour les png avec transparence)
                        $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
                        imagefill($Ress_Dst, 0, 0, $trans_color);
                        break;
                }

                // REDIMENSIONNEMENT (copie, redimensionne, re-echantillonne)
                imagecopyresampled($Ress_Dst, $Ress_Src, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src);

                // ENREGISTREMENT dans le repertoire (avec la fonction appropriee)
                switch ($extension_Src)
                {
                    case 'jpg':
                    case 'jpeg':
                        imagejpeg ($Ress_Dst, $rep_Dst.$img_Dst);
                        break;
                    case 'png':
                        imagepng ($Ress_Dst, $rep_Dst.$img_Dst);
                        break;
                }

                // liberation des ressources-image
                imagedestroy ($Ress_Src);
                imagedestroy ($Ress_Dst);
            }

        }
    }

    // retourne : true si le redimensionnement et l'enregistrement ont bien eu lieu, sinon false
    if ($condition==1 && file_exists($rep_Dst.$img_Dst)) { return true; }
    else { return false; }

};