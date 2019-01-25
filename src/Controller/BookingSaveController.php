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

class BookingSaveController extends AbstractController
{
    /**
     * @Route("/booking/save", name="booking_save")
     */
    public function _invoke(Request $request)
    {
        $houseRepository = $this->getDoctrine()->getRepository(House::class);
        $house = $houseRepository->findOneBy(['name' => 'don-alonso']);
        $booking = new Booking();
        $booking->setHouse($house);
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($booking->getNumberOfKids() === null) {
                $booking->setNumberOfKids(0);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('index', ['rid' => $booking->getId()]);
    }
}
