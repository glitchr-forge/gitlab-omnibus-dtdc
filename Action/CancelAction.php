<?php

namespace Omnibus\Dtdc\Action;

use Omnibus\Action\ActionInterface;
use Omnibus\Action\ApiAwareInterface;
use Omnibus\Action\ApiAwareTrait;
use Omnibus\Dtdc\Api;
use Omnibus\Request\Cancel;
use Omnibus\Request\Request;

/** POST /consignment/cancel. */
final class CancelAction implements ActionInterface, ApiAwareInterface
{
    /** @use ApiAwareTrait<Api> */
    use ApiAwareTrait;

    public function __construct()
    {
        $this->apiClass = Api::class;
    }

    public function supports(Request $request): bool
    {
        return $request instanceof Cancel;
    }

    public function execute(Request $request): void
    {
        \assert($request instanceof Cancel);
        $data = $this->api->call('POST', '/consignment/cancel', ['AWBNo' => [$request->trackingNumber], 'customerCode' => $this->api->customerCode]);
        $request->setResult(empty($data['failedAWBNo'] ?? $data['failed'] ?? []) && 'OK' === strtoupper((string) ($data['status'] ?? 'OK')));
    }
}
