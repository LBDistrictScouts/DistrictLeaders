<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

/**
 * Class IconHelper
 *
 * @package App\View\Helper
 */
class JobHelper extends Helper
{
    protected $resultKeys = [
        'records' => 'Parsed Compass Records',
        'email_send_id' => 'Email Send ID',
        'domainsCount' => 'Synced Domains',
        'usersCount' => 'Synced Directory Users',
        'groupsCount' => 'Synced Directory Groups',
    ];

    protected $inputKeys = [
        'version' => 'Document Version',
        'directory' => 'Directory',
        'email_generation_code' => 'Email Generation Code',
    ];

    protected $linkKeys = [
        'version' => '/document-versions/view/{0}',
        'directory' => '/directories/view/{0}',
        'email_send_id' => '/email-sends/view/{0}',
    ];

    /**
     * @param array $rowData Data to be Row Formatted
     * @return string
     */
    private function rowFormat(array $rowData): string
    {
        $string = '<tr>';

        foreach ($rowData as $rowDatum => $link) {
            $string .= $this->cellFormat($rowDatum, $link);
        }

        $string .= '</tr>';

        return $string;
    }

    /**
     * @param string|int $value The value for formatting
     * @param string|null $link The Link for passing
     * @return string
     */
    private function cellFormat($value, ?string $link = null): string
    {
        if (!empty($link) && is_numeric($value)) {
            return '<td><a href="' . __($link, $value) . '" >' . (string)$value . '</a></td>';
        }

        return '<td>' . (string)$value . '</td>';
    }

    /**
     * @param array $labelKeys The Label Key Set being processed
     * @param array $data Data for Printing
     * @param string|null $header The Table Header Label
     * @return string
     */
    public function tableFormat(array $labelKeys, array $data, ?string $header = 'Input'): string
    {
        $table = [];

        foreach ($labelKeys as $key => $label) {
            if (key_exists($key, $data)) {
                if (key_exists($key, $this->linkKeys)) {
                    array_push($table, $this->rowFormat([$label => null, $data[$key] => $this->linkKeys[$key]]));
                } else {
                    array_push($table, $this->rowFormat([$label => null, $data[$key] => null]));
                }
            }
        }

        if (empty($table)) {
            return '';
        }

        $string = '<div class="table-responsive table-hover">';
        $string .= '<table class="table table-hover">';
        $string .= '<thead><tr><th scope="col">' . $header . '</th><th scope="col">Value</th></tr></thead>';
        $string .= '<tbody>';

        foreach ($table as $row) {
            $string .= $row;
        }

        $string .= '</tbody>';
        $string .= '</table>';

        return $string . '</div>';
    }

    /**
     * @param string $jobData The Job data to be parsed
     * @return string
     */
    public function jobData(string $jobData): string
    {
        $data = unserialize($jobData);
        if (!is_array($data)) {
            return '';
        }
        $string = '';

        $string .= $this->tableFormat($this->inputKeys, $data);
        $string .= $this->tableFormat($this->resultKeys, $data, 'Output');

        return $string;
    }
}
