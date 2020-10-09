# Sistema de venta de entradas para películas (MoviePass)
Proyecto final para las materias *Laboratorio 4* y *Metodología de Sistemas*, de la carrera *Tecnicatura Universitaria en Programación*, **UTN**.

[![UTN:MdP](https://img.shields.io/badge/UTN-MdP-blue.svg)](http://mdp.utn.edu.ar/)

Este trabajo es parte de un examen, por lo que no se permiten colaboraciones externas, pero cualquier sugerencia es bienvenida.


### El equipo

@[Fran](https://github.com/frangrande91), @[Maxi](https://github.com/maxi2991), y @[Jorge](https://github.com/JorgePiaggio).


## Consigna

### Requisitos Funcionales

Una empresa que se dedica a organizar y vender entradas de cine nos solicita el desarrollo de un software que les permita a sus clientes comprar la entrada para una película en un determinado cine
a través de un sitio web. Los clientes se deben registrar con su email y una clave. También debe existir la posibilidad de registrarse vía su cuenta de Facebook.

* El cliente (C) podrá realizar las siguientes actividades:
1. Consultar películas por fecha y/o categoría.
2. Seleccionar una película para su compra. A continuación se visualizarán los cines donde se
proyecta con sus horarios (solo aquellos que tengan aún entradas disponibles). Una vez seleccionado horario y cine se deben detallar la cantidad de entradas a comprar, visualizando el total de la compra.
La compra sólo podrá realizarse con tarjeta de crédito, mediante un proceso que solicitará la autorización del pago a la corresp. Cia de crédito (Visa ó Master)
Al recibir la autorización del pago, el sistema genera las entradas, enviando una copia al email. Cada entrada tendrá un número y un código QR que permitirá ingresar al cine (entrada individual).
Existe una política de descuento en el sitio que consiste en cobrar 25% menos el valor de las entradas los días martes y miércoles, debiendo al menos comprar 2 entradas.
3. Consultar las entradas adquiridas, ordenadas por película ó por fecha.

* El administrador (A) podrá realizar las siguientes actividades:
1. Ingresar películas a la cartelera del cine con sus días y horarios de proyección.
2. Administrar cines. Cada registro debe tener el nombre del cine, su capacidad total, dirección y valor único de entrada.
3. Consultar cantidades vendidas y remanentes de las proyecciones (Película, Cine, Turno).
4. Consultar totales vendidos en pesos (por película ó por cine, entre fechas).

## Requisitos No Funcionales
Programación en capas de la aplicación respetando la arquitectura de 3 capas lógicas vista durante
la cursada. Esto implica el desarrollo de las clases que representen las entidades del modelo y
controladoras de los casos de uso, las vistas y la capa de acceso a datos.
El acceso a las películas y categorías (temas) de las mismas será efectuado a través del uso de una
API pública del sitio [TheMovieDb](https://www.themoviedb.org), donde el alumno deberá crearse una
cuenta y asi obtener la Api Key necesaria para acceder a los recursos detallados en https://developers.themoviedb.org/3. 
De alli usaremos los GET:

```- movie/now_playing : retorna la lista de películas actuales```

```- genre/movie/list : retorna la lista de géneros (temas)```

## Implementación mínima para la aprobación:
1. Revisión
 - Administrar Cines (A- Item b, con dao en memoria)
 - Consulta de películas actuales (C- Item a - get de la api)
2. Revisión
 - Ingresar películas a la cartelera del cine junto con los días y horarios de exhibición (A - item a)
 – Agregar a 1.2 los filtros por categoría (temas) y fechas
3. Revisión
 - Seleccionar y comprar entradas para una proyección de película determinada (C – item b, sin
pago ni descuentos)
