<?php

namespace App;

class Cart
{
    public $items=null;
    public $totalQuantity=0;
    public $totalPrice=0;

    public function __construct($oldcart){
        if($oldcart){
            $this->items=$oldcart->items;
            $this->totalQuantity=$oldcart->totalQuantity;
            $this->totalPrice=$oldcart->totalPrice;
        }
    }

    public function add($item,$id){
        $storedItem=['quantity'=>0,'price'=>$item->purchase_price,'item'=>$item];
        if($this->items){
            if(array_key_exists($id,$this->items)){
                $storedItem=$this->items[$id];
            }
        }
        $storedItem['quantity']++;
        $storedItem['price']=$item->purchase_price * $storedItem['quantity'];
        $this->items[$id]=$storedItem;
        $this->totalQuantity++;
        $this->totalPrice=$this->totalPrice+$item->purchase_price;
    }
}
