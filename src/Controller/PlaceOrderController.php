<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Order;
use App\Form\AddressFormType;
use App\Repository\AddressRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class PlaceOrderController extends AbstractController
{
    private $env;
    private $entityManager;

    public function __construct(Environment $env, EntityManagerInterface $entityManager) {
        $this->env = $env;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/placeorder", name="place_order")
     */
    public function index(Request $req, AddressRepository $addrRepo): Response
    {
        $addressList = $addrRepo->findAll();
        $choiceList = array();
        $addr = new Address();

        foreach($addressList as $elem) {
            $choiceList[$elem->__toString()] = $elem->getId();
        }

        $choiceList["Új számlázási címet adok meg"] = 0;

        $form = $this->createFormBuilder()
            ->add('addrselect', ChoiceType::class, [
                'label' => 'Számlázási cím',
                'choices' => $choiceList,
                'attr' => [
                    'onclick' => 'selectChanged()',
                ]
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Típus *',
                'choices' => [
                    'Céges' => 0,
                    'Magánszemély' => 1,
                ],
                'required' => false,
            ])
            ->add('name', null, [
                'label' => 'Név / Cégnév *',
                'required' => false,
            ])
            ->add('phonenumber', null, [
                'label' => 'Telefonszám',
                'required' => false,
            ])
            ->add('taxnumber', TextType::class, [
                'label' => 'Adószám',
                'required' => false,
            ])
            ->add('country', ChoiceType::class, [
                'label' => 'Ország *',
                'choices' => [
                    'Magyarország' => 'Magyarország',
                    'Szerbia' =>  'Szerbia',
                    'Románia' => 'Románia',
                    'Szlovákia' => 'Szlovákia',
                    'Ausztria' => 'Ausztria',
                    'Ukrajna' => 'Ukrajna',
                    'Szlovénia' => 'Szlovénia',
                    'Egyesült Királyság' => 'Egyesült Királyság',
                    'Németország' => 'Németország'
                ],
                'required' => false,
            ])
            ->add('postcode', TextType::class, [
                'label' => 'Irányítószám *',
                'required' => false,
            ])
            ->add('city', null, [
                'label' => 'Város *',
                'required' => false,
            ])
            ->add('address', null, [
                'label' => 'Utca, házszám *',
                'required' => false,
            ])
            ->add('checkbox', CheckboxType::class, [
                'label' => false,
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Megrendelés'          
            ])
            ->getForm();

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $arr = $form->getData();

            if($arr["addrselect"] == 0) { // new addr
                $fieldLeftEmpty =    
                    empty($arr["name"])     ||
                    empty($arr["country"])  ||
                    empty($arr["postcode"]) ||
                    empty($arr["city"])     ||
                    empty($arr["address"]);

                if($fieldLeftEmpty) {
                    return $this->redirectToRoute('place_order', ["success" => 0, "err" => "fd"]);
                }

                if($arr["type"] == 0 && empty($arr["taxnumber"])) {
                    return $this->redirectToRoute('place_order', ["success" => 0, "err" => "te"]);
                }

                if(!$arr["checkbox"]) {
                    return $this->redirectToRoute('place_order', ["success" => 0, "err" => "cb"]);
                }

                if(intval($arr["postcode"]) == 0) {
                    return $this->redirectToRoute('place_order', ["success" => 0, "err" => "pc"]);
                }

                if(intval(substr($arr["phonenumber"], 1)) == 0 || strpos($arr["phonenumber"], "+36") != 0) {
                    return $this->redirectToRoute('place_order', ["success" => 0, "err" => "ph"]);
                }

                if(preg_match("/^[0-9]{8}-[1-5]-[0-9]{2}$/", $arr["taxnumber"]) == 1 && $arr["type"] == 0) {
                    return $this->redirectToRoute('place_order', ["success" => 0, "err" => "tx"]);
                }

                $addr->setType($arr["type"]);
                $addr->setName($arr["name"]);
                $addr->setPhonenumber($arr["phonenumber"]);
                $addr->setTaxnumber($arr["taxnumber"]);
                $addr->setCountry($arr["country"]);
                $addr->setPostCode($arr["postcode"]);
                $addr->setCity($arr["city"]);
                $addr->setAddress($arr["address"]);

                $this->entityManager->persist($addr);
                $this->entityManager->flush();
            } else {
                $addr = $addrRepo->findBy(["id" => $arr["addrselect"]])[0];
            }

            $newOrder = new Order();

            $newOrder->setNetAmount(17990);
            $newOrder->setGrossAmount(22847);
            $newOrder->setTaxAmount(4857);

            $newOrder->setAddressType($addr->getType());
            $newOrder->setAddressName($addr->getName());
            $newOrder->setAddressPhone($addr->getPhoneNumber());
            $newOrder->setAddressTax($addr->getTaxNumber());
            $newOrder->setAddressCountry($addr->getCountry());
            $newOrder->setAddressPostCode($addr->getPostCode());
            $newOrder->setAddressCity($addr->getCity());
            $newOrder->setAddressDesc($addr->getAddress());

            $this->entityManager->persist($newOrder);
            $this->entityManager->flush();

            return $this->redirectToRoute('place_order', ["success" => 1, "page" => "neworder"]);
        }

        return new Response($this->env->render('place_order/placeorder.html.twig', [
            'select_addr' => $form->createView(),
        ]));
    }
}
