<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Class definition:  [NelsonMartell]  IntString
 *
 * Copyright © 2015 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright © 2015 Nelson Martell
 * @link       http://nelson6e65.github.io/php_nml/
 * @since      v0.1.1
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell {

	/**
	 * Representa un elemento mixto, compuesto por un entero y una cadena unidos (en ese orden).
	 * El método ToString obtiene esa cadena compuesta.
	 *
	 *
	 * @author  Nelson Martell (nelson6e65-dev@yahoo.es)
	 * */
	class IntString extends Object implements IEquatable, IComparable {

		function __construct($intValue = 0, $stringValue = '') {
			unset($this->IntValue, $this->StringValue);

			if (is_integer($intValue) or $intValue == NULL) {
				$this->_intValue = $intValue;
			} else {
				//Try convert to integer
				$this->_intValue = (integer) $intValue;
			}

			$this->_stringValue = (string) $stringValue;
		}

		public static function Parse($value) {
			if ($value instanceof IntString) {
				return $value;
			}

			$s = (string) $value;
			$intValue = (int) $s;

			$stringValue = explode($intValue, $s, 2);

			if ($intValue > 0 or $stringValue[1] != '') {
				$stringValue = $stringValue[1];
			} else {
				$stringValue = $stringValue[0];
			}

			return new IntString($intValue, $stringValue);
		}


		protected $_intValue;
		protected $_stringValue;

		public $IntValue;
		public function get_IntValue() {
			return (int) $this->_intValue;
		}

		public $StringValue;
		public function get_StringValue() {
			return $this->_stringValue;
		}

		public function ToString() {
			return $this->IntValue . $this->StringValue;
		}

		public function Equals($other) {
			if ($other instanceof IntString) {
				if ($this->IntValue === $other->IntValue) {
					if ($this->StringValue === $other->StringValue) {
						return true;
					}
				}
			}

			return false;
		}


		#region IComparable

		/**
		 * Determina la posición relativa de esta instancia con respecto al objeto especificado.
		 * Nota: Cualquier objeto que no sea instancia de IntString se considerará menor.
		 *
		 *
		 * @param  IntString|mixed  $other  Objeto con el que se va a comparar.
		 * @return  integer  Cero (0), si esta instancia es igual a $other; mayor a cero (>0),
		 *     si es mayor a $other; menor a cero (<0), si es menor.
		 * */
		public function CompareTo($other) {

			$r = $this->Equals($other) ? 0 : 9999;

			if ($r != 0) {
				if ($other instanceof IntString) {
					$r = $this->IntValue - $other->IntValue;

					if ($r == 0) {
						$r = $this->StringValue < $other->StringValue ? -1 : 1;
					}
				} else {
					$r = 1;
				}
			}

			return $r;
		}

		#endregion

	}
}
