<?php
// 1. Defina qué es un Array en simples palabras
// R: Un array es una estructura de datos que almacena una colección de elementos, cada uno con una clave o índice único. En PHP, los arrays pueden contener valores de diferentes tipos de datos y pueden ser indexados por números o cadenas.

// 2. Realice una comparación entre los framework de PHP Laravel y Cake 
// R: Laravel y CakePHP son un framework de PHP que proporciona una capa de abstracción entre el desarrollador y el servidor web, permitiendo a los desarrolladores crear aplicaciones web rápidamente y de forma eficiente. Ambos frameworks son populares entre los desarrolladores de PHP y ofrecen una gran cantidad de características y herramientas para facilitar el desarrollo de aplicaciones web. Sin embargo, Laravel es más moderno y flexible que CakePHP, y ofrece una mayor cantidad de características y herramientas para facilitar el desarrollo de aplicaciones web. Además, Laravel es más fácil de aprender y usar que CakePHP, lo que lo hace más popular entre los desarrolladores de PHP. Por tanto, Laravel es una opción más recomendable que CakePHP para desarrollar aplicaciones web en PHP.

// 3. Genere las líneas de código para crear un array bidimensional para generar tabla de la  siguiente imagen 
// R:
$array = [
    ["Nombre", "Edad", "Ciudad"],
    ["Juan", 25, "Madrid"],
    ["María", 30, "Barcelona"],
    ["Luis", 35, "Valencia"]
];

echo "<table border='1'>";
foreach ($array as $row) {
    echo "<tr>";
    foreach ($row as $cell) {
        echo "<td>" . htmlspecialchars($cell) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";

// 4. Dado el siguiente contexto, explique con sus palabras como optimizaría la  siguiente codificación 
$desde = $this -> data['Fecha']['DESDE'];
$hasta = $this -> data['Fecha']['HASTA'];

$motivos = $this -> licencias -> query("SELECT * FROM LICENCIAS WHERE FECHA_INICIO BETWEEN '$desde' AND '$hasta' ");

foreach($motivos as $n => $persona){
    $fun  = $this -> funcionario -> find('all', array(
        'conditions' => array(
        'FUN_RUT' => (string)(int)$persona['LICENCIAS']['FUN_RUT'], 'FUN_RUT' => $cc)
    ));

    if(count($fun)>0){
        $motivos[$n]['fun'] = $fun;
    }else{
        unset($motivos[$n]);
    }
}
$this->set('resultado', $motivos);
// Contexto: 
// Se requiere mejorar los tiempos de respuesta de un reporte que trae datos de licencias médicas, este  reporte trae muchos datos de la base de datos entre ellos datos licencias y de funcionarios, al indagar en  el código el programador se da cuenta de que los datos son extraídos a través de query en sql y  almacenadas en un array, posterior a esto se realiza una iteración (ciclo foreach) y dentro de dicha iteración  se realizan nuevas consultas sql y condiciones lógicas para dar valor a ciertas variables. Una vez finalizado  el ciclo se guarda todo lo procesado y se presenta la data en pantalla.

// R:
// Consulta optimizada en:
// - SQL Unificada : ya no itera en los resultados de LICENCIAS para obtener los datos de FUNCIONARIOS de forma separada
// - RIGHT JOIN : trae en universo de datos posibles de LICENCIAS que si esten asociadas a un FUNCIONARIO
// - Procesamiento : la consulta es capaz de traer los resultados esperados, ya no se usa memoria adicional en php en iteraciones extras
// - INFORMACION RELEVANTE : no es necesario mostrar todos los atributos de las tablas, sino los que necesito
$desde = $this->data['Fecha']['DESDE'];
$hasta = $this->data['Fecha']['HASTA'];
$motivos = $this->licencias->query("
    SELECT LICENCIAS.FECHA_INICIO, LICENCIAS.NUMERO, LICENCIAS.MOTIVO, FUNCIONARIO.FUN_RUT, FUNCIONARIO.FUN_NOMBRE
    FROM  LICENCIAS 
    INNER JOIN FUNCIONARIO ON LICENCIAS.FUN_RUT = FUNCIONARIO.FUN_RUT 
    WHERE LICENCIAS.FECHA_INICIO BETWEEN '$desde' AND '$hasta'
");

$this->set('resultado', $motivos);

// 5. Resuelva el siguiente ejercicio 
// Se requiere trabajar con una matriz de 10 enteros, de la siguiente manera: [10, 20, 30, 40, 50, 60, 70, 80,  90, 100]. Escriba una función que reciba dos enteros como parámetros. La función devuelve la suma de los  elementos de la matriz que se encuentran entre esos dos enteros. Por ejemplo, si usamos 30 y 60 como  parámetros, la función debería devolver 180 (30 + 40 + 50 + 60).  
// Algunos requisitos adicionales: 
// ∙ Los dos enteros pasados a la función deben ser positivos, en caso contrario la función deberá  devolver -1. 
// ∙ Validar que el primer entero sea menor que el segundo entero. De lo contrario, la función deberá  devolver 0. 
// ∙ Si el primer entero está en la matriz y el segundo está por encima de 100, por ejemplo, 90 y 120,  entonces la función deberá devolver la suma de los enteros que están dentro de la matriz y entre  los rangos dados. En este caso, sería 190. 
// ∙ Si no se encuentran ambos enteros en la matriz, por ejemplo, 110 y 120, la función deberá devolver  0.

// R:
function sumarElementos($inicio, $fin) {
    $matriz = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
    // inicio y fin deben ser mayores a 0
    if ($inicio < 0 || $fin < 0) {
        return -1;
    }
    // inicio debe ser menor que fin siempre, de lo contrario retorna 0
    // dada esta misma condicion si inicio es  mayor a 100, fin deberia ser mayor a esto... por ende tambien retornaria 0
    if ($inicio > $fin) {
        return 0;
    }
    //recorrer la matriz y sumar cada valor que sea mayor o igual a inicio y menor o igual a fin
    $suma = 0;
    foreach ($matriz as $valor) {
        if ($valor >= $inicio && $valor <= $fin) {
            $suma += $valor;
        }
    }
    // retornar la suma
    return $suma;
}
//ejm
echo sumarElementos(30, 60); // Output: 180

// 6. Dado el siguiente contexto, genere un trozo de líneas de código PHP para dar  solución a lo planteado 
// Se requiere dar formato a un dato de un informe, este dato es la temperatura ambiente expresada en  grados Celsius, el problema es que a veces algunos digitadores no ingresan el dato. La idea es que la  temperatura aparezca en el PDF según las siguientes reglas: 
// ∙ Si la temperatura no fue ingresada el valor a mostrar será un guion medio (-) ∙ Si la temperatura ingresada es igual a 0 deberá mostrar '0,0 °C' y si es un entero deberá mostrar  el dato acompañado de ',0 °C' 
// ∙ Si la temperatura ambiente es menor a cero deberá mostrar el dato acompañado de 'ºC' 

// R:
function formatearTemperatura($temp) {
    //Si la temperatura no fue ingresada el valor a mostrar será un guion medio
    if ($temp === null) {
        return "-";
    }
    //Si la temperatura ingresada es igual a 0 deberá mostrar '0,0 °C'
    if ($temp == 0) {
        return "0,0 °C";
    }
    //si es un entero deberá mostrar  el dato acompañado de ',0 °C' 
    if (is_int($temp)) {
        return $temp . ",0 °C";
    }
    //Si la temperatura ambiente es menor a cero deberá mostrar el dato acompañado de 'ºC', siempre y cuando no caiga en las condiciones anteriores
    return $temp . " °C";
}
echo formatearTemperatura(-2);

?>