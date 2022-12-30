<?php

namespace blog\validator;

use blog\validator\Validator;

/**
 * Description of ImageValidator
 *
 * @author constancelaloux
 */
class ImageValidator extends Validator
{

    public function isValid(string $file): string
    {
        return $file != '';
    }

    /**
     * I check if the image is well a jpeg , gif or png
     */
    public function checkImage(): void
    {
        switch ($uploadImageType) 
        {
            case IMAGETYPE_JPEG:
                /**
                 * 
                 * It returns an image identifier representing an image obtained from the filename file.
                 */
                $image = ImageCreateFromJpeg($imageFolder .$temp['name']);

                /**
                 * I create the miniature
                 */
                ImageCopyResampled($miniature, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );

                /**
                 * I upload the image into the file.
                 * This last function is not least useful since it will offer us the opportunity not only to 
                 * save our new image in a file, but also to determine the quality with which we will save it!
                 */
                ImageJpeg($miniature, $imageFolder . $temp['name'], 100 );

                imagedestroy($miniature);
                imagedestroy($image);
            break;

            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($imageFolder .$temp['name']);
                ImageCopyResampled($miniature, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                imageGif($miniature, $imageFolder . $temp['name'], 100 );
            break;

            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($imageFolder .$temp['name']);
                ImageCopyResampled($miniature, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                imagePng($miniature, $imageFolder . $temp['name'], 9 );
            break;           
        } 
    }
    
    /**
     * Check file format
     * @param string $key
     * @param array $extensions
     * @return \self
     */
    public function extension(string $key, array $extensions): self
    {
        $file = $this->getValue($key);
        /**
         * It means there is no upload errors UPLOAD_ERR_OK
         */
        if($file !== NULL && $file->getError() === UPLOAD_ERR_OK)
        {
            $type = $file->getClientMediaType();
            $extension = mb_strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
            $expectedType = self::MIME_TYPES[$extension] ?? NULL;
            /**
             * If this extension is in the extensions table
             */
            if(!in_array($extension, $extensions) || $expectedType !== $type )
            {
                $this->addError($key, 'fileType', [join(',', $extensions)]);
            }
        }
        return $this;
    }
    
    /**
     * Check that the file must be necessarily uploaded
     * @param string $key
     * @return \self
     */
    public function uploaded(string $key): self
    {
        $file = $this->getValue($key);
        if($file === NULL || $file->getError() !== UPLOAD_ERR_OK)
        {
            $this->addError($key, 'uploaded');
        }
        return $this;
    }
}
