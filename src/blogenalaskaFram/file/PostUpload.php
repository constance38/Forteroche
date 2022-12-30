<?php

namespace blog\file;

use blog\file\Upload;

/**
 * Description of PostUpload
 *
 * @author constancelaloux
 */
class PostUpload extends Upload
{
    protected $path = '/../../../public/images/upload/posts'; 
    protected $newwidth = 200;
}
