<?php


namespace App\Service;


use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class InvoiceService
{
    public function __construct(ContainerInterface $container, LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

}
