<?php
$tahun = date('Y');

$tglstartjanuari = $tahun . '-' . '01' . '-' . '01';
$tglstartfebruari = $tahun . '-' . '02' . '-' . '01';
$tglstartmaret = $tahun . '-' . '03' . '-' . '01';
$tglstartapril = $tahun . '-' . '04' . '-' . '01';
$tglstartmei = $tahun . '-' . '05' . '-' . '01';
$tglstartjuni = $tahun . '-' . '06' . '-' . '01';
$tglstartjuli = $tahun . '-' . '07' . '-' . '01';
$tglstartagustus = $tahun . '-' . '08' . '-' . '01';
$tglstartseptember = $tahun . '-' . '09' . '-' . '01';
$tglstartoktober = $tahun . '-' . '10' . '-' . '01';
$tglstartnovember = $tahun . '-' . '11' . '-' . '01';
$tglstartdesember = $tahun . '-' . '12' . '-' . '01';
$tglastjanuari = new DateTime($tglstartjanuari);
$tglastjanuari->modify('last day of this month');
$tglastfebruari = new DateTime($tglstartfebruari);
$tglastfebruari->modify('last day of this month');
$tglastmaret = new DateTime($tglstartmaret);
$tglastmaret->modify('last day of this month');
$tglastapril = new DateTime($tglstartapril);
$tglastapril->modify('last day of this month');
$tglastmei = new DateTime($tglstartmei);
$tglastmei->modify('last day of this month');
$tglastjuni = new DateTime($tglstartjuni);
$tglastjuni->modify('last day of this month');
$tglastjuli = new DateTime($tglstartjuli);
$tglastjuli->modify('last day of this month');
$tglastagustus = new DateTime($tglstartagustus);
$tglastagustus->modify('last day of this month');
$tglastseptember = new DateTime($tglstartseptember);
$tglastseptember->modify('last day of this month');
$tglastoktober = new DateTime($tglstartoktober);
$tglastoktober->modify('last day of this month');
$tglastnovember = new DateTime($tglstartnovember);
$tglastnovember->modify('last day of this month');
$tglastdesember = new DateTime($tglstartdesember);
$tglastdesember->modify('last day of this month');
echo $tglastjanuari->format('Y-m-d');
echo '<br>';
echo $tglastfebruari->format('Y-m-d');
echo '<br>';
echo $tglastmaret->format('Y-m-d');
echo '<br>';
echo $tglastapril->format('Y-m-d');
echo '<br>';
echo $tglastmei->format('Y-m-d');
echo '<br>';
echo $tglastjuni->format('Y-m-d');
echo '<br>';
echo $tglastjuli->format('Y-m-d');
echo '<br>';
echo $tglastagustus->format('Y-m-d');
echo '<br>';
echo $tglastseptember->format('Y-m-d');
echo '<br>';
echo $tglastoktober->format('Y-m-d');
echo '<br>';
echo $tglastnovember->format('Y-m-d');
echo '<br>';
echo $tglastdesember->format('Y-m-d');

?>