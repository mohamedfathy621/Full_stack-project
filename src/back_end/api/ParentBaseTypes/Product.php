<?php
require_once __DIR__ . '/../BaseTypes/NestedType.php'; 
use GraphQL\Type\Definition\Type;
abstract class Product extends NestedType{
    public function __construct(mysqli $connection,array $baseTypes) {
        parent::__construct($connection,'Product',$baseTypes); // Only pass the name
    }
    protected function getConf() {
        // it uses a NestedType class Price and attributeSet and a BaseType Gallerytype
        $pricetype = $this->baseTypes['PriceType'];
        $gallerytype = $this->baseTypes['GalleryType'];
        $attributeSetType = $this->baseTypes['AttributesetType'];
        return [
            'productId'  => Type::nonNull(Type::id()),
            'name' => Type::nonNull(Type::String()),
            'brand'  =>  Type::nonNull(Type::String()),
            'categoryId' => Type::nonNull(Type::String()),
            'inStock' =>  Type::nonNull(Type::boolean()),
            'description' => Type::nonNull(Type::String()),
            //each NestedType and BaseType is resolved in it's own Class 
            'price' => [
                    'type' => Type::listOf($pricetype),
                    'resolve' =>function ($Product) use ($pricetype) {
                    return $pricetype->resolvePrice($Product['productId']); // Call the resolveCurrency method
                    },
            ],
            'gallery' => [
                'type' => Type::listOf($gallerytype),
                'resolve' =>function ($Product) use ($gallerytype) {
                    return $gallerytype->resolveGallery($Product['productId']); // Call the resolveCurrency method
                 },
           ],
            'attributeset' =>[
                'type' => Type::listOf($attributeSetType),
                'resolve' =>function ($Product) use ($attributeSetType) {
                    return $attributeSetType->resolveAttributeset($Product['productId']);
                }
            ]
            
        ];
    }
}

?>