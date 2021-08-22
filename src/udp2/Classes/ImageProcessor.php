<?php

    namespace udp2\Classes;

    use TmpFile\TmpFile;
    use Zimage\Exceptions\CannotGetOriginalImageException;
    use Zimage\Exceptions\FileNotFoundException;
    use Zimage\Exceptions\SizeNotSetException;
    use Zimage\Exceptions\UnsupportedImageTypeException;
    use Zimage\Objects\Size;
    use Zimage\Zimage;

    class ImageProcessor
    {
        /**
         * Resizes an image and keeps the aspect ratio by blurring the background
         * This function can be slow!
         *
         * @param Zimage $zimage
         * @param Size $size
         * @param int $blur_strength
         * @return Zimage
         * @throws CannotGetOriginalImageException
         * @throws FileNotFoundException
         * @throws UnsupportedImageTypeException
         * @throws SizeNotSetException
         */
        public static function resizeImageModern(Zimage $zimage, Size $size, int $blur_strength=120): Zimage
        {
            $image = imagecreatefromstring($zimage->getOriginalImage()->getData());
            $wor = imagesx($image);
            $hor = imagesy($image);
            $back = imagecreatetruecolor($size->getWidth(), $size->getHeight());

            $max_fact = max($size->getWidth()/$wor, $size->getHeight()/$hor);
            $new_w = $wor*$max_fact;
            $new_h = $hor*$max_fact;
            imagecopyresampled($back, $image, -(($new_w-$size->getWidth())/2), -(($new_h-$size->getHeight())/2), 0, 0, $new_w, $new_h, $wor, $hor);

            // Blur Image
            for ($x=1; $x <=$blur_strength; $x++)
            {
                imagefilter($back, IMG_FILTER_GAUSSIAN_BLUR, 999);
            }
            imagefilter($back, IMG_FILTER_SMOOTH,90);
            imagefilter($back, IMG_FILTER_BRIGHTNESS, 10);

            $min_fact = min($size->getWidth()/$wor, $size->getHeight()/$hor);
            $new_w = $wor*$min_fact;
            $new_h = $hor*$min_fact;

            $front = imagecreatetruecolor($new_w, $new_h);
            imagecopyresampled($front, $image, 0, 0, 0, 0, $new_w, $new_h, $wor, $hor);

            imagecopymerge($back, $front,-(($new_w-$size->getWidth())/2), -(($new_h-$size->getHeight())/2), 0, 0, $new_w, $new_h, 100);

            // Create the new file
            $TmpFile = new TmpFile(null, ".udp_tmp");
            imagejpeg($back, $TmpFile->getFileName(),100);
            imagedestroy($back);
            imagedestroy($front);

            $return_object = Zimage::createFromImage($TmpFile->getFileName(), true);
            $return_object->setSizes($zimage->getSizes()); // Reconstruct the sizes

            return $return_object;
        }
    }