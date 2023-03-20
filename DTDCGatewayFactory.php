<?php

namespace Omnibus\DTDC;

use Omnibus\Core\GatewayFactory;
use Omnibus\DTDC\Action\ShippingAction;
use Omnibus\DTDC\Action\TrackingAction;
use Omnibus\DTDC\Action\PackingSlipAction;

class DTDCGatewayFactory extends GatewayFactory
{
    protected function populateConfig(ArrayObject $config)
    {
        $config->defaults([
            'omnibus.factory_name' => 'dtdc',
            'omnibus.factory_title' => 'DTDC'
        ]);
    }
}