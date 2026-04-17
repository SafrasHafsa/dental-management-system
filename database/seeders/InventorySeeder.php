<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $categories = [
            ['name' => 'Consumables',      'description' => 'Single-use disposable items'],
            ['name' => 'Instruments',       'description' => 'Dental instruments and tools'],
            ['name' => 'Medications',       'description' => 'Drugs, anesthetics, and pharmaceuticals'],
            ['name' => 'Restorative',       'description' => 'Filling, bonding, and restoration materials'],
            ['name' => 'Protective Gear',   'description' => 'PPE and infection control supplies'],
        ];

        foreach ($categories as $cat) {
            DB::table('inventory_categories')->insertOrIgnore(['name' => $cat['name'], 'description' => $cat['description']]);
        }

        $catId = fn(string $name) => DB::table('inventory_categories')->where('name', $name)->value('id');

        // Items
        $items = [
            // Consumables
            ['category' => 'Consumables',    'name' => 'Disposable Gloves (Box)',     'unit' => 'box',   'current' => 20, 'minimum' => 5,  'cost' => 350,  'price' => null],
            ['category' => 'Consumables',    'name' => 'Face Masks (Box of 50)',      'unit' => 'box',   'current' => 15, 'minimum' => 3,  'cost' => 280,  'price' => null],
            ['category' => 'Consumables',    'name' => 'Dental Bibs / Napkins',       'unit' => 'pack',  'current' => 30, 'minimum' => 5,  'cost' => 120,  'price' => null],
            ['category' => 'Consumables',    'name' => 'Cotton Rolls',                'unit' => 'bag',   'current' => 25, 'minimum' => 5,  'cost' => 90,   'price' => null],
            ['category' => 'Consumables',    'name' => 'Gauze Pads',                  'unit' => 'pack',  'current' => 20, 'minimum' => 5,  'cost' => 150,  'price' => null],
            ['category' => 'Consumables',    'name' => 'Saliva Ejectors',             'unit' => 'bag',   'current' => 10, 'minimum' => 3,  'cost' => 180,  'price' => null],
            ['category' => 'Consumables',    'name' => 'Suction Tips',                'unit' => 'bag',   'current' => 8,  'minimum' => 2,  'cost' => 200,  'price' => null],
            ['category' => 'Consumables',    'name' => 'Disposable Syringes (3ml)',   'unit' => 'box',   'current' => 12, 'minimum' => 3,  'cost' => 220,  'price' => null],

            // Protective Gear
            ['category' => 'Protective Gear','name' => 'Protective Eyewear',          'unit' => 'pcs',   'current' => 6,  'minimum' => 2,  'cost' => 450,  'price' => null],
            ['category' => 'Protective Gear','name' => 'Disposable Aprons',           'unit' => 'roll',  'current' => 4,  'minimum' => 1,  'cost' => 300,  'price' => null],
            ['category' => 'Protective Gear','name' => 'Hand Sanitizer (500ml)',      'unit' => 'bottle','current' => 10, 'minimum' => 3,  'cost' => 250,  'price' => null],
            ['category' => 'Protective Gear','name' => 'Disinfectant Spray (1L)',     'unit' => 'bottle','current' => 8,  'minimum' => 2,  'cost' => 400,  'price' => null],

            // Instruments
            ['category' => 'Instruments',    'name' => 'Dental Explorer',             'unit' => 'pcs',   'current' => 10, 'minimum' => 3,  'cost' => 800,  'price' => null],
            ['category' => 'Instruments',    'name' => 'Dental Mirror',               'unit' => 'pcs',   'current' => 10, 'minimum' => 3,  'cost' => 600,  'price' => null],
            ['category' => 'Instruments',    'name' => 'Tweezers / Cotton Pliers',   'unit' => 'pcs',   'current' => 8,  'minimum' => 2,  'cost' => 700,  'price' => null],
            ['category' => 'Instruments',    'name' => 'Excavator Spoon',             'unit' => 'pcs',   'current' => 6,  'minimum' => 2,  'cost' => 900,  'price' => null],
            ['category' => 'Instruments',    'name' => 'Dental Scaler',               'unit' => 'pcs',   'current' => 5,  'minimum' => 2,  'cost' => 1200, 'price' => null],

            // Medications
            ['category' => 'Medications',    'name' => 'Lidocaine 2% Cartridges',    'unit' => 'box',   'current' => 10, 'minimum' => 3,  'cost' => 1500, 'price' => null],
            ['category' => 'Medications',    'name' => 'Eugenol',                     'unit' => 'bottle','current' => 5,  'minimum' => 2,  'cost' => 850,  'price' => null],
            ['category' => 'Medications',    'name' => 'Hydrogen Peroxide 3%',        'unit' => 'bottle','current' => 6,  'minimum' => 2,  'cost' => 200,  'price' => null],
            ['category' => 'Medications',    'name' => 'Chlorhexidine Mouthwash',     'unit' => 'bottle','current' => 8,  'minimum' => 2,  'cost' => 350,  'price' => 500],
            ['category' => 'Medications',    'name' => 'Fluoride Gel',                'unit' => 'tube',  'current' => 10, 'minimum' => 3,  'cost' => 400,  'price' => 600],

            // Restorative
            ['category' => 'Restorative',    'name' => 'Composite Resin (Syringe)',  'unit' => 'pcs',   'current' => 8,  'minimum' => 2,  'cost' => 2500, 'price' => null],
            ['category' => 'Restorative',    'name' => 'Glass Ionomer Cement',        'unit' => 'pack',  'current' => 6,  'minimum' => 2,  'cost' => 1800, 'price' => null],
            ['category' => 'Restorative',    'name' => 'Dental Bonding Agent',        'unit' => 'bottle','current' => 5,  'minimum' => 2,  'cost' => 2200, 'price' => null],
            ['category' => 'Restorative',    'name' => 'Zinc Oxide Powder',           'unit' => 'bottle','current' => 4,  'minimum' => 1,  'cost' => 600,  'price' => null],
            ['category' => 'Restorative',    'name' => 'Articulating Paper',          'unit' => 'box',   'current' => 10, 'minimum' => 2,  'cost' => 300,  'price' => null],
        ];

        $now = now();
        foreach ($items as $item) {
            $catIdValue = $catId($item['category']);
            $sku = strtoupper(Str::slug($item['name'], '-'));
            $sku = substr($sku, 0, 20);

            DB::table('inventory_items')->insertOrIgnore([
                'id'            => Str::ulid(),
                'category_id'   => $catIdValue,
                'supplier_id'   => null,
                'sku'           => $sku,
                'name'          => $item['name'],
                'unit'          => $item['unit'],
                'current_stock' => $item['current'],
                'minimum_stock' => $item['minimum'],
                'unit_cost'     => $item['cost'],
                'selling_price' => $item['price'],
                'is_active'     => true,
                'is_sellable'   => $item['price'] !== null,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }
    }
}
