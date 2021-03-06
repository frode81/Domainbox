# API Support check domainbox.com for more information. (36/...)


| Endpoint                                | SDK Class::Function                             | Output            | Version |
|-----------------------------------------|-------------------------------------------------|-------------------|---------|
| CheckDomainAvailability                 | Domain::checkDomainAvailability()               | Domain            | 0.1.0   |
|                                         |                                                 |                   |         |
|                                         |                                                 |                   |         |
| CheckDomainAvailability                 | Domain::checkDomainAvailability()               | Domain            | 0.1.0   |
| CheckDomainAvailabilityPlus             | Domain::checkDomainAvailabilityPlus()           | Domain            | 0.1.0   |
| RegisterDomain                          | Domain::registerDomain()                        | Domain            | 0.1.0   |
| RenewDomain                             | Domain::renewDomain()                           | Domain            | 0.1.0   |
| DeleteDomain                            | Domain::deleteDomain()                          | Domain            | 0.1.0   |
| CheckDomainDeleteRefund                 |                                                 |                   |         |
| UnrenewDomain                           |                                                 |                   |         |
| CreateDomainAuthcode                    |                                                 |                   |         |
| ResendDomainVerificationEmail           | Domain::resendDomainVerificationEmail()         | Boolean           | 0.4.0   |
| CheckDomainClaims                       |                                                 |                   |         |
|                                         |                                                 |                   |         |
| CreateTrademark                         |                                                 |                   | 0.7.0   |
| QueryTrademark                          |                                                 |                   | 0.7.0   |
| QueryTrademarkLabels                    |                                                 |                   | 0.7.0   |
| QueryTrademarkSMD                       |                                                 |                   | 0.7.0   |
| ModifyTrademark                         |                                                 |                   | 0.7.0   |
|                                         |                                                 |                   |         |
| CreateContact                           | Contact::createContact()                        | Contact           | 0.1.0   |
| ModifyContact                           | Contact::modifyContact()                        | Contact           | 0.1.0   |
| QueryContact                            | Contact::queryContact()                         | Contact           | 0.1.0   |
| DeleteContact                           | Contact::deleteContact()                        | Boolean           | 0.1.0   |
|                                         |                                                 |                   |         |
| ModifyDomainContacts                    | Domain::modifyDomainContacts()                  | Domain            | 0.4.0   |
| ModifyDomainNameservers                 |                                                 |                   |         |
| ModifyDomainAuthcode                    | Domain::modifyDomainAuthcode()                  | Domain            | 0.4.0   |
| ModifyDomainLock                        | Domain::modifyDomainLock()                      | Boolean           | 0.4.0   |
| ModifyDomainRenewalSettings             | Domain::ModifyDomainRenewalSettings()           | Domain            | 0.4.0   |
| ModifyDomainPrivacy                     | Domain::ModifyDomainPrivacy()                   | Boolean           | 0.4.0   |
| ModifyDomainTelCredentials              |                                                 |                   |         |
| ModifyDomainMemberContact               |                                                 |                   |         |
| ModifyDomainAdditionalData              |                                                 |                   |         |
| ModifyDomainStatus                      |                                                 |                   |         |
| ModifyDomainProxy                       |                                                 |                   |         |
| ModifyDomainRecords                     | Domain::ModifyDomainRecords()                   | Boolean           | 0.4.0   |
|                                         |                                                 |                   |         |
| QueryDomainAuthcode                     | Domain::queryDomainAuthCode()                   | Domain            | 0.4.0   |
| QueryDomain                             | Domain::queryDomain()                           | Domain            | 0.1.0   |
| QueryDomainLock                         | Domain::queryDomainLock()                       | Domain            | 0.4.0   |
| QueryDomainRenewalSettings              | Domain::queryDomainRenewalSettings()            | Domain            | 0.4.0   |
| QueryDomainDates                        | Domain::queryDomainDates()                      | Domain            | 0.4.0   |
| QueryDomainNameservers                  | Domain::queryDomainNameservers()                | Domain            | 0.4.0   |
| QueryDomainNameserverHosts              |                                                 |                   |         |
| QueryDomainContacts                     | Domain::queryDomainContacts()                   | Domain            | 0.4.0   |
| QueryDomainPrivacy                      | Domain::QueryDomainPrivacy()                    | Domain            | 0.4.0   |
| QueryDomainLaunch                       |                                                 |                   |         |
| QueryDomainTelCredentials               |                                                 |                   |         |
| QueryDomainMemberContact                |                                                 |                   |         |
|                                         |                                                 |                   |         |
| CreateNameserver                        | Nameserver::createNameserver()                  | Boolean           | 0.5.0   |
| ModifyNameserver                        | Nameserver::modifyNameserver()                  | Boolean           | 0.5.0   |
| DeleteNameserver                        | Nameserver::deleteNameserver()                  | Boolean           | 0.5.0   |
| QueryNameserver                         | Nameserver::queryNameserver()                   | Nameserver        | 0.5.0   |
| CreateExternalNameserver                | Nameserver::createNameserver()                  | Boolean           | 0.5.0   |
|                                         |                                                 |                   |         |
| CheckTransferAvailabilty                | Transfer::CheckTransferAvailabilty()            | Domain            | 0.6.0   |
| RequestTransfer                         | Transfer::transferDomain()                      | Domain            | 0.6.0   |
| QueryTransfer                           | Transfer::queryTransfer()                       | Domain            | 0.6.0   |
| CancelTransfer                          | Transfer::cancelTransfer()                      | Boolean           | 0.6.0   |
| ResendTransferAdminEmail                | Transfer::resendTransferAdminEmail()            | Domain            | 0.6.0   |
| RestartTransfer                         | Transfer::restartTransfer()                     | Boolean           | 0.6.0   |
| QueryTransferAway                       |                                                 |                   |         |
| CompleteTransferAway                    |                                                 |                   |         |
| RejectTransferAway                      |                                                 |                   |         |
| RequestTransferAway                     |                                                 |                   |         |
