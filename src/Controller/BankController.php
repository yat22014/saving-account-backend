<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\SavingAccount;

class BankController extends AbstractController
{
    /**
     * @Route("/bank", name="bank")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/BankController.php',
        ]);
    }


    /**
     * @Route("/account/create", name="createAccount")
     */
    public function setupAccount(Request $request)
    {

        $userInformation = $request->request->get('submitAccount');
        // dump($userInformation, 30);
        if (isset($userInformation)) {
            $userAccount = json_decode($userInformation, true);
            // dump(34, $userAccount);


            $entityManager = $this->getDoctrine()->getManager();
            $savingAccount = new SavingAccount();

            $accountName = $userAccount["accountName"];
            $account = $userAccount["account"];

            $savingAccount->setName($accountName);
            $savingAccount->setAccount($account);

            $entityManager->persist($savingAccount);
            $entityManager->flush();

            $parametersAsArray = json_decode($request->getContent(), true);
            // dump(33, $request->request->all());
            return $this->json([
                "success" => true
            ]);
        } else {
            return $this->json([
                "success" => false
            ]);

        }
    }

    /**
     * @Route("/account/list", name="accountList")
     */
    public function accountList()
    {

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $repository = $this->getDoctrine()->getRepository(SavingAccount::class);
        $accountList = $repository->findAll();

        // $jsonContent = $serializer->serialize($accountList, 'json');
        dump(82, $accountList);
        $jsonObject = $serializer->serialize($accountList, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = JsonResponse::fromJsonString($jsonObject);

        // dump(77, $accountList);
        // dump(78, $jsonContent);
        // dump(79, $response);
        // exit;
        // return $this->json([
        //     "list" => $jsonContent
        // ]);
        return $response;
    }
}
