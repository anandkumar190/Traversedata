<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class MyExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = @json_decode(file_get_contents("https://opencontext.org/query/Asia/Turkey/Kenan+Tepe.json"),true);  
        $key="id";
        $result=$this->findValuesByKey($data,$key);
        
        return $result;
    }

    public function view(): View
    {
        $data = @json_decode(file_get_contents("https://opencontext.org/query/Asia/Turkey/Kenan+Tepe.json"),true);  
        $key="id";
        $result=$this->findValuesByKey($data,$key);
        
        return view('exports.my_export', [
            'data' => $result
        ]);
    }

    public function findValuesByKey($obj, $key) {
        $values = array();
        foreach ($obj as $property => $value) {
            if ($property === $key ){
                $value=is_array($value)?@$value['id']:$value;
                if (!empty($value) and is_string($value)) {
                    $values[] = is_array($value)?@$value['id']:$value;
                }
               
            }
            if (is_object($value) || is_array($value)) {
                $values = array_merge($values, $this->findValuesByKey($value, $key));
            }
        }
        return $values;
    }
}
