<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SystemSetting;

class InitialSystemSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initial:system_setting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initial System Settings';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $settings_data = [
            ['id' => 1, 'key' => 'site_name', 'data_type' => 'string', 'value' => 'VN Tech', 'is_hidden' => false],
            ['id' => 2, 'key' => 'site_name_sub', 'data_type' => 'string', 'value' => 'VN Tech', 'is_hidden' => false],                        
            ['id' => 3, 'key' => 'site_name_short', 'data_type' => 'string', 'value' => 'VN Tech', 'is_hidden' => false],
            ['id' => 4, 'key' => 'site_name_mobile', 'data_type' => 'string', 'value' => 'VNT', 'is_hidden' => false],
            ['id' => 10, 'key' => 'site_copyright', 'data_type' => 'string', 'value' => 'Copyright © 2017 VN Tech. All rights reserved.', 'is_hidden' => false],
            
            ['id' => 11, 'key' => 'site_is_use_logo', 'data_type' => 'boolean', 'value' => '0', 'is_hidden' => false],
            ['id' => 12, 'key' => 'site_logo', 'data_type' => 'string', 'value' => 'logo.png', 'is_hidden' => false],                    
            ['id' => 13, 'key' => 'site_logo_mobile', 'data_type' => 'string', 'value' => 'logo_mobile.png', 'is_hidden' => false],
            ['id' => 14, 'key' => 'site_favicon', 'data_type' => 'string', 'value' => 'favicon.ico', 'is_hidden' => false],

            ['id' => 201, 'key' => 'company_name', 'data_type' => 'string', 'value' => 'VN Tech', 'is_hidden' => false],
            ['id' => 202, 'key' => 'company_name_full', 'data_type' => 'string', 'value' => '', 'is_hidden' => false],
            ['id' => 203, 'key' => 'company_name_short', 'data_type' => 'string', 'value' => '', 'is_hidden' => false],
            
            ['id' => 211, 'key' => 'company_email', 'data_type' => 'string', 'value' => '', 'is_hidden' => false],
            ['id' => 212, 'key' => 'company_email_2', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],

            ['id' => 221, 'key' => 'company_phone', 'data_type' => 'string', 'value' => '', 'is_hidden' => false],
            ['id' => 222, 'key' => 'company_phone_2', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],

            ['id' => 223, 'key' => 'company_hot_line', 'data_type' => 'string', 'value' => '', 'is_hidden' => false],

            ['id' => 231, 'key' => 'company_address', 'data_type' => 'string', 'value' => '', 'is_hidden' => false],
            ['id' => 232, 'key' => 'company_address_2', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],

            ['id' => 233, 'key' => 'lat', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],
            ['id' => 234, 'key' => 'lng', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],

            ['id' => 301, 'key' => 'social_facebook', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],
            ['id' => 302, 'key' => 'social_twitter', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],
            ['id' => 303, 'key' => 'social_google_plus', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],
            ['id' => 304, 'key' => 'social_instagram', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],
            ['id' => 305, 'key' => 'social_linkedin', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],
            ['id' => 306, 'key' => 'social_pinterest', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],
            ['id' => 307, 'key' => 'social_zalo', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],
            ['id' => 308, 'key' => 'social_viber', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],
            ['id' => 309, 'key' => 'social_tango', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],
            ['id' => 310, 'key' => 'social_wechat', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],
            ['id' => 311, 'key' => 'social_whatapp', 'data_type' => 'string', 'value' => '', 'is_hidden' => true],

            ['id' => 401, 'key' => 'admin_name', 'data_type' => 'string', 'value' => '', 'is_hidden' =>false],
            ['id' => 402, 'key' => 'admin_email', 'data_type' => 'string', 'value' => '', 'is_hidden' =>false],
            ['id' => 403, 'key' => 'admin_phone', 'data_type' => 'string', 'value' => '', 'is_hidden' =>false],
            
            ['id' => 601, 'key' => 'account_mailer', 'data_type' => 'string', 'value' => 'vntech.sendmail@gmail.com', 'is_hidden' => false],
            ['id' => 602, 'key' => 'password_mailer', 'data_type' => 'string', 'value' => 'vntech@123', 'is_hidden' => false],
            ['id' => 603, 'key' => 'driver_mailer', 'data_type' => 'string', 'value' => 'smtp', 'is_hidden' => false],
            ['id' => 604, 'key' => 'host_mailer', 'data_type' => 'string', 'value' => 'smtp.gmail.com', 'is_hidden' => false],
            ['id' => 605, 'key' => 'port_mailer', 'data_type' => 'string', 'value' => '465', 'is_hidden' => false],
            ['id' => 606, 'key' => 'encryption_mailer', 'data_type' => 'string', 'value' => 'ssl', 'is_hidden' => false]         
        ];
        foreach ($settings_data as $item) {            
            try{
                $dataType = $item['data_type'];
                $value = $item['value'];
                $name = ucwords(str_replace('_', ' ', $item['key']));
                $description = isset($item['description']) ? $item['description'] : $name;
                $setting = SystemSetting::create([
                    'id'   => $item['id'],
                    'key' => $item['key'],
                    'data_type' => $dataType,
                    'value' => $value,
                    'is_hidden' => $item['is_hidden'],
                    'name' => $name
                ]);
            }catch(\Exception $e){
                //Ignore error. Insert existed
                echo $e->getMessage(); 
            }
        }
    }
}
