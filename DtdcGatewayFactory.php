<?php

namespace Omnibus\Dtdc;

use Omnibus\Config;
use Omnibus\Dtdc\Action\CancelAction;
use Omnibus\Dtdc\Action\ShippingAction;
use Omnibus\Dtdc\Action\TrackingAction;
use Omnibus\Exception\InvalidConfigException;
use Omnibus\GatewayFactory;
use Symfony\Component\HttpClient\HttpClient;

/**
 *   options:
 *     api_key: '%env(DTDC_API_KEY)%'              # the customer integration key
 *     customer_code: '%env(DTDC_CUSTOMER)%'
 *     tracking_username: null                     # the tracking API's login
 *     tracking_password: null
 *     sandbox: true
 *     rates: [...]                                # prices from configuration: DTDC quotes by contract
 *
 * No pickup points: DTDC delivers to the door. Unverified until an account's keys are at hand.
 */
final class DtdcGatewayFactory extends GatewayFactory
{
    protected function populateConfig(Config $config): void
    {
        $config->defaults([
            'omnibus.factory_name' => 'dtdc',
            'omnibus.factory_title' => 'DTDC',
            'omnibus.required_options' => ['api_key', 'customer_code'],
            'tracking_username' => null,
            'tracking_password' => null,
            'sandbox' => false,
            'omnibus.api' => function (Config $c) {
                $http = $this->http ?? (class_exists(HttpClient::class) ? HttpClient::create() : throw new InvalidConfigException('The "dtdc" gateway needs symfony/http-client.'));

                return new Api($http, (string) $c['api_key'], (string) $c['customer_code'], $c['tracking_username'] ?: null, $c['tracking_password'] ?: null, (bool) $c['sandbox']);
            },
            'omnibus.action.shipping' => new ShippingAction(),
            'omnibus.action.tracking' => new TrackingAction(),
            'omnibus.action.cancel' => new CancelAction(),
        ]);
    }
}
