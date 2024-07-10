// 1. Transforme el siguiente mensaje en un array para que cada elemento sea una de estas  palabras.
const message = "Transforme el siguiente mensaje en un array para que cada elemento sea una de estas palabras.";
// R: dividir el string en substring con split indicando el separador. retorna un array
let array = message.split(" ");
console.log(array);

// 2. ¿Por qué el console.log no imprime el valor asignado a la variable? 
let variable = '10';
if(variable === 10){
    console.log(variable);
}
// R: Esto se debe a que === compara el valor y tambien el tipo de dato, en este caso el valor es 10, sin embargo el tipo de dato de variable es un string y en el if, la comparacion es entre un texto un un entero. Para comparaciones estrictas se recomienda hacerlo con valores del mismo tipo de datos.

// 3. Corrija y optimice el siguiente código 
/*
let imprimir = 0;
const algo = "";
if(!imprimir){
    algo =  "hola mundo";
}else{
    algo = "chao mundo";
}
console.log(algo);
*/
// R: Se puede optimizar el codigo de la siguiente manera -> cambiar el valor de imprimir de enteros a booleanos para validar por true or false, usar operador ternario para la asignacion
let imprimir = false;
let algo = !imprimir ? "hola mundo" : "chao mundo";
console.log(algo);

// 4. ¿Qué haría usted para que esta función (funcion_principal) imprima los números en orden  de menor a mayor
function funcion_principal(){
    console.log("1");
    console.log("2");
    funcion_secundaria<
    console.log("4")
}
function funcion_secundaria(){
    return new Promise((resolve,reject) => {
        setTimeout(() => {
            console.log("3")
            resolve();
        }, (1000));
    });
}
funcion_principal();

// R: convertir funcion_principal en async para que la ejecucion de funcion_secundaria espere hasta completarse su ejecucion para poder imprimir el ultimo console.log()
async function funcion_principal() {
    console.log("1");
    console.log("2");
    await funcion_secundaria();
    console.log("4");
}

function funcion_secundaria() {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            console.log("3");
            resolve();
        }, 1000);
    });
}

funcion_principal();

// R: (alternativa) -> manejar una funcion que encapsule el trabajo de ordenar un array de los numeros deseados
let numeros = [5, 2, 9, 1, 5, 6];

function imprimirNumeros(numeros) {
    numeros.sort((a, b) => a - b);
    console.log(numeros);
    return numeros;
}

imprimirNumeros(numeros);

/*
5. Para este ejercicio se le solicita crear un json que contenga los siguientes elementos: 
1) Arreglo de 3 objetos (identifíquelo como funcionarios) con los 3 atributos y valores listados a  continuación: 
∙ nombre: string. (Sebastián, Cristian, Nicole) 
∙ edad: number. (32, 21, 7) 
∙ vacunado: boolean. (true, false, true) 
2) Empresa: string. (IDIEM) */

let datos = {
    funcionarios: [
        { nombre: "Sebastián", edad: 32, vacunado: true },
        { nombre: "Cristian", edad: 21, vacunado: false },
        { nombre: "Nicole", edad: 7, vacunado: true }
    ],
    empresa: "IDIEM"
};

console.log(JSON.stringify(datos, null, 2));

/*
6. Según el ejercicio anterior y en base a sus conocimientos en manipulación de arreglos, se  solicita realizar las siguientes operaciones de la forma más eficiente posible. No puede usar  foreach ni for, y además no está permitido repetir funciones, a menos que el ejercicio indique  lo contrario. No puede trabajar con los índices del arreglo. Imagine que es una base de datos  amplia donde no conoce todos los valores de los registros que contienen. 
1) Retornar todos los funcionarios que estén vacunados y tengan una edad sobre 18. 2) Retornar el nombre del primer funcionario que no esté vacunado. 
3) Retornar el arreglo con el atributo empresa dentro de cada registro del arreglo. 4) Retornar sumatoria de edades de los registros del arreglo de funcionarios. 5) Buscar y modificar la edad del primer funcionario con nombre Nicole, sumándole 10 (En este  
ejercicio puede repetir funciones ya usadas anteriormente. Debe modificar el json inicial, no  está permitido generar uno nuevo)
*/
// 1) Retornar todos los funcionarios que estén vacunados y tengan una edad sobre 18.
let vacunadosMayoresDe18 = datos.funcionarios.filter(funcionario => funcionario.vacunado && funcionario.edad > 18);
console.log(vacunadosMayoresDe18);

// 2) Retornar el nombre del primer funcionario que no esté vacunado.
let primerNoVacunado = datos.funcionarios.find(funcionario => !funcionario.vacunado).nombre;
console.log(primerNoVacunado);

// 3) Retornar el arreglo con el atributo empresa dentro de cada registro del arreglo.
let funcionariosConEmpresa = datos.funcionarios.map(funcionario => ({ ...funcionario, empresa: datos.empresa }));
console.log(funcionariosConEmpresa);

// 4) Retornar sumatoria de edades de los registros del arreglo de funcionarios.
let sumatoriaEdades = datos.funcionarios.reduce((sum, funcionario) => sum + funcionario.edad, 0);
console.log(sumatoriaEdades);

// 5) Buscar y modificar la edad del primer funcionario con nombre Nicole, sumándole 10.
let modificarEdad = (nombrePersona) => {
    let persona = datos.funcionarios.find(funcionario => funcionario.nombre === nombrePersona);
    if (persona) {
        persona.edad += 10;
        console.log(`${persona.nombre} ahora tiene ${persona.edad}`)
    }else{
        console.log(`No se encontró a ${nombrePersona} en la lista de funcionarios`);
    }
};
modificarEdad("Nicole");
console.log(datos);