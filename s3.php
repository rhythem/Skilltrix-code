<?php

	
	require 'vendor/autoload.php';

	use Aws\S3\S3Client;
	use Aws\Common\Enum\Region;
	use Guzzle\Http\EntityBody;
	use Aws\S3\Enum\CannedAcl;
		$config = array(
			'key' => 'AKIAIIBXKICL64PBEZ5Q',
			'secret' => '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',
			'region' => Region::US_EAST_1
		);
	
$s3 = S3Client::factory($config);
$bucketname = 'st_resource';  //must be all lowercase
$filename = 'default.png'; //my image on my server
$path = 'photo/profile/'; //the physical path where the image is located
$fullfilename = $path.$filename;

$s3->putObject(array(
        'Bucket' => $bucketname,
        'Key'    => 'profile/'.$filename, 
        'Body'   => EntityBody::factory(fopen($fullfilename, 'r')),
        'ACL'    => CannedAcl::PUBLIC_READ_WRITE,
        'ContentType' => 'image/jpeg'
));
?>
<img src="https://s3.amazonaws.com/<?php echo $bucketname;?>/profile/<?php echo $filename;?>">