<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT
 * @subpackage  Bpmppt Helper
 * @category    Helpers
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) BPMPPT Kab. Pekalongan
 * @license     http://github.com/feryardiant/bpmppt/blob/master/LICENSE
 * @since       Version 0.1.5
 */

// -----------------------------------------------------------------------------

function print_tembusan($data_tembusan)
{
    $output = '';

    if (strlen($data_tembusan) > 0)
    {
        $data_tembusan = unserialize($data_tembusan);
        $output .= '<p>Tembusan :</p><ol>';

        $i = 0;
        $c = count($data_tembusan);

        foreach ($data_tembusan as $tembusan)
        {
            $output .= '<li>'.$tembusan.($i < ($c - 1) ? ';' : '.').'</li>';
            $i++;
        }

        $output .= '</ol>';
    }

    echo $output;
}

function print_ttd_kadin($atas_nama = '')
{
    $properties = array( 'skpd_name', 'skpd_city', 'skpd_lead_name', 'skpd_lead_jabatan', 'skpd_lead_nip' );
    $atas_nama || $atas_nama = 'BUPATI PEKALONGAN';

    foreach ($properties as $property)
    {
        $$property = get_setting($property);
    }

    $output = 'A.n. '.$atas_nama.'<br>'
            . word_wrap('KEPALA '.strtoupper($skpd_name), 32)
            . ''.strtoupper($skpd_city).'<br><br><br>'
            . '<span class="underline">'.strtoupper($skpd_lead_name).'</span><br>'
            . ''.strtoupper($skpd_lead_jabatan).'<br>'
            . 'NIP. '.strtoupper($skpd_lead_nip).'';

    echo $output;
}

function print_blnthn_head($str_date)
{
    return strtoupper(format_roman(bdate('%m', $str_date)).' / '.bdate('%Y', $str_date));
}

function print_blnthn_foot($str_date, $nbsp = null)
{
    $nbsp || $nbsp = 6;
    echo nbs($nbsp).bdate('%F %Y', $str_date);
}
