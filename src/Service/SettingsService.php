<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class SettingsService
 * @package App\Service
 */
class SettingsService
{
    /**
     * @var string[] Default Settings
     */
    protected $defaultSettings = [
        'settings-customer-currency' => 'EUR',
        'settings-customer-locale' => 'en_GB',
        'settings-customer-id' => 'CS12.000.AAE',
        'settings-customer-name' => 'John',
        'settings-customer-family-name' => 'Doe',
        'settings-customer-email' => 'john.doe@paypal.com',
        'settings-customer-street' => 'Rue Bethancourt 5',
        'settings-customer-city' => 'Paris',
        'settings-customer-province' => 'Paris',
        'settings-customer-zip-code' => '75007',
        'settings-customer-country' => 'FR',
        'settings-merchant-name' => 'PlayGround Shop',
        'settings-merchant-email' => 'merchant@domain.com',
        'settings-merchant-street' => 'Calle Valencia 34',
        'settings-merchant-city' => 'Mahora',
        'settings-merchant-province' => 'Albacete',
        'settings-merchant-zip-code' => '02002',
        'settings-merchant-country' => 'FR',
        'settings-item-name' => 'Make me proud! TEE (XXL)',
        'settings-item-price' => '18',
        'settings-item-shipping' => '5',
        'settings-item-sku' => 'TEE-MMP-XXL',
        'settings-item-description' => 'A tee that will make you proud and good looking, in an XXL size',
        'settings-item-purchase-description' => 'Tee sale: Make me proud! (XXL) SPECIAL OFFER',
        'settings-item-tax-name' => 'VAT',
        'settings-item-tax-value' => '21',
    ];

    /**
     * @var Session
     */
    public $session;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SettingsService constructor.
     * @param SessionInterface $session
     * @param LoggerInterface $logger
     */
    public function __construct(SessionInterface  $session, LoggerInterface $logger)
    {
        $this->session = $session;
        $this->logger = $logger;
    }

    /**
     * @param array $settings
     */
    public function storeSettings(array $settings): void
    {
        $this->session->set('settings', $settings);
    }

    /**
     * Clear settings to Defaults
     */
    public function clearSettings(): void
    {
        $this->session->set('settings', $this->defaultSettings);
    }

    /**
     * Check if settings are initialized
     * @return bool
     */
    public function isInitialized(): bool
    {
        $settings = $this->session->get('settings');
        if (is_array($settings)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $settingKey
     *
     * @return string
     */
    public function getSetting(string $settingKey): ?string
    {
        $settings = $this->session->get('settings');
        if (array_key_exists($settingKey, $settings)) {
            return $settings[$settingKey];
        }

        return null;
    }
}
