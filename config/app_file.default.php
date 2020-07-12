<?php

use Aws\Sdk;

$sharedConfig = [
    'region' => 'your-region-here',
    'version' => 'latest',
];
$sdk = new Sdk($sharedConfig);
$client = $sdk->createS3();

return [
    'Filesystem' => [
        'default' => [
            'adapter' => '\League\Flysystem\AwsS3v3\AwsS3Adapter',
            'adapterArguments' => [
                $client,
                '<<S3_BUCKET_NAME>>',
            ],
            'normalizer' => [
                'hashingAlgo' => 'sha1',
            ],
            'entityClass' => 'App\Model\Entity\DocumentEdition',
        ],
        'local' => [
            'adapter' => 'Local',
            'adapterArguments' => [ WWW_ROOT . 'files' ],
            'entityClass' => 'App\Model\Entity\DocumentEdition',
        ],
        'cache' => [
            'adapter' => 'Local',
            'adapterArguments' => [ WWW_ROOT . 'cached' ],
        ],
    ],
];
