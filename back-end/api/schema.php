<?php

require '/home/vol9_5/infinityfree.com/if0_37279313/htdocs/learit/vendor/autoload.php';
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Error\Error;
use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
require_once 'queryType.php';



class trying {
    static protected $queryType;
    static protected  $mutationType;
    static protected $connection;
    static public function handle() {
        self::$connection = new mysqli('sql309.infinityfree.com', 'if0_37279313', 'ZqvEM9UYTo9JT', 'if0_37279313_project');
        self::$queryType = new QueryType(self::$connection);
        self::$mutationType = new MutationType(self::$connection);
        try {
            $schema = new Schema(
                (new SchemaConfig())
                ->setQuery(self::$queryType)
                ->setMutation(self::$mutationType)
            );
        
            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }
        
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;
        
            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();
        } catch (Throwable $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
        
    }
};
?>