<?php

namespace Skynettechnologies\ContaoSkynetaccessibilityScanner\Controller\BackendModule;

use Contao\BackendModule;
use Contao\BackendUser;

        $user = BackendUser::getInstance();
        $username  = $user->username;
        $useremail = $user->email;

        $websitename   = $_SERVER['HTTP_HOST'];
      
        $arrDetails = [
            'website'        => base64_encode($websitename), // Encode domain
            'platform'       => 'Contao CMS',
            'is_trial_period'=> 1,
            'name'           => $username,
            'email'          => $useremail,
            'comapany_name'  => $websitename,
            'package_type'   => '10-pages'
        ];
        // register user domain on scanning & monitoring dashboard
        $ch = curl_init('https://skynetaccessibilityscan.com/api/register-domain-platform');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrDetails);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);

        // Decode API response
        $jsonStart = strpos($response, '{');
        if ($jsonStart !== false) {
            $jsonPart = substr($response, $jsonStart);
            $result = json_decode($jsonPart, true);
            
        } else {
            echo "Invalid response: " . $response;
        } 

        $encodedWebsite = base64_encode($websitename);

        /* -----------------------------
         GET SCAN DETAIL API
        ----------------------------- */
    
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://skynetaccessibilityscan.com/api/get-scan-detail',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'website' => $encodedWebsite
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            curl_close($curl);
            return;
        }

        curl_close($curl);

        $data = json_decode($response, true);

        /* -----------------------------
         Extract API User Data
        ----------------------------- */
        $apiUserId = $data['userData']['id'] ?? 0;
        $apiName   = $data['userData']['name'] ?? '';
        $apiEmail  = $data['userData']['email'] ?? '';

        /* -----------------------------
         Check email starts with no-reply@
        ----------------------------- */
    
        if (strpos($apiEmail, 'no-reply@') === 0) {
             $users = BackendUser::getInstance();
            $user_name  = $users->username;
            $user_email = $users->email;
        
         
            $payload = json_encode([
                'user_id' => $apiUserId,
                'name'    => $user_name,
                'email'   => $user_email,
            ]);

            $ch = curl_init('https://skynetaccessibilityscan.com/api/update-user');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $payload,
                CURLOPT_HTTPHEADER     => [
                    'Content-Type: application/json',
                    'Accept: application/json'
                ],
                CURLOPT_SSL_VERIFYPEER => false,
            ]);

            $updateResponse = curl_exec($ch);
            curl_close($ch);

           echo 'Update user API: ' . $updateResponse;
        }



class SkynetAccessibilityScannerModule extends BackendModule
{
    protected $strTemplate = 'be_skynet_accessibility';

    protected function compile(): void
    {
     
        $this->Template->title = 'SkynetAccessibility Scanner';

    }
}