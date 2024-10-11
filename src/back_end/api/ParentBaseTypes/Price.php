<?php
require_once __DIR__ . '/../BaseTypes/NestedType.php'; 
use GraphQL\Type\Definition\Type;
abstract class Price extends NestedType{
    public function __construct(mysqli $connection,array $baseTypes) {
        parent::__construct($connection,'Price',$baseTypes); // it is configured using the mysql connection and an array of Types used in it
    }
    //the config of the Price class 
    protected function getConf() {
        $currencyType = $this->baseTypes['currencyType']; // as price has a Nested BaseType of currency it is passed from the main function
        return [
            'amount' => Type::nonNull(Type::float()), 
            'currency' =>[ 
                'type' =>   Type::nonNull($currencyType),
                'resolve' =>function ($price) use ($currencyType) {
                    // here Price class leverage the resolver of currency type 
                    return $currencyType->resolveCurrency($price['id']); // Call the resolveCurrency method
                }
                ] ,
            'currencyId' => Type::nonNull(Type::String())
        ];
    }
}

?>