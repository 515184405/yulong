<?php
return [
    'adminEmail' => 'admin@example.com',
    // TOKEN验证参数
    'auth'	=>	[
        //KEY值(MD5加密/可自定义)
        'key'	=>	'f1e358c80759c68a37394c18755ba7de',
        //密钥(可自定义)
        'secret' =>	'photolive19930313',
        //有效期,单位为s。此处设置为12小时(可自定义)!!!时间不宜过长
        'timeout'	=>	'3600 * 12'
    ]

];
