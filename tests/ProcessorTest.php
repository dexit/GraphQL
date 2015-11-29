<?php
/*
* This file is a part of graphql-youshido project.
*
* @author Alexandr Viniychuk <a@viniychuk.com>
* created: 11/28/15 2:02 AM
*/

namespace Youshido\Tests;


use Youshido\GraphQL\Schema;
use Youshido\GraphQL\Type\Object\ObjectType;
use Youshido\GraphQL\Validator\Validator;
use Youshido\GraphQL\Processor;

class ProcessorTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        require_once __DIR__ . '/../vendor/autoload.php';
    }

    public function testProcessor()
    {
        $schema = new Schema(
            [
                'query' => new ObjectType(
                    [
                        'name'   => 'OneFileQuery',
                        'fields' => [
                            'users' => new ObjectType([
                                  'name' => 'users',
                                  'fields' => [
                                      'id'  => ['type' => 'int'],
                                      'name'  => ['type' => 'string']
                                  ],
                                  'resolve' => function() {
                                      return [
                                          'id' => 1,
                                          'name' => 'Alex'
                                      ];
                                  }
                              ])
                        ]
                    ])
            ]);

        $queryString = '{ users { name } }';

        $validator = new Validator();
        $processor = new Processor($validator);

        $processor->setSchema($schema);
        $processor->processQuery($queryString);

        print_r($processor->getResponseData());

    }

}
