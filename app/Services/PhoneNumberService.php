<?php

namespace App\Services;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class PhoneNumberService
{
    public function __construct() {}

    /**
     * Format a phone number to E.164 format.
     *
     * @param  string  $phoneNumber  The phone number to format.
     * @param  string  $region  The region (e.g., "US", "GB") to parse the number.
     * @return string|null The formatted phone number or null if invalid.
     */
    public function formatToE164(string $phoneNumber, string $region = 'US'): ?string
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            // Parse the phone number with the specified region
            $numberProto = $phoneUtil->parse($phoneNumber, $region);

            // Format the number to E.164
            return $phoneUtil->format($numberProto, PhoneNumberFormat::E164);
        } catch (NumberParseException $e) {
            // Handle invalid phone numbers
            return null;
        }
    }
}
