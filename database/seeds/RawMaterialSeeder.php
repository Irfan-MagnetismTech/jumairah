<?php

use Illuminate\Database\Seeder;

class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rawMaterials = [
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'SN-500', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'BS-150', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'HCO', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'12 HAS', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'L.HO', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'GC-33', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'HY-23', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'PP', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'EVA', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'SPO', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'LDEP', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'Olic Acid', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'Lime', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'Taki F', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'Stearik Acid', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'Arosil-200 (Fume Silica)', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'RPO', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'ALU. Stearic', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'Colour', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'VM', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'Petty Acid', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'C/Gr', 'min_quantity' =>1],
            ['apsection_id'=>1,'category_id'=>2,'unit_id'=>1,'name'=>'N-600', 'min_quantity' =>1],

            ['apsection_id'=>2,'category_id'=>2,'unit_id'=>1,'name'=>'BS-150', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>2,'unit_id'=>1,'name'=>'DEG', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>2,'unit_id'=>1,'name'=>'MEG', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>2,'unit_id'=>1,'name'=>'N-150 (G-II)', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>2,'unit_id'=>1,'name'=>'N-500/600 (G-II)', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>2,'unit_id'=>1,'name'=>'N-70 (G-II)', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>2,'unit_id'=>1,'name'=>'PEG', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>2,'unit_id'=>1,'name'=>'PS-02 (G-II)', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>2,'unit_id'=>1,'name'=>'SN-150 (G-I)', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>2,'unit_id'=>1,'name'=>'SN-500 (G-I)', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>2,'unit_id'=>1,'name'=>'TEG', 'min_quantity' =>1],

            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'AFM-002', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'AHY-527', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'AR-55', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'ATF-45', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'BE-71', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'CF-14', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'CF-19', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'CF-25', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'CF-45', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'CH-33', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'CI-22', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'CI-51', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'CI-57 B', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'Colour', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'ETRO-4+', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'ETRO-6+', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'F-23', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'Flavour', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'GC-33', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'HY-23', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'HY-43', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'MA-4T', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'P-55', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'PR-1046', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'SL-80', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'SL-93', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'SN-10', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'SN-60', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'SN-90', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'TBN-40', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'VI-54', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'VI-61', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'VII-25', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'VM(SPO)-25', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>1,'unit_id'=>1,'name'=>'VM-25', 'min_quantity' =>1],

            ['apsection_id'=>2,'category_id'=>3,'unit_id'=>3,'name'=>'Can (Plastic)', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>3,'unit_id'=>3,'name'=>'Can (Metal)', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>3,'unit_id'=>3,'name'=>'Pail (Plastic)', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>3,'unit_id'=>3,'name'=>'Pail (Metal)', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>3,'unit_id'=>3,'name'=>'Drum', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>3,'unit_id'=>3,'name'=>'Drum (Steel)', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>3,'unit_id'=>3,'name'=>'Sticker', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>3,'unit_id'=>3,'name'=>'Carton', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>3,'unit_id'=>3,'name'=>'Gum Tape', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>3,'unit_id'=>3,'name'=>'Flil', 'min_quantity' =>1],

            ['apsection_id'=>2,'category_id'=>4,'unit_id'=>1,'name'=>'Flavour', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>4,'unit_id'=>1,'name'=>'Colour', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>4,'unit_id'=>2,'name'=>'Solvent & Cleaner', 'min_quantity' =>1],
            ['apsection_id'=>2,'category_id'=>4,'unit_id'=>2,'name'=>'Ink', 'min_quantity' =>1],


        ];
        foreach ($rawMaterials as $rawMaterial){
            \App\Material::create($rawMaterial);
        }
    }
}
