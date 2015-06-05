<?php

namespace Expressly\Provider;

use Expressly\Entity\Merchant;
use Silex\Application;

class MerchantProvider implements MerchantProviderInterface
{
    private $db;
    private $logger;
    private $table;
    private $merchant;

    public function __construct(Application $app, $config = array(), $table = null)
    {
        $this->db = $app['db'];
        $this->logger = $app['logger'];
        $this->table = !is_null($table) ? $table : $app['config']['table']['merchant'];
        $this->merchant = new Merchant();
    }

//    private function firstOrCreate()
//    {
//        $merchant = new Merchant();
//
//        try {
//            $getQuery = sprintf('SELECT * FROM %s LIMIT 1', $this->table);
//            $statement = $this->db->prepare($getQuery);
//            $statement->execute();
//
//            $result = $statement->fetch(\PDO::FETCH_ASSOC);
//
//            if (empty($result)) {
//                $merchant->setPassword(Merchant::createPassword());
//                $password = $merchant->getPassword();
//
//                $insertQuery = sprintf('INSERT INTO %s (`password`) VALUES (:password)', $this->table);
//                $statement = $this->db->prepare($insertQuery);
//                $statement->bindParam(':password', $password);
//                $statement->execute();
//
//                $result = $statement->fetch(\PDO::FETCH_ASSOC);
//            }
//
//            $merchant->setId($result['id'])
//                ->setHost($result['host'])
//                ->setPassword($result['password'])
//                ->setOffer($result['offer'])
//                ->setDestination($result['destination']);
//        } catch (\PDOException $e) {
//            $this->logger->addError($e);
//        }
//
//        return $merchant;
//    }

    public function getMerchant()
    {
        return $this->merchant;
    }

    public function setMerchant(Merchant $merchant)
    {
        if (!Merchant::compare($this->merchant, $merchant)) {
            $this->save($merchant);
        }

        return $this;
    }

    private function save(Merchant $merchant)
    {
        if (empty($this->merchant)) {
            return;
        }

        try {
            $saveQuery = sprintf(
                'INSERT INTO %s (`id`, `uuid`, `shop_name`, `host`, `path`, `password`, `offer`, `destination`, `policy`, `terms`, `image`)
                VALUES (:id, :uuid, :shop_name, :host, :path, :password, :offer, :destination, :policy, :terms, :image)
                ON DUPLICATE KEY UPDATE `uuid`=VALUES(`uuid`), `name`=VALUES(`name`), `host`=VALUES(`host`), `path`=VALUES(`path`),
                `password`=VALUES(`password`), `offer`=VALUES(`offer`), `destination`=VALUES(`destination`), `policy`=VALUES(`policy`),
                `terms`=VALUES(`terms`), `image`=VALUES(`image`);',
                $this->table
            );
            $statement = $this->db->prepare($saveQuery);
            $statement->bindParam('id', $merchant->getId());
            $statement->bindParam('uuid', $merchant->getUuid());
            $statement->bindParam('shop_name', $merchant->getName());
            $statement->bindParam('host', $merchant->getHost());
            $statement->bindParam('path', $merchant->getPath());
            $statement->bindParam('password', $merchant->getPassword());
            $statement->bindParam('offer', $merchant->getOffer());
            $statement->bindParam('destination', $merchant->getDestination());
            $statement->bindParam('policy', $merchant->getPolicy());
            $statement->bindParam('terms', $merchant->getTerms());
            $statement->bindParam('image', $merchant->getImage());
            $statement->execute();

            $this->merchant = $merchant;
        } catch (\PDOException $e) {
            $this->logger->addError($e);
        }
    }
}