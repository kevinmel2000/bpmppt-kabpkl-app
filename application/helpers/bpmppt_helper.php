<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Bpmppt Helper
 * @category    Helpers
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
    foreach (array('skpd_name', 'skpd_city', 'skpd_lead_name', 'skpd_lead_jabatan', 'skpd_lead_nip') as $property)
    {
        $$property = Bootigniter::get_setting($property);
    }

    $atas_nama || $atas_nama = 'BUPATI PEKALONGAN';
    $output = 'A.n. '.$atas_nama.'<br>'
            . word_wrap('KEPALA '.strtoupper($skpd_name), 32)
            . ''.strtoupper($skpd_city).'<br><br><br>'
            . '<span class="underline">'.strtoupper($skpd_lead_name).'</span><br>'
            . ''.strtoupper($skpd_lead_jabatan).'<br>'
            . 'NIP. '.strtoupper($skpd_lead_nip).'';

    echo $output;
}

function print_cop()
{
    foreach (array('skpd_logo', 'skpd_name', 'skpd_address', 'skpd_telp', 'skpd_city', 'skpd_pos', 'skpd_email') as $property)
    {
        $$property = Bootigniter::get_setting($property);
    }

    $img_logo = img( array(
        'src'   =>  $skpd_logo,
        'alt'   => 'Logo cetak',
        'class' => 'img logo-skpd',
        'width' => '60',
        'style' => 'position:absolute; left:5px;'));

    $output = '<p class="align-center bold" style="margin-top: 5px; margin-left: 60px; line-height: 1.5em;">'
            . 'PEMERINTAH KABUPATEN PEKALONGAN<br>'
            . '<span style="font-size: 16px; line-height:1.4em;">'.strtoupper($skpd_name).'</span><br>'
            . '<span style="font-size: 12px; line-height:1.4em;">'.$skpd_address.' '.$skpd_city.', Kode Pos '.$skpd_pos.'</span><br>'
            . '<span style="font-size: 12px; line-height:1.4em;">Telepon./Faksimile : '.$skpd_telp.' e-mail : '.$skpd_email.'</span>'
            . '</p>';

    return $img_logo.$output;
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

function iplc_debits($debits = array())
{
    if (empty($debits)) return;

    $html = '<table class="bordered"><thead><tr>'
          . '<th>NO</th>';

    foreach ($debits['head'] as $debit_head)
    {
        $html .= '<th>'.$debit_head.'</th>';
    }

    $html .= '</tr></thead><tbody>';

    foreach ($debits['body'] as $i => $debit_data)
    {
        $html .= '<tr><td>'.($i + 1).'</td>';

        foreach (array_keys($debits['head']) as $debit_key)
        {
            $html .= '<td>'.($debit_data[$debit_key] ?: '-').'</td>';
        }

        $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    return $html;
}
