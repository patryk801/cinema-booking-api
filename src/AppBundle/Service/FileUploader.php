<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
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

    public function uploadImage(UploadedFile $file,string $targetDir): ?string
    {
        if($this->isValidImageFile($file))
        {
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($targetDir, $fileName);
            return $fileName;
        }
        else return null;
    }

    public function uploadImageFromPutRequest(Request $request, string $targetDir): ?string
    {
        // Read the image content from request body
        $content = $request->getContent();
        // Create temporary upload file (deleted after request finishes)
        $tmpFile = tmpfile();
        // Get the temporary file name
        $tmpFilePath = stream_get_meta_data($tmpFile)['uri'];
        // Write image content to the temporary file
        file_put_contents($tmpFilePath, $content);

        // Get the file mime-typ
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $tmpFilePath);

        // Guess the extension based on a mime-type
        $extensionGuesser = ExtensionGuesser::getInstance();
        $extension = $extensionGuesser->guess($mimeType);

        // Check if it's really an image
        if(!in_array($extension, $this->acceptedImageExtensions)) throw new UnsupportedMediaTypeHttpException('File uploaded is not a valid png/jpeg/gif image.');

        $newFileName = md5(uniqid()).'.'.$extension;

        // Copy the temp file to the uploads directory
        if(copy($tmpFilePath, $targetDir.DIRECTORY_SEPARATOR.$newFileName)) return $newFileName;
        else return null;
    }
}