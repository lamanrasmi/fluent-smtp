<?php

namespace FluentMail\App\Services\Mailer\Providers\Enginemailer;

use FluentMail\Includes\Support\Arr;
use FluentMail\App\Services\Mailer\ValidatorTrait as BaseValidatorTrait;

trait ValidatorTrait
{
    use BaseValidatorTrait;

    public function validateProviderInformation($connection)
    {
        $errors = [];

        $keyStoreType = $connection['key_store'];

        if($keyStoreType == 'db') {
            if (! Arr::get($connection, 'api_key')) {
                $errors['api_key']['required'] = __('Api UserKey is required.', 'fluent-smtp');
            }
        } else if($keyStoreType == 'wp_config') {
            if(!defined('FLUENTMAIL_ENGINEMAILER_API_KEY') || !FLUENTMAIL_ENGINEMAILER_API_KEY) {
                $errors['api_key']['required'] = __('Please define FLUENTMAIL_ENGINEMAILER_API_KEY in wp-config.php file.', 'fluent-smtp');
            }
        }

        if ($errors) {
            $this->throwValidationException($errors);
        }
    }
}
