<?php
/**
 * Generates the normalizer data file for Malayalam.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup MaintenanceLanguage
 */

require_once __DIR__ . '/../Maintenance.php';

/**
 * Generates the normalizer data file for Malayalam.
 * For NFC see includes/libs/normal.
 *
 * @ingroup MaintenanceLanguage
 */
class GenerateNormalizerDataMl extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Generate the normalizer data file for Malayalam';
	}

	public function getDbType() {
		return Maintenance::DB_NONE;
	}

	public function execute() {
		$hexPairs = array(
			# From http://unicode.org/versions/Unicode5.1.0/#Malayalam_Chillu_Characters
			'0D23 0D4D 200D' => '0D7A',
			'0D28 0D4D 200D' => '0D7B',
			'0D30 0D4D 200D' => '0D7C',
			'0D32 0D4D 200D' => '0D7D',
			'0D33 0D4D 200D' => '0D7E',

			# From http://permalink.gmane.org/gmane.science.linguistics.wikipedia.technical/46413
			'0D15 0D4D 200D' => '0D7F',
		);

		$pairs = array();
		foreach ( $hexPairs as $hexSource => $hexDest ) {
			$source = hexSequenceToUtf8( $hexSource );
			$dest = hexSequenceToUtf8( $hexDest );
			$pairs[$source] = $dest;
		}

		global $IP;
		file_put_contents( "$IP/serialized/normalize-ml.ser", serialize( $pairs ) );
		echo "ml: " . count( $pairs ) . " pairs written.\n";
	}
}

$maintClass = 'GenerateNormalizerDataMl';
require_once RUN_MAINTENANCE_IF_MAIN;
