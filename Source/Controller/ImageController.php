<?php
/**
 * Image Controller
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Controller;

use stdClass;
use CommonApi\Application\ImageInterface;
use CommonApi\Exception\RuntimeException;

/**
 * Image Controller
 *
 * @package     Molajo
 * @copyright   2014-2015 Amy Stephen. All rights reserved.
 * @license     http://www.opensource.org/licenses/mit-license.html MIT License
 * @since       1.0
 */
final class ImageController implements ImageInterface
{
    /**
     * Default Media Folder
     *
     * @var    string
     * @since  1.0
     */
    protected $media_folder = 'Media';

    /**
     * Sizes - configurable
     *
     * @var    array
     * @since  1.0
     */
    protected $standard_size
        = array(
            'thumbnail' => array('width' => 50, 'height' => 50),
            'small'     => array('width' => 75, 'height' => 75),
            'medium'    => array('width' => 150, 'height' => 150),
            'large'     => array('width' => 300, 'height' => 300),
            'xlarge'    => array('width' => 500, 'height' => 500),
            'normal'    => array('width' => null, 'height' => null)
        );

    /**
     * Standard Types
     *
     * @var    array
     * @since  1.0
     */
    protected $standard_type = array('portrait', 'landscape', 'auto', 'crop');

    /**
     * Default Size
     *
     * @var    string
     * @since  1.0
     */
    protected $default_size = 'medium';

    /**
     * Default Type
     *
     * @var    array
     * @since  1.0
     */
    protected $default_type = 'auto';

    /**
     * Constructor
     *
     * @param  string $media_folder
     * @param  array  $standard_size
     * @param  array  $standard_type
     * @param  string $default_size
     * @param  string $default_type
     *
     * @since  1.0
     */
    public function __construct(
        $media_folder = null,
        array $standard_size = array(),
        array $standard_type = array(),
        $default_size = 'normal',
        $default_type = 'auto'
    ) {
        $this->media_folder = $media_folder;

        if (is_dir($this->media_folder)) {
        } else {
            mkdir($this->media_folder, 0755);
        }

        if (count($standard_size) > 0) {
            $this->standard_size = $standard_size;
        }

        if (count($standard_type) > 0) {
            $this->standard_type = $standard_type;
        }
        $this->default_size = $default_size;
        $this->default_type = $default_type;
    }

    /**
     * Retrieve and optionally resize requested image
     *
     * @param   string      $filename
     * @param   null|string $type
     * @param   null|string $size
     * @param   bool        $base64_encode
     *
     * @return  stdClass
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function getImage($filename, $type = null, $size = null, $base64_encode = true)
    {
        $this->validateFileName($filename);
        $type  = $this->verifyType($type);
        $size  = $this->setSize($size);
        $image = $this->setImageObject($filename, $type, $size);
        $image = $this->createImage($image);
        $this->addBase64Encoded($base64_encode, $image);

        return $image;
    }

    /**
     * @param $filename
     *
     * @throws RuntimeException
     */
    protected function validateFileName($filename)
    {
        if (file_exists($filename)) {
        } else {
            throw new RuntimeException('ImageController: Filename: ' . $filename . ' Does Not Exist.');
        }
    }

    /**
     * @param $type
     *
     * @return array|string
     */
    protected function verifyType($type)
    {
        if ($type === null) {
            $type = $this->default_type;
        }
        if (in_array($type, $this->standard_type)) {
        } else {
            $type = $this->default_type;
            return $type;
        }
        return $type;
    }

    /**
     * @param $size
     *
     * @return string
     */
    protected function setSize($size)
    {
        if ($size === null) {
            $size = $this->default_size;
        }
        if (in_array($size, $this->standard_size)) {
            $size = $this->default_size;
            return $size;
        }
        return $size;
    }

    /**
     * @param $image
     *
     * @return stdClass
     * @throws RuntimeException
     */
    protected function createImage($image)
    {
        if (file_exists($image->filename)) {
        } else {
            $image = $this->resizeImage($image, $image_quality = 100);
            return $image;
        }
        return $image;
    }

    /**
     * @param $base64_encode
     * @param $image
     */
    protected function addBase64Encoded($base64_encode, $image)
    {
        unset($image->original_source);
        unset($image->source);

        if ($base64_encode === true) {
            $image->base64 = 'data:image/'
                . $image->file_extension
                . ';base64,'
                . base64_encode(fread(fopen($image->filename, 'r'), filesize($image->filename)));
        }
    }

    /**
     * Get Placeholder Image
     *
     * @param   string $size
     * @param   string $color
     *
     * @return  ImageController
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function getImagePlaceholder($size, $color)
    {
        return $this;
    }

    /**
     * Set Image Object from Filename
     *
     * @param   string $filename
     * @param   string $type
     * @param   string $size
     *
     * @return  stdClass
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function setImageObject($filename, $type, $size)
    {
        $image = new stdClass();

        $image->original_filename          = $filename;
        $image->size                       = $size;
        $image->type                       = $type;
        $file_parts                        = pathinfo($image->original_filename);
        $image->original_path              = $file_parts['dirname'];
        $image->original_basename          = $file_parts['basename'];
        $image->original_file_extension    = $file_parts['extension'];
        $image->basename_no_file_extension = $file_parts['filename'];

        switch ($image->original_file_extension) {
            case 'jpg':
            case 'jpeg':
                $image->original_source = imagecreatefromjpeg($image->original_filename);
                break;

            case 'gif':
                $image->original_source = imagecreatefromgif($image->original_filename);
                break;

            case 'png':
                $image->original_source = imagecreatefrompng($image->original_filename);
                break;

            default:
                throw new RuntimeException(
                    'ImageController: Invalid File Extension: '
                    . $image->original_file_extension
                    . ' Filename: ' . $image->original_filename
                );
        }

        $image->original_width  = imagesx($image->original_source);
        $image->original_height = imagesy($image->original_source);

        /** Defaults */
        $image->filename       = $image->original_filename;
        $image->path           = $image->original_path;
        $image->basename       = $image->original_basename;
        $image->file_extension = $image->original_file_extension;
        $image->width          = $image->original_width;
        $image->height         = $image->original_height;
        $image->x              = 0;
        $image->y              = 0;

        /** No resizing is complete */
        if ($size === 'normal') {
            imagedestroy($image->original_source);
            unset($image->source);
            unset($image->original_source);
            return $image;
        }

        /** Calculate Height */
        $image                 = $this->setImageSize($type, $size, $image);
        $image->basename       = $image->basename_no_file_extension
            . 'W' . $image->width
            . 'H' . $image->height
            . '.' . $image->file_extension;
        $image->file_extension = $image->original_file_extension;
        $image->path           = $this->media_folder;
        $image->filename       = $image->path . '/' . $image->basename;

        return $image;
    }

    /**
     * Get Image Dimensions
     *
     * @param   string   $type
     * @param   string   $size
     * @param   stdClass $image
     *
     * @return  stdClass
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function setImageSize($type, $size, $image)
    {
        $image->width  = $this->standard_size[$size]['width'];
        $image->height = $this->standard_size[$size]['height'];

        if ($size === 'normal' || $image->width === null || $image->height === null) {
            $image->width  = $image->original_width;
            $image->height = $image->original_height;
            return $image;
        }

        if ($type === 'auto') {
            if ($image->height < $image->width) {
                $type = 'landscape';
            } else {
                $type = 'portrait';
            }
        }

        switch ($type) {
            case 'portrait':
                $ratio        = $image->width / $image->height;
                $image->width = $image->height * $ratio;
                break;

            case 'landscape':
                $ratio         = $image->height / $image->width;
                $image->height = $image->width * $ratio;
                break;

            case 'crop':
                $height_ratio = $image->original_height / $image->height;
                $width_ratio  = $image->original_width / $image->width;

                if ($height_ratio < $width_ratio) {
                    $ratio = $height_ratio;
                } else {
                    $ratio = $width_ratio;
                }

                $image->height = $image->original_height / $ratio;
                $image->width  = $image->original_width / $ratio;
                $image->x      = ($image->width / 2) - ($image->original_width / 2);
                $image->y      = ($image->height / 2) - ($image->original_height / 2);
                break;
        }

        return $image;
    }

    /**
     * Resize the image and save it to a file
     *
     * @param   stdClass $image
     * @param   int      $image_quality
     *
     * @return  stdClass
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function resizeImage($image, $image_quality = 100)
    {
        $image->source = imagecreatetruecolor($image->width, $image->height);

        imagecopyresampled(
            $image->source,
            $image->original_source,
            0,
            0,
            $image->x,
            $image->y,
            $image->width,
            $image->height,
            $image->original_width,
            $image->original_height
        );

        switch ($image->file_extension) {
            case 'jpg':
            case 'jpeg':
                if (function_exists('imagejpeg')) {
                    imagejpeg($image->source, $image->filename, $image_quality);
                    break;
                }
                throw new RuntimeException('ImageController resizeImage: PHP function imagejpeg is not supported');

            case 'gif':
                if (function_exists('imagegif')) {
                    imagegif($image->source, $image->filename, $image_quality);
                    break;
                }
                throw new RuntimeException('ImageController resizeImage: PHP function imagegif is not supported');

            case 'png':
                // *** Scale quality from 0-100 to 0-9
                $scale_quality = round(($image_quality / 100) * 9);

                // *** Invert quality setting as 0 is best, not 9
                $invert_scale_quality = 9 - $scale_quality;

                if (function_exists('imagepng')) {
                    imagepng($image->source, $image->filename, $invert_scale_quality);
                    break;
                }
                throw new RuntimeException('ImageController resizeImage: PHP function imagepng is not supported');

            default:
                throw new RuntimeException(
                    'ImageController createResizedImage: Invalid File Extension: '
                    . $image->file_extension
                    . ' Filename: ' . $image->filename
                );
        }

        return $image;
    }
}
