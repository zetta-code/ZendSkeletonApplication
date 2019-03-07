<?php
/**
 * @link      http://github.com/zetta-code/zend-skeleton-application for the canonical source repository
 * @copyright Copyright (c) 2018 Zetta Code
 */

namespace Application\Enum;

class Translate
{
    function __invoke()
    {
        return [
            _('Available'),
            _('Canceled'),
            _('Confirm'),
            _('Done'),
            _('Missing'),
            _('Rescheduled'),
            _('Reserved'),

            _('api'),
            _('Super'),
            _('Admin'),
            _('Legal'),
            _('Patient'),
            _('Member'),
            _('Guest'),
        ];
    }
}
