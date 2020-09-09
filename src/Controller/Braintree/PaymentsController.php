<?php

namespace App\Controller\Braintree;

use Braintree\Exception\NotFound;
use Braintree\Transaction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PaymentsController
 *
 * @package App\Controller\Braintree
 *
 * @Route("/braintree/payments", name="braintree-payments-")
 */
class PaymentsController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     *
     * @return Response
     */
    public function payments()
    {
        $clientToken = $this->braintreeService->getPaymentService()->getClientToken();
        return $this->render('braintree/payments/payments.html.twig', [
            'clientToken' => $clientToken,
        ]);
    }

    /**
     * @Route("/payload", name="payload", methods={"POST"})
     *
     * @return Response
     */
    public function paymentsPayload()
    {
        $request = Request::createFromGlobals();
        $payload = $request->request->all();
        return $this->render('default/dump.html.twig', [
            'result' => (object) $payload,
            'raw_result' => false,
        ]);
    }

    /**
     * @Route("/transaction", name="create", methods={"POST"})
     *
     * @return Response
     */
    public function createTransaction()
    {
        $request = Request::createFromGlobals();
        $paymentNonce = $request->request->get('payment_nonce');
        $amount = $request->request->get('amount');
        $deviceData = $request->request->get('device_data');
        $sale = $this->braintreeService->getPaymentService()->createSale($amount, $paymentNonce, $deviceData);
        /** @var Transaction $transaction */
        $transaction = $sale->transaction;
        return $this->render('default/dump-input-id.html.twig', [
            'result' => $sale,
            'raw_result' => false,
            'result_id' => $transaction->id
        ]);
    }

    /**
     * @Route("/transaction/{transactionId}/capture", name="capture", methods={"POST"})
     *
     * @param string $transactionId
     *
     * @return Response
     */
    public function captureTransaction(string $transactionId)
    {
        $request = Request::createFromGlobals();
        $amount = $request->request->get('amount');
        $capture = $this->braintreeService->getPaymentService()->captureSale($transactionId, $amount);
        return $this->render('default/dump.html.twig', [
            'result' => (object) $capture,
            'raw_result' => false,
        ]);
    }

    /**
     * @Route("/{transactionId}", name="get", methods={"GET"})
     *
     * @param string $transactionId
     * @return Response
     * @throws NotFound
     */
    public function getTransaction(string $transactionId)
    {
        $transaction = $this->braintreeService->getPaymentService()->getTransaction($transactionId);
        return $this->render('default/dump.html.twig', [
            'result' => (object) $transaction,
            'raw_result' => false,
        ]);
    }
}
