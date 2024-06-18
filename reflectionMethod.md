````php
<?php
// example code]
$classesArquivos = [
    "TipoDiferente"
];

$post = [
    "dado" => "2reais",
    "arr"  => "array"
];
class TipoDiferente 
{
    public  $dado;
    public  $arr; 
}
class Classe 
{
    public $nome ;
    public $idade;

    public function funcaoArgumento(TipoDiferente $argumento) 
    {
        var_dump("a de amor");
    }
}

$classInstance = new Classe();

//var_dump(array_keys(get_object_vars($classInstance)) );

$reflected = new ReflectionMethod(Classe::class, "funcaoArgumento");

$params = $reflected->getParameters();
$args = [];
foreach($params as $param)
{   
    $type = $param->getType();
    $typeName = array_search( $type->getName(), $classesArquivos,);
    
    $typeName = $classesArquivos[$typeName];
    var_dump($typeName);

    if (!$type->isBuiltin() && $typeName) 
    {
        $instance = new $typeName;

        //para obter as (propriedades) do objeto é necessário passar uma instancia da classe
        $toArr = get_object_vars($instance);

        $keys = array_keys($toArr);
        foreach ($keys as $key) 
        {
            $instance->$key = $post[$key];
        }
        $args[] = $instance;
    }
}
var_dump($args);