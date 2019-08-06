<?php

namespace App\Repository;

use Symfony\Component\DependencyInjection\ContainerInterface;

class PhotoRepository
{
    private $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function findUrl($client)
    {
        $iDirUrl = '/images/cache/';
        $iDir = $this->container->getParameter('kernel.project_dir') . '/public'. $iDirUrl;
        $photoKey = (string)$client->getId();
        $photoKey = 'photo_'.$photoKey;
        $iFile = $iDir.$photoKey;
        $iUrl = $iDirUrl.$photoKey;
        if (!file_exists($iFile)) {
            file_put_contents($iFile, $client->getPhoto());
        } else {
          $dateAsUnix = 0;
        $date = $client->getPhotoSaveDate(); // no date, no saved file
        if (!empty($date)) {
            $dateAsUnix = $date->getTimestamp();
            $datec = filemtime($iFile);
            if ($datec < $dateAsUnix) {
            dump($dateAsUnix);
            dump($datec);
                file_put_contents($iFile, $client->getPhoto());
            }
    }
        }
        return $iUrl;
    }

    public function findThumbnailUrl($client)
    {
        return $this->findUrl($client);
    }
}
