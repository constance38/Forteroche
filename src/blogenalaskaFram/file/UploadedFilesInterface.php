<?php

namespace blog\file;

/**
 *
 * @author constancelaloux
 */
interface UploadedFilesInterface 
{
    public function moveTo(string $targetPath): void;
    
    public function upload(array $file, ?string $oldFile = null): string;
    
    public function delete(?string $oldFile): void;  
}
