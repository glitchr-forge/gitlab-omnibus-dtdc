# omnibus/dtdc

DTDC for [glitchr/omnibus](https://github.com/glitchr-studio/omnibus): consignments with their
labels and cancellation through DTDC's customer integration API (an api-key), tracking through
DTDC's tracking API (its own login). Prices come from configuration (`rates`): DTDC quotes by
contract.

```yaml
omnibus:
    gateways:
        dtdc:
            factory: dtdc
            options:
                api_key: '%env(DTDC_API_KEY)%'
                customer_code: '%env(DTDC_CUSTOMER)%'
                tracking_username: '%env(DTDC_TRACK_USER)%'
                tracking_password: '%env(DTDC_TRACK_PASSWORD)%'
                sandbox: true
                rates:
                    - { service: 'B2C PRIORITY', label: 'DTDC Priority', currency: INR, bands: { 5000: 25000 } }
```

The service is DTDC's service type id (B2C PRIORITY by default, PTP, GROUND EXPRESS...). Shipment
options: `description`, `commodity`, `label_code` (SHIP_LABEL_4X6, SHIP_LABEL_A4). No pickup
points: DTDC delivers to the door.

Credentials: a DTDC business account; the integration api-key and customer code, and the tracking
login, come from DTDC's integration team (the demo environment first).

Built from DTDC's published integration documentation and tested on recorded answers;
**unverified** against the demo environment until an account's keys are at hand.

License: LGPL-3.0-or-later.
