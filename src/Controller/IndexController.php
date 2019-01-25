<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function __invoke(Request $request)
    {
        $bookingId = $request->query->get('rid');
        $booking = new Booking();
        $bookingSaved = $bookingId !== null;
        if ($bookingSaved === true) {
            $bookingRepository = $this->getDoctrine()->getRepository(Booking::class);
            $booking = $bookingRepository->find($bookingId);
            $bookingSaved = $booking !== null;
        }

        $form = $this->createForm(BookingType::class, $booking);

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
            'saved' => $bookingSaved
        ]);
    }
}
