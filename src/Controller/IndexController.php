<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

class IndexController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(): Response
    {

        $package = new Package(new EmptyVersionStrategy());
        $path = $package->getUrl('assets/json/episodios.json');
        $data = file_get_contents($path);
        $episodios = json_decode($data,1);

        foreach ($episodios as $chave => $episodio) {

            $episodios[$chave]['embed'] = 'https://youtube.com/embed/' . str_replace(['https://www.youtube.com/watch?v=','https://youtu.be/'],'',$episodio['Link']);
            $episodios[$chave]['thumb'] = 'https://img.youtube.com/vi/' . str_replace(['https://www.youtube.com/watch?v=','https://youtu.be/'],'',$episodio['Link']) . '/hqdefault.jpg';

        }

        $episodioAleatorio = $episodios[array_rand($episodios)];

        return $this->render('base.html.twig',['episodios' => $episodios, 'aleatorio' => $episodioAleatorio]);
    }

}