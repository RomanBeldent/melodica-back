<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    // doc : https://symfony.com/doc/5.4/controller/upload_file.html
    public function upload(UploadedFile $file): string
    {
        // on récupère le nom de l'image pur et dur, sans extension
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // on "slug" le fichier, afin d'avoir un nom de fichier propre
        // il faut que tous les fichiers aient une norme afin de pouvoir correctement les gérer
        $safeFilename = $this->slugger->slug($originalFilename);
        // on donne un identifiant unique à chaque fichier uploadé
        // fichier avec nommé aux normes, on ajoute - id unique et . pour finir avec l'extension
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
        // on déplace à le fichier à l'endroit souhaité
        // le dossier a été définit dans "services.yaml"
        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}
