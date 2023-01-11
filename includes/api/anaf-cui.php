<?php
add_action( 'rest_api_init', 'get_cui_data_route_test' );
add_action( 'wp_enqueue_scripts', 'enqueue_scripts_anaf' );

function get_cui_data_route_test() {
    register_rest_route('anaf', 'cui', [
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => 'company_data',
        'permission_callback' => '__return_true',
    ]);
}

function company_data( WP_REST_Request $request ) {
    if ( ! wp_verify_nonce( $request->get_header( 'X-WP-Nonce' ), 'wp_rest' )  ) {
        return new WP_REST_Response( [ 'message' => __( 'The nonce is invalid.', 'send-data' ) ] );
    }
    static $lastRequest;
    $maxRequestsPerMin = 20;
    if (isset($lastRequest)) {
        $delay = 60 / $maxRequestsPerMin; // 60 seconds / $maxRequestsPerMin
        if ((microtime(true) - $lastRequest) < $delay) {
            // Sleep until the delay is reached
            $sleepAmount = ($delay - microtime(true) + $lastRequest) * (1000 ** 2);
            usleep($sleepAmount);
        }
    }
    $lastRequest = microtime(true);

    $cui = $_GET['cui'];
    $data = date("Y-m-d");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://webservicesp.anaf.ro/PlatitorTvaRest/api/v7/ws/tva',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'[
                                        {
                                            "cui": "'.$cui.'", "data": "'.$data.'"
                                        }
                                    ]',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $request = curl_exec($curl);
        curl_close($curl);
        $rsp = json_decode($request);
        if(empty($rsp->found)){
            return new WP_REST_Response(false);
        }else{
            $datefirma = [
                'nume' => $rsp->found[0]->date_generale->denumire,
                'reg_com' => $rsp->found[0]->date_generale->nrRegCom,
                'telefon' => $rsp->found[0]->date_generale->telefon,
                'strada' => $rsp->found[0]->adresa_sediu_social->sdenumire_Strada,
                'numar' => $rsp->found[0]->adresa_sediu_social->snumar_Strada,
                'cod_postal' => $rsp->found[0]->adresa_sediu_social->scod_Postal,
            ];
            return new WP_REST_Response($datefirma);
        }
}
function enqueue_scripts_anaf() {
    if (is_checkout()) {
        $url = plugins_url('/date-cif-anaf');
        $args = [
            'rest_api_url' => get_rest_url(null, 'anaf/'),
            'homepage' => home_url(),
            'nonce' => wp_create_nonce('wp_rest'),
        ];
        wp_register_script('send-cif-form', $url . '/public/js/date-cif-anaf-public.js', [], '1.0.0', true);
        wp_localize_script('send-cif-form', 'anafcui_object', $args);
        wp_enqueue_script('send-cif-form');

    }
}