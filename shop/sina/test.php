<?php
include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , '2.00AQgaXD0G4Vgrfe481a8840pYC9aC' );

$uid = '2391144757';
$user_message = $c->show_user_by_id($uid);
print_r($user_message);
