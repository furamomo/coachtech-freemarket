<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Item;

class CategoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryMap = Category::pluck('id', 'name');
        
        $itemCategoryMap = [
            '腕時計' => ['ファッション', 'メンズ'],
            'HDD' => ['家電'],
            '玉ねぎ3束' => ['キッチン'],
            '革靴' => ['ファッション', 'メンズ'],
            'ノートPC' => ['家電'],
            'マイク' => ['家電'],
            'ショルダーバッグ' => ['ファッション', 'レディース'],
            'タンブラー' => ['キッチン'],
            'コーヒーミル' => ['キッチン'],
            'メイクセット' => ['コスメ', 'レディース'],
        ];

        foreach ($itemCategoryMap as $itemName => $categoryNames) {
            $item = Item::where('name', $itemName)->first();

            if (!$item) {
                continue;
            }

            $categoryIds = collect($categoryNames)
                ->map(fn($name) => $categoryMap[$name] ?? null)
                ->filter()
                ->values()
                ->toArray();

            $item->categories()->sync($categoryIds);
        }
    }
}
