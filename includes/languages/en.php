<?php
function lang($phrase)
{
    static $lang = array(
        'homePage'    =>  'HomePage',
        'manage'    =>  'Manage',
        'historyPage'    =>  'HistoryPage',




    );
    return $lang[$phrase];
}
