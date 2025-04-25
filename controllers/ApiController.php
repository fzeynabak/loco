<?php
class ApiController {
    private $data;
    
    public function __construct() {
        $json = file_get_contents(ROOT_PATH . '/data/iran-cities.json');
        $this->data = json_decode($json, true);
    }
    
    public function getProvinces() {
        header('Content-Type: application/json');
        $provinces = [];
        foreach ($this->data as $province) {
            $provinces[] = [
                'id' => $province['id'],
                'name' => $province['name']
            ];
        }
        echo json_encode($provinces);
    }
    
    public function getCities($provinceId) {
        header('Content-Type: application/json');
        $cities = [];
        foreach ($this->data as $province) {
            if ($province['id'] == $provinceId) {
                foreach ($province['cities'] as $city) {
                    $cities[] = [
                        'id' => $city['id'],
                        'name' => $city['name']
                    ];
                }
                break;
            }
        }
        echo json_encode($cities);
    }

    public function getStations($cityId) {
        // این متد رو باید با دیتای واقعی ایستگاه‌های راه‌آهن پر کنید
        header('Content-Type: application/json');
        // فعلاً یک نمونه برمی‌گردونیم
        $stations = [
            ['id' => 1, 'name' => 'ایستگاه راه‌آهن تهران'],
            ['id' => 2, 'name' => 'ایستگاه راه‌آهن جنوب']
        ];
        echo json_encode($stations);
    }
}