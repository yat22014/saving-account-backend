<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\SavingAccount;
use App\Entity\AccountDebt;
use App\Entity\Transaction;

class ProcessController extends AbstractController
{
    /**
     * @Route("/debt/list", name="debtList")
 	*/
    public function debtList(Request $request)
    {

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $userInformation = $request->request->get('userInformation');
        dump($userInformation, 30);
        if (isset($userInformation)) {
            $userAccount = json_decode($userInformation, true);
            $accountDebt = $this->getDoctrine()->getRepository(AccountDebt::class)->findBy(['debtAccount' => $userAccount["id"]]);
            dump($accountDebt, 60);
            $jsonObject = $serializer->serialize($accountDebt, 'json', [
                'circular_reference_handler' => function ($object) {
                  return $object->getId();
                }
            ]);
            $response = JsonResponse::fromJsonString($jsonObject);
            return $response;
            // return $this->json([
            //     "success" => false
            // ]);
        } else {
            return $this->json([
                "success" => false
            ]);
        }
    }

    /**
     * @Route("/debt/detail", name="debtDetail")
    */
    public function debtDetail(Request $request)
    {

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $debtId = $request->request->get('debtId');
        dump($debtId, 62);
        if (isset($debtId)) {
            $transaction = $this->getDoctrine()->getRepository(Transaction::class)->findBy(['accountDebt' => $debtId], array('created' => 'DESC'));
            dump($transaction, 60);
            $jsonObject = $serializer->serialize($transaction, 'json', [
                'circular_reference_handler' => function ($object) {
                  return $object->getId();
                }
            ]);
            $response = JsonResponse::fromJsonString($jsonObject);
            return $response;
        } else {
            return $this->json([
                "success" => false
            ]);
        }
    }

    /**
     * @Route("/debt/new", name="newDebt")
    */
    public function newDebt(Request $request)
    {
        $debtUser = $request->request->get('debtUser');
        $debtName = $request->request->get('debtName');
        $debtAmount = $request->request->get('debtAmount');
        $debtReason = $request->request->get('debtReason');
        if (isset($debtUser)) {
            // $user = json_decode($debtUser, true);

            $savingAccount = $this->getDoctrine()->getRepository(SavingAccount::class)->find($debtUser);
            // $savingAccount = $this->getDoctrine()->getRepository(SavingAccount::class)->find($userAccount["id"]);

                dump(66, $debtUser, $savingAccount);
            if ($savingAccount) {
                $entityManager = $this->getDoctrine()->getManager();
                $accountDebt = new AccountDebt();

                $accountDebt->setAmount($debtAmount);
                $accountDebt->setDebtAccount($savingAccount);
                $accountDebt->setName($debtName);
                $accountDebt->setReason($debtReason);
                $accountDebt->setOriginalAmount($debtAmount);

                $entityManager->persist($accountDebt);
                $entityManager->flush();

                return $this->json([
                    "success" => true
                ]);
            } else {
                return $this->json([
                    "success" => false
                ]);

            }
        } else {
            return $this->json([
                "success" => false
            ]);

        }
    }

    /**
     * @Route("/transaction/new", name="newTransaction")
    */
    public function newTransaction(Request $request)
    {
        dump(131, $request->request);
        $transactionAmount = $request->request->get('transactionAmount');
        $debtId = $request->request->get('debtId');
        $payTo = $request->request->get('payTo');
        $title = $request->request->get('title');

        if (isset($transactionAmount) && isset($debtId) && isset($payTo) && isset($title)) {
            $accountDebt = $this->getDoctrine()->getRepository(AccountDebt::class)->find($debtId);
            dump(137, $accountDebt, $debtId);
            if ($accountDebt) {
                dump(139, $accountDebt->getAmount());
                $entityManager = $this->getDoctrine()->getManager();

                $newRemainingMoney = $accountDebt->getAmount() - $transactionAmount;

                $newTransaction = new Transaction();
                $newTransaction->setAmount($transactionAmount);
                $newTransaction->setPayTo($payTo);
                $newTransaction->setAccountDebt($accountDebt);
                $newTransaction->setCurrentAmountMark($accountDebt->getAmount());
                $newTransaction->setTitle($title);

                $accountDebt->setAmount($newRemainingMoney);

                $entityManager->persist($newTransaction);
                $entityManager->persist($accountDebt);
                $entityManager->flush();


                $encoders = [new XmlEncoder(), new JsonEncoder()];
                $normalizers = [new ObjectNormalizer()];

                $serializer = new Serializer($normalizers, $encoders);
                $transactionlist = $this->getDoctrine()->getRepository(Transaction::class)->findBy(["accountDebt" => $debtId], array('created' => 'DESC'));
                dump($transactionlist, 60);
                $jsonObject = $serializer->serialize($transactionlist, 'json', [
                    'circular_reference_handler' => function ($object) {
                      return $object->getId();
                    }
                ]);
                // $response = JsonResponse::fromJsonString($jsonObject);
                dump(166, $jsonObject);

                return $this->json([
                        "success" => true,
                        "transactionList" => $jsonObject
                ]);

            } else {
                return $this->json([
                        "success" => false
                ]);
            }
        } else {
            return $this->json([
                    "success" => false
            ]);
        }


    }
}
