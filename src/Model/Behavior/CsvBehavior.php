<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;

/**
 * Csv behavior
 */
class CsvBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     * @access protected
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $_defaultConfig = [
        'length' => 0,
        'delimiter' => ',',
        'enclosure' => '"',
        'escape' => '\\',
        'headers' => true,
        'text' => false,
        'excel_bom' => false,
    ];

    /**
     * Import public function
     *
     * @param string $content filename or path to the file under webroot
     * @param array $fields to import
     * @param array $options to set
     * @param bool $mapping Return field Headers
     * @return array|false of all data from the csv file in [Model][field] format
     * @author Dean Sofer
     */
    public function importCsv(
        string $content,
        array $fields = [],
        array $options = [],
        bool $mapping = false
    ): array|false {
        $config = $this->getConfig();
        $options = array_merge($config, $options);

        if (!$this->eventTrigger('beforeImportCsv', [$content, $fields, $options])) {
            return false;
        }

        if ($options['text']) {
            // store the content to a file and reset
            $file = fopen('php://memory', 'rw');
            fwrite($file, $content);
            fseek($file, 0);
        } else {
            $file = fopen($content, 'r');
        }

        // open the file
        if ($file) {
            $data = [];

            if (empty($fields)) {
                // read the 1st row as headings
                $fields = fgetcsv($file, $options['length'], $options['delimiter'], $options['enclosure']);
                $original = $fields;
                foreach ($fields as $key => $field) {
                    $field = strtolower(trim(preg_replace('/[^_.a-zA-Z0-9]/', '', Inflector::underscore($field))));
                    $field = str_replace('__', '_', $field);
                    if (empty($field)) {
                        continue;
                    }
                    $fields[$key] = $field;
                }
            } elseif ($options['headers']) {
                fgetcsv($file, $options['length'], $options['delimiter'], $options['enclosure']);
            }

            // Row counter
            $rowCount = 0;
            // read each data row in the file
            $alias = $this->_table->getAlias();
            while ($row = fgetcsv($file, $options['length'], $options['delimiter'], $options['enclosure'])) {
                if ($mapping && $rowCount >= 1) {
                    return compact('fields', 'original', 'data');
                }

                // for each header field
                foreach ($fields as $f => $field) {
                    if (!isset($row[$f])) {
                        $row[$f] = null;
                    }
                    $row[$f] = trim($row[$f]);
                    // get the data field from Model.field
                    if (strpos($field, '.')) {
                        $keys = explode('.', $field);
                        if ($keys[0] == $alias) {
                            $field = $keys[1];
                        }
                        if (!isset($data[$rowCount])) {
                            $data[$rowCount] = [];
                        }
                        $data[$rowCount] = Hash::insert($data[$rowCount], $field, $row[$f]);
                    } else {
                        $data[$rowCount][$field] = $row[$f];
                    }
                }
                $rowCount++;
            }

            // close the file
            fclose($file);

            $this->eventTrigger('afterImportCsv', [$data]);

            // return the messages
            return $data;
        } else {
            return false;
        }
    }

    /**
     * Converts a data array into
     *
     * @param string $filename to export to
     * @param array<\App\Model\Behavior\Entity> $data to export
     * @param array $options Options Configuration
     * @return int|false
     * @author Dean
     */
    public function exportCsv(string $filename, array $data, array $options = []): int|false
    {
        $config = $this->getConfig();
        $options = array_merge($config, $options);

        if (!$this->eventTrigger('beforeExportCsv', [$filename, $data, $options])) {
            return false;
        }

        // open the file
        $file = fopen($filename, 'w');

        if ($file) {
            // Add BOM for proper display UTF-8 in EXCEL
            if ($options['excel_bom']) {
                fputs($file, chr(239) . chr(187) . chr(191));
            }
            // Iterate through and format data
            $firstRecord = true;
            foreach ($data as $record) {
                $record = $record->toArray();
                $row = [];
                foreach ($record as $field => $value) {
                    if (!is_array($value)) {
                        $row[] = $value;
                        if ($firstRecord) {
                            $headers[] = $field;
                        }
                        continue;
                    }
                    $table = $field;
                    $fields = $value;
                    foreach ($fields as $columnIndex => $columnName) {
                        if (!is_array($columnName)) {
                            if ($firstRecord) {
                                $headers[] = $table . '.' . $columnIndex;
                            }
                            $row[] = $columnName;
                        }
                    }
                }
                $rows[] = $row;
                $firstRecord = false;
            }

            if ($options['headers']) {
                // write the 1st row as headings
                fputcsv($file, $headers, $options['delimiter'], $options['enclosure']);
            }
            // Row counter
            $rowCount = 0;
            foreach ($rows as $row) {
                fputcsv($file, $row, $options['delimiter'], $options['enclosure']);
                $rowCount++;
            }

            // close the file
            fclose($file);

            $this->eventTrigger('afterExportCsv', []);

            return $rowCount;
        } else {
            return false;
        }
    }

    /**
     * @param string $callback Event Callback Name
     * @param array $parameters Parameters for Callback Event
     * @return bool
     */
    protected function eventTrigger(string $callback, array $parameters): bool
    {
        if (method_exists($this->_table, $callback)) {
            return call_user_func_array([$this->_table, $callback], $parameters);
        } else {
            return true;
        }
    }
}
