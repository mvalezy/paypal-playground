<?php

namespace App\Service\Braintree;

use Braintree\Result\Error;
use Braintree\Result\Successful;
use Exception;

/**
 * Class PaymentService
 * @package App\Service\Braintree
 */
class PaymentService extends AbstractBraintreeService
{
    /**
     * @return string
     */
    public function getClientToken(): ?string
    {
        try {
            return $this->gateway->clientToken()->generate();
        } catch (Exception $exception) {
            $this->logger->error(
                'Error on ' . __CLASS__ . '->' . __FUNCTION__ - ': ' . $exception->getMessage()
            );
        }
        return null;
    }

    /**
     * @param $amount
     * @param $paymentNonce
     * @param $deviceDataFromTheClient
     * @return Error|Successful
     */
    public function createSale($amount, $paymentNonce, $deviceDataFromTheClient)
    {
        return $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $paymentNonce,
            'deviceData' => $deviceDataFromTheClient,
            'options' => [
                'submitForSettlement' => false
            ]
        ]);
    }

    /**
     * @param $transactionId
     * @param $amount
     * @return Error|Successful
     */
    public function captureSale($transactionId, $amount)
    {
        return $this->gateway->transaction()->submitForSettlement($transactionId, $amount);
    }
}
