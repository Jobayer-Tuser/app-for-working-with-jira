<?Php 

$curl = curl_init();

$url = 'https://cooldaddycoolmummy.xyz/wp-json/tutor/v1/courses?order=desc&orderby=ID&paged=1';

curl_setopt($curl, CURLOPT_URL, $url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


$response = curl_exec($curl);

if ( $error = curl_error($curl)){
	echo $error;
} else {

		
	$decode = json_decode($response, true);

	// echo "<pre>";
	// print_r($decode['data']['posts'][0]);
	// echo "</pre>";

	$filter = array_filter( $decode['data']['posts'] , function( $data ){
			if ( $data['ID'] == 8767 ) {
				return $data;
			}
			
		});
	echo "<pre>";
	print_r($filter);
	echo "</pre>";
	

	foreach ( $decode['data']['posts'] as $key => $value ) {

		if ( $value['ID'] == 8767 ) {
			echo "<pre>";
			print_r($value['post_title']);
			echo "</pre>";
		}
	}
}

curl_close($curl);