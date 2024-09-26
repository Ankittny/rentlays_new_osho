<?php

namespace Modules\Gateway\Database\Seeders;

use Illuminate\Database\Seeder;

class GatewaysTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('gateways')->delete();

        \DB::table('gateways')->insert(array(
            0 =>
            array(
                'id' => 1,
                'alias' => 'paypal',
                'name' => 'Paypal',
                'sandbox' => 1,
                'data' => '{"secretKey":"ECsq6hLG6I6AZgvkVK2tXjFktn2MW8Jm9UiZA89_omBByLwJKmHA-O2CkeJv4yeap-89SlEP336SWC5h","clientId":"AZeutAJKxyK2yU30ElSOestOrJz48UUtyGFByWl1AbspfkOYcdq8Yf1sMlcqOZioBkekTQEC0M-4z2Iv","instruction":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.","status":"1","sandbox":"1"}',
                'instruction' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image' => 'thumbnail.png',
                'status' => 1,
            ),
            1 =>
            array(
                'id' => 2,
                'alias' => 'stripe',
                'name' => 'Stripe',
                'sandbox' => 1,
                'data' => '{"clientSecret":"sk_test_UWTgGYIdj8igmbVMgTi0ILPm","publishableKey":"pk_test_c2TDWXsjPkimdM8PIltO6d8H","instruction":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.","status":"1","sandbox":"1"}',
                'instruction' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image' => 'thumbnail.png',
                'status' => 1,
            ),
            2 =>
            array(
                'id' => 4,
                'alias' => 'directbanktransfer',
                'name' => 'DirectBankTransfer',
                'sandbox' => 1,
                'data' => '{"name":"DirectBankTransfer","account_name":"John Doe","iban":"6667 77637 32432","swift_code":"Test123","routing_no":"Test123","bank_name":"HSBC","branch_name":"Chicago","branch_city":"Chicago","branch_address":"123, Shicago , USA","country":"USA","logo":"hsbc.png","status":"1","instruction":"Make your payment directly into our bank account. please upload necessary attachment to verify the transaction. the admin will approve the transaction if it valid"}',
                'instruction' => 'Make your payment directly into our bank account. please upload necessary attachment to verify the transaction. the admin will approve the transaction if it valid.',
                'image' => 'thumbnail.png',
                'status' => 1,
            ),
            3 =>
            array(
                'id' => 5,
                'alias' => 'flutterwave',
                'name' => 'Flutterwave',
                'sandbox' => 1,
                'data' => '{"secretKey":"FLWSECK_TEST-916f34c844284b80a161639d9c91e97a-X","publicKey":"FLWPUBK_TEST-e0ea855b8e3342068bfb11ef4ea0c0f5-X","encryptionKey":"FLWSECK_TESTd587420f66c1","instruction":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua","status":"1"}',
                'instruction' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'image' => 'thumbnail.png',
                'status' => 1,
            ),
            
            4 =>
            array(
                'id' => 6,
                'alias' => 'paystack',
                'name' => 'Paystack',
                'sandbox' => 1,
                'data' => '{"secretKey":"sk_test_6ccdf0a7fff95c5edb111d1702cf0b4b9787952a","publicKey":"pk_test_10c26a1cfde23c76701cba105aa8ae1101112236","instruction":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.","status":"1","sandbox":"1"}',
                'instruction' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image' => 'thumbnail.png',
                'status' => 1,
            ),
           
            
            
        ));
    }
}
