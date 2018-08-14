<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class FileUploader
{
    private $acceptedImageExtensions;
    private $allowedImageSize;

    public function __construct(array $acceptedImageExtensions, int $allowedImageSize)
    {
        $this->acceptedImageExtensions = $acceptedImageExtensions;
        $this->allowedImageSize = $allowedImageSize;
    }

    private function isValidImageFile(UploadedFile $file): bool
    {
        if(!in_array($file->guessExtension(), $this->acceptedImageExtensions)) throw new UnsupportedMediaTypeHttpException('Invalid file extension.');
        if($file->getSize() > $this->allowedImageSize) throw new \Exception('Invalid file size.');

        return true;
    }

    public function uploadImage(UploadedFile $file, $targetDir): ?string
    {
        if($this->isValidImageFile($file))
        {
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($targetDir, $fileName);
            return $fileName;
        }
        else return null;
    }
}