<?php

class ClassCarrinho
{
    
    private $id;
    private $name;
    private $price;

    public function __construct()
    {
        session_start();
    }

    public function getId(){return $this->id;}
    public function setId($id): void{$this->id = $id;}
    public function getName(){return $this->name;}
    public function setName($name): void{$this->name = $name;}
    public function getPrice(){return $this->price;}
    public function setPrice($price): void{$this->price = $price;}


    //Adicionar os produtos
    public function addProducts()
    {
        if(isset($_SESSION['products']) && array_key_exists($this->getId(),$_SESSION['products'])){
            $_SESSION['products'][$this->getId()]['quantity']+=1;
        }else{
            $_SESSION['products'][$this->getId()]=[
                'id'=>$this->getId(),
                'name'=>$this->getName(),
                'price'=>$this->getPrice(),
                'quantity'=>1
            ];
        }
    }

     //Listar os produtos do carrinho
     public function listProducts()
     {
         $html="";
         if(isset($_SESSION['products'])){
             foreach ($_SESSION['products'] as $product) {
                 $html.="<tr>";
                 $html.="<td>".$product['id']."</td>";
                 $html.="<td>".$product['name']."</td>";
                 $html.="<td>".$product['quantity']."</td>";
                 $html.="<td>".number_format(($product['quantity']*$product['price']),2,',','.')."</td>";
                 $html.="</tr>";
             }
         }
         return $html;
     }

     //Pega o valor total da compra
     public function getAmount()
     {
         $amount=0;
         if(isset($_SESSION['products'])){
           foreach ($_SESSION['products'] as $product){
               $amount+=$product['quantity']*$product['price'];
           }
     }
        return $amount;
    }

    //limpar carrinho
    public function clearCart()
    {
        unset($_SESSION['products']);
    }
}
