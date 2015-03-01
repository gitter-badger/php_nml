<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Interface definition:  [NelsonMartell\Collections]  ICollection
 *
 * Copyright � 2015 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright � 2015 Nelson Martell
 * @link       http://nelson6e65.github.io/php_nml/
 * @since      v0.1.1
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Collections {
	use \Iterator;

	/**
	 * Define m�todos para manipular colecciones de objetos.
	 *
	 *
	 * @author  Nelson Martell (nelson6e65-dev@yahoo.es)
	 * */
	interface ICollection extends Iterator {

		/**
		 * Obtiene el n�mero de elementos incluidos en la colecci�n.
		 * Si extiende la clase NelsonMartell.Object, debe definirse la propiedad 'public $Count'.
		 *
		 *
		 * @see     NelsonMartell\Object
		 * @return  integer
		 * */
		public function get_Count();

		/**
		 * Agrega un elemento a la colecci�n.
		 *
		 *
		 * @param   mixed $item Objeto que se va a agregar.
		 * @return  void
		 * */
		public function Add($item);

		/**
		 * Quita todos los elementos de la colecci�n.
		 *
		 *
		 * La propiedad Count se debe establecer en 0 y deben liberarse las referencias a otros
		 * objetos desde los elementos de la colecci�n.
		 *
		 * @return  void
		 * */
		public function Clear();

		/**
		 * Determina si la colecci�n contiene un valor espec�fico.
		 *
		 *
		 * @param   mixed $item Objeto que se va a buscar.
		 * @return  boolean true si $item se encuentra; en caso contrario, false.
		 * */
		public function Contains($item);

		/**
		 * Quita la primera aparici�n de un objeto espec�fico de la colecci�n.
		 *
		 *
		 * @param   $item Objeto que se va a quitar.
		 * @return  boolean True si $item se ha quitado correctamente; en caso contrario, False.
		 *   Este m�todo tambi�n devuelve false si no se encontr� $item.
		 * */
		public function Remove($item);

	}
}
