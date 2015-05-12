<?php

namespace Expressly\Entity;

class Cart
{
    protected $productCode;
    protected $coupon;

    public function getProductCode()
    {
        return $this->productCode;
    }

    public function setProductCode($code)
    {
        $this->productCode = $code;

        return $this;
    }

    public function getCoupon()
    {
        return $this->coupon;
    }

    public function setCoupon($coupon)
    {
        $this->coupon = $coupon;

        return $this;

    }
}