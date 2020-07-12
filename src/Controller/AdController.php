<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repository)
    {
        $ads = $repository->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }


    /**
     * @Route("/ads/{slug}",name="ads_show")
     *
     */
    public function show($slug,AdRepository $repository){
        $ad = $repository->findOneBySlug($slug);

        return $this->render('ad/show.html.twig',[
            'ad'=>$ad
        ]);
    }


}


