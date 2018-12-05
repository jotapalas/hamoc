<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Booking;
use App\Entity\House;
use App\Repository\BookingRepository;
use App\Repository\HouseRepository;
use App\Form\BookingType;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function __invoke(Request $request)
    {
        $houseRepository = $this->getDoctrine()->getRepository(House::class);
        $house = $houseRepository->findOneBy(['name' => 'don-alonso']);
        $booking = new Booking();
        $booking->setHouse($house);
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();
    
            //TODO redirect
            /*return $this->redirectToRoute('admin_post_show', [
                'id' => $post->getId()
            ]);*/
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
