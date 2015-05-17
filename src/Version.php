<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Class definition:  [NelsonMartell]  Version
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

namespace NelsonMartell {
	use \InvalidArgumentException;

	/**
	 * Representa el n�mero de versi�n de un programa o ensamblado, de la forma "1.2.3.4". S�lo
	 * siendo obligatorios el primer y segundo componente.
	 * No se puede heredar esta clase.
	 *
	 *
	 * @author  Nelson Martell (nelson6e65-dev@yahoo.es)
	 * */
	final class Version extends Object implements IEquatable, IComparable {

		/**
		 * Crea una nueva instancia con los n�meros principal, secundario, de compilaci�n (opcional)
		 * y revisi�n (opcional).
		 * Para comprobar si la versi�n es v�lida, usar el m�todo IsValid.
		 *
		 *
		 * @param  int  $major  Componente principal
		 * @param  int  $minor  Componente secundario
		 * @param  int|string|VersionComponent|NULL  $build  Componente de compilaci�n
		 * @param  int|string|VersionComponent|NULL  $revision  Componente de revisi�n
		 * @throw  InvalidArgumentException
		 * */
		function __construct($major, $minor, $build = null, $revision = null) {
			parent::__construct();
			unset($this->Major, $this->Minor, $this->Build, $this->Revision);

			if (!is_integer($major)) {
				throw new InvalidArgumentException(sprintf(dgettext('nml', "Invalid argument type. '%s' (argument %s) must be an instance of '%s', '%s' given. Convert value or use the static method Version::Parse(string|mixed) to create a new instance from an string."), "major", 1, typeof(0), typeof($major)));
			}

			if (!is_integer($minor)) {
				throw new InvalidArgumentException(sprintf(dgettext('nml', "Invalid argument type. '%s' (argument %s) must be an instance of '%s', '%s' given. Convert value or use the static method Version::Parse(string|mixed) to create a new instance from an string."), "minor", 2, typeof(0), typeof($major)));
			}

			if ($major < 0) {
				throw new InvalidArgumentException(sprintf(dgettext('nml', "Invalid argument value. '%s' (argument %s) must be a positive number; '%s' given."), "major", 1, $major));
			}

			if ($minor < 0) {
				throw new InvalidArgumentException(sprintf(dgettext('nml', "Invalid argument value. '%s' (argument %s) must be a positive number; '%s' given."), "minor", 2, $minor));
			}

			$this->_major = $major;
			$this->_minor = $minor;
			$this->_build = VersionComponent::Parse($build);
			$this->_revision = VersionComponent::Parse($revision);
		}

		/**
		 * Convierte una cadena a su representaci�n del tipo Version.
		 *
		 *
		 * @param   string  Cadena a convertir.
		 * @return  Version Objeto convertido desde $value.
		 * */
		public static function Parse($value) {
			if ($value instanceof Version) {
				return $value;
			}

			$version = (string) $value;

			$version = explode('.', $version);

			$c = count($version);

			if ($c > 4 || $c < 2) {
				//var_dump($version);
				throw new InvalidArgumentException(sprintf(dgettext('nml', "Unable to parse. Argument passed has an invalid format: '%s'."), $value));
			}


			$major = (int) $version[0];
			$minor = (int) $version[1];
			$build = null;
			$revision = null;

			if(count($version) >= 3) {
				$build = VersionComponent::Parse($version[2]);

				if(count($version) == 4) {
					$revision = VersionComponent::Parse($version[3]);
				}
			}



			return new Version($major, $minor, $build, $revision);
		}

		/**
		 * Obtiene el valor del componente principal del n�mero de versi�n del objeto actual.
		 * �sta propiedad es de s�lo lectura.
		 *
		 *
		 * @var  int Componente principal del n�mero de versi�n
		 * */
		public $Major;
		private $_major;

		public function get_Major() { return $this->_major; }


		/**
		 * Obtiene el valor del componente secundario del n�mero de versi�n del objeto actual.
		 * �sta propiedad es de s�lo lectura.
		 *
		 *
		 * @var  int Componente secundario del n�mero de versi�n
		 * */
		public $Minor;
		private $_minor;

		public function get_Minor() { return $this->_minor; }

		/**
		 * Obtiene el valor del componente de compilaci�n del n�mero de versi�n del objeto actual.
		 * �sta propiedad es de s�lo lectura.
		 *
		 *
		 * @var  VersionComponent  Componente de compilaci�n del n�mero de versi�n
		 * */
		public $Build;
		private $_build;

		public function get_Build() { return $this->_build; }

		/**
		 * Obtiene el valor del componente de revisi�n del n�mero de versi�n del objeto actual.
		 * �sta propiedad es de s�lo lectura.
		 *
		 *
		 * @var  VersionComponent  Componente de revisi�n del n�mero de versi�n
		 * */
		public $Revision;
		private $_revision;

		public function get_Revision() { return $this->_revision; }


		/**
		 * Convierte la instancia actual en su representaci�n en cadena.
		 * Por defecto, si no est�n definidos los componentes de compilaci�n y revisi�n, no se
		 * incluyen en la salida.
		 * Use el m�todo IsValid si quiere determinar si la versi�n es v�lida antes de devolver esta cadena.
		 *
		 *
		 * @return  string  Representaci�n de la versi�n en forma de cadena: 'major.minor[.build[.revision]]'
		 * @see  VersionComponent::IsNull
		 * @see  Version::IsValid
		 * */
		public function ToString() {
			$s[0] = $this->Major;
			$s[1] = $this->Minor;

			if ($this->Revision->IsNotNull()) {
				$s[2] = $this->Build;
				$s[3] = $this->Revision;
			} else {
				if ($this->Build->IsNotNull()) {
					$s[2] = $this->Build;
				}
			}
			$v = implode('.', $s);

			return $v;
		}

		/**
		 * Indica si la instancia actual es un n�mero de versi�n v�lido.
		 *
		 * Se considera v�lido si:
		 * 1. Major o Minor es mayor a cero (0). No puede ser '0.0'.
		 * 2. Build y Revision son nulos (no est�n definidos).
		 * 3. Build est� definido pero Revision no.
		 * 4. Ambos est�n definidos, pero no poseen la parte de la cadena.
		 * 5. Ambos est�n definidos, pero Build no posee la parte de cadena.
		 * 6. Build est� definido y tiene la cadena, pero Revision no est� definido.
		 * 7. Revision posee cadena, pero Build no.
		 *
		 * @return  boolean  Un valor que indica si la instancia actual es v�lida.
		 * */
		public function IsValid() {
			// Validaci�n de Major y Minor:
			$r = ($this->Major > 0 or $this->Minor > 0); //#1

			// Validaci�n de Build y Revision:
			if ($r) {
				$r = ($this->Build->IsNull() and $this->Revision->IsNull()); // #2

				if (!$r) {
					if ($this->Build->IsNotNull() and $this->Revision->IsNotNull()) { // Si ambos est�n definidos...

						$r = (bool)($this->Build->StringValue == ''); //#5

						if (!$r) {
							$r = (bool)(($this->Build->StringValue == '') and ($this->Revision->StringValue == '')); //#4

							if (!$r) {
								if ($this->Build->StringValue != '') {
									$r = $this->Revision->IsNull(); #6
								}

								if ($this->Revision->StringValue != '') {
									$r = ($this->Build->StringValue == ''); #7
								}
							}
						}
					} else {
						$r = ($this->Build->IsNotNull() and $this->Revision->IsNull()); //#3
					}
				}
			}

			return (bool) $r;
		}

		/**
		 * Determina si el objeto $other especificado es igual a la instancia actual.
		 *
		 *
		 * @return  bool True si $other es igual esta instancia
		 * */
		public function Equals($other) {
			if ($other instanceof Version) {
				if ($this->Major == $other->Major && $this->Minor == $other->Minor) {
					if ($this->Build->Equals($other->Build)) {
						if ($this->Revision->Equals($other->Revision)) {
							return true;
						}
					}
				}
			}

			return false;
		}


		#region IComparable

		/**
		 * Determina la posici�n relativa del objeto especificado con respecto a esta instancia.
		 *
		 *
		 * @param   Version  $other
		 * @return  integer  0, si es igual; >0, si es mayor; <0, si es menor.
		 * */
		public function CompareTo($other){

			$r = $this->Equals($other) ? 0 : 9999;

			if ($r != 0) {
				$r = $this->Major - $other->Major;

				if ($r == 0) {
					$r = $this->Minor - $other->Minor;

					if ($r == 0) {
						$r = $this->Build->CompareTo($other->Build);

						if ($r == 0) {
							$r = $this->Revision->CompareTo($other->Revision);
						}
					}
				}
			}

			return $r;
		}

		#endregion

	}
}