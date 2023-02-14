<?php

require __DIR__ . '/../vendor/autoload.php';

use app\shared\FieldsValidator;

class User{

    public function bootstrap(int $id, string $name, string $email, string $document){
        $fields = [
            'id' => ['value' => $id, 'type' => 'int', 'nullable' => false],
            'name' => ['value' => $name, 'type' => 'string', 'min' => 5, 'max' => 200, 'nullable' => false],
            'email' => ['value' => $email, 'type' => 'string', 'min' => 4, 'max' => 200, 'nullable' => false],
            'document' => ['value' => $document, 'type' => 'string', 'min' => 4, 'max' => 200, 'nullable' => false]
        ];

        try{
            $f = new FieldsValidator($fields);
            $f->object($this);
        }catch(Exception $e){
            echo $e->getMessage() . "\n\n";
        }
    }

    public function find(int $id) :? User {
        $data = new stdClass();
        $data->id = 2;
        $data->nome = 'Lucas Awade';
        $data->email = 'lucasawade@gmail.com';
        $data->document = 'Administrador';
        return $data;
    }
}



try{
    $user = new User();
    $user->bootstrap(2, 'Lucas Awade', 'lucasawade@gmail.com', 'Administrador');
    print_r($user->id);
} catch (Exception $e){
    echo $e->getMessage() . "\n\n";
}

?>