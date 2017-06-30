<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use MadeITBelgium\Domainbox\Domainbox;
use MadeITBelgium\Domainbox\Object\Contact;
use MadeITBelgium\Domainbox\Object\Domain;

class DomainTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    //checkDomainAvailability
    public function testUnavailableDomain()
    {
        $domainbox = new Domainbox('reseller', 'username', 'password', false);

        // Create a mock and queue two responses.

        $stream = Psr7\stream_for('{"d": {"AvailabilityStatus": 1, "AvailabilityStatusDescr": "Unavailable", "LaunchPhase": "GA", "DropDate": "2017-01-01", "BackOrderAvailable": false, "AdditionalResults": {}, "LaunchStep": "", "ResultCode": 100, "ResultMsg": "Command Successful", "TxID": "1b68172f-ca79-4fc4-9a04-f15a17b6abfc"}}');
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], $stream),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $domainbox->setClient($client);
        $domain = $domainbox->domain();
        $response = $domain->checkDomainAvailability('madeit.be', 'GA');

        $this->assertEquals('Unavailable', $response->getStatus());
        $this->assertEquals(false, $response->isAvailable());
        $this->assertEquals(false, $response->canBackOrder());
        $this->assertEquals('2017-01-01', $response->getDropDate());
        $this->assertEquals('GA', $response->getLaunchPhase());
    }

    public function testUnavailableBackOrderDomain()
    {
        $domainbox = new Domainbox('reseller', 'username', 'password', false);

        // Create a mock and queue two responses.

        $stream = Psr7\stream_for('{"d": {"AvailabilityStatus": 1, "AvailabilityStatusDescr": "Unavailable", "LaunchPhase": "GA", "DropDate": "", "BackOrderAvailable": true, "AdditionalResults": {}, "LaunchStep": "", "ResultCode": 100, "ResultMsg": "Command Successful", "TxID": "1b68172f-ca79-4fc4-9a04-f15a17b6abfc"}}');
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], $stream),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $domainbox->setClient($client);
        $domain = $domainbox->domain();
        $response = $domain->checkDomainAvailability('madeit.be', 'GA');

        $this->assertEquals('Unavailable', $response->getStatus());
        $this->assertEquals(false, $response->isAvailable());
        $this->assertEquals(true, $response->canBackOrder());
    }

    public function testUnavailableOfflineDomain()
    {
        $domainbox = new Domainbox('reseller', 'username', 'password', false);

        // Create a mock and queue two responses.

        $stream = Psr7\stream_for('{"d": {"AvailabilityStatus": 8, "AvailabilityStatusDescr": "UnavailableUsingOfflineLookup", "LaunchPhase": "GA", "DropDate": "", "BackOrderAvailable": true, "AdditionalResults": {}, "LaunchStep": "", "ResultCode": 100, "ResultMsg": "Command Successful", "TxID": "1b68172f-ca79-4fc4-9a04-f15a17b6abfc"}}');
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], $stream),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $domainbox->setClient($client);
        $domain = $domainbox->domain();
        $response = $domain->checkDomainAvailability('madeit.be', 'GA', true);

        $this->assertEquals('UnavailableOfflineLookup', $response->getStatus());
        $this->assertEquals(false, $response->isAvailable());
        $this->assertEquals(true, $response->canBackOrder());
    }

    public function testAvailableOfflineDomain()
    {
        $domainbox = new Domainbox('reseller', 'username', 'password', false);

        // Create a mock and queue two responses.

        $stream = Psr7\stream_for('{"d": {"AvailabilityStatus": 7, "AvailabilityStatusDescr": "AvailableUsingOfflineLookup", "LaunchPhase": "GA", "DropDate": "", "BackOrderAvailable": false, "AdditionalResults": {}, "LaunchStep": "", "ResultCode": 100, "ResultMsg": "Command Successful", "TxID": "1b68172f-ca79-4fc4-9a04-f15a17b6abfc"}}');
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], $stream),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $domainbox->setClient($client);
        $domain = $domainbox->domain();
        $response = $domain->checkDomainAvailability('madeit.be', 'GA', true);

        $this->assertEquals('AvailableOfflineLookup', $response->getStatus());
        $this->assertEquals(true, $response->isAvailable());
        $this->assertEquals(false, $response->canBackOrder());
    }

    public function testAvailableDomain()
    {
        $domainbox = new Domainbox('reseller', 'username', 'password', false);

        // Create a mock and queue two responses.

        $stream = Psr7\stream_for('{"d": {"AvailabilityStatus": 0, "AvailabilityStatusDescr": "Available", "LaunchPhase": "GA", "DropDate": "", "BackOrderAvailable": false, "AdditionalResults": {}, "LaunchStep": "", "ResultCode": 100, "ResultMsg": "Command Successful", "TxID": "1b68172f-ca79-4fc4-9a04-f15a17b6abfc"}}');
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], $stream),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $domainbox->setClient($client);
        $domain = $domainbox->domain();
        $response = $domain->checkDomainAvailability('madeit.be', 'GA', true);

        $this->assertEquals('Available', $response->getStatus());
        $this->assertEquals(true, $response->isAvailable());
        $this->assertEquals(false, $response->canBackOrder());
    }

    //checkDomainAvailabilityPlus
    public function testUnavailableDomainPlus()
    {
        $domainbox = new Domainbox('reseller', 'username', 'password', false);

        // Create a mock and queue two responses.

        $stream = Psr7\stream_for('{
  "d": {
    "DomainCheck": {
      "ResultCode": 100,
      "ResultMsg": "Domain Check completed successfully",
      "Domains": [
        {
          "ResultCode": 100,
          "ResultMsg": "Command Successful",
          "DomainName": "madeit.be",
          "AvailabilityStatus": 1,
          "AvailabilityStatusDescr": "Unavailable",
          "LaunchPhase": "GA",
          "DropDate": "",
          "BackOrderAvailable": false,
          "LaunchStep": "",
          "AdditionalResults": {}
        },
        {
          "ResultCode": 100,
          "ResultMsg": "Command Successful",
          "DomainName": "madeit.com",
          "AvailabilityStatus": 1,
          "AvailabilityStatusDescr": "Unavailable",
          "LaunchPhase": "GA",
          "DropDate": "",
          "BackOrderAvailable": true,
          "LaunchStep": "",
          "AdditionalResults": {}
        },
        {
          "ResultCode": 100,
          "ResultMsg": "Command Successful",
          "DomainName": "madeit.nl",
          "AvailabilityStatus": 0,
          "AvailabilityStatusDescr": "Available",
          "LaunchPhase": "GA",
          "DropDate": "",
          "BackOrderAvailable": false,
          "LaunchStep": "",
          "AdditionalResults": {}
        }
      ]
    },
    "NameSuggestions": {
      "ResultCode": 500,
      "ResultMsg": "Name Suggestions failed. Unable to get name Suggestions"
    },
    "TypoSuggestions": {
      "ResultCode": 500,
      "ResultMsg": "Typo Suggestions failed. Unable to get Typo Suggestions"
    },
    "PrefixSuffixSuggestions": {
      "ResultCode": 500,
      "ResultMsg": "Suffix/Prefix Suggestions failed. Unable to get Suffix/Prefix Suggestions"
    },
    "PremiumDomains": {
      "ResultCode": 100,
      "ResultMsg": "Command Successful",
      "Domains": [
        {
          "DomainName": "madeitmine.com",
          "Price": "1495.00",
          "FastTransfer": true
        },
        {
          "DomainName": "madeitup.com",
          "Price": "6099.00",
          "FastTransfer": true
        },
        {
          "DomainName": "madeitmatter.com",
          "Price": "1895.00",
          "FastTransfer": true
        },
        {
          "DomainName": "madeiteasy.com",
          "Price": "3599.00",
          "FastTransfer": true
        },
        {
          "DomainName": "madeityet.com",
          "Price": "349.00",
          "FastTransfer": true
        },
        {
          "DomainName": "madeitfunny.com",
          "Price": "250.00",
          "FastTransfer": false
        },
        {
          "DomainName": "MadeItHappen.com",
          "Price": "2288.00",
          "FastTransfer": true
        },
        {
          "DomainName": "madeitright.com",
          "Price": "2695.00",
          "FastTransfer": false
        },
        {
          "DomainName": "madeitsimple.com",
          "Price": "899.00",
          "FastTransfer": false
        },
        {
          "DomainName": "madeitdesign.com",
          "Price": "877.00",
          "FastTransfer": false
        }
      ]
    },
    "ResultCode": 100,
    "ResultMsg": "The following items failed (Name Suggestions, Typo Suggestions, Suffix/Prefix Suggestions)",
    "TxID": "9fb8f585-c43e-4d29-8fae-86110cd89adc"
  }
}'); //ResultCode changed from 210
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], $stream),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $domainbox->setClient($client);
        $domain = $domainbox->domain();
        $response = $domain->checkDomainAvailabilityPlus('madeit.be');

        $this->assertEquals(3, count($response));

        $this->assertEquals('madeit.be', $response[0]->getDomainName());
        $this->assertEquals('Unavailable', $response[0]->getStatus());
        $this->assertEquals(false, $response[0]->isAvailable());
        $this->assertEquals(false, $response[0]->canBackOrder());

        $this->assertEquals('madeit.com', $response[1]->getDomainName());
        $this->assertEquals('Unavailable', $response[1]->getStatus());
        $this->assertEquals(false, $response[1]->isAvailable());
        $this->assertEquals(true, $response[1]->canBackOrder());

        $this->assertEquals('madeit.nl', $response[2]->getDomainName());
        $this->assertEquals('Available', $response[2]->getStatus());
        $this->assertEquals(true, $response[2]->isAvailable());
        $this->assertEquals(false, $response[2]->canBackOrder());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_UK()
    {
        //UK Domains
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.co.uk';
        $launchPhase = 'GA';
        $period = 1;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.co.uk',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                    'AdditionalData'     => ['UKAdditionalData' => ''],
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Extension'   => ['UKDirectData' => ['RelatedDomainId' => 0]],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'NS10'        => '',
                'NS11'        => '',
                'NS12'        => '',
                'NS13'        => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_US()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.us';
        $launchPhase = 'GA';
        $period = 1;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.us',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                    'AdditionalData'     => ['USAdditionalData' => ''],
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'NS10'        => '',
                'NS11'        => '',
                'NS12'        => '',
                'NS13'        => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_IM()
    {
        //IM Domains
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.im';
        $launchPhase = 'GA';
        $period = 3;
        $applyLock = false;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.im',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'NS10'        => '',
                'NS11'        => '',
                'NS12'        => '',
                'NS13'        => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_IN()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.in';
        $launchPhase = 'GA';
        $period = 1;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = true;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.in',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => true,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'NS10'        => '',
                'NS11'        => '',
                'NS12'        => '',
                'NS13'        => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_EU()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.eu';
        $launchPhase = 'GA';
        $period = 1;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = true;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.eu',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_BE()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.be';
        $launchPhase = 'GA';
        $period = 2;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = true;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.be',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_ES()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.es';
        $launchPhase = 'GA';
        $period = 6;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = true;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.es',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_AF()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.af';
        $launchPhase = 'GA';
        $period = 6;
        $applyLock = false;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.af',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'NS10'        => '',
                'NS11'        => '',
                'NS12'        => '',
                'NS13'        => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_TEL()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.tel';
        $launchPhase = 'GA';
        $period = 1;
        $applyLock = false;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.tel',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_AT()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.at';
        $launchPhase = 'GA';
        $period = 1;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 31;
        $applyPrivacy = true;
        $acceptTerms = false;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.at',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 30,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_NL()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.nl';
        $launchPhase = 'GA';
        $period = 2;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = true;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.nl',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'NS10'        => '',
                'NS11'        => '',
                'NS12'        => '',
                'NS13'        => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_TK()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.tk';
        $launchPhase = 'GA';
        $period = 10;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.tk',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_qA()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.qa';
        $launchPhase = 'GA';
        $period = 6;
        $applyLock = false;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.qa',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'NS10'        => '',
                'NS11'        => '',
                'NS12'        => '',
                'NS13'        => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_FR()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.fr';
        $launchPhase = 'GA';
        $period = 2;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = true;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.fr',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_DE()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.de';
        $launchPhase = 'GA';
        $period = 1;
        $applyLock = false;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = false;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.de',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Extension'   => ['DeBillingData' => ['MonthlyBilling' => false]],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'NS10'        => '',
                'NS11'        => '',
                'NS12'        => '',
                'NS13'        => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_MX()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.mx';
        $launchPhase = 'GA';
        $period = 6;
        $applyLock = false;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.mx',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_IT()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.it';
        $launchPhase = 'GA';
        $period = 2;
        $applyLock = false;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.it',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_CO_ZA()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.co.za';
        $launchPhase = 'GA';
        $period = 2;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = true;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.co.za',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_FM()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.fm';
        $launchPhase = 'GA';
        $period = 6;
        $applyLock = false;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.fm',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'NS10'        => '',
                'NS11'        => '',
                'NS12'        => '',
                'NS13'        => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_PL()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.pl';
        $launchPhase = 'GA';
        $period = 2;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = true;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.pl',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'NS10'        => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_IO()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.io';
        $launchPhase = 'GA';
        $period = 2;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.io',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'NS10'        => '',
                'NS11'        => '',
                'NS12'        => '',
                'NS13'        => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_JP()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.jp';
        $launchPhase = 'GA';
        $period = 2;
        $applyLock = true;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = true;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.jp',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Extension'   => ['JPProxyServiceData' => ['UseProxyService' => true]],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'NS10'        => '',
                'NS11'        => '',
                'NS12'        => '',
                'NS13'        => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    //register
    public function testRegisterGenerateDomainboxCommand_LV()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.lv';
        $launchPhase = 'GA';
        $period = 2;
        $applyLock = false;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.lv',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }

    /*
    //register
    public function testRegisterGenerateDomainboxCommand_()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.co.uk';
        $launchPhase = 'GA';
        $period = 1;
        $applyLock = false;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $this->assertEquals([
            'DomainName'    => 'maideit.co.uk',
            'LaunchPhase'   => 'GA',
            'Period'        => 1,
            'ApplyLock'     => false,
            'AutoRenew'     => true,
            'AutoRenewDays' => 7,
            'AcceptTerms'   => true,
            'ApplyPrivacy'  => false,
            'Contacts'      => [
                'Registrant' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Admin' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Billing' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
                'Tech' => [
                    'Name'               => 'Tjebbe Lievens',
                    'Organisation'       => 'Made I.T.',
                    'Street1'            => 'Somewhere in belgium',
                    'Street2'            => '',
                    'Street3'            => '',
                    'City'               => 'Geel',
                    'State'              => 'Antwerp',
                    'Postcode'           => '2440',
                    'CountryCode'        => 'BE',
                    'Telephone'          => '+32.123456789',
                    'TelephoneExtension' => '',
                    'Fax'                => '',
                    'Email'              => 'info@madeit.be',
                ],
            ],
            'Extension'   => ['UKDirectData' => ['RelatedDomainId' => 0]],
            'Nameservers' => [
                'NS1'         => 'ns1.madeit.be',
                'NS2'         => 'ns2.madeit.be',
                'NS3'         => '',
                'NS4'         => '',
                'NS5'         => '',
                'NS6'         => '',
                'NS7'         => '',
                'NS8'         => '',
                'NS9'         => '',
                'NS10'        => '',
                'NS11'        => '',
                'NS12'        => '',
                'NS13'        => '',
                'GlueRecords' => [],
            ],
        ], $registerDomain->generateDomainboxCommand());
    }
    */
    public function testRegisterCommand()
    {
        $contact = new Contact('Tjebbe Lievens', 'Made I.T.', 'Somewhere in belgium', null, null, 'Geel', 'Antwerp', '2440', 'BE', '+32.123456789', null, null, 'info@madeit.be');

        $registerDomain = new Domain();
        $domainName = 'maideit.be';
        $launchPhase = 'GA';
        $period = 1;
        $applyLock = false;
        $autoRenew = true;
        $autoRenewDays = 7;
        $applyPrivacy = false;
        $acceptTerms = true;
        $nameServers = ['ns1.madeit.be', 'ns2.madeit.be'];
        $glueRecords = [];
        $registrant = $contact;
        $admin = $contact;
        $tech = $contact;
        $billing = $contact;
        $trademark = null;
        $extension = null;
        $sunriseData = null;
        $commandOptions = null;
        $registerDomain->create($domainName, $launchPhase, $period, $applyLock, $autoRenew, $autoRenewDays, $applyPrivacy, $acceptTerms, $nameServers, $glueRecords, $registrant, $admin, $tech, $billing, $trademark, $extension, $sunriseData, $commandOptions);

        $domainbox = new Domainbox('reseller', 'username', 'password', false);

        // Create a mock and queue two responses.

        $stream = Psr7\stream_for('{"d": {"OrderId": 13477, "DomainId":24957, "RegistrantContactId": 12187, "AdminContactId": 12190, "TechContactId": 12190, "BillingContactId": 12187, "ResultCode": 100, "ResultMsg": "Command Successful", "TxID": "1b68172f-ca79-4fc4-9a04-f15a17b6abfc"}}');
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], $stream),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $domainbox->setClient($client);
        $domain = $domainbox->domain();
        $response = $domain->registerDomain($registerDomain);

        $this->assertEquals(13477, $response->getOrderId());
        $this->assertEquals(24957, $response->getDomainId());
        $this->assertEquals(12187, $response->getRegistrantContactId());
        $this->assertEquals(12190, $response->getAdminContactId());
        $this->assertEquals(12190, $response->getTechContactId());
        $this->assertEquals(12187, $response->getBillingContactId());
    }
}
