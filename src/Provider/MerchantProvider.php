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
        $this->merchant = $this->firstOrCreate();
    }

    private function firstOrCreate()
    {
        $merchant = new Merchant();

        try {
            $getQuery = sprintf('SELECT * FROM %s LIMIT 1', $this->table);
            $statement = $this->db->prepare($getQuery);
            $statement->execute();

            $result = $statement->fetch(\PDO::FETCH_ASSOC);

            if (empty($result)) {
                $merchant->setPassword(Merchant::createPassword());
                $password = $merchant->getPassword();

                $insertQuery = sprintf('INSERT INTO %s (`password`) VALUES (:password)', $this->table);
                $statement = $this->db->prepare($insertQuery);
                $statement->bindParam(':password', $password);
                $statement->execute();

                $result = $statement->fetch(\PDO::FETCH_ASSOC);
            }

            $merchant->setId($result['id'])
                ->setHost($result['host'])
                ->setPassword($result['password'])
                ->setOffer($result['offer'])
                ->setDestination($result['destination']);
        } catch (\PDOException $e) {
            $this->logger->addError($e);
        }

        return $merchant;
    }

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

    private function save(Merchant $new)
    {
        if (empty($this->merchant)) {
            return;
        }

        try {
            $saveQuery = sprintf(
                'UPDATE %s SET `host`=:host, `password`=:password, `offer`=:offer, `destination`=:destination WHERE `id`=:id',
                $this->table
            );
            $statement = $this->db->prepare($saveQuery);
            $statement->bindParam('host', $new->getHost());
            $statement->bindParam('password', $new->getPassword());
            $statement->bindParam('offer', $new->getOffer());
            $statement->bindParam('destination', $new->getDestination());
            $statement->bindParam('id', $this->merchant->getId());
            $statement->execute();

            $this->merchant = $new;
        } catch (\PDOException $e) {
            $this->logger->addError($e);
        }
    }
}