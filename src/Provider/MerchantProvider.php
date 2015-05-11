<?php

namespace Expressly\Provider;

use Expressly\Entity\Merchant;
use Silex\Application;

class MerchantProvider implements MerchantProviderInterface
{
    private $em;
    private $merchant;

    public function __construct(Application $app)
    {
        $this->em = $app['orm.em'];
        $meta = $this->em->getClassMetadata('Expressly\Entity\Merchant');
        $meta->setTableName($app['config']['table']['merchant']);

        $merchant = $this->em->getRepository('Expressly\Entity\Merchant')->findOneBy(array());

        $this->merchant = $merchant ?: new Merchant();
    }

    public function getMerchant()
    {
        return $this->merchant;
    }

    public function setMerchant(Merchant $merchant)
    {
        if ($this->merchant->getId() != $merchant->getId()) {
            $this->em->remove($this->merchant);
        }

        $this->em->persist($merchant);
        $this->em->flush();

        $this->merchant = $merchant;
    }
}