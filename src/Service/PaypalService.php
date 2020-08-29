<?php

namespace App\Service;

use App\Service\Paypal\IdentityService;
use App\Service\Paypal\PaymentService;
use App\Service\Paypal\PayoutService;
use App\Service\Paypal\ReportingService;

/**
 * Class PaypalService
 * @package App\Service
 */
class PaypalService
{
    /**
     * @var IdentityService
     */
    protected $identityService;

    /**
     * @var PaymentService
     */
    protected $paymentService;

    /**
     * @var PayoutService
     */
    protected $payoutService;

    /**
     * @var ReportingService
     */
    protected $reportingService;

    /**
     * PaypalService constructor.
     * @param IdentityService $identityService
     * @param PaymentService $paymentService
     * @param PayoutService $payoutService
     * @param ReportingService $reportingService
     */
    public function __construct(
        IdentityService $identityService,
        PaymentService $paymentService,
        PayoutService $payoutService,
        ReportingService $reportingService
    ) {
        $this->identityService = $identityService;
        $this->paymentService = $paymentService;
        $this->payoutService = $payoutService;
        $this->reportingService = $reportingService;
    }

    /**
     * @return IdentityService
     */
    public function getIdentityService(): IdentityService
    {
        return $this->identityService;
    }

    /**
     * @return PaymentService
     */
    public function getPaymentService(): PaymentService
    {
        return $this->paymentService;
    }

    /**
     * @return PayoutService
     */
    public function getPayoutService(): PayoutService
    {
        return $this->payoutService;
    }

    /**
     * @return ReportingService
     */
    public function getReportingService(): ReportingService
    {
        return $this->reportingService;
    }
}
