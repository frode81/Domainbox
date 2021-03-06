<?php

namespace MadeITBelgium\Domainbox\TLDs;

/**
 * Domainbox API.
 *
 * @version    1.0.0
 *
 * @copyright  Copyright (c) 2017 Made I.T. (http://www.madeit.be)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
class Qa extends TLD
{
    protected $tld = '.qa';
    protected $idnTLD = 'qa';
    protected $dnsName = 'qa';

    protected $periods = [1, 2, 3, 4, 5];
    protected $fee_registry = 30;
    protected $fee_renew = 30;
    protected $fee_transfer = 30;
    protected $fee_domainbox = 5;
    protected $fee_icann = 0;
    protected $fee_setup = 0;
    protected $fee_application = 0;
    protected $fee_total = 35;
    protected $fee_restore = null;
    protected $fee_backorder = null;

    protected $type = 'ccTLD';

    protected $applyLock = true;
    protected $applyPrivacy = true;
    protected $numberOfNameServers = 13;
    protected $dnssec = false;
    protected $ipv6 = true;
    protected $ipv4 = true;

    protected $refund = false;
    protected $refundPeriodAdd = 3;
    protected $refundPeriodTransfer = 0;
    protected $refundPeriodRenew = 30;
    protected $refundLimit = 10;

    public function __construct()
    {
        parent::__construct();
    }
}
