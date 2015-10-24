--TEST--
bool openssl_csr_export_to_file ( resource $csr , string $outfilename [, bool $notext = true ] );
--CREDITS--
marcosptf - <marcosptf@yahoo.com.br>
--SKIPIF--
<?php 
if (!extension_loaded("openssl")) print "skip";
if (OPENSSL_VERSION_NUMBER < 0x10000000) die("skip Output requires OpenSSL 1.0");
?>
--FILE--
<?php
$config = __DIR__ . DIRECTORY_SEPARATOR . 'openssl.cnf';
$config_arg = array('config' => $config);
$crsExportedFileNoTextTrue = __DIR__ . DIRECTORY_SEPARATOR . "crs-exported-file-notext-true.crs";
$crsExportedFileNoTextFalse = __DIR__ . DIRECTORY_SEPARATOR . "crs-exported-file-notext-false.crs";

$dn = array(
    "countryName" => "BR",
    "stateOrProvinceName" => "Rio Grande do Sul",
    "localityName" => "Porto Alegre",
    "commonName" => "Marcosptf",
    "emailAddress" => "marcosptf@yahoo.com.br"
);

$args = array(
    "digest_alg" => "sha1",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_DSA,
    "encrypt_key" => true,
    "config" => $config
);

$privkey = openssl_pkey_new($config_arg);
$csr = openssl_csr_new($dn, $privkey, $args);

if (openssl_csr_export_to_file($csr, $crsExportedFileNoTextTrue, true)){

    if (openssl_csr_export_to_file($csr, $crsExportedFileNoTextFalse, false)){
    
        if ((file_exists($crsExportedFileNoTextTrue)) && (file_exists($crsExportedFileNoTextFalse))) {
            print("okey");
            
        } else {
            print("export to csr file has failed on create file");    
            
        }
        
    } else {
        print("export to csr with human readable file has failed");    
        
    }

}else{
    print("export to csr file has failed");    
    
}
?>
--EXPECT--
okey
